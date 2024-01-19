<?php
require_once "classes/Portifolio.php";
require_once "classes/ResultsManipulation.php";

//instanciamento
$portifolio = new Portifolio();
$resultsManipulation = new ResultsManipulation();

//definindo ativos
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
//buscando informacoes dos ativos
$dados = $portifolio->get_assets_info();

//gerando csv das informacoes
$resultsManipulation->generate_csv($dados);


