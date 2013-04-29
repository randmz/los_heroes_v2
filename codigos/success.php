<?php
session_start();

ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

//require_once '../trash/conn.php';
//incluyendo las funciones
include 'funciones.php';

$tipo = $_REQUEST['tipo'];

switch($tipo){

case 'login':
  $rut = cambiar_caracteres($_POST['login_rut']);
	$password = $_POST['login_password'];

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	$rut = preg_replace('/:/','',$rut);
	$rut = preg_replace('/Ã±/','&ntilde;',$rut);
	$rut = preg_replace('/Ã‘/','&Ntilde;',$rut);
	//$rut = ucfirst($rut);
	$rut = strtoupper($rut);
	
	$password = preg_replace('/Ã±/','&ntilde;',$password);
	$password = preg_replace('/Ã‘/','&Ntilde;',$password);
	
	$password = strtoupper($password);
	$password = md5($password);
	
	$valor = login($rut, $password);

	if($valor == 0){
		header("Location: ../error.php?tipo=login");
	}else{
		// enviar a la página pa' evaluar
		header("Location: ../evaluar-opciones.php");
	}

break; //fin login

//para las estadísticas básicas
case 'login_interno':
	$rut = cambiar_caracteres($_POST['login_rut']);
	$password = md5(strtolower($_POST['login_password']));

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	$rut = preg_replace('/:/','',$rut);
	
	$rut = strtolower($rut);
	
	$valor = login_interno($rut, $password);

	if($valor == 0){
	header("Location: ../error.php?tipo=login");
	}else{
	// enviar a la página pa' evaluar
	header("Location: ../estadisticas.php");
	}

break; //fin login

//para las estadísticas de sw
case 'login_interno_sw':
	$rut = cambiar_caracteres($_POST['login_rut']);
	$password = md5(strtolower($_POST['login_password']));

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	$rut = preg_replace('/:/','',$rut);
	
	$rut = strtolower($rut);
	
	$valor = login_interno($rut, $password);

	if($valor == 0){
	header("Location: ../error.php?tipo=login");
	}else{
	// enviar a la página pa' evaluar
	header("Location: ../estadisticas_sw.php");
	}

break; //fin login

case 'login_pensionado':
	$rut = cambiar_caracteres($_POST['rut']);
	
	//sacando caracteres (punto, coma, guión)
	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	$rut = preg_replace('/:/','',$rut);
	
	$rut = strtolower($rut);
	
	$valor = login_pensionado($rut);
	
	if($valor == 0){
	header("Location: ../error.php?tipo=login_pensionado");
	}else{
	// enviar a la página pa' evaluar
	header("Location: ../index_usuario.php");
	}
	
break;

case 'login_callcenter':
	$nombre = strtolower(cambiar_caracteres($_POST['login_nombre']));
	$password = md5(strtolower($_POST['login_password']));
	
	//sacando caracteres (punto, coma, guión)
	$nombre = preg_replace('/\./','',$nombre);
	$nombre = preg_replace('/,/','',$nombre);
	$nombre = preg_replace('/-/','',$nombre);
	$nombre = preg_replace('/:/','',$nombre);
	
	$valor = login_callcenter($nombre, $password);
	
	if($valor == 0){
	header("Location: ../error.php?tipo=login");
	}else{
	// enviar a la página del callcenter
	header("Location: ../callcenter.php");
	}
	
break;

case 'logout':
	$_SESSION['rut'] = null;
	$_SESSION['nombre'] = null;
	header("Location: ../login.php");
	
break; //fin logout

case 'logout_callcenter':
	$_SESSION['rut'] = null;
	$_SESSION['nombre'] = null;
	header("Location: ../login-callcenter.php");
	
break; //fin logout callcenter

case 'logout_interno':
	$_SESSION['rut'] = null;
	$_SESSION['nombre'] = null;
	header("Location: ../login-interno.php");
	
break; //fin logout interno

case 'logout_pensionado':
	$_SESSION['rut'] = null;
	$_SESSION['nombre'] = null;
	header("Location: ../login-pensionado.php");
	
break; //fin logout pensionado

case 'crear_ficha':
	$score_total = 0;
	$score_salud = 0;
	$score_nutricion = 0;
	$score_actividad_fisica = 0;
	
	// datos personales
	$rut = cambiar_caracteres($_POST['rut']);

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	$rut = preg_replace('/:/','',$rut);
	
	$afiliado = cambiar_caracteres($_POST['afiliado']);
	
	$nombre = cambiar_caracteres($_POST['nombre']);
	
	$nombre = preg_replace('/Ã¡/','&aacute;',$nombre);
	$nombre = preg_replace('/Ã©/','&eacute;',$nombre);
	$nombre = preg_replace('/Ã­/','&iacute;',$nombre);
	$nombre = preg_replace('/Ã³/','&oacute;',$nombre);
	$nombre = preg_replace('/Ãº/','&uacute;',$nombre);
	$nombre = preg_replace('/Ã±/','&ntilde;',$nombre);
	$nombre = preg_replace('/Ã‘/','&Ntilde;',$nombre);
	
	$nombre = preg_replace('/:/','',$nombre);
	
	$nombre = ucwords(strtolower($nombre)); //para que quede todo en minúsculas, menos la primera letra
	
	$nac_fecha = cambiar_caracteres($_REQUEST['date1']);
	list($nac_anio, $nac_mes, $nac_dia) = explode('-', $nac_fecha);
	
	$dia_actual = date('d');
	$mes_actual = date('m');
	$anio_actual = date('Y');
	
	$edad = $anio_actual - $nac_anio;
	if($mes_actual == $nac_mes):
		if($dia_actual < $nac_dia):
			$edad--;
		endif;
	elseif($mes_actual < $nac_mes):
		$edad--;
	endif;
	
	if((isset($_POST['edad']))&&($edad == '')):
		$edad = $_POST['edad'];
	endif;
	
	//$edad = cambiar_caracteres($_POST['edad']);
	//$edad = preg_replace('/:/','',$edad);
	
	$sexo = cambiar_caracteres($_POST['sexo']);
	$telefono = cambiar_caracteres($_POST['telefono']);
	$telefono = preg_replace('/:/','',$telefono);
	$region = $_POST['region'];
	$ciudad = $_POST['ciudad'];
	$centro = $_POST['centro'];
	
	if(isset($_POST['correo'])){
	$correo = cambiar_caracteres($_POST['correo']);
	$correo = preg_replace('/:/','',$correo);
	}else{
	$correo = "0";
	}
	
	
	//ingresando o editando el usuario
	$centro = crear_usuario($rut, $afiliado, $nombre, $nac_fecha, $nac_dia, $nac_mes, $nac_anio, $edad, $sexo, $telefono, $region, $ciudad, $centro, $correo);
	//guardando datos
	//$valor = guardar_usuario($rut, $nombre, $edad, $sexo, $telefono, $region, $ciudad, $correo);
	
	if($_SESSION['permiso']==2){
	// datos de la ficha
	$peso = cambiar_caracteres(preg_replace('/,/','.',$_POST['peso']));
	$peso = preg_replace('/:/','.',$peso);
	$estatura = cambiar_caracteres(preg_replace('/,/','.',$_POST['estatura']));
	$estatura = preg_replace('/:/','.',$estatura);
	$imc = cambiar_caracteres($_POST['imc']);
	$imc_riesgo = cambiar_caracteres($_POST['imc_riesgo']);
	$cintura = cambiar_caracteres(preg_replace('/,/','.',$_POST['cintura']));
	$cintura = preg_replace('/:/','.',$cintura);
	$cintura_riesgo = cambiar_caracteres($_POST['cintura_riesgo']);	
	
	//$fecha = $fecha = date('d/m/Y/H/i');
	$fecha = date('d/m/Y'); // W es para guardar el número de la semana del año, para sacar después las metas por semana
	$hora = date('H:i:s');
	//sacando el nombre del evaluador
	$evaluador = $_SESSION['nombre'];
	
	//ingresando la ficha
	$valor = crear_ficha($evaluador, $rut, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha, $hora);
	//guardando la ficha localmente
	//$valor = guardar_ficha($rut, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha);
	
	//SALUD
	$pregunta1 = cambiar_caracteres($_POST['pregunta1']);
	$pregunta1b = cambiar_caracteres($_POST['pregunta1b']);
	$pregunta1c = cambiar_caracteres($_POST['pregunta1c']);
	$pregunta1d = cambiar_caracteres($_POST['pregunta1d']);
	$pregunta41 = cambiar_caracteres($_POST['pregunta41']);
	$pregunta42 = cambiar_caracteres($_POST['pregunta42']);
	$pregunta43 = cambiar_caracteres($_POST['pregunta43']);
	$pregunta43a = cambiar_caracteres($_POST['pregunta43a']);
	$pregunta43b = cambiar_caracteres($_POST['pregunta43b']);
	$pregunta43c = cambiar_caracteres($_POST['pregunta43c']);
	$pregunta43d = cambiar_caracteres($_POST['pregunta43d']);
	$pregunta44 = cambiar_caracteres($_POST['pregunta44']);
	$pregunta45 = cambiar_caracteres($_POST['pregunta45']);
	
	if($pregunta1 == null) $pregunta1 = 0;
	if($pregunta1b == null)	$pregunta1b = 0;
	if($pregunta1c == null)	$pregunta1c = 0;
	if($pregunta1d == null)	$pregunta1d = 0;
	if($pregunta41 == null)	$pregunta41 = 0;
	if($pregunta42 == null)	$pregunta42 = 0;
	if($pregunta43 == null)	$pregunta43 = 0;
	if($pregunta43a == null) $pregunta43a = 0;
	if($pregunta43b == null) $pregunta43b = 0;
	if($pregunta43c == null) $pregunta43c = 0;
	if($pregunta43d == null) $pregunta43d = 0;
	if($pregunta44 == null) $pregunta44 = 0;
	if($pregunta45 == null) $pregunta45 = 0;
	
	// iniciando valores 0 en especialidades
	$trauma = 0;
	$cirujano = 0;
	$internista = 0;
	$nutri = 0;
	$urologo = 0;
	$gine = 0;
	$cardio = 0;
	
	// colocando si debe ir a esa especialidad
	$trauma = $pregunta41;
	
	if($sexo == 0):
	$gine = $pregunta43;
	endif;
	
	$cirujano = $pregunta44;
	$internista = $pregunta45;
	if($imc > 30) $nutri = 1;
	

	$score_salud = $pregunta41 + $pregunta43 + $pregunta44 + $pregunta45 + $nutri;
	
	if( (($pregunta1b == 1)||($pregunta1c == 1))&&($pregunta42 == 1) ): 
		$score_salud++;
		$cardio = 1;
		endif;
	
	if( (($pregunta43a == 1) || ( $pregunta43b + $pregunta43c + $pregunta43d >= 2))&&($sexo == 1) ):
		$score_salud++;
		$urologo = 1;
		endif;
	
	
	//NUTRICION
	$pregunta4 = cambiar_caracteres($_POST['pregunta4']);
	$pregunta5 = cambiar_caracteres($_POST['pregunta5']);
	$pregunta51 = cambiar_caracteres($_POST['pregunta51']);
	$pregunta52 = cambiar_caracteres($_POST['pregunta52']);
	$pregunta6 = cambiar_caracteres($_POST['pregunta6']);
	$pregunta7 = cambiar_caracteres($_POST['pregunta7']);
	$pregunta8 = cambiar_caracteres($_POST['pregunta8']);
	$pregunta9 = cambiar_caracteres($_POST['pregunta9']);
	$pregunta10 = cambiar_caracteres($_POST['pregunta10']);
	$pregunta11 = cambiar_caracteres($_POST['pregunta11']);
	
	if($pregunta4 == null)
		$pregunta4 = 0;
	if($pregunta5 == null)
		$pregunta5 = 0;
	if($pregunta51 == null)
		$pregunta51 = 0;
	if($pregunta52 == null)
		$pregunta52 = 0;
	if($pregunta6 == null)
		$pregunta6 = 0;
	if($pregunta7 == null)
		$pregunta7 = 0;
	if($pregunta8 == null)
		$pregunta8 = 0;
	if($pregunta9 == null)
		$pregunta9 = 0;
	if($pregunta10 == null)
		$pregunta10 = 0;
	if($pregunta11 == null)
		$pregunta11 = 0;
		
	if($pregunta52 == 1):
		$pregunta6 = 0;
	endif;
	
	$score_nutricion = $pregunta4 + $pregunta5 + $pregunta6 + $pregunta7 + $pregunta8 + $pregunta9 + $pregunta10 + $pregunta11;
	
	$nutricion = array($pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta52, 1);
	
	//ACTIVIDAD FISICA
	$pregunta12 = cambiar_caracteres($_POST['pregunta12']);
	$pregunta12a = cambiar_caracteres($_POST['pregunta12a']);
	$pregunta12b = cambiar_caracteres($_POST['pregunta12b']);
	$pregunta12c = cambiar_caracteres($_POST['pregunta12c']);
	$pregunta12d = cambiar_caracteres($_POST['pregunta12d']);
	
	if($pregunta12 == null)
		$pregunta12 = 0;
	if($pregunta12a == null)
		$pregunta12a = 0;
	if($pregunta12b == null)
		$pregunta12b = 0;
	if($pregunta12c == null)
		$pregunta12c = 0;
	if($pregunta12d == null)
		$pregunta12d = 0;
		
	$fisica = array($pregunta12, $pregunta12a, $pregunta12b, $pregunta12c, $pregunta12d);
	
	$score_actividad_fisica = $pregunta12;
	
	$score_total = $score_salud + $score_nutricion + $score_actividad_fisica;
	
	//ingresando los scores en la ficha
	$valor = crear_scores($score_salud, $score_nutricion, $score_actividad_fisica, $fecha, $rut);
	//guardando los scores
	//$valor = guardar_scores($score_salud, $score_nutricion, $score_actividad_fisica, $fecha, $rut);
	
	//creando los resultados de la ficha
	$valor = crear_evaluacion($pregunta1, $pregunta1b, $pregunta1c, $pregunta1d, $pregunta41, $pregunta42, $pregunta43, $pregunta43a, $pregunta43b, $pregunta43c, $pregunta43d, $pregunta44, $pregunta45, $pregunta4, $pregunta5, $pregunta51, $pregunta52, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta10, $pregunta11, $pregunta12, $pregunta12a, $pregunta12b, $pregunta12c, $pregunta12d, $fecha, $rut);
	//guardar la evaluacion
	//$valor = guardar_evaluacion($pregunta1, $pregunta1a, $pregunta1b, $pregunta1c, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta9a, $pregunta10a, $pregunta10b, $pregunta10c, $pregunta11, $pregunta11a, $pregunta12, $pregunta12a, $fecha, $rut);
	
	$guardar = 1;
	
	//ingresando (y guardando en el local) las metas
	$valor = crear_metas($rut, $score_salud, $score_nutricion, $score_actividad_fisica, $guardar, $cardio, $cirujano, $trauma, $gine, $urologo, $nutri, $internista, $centro, $sexo, $nutricion, $pregunta51, $fisica, $edad);
	}
	
	header("Location: ../exito.php?tipo=ficha&score=".$score_total."&rut=".$rut);
	
break;

case 'crear_control':
	
	// datos personales
	$rut = cambiar_caracteres($_POST['rut-control']);

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	$rut = preg_replace('/:/','',$rut);
		
	// datos de la ficha
	$peso = cambiar_caracteres(preg_replace('/,/','.',$_POST['peso-control']));
	$peso = preg_replace('/:/','.',$peso);
	
	$estatura = cambiar_caracteres(preg_replace('/,/','.',$_POST['estatura-control']));
	$estatura = preg_replace('/:/','.',$estatura);
	
	$imc = cambiar_caracteres($_POST['imc-control']);
	$imc_riesgo = cambiar_caracteres($_POST['imc_riesgo-control']);
	
	$cintura = cambiar_caracteres(preg_replace('/,/','.',$_POST['cintura-control']));
	$cintura = preg_replace('/:/','.',$cintura);
	
	$cintura_riesgo = cambiar_caracteres($_POST['cintura_riesgo-control']);		
	
	//$fecha = $fecha = date('d/m/Y/H/i');
	$fecha = date('d/m/Y'); // W es para guardar el número de la semana del año, para sacar después las metas por semana
	$hora = date('H:i:s');
	//sacando el nombre del evaluador
	$evaluador = $_SESSION['nombre'];
	
	//preguntas del control
	$pregunta1 = cambiar_caracteres($_POST['control1']);
	$pregunta1_razon = cambiar_caracteres($_POST['control11']);
	
	$pregunta2 = cambiar_caracteres($_POST['control2']);
	$pregunta2_razon = cambiar_caracteres($_POST['control21']);
	
	$pregunta3 = cambiar_caracteres($_POST['control3']);
	$pregunta3_razon = cambiar_caracteres($_POST['control31']);
	
	if(($pregunta3 == 0)&&($pregunta3_razon == null)):
		$pregunta3_razon = 0;
	endif;
	
	if($pregunta3 == 1):
		$pregunta32a = cambiar_caracteres($_POST['control32a']);
		$pregunta32b = cambiar_caracteres($_POST['control32b']);
		$pregunta32c = cambiar_caracteres($_POST['control32c']);
		$pregunta32d = cambiar_caracteres($_POST['control32d']);
		
		$pregunta3_razon = $pregunta32a.';'.$pregunta32b.';'.$pregunta32c.';'.$pregunta32d;
	endif;

	
	//ingresando la ficha
	$valor = crear_control($rut, $evaluador, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha, $hora, $pregunta1, $pregunta1_razon, $pregunta2, $pregunta2_razon, $pregunta3, $pregunta3_razon);
	//guardando la ficha localmente
	//$valor = guardar_ficha($rut, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha);
	
	header("Location: ../exito.php?tipo=control&rut=".$rut);
	
break;

//para subir el respaldo de la ficha
case 'subir_ficha':

if (is_uploaded_file($_FILES['myFile']['tmp_name'])){
  
	$allowed_filetypes = array('.txt'); // Extensiones permitidas
	
	$partes_ruta = pathinfo($_FILES['myFile']['name']);
	$fileExt = $partes_ruta['extension'];
	$ext = '.' . $fileExt;
	
	// Para ver si está permitido ese tipo de archivo.
	if(in_array($ext,$allowed_filetypes)){
	
		$filePointer = fopen($_FILES['myFile']['tmp_name'], "rb");
		if ($filePointer!=false){
		while (!feof($filePointer)){
		  $buffer = fgets($filePointer, 4096);
			
		  if(!feof($filePointer)){
				$datos = explode(':', $buffer);
				
				//datos del usuario
				$rut = $datos[0];
				$nombre = $datos[1];
				$edad = $datos[2];
				$sexo = $datos[3];
				$telefono = $datos[4];
				$region = $datos[5];
				$ciudad = $datos[6];
				$correo = $datos[7];
				
				//ingresando o editando el usuario
				$valor = crear_usuario($rut, $nombre, $edad, $sexo, $telefono, $region, $ciudad, $correo);
				
				//datos de la ficha
				$peso = $datos[8];
				$estatura = $datos[9];
				$imc = $datos[10];
				$imc_riesgo = $datos[11];
				$cintura = $datos[12];
				$cintura_riesgo = $datos[13];
				$fecha = $datos[14];
				
				//ingresando la ficha
				$valor = crear_ficha($rut, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha);
				
				//datos de los scores
				$score_salud = $datos[15];
				$score_nutricion = $datos[16];
				$score_actividad_fisica = $datos[17];
				
				//ingresando los scores en la ficha
				$valor = crear_scores($score_salud, $score_nutricion, $score_actividad_fisica, $fecha, $rut);
					
				//datos de la evaluación
				$pregunta1 = $datos[18];
				$pregunta1a = $datos[19];
				$pregunta1b = $datos[20];
				$pregunta1c = $datos[21];
				$pregunta2 = $datos[22];
				$pregunta3 = $datos[23];
				$pregunta4 = $datos[24];
				$pregunta5 = $datos[25];
				$pregunta6 = $datos[26];
				$pregunta7 = $datos[27];
				$pregunta8 = $datos[28];
				$pregunta9 = $datos[29];
				$pregunta9a = $datos[30];
				$pregunta10a = $datos[31];
				$pregunta10b = $datos[32];
				$pregunta10c = $datos[33];
				$pregunta11 = $datos[34];
				$pregunta11a = $datos[35];
				$pregunta12 = $datos[36];
				$pregunta12a = $datos[37];
				
				//creando los resultados de la ficha
				$valor = crear_evaluacion($pregunta1, $pregunta1a, $pregunta1b, $pregunta1c, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $pregunta6, $pregunta7, $pregunta8, $pregunta9, $pregunta9a, $pregunta10a, $pregunta10b, $pregunta10c, $pregunta11, $pregunta11a, $pregunta12, $pregunta12a, $fecha, $rut);
				
				//datos de las metas
				$id_ficha = $datos[38];
				$id_meta1 = $datos[39];
				$id_meta2 = $datos[40];
				$id_meta3 = $datos[41];
				$id_meta4 = $datos[42];
				$id_meta5 = $datos[43];
				$id_meta6 = $datos[44];
				
				$guardar = 0;
				
				//ingresando (y guardando en el local) las metas
				$valor = crear_metas($rut, $score_salud, $score_nutricion, $score_actividad_fisica);
				}

		}

		fclose($filePointer);
		header("Location: ../exito.php?tipo=subir_ficha");
		}
	
	}else{
	  header("Location: ../error.php?tipo=archivo_extension");
	  }
	}
break;

//cuando el call center se logra comunicar con un pensionado
case 'contactado':
	
	$rut_pensionado = $_REQUEST['pensionado'];
	$region = $_REQUEST['region'];
	$ciudad = $_REQUEST['ciudad'];
	
	$meta1_salud = $_POST['meta1_salud'];
	$meta2_salud = $_POST['meta2_salud'];
	$meta1_nutricion = $_POST['meta1_nutricion'];
	$meta2_nutricion = $_POST['meta2_nutricion'];
	$meta1_actividad_fisica = $_POST['meta1_actividad_fisica'];
	$meta2_actividad_fisica = $_POST['meta2_actividad_fisica'];
	
	
	$valor = contacto_llamado($rut_pensionado, $meta1_salud, $meta2_salud, $meta1_nutricion, $meta2_nutricion, $meta1_actividad_fisica, $meta2_actividad_fisica);
	
	header("Location: ../ficha_callcenter.php?region=".$region."&ciudad=".$ciudad);
	
break;

//cuando el call center no se logra comunicar con un pensionado
case 'no_contactado':
	
	$rut_pensionado = $_REQUEST['pensionado'];
	$region = $_REQUEST['region'];
	$ciudad = $_REQUEST['ciudad'];
	
	$valor = contacto_no_llamado($rut_pensionado);
	
	header("Location: ../ficha_callcenter.php?region=".$region."&ciudad=".$ciudad);
	
break;

default:
	header("Location: ../index.php");
break;

}
