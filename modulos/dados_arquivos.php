<?php 
    header("Content-Type: application/json");
    
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    //protegeArquivo(basename(__FILE__));
    
    $jsonData = '{ "arquivos" :[';
     
    
    $select = ' select arquivos.id, arquivos.id_tarefa, arquivos.id_usuario,
                arquivos.descricao, arquivos.nome_arquivo, arquivos.data_hora,
                u.nome usuario from ';
    $qarquivo = new arquivo();
    $qarquivo->extras_select = " inner join usuarios u on (u.id = arquivos.id_usuario) ";
    
    $qarquivo->selecionaTudo($qarquivo,$select);
    while ($res = $qarquivo->retornaDados())        
    {                
        $row = array();
        $row["id"] = $res->id;
        $row["descricao"] = $res->descricao;
        $row["nome_arquivo"] = $res->nome_arquivo;
        $row["id_tarefa"] = $res->id_tarefa;
        $row["id_usuario"] = $res->id_usuario;
        $row["usuario"] = $res->usuario;
        $row["data_hora"] = $res->data_hora;
        $row["acoes"] = $res->id;        
            
        $ddata[] = $row; 
                   
    } 
    
    $output = array(
        "jarquivos" => $ddata,
    );
    
    header('Content-type: application/json');
    echo json_encode($output);        
  
   
?>