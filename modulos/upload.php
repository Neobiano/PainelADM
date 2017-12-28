<?php
  
    for($i=0; $i<count($_FILES['file']['name']); $i++)
    {
        date_default_timezone_set("Brazil/East");
        $name     = $_FILES['file']['name'];//Atribui uma array com os nomes dos arquivos à variável
        $tmp_name = $_FILES['file']['tmp_name']; //Atribui uma array com os nomes temporários dos arquivos à variável
        
        $allowedExts = array(".gif", ".jpeg", ".jpg", ".png", ".bmp");//Extensões permitidas
                
        $dir = "../arquivos/";
        $ext = strtolower(substr($name[$i],-4));
        //$ext = explode('.', basename( $_FILES['file']['name'][$i]));
        //$target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext)-1];
        $new_name = date("Y.m.d-H.i.s") ."-". $i . $ext;
        
       // if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) 
       if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $dir.$new_name)) //Fazer upload do arquivo{
            echo "The file has been uploaded successfully <br />";
         else
            echo "There was an error uploading the file, please try again! <br />";
        
        }    
/*   if(isset($_FILES['fileUpload']))
   {     
      date_default_timezone_set("Brazil/East");

      $name     = $_FILES['fileUpload']['name'];//Atribui uma array com os nomes dos arquivos à variável
      $tmp_name = $_FILES['fileUpload']['tmp_name']; //Atribui uma array com os nomes temporários dos arquivos à variável

      $allowedExts = array(".gif", ".jpeg", ".jpg", ".png", ".bmp");//Extensões permitidas

      $dir = 'arquivos/';
      echo 'aqui 2'; 
      for($i = 0; $i < count($tmp_name); $i++) //passa por todos os arquivos
      {
         $ext = strtolower(substr($name[$i],-4)); 

       //  if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
        // {
            $new_name = date("Y.m.d-H.i.s") ."-". $i . $ext;
            move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
        // }
      }
   }*/
?>