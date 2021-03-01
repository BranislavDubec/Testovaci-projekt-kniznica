<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\Responses\JsonResponse;
use Nette\Utils\Arrays;
use Nette\Utils\Json;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{

  private  $database;
  private $json;
  public $sort = 'asc';
  public $data = array(
		'meno' => array()
	);
  public $kategoria= [
  ];
  public function __construct(Nette\Database\Explorer $database)
	{
		$this->database = $database;

    $rows = $database->fetchAll('SELECT meno FROM autor');
    $this->json = $database->fetchAll('SELECT * FROM kniha');
    foreach ($this->json as $row) {
        $row['autor'] = $this->database->fetch('SELECT meno FROM autor WHERE id = ? ',$row->autor);
    }
    $this->data['meno']=  Arrays::map($rows, function ($row) {
              return $row->meno;
          });
    $rows = $database->fetchAll('SELECT nazov FROM kategoria');
    $this->kategoria=  Arrays::map($rows, function ($row) {
              return $row->nazov;
          });
	}

  public function renderDefault(): void
  {
     $this->template->sort = $this->sort;
     if($this->sort === 'id'){
	      $this->template->books = $this->database->table('kniha')
		   ->order('id ASC');
     }
     else if($this->sort === 'asc'){
       $this->template->books = $this->database->table('kniha')
      ->order('Cena ASC');
     }
     else{
       $this->template->books = $this->database->table('kniha')
      ->order('Cena DESC');
     }
  }
  public function actionDefault($sort = 'id')
	{
    $this->sort = $sort;
    if($sort !== "asc" && $sort !== "desc" && $sort !== "id"){
      $this->error("Wrong path", 400);
    }
	}
  public function actionJsonapi()
	{
    $this->sendResponse(new JsonResponse($this->json));
	}
  protected function createComponentAddBook(): Nette\Application\UI\Form
  {

  	$form = new Nette\Application\UI\Form; // means Nette\Application\UI\Form

  	$form->addText('meno')
        ->setHtmlAttribute('placeholder', 'Autor')
  		  ->setRequired("Vyplnte autora.");
    $form->addText('nazov')
        ->setHtmlAttribute('placeholder', 'Názov knihy')
        ->setRequired();
    $form->addText('isbn')
        ->setHtmlAttribute('placeholder', 'ISBN')
      	->setRequired()
        ->addRule($form::PATTERN, "Invalid ISBN","^(?:ISBN(?:-13)?:?●)?(?=[0-9]{13}$|(?=(?:[0-9]+[-●]){4})[-●0-9]{17}$)97[89][-●]?[0-9]{1,5}[-●]?[0-9]+[-●]?[0-9]+[-●]?[0-9]$");
    $form->addText('cena')
        ->setHtmlAttribute('placeholder', 'Cena')
        ->setRequired()
        ->addRule($form::FLOAT, 'invalid value');
    $form->addSelect('kategoria','', $this->kategoria)
        ->setHtmlAttribute('placeholder', 'Kategória')
        ->setRequired()
        ->setPrompt('Kategória');
  	$form->addSubmit('send', 'Pridať knihu');

    $form->onSuccess[] = [$this, 'addBookSucceeded'];
  	return $form;
  }
  public function addBookSucceeded(\stdClass $values): void
  {
    $var = $this->database->table('autor')->where('meno', $values->meno);
    if(count($var) == 0){
      $var =   $this->database->table('autor')->insert([
      'meno' => $values->meno,
  	]);
    $id = $var->id;
  }
  else{
    $id = $var->fetch()->id;
  }
  $kategoria = $this->kategoria[$values->kategoria];
	$this->database->table('kniha')->insert([
		'nazov' => $values->nazov,
		'ISBN' => $values->isbn,
		'Cena' => $values->cena,
		'Kategoria' => $kategoria,
    'Autor' => $id,
	]);

	$this->flashMessage('Kniha úspešne pridaná');
	$this->redirect('this');
}
public function renderAutocomplete($whichData, $typedText = '')
   {
       $matches = preg_grep("/$typedText/i", $this->data[$whichData]);
       $this->sendResponse(new JsonResponse($matches));
   }
}
