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
                            'nome'=>$_POST['nome']
                        ));
                        
                        $tarefa->valorpk = $id;
                        $tarefa->extras_select = "WHERE id=$id";
                        $tarefa->selecionaTudo($tarefa);
                        $res = $tarefa->retornaDados();
                        
                        //se o NOME foi alterado do inicilamente carregado para o registro
                        if ($res->nome != $_POST['nome'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($tarefa->existeRegistro('nome',$_POST['nome']))
                            {
                                printMSG('tarefa já existe no sistema, escolha outro nome!','erro');
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
                                    
                    }
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição    
                    $tarefabd = new tarefa();
                    $tarefabd->extras_select = "WHERE id=$id";
                    $tarefabd->selecionaTudo($tarefabd);
                    $resbd = $tarefabd->retornaDados();
                }
                else
                    printMSG('tarefa não definido, <a href="?m=tarefas&t=listar">escolha um tarefa para alterar</a>','erro');
                
                
                //formulário de edição de usuário   
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
                                            nome:{required:true,minlength:5}
                                                                                        
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
                		<li><a ><i class="fa fa-dashboard"></i> tarefas</a></li>
                		<li class="active">Incluir</li>
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
              								<input disabled name="nome" type="text" class="form-control" placeholder="Nome do tarefa" value="<?php if($resbd) echo $resbd->id;?>">
    									</div>
    									
    									<div class="form-group">
              								<label>Nome</label>
              								<input autofocus name="nome" type="text" class="form-control" placeholder="Nome do tarefa" value="<?php if($resbd) echo $resbd->nome;?>">
    									</div>
                                            									
    								</div>                                
                                  
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=tarefas&t=listar'" >Cancelar</button>
    									 <button type="submit" name="editar" class="btn btn-info pull-right">Salvar Alterações</button>  									
    									 
    								</div>                              
    							</form>
    		 				</div><!-- Final box-primary -->
    					</div><!-- Final col-md-6 -->
    				</div>
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
                                        'nome'=>$_POST['nome']                                       
                                        )
                                    ); 
             
            
                //verificando se ja existem registros com o parametro solicitado para inserção      
                if ($tarefa->existeRegistro('nome',$_POST['nome'])) 
                {
                    printMSG('tarefa já existe no sistema, escolha outro nome!','erro');
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
                                        nome:{required:true,minlength:5}                                        
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
                		<li><a ><i class="fa fa-dashboard"></i> tarefas</a></li>
                		<li class="active">Incluir</li>
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
              								<label>Nome</label>
              								<input autofocus name="nome" type="text" class="form-control" placeholder="Nome do tarefa" value="<?php echo $_POST['nome']?>">
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
    		        tarefas
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
                        	<table id="gridfull" class="table table-bordered table-striped">
                           		<thead>
                            		<tr>
                              			<th>Código</th>
                              			<th>Nome</th>                              			                 
                              			<th>Ações</th>
                            		</tr>
                            	</thead>
                            	<tbody>
                                    <?php 
                                    $tarefa = new tarefa();
                                    $tarefa->selecionaTudo($tarefa);                       					                                              
                                    while ($res = $tarefa->retornaDados()):
                                        echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td>%s</td>',$res->nome);                                                               
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
                  								<input  name="id" type="text" class="form-control"  disabled value="<?php if($resbd) echo $resbd->id;?>">
        									</div>
                                            
                                            <div class="form-group">
                  								<label>Nome</label>
                  								<input  name="nome" type="text" class="form-control" disabled value="<?php if($resbd) echo $resbd->nome;?>">
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