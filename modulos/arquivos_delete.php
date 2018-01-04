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
            $dir = "../arquivos/";
            $file = glob( $dir."*-".$id."-*");
            unlink($file);                                   
        
     }
    }  

?>