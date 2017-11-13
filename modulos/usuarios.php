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
					print_r($user);//redireciona('?erro=2');
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
				<div id="loginform">
					<form class="userform" method="post" action="">
						<fieldset>
							<legend>Acesso restrito, idenfique-se</legend>
							<ul>
								<li>
									<label  for="usuario">Usuário:</label>
									<input type="text" size="35" name="usuario" value="<?php echo $_POST['usuario']; ?>" />
								</li>
								<li>
									<label for="senha">Senha:</label>
									<input  type="password" size="35" name="senha" value="<?php echo $_POST['senha'];?>"/>
								</li>
								<li class="center">	
									<input type="submit" name="logar" value="login"/>		
								</li>
							</ul>
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
						</fieldset>
					</form>
				</div>
									
			<?php				
			break;
			
		case 'editar':
			echo '<h2>Edição de Usuários</h2>';           
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
                        if ($res->EMAIL != $_POST['email'])
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
                                printMSG('Dados alterados com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>');
                                unset($_POST);
                            }
                            
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
					<form class="userform" method="post" action="">
						<fieldset>
							<legend>Informe os dados para alteração</legend>
							<ul>
								<li>
									<label for="nome">Nome:</label>
									<input type="text" size="50" name="nome" value="<?php if($resbd) echo $resbd->nome; ?>"/>
								</li>
								<li>
									<label for="email">Email:</label>
									<input type="text" size="50" name="email" value="<?php if($resbd) echo $resbd->email; ?>"/>
								</li>
								<li>
									<label for="login" >Login:</label>
									<input type="text" size="35" name="login" disabled="disabled" value="<?php if($resbd) echo $resbd->login; ?>"/>
								</li>								
								<li>
									<label for="ativo">Ativo:</label>
									<input type="checkbox" name="ativo" <?php
																			if (!isAdmin())
																				echo 'disabled="disabled"';
																			
																			if ($resbd->ativo=='s')
																				echo 'checked="checked"';
																		?> />Habilitar ou desabilitar o usuário
								</li>								
								<li>
									<label for="adm">Administrador:</label>
									<input type="checkbox" name="adm" <?php
																			if (!isAdmin())
																				echo 'disabled="disabled"';
																			
																			if ($resbd->administrador == 's')
																				echo 'checked="checked"';
																		?> />dar controle total ao usuário
								</li>
								<li class="center">
									<input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
									<input type="submit" name="editar" value="Salvar Alterações"/>
								</li>
							</ul>
						</fieldset>
					</form>
					
				<?php	
			}//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
			else
				printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
		break;		
			
		case 'incluir':
			echo '<h2>Cadastro de Usuários</h2>';
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
						printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=usuarios&t=listar">Exibir Cadastros</a>');
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
			<form class="userform" method="post" action="">
				<fieldset>
					<legend>Informe os dados para cadastro</legend>
					<ul>
						<li>
							<label for="nome">Nome:</label>
							<input type="text" size="50" name="nome" value="<?php echo $_POST['nome']?>"/>
						</li>
						<li>
							<label for="email">Email:</label>
							<input type="text" size="50" name="email" value="<?php echo $_POST['email']?>"/>
						</li>
						<li>
							<label for="login">Login:</label>
							<input type="text" size="35" name="login" value="<?php echo $_POST['login']?>"/>
						</li>
						<li>
							<label for="senha">Senha:</label>
							<input type="password" size="25" name="senha" id="senha" value="<?php echo $_POST['senha']?>"/>
						</li>
						<li>
							<label for="senhaconf">Repita a senha:</label>
							<input type="password" size="25" name="senhaconf" value="<?php echo $_POST['senhaconf']?>"/>
						</li>
						<li>
							<label for="adm">Administrador:</label>
							<input type="checkbox" name="adm" <?php
																	if (!isAdmin())
																		echo 'disabled="disabled"';
																	
																	if ($_POST['adm'])
																	 	echo 'checked="checked"';
																?> />dar controle total ao usuário
						</li>
						<li class="center">
							<input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
							<input type="submit" name="cadastrar" value="Salvar dados"/>
						</li>
					</ul>
				</fieldset>
			</form>
			<?php
			break;
		
		case 'listar':
			echo '<h2>Usuários cadastrados</h2>';
	        loadCSS('data-table',NULL,TRUE);          
	        ?>
	        <script type="text/javascript">
	            $(document).ready(function(){
	               $("#listausers").dataTable({
	                "oLanguage": {
	                    "sZeroRecords": "Nenhum dado econtrado para exibição",
	                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ de registros",
	                    "sInfoEmpty": "Nenhum registro para ser exibido",
	                    "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
	                    "sSearch": "Pesquisar",
	                },
	                	
	                "bPaginate": false,
	                "aaSorting": [[0, "asc"]] 
	               }); 
	            });
	        </script>
	        <table cellspacing="0" cellpadding="0" border="0" class="display" id="listausers">
	            <thead>
	                <tr>
	                    <th>Nome</th><th>Email</th><th>Login</th><th>Ativo/Adm</th><th>Cadastro</th><th>Ações</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                $user = new usuario();
	                $user->selecionaTudo($user);                	                                
	                while ($res = $user->retornaDados()):
	                    echo '<tr>';
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
	        </table>
			
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
							printMSG('Senha alterada com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>');
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
					<body class="hold-transition login-page">
						<div class="login-box">
						  <div class="login-logo">
						    <a href="../../index2.html"><b>Admin</b>LTE</a>
						  </div>
						  <!-- /.login-logo -->
						  <div class="login-box-body">
						    <p class="login-box-msg">Sign in to start your session</p>
					<form class="userform" method="post" action="">
						<fieldset>
							<legend>Informe os dados para alteração</legend>
							<ul>
								<li>
									<label for="nome">Nome:</label>
									<input type="text" size="50" name="nome" disabled="disabled" value="<?php if($resbd) echo $resbd->nome; ?>"/>
								</li>
								<li>
									<label for="email">Email:</label>
									<input type="text" size="50" name="email" disabled="disabled" value="<?php if($resbd) echo $resbd->email; ?>"/>
								</li>
								<li>
									<label for="login" >Login:</label>
									<input type="text" size="35" name="login" disabled="disabled" value="<?php if($resbd) echo $resbd->login; ?>"/>
								</li>								
								<li>
									<label for="senha">Senha:</label>
									<input type="password" size="25" name="senha" id="senha" value="<?php echo $_POST['senha']?>"/>
								</li>
								<li>
									<label for="senhaconf">Repita a senha:</label>
									<input type="password" size="25" name="senhaconf" value="<?php echo $_POST['senhaconf']?>"/>
								</li>
								<li class="center">
									<input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
									<input type="submit" name="mudasenha" value="Salvar Alterações"/>
								</li>
							</ul>
						</fieldset>
					</form>
					<div class="social-auth-links text-center">
				      <p>- OR -</p>
				      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
				        Facebook</a>
				      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
				        Google+</a>
				    </div>
				    <!-- /.social-auth-links -->
				
				    <a href="#">I forgot my password</a><br>
				    <a href="register.html" class="text-center">Register a new membership</a>
				
				  </div>
				  <!-- /.login-box-body -->
				</div>
				<!-- /.login-box -->
				
				<!-- jQuery 3 -->
				<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
				<!-- Bootstrap 3.3.7 -->
				<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
				<!-- iCheck -->
				<script src="../../plugins/iCheck/icheck.min.js"></script>
				<script>
				  $(function () {
				    $('input').iCheck({
				      checkboxClass: 'icheckbox_square-blue',
				      radioClass: 'iradio_square-blue',
				      increaseArea: '20%' // optional
				    });
				  });
				</script>
				</body>
				<?php	
			}//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
			else
				printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
		break;
					
		case 'excluir':
            echo '<h2>Exclusão de Usuário</h2>';
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
                            printMSG('Registro excluído com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>');
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
                    <form class="userform" method="post" action="">
                        <fieldset>
                            <legend>Confira os dados para exclusão</legend>
                            <ul>
                                <li>
                                    <label for="nome">Nome:</label>
                                    <input type="text" size="50" name="nome" disabled="disabled"  value="<?php if($resbd) echo $resbd->nome; ?>"/>
                                </li>
                                <li>
                                    <label for="email">Email:</label>
                                    <input type="text" size="50" name="email" disabled="disabled"  value="<?php if($resbd) echo $resbd->email; ?>"/>
                                </li>
                                <li>
                                    <label for="login" >Login:</label>
                                    <input type="text" size="35" name="login" disabled="disabled" value="<?php if($resbd) echo $resbd->login; ?>"/>
                                </li>                               
                                <li>
                                    <label for="ativo">Ativo:</label>
                                    <input type="checkbox" name="ativo" disabled="disabled" 
                                                                        <?php                                                                            
                                                                            
                                                                            if ($resbd->ativo=='s')
                                                                                echo 'checked="checked"';
                                                                        ?> />Habilitar ou desabilitar o usuário
                                </li>                               
                                <li>
                                    <label for="adm">Administrador:</label>
                                    <input type="checkbox" name="adm" disabled="disabled" 
                                                                        <?php                                                                           
                                                                            
                                                                            if ($resbd->administrador == 's')
                                                                                echo 'checked="checked"';
                                                                        ?> />dar controle total ao usuário
                                </li>
                                <li class="center">
                                    <input type="button" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
                                    <input type="submit" name="excluir" value="Confirmar exclusão"/>
                                </li>
                            </ul>
                        </fieldset>
                    </form>
                    
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
        
		default:
			echo '<p> A tela solicitada não existe </p>';
			break;
	}