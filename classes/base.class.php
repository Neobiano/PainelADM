<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

abstract class Base extends Banco {
	public $tabela = "";
	public $campos_valores = array();
	public $campopk = null;
	public $valorpk = null;
	public $extras_select = "";
	
	public function addCampo($campo=null,$valor=null)
	{
		if (!is_null($campo))
		{
			$this->campos_valores[$campo] = $valor;
		}
	}
	
	public function delCampo($campo=null)
	{
		if (array_key_exists($campo,$this->campos_valores))
		{
			unset($this->campos_valores[$campo]);
		}
	}
	
	public function setValor($campo=null,$valor=null)
	{
		if (!is_null($campo) && !is_null($valor)) 
		{
			$this->campos_valores[$campo] = $valor;
		}
	}
	
	public function getValor($campo=null)
	{
		if (!is_null($campo) && (array_key_exists($campo,$this->campos_valores))) 
		{
			return $this->campos_valores[$campo];
		}
		else
			return false;
	}
}

?>