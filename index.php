<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<? $APPLICATION->IncludeComponent("ninjacat:cities.list",
    ".default",
    [
        'CACHE_TYPE' => 'A',
        'ENTITY' => 'cities',
    ],
    false,
    ['HIDE_ICONS' => 'Y']
);
?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
