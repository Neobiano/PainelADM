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
                    $qprojeto = new projeto();
                    $qprojeto->selecionaTudo($qprojeto);
                    if ($qprojeto->linhasafetadas <= 0)
                        $tela = 'incluir';  
                }
                
                loadJS('jqueryvalidate');
                loadJS('jqueryvalidate-messages');
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
                        $projeto = new projeto(array(
                            'nome'=>$_POST['nome'],
                            'descricao'=>$_POST['descricao']
                        ));
                        
                        $projeto->valorpk = $id;
                        $projeto->extras_select = "WHERE id=$id";
                        $projeto->selecionaTudo($projeto);
                        $res = $projeto->retornaDados();
                        
                        //se o NOME foi alterado do inicilamente carregado para o registro
                        if ($res->nome != $_POST['nome'])
                        {
                            //verificando se já existe um email no BD como o 'novo' email cadastrado
                            if ($projeto->existeRegistro('nome',$_POST['nome']))
                            {
                                printMSG('Projeto já existe no sistema, escolha outro nome!','erro');
                                $duplicado = TRUE;
                            }
                        }

                        //se não existe vai atualizar normalmente
                        if ($duplicado!=TRUE)
                        {
                            $projeto->atualizar($projeto);
                            if ($projeto->linhasafetadas==1)
                            {
                                printMSG('Dados alterados com sucesso. <a href="?m=projetos&t=listar">Exibir cadastros</a>','sucesso');
                                unset($_POST);
                            }
							else                         
                            	printMSG('Nenhum dado foi alterado. <a href="?m=projetos&t=listar">Exibir cadastros</a>','alerta');
                        }
                                    
                    }
                    
                    //se não clicou no botão salvar, so vai carregar os registros do usuário em tela para edição    
                    $projetobd = new projeto();
                    $projetobd->extras_select = "WHERE id=$id";
                    $projetobd->selecionaTudo($projetobd);
                    $resbd = $projetobd->retornaDados();
                }
                else
                    printMSG('Projeto não definido, <a href="?m=projetos&t=listar">escolha um projeto para alterar</a>','erro');
                
                
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
                		Projetos
                		<small>Incluir</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Projetos</a></li>
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
              								<input disabled name="nome" type="text" class="form-control input-sm" placeholder="Nome do projeto" value="<?php if($resbd) echo $resbd->id;?>">
    									</div>
    									
    									<div class="form-group">
              								<label>Nome</label>
              								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do projeto" value="<?php if($resbd) echo $resbd->nome;?>">
    									</div>
                                        
    									<div class="form-group">
      										<label>Descrição</label>
      										<textarea name="descricao" class="form-control input-sm" rows="3" placeholder="Descrição do projeto"><?php if($resbd) echo $resbd->descricao;?></textarea>
        								</div>
    								</div>                                
                                  
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=projetos&t=listar'" >Cancelar</button>
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
              
                $projeto = new projeto(
                                        array(
                                        'nome'=>$_POST['nome'],
                                        'descricao'=>$_POST['descricao']                                        
                                        )
                                    ); 
             
            
                //verificando se ja existem registros com o parametro solicitado para inserção      
                if ($projeto->existeRegistro('nome',$_POST['nome'])) 
                {
                    printMSG('Projeto já existe no sistema, escolha outro nome!','erro');
                    $duplicado = true;
                }
                               
                if ($duplicado!=true) 
                {
                    $projeto->inserir($projeto);
                   
                    if ($projeto->linhasafetadas==1)
                    {
                        printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=projetos&t=listar">Exibir Cadastros</a>','sucesso');   
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
                		Projetos
                		<small>Incluir</small>
                  	</h1>
                  	<ol class="breadcrumb">
                		<li><a ><i class="fa fa-dashboard"></i> Projetos</a></li>
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
              								<input autofocus name="nome" type="text" class="form-control input-sm" placeholder="Nome do projeto" value="<?php echo $_POST['nome']?>">
    									</div>
                                        
    									<div class="form-group">
      										<label>Descrição</label>
      										<textarea name="descricao" class="form-control input-sm" rows="3" placeholder="Descrição do projeto"><?php echo $_POST['descricao']?></textarea>
        								</div>
    								</div>                                
                                  
    								<div class="box-footer">  
    									 <button type="button" class="btn btn-default" onclick="location.href='?m=projetos&t=listar'" >Cancelar</button>
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
                    
                    $projeto = new projeto(array(
                        'nome'=>$_POST['nome']
                    ));
                    
                    
                    //verificando se ja existem registros com o parametro solicitado para inserção
                    if ($projeto->existeRegistro('nome',$_POST['nome']))
                    {
                        printMSG('projeto já existe no sistema, escolha outro nome!','erro');
                        $duplicado = true;
                    }
                    
                    if ($duplicado!=true)
                    {
                        $projeto->inserir($projeto);
                        if ($projeto->linhasafetadas==1)
                        {
                            $lastid = $projeto->lastId;
                                                        
                            $qprojeto = new projeto();
                            $qprojeto->extras_select = " order by nome";
                            $qprojeto->selecionaTudo($qprojeto);
                            
                            while ($res = $qprojeto->retornaDados())
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
                                "jprojetos" => $ddata,
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
    		        Projetos
    		        <small>Listagem</small>
    		      </h1>
    		      <ol class="breadcrumb">
    		        <li><a ><i class="fa fa-dashboard"></i> Projetos</a></li>
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
                              			<th>Descrição</th>
                              			<th>Ações</th>                  
                            		</tr>
                            	</thead>
                            	<tbody>
                                    <?php 
                                    $projeto = new projeto();
                                    $projeto->selecionaTudo($projeto);                       					                                              
                                    while ($res = $projeto->retornaDados()):
                                        echo '<tr>';
                                        printf('<td>%s</td>',$res->id);
                                        printf('<td>%s</td>',$res->nome);
                                        printf('<td>%s</td>',$res->descricao);                        
                                        printf('<td><a href="?m=projetos&t=incluir" title="Novo"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=projetos&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a><a href="?m=projetos&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id);
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
                        $projeto = new projeto();
                        $projeto->valorpk =$id;                   
                                                
                        
                        $projeto->deletar($projeto);
                        if ($projeto->linhasafetadas==1)
                        {
                            printMSG('Registro excluído com sucesso. <a href="?m=projetos&t=listar">Exibir cadastros</a>','sucesso');                                                     
                            unset($_POST);                           
                        }
                        else 
                            printMSG('Nenhum dado foi excluído. <a href="?m=projetos&t=listar">Exibir cadastros</a>','alerta');
                        
                    } //final isset $_POST['excluir']
                    $projetobd = new projeto();
                    $projetobd->extras_select = "where id=$id";
                    $projetobd->selecionaTudo($projetobd);
                    $resbd = $projetobd->retornaDados();                   
                }//final isset $_GET['id']
                else
                    printMSG('Projeto não definido, <a href="?projetos&t=listar">escolha um projeto para excluir</a>','erro');
                
                //formulário de edição de projeto   
                ?>   
                	<div class="content-wrapper">
                    <!-- Content Header (Page header) --> 
            
                    <section class="content-header">
                    	<h1>
                    		Projetos
                    		<small>Excluir</small>
                      	</h1>
                      	<ol class="breadcrumb">
                    		<li><a ><i class="fa fa-dashboard"></i> Projetos</a></li>
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
                  								<label>Nome</label>
                  								<input  name="nome" type="text" class="form-control input-sm" disabled value="<?php if($resbd) echo $resbd->nome;?>">
        									</div>
        									
        									<div class="form-group">
          										<label>Descrição</label>
          										<textarea name="descricao" class="form-control input-sm" rows="3" disabled><?php if($resbd) echo $resbd->descricao;?></textarea>
            								</div>
        								</div>                                
                                      
        								<div class="box-footer">  
        									 <button type="button" class="btn btn-default" onclick="location.href='?m=projetos&t=listar'" >Cancelar</button>
        									 <button type="submit" name="excluir" class="btn btn-info pull-right">Confirmar exclusão</button>  									
        									 
        								</div>                              
        							</form>
        		 				</div><!-- Final box-primary -->
        					</div><!-- Final col-md-6 -->
        				</div>
        			</section>
                    <!-- /.content -->
    			</div>                                  
                    
                <?php   
            }//final  if ((isAdmin()==true)||$sessao->getVar('iduser')==$_GET['id'])
            else
                printMSG('Você não tem permissão para acessar essa página. <a href="#" onclick="history.back()">Voltar</a>','erro');
        break;      
        
        default:
            echo '<p> A tela solicitada não existe </p>';
            break;
    }