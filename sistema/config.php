<?PHP

    date_default_timezone_set('America/Sao_Paulo');
	ini_set("display_errors", false);
//    error_reporting(E_ALL & ~E_NOTICE);


// ======= CONFIGURAÇÕES DO BANCO DE DADOS ========================================================

    $mysql_server = "localhost";
    $database = "zaztech";
    $user = "root";
    $password = "";



	$rootdir = $_SERVER["DOCUMENT_ROOT"]."/";
    if(substr($rootdir,-2)=='//'){ $rootdir = substr($rootdir,0,-1);}
    define('ROOTDIR', $rootdir);

    $adminroot = $rootdir."sistema/";
    define('ADMINROOT', $adminroot);


    $siteurl = "https://".$_SERVER["HTTP_HOST"]."/";
    define('SITEURL', $siteurl);

    $adminurl = SITEURL."sistema/";
    define('ADMINURL', $adminurl);


    $db = new mysqli($mysql_server,$user,$password,$database);
    $db->set_charset('utf8');
    if($db->connect_errno > 0)
        die('Impossivel conectar ao banco de dados [' . $db->connect_error . ']');

    require_once(ADMINROOT.'horario.php');
    define("HOST", $mysql_server);
    define("USER", $user);
    define("PASS", $password);
    define("DB", $database);
    define("DATETIMEHOJE", $hoje);
    define("DATEHOJE", $datehoje);
    define("DATAHOJE", $datahoje);
    define("CLIENTENOME", "ZazTech");


	define("SERVER_NAME", $_SERVER["SERVER_NAME"]); 
	define("SERVER_URI", $_SERVER ["REQUEST_URI"]);
	define("URL_ATUAL", "https://".SERVER_NAME."/".SERVER_URI);

    $infoserver = $_SERVER['REQUEST_URI'];


?>