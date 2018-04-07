<?php
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    
    $parametro = basename($_GET['file']);
    $pos = strpos($parametro,"<>")+2;      
    
    $referencia = substr($parametro,$pos);
    $file = ARQUIVOSPATH.'/'.$referencia; 
    
    $nome = substr($parametro,0,$pos-2);//substr($parametro,-$pos);                    
        
    if(!$file){ // file does not exist
        die('Arquivo não encontrado:'.$parametro);
    } else {
       
        header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="'.$nome.'"');
        header('Content-Type: application/zip');
        header('Content-Transfer-Encoding: binary');
        
        // read the file from disk
        readfile($file);
    }