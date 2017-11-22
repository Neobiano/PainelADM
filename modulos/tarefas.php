<?php   
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    protegeArquivo(basename(__FILE__));
    loadJS('jqueryvalidate');
    loadJS('jqueryvalidate-messages');
	
    //verificando se há registros no BD, caso contrario abrirá a inserção.
    if ($tela =='listar')
    {
        $qtarefa = new tarefa();       
        $qtarefa->selecionaTudo($qtarefa);
        if ($qtarefa->linhasafetadas <= 0)
            $tela = 'incluir';        
    }
    
    switch ($tela) 
    {                 
        case 'editar':                     
            $sessao = new sessao();
            
            //verificando se o usuário logado é admin            
            if (isAdmin()==true)
            {
                //se possui ID definido no roteamento, pois se não tiver indica que o usuário tentou 'entrar direto na página'    
                if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    
                    //verificando se ele escolheu a botão 'editar' 
                    if (isset($_POST['editar']))
                    {                       
                        // se for usuário do tarefa admin, vai criar um objeto com todos os parametros para edição, permitindo a definição e novos admins                                     
                        $tarefa = new tarefa(array(
                            'assunto'=>$_POST['assunto'],
                            'descricao'=>$_POST['editor1'],
                            'id_tipo'=>$_POST['tipo'],
                            'id_status'=>$_POST['status'],
                            'id_prioridade'=>$_POST['prioridade'],
                            'id_projeto'=>$_POST['projeto'],
                            'id_categoria'=>$_POST['categoria'],
                            'id_atribuido'=>$_POST['atribuido'],
                            'id_criador'=>$_POST['atribuido'],
                            'data_inicio'=>$_POST['dataini'],
                            'data_fim'=>$_POST['datafim'],
                            'data_cacad'=>$_POST['datafim']
                        ));
                        
                        $duplicado=false;
                        $tarefa->valorpk = $id;
                        $tarefa->extras_select = "WHERE id=$id";
                        $tarefa->selecionaTudo($tarefa);
                        $res = $tarefa->retornaDados();
                        
                        //se o assunto foi alterado do inicilamente carregado para o registro
                        if ($res->assunto != $_POST['assunto'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($tarefa->existeRegistro('assunto',$_POST['assunto']))
                            {
                                printMSG('tarefa já existe no sistema, escolha outro assunto!','erro');
                                $duplicado = TRUE;
                            }
                        }

                        //se não existe vai atualizar normalmente
                        if ($duplicado!=TRUE)
                        {
                            $tarefa->atualizar($tarefa);
                            if ($tarefa->linhasafetadas==1)
                            {
                                printMSG('Dados alterados com sucesso. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','sucesso');
                                unset($_POST);
                            }
							else                         
                            	printMSG('Nenhum dado foi alterado. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','alerta');
                        }
                                    
                    }//if (isset($_POST['editar'])) - final
                    
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição    
                    $tarefabd = new tarefa();
                    $tarefabd->extras_select = "WHERE id=$id";
                    $tarefabd->selecionaTudo($tarefabd);
                    $resbd = $tarefabd->retornaDados();
                }
                else
                    printMSG('tarefa não definido, <a href="?m=tarefas&t=listar">escolha um tarefa para alterar</a>','erro');
                
                
                   
                ?>
                <script type="text/javascript">
					$(document).ready
					(
            			function () 
            			{
            			    						CKEDITOR.replace('editor1')	
            			
                        			  				//Date picker
                                    			    $('#datepicker1').datepicker({	    
                                    			      format:"yyyy-mm-dd",
                                    			      todayBtn:true,
                                    			      assumeNearbyYear:true,
                                    			      todayHighlight:true,	                
                                    			      autoclose: true
                                    			    })		  
                
                                    			    $('#datepicker2').datepicker({	    
                                    			      format:"yyyy-mm-dd",
                                    			      todayBtn:true,
                                    			      assumeNearbyYear:true,
                                    			      todayHighlight:true,	                
                                    			      autoclose: true
                                    			    })			    
            			 				}
		 			); 
					
    			</script>	           
                <div class="content-wrapper">
                <!-- Content Header (Page header) --> 
        
                <section class="content-header">
                	<h1>
                		Tarefas
                		<small>Editar</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Editar</a></li>
                		<li class="active">Editar</li>
                  	</ol>
                </section> 
    
                
    			<section class="content">      				    	           
    						<div class="box box-primary">    								
    							<form class="userform" role="form" method="post" action="">
    								<div class="box-body">
    									<div class="row">
    									 	<div class="form-group">
            									<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="assunto" type="text" class="form-control input-sm" placeholder="assunto do tarefa" value="<?php if($resbd) echo $resbd->id;?>">
            									</div>
            									<div class="col-xs-8">
                      								<label>Assunto</label>
                      								<input autofocus name="assunto" type="text" class="form-control input-sm" placeholder="assunto do tarefa" value="<?php if($resbd) echo $resbd->assunto;?>">
            									</div>            									                                                         								
            									<div class="col-xs-2">
                      								<label>Tipo</label>
                                                    <select name="tipo" class="form-control select2 input-sm" style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qtipo = new tipo();                                                	
                                                            $qtipo->selecionaTudo($qtipo);                                                	                                                	                                                                                                                                                              
                                                            while ($res = $qtipo->retornaDados())
                                                            {                                         
                                                                if ($resbd->id_tipo == $res->id)
                                                                    printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                                else
                                                                    printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            } 
                                                        ?>                                              
                                                    </select>
            									</div>        									
            							 	</div>            							 	   	
            							</div>	
            							<div class="row top-buffer">
    									 	<div class="form-group">    									 	
                                            	<div class="col-xs-12" >                                                               
                                            			<label>Descrição</label>
                                            			<textarea form-control id="editor1" name="editor1" rows="10" cols="80">
    															<?php if($resbd) echo html_entity_decode($resbd->descricao);?>                                        				                                            				
                                            			</textarea>                                                                                                                                       
                                            	</div>		                                    	     									                                             
    										</div>            							 	   	
            							</div> 	
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Prioridade</label>
                                                    <select name="prioridade" class="form-control select2 input-sm" style="width: 100%;">
                                                    <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qprioridade = new prioridade();
                                                        	$qprioridade->selecionaTudo($qprioridade);
                                                        	while ($res = $qprioridade->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_prioridade == $res->id)
                                                        	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>  
            									<div class="col-xs-4">
                      								<label>Categoria</label>
                                                    <select name="categoria" class="form-control select2 input-sm" style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qcategoria = new categoria();
                                                        	$qcategoria->selecionaTudo($qcategoria);
                                                        	while ($res = $qcategoria->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_categoria == $res->id)
                                                        	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div> 
            									<div class="col-xs-4">
                      								<label>Status</label>
                                                    <select name="status" class="form-control select2 input-sm" style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qstatus= new status();
                                                        	$qstatus->selecionaTudo($qstatus);
                                                        	while ($res = $qstatus->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_status == $res->id)
                                                        	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>       									
            							 	</div>            							 	   	
            							</div>	  
            							
            							<div class="row top-buffer">
    									 	<div class="form-group">            								
            									<div class="col-xs-4">
                      								<label>Projeto</label>
                                                    <select name="projeto" class="form-control select2 input-sm" style="width: 100%;">
                                                       <option selected="selected" value="0"> </option>
                                                    	<?php 
                                                    	   $qprojeto = new projeto();
                                                    	   $qprojeto->selecionaTudo($qprojeto);
                                                    	   while ($res = $qprojeto->retornaDados())
                                                        	{
                                                        	    if ($resbd->id_projeto == $res->id)
                                                        	        printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                        	    else
                                                        	        printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                        	} 
                                                        ?>                                              
                                                    </select>
            									</div>  
            									<div class="col-xs-4">
                      								<label>Atribuido à</label>
                                                    <select name="atribuido" class="form-control select2 input-sm" style="width: 100%;">
                                                    	<option selected="selected" value="0"> </option>
                                                    	<?php 
                                                        	$qusuario = new usuario();
                                                        	$qusuario->selecionaTudo($qusuario);
                                                        	while ($res = $qusuario->retornaDados())
                                                            	{
                                                            	    if ($resbd->id_atribuido == $res->id)
                                                            	       printf('<option selected="selected" value="%s">%s</option>',$res->id,$res->nome);
                                                            	    else
                                                            	       printf('<option value="%s">%s</option>',$res->id,$res->nome);
                                                            	} 
                                                         ?>                                              
                                                    </select>
            									</div>                									
            									<div class="col-xs-2">
                      								<label>Data Início</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input name="dataini" type="text" class="form-control pull-right input-sm" id="datepicker1" value="<?php if($resbd) echo $resbd->data_inicio;?>">
                                                    </div>
                                                                                                                                                
            									</div>  
            									<div class="col-xs-2">
                      								<label>Data Fim</label>
                      								<div class="input-group date">
                                                      <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input name="datafim" type="text" class="form-control pull-right input-sm" id="datepicker2" value="<?php if($resbd) echo $resbd->data_fim;?>">
                                                    </div>
                                                                                                                                                
            									</div>           									     									
            							 	</div>            							 	   	
            							</div>	   
    								</div> 	  	                               
                                  		 
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
    									 <button type="submit" name="editar" class="btn btn-info pull-right">Salvar Alterações</button>  									    									 
    								</div>     							                          
    						</form>
    		 			</div><!-- Final box-primary -->    					  			
    			</section>
                <!-- /.content -->
			</div> <!-- /.content-wrapper -->
			                 	
			                                     
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
            
        case 'incluir':             
            if (isset($_POST['cadastrar']))
            {    
              
                $tarefa = new tarefa(
                                        array(
                                        'assunto'=>$_POST['assunto']                                       
                                        )
                                    ); 
             
            
                //verificando se ja existem registros com o parametro solicitado para inserção      
                if ($tarefa->existeRegistro('assunto',$_POST['assunto'])) 
                {
                    printMSG('tarefa já existe no sistema, escolha outro assunto!','erro');
                    $duplicado = true;
                }
                               
                if ($duplicado!=true) 
                {
                    $tarefa->inserir($tarefa);
                   
                    if ($tarefa->linhasafetadas==1)
                    {
                        printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=tarefas&t=listar">Exibir Cadastros</a>','sucesso');   
                        unset($_POST);                                                                                                                                           
                    }   
                }                               
            }
           
        ?>          
            <script type="text/javascript">
                    $(document).ready
                    (
                        function()
                        {
                            $(".userform").validate
                            (
                                {
                                    rules:
                                    {
                                        assunto:{required:true,minlength:5}                                        
                                    }
                                }
                            )
                            
                        }
                    );
			</script>
			<div class="content-wrapper">
                <!-- Content Header (Page header) --> 
        
                <section class="content-header">
                	<h1>
                		tarefas
                		<small>Incluir</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Tarefas</a></li>
                		<li class="active">Editar</li>
                  	</ol>
                </section> 
    
                <!-- Main content -->
    			<section class="content">
      				<div class="row">
    	            <!-- left column -->
    					<div class="col-md-6">
                        <!-- general form elements -->
    						<div class="box box-primary">    							    							
    							<!-- form start -->	
    							<form class="userform" role="form" method="post" action="">
    								<div class="box-body">
    									<div class="form-group">
              								<label>Assunto</label>
              								<input autofocus name="assunto" type="text" class="form-control input-sm" placeholder="assunto do tarefa" value="<?php echo $_POST['assunto']?>">
    									</div>
                                            								
    								</div>                                
                                  
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
    									 <button type="submit" name="cadastrar" class="btn btn-info pull-right">Salvar dados</button>  									
    									 
    								</div>                              
    							</form>
    		 				</div><!-- Final box-primary -->
    					</div><!-- Final col-md-6 -->
    				</div>
    			</section>
                <!-- /.content -->
			</div> <!-- /.content-wrapper -->
        	
            <?php
            break;
        
        case 'listar':
                			       
            ?>
            <div class="content-wrapper">             
                <!-- Content Header (Page header) -->
    		    <section class="content-header">
    		      <h1>
    		        Tarefas
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> tarefas</a></li>
    		        <li class="active">Listagem</li>
    		      </ol>
    		    </section>
    		    
    		     <!-- Main content -->
        		<section class="content container-fluid">                
                	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">		       
                	<div class="box">                              
                    	<div class="box-body">
                        	<table id="gridfull" class="table table-bordered table-striped table-sm">
                           		<thead>
                            		<tr>
                              			<th>Código</th>
                              			<th>Status</th>
                              			<th>Assunto</th>
                              			<th>Projeto</th>                              			
                              			<th>Categoria</th>
                              			<th>Prioridade</th>
                              			<th>Atribuído à</th>
                              			<th>Data Inicio</th>
                              			<th>Data Fim</th>                              			                 
                              			<th>Ações</th>
                            		</tr>
                            	</thead>
                            	<tbody>
                                    <?php 
                                    $select = ' SELECT tarefas.*, c.nome categoria, p.nome prioridade, pj.nome projeto,
                                                st.nome status, tp.nome tipo, u1.nome usr_criador, u2.nome usr_atribuido
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
                                    while ($res = $tarefa->retornaDados()):
                                        echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td>%s</td>',$res->status);
                                        printf('<td>%s</td>',$res->assunto);
                                        printf('<td>%s</td>',$res->projeto);
                                        printf('<td>%s</td>',$res->categoria);
                                        printf('<td>%s</td>',$res->prioridade);
                                        printf('<td>%s</td>',$res->usr_atribuido);
                                        printf('<td>%s</td>',$res->data_inicio);
                                        printf('<td>%s</td>',$res->data_fim);
                                        printf('<td><a href="?m=tarefas&t=incluir" title="Novo"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=tarefas&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a><a href="?m=tarefas&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id);
                                        echo '</tr>';
                                    endwhile;               
                                    ?>
                             	</tbody>
                            	<tfoot>
                            		<tr>
                              			<th></th>
                              			<th></th>
                              			<th></th>                              			        
                              			<th></th>
                              			<th></th>
                              			<th></th>
                              			<th></th>
                              			<th></th>
                              			<th></th>
                              			<th></th>
                            		</tr>
                            	</tfoot>
                        	</table>
            			</div><!-- /.box -->                    
            		</div><!-- /.box-body -->
            	</section> <!-- /.Main content -->           
			</div> <!-- /.content-wrapper -->
            <?php
            break;  
                              
        case 'excluir':        
            $sessao = new sessao();
            if (isAdmin()==true)
            {
                if (isset($_GET['id'])) 
                {
                    $id = $_GET['id'];
                    
                    //iniciando processo de salvamento se o usuário deu POST
                    if (isset($_POST['excluir']))
                    {
                        $tarefa = new tarefa();
                        $tarefa->valorpk =$id;                   
                                                
                        
                        $tarefa->deletar($tarefa);
                        if ($tarefa->linhasafetadas==1)
                        {
                            printMSG('Registro excluído com sucesso. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','sucesso');                                                     
                            unset($_POST);                           
                        }
                        else 
                            printMSG('Nenhum dado foi excluído. <a href="?m=tarefas&t=listar">Exibir cadastros</a>','alerta');
                        
                    } //final isset $_POST['excluir']
                    $tarefabd = new tarefa();
                    $tarefabd->extras_select = "where id=$id";
                    $tarefabd->selecionaTudo($tarefabd);
                    $resbd = $tarefabd->retornaDados();                   
                }//final isset $_GET['id']
                else
                    printMSG('tarefa não definido, <a href="?tarefas&t=listar">escolha um tarefa para excluir</a>','erro');
                
                //formulário de edição de tarefa   
                ?>   
                	<div class="content-wrapper">
                    <!-- Content Header (Page header) --> 
            
                    <section class="content-header">
                    	<h1>
                    		tarefas
                    		<small>Excluir</small>
                      	</h1>
                      	<ol class="breadcrumb">
                    		<li><a ><i class="fa fa-dashboard"></i> tarefas</a></li>
                    		<li class="active">Excluir</li>
                      	</ol>
                    </section> 
        
                    <!-- Main content -->
        			<section class="content">
          				<div class="row">
        	            <!-- left column -->
        					<div class="col-md-6">
                            <!-- general form elements -->
        						<div class="box box-primary">
        							<div class="box-header with-border">
        								<h3 class="box-title">Informe os dados para cadastro</h3>
        							</div>   	
        							
        							<!-- form start -->	
        							<form class="userform" role="form" method="post" action="">
        								<div class="box-body">
        									<div class="form-group">
                  								<label>Código</label>
                  								<input  name="id" type="text" class="form-control input-sm"  disabled value="<?php if($resbd) echo $resbd->id;?>">
        									</div>
                                            
                                            <div class="form-group">
                  								<label>Assunto</label>
                  								<input  name="assunto" type="text" class="form-control input-sm" disabled value="<?php if($resbd) echo $resbd->assunto;?>">
        									</div>        									        									
        								</div>                                
                                      
        								<div class="box-footer">  
        									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
        									 <button type="submit" name="excluir" class="btn btn-info pull-right">Confirmar exclusão</button>  									
        									 
        								</div>                              
        							</form>
        		 				</div><!-- Final box-primary -->
        					</div><!-- Final col-md-6 -->
        				</div>
        			</section>
                    <!-- /.content -->
    			</div> <!-- /.content-wrapper         			                                  
                    
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
        
        default:
            echo '<p> A tela solicitada não existe </p>';
            break;
    }