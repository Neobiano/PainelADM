<?php
    $file = basename($_GET['file']);
    $file = 'C:/wamp64/www/PainelADM/arquivos/'.$file;
    
    if(!$file){ // file does not exist
        die('Arquivo não encontrado');
    } else {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        // read the file from disk
        readfile($file);
    }