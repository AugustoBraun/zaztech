<?php

	session_start();

	require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/config.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/auth.php");


// ===================  sistemas ==============================================================================


    function urlAmigavel($url = null){

        if(!$url){ $url =  $_SERVER['REQUEST_URI']; }
        $url = explode('/', parse_url($url, PHP_URL_PATH));
        $caminho = array();		//importante setar pois preciso mesmo vazio

        foreach($url as $path){
            if($path != '') {
                $caminho[] = $path;
            }
        }

        // organizo os caminhos do sistema
        if(isset($caminho[1])){
            $sistema['controlador'] = $caminho[1];
        }else{
            $sistema['controlador'] = 'tarefas';
        }
        if(isset($caminho[2])){
            $sistema['acao'] = 'admin_'.$caminho[2];
        }else{
            $sistema['acao'] = 'admin_gerenciar';
        }
        for($i=3, $o=0; $i<count($caminho); $i++, $o++){
            $sistema['params'][$o] = $caminho[$i];
        }
        return($sistema);
    }

    $sistema = urlAmigavel();



    //funcoes essenciais ao sistema
    function lerTemplate($opcao1= null, $opcao2=null)
    {
        global $sistema;

        if(empty($opcao1))
            $opcao1 = $sistema['controlador'];
        if(empty($opcao2))
            $opcao2 = $sistema['acao'];

        $opcao2 = str_replace('admin_', '', $opcao2);
        $ferramenta = ADMINROOT.'/'.$opcao1.'/'.$opcao2.'.php';
        return($ferramenta);
    }
			
//================================================
		
				
    //carrego o controlador mestre e modelo mestre
    include_once($_SERVER["DOCUMENT_ROOT"].'/sistema/_modelo_mestre.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/sistema/_controlador_mestre.php');

		
//================================================

    require_once($rootdir.'sistema/'.$sistema['controlador'].'/controlador.php');

    if(!method_exists($sistema['controlador'], $sistema['acao']))
    {
        echo 'Error controller / action';
    }else{
        $controlador = $sistema['controlador'];
        $dados_template = new $controlador;
    }


    //define o conteudo atraves dos comandos do controlador
    $conteudo = $dados_template->{$sistema['acao']}($sistema['params'], $_GET, $_POST, $_FILES);


    //lança pro ambiente as variaveis da classe controlador
    $vars = get_class_vars(get_class($dados_template));
     foreach($vars as $nome => $valor){
         $$nome = $valor;
     }
     foreach($dados_template->variaveis as $nome => $valor){
         $$nome = $valor;
     }




//====== mensagens ==========================================
			 
    if(is_array($_SESSION['msg_erro'])){$_SESSION['msg_erro'] = implode(' / ', $_SESSION['msg_erro']);}
    if(is_array($_SESSION['msg_sucesso'])){$_SESSION['msg_sucesso'] = implode(' / ', $_SESSION['msg_sucesso']);}
    if(is_array($_SESSION['msg_aviso'])){$_SESSION['msg_aviso'] = implode(' / ', $_SESSION['msg_aviso']);}

    function mostraAviso($msg, $nomediv='msg_sucesso'){
            return '<div class="'.$nomediv.'" style="display:none; position: relative; top: 20px; margin-bottom: 30px;">'.$msg.'<a class="close" href="javascript:fechaMensagens(\''.$nomediv.'\')"></a></div>';
    }

?><!DOCTYPE html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="/sistema/css/sistema.css">
		<link rel="stylesheet" href="/css/ui-darkness/jquery-ui-1.8.16.custom.css">
		<link href="/css/skins/grey.css" rel="stylesheet" type="text/css" />
		<link href="/css/jquery_notification.css" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="/css/impromptu/default.css">
        <link href="/css/tablesorter.css" type="text/css" rel="stylesheet" media="print, projection, screen"/>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/jquery-impromptu.js"></script>
        <script type="text/javascript" src="/js/jquery_notification.js"></script>
        <script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="/sistema/js/sistema.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	    <script language="javascript" type="text/javascript">

            var SITEURL = '<?php echo SITEURL; ?>';

			$(function()
            {


                $("#tabela_editar, #tabela_editar2, #tabela_editar3, #tabela_editar4, #tabela_editar5, #tabela_editar6, #tabela_editar7")
                    .tablesorter({
                        widgets: ['zebra','indexFirstColumn']
                    });

                $(".tabela_editar")
                    .tablesorter({
                        widgets: ['zebra','indexFirstColumn']
                    });

			});


		/*	function fechaMensagens(div)
            {
                $('.'+div).hide();
			}

			function abreMensagens(div){
				if ($('.'+div).is(':visible')) {
					$('.'+div).fadeTo("fast", 0.00, function(){ //fade
						$(this).hide('blind', '1000');
					});
				}else{
					$('.'+div).fadeTo("slow", 1.00, function(){ //fade
						$(this).slideDown('slow');
					});
				}
			}


            function confirmaCallback(texto, callback, params)
            {
                function confirma(v,m,f)
                {
                    if(v == true){
                        callback(params);
                    }else{
                        return false;
                    }
                }
                $.prompt(texto,{
                    callback: confirma,
                    buttons: { Confirmar: true, Cancelar: false },
                    prefix: 'cleanblue'
                });
            }
*/


        </script>

</head>
<body id="body">

    <div id="box_usuario">
        <div style="max-width:1000px; width: 100%; margin: 0 auto; text-align: center;">
            <div id="box_usuario_txt">
                <div class="box_foto" <?php
                    if(is_file(ROOTDIR.'uploads/img/usuario/'.$_SESSION['userid'].'.jpg')){
                        echo ' style="background-image: url(\'/uploads/img/usuario/'.$_SESSION['adminUser']['userid'].'.jpg\'); background-repeat: no-repeat;"';
                    }
                ?>>
                </div>
                <div class="box_usario_nome">
                    <?php echo $_SESSION['adminUser']['usernome']; ?>
                </div>
                <table border=0 cellpadding=2 cellspacing=5">
                    <tr>
                        <td>
                            <div class="box_usuario_detalhes">
                                <a href="/sistema/login.php" style="color: #ffffff;">
                                    <img src="/sistema/img/_sair.png" border=0 align=absmiddle>
                                    sair
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div id="Content">


        <div id="admin-menu">

            <div class="menu-logo">

                <img src="/img/logo_principal.png">

            </div>

            <div class="wrap menu_ferramentas">

                <div class="grey demo-container">
                    <ul class="accordion nobullet" id="accordion-1">
                        <li>
                            <a href="/sistema/tarefas/gerenciar">Gerenciar Tarefas</a>
                        </li>
                    </ul>
               </div>

            </div>
        </div>

        <div id="admin-interface">

            <div class="sistema_conteudos"  ><?php


                    //caso seja enviado algum conteudo fora de template, carrega
                    if($conteudo['miolo'])
                        echo $conteudo['miolo'];


                    // caso o controlador solicite um template, carrega.
                    if(is_array($conteudo['template']))
                        include_once(lerTemplate($conteudo['template'][0],$conteudo['template'][1]));



            ?>
            </div>

        </div>

    </div>

</body>
</html>