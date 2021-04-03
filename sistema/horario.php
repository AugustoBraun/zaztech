<?PHP


    $meses = array(null,"janeiro","fevereiro","mar&ccedil;o","abril","maio","junho","julho","agosto","setembro","outubro","novembro","dezembro");
    $mesesUpper = array(null,"JANEIRO","FEVEREIRO","MARÇO","ABRIL","MAIO","JUNHO","JULHO","AGOSTO","SETEMBRO","OUTUBRO","NOVEMBRO","DEZEMBRO");

    $dias_semana = array("Domingo","Segunda-feira","Ter&ccedil;a-feira","Quarta-feira","Quinta-feira","Sexta-feira","S&aacute;bado");






    $thedate = getdate();
    $day = $thedate["wday"];
    $mon = $thedate["mon"];
    $month = $thedate["month"];
    $year = $thedate["year"];
    $dia_mes = $thedate["mday"];


$datatual = getdate();
$diaatual = $datatual['mday'];
$mesatual = $datatual['mon'];
$anoatual = $datatual['year'];
$semana = $thedate['wday'];
$diasemana = $dias_semana[$semana];

if ($diaatual < 10 ){ $diaatual = '0'.$diaatual; }
if ($mesatual < 10 ){ $mesatual = '0'.$mesatual; }

$hora = $thedate['hours'];
if (strlen($hora) < 2){ $hora = '0'.$hora; }

$segundos = $thedate['seconds'];
if (strlen($segundos) < 2){ $segundos = '0'.$segundos; }

$minutes = $datatual['minutes'];
$segundos = $datatual['seconds'];
$hours = $datatual['hours'];
$hora24 = $hours;
$ampm="AM";

if ($hours > 12) {
$hours=$hours-12;
$ampm="PM";
}

if ( $minutes < 10) {
$minutes="0$minutes";
}
if ( $minut0s < 10) {
$minut0s="0$minutos";
}
if ( $segundos < 10) {
$segundos="0$segundos";
}
if ( $thedate['mon'] < 10) {
$thedate['mon']= '0'.$thedate['mon'];
}
if ( $thedate['mday'] < 10) {
$thedate['mday']= '0'.$thedate['mday'];
}
$hoje = $year."-".$mesatual."-".$diaatual." ".$hora.":".$minutes.":".$segundos;
$hojez = $year."-".$mesatual."-".$diaatual." 00:00:00";
//$hoje2
$datahoje = $diaatual."/".$mesatual."/".$year;
$datehoje = $year.'-'.$mesatual.'-'.$diaatual;


//$horario =  $hours.':'.$minutes.' '.$ampm;
$horario =  $hora.':'.$minutes;



//$mostra_horario = '<font color=#666666>Bem-vindo(a) </font><font color=#B03C1E><b>'.$_SESSION['usernome'].'</b></font><font color=#666666>, hoje é '.$diasemana."&nbsp;&nbsp;".$thedate["mday"].' de '.$meses[$mon].' de '.$thedate["year"]." - </font><font color=#B03C1E><b>".$horario."</b></font>";
$mostra_horario = $thedate["mday"].'/'.$thedate['mon'].'/'.$thedate["year"]." - ".$horario;

$dthoje= date("d/m/Y", strtotime($hoje));







if(!function_exists('days_diff')){
function days_diff($date_ini, $date_end, $round = 0) {
    $date_ini = strtotime($date_ini);
    $date_end = strtotime($date_end);

    $date_diff = ($date_end - $date_ini) / 86400;

    if($round != 0)
        return floor($date_diff);
    else
        return $date_diff;
}

}


if(!function_exists('formata_data_extenso')){
function formata_data_extenso($strDate)
{
	// Array com os dia da semana em português;
    $arrDaysOfWeek = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
	// Array com os meses do ano em português;
	$arrMonthsOfYear = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	// Descobre o dia da semana
	$intDayOfWeek = date('w',strtotime($strDate));
	// Descobre o dia do mês
	$intDayOfMonth = date('d',strtotime($strDate));
	// Descobre o mês
	$intMonthOfYear = date('n',strtotime($strDate));
	// Descobre o ano
	$intYear = date('Y',strtotime($strDate));
	// Formato a ser retornado
//	return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
	return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
}
}



//
// == Função para subtração e adição de datas =============================================
// Autor: Fernando Barchi Finotti - fbarchi@ig.com.br - UIN# 38189361
// Modificado por: Thiago Filler
// Data: 02 Dez 01
// Update : Fernando Barchi Finotti
// Data: 15/09/2003
// Obs. Bug quando o mes era 09, não trocava de mes, apenas era somado  os dias
// LOG Fernando Barchi : Problema foi corrigido.
// ============================================================================


// ============================================================================

if(!function_exists('voltadata')){
function voltadata($dias,$datahoje){

// Desmembra Data -------------------------------------------------------------

  if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $datahoje, $sep)) {
  $dia = $sep[1];
  $mes = $sep[2];
  $ano = $sep[3];
  } else {
  //  echo "<b>Formato Inválido de Data - $datahoje</b><br>";
  }

// Meses que o antecessor tem 31 dias -----------------------------------------

  if($mes == "01" || $mes == "02" || $mes == "04" || $mes == "06" || $mes == "08" || $mes == "09" || $mes == "11"){
    for ($cont = $dias ; $cont > 0 ; $cont--){
    $dia--;
      if($dia == 00){ // Volta o dia para dia 31 .
      $dia = 31;
      $mes = $mes -1; // Diminui um mês se o dia zerou .
      }
        if($mes == 00){
        $mes = 12;
        $ano = $ano - 1; // Se for Janeiro e subtrair 1 , vai para o ano anterior no mês de dezembro.
        }

    }
  }

// Meses que o antecessor tem 30 dias -----------------------------------------

  elseif($mes == "05" || $mes == "07" || $mes == "10" || $mes == "12" ){
    for ($cont = $dias ; $cont > 0 ; $cont--){
    $dia--;
      if($dia == 00){ // Volta o dia para dia 30 .
      $dia = 30;
      $mes = $mes -1; // Diminui um mês se o dia zerou .
    }
    if($mes == 00){
        $mes = 12;
        $ano = $ano - 1; // Se for Janeiro e subtrair 1 , vai para o ano anterior no mês de dezembro.
        }
    }
  }

// Mês que o antecessor é fevereiro -------------------------------------------
//
// == Correção do voltadata no mês Abril/Março =============================================
// Modificado por: Paulo Roberto Ens pauloens@bruc.com.br
// Data: 11 Mai 2005
// ============================================================================
//
  else //Else adicionado para funcionar o voltadata no mês de Abril/Março
  {
  if($ano % 4 == 0 && $ano%100 != 0){ // se for bissexto
    if($mes == "03" ){
      for ($cont = $dias ; $cont > 0 ; $cont--){
      $dia--;
        if($dia == 00){ // Volta o dia para dia 30 .
        $dia = 29;
        $mes = $mes -1; // Diminui um mês se o dia zerou .
      }
    if($mes == 00){
        $mes = 12;
        $ano = $ano - 1; // Se for Janeiro e subtrair 1 , vai para o ano anterior no mês de dezembro.
        }
      }
    }
  }//fecha se bissexto...
  else{ // se não for bissexto
    if($mes == "03" ){
      for ($cont = $dias ; $cont > 0 ; $cont--){
        $dia--;
        if($dia == 00){ // Volta o dia para dia 30 .
          $dia = 28;
          $mes = $mes -1; // Diminui um mês se o dia zerou .
        }
        if($mes == 00){
        $mes = 12;
        $ano = $ano - 1; // Se for Janeiro e subtrair 1 , vai para o ano anterior no mês de dezembro.
        }
      }
    }
  }
    }//Termina else dos meses

// Confirma Saída de 2 dígitos ------------------------------------------------

  if(strlen($dia) == 1){$dia = "0".$dia;}
  if(strlen($mes) == 1){$mes = "0".$mes;}

// Monta Saída ----------------------------------------------------------------

  $nova_data = $dia."/".$mes."/".$ano ;

return($nova_data);
} //fecha função


} // fecha o if se a funcao existe
//
// == Função para adição de datas =============================================
// Autor: Fernando Barchi Finotti - fbarchi@ig.com.br
// Modificado por: Tripa Seca @ phpbrasil.com
// Data: 02 Dez 01
// ============================================================================
//


if(!function_exists('somadata')){
function somadata($dias,$datahoje){

// Desmembra Data -------------------------------------------------------------

  if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $datahoje, $sep)) {
  $dia = $sep[1];
  $mes = $sep[2];
  $ano = $sep[3];
  } else {
    echo "<b>Formato Inválido de Data - $datahoje</b><br>";
  }

  $i = $dias;

  for($i = 0;$i<$dias;$i++){

    if ($mes == "01" || $mes == "03" || $mes == "05" || $mes == "07" || $mes == "08" || $mes == "10" || $mes == "12"){
      if($mes == 12 && $dia == 31){
        $mes = 01;
        $ano++;
        $dia = 00;
      }
    if($dia == 31 && $mes != 12){
      $mes++;
      $dia = 00;
    }
  }//fecha if geral

  if($mes == "04" || $mes == "06" || $mes == "09" || $mes == "11"){
	if($dia == 30){
      $dia = 00;
      $mes++;
    }
  }//fecha if geral

  if($mes == "02"){
    if($ano % 4 == 0 && $ano % 100 != 0){ //ano bissexto
      if($dia == 29){
        $dia = 00;
        $mes++;
      }
    }
    else{
      if($dia == 28){
        $dia = 00;
        $mes++;
      }
    }
  }//FECHA IF DO MÊS 2

  $dia++;

  }//fecha o for()

// Confirma Saída de 2 dígitos ------------------------------------------------

  if(strlen($dia) == 1){$dia = "0".$dia;};
  if(strlen($mes) == 1){$mes = "0".$mes;};

// Monta Saída ----------------------------------------------------------------

$nova_data = $dia."/".$mes."/".$ano ;

return($nova_data);

}//fecha a funçâo data

} // fecha o if se a funcao existe









// bloco de novas funcoes para os dias da semana em agenda e onde mais precisar
if(!function_exists('mesAbreviado')){
function mesAbreviado($mes){
$mesAbrev = array(null,"Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez");
if(substr($mes,0,1)=="0"){$mes = substr($mes,1);}
return $mesAbrev[$mes];
}
}


if(!function_exists('DiaSemana')){
//entrar com data 01/01/2000
function DiaSemana($data) {
    $dataf = explode("/",$data);
    $data = $dataf[2]."-".$dataf[1]."-".$dataf[0];
    $rs = strftime('%w',strtotime($data));
    if($rs==0){$rs=7;}
    switch($rs) {
        case '7': $s = 'Domingo'; break;
        case '1': $s = 'Segunda'; break;
        case '2': $s = 'Terça'; break;
        case '3': $s = 'Quarta'; break;
        case '4': $s = 'Quinta'; break;
        case '5': $s = 'Sexta'; break;
        case '6': $s = 'Sábado'; break;
    }
return $s;
}
}




if(!function_exists('Semana')){
function Semana($data) {
    $dataf = explode("/",$data);
    $data = $dataf[2]."-".$dataf[1]."-".$dataf[0];
    $rs = strftime('%w',strtotime($data));
    if($rs==0){$rs=7;}
    return $rs;
}
}


if(!function_exists('ExtData')){
function ExtData($data) {
    $dataf = explode("/",$data);
    $data = $dataf[2]."-".$dataf[1]."-".$dataf[0];
    $rs = strftime('%d,%m',strtotime($data));
    $rs=explode(",",$rs);
    return $rs;
}
}


if(!function_exists('Mes')){
function Mes($data) {
    $dataf = explode("/",$data);
    $data = $dataf[2]."-".$dataf[1]."-".$dataf[0];
    $rs = strftime('%m',strtotime($data));
    return $rs;
}
}

if(!function_exists('DataCurta')){
function DataCurta($data) {
    $dataf = explode(" ",$data);
    $dataf = explode("-",$dataf);
    $datag = $dataf[2]."/".$dataf[1]."/".$dataf[0];
    $rs = strftime('%d/%m',strtotime($data));
    return $rs;
}
}


if(!function_exists('DataLonga')){
function DataLonga($data) {
    $dataf = explode(" ",$data);
    $dataf = explode("-",$dataf);
    $datag = $dataf[2]."/".$dataf[1]."/".$dataf[0];
    $rs = strftime('%d/%m/%y',strtotime($data));
    return $rs;
}
}


if(!function_exists('DataLonga2')){
function DataLonga2($data) {
    $dataf = explode(" ",$data);
    $dataf = explode("-",$dataf);
    $datag = $dataf[2]."/".$dataf[1]."/".$dataf[0];
    $rs = strftime('%d/%m/%Y',strtotime($data));
    return $rs;
}
}

if(!function_exists('formdata')){
    function formdata($data) {
    $data1 = substr($data,0,10);
    $data2 = substr($data,11,8);
    $data1 = explode("-",$data1);
    $data1 = array_reverse($data1);
    $data1 = implode("/",$data1);
    return $data1." ".$data2;
    }
}




if(!function_exists('formatadata')){
                function formatadata($func,$valor,$data){
                         if($func=="soma"){
                            $dtq = explode("/",somadata($valor,$data));
                         }elseif($func="volta"){
                            $dtq = explode("/",voltadata($valor,$data));
                         }else{
                            $dtq = explode("/",$data);
                         }
                         $dtquery =  $dtq[2].'-'.$dtq[1].'-'.$dtq[0].' 00:00:00';
                         return($dtquery);
                 }
}
?>
