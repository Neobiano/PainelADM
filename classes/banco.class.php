<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));
abstract class Banco{
	//utilizando as constantes definidas no arquivo config.php
	public $servidor	= DBHOST;
	public $usuario		= DBUSER;
	public $senha		= DBPASS;
	public $nomebanco 	= DBNAME;
	public $conexao 	= null;
	public $dataset		= null;
	public $linhasafetadas = -1; //quantidade de linhas que uma instrucao ira impactar no bd
	public $lastid = null;
	//------------------------métodos----------------------
	public function __construct(){
		$this->conecta();
	}
	
	public function __destruct(){
		if ($this->conexao!=NULL)
		{
			$this->conexao = null;				
		} 
	}
	
	public function conecta()
	{
		try	
		{
			
			//mysql
			if  (SGBD == 1)
			{
				$param1 = 'mysql:host='.$this->servidor.';dbname='.$this->nomebanco;
				$this->conexao = new PDO($param1,$this->usuario,$this->senha,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));				
				$this->conexao->exec("SET character_set_connection=utf8");
				$this->conexao->exec("SET character_set_client=utf8");
				$this->conexao->exec("SET character_set_results=utf8");
			}
			else
			{				
				$param1 = 'sqlsrv:server='.$this->servidor.';database='.$this->nomebanco;
				$this->conexao = new PDO($param1,$this->usuario,$this->senha,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$this->conexao->exec("use [BD_TAREFAS]");		
							
			}									  					
				
			
		}
		catch (PDOException $e) 
		{
			$this->trataerro(__FILE__,__FUNCTION__,$e->getCode(),$e->getMessage(),true); 	
		} 	 				
		 					
	} //conecta
	
	public function inserir($objeto)
	{
		$sql = " insert into ".$objeto->tabela."(";
		for ($i=0; $i < count($objeto->campos_valores); $i++) 
		{
			$sql .= key($objeto->campos_valores);	
			//se não for o ultimo	
			if ($i < (count($objeto->campos_valores)-1))
				$sql .= ", ";
			else
				$sql .= ") ";
			 
			
			next($objeto->campos_valores); 
		}
		reset($objeto->campos_valores);
		$sql .= " values (";
		
		for ($i=0; $i < count($objeto->campos_valores); $i++) 
		{
			$sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)])
					?$objeto->campos_valores[key($objeto->campos_valores)]
					:"'".$objeto->campos_valores[key($objeto->campos_valores)]."'";	
			//se não for o ultimo	
			if ($i < (count($objeto->campos_valores)-1))
				$sql .= ", ";
			else 
				$sql .= ") ";
					 
			
			next($objeto->campos_valores); 
		}
		$this->executaSQL($sql);
		
	}//final inserir
	
	public function atualizar($objeto)
	{
		$sql = " update ".$objeto->tabela." set ";
		for ($i=0; $i < count($objeto->campos_valores); $i++) 
		{
			$sql .= key($objeto->campos_valores)."=";
			$sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)])
					?$objeto->campos_valores[key($objeto->campos_valores)]
					:"'".$objeto->campos_valores[key($objeto->campos_valores)]."'";	
			
			//se não for o ultimo	
			if ($i < (count($objeto->campos_valores)-1))
				$sql .= ", ";
			else
				$sql .= " ";
					
			next($objeto->campos_valores); 
		}
			
		$sql .= " where ".$objeto->campopk."=";
		$sql .= is_numeric($objeto->valorpk)?$objeto->valorpk:"'".$objeto->valorpk."'";
				
		$this->executaSQL($sql);
	
	} //final atualizar
	
	public function deletar($objeto)
	{
		$sql = " delete from ".$objeto->tabela;
	    $sql .= " where ".$objeto->campopk."=";
		$sql .= is_numeric($objeto->valorpk)?$objeto->valorpk:"'".$objeto->valorpk."'";
				
	    $this->executaSQL($sql);
	
	}//final deletar
	
	public function selecionaTudo($objeto,$sel=null)
	{
	    if (is_null($sel))	    
		   $sel = " select * from ";
	     
	    $sql = $sel.$objeto->tabela;
		if ($objeto->extras_select != null) 
		{
			$sql .= " ".$objeto->extras_select;
		}				
		return $this->executaSQL($sql);
	} //final selecionatudo
		
	
	public function selecionaCampos($objeto)
	{
		$sql = "SELECT ";
		for($i=0; $i<count($objeto->campos_valores); $i++)
		{
			$sql .= key($objeto->campos_valores);
			if($i < (count($objeto->campos_valores)-1)):
				$sql .= ", ";
			else:
				$sql .= " ";
			endif;
			next($objeto->campos_valores);
		};
		
		$sql .= " FROM ".$objeto->tabela;
		if($objeto->extras_select!=NULL):
			$sql .= " ".$objeto->extras_select;
		endif;
		return $this->executaSQL($sql);
	}//
	
	public function executaSQL($sql=null)
	{
		if (!is_null($sql))
		{
								    		   
			$query = $this->conexao->query($sql) or $this->trataerro(__FILE__,__FUNCTION__);	
											            
            $this->linhasafetadas = $query->RowCount();
                                    
			if (substr(trim(strtolower($sql)),0,6)=='select') 
			{
				$this->dataset = $query;
				return $this->dataset; 
			}
			else if (substr(trim(strtolower($sql)),0,6)=='insert')
			{
			    $stmt = $this->conexao->query("SELECT LAST_INSERT_ID()");
			    $this->lastId = $stmt->fetchColumn();
			}
			else
			    $this->lastId = null;
            		   			
		}
		else 
			$this->trataerro(__FILE__,__FUNCTION__,'Comando SQL não informado na rotina',FALSE);		
	}
	
	public function retornaDados($tipo=NULL)
	{
		return $this->dataset->fetch(PDO::FETCH_OBJ);
		/*switch (strtolower($tipo)) 
		{												
			case "object":
				return $this->dataset->fetch(PDO::FETCH_OBJ); 				
				break;
			
			default:
                $teste = $this->dataset;                 
				return $teste->fetch(PDO::FETCH_OBJ);
				break;
		}*/
	}
	public function trataErro($arquivo=null,$rotina=null,$numerro=null,$msgerro=null,$geraexcept=false)
	{
		if($arquivo==null) 
			$arquivo="nao informado";
			
		if($rotina==null) 
			$rotina="nao informada";
			
		if($numerro==null) 
			$numerro="nao informado";
		
		if($msgerro==null) 
			$msgerro="nao informada";
			
		$resultado = '<strong>Erro Ocorrido</strong><br/>
					  <strong>Arquivo:</strong> '.$arquivo.'<br/>
					  <strong>Rotina:</strong> '.$rotina.'<br/>
					  <strong>Codigo:</strong> '.$numerro.'<br/>
					  <strong>Mensagem:</strong> '.$msgerro;
		
		if (!($geraexcept))
			echo $resultado; 
		else 
			die($resultado);
	}
}//fim classe banco

?>