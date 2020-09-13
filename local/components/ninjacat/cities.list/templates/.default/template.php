<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}?>
<?
if($arParams['BOOTSTRAP'] !=='N'){
	$this->addExternalCss('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
}
?>
<? if(!empty($arResult['CITIES'])): ?>
<div class="fluid-container">
	<table class="table table-hover table-bordered text-center">
	<thead>
	<tr>
		<th scope="col">Название</th>
		<th scope="col">Доходы общие</th>
		<th scope="col">Расходы общие</th>
		<th scope="col">Количество жителей</th>
		<th scope="col">Место в рейтинге по количеству жителей</th>
		<th scope="col">Место в рейтинге по средним доходам населения</th>
		<th scope="col">Место по средним расходам населения</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($arResult['CITIES'] as $city):?>
	<tr>
		<td><?= $city['UF_NAME'] ?></td>
		<td><?= $city['UF_INCOME']?></td>
		<td><?= $city['UF_COSTS']?></td>
		<td><?= $city['UF_NUM_RES']?></td>
		<td><?= $city['RESIDENTS_RANK']?></td>
		<td><?= $city['AVG_INCOME_RANK']?></td>
		<td><?= $city['AVG_COST_RANK']?></td>
	</tr>
	<? endforeach;?>
	</tbody>
</table>
</div>
<? endif;?>

