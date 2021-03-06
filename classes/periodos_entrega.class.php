	
<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

class periodos_entrega extends Base
{
    public function __construct($campos=array())
    {
        parent::__construct();
        $this->tabela = "periodos_entrega";
        if (sizeof($campos)<=0) 
        {
            $this->campos_valores = array(
                                           "id"=>null,
                                           "nome"=>null,
                                           "inter_ini"=>null,
                                           "inter_fim"=>null,
                                           "cor"=>null                                           
                                          );
        }
        else
            $this->campos_valores = $campos;
        
        $this->campopk="id";
    }
    
    public function existeRegistro($campo=NULL,$valor=NULL){
        if ($campo!=NULL && $valor!=NULL):
            is_numeric($valor) ? $valor = $valor : $valor = "'".$valor."'";
            $this->extras_select = "WHERE $campo=$valor";
            $this->selecionaTudo($this);
            if ($this->linhasafetadas > 0):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->trataerro(__FILE__,__FUNCTION__,NULL,'Faltam parâmetros para executar a função',TRUE);
        endif;
    }       
}

?>