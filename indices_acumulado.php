<?php
//utiliza a funcao para retornar o indexador
print_r( get_index_current_value("inpc"));
echo PHP_EOL;
print_r(get_index_current_value("igp-m"));
echo PHP_EOL;
print_r(get_index_current_value("ipca"));

//funcao reesponsavel por retornar o valor do indexador a partir da url e do xpath
function get_index_current_value($index){

    //determina o xpath/url a ser utilizado
    $xpath_data_vigente = "//*[@id='indiceTable']/tbody/tr[2]/td[1]";
    switch($index){
        case "inpc":
            $xpath_acumulado = "//*[@id='indiceTable']/tbody/tr[2]/td[4]";
            $url = "https://www.vriconsulting.com.br/indices/inpc.php";
            break;
        case "igp-m":
            $xpath_acumulado = "//*[@id='indiceTable']/tbody/tr[2]/td[5]";
            $url = "https://www.vriconsulting.com.br/indices/igp-m.php";
            break;
        case "ipca":
            $xpath_acumulado = "//*[@id='indiceTable']/tbody/tr[2]/td[4]";
            $url = "https://www.vriconsulting.com.br/indices/ipca.php";
            break;
        default:
            return "Indice Invalido";
    }

    //busca o conteudo da pagina
    $content = file_get_contents($url);
    if(!$content) return "nao obteve conteudo da url definida";
    //instancia um DOM
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    //carrega a pagina adquirida
    $dom->loadHTML($content);
    //instancia o XPath
    $xp = new DOMXPath($dom);

    //query usando xpath para retornar o Node especifico (acumulado
    $acumulado = trim($xp->query($xpath_acumulado)[0]->nodeValue);
    $data_vigente = trim($xp->query($xpath_data_vigente)[0]->nodeValue);

    //retorna o conteudo do node
    return (["acumulado" => $acumulado, "data_vigente" => $data_vigente]);
}