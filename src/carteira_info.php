<?php
require_once "classes/Portifolio.php";
//instancia o portifolio
$portifolio = new Portifolio();

$portifolio->set_assets([
    [
        "name" => "petr4",
        "type" => "acoes",
    ],[
        "name" => "vale3",
        "type" => "acoes",
    ],[
        "name" => "cptr11",
        "type" => "fiis",
    ]
]);
$portifolio->get_assets_info();