<?php

use Latte\Runtime as LR;

/** source: C:\Users\dubec\Desktop\Testovaci-projekt-kniznica\Kniznica\app\Presenters/templates/Homepage/default.latte */
final class Template898c418ac1 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['content' => 'blockContent'],
	];


	public function main(): array
	{
		extract($this->params);
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('content', get_defined_vars());
		echo "\n";
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['book' => '76'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block content} on line 1 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<style>
.ui-autocomplete-loading { background: white url(\'images/ui-anim_basic_16x16.gif\') right center no-repeat; }
#city { width: 25em; }
</style>
<script>
$(function() {

	var select_name = "meno";
	$("input[name=" + select_name + "]").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: ';
		echo LR\Filters::escapeJs($presenter->link('autocomplete')) /* line 13 */;
		echo ',
				data: {
					whichData: select_name,
					typedText: request.term
				},
				success: function( data ) {
					response( $.map( data, function( item ) {
						return { label: item, value: item }
					}));
				}
			});
		},
		minLength: 2,
		open: function() {
			$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
		},
		close: function() {
			$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
		}
	});
});
</script>


	<div  style="width:10%;margin-left:auto;margin-right:auto;">
	<h1>Knižnica</h1>
	</div>
	<div class="container">
';
		$form = $this->global->formsStack[] = $this->global->uiControl["addBook"];
		echo '	<form class="row g-3 container"';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), ['class' => null], false);
		echo '>
	<div class="col-md-12">
		<p>';
		echo end($this->global->formsStack)["nazov"]->getControl()->addAttributes(['class'=>"form-control"]) /* line 43 */;
		echo '</p>
	</div>
	<div class="col-md-6 pe-auto">
		<p>';
		echo end($this->global->formsStack)["meno"]->getControl()->addAttributes(['class'=>" form-control"]) /* line 46 */;
		echo '</p>
	</div>
	<div class="col-md-6">
		<p>';
		echo end($this->global->formsStack)["isbn"]->getControl()->addAttributes(['class'=>" form-control"]) /* line 49 */;
		echo '</p>
	</div>
	<div class="col-md-2">
		<p>';
		echo end($this->global->formsStack)["cena"]->getControl()->addAttributes(['class'=>" form-control "]) /* line 52 */;
		echo '</p>
	</div>
	<div class="col-md-4">
		<p>';
		echo end($this->global->formsStack)["kategoria"]->getControl()->addAttributes(['class'=>" form-control "]) /* line 55 */;
		echo '</p>
	</div>
		<button class=" btn btn-outline-secondary btn-lg mx-auto" type="submit"';
		$_input = end($this->global->formsStack)["send"];
		echo $_input->getControlPart()->addAttributes(['class' => null, 'type' => null])->attributes();
		echo '>Pridať novú knihu</button>
';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
		echo '	</form>
	</div>

	<div  style="width:7%;margin-left:auto;margin-right:auto;">
<h1>Knihy</h1>
	</div>
<div width:80%>
<table class="table table-striped" style="width:80%;margin-left:auto;margin-right:auto;">
<thead>
	<tr>
		<th scope="col">Názov</th>
		<th scope="col">ISBN</th>
		<th scope="col" ><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", ['sort' => ($sort !== 'asc' ? 'asc' : 'desc')]));
		echo '">Cena</a></th>
		<th scope="col">Kategória</th>
		<th scope="col">Autor</th>
	</tr>
</thead>
<tbody>
';
		$iterations = 0;
		foreach ($books as $book) {
			echo '	<tr>
		<th >';
			echo LR\Filters::escapeHtmlText($book->nazov) /* line 78 */;
			echo '</th>
		<th >';
			echo LR\Filters::escapeHtmlText($book->ISBN) /* line 79 */;
			echo '</th>
		<th >';
			echo LR\Filters::escapeHtmlText($book->cena) /* line 80 */;
			echo '</th>
		<th >';
			echo LR\Filters::escapeHtmlText($book->kategoria) /* line 81 */;
			echo '</th>
		<th >';
			echo LR\Filters::escapeHtmlText($book->ref('autor', 'autor')->meno) /* line 82 */;
			echo '</th>
	</tr>

';
			$iterations++;
		}
		echo '</tbody>
</table>
</div>
';
	}

}
