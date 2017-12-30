<?php
    require_once(dirname(dirname(__FILE__))."/funcoes.php");
    $sessao = new sessao();
    $iduser = $sessao->getVar('iduser');
    $codTarefa = $_POST['codTarefa'];

    //percorrendo os arquivos selecionados
    for($i=0; $i<count($_FILES['file']['name']); $i++)
    {
        date_default_timezone_set("Brazil/East");
        $name     = $_FILES['file']['name'];//Atribui uma array com os nomes dos arquivos à variável
        $tmp_name = $_FILES['file']['tmp_name']; //Atribui uma array com os nomes temporários dos arquivos à variável
        
        $allowedExts = array(".msg"/*".gif", ".jpeg", ".jpg", ".png", ".bmp"*/);//Extensões permitidas
                
        $dir = "../arquivos/";
        $ext = strtolower(substr($name[$i],-4));
       
        $new_name = $codTarefa.'-'.date("Y.m.d-H.i.s") ."-". $i . $ext;
      
       if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $dir.$new_name))
       {
           $arquivo = new arquivo(array(
               'id_tarefa'=>$_POST['codTarefa'],
               'id_usuario'=>$iduser,
               'descricao'=>'Arquivo incluido',
               'nome_arquivo'=>$new_name,
               'data_hora'=>date("Y.m.d-H.i.s")              
           ));
           $arquivo->inserir($arquivo);
           
           echo "The file has been uploaded successfully <br />";
       }
       else
           echo "There was an error uploading the file, please try again! <br />";
        
     }    

?>