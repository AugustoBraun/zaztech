<?php

session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/sistema/config.php");
$_SESSION['adminUser'] = array();


?><!DOCTYPE html>
<html lang="pt">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<META name="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
		<META NAME="ROBOTS" CONTENT="NONE">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
        <title>Prova Prática ZazTech</title>

		<link rel="stylesheet" href="/sistema/css/sistema.css">

		<script type="text/javascript" src="/js/jquery.min.js"></script>

</head>

<body>


    <div id="login-content">

            <div id="login-card">

                <div id="face1">

                    <img src="/img/logo_principal.png">

                </div>

                <div id="face2">

                    <div style="clear:both"></div>

                    <div id="login-form">

                        <form name="loginform" action="/sistema/" method="POST" >

                            <input type="text" name="usuario" placeholder="login" class="login-form-input" value="usuario">
                            <input type="password" name="senha" placeholder="******"  class="login-form-input" value="senha">

                            <input type="submit"  name="access" id="access" class="botao1" value="acessar" style="width: 100%; margin: 20px 0; padding: 10px;"/>
                        </form>

                    </div>

                </div>

            </div>


    </div>


</html>
