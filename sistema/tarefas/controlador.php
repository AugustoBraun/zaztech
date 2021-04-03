<?php


class tarefas  extends controlador_mestre
{

    var $controlador_nome = "Tarefas";


// =====================================================================================================================================


    function __construct()
    {

    }


// =====================================================================================================================================


    function admin_gerenciar($params, $get, $post, $file)
    {

        $conteudo['acao_nome'] = 'Gerenciar Tarefas';
        $userId = intVal($_SESSION['adminUser']['userid']);
        if($userId <= 0)
            header('Location: /sistema/login.php');

        //lista as tarefas no front
        $query = "select *, DATE_FORMAT(tarefaInicio,'%d/%m/%Y') as tarefaInicio, DATE_FORMAT(tarefaFim,'%d/%m/%Y') as tarefaFim
                    from tarefas where tarefaAtiva='Y' order by tarefaPrioridade asc, tarefaStatus asc, tarefaId desc";
        $tarefas = $this->consulta_array($query);
        $this->set('tarefas',$tarefas);

        //lista de usuários
        $query = "select id_login, nome from login order by nome asc";
        $usuarios = $this->consulta_array($query);
        $this->set('usuarios',$usuarios);

        $conteudo['template'] = array('tarefas', 'gerenciar');
        $this->mensagensNaSessao($conteudo);
        return $conteudo;

    }



// =====================================================================================================================================


    function admin_criaTarefa()
    {
        $query = "insert into tarefas (tarefaStatus) values ('a')";
        $proximo = $this->consulta_id($query);
        $this->debuga($proximo,1,0);
    }


// =====================================================================================================================================


    function admin_alteraPrioridade($params, $get, $post, $file)
    {
        $id = intVal($post['tarefaId']);
        $prio = trim($post['nova_prio']);

        if(!$id || !$prio || $id<=0)
            $this->debuga('erro',1,0);

        $query = "update tarefas set tarefaPrioridade='".$prio."' where tarefaId=".$id;

        if(false === $this->consulta($query))
            $acao = 'errodb';
        else
            $acao = 'OK';

        $this->debuga($acao,1,0);
    }


// =====================================================================================================================================


    function admin_alteraStatus($params, $get, $post, $file)
    {
        $id = intVal($post['tarefaId']);
        $status = trim($post['new_status']);

        if(!$id || !$status || $id<=0)
            $this->debuga('erro',1,0);

        $query = "update tarefas set tarefaStatus='".substr(strtolower($status),0,1)."' where tarefaId=".$id;

        if(false === $this->consulta($query))
            $acao = 'errodb';
        else
            $acao = 'OK';

        if($acao == 'OK' && $status == 'c')
            $query = "update tarefas set tarefaConcluida=NOW() where tarefaId=".$id;

        $this->consulta($query);

        $this->debuga($acao,1,0);
    }


// =====================================================================================================================================


    function admin_editarCampo($params, $get, $post, $file)
    {
        $id = intVal($post['tarefaId']);
        $campo = $this->DBFormat($post['campo']);
        $valor = $this->DBFormat($post['valor']);

        if(!$id || !$campo || !$valor || $id <= 0 || strlen($valor) < 1)
            $this->debuga('erro',1,0);

        if($campo == 'Inicio' || $campo == 'Fim')
        {
            $valor = explode('/',$valor);
            $valor = $valor[2].'-'.$valor[1].'-'.$valor[0];
        }

        $query = "update tarefas set tarefa".ucfirst($campo)."='".$valor."' where tarefaId=".$id;
        if(false === $this->consulta($query))
            $acao = 'errodb';
        else
            $acao = 'OK';

        $this->debuga($acao,1,0);
    }


// =====================================================================================================================================


    function admin_atribuirUsuario($params, $get, $post, $file)
    {
        $usuarioId = intVal($post['usuarioId']);
        $usuarioNome = $this->DBFormat(strip_tags($post['usuarioNome']));
        $tarefaId = intVal($post['tarefaId']);

        if(empty($usuarioId) || empty($tarefaId))
            $this->debuga('VAZIO',1,0);

        //checa se usuario foi utilizado em mais de 3 projetos simultaneos
        $query = "select usuarioId from tarefas where usuarioId=".$usuarioId;
        $tarefas = $this->consulta_array($query, 'usuarioId');

        if(count($tarefas) >= 3)
            $this->debuga('Usuário(a) '.$usuarioNome.' já está alocado(a) em 3 ou mais projetos',1,0);

        $query = "update tarefas set usuarioId=".$usuarioId." where tarefaId=".$tarefaId;

        if(false === $this->consulta($query))
            $acao = 'errodb';
        else
            $acao = 'OK';

        $this->debuga($acao,1,0);
    }


// =====================================================================================================================================


    function admin_deletaTarefa($params, $get, $post, $file)
    {
        $tarefaId = intVal($post['tarefaId']);

        if($tarefaId <= 0)
            $this->debuga('erro',1,0);

        $query = "update tarefas set tarefaAtiva='N', tarefaDesativada=NOW() where tarefaId=".$tarefaId;
        if(false === $this->consulta($query))
            $acao = 'errodb';
        else
            $acao = 'OK';

        $this->debuga($acao,1,0);
    }


// =====================================================================================================================================

}

?>
