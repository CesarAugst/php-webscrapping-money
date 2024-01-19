<?php

class MoneyScrapping
{
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
    //busca informacoes do ativo usando  o conteudo processado pelo php
    protected function get_asset_info($processed_content){
        //busca de valor
        try {
            //xpath onde encontra o valor do ativo
            $value_xpath = '//*[@id="cards-ticker"]/div[1]/div[2]/div/span';
            //faz a busca elemento com o xpath na pagina
            $value_content = $processed_content->query($value_xpath)[0];
            //busca texto do elemento
            $value = trim($value_content->nodeValue);
        }catch (Exception $e){
            echo 'Erro ao buscar Valor: ',  $e->getMessage(), "\n";
            $value = null;
        }

        //busca de ultimo dividendo
        try {
            //xpath onde encontra o valor do ativo
            $payment_value_xpath = '//*[@id="table-dividends-history"]/tbody/tr[1]/td[4]';
            $payment_date_xpath = '//*[@id="table-dividends-history"]/tbody/tr[1]/td[2]';
            //faz a busca elemento com o xpath na pagina
            $payment_value_content = $processed_content->query($payment_value_xpath)[0];
            $payment_date_xpath = $processed_content->query($payment_date_xpath)[0];
            //busca texto do elemento
            $payment_value = trim($payment_value_content->nodeValue);
            $payment_date = trim($payment_date_xpath->nodeValue);
        }catch (Exception $e){
            echo 'Erro ao buscar Pagamento: ',  $e->getMessage(), "\n";
            $payment_value = null;
            $payment_date = null;
        }
        //montagem dos dados
        return ["valor" => $value, "pagamento" => $payment_value, "data-com" => $payment_date];
    }
}