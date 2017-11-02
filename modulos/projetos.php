<?php   
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    protegeArquivo(basename(__FILE__));
    loadJS('jqueryvalidate');
    loadJS('jqueryvalidate-messages');
    switch ($tela) 
    {
                    
        case 'editar':
            echo '<h2>Edição de Projetos</h2>';           
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
                                printMSG('Dados alterados com sucesso. <a href="?m=projetos&t=listar">Exibir cadastros</a>');
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
                    
                    <form class="userform" method="post" action="">
                        <fieldset>
                            <legend>Informe os dados para alteração</legend>
                            <ul>
                            	<li>
		                            <label for="codigo">Código:</label>
		                            <input type="text" size="50" name="codigo" disabled="disabled" value="<?php if($resbd) echo $resbd->id;?>"/>
		                        </li>
                                <li>
                                    <label for="nome">Nome:</label>
                                    <input type="text" size="50" name="nome" value="<?php if($resbd) echo $resbd->nome; ?>"/>
                                </li>
                                <li>
                                    <label for="descricao">Descrição:</label>
                                    <textarea  name="descricao" ><?php if($resbd) echo $resbd->descricao;?></textarea>                                    
                                </li>                                
                                <li class="center">
                                    <input type="button" onclick="location.href='?m=projetos&t=listar'" value="Cancelar"/>
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
            echo '<h2>Cadastro de Projetos</h2>';
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
                        printMSG('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=projetos&t=listar">Exibir Cadastros</a>');
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
            <form class="userform" method="post" action="">
                <fieldset>
                    <legend>Informe os dados para cadastro</legend>
                    <ul>                    	
                        <li>
                            <label for="nome">Nome:</label>
                            <input type="text" size="50" name="nome" value="<?php echo $_POST['nome']?>"/>
                        </li>
                        <li>
                            <label for="descricao">Descrição:</label>
                            <textarea  name="descricao" ><?php echo $_POST['descricao']?></textarea>
                        </li>                        
                        <li class="center">
                            <input type="button" onclick="location.href='?m=projetos&t=listar'" value="Cancelar"/>
                            <input type="submit" name="cadastrar" value="Salvar dados"/>
                        </li>
                    </ul>
                </fieldset>
            </form>
            <?php
            break;
        
        case 'listar':
            echo '<h2>Projetos</h2>';
            loadCSS('data-table',NULL,TUE);			
            loadJS('jquery-datatable');
			       
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
                    "sScrollY": "400px",
                    "bPaginate": false,
                    "aaSorting": [[0, "asc"]] 
                   }); 
                });
            </script>
            <table cellspacing="0" cellpadding="0" border="0" class="display" id="listausers">
                <thead>
                    <tr>
                        <th>Codigo</th><th>Nome</th><th>Descricao</th><th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $projeto = new projeto();
                    $projeto->selecionaTudo($projeto);                       					                                              
                    while ($res = $projeto->retornaDados()):
                        echo '<tr>';
                        printf('<td class="center">%s</td>',$res->id);
                        printf('<td class="center">%s</td>',$res->nome);
                        printf('<td class="center">%s</td>',$res->descricao);                        
                        printf('<td class="center"><a href="?m=projetos&t=incluir" title="Novo"><img src="images/add.png" alt="Novo cadastro" /></a> <a href="?m=projetos&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar" /></a><a href="?m=projetos&t=excluir&id=%s" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a></td>',$res->id,$res->id);
                        echo '</tr>';
                    endwhile;               
                    ?>
                </tbody>
            </table>
            
            <?php
            break;  
            

                    
        case 'excluir':
            echo '<h2>Exclusão de Projetos</h2>';
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
                            printMSG('Registro excluído com sucesso. <a href="?m=projetos&t=listar">Exibir cadastros</a>');
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
                	                    
                    <form class="userform" method="post" action="">
                        <fieldset>
                            <legend>Confira os dados para exclusão</legend>
                            <ul>
                                <li>
                                    <label for="nome">Código:</label>
                                    <input type="text" size="50" name="nome" disabled="disabled"  value="<?php if($resbd) echo $resbd->id; ?>"/>
                                </li>
                                <li>
                                    <label for="nome">Nome:</label>
                                    <input type="text" size="50" name="nome" disabled="disabled"  value="<?php if($resbd) echo $resbd->nome; ?>"/>
                                </li>
                                <li>
                                    <label for="descricao">Descricao:</label>
                                    <textarea  name="descricao" disabled="disabled" ><?phpif($resbd) echo $resbd->descricao;?></textarea>                                    
                                </li>                                
                                <li class="center">
                                    <input type="button" onclick="location.href='?m=projetos&t=listar'" value="Cancelar"/>
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