<?php 	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jqueryvalidate');
	loadJS('jqueryvalidate-messages');
	switch ($tela) 
	{
		case 'login':
			//caso esteja 'logado', nao permite voltar para o form de login e redireciona para o painel.php
			$sessao = new sessao();			
			if (($sessao->getNvars()>0) || ($sessao->getVar('logado')==TRUE)||($sessao->getVar('ip')==$_SERVER['REMOTE_ADDR']))
				redireciona('painel.php');
			 
			//se o botão login foi clicado, entao a função doLogin será executada		
			if (isset($_POST['logar'])) 
			{
			        
            	$user = new usuario();
				$user->setValor('login',$_POST['usuario']);
				$user->setValor('senha',$_POST['senha']);
                
				
				if ($user->doLogin($user))                 
                    redireciona('painel.php');                
				else		
				    redireciona('?erro=2');
					//print_r($user);//
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
										usuario:{required:true,minlength:3},
										senha:{required:true,rangelength:[4,10]},
									}
								}
							)
							
						}
					);
				</script>	
				
				<div class="login-box">
                  <div class="login-logo">
                    <a><b>Painel</b>CERAT</a>
                  </div>
                  <!-- /.login-logo -->
                  <div class="login-box-body">
                    <p class="login-box-msg">Acesso restrito, idenfique-se</p>
                
                    <form class="userform" method="post" action="">
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Usuário" name="usuario" value="<?php echo $_POST['usuario']; ?>"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Senha" name="senha" value="<?php echo $_POST['senha'];?>"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="row">
                        <div class="col-xs-8">
                          <div class="checkbox icheck">
                            <label>
                              <input type="checkbox"> Memorizar
                            </label>
                          </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                          <button type="submit" name="logar" value="login" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div>
                        <!-- /.col -->
                      </div>
                      <?php 
								$erro = $_GET['erro'];
								switch ($erro) 
								{
									case 1:
										echo '<div class="sucesso"> Você fez logoff do sistema. </div>';
										break;
									case 2:
										echo '<div class="erro"> Dados incorretos ou usuário inativo. </div>';
										break;
									case 3:
										echo '<div class="erro"> Faça login antes de acessar a página solicitada. </div>';
										break;									
								}								
						?>
                    </form>                                                   
                  </div>
                  <!-- /.login-box-body -->
                </div>
                <!-- /.login-box -->
					
				
									
			<?php				
			break;
			
		case 'editar':			           
			$sessao = new sessao();
            
            //verificando se o usuário logado é admin, ou é o dono do cadastro            
            if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
			{
			    //se possui ID definido no roteamento, pois se não tiver indica que o usuário tentou 'entrar direto na página'    
			    if (isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    
                    //verificando se ele escolheu a botão 'editar' 
                    if (isset($_POST['editar']))
                    {
                        // se for usuário do tipo admin, vai criar um objeto com todos os parametros para edição, permitindo a definição e novos admins         
                        if(isAdmin()==TRUE)
                        {    
                            $user = new usuario(array(
                                'nome'=>$_POST['nome'],
                                'email'=>$_POST['email'],
                                'ativo'=>($_POST['ativo']=='on') ? 's' : 'n',
                                'administrador'=>($_POST['adm']=='on') ? 's' : 'n',
                            ));
                        }
                        else //senão vai criar um objeto com campos limitados para edição
                        {    
                            $user = new usuario(array(
                                'nome'=>$_POST['nome'],
                                'email'=>$_POST['email'],
                            ));
                        }
                        $user->valorpk = $id;
                        $user->extras_select = "WHERE id=$id";
                        $user->selecionaTudo($user);
                        $res = $user->retornaDados();
                        
                        //se o email foi alterado do inicilamente carregado para o registro
                        if ($res->email != $_POST['email'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($user->existeRegistro('email',$_POST['email']))
                            {
                                printMSG('Este email já existe no sistema, escolha outro endereço!','erro');
                                $duplicado = TRUE;
                            }
                        }

                        //se não existe vai atualizar normalmente
                        if ($duplicado!=TRUE)
                        {
                            $user->atualizar($user);
                            if ($user->linhasafetadas==1)
                            {
                                printMSG('Dados alterados com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','sucesso');
                                unset($_POST);
                            }
                            else
                              printMSG('Nenhum dado foi alterado. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','alerta');
                        }
                                    
                    }
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição    
                    $userbd = new usuario();
                    $userbd->extras_select = "WHERE id=$id";
                    $userbd->selecionaTudo($userbd);
                    $resbd = $userbd->retornaDados();
                }
                else
                    printMSG('Usuário não definido, <a href="?m=usuarios&t=listar">escolha um usuário para alterar</a>','erro');
                
				
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
											nome:{required:true,minlength:3},
											email:{required:true,email:true}											
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
                    			Usuários
                    			<small>Editar</small>
                    		</h1>
                    		<ol class="breadcrumb">
                    			<li><a ><i class="fa fa-dashboard"></i> Usuários</a></li>
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
                    					<div class="box-header with-border">
                    						<h3 class="box-title">Informe os dados para alteração</h3>
                    					</div>   	
                    					
                    					<!-- form start -->	
                    					<form name="userform" role="form" method="post" action="">
                    						<div class="box-body">
                    							<div class="form-group">
                    								<label>Código</label>
                    								<input disabled name="id" type="text" class="form-control input-sm" placeholder="Código do Usuário" value="<?php if($resbd) echo $resbd->id;?>">
                    							</div>
                    							
                    							<div class="form-group">
                    								<label>Nome</label>
                    								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do Usuário" value="<?php if($resbd) echo $resbd->nome;?>">
                    							</div>
                    							
                    							
                    							<div class="form-group">
                    								<label>Email</label>
                    								<input name="email" type="email" class="form-control input-sm" placeholder="Email do usuário" value="<?php if($resbd) echo $resbd->email;?>">
                    							</div>
                    							
                    							<div class="form-group">
                    								<label>Email</label>
                    								<input disabled name="login" type="text" class="form-control input-sm" placeholder="Login do usuário" value="<?php if($resbd) echo $resbd->login;?>">
                    							</div>
                    							
                                                <div class="form-group">
                                                	<label for="ativo">Ativo:</label>
                                                	<label>
                                                 		 <input type="checkbox" name="ativo"  <?php
																			if (!isAdmin())
																				echo ' disabled';
																			
																			if (strtoupper($resbd->ativo)=='S')
																				echo ' checked';
																		?> />Habilitar ou desabilitar o usuário     		 
                                               		 </label>                                                
                    							</div>    
                    							
                    							<div class="form-group">
                                                	<label for="adm">Administrador:</label>
                                                	<label>
                                                 		 <input type="checkbox"  name="adm"  <?php
                                                                 		 if (!isAdmin())
                                                                 		     echo ' disabled';
                                                             		     
                                                             		     if (strtoupper($resbd->administrador) == 'S')
                                                             		         echo ' checked';
																		?> />dar controle total ao usuário     		 
                                               		 </label>                                                
                    							</div>                             
                    					  
                    						<div class="box-footer">  
                    							 <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'" >Cancelar</button>
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
				$user = new usuario(
										array(
										'nome'=>$_POST['nome'],
										'email'=>$_POST['email'],
										'login'=>$_POST['login'],
										'senha'=>codificaSenha($_POST['senha']),
										'administrador'=>($_POST['adm']=='on')?'S':'N',
										'ativo'=>'S',
										'datacad'=>date('d/m/y')
										)
									); 
			 
			
				//verificando se ja existem registros com o parametro solicitado para inserção		
				if ($user->existeRegistro('login',$_POST['login'])) 
				{
					printMSG("Este login já esta sendo utilizado, escolha outro nome de usuário.",'erro');
					$duplicado = true;
				}
				else if ($user->existeRegistro('email',$_POST['email'])) 
				{
					printMSG("Este email já esta sendo utilizado, escolha outro endereço.",'erro');
					$duplicado = true;
				}
				
				if ($duplicado!=true) 
				{
					$user->inserir($user);
					if ($user->linhasafetadas==1)
					{
						printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=usuarios&t=listar">Exibir Cadastros</a>','sucesso');
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
										nome:{required:true,minlength:3},
										email:{required:true,email:true},
										login:{required:true,minlength:5},
										senha:{required:true,rangelength:[4,10]},
										senhaconf:{required:true,equalTo:"#senha"}
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
                    			Usuários
                    			<small>Editar</small>
                    		</h1>
                    		<ol class="breadcrumb">
                    			<li><a ><i class="fa fa-dashboard"></i> Usuários</a></li>
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
                    					<div class="box-header with-border">
                    						<h3 class="box-title">Informe os dados para cadastro</h3>
                    					</div>   	
                    					
                    					<!-- form start -->	
                    					<form name="userform" role="form" method="post" action="">
                    						<div class="box-body">                    							                    							
                    							<div class="form-group">
                    								<label>Nome</label>
                    								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do usuário" value="<?php echo $_POST['nome'];?>">
                    							</div>                    							
                    							
                    							<div class="form-group">
                    								<label>Email</label>
                    								<input name="email" type="email" class="form-control input-sm" placeholder="Email do usuário" value="<?php echo $_POST['email'];?>">
                    							</div>
                    							
                    							<div class="form-group">
                    								<label>Login</label>
                    								<input name="login" type="text" class="form-control input-sm" placeholder="Login do usuário" value="<?php $_POST['login'];?>">
                    							</div>
                    							
                    							<div class="form-group">
                                                  	<label for="senha">Senha</label>
                                                  	<input name="senha" id="senha" type="password" class="form-control input-sm" placeholder="Senha" value="<?php echo $_POST['senha'];?>">
                                                </div>
                                                
                                                <div class="form-group">
                                                  	<label for="senhaconf">Repita a senha</label>
                                                  	<input name="senhaconf" id="senhaconf" type="password" class="form-control input-sm" placeholder="Senha" value="<?php echo $_POST['senhaconf'];?>">
                                                </div>                    							                                                
                    							
                    							<div class="form-group">
                                                	<label for="adm">Administrador:</label>
                                                	<label>
                                                 		 <input type="checkbox"  name="adm"  <?php
                                                                 		 if (!isAdmin())
                                                                 		     echo ' disabled';
                                                             		     
                                                                 		 if ($_POST['adm'])
                                                             		         echo ' checked';
																		?> />dar controle total ao usuário     		 
                                               		 </label>                                                
                    							</div>                             
                    					  
                    						<div class="box-footer">  
                    							 <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'" >Cancelar</button>
                    							 <button type="submit" name="cadastrar" class="btn btn-info pull-right">Salvar Dados</button>  									
                    							 
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
    		        Usuários
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> Usuários</a></li>
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
                              			<th>Email</th>
                              			<th>Login</th>
                              			<th>Ativo/Adm</th>
                              			<th>Cadastro</th>
                              			<th>Ações</th>                  
                            		</tr>
                            	</thead>
                            	<tbody>
                                    <?php 
                                    $user = new usuario();
                                    $user->selecionaTudo($user);
                                    while ($res = $user->retornaDados()):
                                    echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td>%s</td>',$res->nome);
                                        printf('<td>%s</td>',$res->email);
                                        printf('<td>%s</td>',$res->login);
                                        printf('<td class="center">%s/%s</td>',strtoupper($res->ativo),strtoupper($res->administrador));
                                        printf('<td class="center">%s</td>',date("d/m/Y",strtotime($res->datacad)));
                                        printf('<td class="center"><a href="?m=usuarios&t=incluir" title="Novo cadastro"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=usuarios&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a> <a href="?m=usuarios&t=senha&id=%s" title="Mudar senha"><img src="images/pass.png" alt="Mudar senha" /></a> <a href="?m=usuarios&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id,$res->id);
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
                            		</tr>
                            	</tfoot>
                        	</table>
            			</div><!-- /.box -->                    
            		</div><!-- /.box-body -->
            	</section> <!-- /.Main content -->           
			</div> <!-- /.content-wrapper -->				  			
			<?php
			break;	
			
case 'senha':
			echo '<h2>Alteração de Senha</h2>';
			$sessao = new sessao();
			if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
			{
				if (isset($_GET['id'])) 
				{
					$id = $_GET['id'];
					
					//iniciando processo de salvamento se o usuário deu POST
					if (isset($_POST['mudasenha']))
					{
						$user = new usuario(array(
							'senha'=>codificaSenha($_POST['senha'])															
						));
						$user->valorpk =$id;															
						$user->atualizar($user);
						if ($user->linhasafetadas==1)
						{
							printMSG('Senha alterada com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','sucesso');
							unset($_POST);
						}
						else 
							printMSG('Nenhum dado foi alterado. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','alerta');
						
					} //final isset $_POST['mudasenha']
					$userbd = new usuario();
					$userbd->extras_select = "where id=$id";
					$userbd->selecionaTudo($userbd);
					$resbd = $userbd->retornaDados();					
				}//final isset $_GET['id']
                else
					printMSG('Usuário não definido, <a href="?usuarios&t=listar">escolha um usuário para alterar</a>','erro');
				
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
											senha:{required:true,rangelength:[4,10]},
											senhaconf:{required:true,equalTo:"#senha"}										
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
            			Usuários
            			<small>Alterar Senha</small>
            		</h1>
            		<ol class="breadcrumb">
            			<li><a ><i class="fa fa-dashboard"></i> Usuários</a></li>
            			<li class="active">Alterar Senha</li>
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
            						<h3 class="box-title">Informe os dados para alteração</h3>
            					</div>   	
            					
            					<!-- form start -->	
            					<form name="userform" role="form" method="post" action="">
            						<div class="box-body">
            							<div class="form-group">
            								<label>Código</label>
            								<input disabled name="id" type="text" class="form-control input-sm" placeholder="Código do Usuário" value="<?php if($resbd) echo $resbd->id;?>">
            							</div>
            							
            							<div class="form-group">
            								<label>Nome</label>
            								<input disabled name="nome" type="text" class="form-control input-sm" placeholder="Nome do Usuário" value="<?php if($resbd) echo $resbd->nome;?>">
            							</div>
            							
            							
            							<div class="form-group">
            								<label>Email</label>
            								<input disabled name="email" type="email" class="form-control input-sm" placeholder="Email do usuário" value="<?php if($resbd) echo $resbd->email;?>">
            							</div>
            							
            							<div class="form-group">
            								<label>Login</label>
            								<input disabled disabled name="login" type="text" class="form-control input-sm" placeholder="Login do usuário" value="<?php if($resbd) echo $resbd->login;?>">
            							</div>
            							
                                        <div class="form-group">
                                          	<label for="senha">Senha</label>
                                          	<input name="senha" id="senha" type="password" class="form-control input-sm" placeholder="Senha" value="<?php echo $_POST['senha'];?>">
                                        </div>
                                        
                                        <div class="form-group">
                                          	<label for="senhaconf">Repita a senha</label>
                                          	<input name="senhaconf" id="senhaconf" type="password" class="form-control input-sm" placeholder="Senha" value="<?php echo $_POST['senhaconf'];?>">
                                        </div>                           
            					  
            						<div class="box-footer">  
            							 <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'" >Cancelar</button>
            							 <button type="submit" name="mudasenha" class="btn btn-info pull-right">Salvar Alterações</button>  									            							 
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
                        $user = new usuario();
                        $user->valorpk =$id;                   
                                                
                        
                        $user->deletar($user);
                        if ($user->linhasafetadas==1)
                        {
                            printMSG('Registro excluído com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','sucesso');
                            unset($_POST);
                        }
                        else 
                            printMSG('Nenhum dado foi excluído. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','alerta');
                        
                    } //final isset $_POST['excluir']
                    $userbd = new usuario();
                    $userbd->extras_select = "where id=$id";
                    $userbd->selecionaTudo($userbd);
                    $resbd = $userbd->retornaDados();                   
                }//final isset $_GET['id']
                else
                    printMSG('Usuário não definido, <a href="?usuarios&t=listar">escolha um usuário para excluir</a>','erro');
                
                //formulário de edição de usuário   
                ?>    
                	<div class="content-wrapper">
                    	<!-- Content Header (Page header) --> 
                    
                    	<section class="content-header">
                    		<h1>
                    			Usuários
                    			<small>Excluir</small>
                    		</h1>
                    		<ol class="breadcrumb">
                    			<li><a ><i class="fa fa-dashboard"></i> Usuários</a></li>
                    			<li class="active">Exlcuir</li>
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
                    						<h3 class="box-title">Informe os dados para alteração</h3>
                    					</div>   	
                    					
                    					<!-- form start -->	
                    					<form name="userform" role="form" method="post" action="">
                    						<div class="box-body">
                    							<div class="form-group">
                    								<label>Código</label>
                    								<input disabled name="id" type="text" class="form-control input-sm" placeholder="Código do Usuário" value="<?php if($resbd) echo $resbd->id;?>">
                    							</div>
                    							
                    							<div class="form-group">
                    								<label>Nome</label>
                    								<input disabled name="nome" type="text" class="form-control input-sm" placeholder="Nome do Usuário" value="<?php if($resbd) echo $resbd->nome;?>">
                    							</div>
                    							
                    							
                    							<div class="form-group">
                    								<label>Email</label>
                    								<input disabled name="email" type="email" class="form-control input-sm" placeholder="Email do usuário" value="<?php if($resbd) echo $resbd->email;?>">
                    							</div>
                    							
                    							<div class="form-group">
                    								<label>Login</label>
                    								<input disabled disabled name="login" type="text" class="form-control input-sm" placeholder="Login do usuário" value="<?php if($resbd) echo $resbd->login;?>">
                    							</div>
                    							
                                                <div class="form-group">
                                                	<label for="ativo">Ativo:</label>
                                                	<label>
                                                 		 <input disabled type="checkbox" name="ativo"  <?php
																			if (!isAdmin())
																				echo ' disabled';
																			
																			if (strtoupper($resbd->ativo)=='S')
																				echo ' checked';
																		?> />Habilitar ou desabilitar o usuário     		 
                                               		 </label>                                                
                    							</div>    
                    							
                    							<div class="form-group">
                                                	<label for="adm">Administrador:</label>
                                                	<label>
                                                 		 <input disabled type="checkbox"  name="adm"  <?php
                                                                 		 if (!isAdmin())
                                                                 		     echo ' disabled';
                                                             		     
                                                             		     if (strtoupper($resbd->administrador) == 'S')
                                                             		         echo ' checked';
																		?> />dar controle total ao usuário     		 
                                               		 </label>                                                
                    							</div>                             
                    					  
                    						<div class="box-footer">  
                    							 <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'" >Cancelar</button>
                    							 <button type="submit" name="excluir" class="btn btn-info pull-right">Confirmar exclusão</button>  									
                    							 
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
        
		default:
			echo '<p> A tela solicitada não existe </p>';
			break;
	}