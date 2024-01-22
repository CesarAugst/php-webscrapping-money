<?php

class ResultsManipulation
{
    public function generate_csv($dados){
        //percorre os dados apra obter os dados
        foreach ($dados as $dado):
            $header[] = $dado->name;
            $body_valor[] = $dado->valor;
        endforeach;

        //define nome do arquivo
        $filename = date("Y-m-d_H-i-s");
        // Abrir/criar arquivo
        $arquivo = fopen("files/$filename.csv", 'w');

        //insere cabecalho no arquivo
        fputcsv($arquivo, $header);
        //insere dados do corpo
        fputcsv($arquivo, $body_valor);
        // Fechar o arquivo
        fclose($arquivo);
    }
}