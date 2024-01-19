<?php
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

class MoneyScrapping{
    //define as urls das acoes
    protected function get_url($asset_name, $asset_type){
        try {
            //error
            if (!$asset_name) throw new Exception('Ativo sem nome');
            if (!$asset_type) throw new Exception('Ativo sem tipo');
        } catch (Exception $e) {
            echo 'Erro ao montar URL: ',  $e->getMessage(), "\n";
            return false;
        }
        //conversoes
        $lower_asset_name = strtolower($asset_name);
        //reetorna url completa
        return "https://investidor10.com.br/$asset_type/$lower_asset_name/";
    }
    //busca o conteudo da pagina
    protected function get_url_content($url){
        try {
            $content = file_get_contents($url);
            if(!$content) throw new Exception('Nao obteve conteudo da URL');
        }catch (Exception $e){
            echo 'Erro ao consultar URL: ',  $e->getMessage(), "\n";
            return false;
        }
        return file_get_contents($url);
    }
    //converte o conteudo da url em manipulavel pelo PHP
    protected function get_processed_url($url_content){
        //converte conteudo em DOMDocument
        try {
            $dom = new DOMDocument;
            libxml_use_internal_errors(true);
            $dom->loadHTML($url_content);
        }catch (Exception $e){
            echo 'Erro ao converter em DOMDocument.';
            return false;
        }

        //converte conteudo em DOMXPATH
        try {
            $xp = new DOMXPath($dom);
        }catch (Exception $e){
            echo 'Erro ao converter em DOMXPath.';
            return false;
        }

        //instancia o XPath
        return $xp;
    }

}

class Portifolio extends MoneyScrapping
{
    private $assets;

    //define as acoes
    public function set_assets($assets_list){
        $this->assets = $assets_list;
    }

    //busca as informacoes dos ativos
    public function get_assets_info(){
        //percorre as acoes
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


        endforeach;
    }
}