<?php
//lista de ativos
$ativos = [
    "acoes" => [
        "petr4",
        "vale3"
    ],
    "fiis" => [
        "cptr11"
    ]
];
//instancia o portifolio
$portifolio = new Portfolio($ativos);
print_r($portifolio->get_ativos());

//informacoes sobre o portifolio
class Portfolio{
    function __construct($ativos_list){
        $this->ativos = (object)$ativos_list;
        $this->acoes = $this->ativos->acoes;
        $this->fiis = $this->ativos->fiis;
    }
}
