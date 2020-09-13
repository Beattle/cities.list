<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\Loader;


class CitiesList extends CBitrixComponent
{
    public function __construct($component)
    {
        parent::__construct($component);
    }

    /**
     * @return mixed|void|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     */
    public function executeComponent()
    {
        Loader::includeModule('highloadblock');
        $cites = HighloadBlockTable::getRow(['filter' => ['=NAME' => $this->arParams['ENTITY']]]);
        if ($cites === null){
            return ''; // выводим ошибку
        }
        if( $this->startResultCache()) {
            $Entity = HighloadBlockTable::compileEntity($cites);
            $Cities = $Entity->getDataClass();
            $cities_list = $Cities::getList([
                'select' => ['ID','UF_NAME','AVG_INCOME','AVG_COST','UF_INCOME','UF_COSTS','UF_NUM_RES'],
                'order' => ['UF_NUM_RES' => 'DESC'],
                'runtime' => [
                    new ExpressionField(
                        'AVG_INCOME',
                        '%s / %s ', ['UF_INCOME', 'UF_NUM_RES']),
                    new ExpressionField('AVG_COST',
                        '%s / %s', ['UF_COSTS', 'UF_NUM_RES']),
                ],
            ])->fetchAll();
            if(empty($cities_list)){
                $this->abortResultCache();
            }
            $this->arResult['CITIES'] = $this->getRating($cities_list);
            $this->includeComponentTemplate();
        }

    }

    /**
     * @param  array  $cities
     * @return array
     */
    private function getRating(Array $cities)
    {
        $cities = array_column($cities,null,'ID');
        $avg_costs = array_column($cities,'AVG_COST','ID');
        arsort($avg_costs);
        $rating_costs = array_flip(array_keys($avg_costs));
        $avg_incomes = array_column($cities,'AVG_INCOME','ID');
        arsort($avg_incomes);
        $rating_income = array_flip(array_keys($avg_incomes));
        $res_rank = 0;
        foreach ($cities as $id => &$city) {
            $city['RESIDENTS_RANK'] = ++$res_rank;
            $city['AVG_COST_RANK'] = ++$rating_costs[$id];
            $city['AVG_INCOME_RANK'] = ++$rating_income[$id];
            $city['AVG_COST']  = ceil($city['AVG_COST']);
            $city['AVG_INCOME'] = ceil($city['AVG_INCOME']);
        }
        return $cities;
    }
}