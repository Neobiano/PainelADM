<?php 
    header("Content-Type: application/json");
    
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    //protegeArquivo(basename(__FILE__));
    
    $jsonData = '{ "tarefas" :[';
    $select = ' SELECT tarefas.*,
                                                case
                                                    when (st.fechado = "S") then 0
                                                    else DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)
                                                end atraso, c.nome categoria, p.nome prioridade, pj.nome projeto,
                                                st.nome status, st.cor, tp.nome tipo, u1.nome usr_criador, u2.nome usr_atribuido,
                                                case
                                                   when (st.fechado = "S") then "#ffffff"
                                                    else (select pe.cor from periodos_entrega pe where (DATEDIFF (CURRENT_DATE(),tarefas.data_prev_fim)) BETWEEN pe.inter_ini and pe.inter_fim)
                                                end cor_linha
                                                FROM ';
    $tarefa = new tarefa();
    $tarefa->extras_select = "  left join categorias c on (c.id = tarefas.id_categoria)
                                                                left join prioridades p on (p.id = tarefas.id_prioridade)
                                                                left join projetos pj on (pj.id = tarefas.id_projeto)
                                                                left join status st on (st.id = tarefas.id_status)
                                                                left join tipos tp on (tp.id = tarefas.id_tipo)
                                                                left join usuarios u1 on (u1.id = tarefas.id_criador)
                                                                left join usuarios u2 on (u2.id = tarefas.id_atribuido) ";
    
    $tarefa->selecionaTudo($tarefa,$select);
    while ($res = $tarefa->retornaDados())        
    {                
        $jsonData .= '{"id":"'.$res->id.'",
                        "assunto":"'.$res->assunto.'",
                        "id_tipo":"'.$res->id_tipo.'",
                        "id_status":"'.$res->id_status.'",
                        "id_prioridade":"'.$res->id_prioridade.'",
                        "data_cad":"'.$res->data_cad.'",
                        "id_projeto":"'.$res->id_projeto.'",
                        "id_categoria":"'.$res->id_categoria.'",
                        "data_inicio":"'.$res->data_cad.'",
                        "data_fim":"'.$res->data_fim.'",
                        "id_atribuido":"'.$res->id_atribuido.'",
                        "id_criador":"'.$res->id_criador.'",
                        "data_prev_fim":"'.$res->data_prev_fim.'",
                        "atraso":"'.$res->atraso.'",
                        "categoria":"'.$res->categoria.'",
                        "projeto":"'.$res->projeto.'",
                        "status":"'.$res->status.'",
                        "cor":"'.$res->cor.'",
                        "cor_linha":"'.$res->cor_linha.'",
                        "usr_criador":"'.$res->usr_criador.'",
                        "usr_atribuido":"'.$res->usr_atribuido.'",
                        "tipo":"'.$res->tipo.'",
                        "acoes":"'.$res->id.'"},';                   
    } 
      
    $jsonData = chop($jsonData, ",");
    $jsonData .= ']}';
    echo $jsonData;
  
   
?>