<?php
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    $sessao = new sessao();
    $iduser = $sessao->getVar('iduser');
    $codTarefa = $_POST['codTarefa2'];

    //percorrendo os arquivos selecionados
    for($i=0; $i<count($_FILES['file']['name']); $i++)
    {
        date_default_timezone_set("Brazil/East");
        $name     = $_FILES['file']['name'];//Atribui uma array com os nomes dos arquivos à variável
        $tmp_name = $_FILES['file']['tmp_name']; //Atribui uma array com os nomes temporários dos arquivos à variável
        
        $allowedExts = array(".gif", ".jpeg", ".jpg", ".png", ".bmp");//Extensões permitidas
                
        $dir = "../arquivos/";
        $ext = strtolower(substr($name[$i],-4));
        
        
        $arquivo = new arquivo(array(
            'id_tarefa'=>$codTarefa,
            'id_usuario'=>$iduser,
            'descricao'=>'Arquivo incluido',
            'nome_arquivo'=>$_FILES['file']['name'][$i],
            'data_hora'=>date("Y.m.d-H.i.s")
        ));
        $arquivo->inserir($arquivo);             
        
       $new_name = $codTarefa.'-'.$arquivo->lastId.'-'.date("Y.m.d-H.i.s") ."-". $i . $ext;
       
       if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $dir.$new_name))                            
           echo "Arquivo enviado com sucesso!";
       else
           echo "Houve um erro no envio do arquivo, por favor tente novamente!";
        
     }    

?>