<?php   
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    if ((!isset($tela)) && empty($_POST)) //não é modal, nem chamada convencional, logo.. acesso direto ao arquivo
        protegeArquivo(basename(__FILE__));
    else
    {
        if (!isset($tela)) //se tem a variabel POST, mas não tem a variavel tela, então é uma chamada modal
            $tela = 'modal';
            else
            {
                //verificando se há registros no BD, caso contrario abrirá a inserção.
                if ($tela =='listar')
                {
                    $qstatus = new status();
                    $qstatus->selecionaTudo($qstatus);
                    if ($qstatus->linhasafetadas <= 0)
                        $tela = 'incluir';
                }
                
                loadJS('jqueryvalidate');
                loadJS('jqueryvalidate-messages');
                loadCSS('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min','screen',true);
                loadJS('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',true);
            }
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
                        // se for usuário do tipo admin, vai criar um objeto com todos os parametros para edição, permitindo a definição e novos admins                                     
                        $status = new status(array(
                            'nome'=>$_POST['nome'],
                            'cor'=>$_POST['cor'],
                            'fechado'=>($_POST['fechado']=='on') ? 'S' : 'N',
                            'padrao_abertura'=>($_POST['padraoabertura']=='on') ? 'S' : 'N'                            
                            
                        ));
                        
                        $status->valorpk = $id;
                        $status->extras_select = "WHERE id=$id";
                        $status->selecionaTudo($status);
                        $res = $status->retornaDados();
                        
                        //se o NOME foi alterado do inicilamente carregado para o registro
                        if ($res->nome != $_POST['nome'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($status->existeRegistro('nome',$_POST['nome']))
                            {
                                printMSG('status já existe no sistema, escolha outro nome!','erro');
                                $duplicado = TRUE;
                            }
                        }

                        //se não existe vai atualizar normalmente
                        if ($duplicado!=TRUE)
                        {
                            $status->atualizar($status);
                            if ($status->linhasafetadas==1)
                            {
                                printMSG('Dados alterados com sucesso. <a href="?m=status&t=listar">Exibir cadastros</a>','sucesso');
                                unset($_POST);
                            }
							else                         
                            	printMSG('Nenhum dado foi alterado. <a href="?m=status&t=listar">Exibir cadastros</a>','alerta');
                        }
                                    
                    }
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição    
                    $statusbd = new status();
                    $statusbd->extras_select = "WHERE id=$id";
                    $statusbd->selecionaTudo($statusbd);
                    $resbd = $statusbd->retornaDados();
                }
                else
                    printMSG('status não definido, <a href="?m=status&t=listar">escolha um status para alterar</a>','erro');
                
                
                //formulário de edição de usuário   
                ?>
                    <script type="text/javascript">
                        $(document).ready(function(){                                    	                            
                                        				//color picker with addon
                                        				$('.my-colorpicker2').colorpicker()                                        
                                    				});
                    </script>
                    
                <div class="content-wrapper">
                <!-- Content Header (Page header) --> 
        
                <section class="content-header">
                	<h1>
                		Status
                		<small>Editar</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Status</a></li>
                		<li class="active">Editar</li>
                  	</ol>
                </section> 
    
                <!-- Main content -->
    			<section class="content">
      				<div class="row">
    	            <!-- left column -->
    					<div class="col-md-9">
                        <!-- general form elements -->
    						<div class="box box-primary">
    							<div class="box-header with-border">
    								<h3 class="box-title">Informe os dados para cadastro</h3>
    							</div>   	    							   							    						
    							<form class="userform" role="form" method="post" action="">
    								<div class="box-body">
        								<div class="row">
        									<div class="form-group">
        										<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="id" type="text" class="form-control input-sm" placeholder="Nome do status" value="<?php if($resbd) echo $resbd->id;?>">
                      							</div>        									
        									
            									<div class="col-xs-10">
                      								<label>Nome</label>
                      								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do status" value="<?php if($resbd) echo $resbd->nome;?>">
            									</div>                                        
            								</div>
        								</div> 
        								<div class="row">
        									<div class="form-group">        										      									        									
            									<div class="col-xs-4">
            										<label>Cor</label>
                                                    <div class="input-group my-colorpicker2">
                                                      <input name= "cor" type="text" class="form-control input-sm" value="<?php if($resbd) echo $resbd->cor;?>">
                                    
                                                      <div class="input-group-addon">
                                                        <i></i>
                                                      </div>
                                                    </div>                      								
            									</div>                                        
            								</div>
            								
            								<div class="col-xs-2">
            										<br>                      								
                      								<input type="checkbox" name="fechado"  <?php																			
																			
                																			if (strtoupper($resbd->fechado)=='S')
                																				echo ' checked';
                																		?> /><b> Fechado</b> 
                      								 
                      						</div>  
                      						<div class="col-xs-4">
            										<br>                      								
                      								<input type="checkbox" name="padraoabertura"  <?php																			
																			
                																			if (strtoupper($resbd->padrao_abertura)=='S')
                																				echo ' checked';
                																		?> /><b> Padrão de Abertura</b> 
                      								 
                      						</div> 
        								</div>                                
                                     </div>
                                      
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=status&t=listar'" >Cancelar</button>
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
              
                $status = new status(
                                        array(
                                        'nome'=>$_POST['nome'],
                                        'fechado'=>($_POST['fechado']=='on') ? 'S' : 'N',
                                        'cor'=>$_POST['cor'],
                                        'padrao_abertura'=>($_POST['padraoabertura']=='on') ? 'S' : 'N'    
                                        )
                                    ); 
             
            
                //verificando se ja existem registros com o parametro solicitado para inserção      
                if ($status->existeRegistro('nome',$_POST['nome'])) 
                {
                    printMSG('status já existe no sistema, escolha outro nome!','erro');
                    $duplicado = true;
                }
                               
                if ($duplicado!=true) 
                {
                    $status->inserir($status);
                   
                    if ($status->linhasafetadas==1)
                    {
                        printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=status&t=listar">Exibir Cadastros</a>','sucesso');   
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
                        	                            
                            //color picker with addon
                            $('.my-colorpicker2').colorpicker()
                            
                        }
                    );
			</script>
			<div class="content-wrapper">
                <!-- Content Header (Page header) --> 
        
                <section class="content-header">
                	<h1>
                		Status
                		<small>Incluir</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Status</a></li>
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
        								<div class="row">
        									<div class="form-group">
        										<div class="col-xs-2">
                      								<label>Código</label>
                      								<input disabled name="id" type="text" class="form-control input-sm"">
                      							</div>        									
        									
            									<div class="col-xs-10">
                      								<label>Nome</label>
                      								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do status" value="<?php echo $_POST['nome']?>">
            									</div>                                        
            								</div>
        								</div> 
        								<div class="row">
        									<div class="form-group">        										      									        									
            									<div class="col-xs-4">
            										<label>Cor</label>
                                                    <div class="input-group my-colorpicker2">
                                                      <input name="cor"  type="text" class="form-control input-sm" value="<?php echo $_POST['cor'];?>">
                                    
                                                      <div class="input-group-addon">
                                                        <i></i>
                                                      </div>
                                                    </div>                      								
            									</div>                                        
            								</div>
            								
            								<div class="col-xs-2">
            										<br>                      								
                      								<input  type="checkbox" name="fechado"  <?php																			
                                                                  								if ($_POST['fechado'])
                                                                  								    echo ' checked';                																			
                																		?> /><b> Fechado</b> 
                      								 
                      						</div> 
                      						<div class="col-xs-4">
            										<br>                      								
                      								<input type="checkbox" name="padraoabertura"  <?php																			
                                                                      								if ($_POST['padraoabertura'])
                                                                      								    echo ' checked';     
                																		?> /><b> Padrão de Abertura</b> 
                      								 
                      						</div>  
        								</div>                                
                                     </div>    								                      
                                  
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=status&t=listar'" >Cancelar</button>
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
            
            case 'modal':
                $duplicado = false;
                if(!empty($_POST))
                {
                    
                    $status = new status(array(
                        'nome'=>$_POST['nome']
                    ));
                    
                    
                    //verificando se ja existem registros com o parametro solicitado para inserção
                    if ($status->existeRegistro('nome',$_POST['nome']))
                    {
                        printMSG('status já existe no sistema, escolha outro nome!','erro');
                        $duplicado = true;
                    }
                    
                    if ($duplicado!=true)
                    {
                        $status->inserir($status);
                        if ($status->linhasafetadas==1)
                        {
                            $lastid = $status->lastId;
                            
                            
                            $qstatus = new status();
                            $qstatus->extras_select = " order by nome";
                            $qstatus->selecionaTudo($qstatus);
                            
                            while ($res = $qstatus->retornaDados())
                            {
                                $row = array();
                                $row["id"] = $res->id;
                                $row["nome"] = $res->nome;
                                if ($lastid==$res->id)
                                    $row["lastid"] = true;
                                    else
                                        $row["lastid"] = false;
                                        
                                        $ddata[] = $row;
                            }
                            
                            $output = array(
                                "jstatus" => $ddata,
                            );
                            
                            header('Content-type: application/json');
                            echo json_encode($output);
                            
                            unset($_POST);
                            
                        }
                                                
                    }
                }
                break;
        case 'listar':
                			       
            ?>
            <div class="content-wrapper">             
                <!-- Content Header (Page header) -->
    		    <section class="content-header">
    		      <h1>
    		        Status
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> Status</a></li>
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
                              			<th>Fechado</th>
                              			<th>Padrão Abertura</th>
                              			<th>Cor</th>
                              			<th>Ações</th>                  
                            		</tr>
                            	</thead>
                            	<tbody>
                                    <?php 
                                    $status = new status();
                                    $status->selecionaTudo($status);                       					                                              
                                    while ($res = $status->retornaDados()):
                                        echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td>%s</td>',$res->nome);
                                        printf('<td>%s</td>',(strtoupper($res->fechado=='S') ? 'Sim' : 'Não'));
                                        printf('<td>%s</td>',(strtoupper($res->padrao_abertura=='S') ? 'Sim' : 'Não'));
                                        printf('<td bgcolor="%s">%s</td>',$res->cor,$res->cor);
                                        printf('<td><a href="?m=status&t=incluir" title="Novo"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=status&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a><a href="?m=status&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id);
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
                        $status = new status();
                        $status->valorpk =$id;                   
                                                
                        
                        $status->deletar($status);
                        if ($status->linhasafetadas==1)
                        {
                            printMSG('Registro excluído com sucesso. <a href="?m=status&t=listar">Exibir cadastros</a>','sucesso');                                                     
                            unset($_POST);                           
                        }
                        else 
                            printMSG('Nenhum dado foi excluído. <a href="?m=status&t=listar">Exibir cadastros</a>','alerta');
                        
                    } //final isset $_POST['excluir']
                    $statusbd = new status();
                    $statusbd->extras_select = "where id=$id";
                    $statusbd->selecionaTudo($statusbd);
                    $resbd = $statusbd->retornaDados();                   
                }//final isset $_GET['id']
                else
                    printMSG('status não definido, <a href="?status&t=listar">escolha um status para excluir</a>','erro');
                
                //formulário de edição de status   
                ?> 
                <script type="text/javascript">
                        $(document).ready(function(){
                                    	                            
                                        //color picker with addon
                                        $('.my-colorpicker2').colorpicker()
                                        
                                    });
                                                        
                </script>  
                <div class="content-wrapper">                                 
                        <section class="content-header">
                        	<h1>
                        		Status
                        		<small>Excluir</small>
                          	</h1>
                          	<ol class="breadcrumb">
                        		<li><a ><i class="fa fa-dashboard"></i> Status</a></li>
                        		<li class="active">Excluir</li>
                          	</ol>
                        </section>                            
        	    
        				<section class="content">
          					<div class="row">
        	                   <!-- left column -->
        						<div class="col-md-9">
                                    <!-- general form elements -->
        								<div class="box box-primary">        									        							
        							         <!-- form start -->	
        									<form class="userform" role="form" method="post" action="">
        										<div class="box-body">
            										<div class="row">
            											<div class="form-group">
            												<div class="col-xs-2">
                          										<label>Código</label>
                          										<input disabled name="id" type="text" class="form-control input-sm" placeholder="Nome do status" value="<?php if($resbd) echo $resbd->id;?>">
                          									</div>        									
            									
                											<div class="col-xs-10">
                          										<label>Nome</label>
                          										<input disabled name="nome" type="text" class="form-control input-sm" placeholder="Nome do status" value="<?php if($resbd) echo $resbd->nome;?>">
                											</div>                                        
                										</div>
            										</div>         										
            										<div class="row">
            											<div class="form-group">        										      									        									
                											<div class="col-xs-4">
                												<label>Cor</label>
                                                        		<div class="input-group my-colorpicker2">
                                                          			<input disabled name= "cor" type="text" class="form-control input-sm" value="<?php if($resbd) echo $resbd->cor;?>">                                        
                                                          			<div class="input-group-addon">
                                                            			<i></i>
                                                          			</div>
                                                        		</div>                      								
                											</div>                                        
                										</div>                								
                										
                										<div class="col-xs-2">
                											<br>                      								
                          									<input disabled type="checkbox" name="fechado"  <?php																			   																			
                    										              									if (strtoupper($resbd->fechado)=='S')
                    														          						echo ' checked';
                    																	           	?> /><b> Fechado</b> 
                          								 
                          								</div>  
                          								<div class="col-xs-2">
                        										<br>                      								
                                  								<input type="checkbox" name="padraoabertura"  <?php																			
            																			
                            																			if (strtoupper($resbd->padrao_abertura)=='S')
                            																				echo ' checked';
                            																		?> /><b> Default Abertura</b> 
                                  								 
                                  						</div> 
            										</div>                                 
                                     			</div> li<!-- final box body -->                               
                                      
                								<div class="box-footer">  
                									 <button type="button" class="btn btn-default" onclick="location.href='?m=status&t=listar'" >Cancelar</button>
                									 <button type="submit" name="excluir" class="btn btn-info pull-right">Confirmar exclusão</button>  									                									 
                								</div>                              
        										</form>
        		 						</div><!-- Final box-primary -->
        						</div><!-- Final col-md-9 -->
        					</div>
        				</section>
                    <!-- /.content -->
    			</div> <!-- content-wrapper -->         			                                  
                    
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
        
        default:
            echo '<p> A tela solicitada não existe </p>';
            break;
    }