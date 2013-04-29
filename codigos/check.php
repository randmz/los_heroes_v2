<?php
session_start();

ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include 'funciones.php';

$aux = "";
$aux = $_REQUEST['aux'];

// verificando rut
// verificando nombre
if($aux == 'rut')
{
  $rut = cambiar_caracteres(trim($_POST['rut']));

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	
	//crear registro en la bd
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass) or die ($error_bd);
	mysql_select_db($dbname);

	$sql_check = mysql_query("select Tipo_usuario from usuarios where Rut='".$rut."'") or die(mysql_error());

	if(mysql_num_rows($sql_check))
	{
		$datos = get_info($rut, '../'); // sacando datos del pensionado
		$ficha = get_ficha($rut, '../'); //sacando datos de la ficha
		
		if($ficha[1]==0){
		$vacio = 0;
		}else{
		$vacio = 1;
		}
		
		echo '<font color="green">El usuario ya existe</font>&&'.$vacio.'&&'.$datos[0].'&&'.$datos[1].'&&'.$datos[2].'&&'.$datos[3].'&&'.$datos[4].'&&'.$datos[5].'&&'.
		$ficha[0][1].'&&'.$ficha[0][2].'&&'.$ficha[0][3].'&&'.$ficha[0][4].'&&'.$ficha[0][5].'&&'.$ficha[0][6];
	}
	else
	{
	echo 'OK';
	}
	
	mysql_free_result($sql_check);
	mysql_close($conecta);
}

if($aux == 'rut-control')
{
	$rut = cambiar_caracteres(trim($_POST['rut']));

	$rut = preg_replace('/\./','',$rut);
	$rut = preg_replace('/,/','',$rut);
	$rut = preg_replace('/-/','',$rut);
	
	//crear registro en la bd
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass) or die ($error_bd);
	mysql_select_db($dbname);

	$sql_check = mysql_query("select Tipo_usuario from usuarios where Rut='".$rut."'") or die(mysql_error());

	if(mysql_num_rows($sql_check))
	{
		$datos = get_info($rut, '../'); // sacando datos del pensionado
		$ficha = get_control($rut, '../'); //sacando datos de la ficha
		$metas = get_metas_nivel($rut, 'ultima', '../'); //sacando las metas
		
		if($ficha[1]==0){
		$vacio = 0;
		}else{
		$vacio = 1;
		}
		
		$resistencia = 0;
		$fortalecimiento = 0;
		$equilibrio = 0;
		$movilidad = 0;
		
		$metas_sep = split(';', $metas[13]);
		
		//SACANDO EL TIPO DE EJERCICIO
		for($i = 0; $i < count($metas_sep); $i++):
			$meta = get_meta_nivel($metas_sep[$i], '../');
			
			switch($meta[1]):
				case 'Actividad_resistencia':
					$resistencia = 1;
					break;
				case 'Actividad_fortalecimiento':
					$fortalecimiento = 1;
					break;
				case 'Actividad_equilibrio':
					$equilibrio = 1;
					break;
				case 'Actividad_movilidad':
					$movilidad = 1;
					break;
				default:
					break;
			endswitch;
			
		endfor;
		
		$actividades = $resistencia.';'.$fortalecimiento.';'.$equilibrio.';'.$movilidad;
		
		//sacando si han pasado 6 semanas
		$fecha_actual = date('d/m/Y');
		list($dia_actual, $mes_actual, $anio_actual) = explode('/', $fecha_actual);
		$numero_dias_actual = intval($dia_actual) + (intval($mes_actual) * 30) + (intval($anio_actual) * 365);
		
		list($dia, $mes, $anio) = explode('/', $ficha[0][0]);
		$numero_dias = intval($dia) + (intval($mes) * 30) + (intval($anio) * 365);
		
		$semanas = 0;
		$seis_semanas = 6 * 7;
				
		//verificando que hayan pasado 6 semanas
		if(($numero_dias_actual - $numero_dias) >= $seis_semanas):
			$semanas = 1;
		endif;
		
		echo '<font color="green">El usuario ya existe</font>&&'.$vacio.'&&'.$datos[0].'&&'.$datos[1].'&&'.$datos[2].'&&'.$datos[3].'&&'.$datos[4].'&&'.$datos[5].'&&'.
		$ficha[0][1].'&&'.$ficha[0][2].'&&'.$ficha[0][3].'&&'.$ficha[0][4].'&&'.$ficha[0][5].'&&'.$ficha[0][6].'&&'.$ficha[0][0].'&&'.$ficha[0][8].'&&'.$actividades.'&&'.$semanas;
	}
	else
	{
	echo 'OK';
	}
	
	mysql_free_result($sql_check);
	mysql_close($conecta);
}

//ajax para seleccionar regiones
if($aux == 'region')
{
	$region = $_POST['region'];

	//sacando las ciudades de la region
	$ciudades = get_ciudades($region);

	$msg = 'OK';

	for($i = 0; $i < count($ciudades); $i++){

	$msg = $msg.'%'.$ciudades[$i];

	}

	echo $msg;
}

//ajax para seleccionar regiones del call center
if($aux == 'call_region')
{
	$region = $_POST['region'];

	//sacando las ciudades de la region
	$ciudades = get_ciudades($region);

	$msg = 'OK';
	
	for($i = 0; $i < count($ciudades); $i++){
	
	$pensionados[$i] = numero_pensionados($region, $i);
	
	$msg = $msg.'-'.$ciudades[$i].'-'.$pensionados[$i];

	}

	echo $msg;
}

//función para el ajax de la ficha
if($aux == 'ficha'){

	$path = 'C:/Respaldo_fichas/';

	if(!is_dir($path)){
		mkdir($path, 0777);
	}
	
	
	
	$nombre_archivo = $path.'ficha.txt';
	
	//abriendo el archivo
	if($archivo = fopen($nombre_archivo, "a+")){
		
		while(!feof($archivo)){ 

			$buffer = fgets($archivo,4096); 
			
			if(!feof($archivo)){
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

		
		fclose($archivo);
		
		//borrando el archivo que tiene las fichas
		unlink($nombre_archivo);
		
		echo 'OK';
	}
}

if($aux == 'contactados'){

$valor = resetear_contactados();

echo 'OK';
}
