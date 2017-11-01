<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

class usuario extends Base
{
    public function __construct($campos=array())
    {
        parent::__construct();
        $this->tabela = "usuarios";
        if (sizeof($campos)<=0) 
        {
            $this->campos_valores = array(
                                           "nome"=>null,
                                           "email"=>null,
                                           "login"=>null,
                                           "senha"=>null,
                                           "ativo"=>null,
                                           "administrador"=>null,
                                           "datacad"=>null,
                                          );
        }
        else
            $this->campos_valores = $campos;
        
        $this->campopk="id";
    }   
    
    public function doLogin($objeto)
    {

        $objeto->extras_select = " where login ='".$objeto->getValor('login')."' and senha='".codificaSenha($objeto->getValor('senha'))."' and ativo = 'S'";
        
        $this->selecionaTudo($objeto);
        $sessao = new sessao();       
        if ($this->linhasafetadas==1)
        {
            $usLogado = $objeto->retornaDados();                    
            $sessao->setVar('iduser', $usLogado->id);
            $sessao->setVar('nomeuser', $usLogado->nome);
            $sessao->setVar('loginuser', $usLogado->login);
            $sessao->setVar('logado', true);
            $sessao->setVar('ip', $_SERVER['REMOTE_ADDR']);             
            return true;
        }
        else
        {                
            $sessao->destroy(true);     
            return false;                    
        }                                 
    }
    
    public function doLogout()
    {
        $sessao = new sessao();
        $sessao->destroy(true); 
        redireciona('?erro=1');
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