<?php
require_once "MoneyScrapping.php";
class Portifolio extends MoneyScrapping
{
    private array $assets;

    //define as acoes
    public function set_assets($assets_list){
        $this->assets = $assets_list;
    }

    //busca as informacoes dos ativos
    public function get_assets_info(){
        //lista de resultados vazia
        $result_list = [];

        //percorre os ativos
        foreach ($this->assets as $asset):
            //busca a url para a consulta
            $url_consult = $this->get_url($asset["name"], $asset["type"]);
            //se nao mont url pula iteracao
            if(!$url_consult)continue;

            //realiza consulta ao conteudo da url montada
            $url_content = $this->get_url_content($url_consult);
            //se nao encontrar conteudo pela url pula iteracao
            if(!$url_content)continue;

            //realiza convertas do conteudo em manipulavel pelo PHP
            $processed_content = $this->get_processed_url($url_content);
            //se nao fez a conversao pula a iteracao
            if(!$processed_content)continue;

            //busca conteudo do ativo
            $asset_info = $this->get_asset_info($processed_content);
            $asset["valor"] = $asset_info["valor"];
            $asset["pagamento"] = $asset_info["pagamento"];
            $result_list[] = $asset;

        endforeach;

        print_r($result_list);
    }
}