<?php 
    header("Content-Type: application/json");
    
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    //protegeArquivo(basename(__FILE__));
    
    $jsonData = '{ "tipos" :[';
    $tipo = new tipo();
    $tipo->selecionaTudo($tipo);
    while ($res = $tipo->retornaDados())
    {        
        $jsonData .= '{"id":"'.$res->id.'","nome":"'.$res->nome.'","link":"'.$res->id.'"},';          
    } 
      
    $jsonData = chop($jsonData, ",");
    $jsonData .= ']}';
    echo $jsonData;
  
   
?>