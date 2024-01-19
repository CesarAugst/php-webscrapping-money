<?php

class ResultsManipulation
{
    public function generate_csv($dados){
        //define nome do arquivo
        $filename = date("Y-m-d_H-i-s");
        // Abrir/criar arquivo
        $arquivo = fopen("files/$filename.csv", 'w');

        //insere cabecalho no arquivo
        fputcsv($arquivo, ["SIGLA","TIPO","VALOR","PAGAMENTO"]);

        // Popular os dados
        foreach ($dados as $linha) {
            fputcsv($arquivo, $linha);
        }

        // Fechar o arquivo
        fclose($arquivo);
    }
}