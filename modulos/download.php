<?php
    $nome = basename($_GET['file']);
    $file = ARQUIVOSPATH.'/'.$nome;
    
    if(!$file){ // file does not exist
        die('Arquivo não encontrado');
    } else {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$nome");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        // read the file from disk
        readfile($file);
    }