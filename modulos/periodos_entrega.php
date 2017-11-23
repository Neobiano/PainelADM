<?php   
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    protegeArquivo(basename(__FILE__));
    loadJS('jqueryvalidate');
    loadJS('jqueryvalidate-messages');
    loadCSS('bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min','screen',true);
    loadJS('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',true);
    
	
    //verificando se há registros no BD, caso contrario abrirá a inserção.
    if ($tela =='listar')
    {
        $qperiodos_entrega = new periodos_entrega();
        $qperiodos_entrega->selecionaTudo($qperiodos_entrega);
        if ($qperiodos_entrega->linhasafetadas <= 0)
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
                        // se for usuário do tipo admin, vai criar um objeto com todos os parametros para edição, permitindo a definição e novos admins                                     
                        $periodos_entrega = new periodos_entrega(array(
                            'nome'=>$_POST['nome'],
                            'cor'=>$_POST['cor'],
                            'inter_ini'=>$_POST['interini'],
                            'inter_fim'=>$_POST['interini'],
                                                        
                            
                        ));
                        
                        $periodos_entrega->valorpk = $id;
                        $periodos_entrega->extras_select = "WHERE id=$id";
                        $periodos_entrega->selecionaTudo($periodos_entrega);
                        $res = $periodos_entrega->retornaDados();
                        
                        //se o NOME foi alterado do inicilamente carregado para o registro
                        if ($res->nome != $_POST['nome'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($periodos_entrega->existeRegistro('nome',$_POST['nome']))
                            {
                                printMSG('Período definido já existe no sistema, escolha outro nome!','erro');
                                $duplicado = TRUE;
                            }
                        }

                        //se não existe vai atualizar normalmente
                        if ($duplicado!=TRUE)
                        {
                            $periodos_entrega->atualizar($periodos_entrega);
                            if ($periodos_entrega->linhasafetadas==1)
                            {
                                printMSG('Dados alterados com sucesso. <a href="?m=periodos_entrega&t=listar">Exibir cadastros</a>','sucesso');
                                unset($_POST);
                            }
							else                         
                            	printMSG('Nenhum dado foi alterado. <a href="?m=periodos_entrega&t=listar">Exibir cadastros</a>','alerta');
                        }
                                    
                    }
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição    
                    $periodos_entregabd = new periodos_entrega();
                    $periodos_entregabd->extras_select = "WHERE id=$id";
                    $periodos_entregabd->selecionaTudo($periodos_entregabd);
                    $resbd = $periodos_entregabd->retornaDados();
                }
                else
                    printMSG('periodos_entrega não definido, <a href="?m=periodos_entrega&t=listar">escolha um periodos_entrega para alterar</a>','erro');
                
                
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
                		Períodos de Entrega
                		<small>Editar</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Períodos de Entrega</a></li>
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
                      								<input disabled name="id" type="text" class="form-control input-sm" placeholder="Código é Automático" value="<?php if($resbd) echo $resbd->id;?>">
                      							</div>        									
        									
            									<div class="col-xs-10">
                      								<label>Nome</label>
                      								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do Período" value="<?php if($resbd) echo $resbd->nome;?>">
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
        								</div>                                
                                     </div>
                                      
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=periodos_entrega&t=listar'" >Cancelar</button>
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
              
                $periodos_entrega = new periodos_entrega(
                                        array(
                                        'nome'=>$_POST['nome'],
                                        'fechado'=>($_POST['fechado']=='on') ? 'S' : 'N',
                                        'cor'=>$_POST['cor'],
                                        'padrao_abertura'=>($_POST['padraoabertura']=='on') ? 'S' : 'N'    
                                        )
                                    ); 
             
            
                //verificando se ja existem registros com o parametro solicitado para inserção      
                if ($periodos_entrega->existeRegistro('nome',$_POST['nome'])) 
                {
                    printMSG('periodos_entrega já existe no sistema, escolha outro nome!','erro');
                    $duplicado = true;
                }
                               
                if ($duplicado!=true) 
                {
                    $periodos_entrega->inserir($periodos_entrega);
                   
                    if ($periodos_entrega->linhasafetadas==1)
                    {
                        printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=periodos_entrega&t=listar">Exibir Cadastros</a>','sucesso');   
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
                		periodos_entrega
                		<small>Incluir</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> periodos_entrega</a></li>
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
                      								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do periodos_entrega" value="<?php echo $_POST['nome']?>">
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
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=periodos_entrega&t=listar'" >Cancelar</button>
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
    		        periodos_entrega
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> periodos_entrega</a></li>
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
                                    $periodos_entrega = new periodos_entrega();
                                    $periodos_entrega->selecionaTudo($periodos_entrega);                       					                                              
                                    while ($res = $periodos_entrega->retornaDados()):
                                        echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td>%s</td>',$res->nome);
                                        printf('<td>%s</td>',(strtoupper($res->fechado=='S') ? 'Sim' : 'Não'));
                                        printf('<td>%s</td>',(strtoupper($res->padrao_abertura=='S') ? 'Sim' : 'Não'));
                                        printf('<td bgcolor="%s">%s</td>',$res->cor,$res->cor);
                                        printf('<td><a href="?m=periodos_entrega&t=incluir" title="Novo"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=periodos_entrega&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a><a href="?m=periodos_entrega&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id);
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
                        $periodos_entrega = new periodos_entrega();
                        $periodos_entrega->valorpk =$id;                   
                                                
                        
                        $periodos_entrega->deletar($periodos_entrega);
                        if ($periodos_entrega->linhasafetadas==1)
                        {
                            printMSG('Registro excluído com sucesso. <a href="?m=periodos_entrega&t=listar">Exibir cadastros</a>','sucesso');                                                     
                            unset($_POST);                           
                        }
                        else 
                            printMSG('Nenhum dado foi excluído. <a href="?m=periodos_entrega&t=listar">Exibir cadastros</a>','alerta');
                        
                    } //final isset $_POST['excluir']
                    $periodos_entregabd = new periodos_entrega();
                    $periodos_entregabd->extras_select = "where id=$id";
                    $periodos_entregabd->selecionaTudo($periodos_entregabd);
                    $resbd = $periodos_entregabd->retornaDados();                   
                }//final isset $_GET['id']
                else
                    printMSG('periodos_entrega não definido, <a href="?periodos_entrega&t=listar">escolha um periodos_entrega para excluir</a>','erro');
                
                //formulário de edição de periodos_entrega   
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
                        		periodos_entrega
                        		<small>Excluir</small>
                          	</h1>
                          	<ol class="breadcrumb">
                        		<li><a ><i class="fa fa-dashboard"></i> periodos_entrega</a></li>
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
                          										<input disabled name="id" type="text" class="form-control input-sm" placeholder="Nome do periodos_entrega" value="<?php if($resbd) echo $resbd->id;?>">
                          									</div>        									
            									
                											<div class="col-xs-10">
                          										<label>Nome</label>
                          										<input disabled name="nome" type="text" class="form-control input-sm" placeholder="Nome do periodos_entrega" value="<?php if($resbd) echo $resbd->nome;?>">
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
                									 <button type="button" class="btn btn-default" onclick="location.href='?m=periodos_entrega&t=listar'" >Cancelar</button>
                									 <button type="submit" name="excluir" class="btn btn-info pull-right">Confirmar exclusão</button>  									                									 
                								</div>                              
        										</form>
        		 						</div><!-- Final box-primary -->
        						</div><!-- Final col-md-9 -->
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