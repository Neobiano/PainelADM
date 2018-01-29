<?php
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
   

    //percorrendo os arquivos selecionados
    if(isset($_POST["id"]))
    {
        foreach($_POST["id"] as $id)
        {
            //apagando o registro do BD                                                   
            $arquivo = new arquivo();
            $arquivo->valorpk =$id;   
            $arquivo->deletar($arquivo);
            
            //apagando o arquivo do diretório
            $dir = "C:/wamp64/www/PainelADM/arquivos/";
            $file = glob( $dir."*.dat");
            //echo $file;
            unlink($file);                                   
        
     }
    }  

?>