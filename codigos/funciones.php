´<?php
session_start();

///////////////////////////////////////
//                                   //
//    Código por Hugo Bórquez R.     //
//    pugopugo@hotmail.com           //
//                                   //
///////////////////////////////////////

ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

function cambiar_caracteres($valor){

$valor = preg_replace('/\"/','',$valor);
$valor = preg_replace('/\'/','',$valor);
$valor = preg_replace('/=/','',$valor);
$valor = preg_replace('/&&/','',$valor);
$valor = preg_replace('/|/','',$valor);
$valor = preg_replace('/\*/','',$valor);
$valor = preg_replace('/\\x00/','\\x00',$valor);
$valor = preg_replace('/\\n/','\\n',$valor);
$valor = preg_replace('/\\r/','\\r',$valor);
$valor = preg_replace('/\\x1a/','\\x1a',$valor);

return $valor;
}

function cambiar_caracteres_js($valor){

$valor = preg_replace('/&aacute;/','a',$valor);
$valor = preg_replace('/&eacute;/','e',$valor);
$valor = preg_replace('/&iacute;/','i',$valor);
$valor = preg_replace('/&oacute;/','o',$valor);
$valor = preg_replace('/&uacute;/','u',$valor);
$valor = preg_replace('/&Aacute;/','A',$valor);
$valor = preg_replace('/&Eacute;/','E',$valor);
$valor = preg_replace('/&Iacute;/','I',$valor);
$valor = preg_replace('/&Oacute;/','O',$valor);
$valor = preg_replace('/&Uacute;/','U',$valor);
$valor = preg_replace('/&ntilde;/','n',$valor);
$valor = preg_replace('/&Ntilde;/','N',$valor);

return $valor;
}


function formateo_rut($rut_param){
    
    $parte4 = substr($rut_param, -1); // seria solo el numero verificador
    $parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq 
    $parte2 = substr($rut_param, -7,3); 
    $parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 7 hacia la izq

	if($parte1 != ''){
	$rut = $parte1.".".$parte2.".".$parte3."-".$parte4;
	}else if(substr($rut_param, 0,-4) != ''){
	$rut = $parte2.".".$parte3."-".$parte4;
	}else if(substr($rut_param, 0,-1) != ''){
	$rut = $parte3."-".$parte4;
	}else{
	$rut = $parte4;
	}
	
    return $rut;

}

//función para sacar la información de la ficha de un usuario
function get_ficha($rut, $nivel){

	include $nivel.'trash/conn.php';


	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);

	if($conecta){
		session_start();
				
		$sql_check = mysql_query("SELECT Id_ficha, Fecha, Hora, Peso, Estatura, Cintura, IMC, IMC_riesgo, Cintura_riesgo, (Score_salud + Score_nutricion + Score_actividad_fisica) AS Score_total FROM ficha WHERE Rut_pensionado = '".$rut."'");
		
		if(mysql_num_rows($sql_check)){
		
		for($i = 0; $i < mysql_num_rows($sql_check); $i++){
					
				$row = mysql_fetch_array($sql_check);
				
				$datos[mysql_num_rows($sql_check) - ($i + 1)] = array($row['Fecha'], $row['Peso'], $row['Estatura'], $row['Cintura'], $row['IMC'], $row['IMC_riesgo'], $row['Cintura_riesgo'], $row['Id_ficha'], $row['Score_total'], $row['Hora']);
				
			}
		
		}else{
		//$datos = '';
		//no debería pasar
		}
		
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
		header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
		}
	return $datos;
}

//función para sacar la información del control de un usuario
function get_control($rut, $nivel){

	include $nivel.'trash/conn.php';


	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);

	if($conecta){
		session_start();
				
		$sql_check = mysql_query("SELECT Id_control, Fecha, Hora, Peso, Estatura, Cintura, IMC, IMC_riesgo, Cintura_riesgo, Pregunta1, Pregunta11, Pregunta2, Pregunta21, Pregunta3, Pregunta31 FROM control WHERE Rut_pensionado = '".$rut."'");
		
		if(mysql_num_rows($sql_check)){
		
		for($i = 0; $i < mysql_num_rows($sql_check); $i++){
					
				$row = mysql_fetch_array($sql_check);
				
				$datos[mysql_num_rows($sql_check) - ($i + 1)] = array($row['Fecha'], $row['Peso'], $row['Estatura'], $row['Cintura'], $row['IMC'], $row['IMC_riesgo'], $row['Cintura_riesgo'], $row['Id_control'], $row['Hora'], $row['Pregunta1'], $row['Pregunta11'], $row['Pregunta2'], $row['Pregunta21'], $row['Pregunta3'], $row['Pregunta31']);
				
			}
		
		}else{
		//$datos = '';
		//no debería pasar
		}
		
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
		header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
		}
	return $datos;
}

//función para sacar la información de un usuario
function get_info($rut, $nivel){

	include $nivel.'trash/conn.php';


	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);

	if($conecta){
		session_start();
				
		$sql_check = mysql_query("SELECT Nombre, Edad, Telefono, Region, Ciudad, Sexo, Correo, Centro FROM usuarios WHERE Rut = '".$rut."'");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		
		if($row['Correo'] == '0'){
		$correo = "";
		}else{
		$correo = $row['Correo'];
		}
		
		$datos = array($row['Nombre'], $row['Edad'], $row['Telefono'], $row['Region'], $row['Sexo'], $correo, $row['Ciudad'], $row['Centro']);

		}else{
		$datos = 'no hay';
		//no debería pasar
		}
		
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
		header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
		}
return $datos;
}

//función para el login, ya sea pensionado o evaluador
function login($rut, $pass){
	
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//revisando login
		$sql_check = mysql_query("SELECT Id_usuario, Nombre, Tipo_usuario FROM evaluadores WHERE Nombre='".$rut."' AND Password='".$pass."'");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		
		$_SESSION['rut'] = $rut;
		$_SESSION['nombre'] = $row['Nombre'];
		$_SESSION['permiso'] = $row['Tipo_usuario'];
		$_SESSION['user'] = 'evaluador';
		session_write_close();
		
		$valor = 1;
		
		}else{
		//error de login
		$_SESSION['rut'] = null;
		$_SESSION['nombre'] = null;
		$_SESSION['permiso'] = null;
		$_SESSION['user'] = null;
		session_write_close();
		$valor = 0;
		}
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}

	return $valor;
}

//función para el login interno, para las estadísticas
function login_interno($nombre, $pass){
	
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//revisando login
		$sql_check = mysql_query("SELECT Id_usuario, Rut, Tipo_usuario FROM evaluadores WHERE Nombre='".$nombre."' AND Password='".$pass."'");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		
		$_SESSION['rut'] = $row['Rut'];
		$_SESSION['nombre'] = $nombre;
		$_SESSION['permiso'] = $row['Tipo_usuario'];
		$_SESSION['user'] = 'interno';
		session_write_close();
		$valor = 1;
		
		}else{
		//error de login
		$valor = 0;
		}
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}

	return $valor;
}

//función para el login, ya sea pensionado o evaluador
function login_callcenter($nombre, $pass){
	
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//revisando login
		$sql_check = mysql_query("SELECT Id_usuario, Rut, Is_admin FROM evaluadores WHERE Nombre='".$nombre."' AND Password='".$pass."' AND Tipo_usuario='3'");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		
		$_SESSION['rut'] = $row['Rut'];
		$_SESSION['nombre'] = $nombre;
		$_SESSION['permiso'] = 3;
		$_SESSION['user'] = 'callcenter';
		$_SESSION['is_admin'] = $row['Is_admin'];
		session_write_close();
		$valor = 1;
		
		}else{
		//error de login
		$valor = 0;
		}
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}

	return $valor;
}

function login_pensionado($rut){
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//revisando login
		$sql_check = mysql_query("SELECT Id_usuario, Nombre FROM usuarios WHERE Rut='".$rut."' AND Tipo_usuario=1");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		
		$_SESSION['rut'] = $rut;
		$_SESSION['nombre'] = $row['Nombre'];
		$_SESSION['user'] = 'user';
		//$_SESSION['permiso'] = $row['Tipo_usuario'];
		session_write_close();
		$valor = 1;
		
		}else{
		//error de login
		$valor = 0;
		}
		
		mysql_free_result($sql_check);
		mysql_close($conecta);
		}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}

		return $valor;
}

//funcion para crear o editar a un pensionado
function crear_usuario($rut, $afiliado, $nombre, $nac_fecha, $nac_dia, $nac_mes, $nac_anio, $edad, $sexo, $telefono, $region, $ciudad, $centro, $correo){

	$valor = 0;
	$datos = get_info($rut, '../');

	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();

		if($datos == 'no hay'){
			//usuario nuevo, crear
			mysql_query("INSERT INTO usuarios (Nombre, Rut, Tipo_afiliado, Nac_fecha, Nac_dia, Nac_mes, Nac_anio, Edad, Sexo, Telefono, Region, Ciudad, Centro, Correo) VALUES ('".$nombre."','".$rut."','".$afiliado."','".$nac_fecha."','".$nac_dia."','".$nac_mes."','".$nac_anio."','".$edad."','".$sexo."','".$telefono."','".$region."', '".$ciudad."', '".$centro."', '".$correo."')");
			$valor = $centro;
		}else{
			//usuario existente, editar
			mysql_query("UPDATE usuarios SET Nombre='".$nombre."', Sexo='".$sexo."', Telefono='".$telefono."', Correo='".$correo."' WHERE Rut='".$rut."'");
			
			// viendo si existe la evaluación de esa ficha, para evitar error
			$sql_check = mysql_query("SELECT Centro FROM usuarios WHERE Rut = '".$rut."'");
			
			if(mysql_num_rows($sql_check)){
			
			$row = mysql_fetch_array($sql_check);
			$valor = $row['Centro'];
			
			}else{
			}
		}
		//$valor = 1;
	}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_close($conecta);

	return $valor;
}

//funcion para guardar un pensionado localmente
function guardar_usuario($rut, $nombre, $edad, $sexo, $telefono, $region, $ciudad, $centro, $correo){
	
	if($correo == ''){
		$correo = '0';
	}
	
	$cadena = $rut.':'.$nombre.':'.$edad.':'.$sexo.':'.$telefono.':'.$region.':'.$ciudad.':'.$centro.':'.$correo;
	
	$valor = 0;
	
	$path = 'C:/Respaldo_fichas/';
	$path_backup = 'C:/Respaldo_fichas_NO_BORRAR/';
	
	if(!is_dir($path)){
		mkdir($path);
	}
	
	if(!is_dir($path_backup)){
		mkdir($path_backup);
	}
	
	//abriendo el archivo
	if($archivo = fopen($path.'ficha.txt', "a+")){
		
		//escribiendo en archivo
		fputs($archivo, $cadena); 
		
		fclose($archivo);
		$valor = 1;
	}
	
	$fecha = date('d-m-Y');
	//abriendo el archivo
	if($archivo = fopen($path_backup.'ficha-'.$fecha.'.txt', "a+")){
		
		//escribiendo en archivo
		fputs($archivo, $cadena); 
		
		fclose($archivo);
		$valor = 1;
	}
		//usuario nuevo, crear
	return $valor;
}

//función para crear la ficha
function crear_ficha($evaluador, $rut, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha, $hora){

	$valor = 0;

	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// viendo si existe la evaluación de esa ficha en el mismo día, para evitar error
		$sql_check = mysql_query("SELECT Id_ficha FROM ficha WHERE Rut_pensionado = '".$rut."' AND Fecha = '".$fecha."'");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		$id_ficha = $row['Id_ficha'];
		
		mysql_query("UPDATE ficha SET Evaluador='".$evaluador."', Peso='".$peso."', Estatura='".$estatura."', Cintura='".$cintura."', IMC='".$imc."', IMC_riesgo='".$imc_riesgo."', Cintura_riesgo='".$cintura_riesgo."', Hora = '".$hora."' WHERE Rut_pensionado = '".$rut."' AND Fecha='".$fecha."'");
		mysql_query("UPDATE control SET Peso='".$peso."', Estatura='".$estatura."', Cintura='".$cintura."', IMC='".$imc."', IMC_riesgo='".$imc_riesgo."', Cintura_riesgo='".$cintura_riesgo."', Hora = '".$hora."' WHERE Rut_pensionado = '".$rut."' AND Fecha='".$fecha."'");

		}else{
		
		//crear una ficha del usuario
		mysql_query("INSERT INTO ficha (Evaluador, Fecha, Hora, Peso, Estatura, Cintura, IMC, IMC_riesgo, Cintura_riesgo, Rut_pensionado) VALUES ('".$evaluador."', '".$fecha."', '".$hora."','".$peso."','".$estatura."','".$cintura."','".$imc."','".$imc_riesgo."','".$cintura_riesgo."', '".$rut."')");
		mysql_query("INSERT INTO control (Fecha, Hora, Peso, Estatura, Cintura, IMC, IMC_riesgo, Cintura_riesgo, Rut_pensionado) VALUES ('".$fecha."', '".$hora."','".$peso."','".$estatura."','".$cintura."','".$imc."','".$imc_riesgo."','".$cintura_riesgo."', '".$rut."')");
		}
		
		$valor = 1;
	}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);			
	mysql_close($conecta);

	return $valor;
}

//función para guardar localmente la ficha
function guardar_ficha($rut, $peso, $estatura, $imc, $imc_riesgo, $cintura, $cintura_riesgo, $fecha){
	
	$cadena = ':'.$peso.':'.$estatura.':'.$imc.':'.$imc_riesgo.':'.$cintura.':'.$cintura_riesgo.':'.$fecha;
	
	$valor = 0;
		
	$path = 'C:/Respaldo_fichas/';
	$path_backup = 'C:/Respaldo_fichas_NO_BORRAR/';
	
	if(!is_dir($path)){
		mkdir($path);
	}
	
	if(!is_dir($path_backup)){
		mkdir($path_backup);
	}
	
	//abriendo el archivo
	if($archivo = fopen($path.'ficha.txt', "a+")){
		
		//escribiendo en archivo
		fputs($archivo, $cadena); 
		
		fclose($archivo);
		$valor = 1;
	}
	
	$fecha = date('d-m-Y');
	//abriendo el archivo
	if($archivo = fopen($path_backup.'ficha-'.$fecha.'.txt', "a+")){
		
		//escribiendo en archivo
		fputs($archivo, $cadena); 
		
		fclose($archivo);
		$valor = 1;
	}

	return $valor;
}

//función para guardar las metas
function guardar_metas($id_ficha, $id_meta1, $id_meta2, $id_meta3, $id_meta4, $id_meta5, $id_meta6){

	$cadena = ':'.$id_ficha.':'.$id_meta1.':'.$id_meta2.':'.$id_meta3.':'.$id_meta4.':'.$id_meta5.':'.$id_meta6;
	
	$valor = 0;

	$path = 'C:/Respaldo_fichas/';
	$path_backup = 'C:/Respaldo_fichas_NO_BORRAR/';
	
	if(!is_dir($path)){
		mkdir($path);
	}
	
	if(!is_dir($path_backup)){
		mkdir($path_backup);
	}
	
	//abriendo el archivo
	if($archivo = fopen($path.'ficha.txt', "a+")){
		
		//escribiendo en archivo
		fputs($archivo, $cadena); 
		fputs($archivo,"\n");
		fclose($archivo);
		$valor = 1;
	}
	
	$fecha = date('d-m-Y');
	//abriendo el archivo
	if($archivo = fopen($path_backup.'ficha-'.$fecha.'.txt', "a+")){
		
		//escribiendo en archivo
		fputs($archivo, $cadena); 
		fputs($archivo,"\n");
		fclose($archivo);
		$valor = 1;
	}

	return $valor;
}

//funcion para sacar regiones
function get_regiones(){

	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando el id de la ficha
		$sql_check = mysql_query("SELECT Numero_region, Nombre_region FROM info_regiones ORDER BY Numero_region ASC");
		
		if(mysql_num_rows($sql_check)){
		
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
					
				$row = mysql_fetch_array($sql_check);
				
				$regiones[$i] = array($row['Numero_region'], $row['Nombre_region']);
				
			}
		}else{
		
		}

		}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
	return $regiones;
}

//funcion para sacar centros
function get_centros(){

	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando el id de la ficha
		$sql_check = mysql_query("SELECT Numero_centro, Nombre_centro FROM info_centros ORDER BY Numero_centro ASC");
		
		if(mysql_num_rows($sql_check)){
		
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
					
				$row = mysql_fetch_array($sql_check);
				
				$centros[$i] = array($row['Numero_centro'], $row['Nombre_centro']);
				
			}
		}else{
		
		}

		}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
	return $centros;
}

//función para sacar las ciudades de una región
function get_ciudades($numero_region){
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando las ciudades
		$sql_check = mysql_query("SELECT Sucursal, Tipo FROM info_ciudades WHERE Numero_region = '".$numero_region."' ORDER BY Numero_ciudad ASC");
		
		if(mysql_num_rows($sql_check)){
		
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
					
				$row = mysql_fetch_array($sql_check);
				
				//poner pa' que fuarde las ciudades
				$ciudades[$i] = $row['Sucursal'].' ('.$row['Tipo'].')';
				
			}
		}else{}
		
	}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
	return $ciudades;
}

//función para sacar el nombre y código de la ciudad de una región
function get_ciudad($numero_ciudad, $numero_region){
	//incluyendo conexión
	include 'trash/conn.php';
	
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando las ciudades
		$sql_check = mysql_query("SELECT Ciudad, Codigo_telefonico FROM info_ciudades WHERE Numero_ciudad = '".$numero_ciudad."' AND Numero_region = '".$numero_region."'");
		
		if(mysql_num_rows($sql_check)){
		
			$row = mysql_fetch_array($sql_check);
			$datos = array($row['Ciudad'], $row['Codigo_telefonico']);
			
		}else{}
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
	return $datos;
}

//función para sacar la información del centro a partir de su id
function get_centro($nivel, $numero_centro){
	//incluyendo conexión
	include $nivel.'trash/conn.php';
	
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando las ciudades
		$sql_check = mysql_query("SELECT * FROM info_centros WHERE Numero_centro = '".$numero_centro."'");
		//$sql_check = mysql_query("SELECT Id_centros, Numero_centro, Nombre_centro, Geriatria, Traumatologo, Otorrino, Cardiologia, Dermatologo, Ginecologo, Neurologo, Oftalmologo, Urologo, Ginecobtetra, Cirujano, Salud_mental, Internista, Broncopulmonar, Endocrino, Fonoaudiologo, Gastroenterologo, Inmunologo, Kinesiologo, Nefrologo, Neurocirujano, Nutricionista, Psiquiatra, Psicologo, Reumatologo FROM info_centros WHERE Numero_centro = '".$numero_centro."'");
		
		if(mysql_num_rows($sql_check)){
		
			$row = mysql_fetch_array($sql_check);
			//$datos = array($row['Id_centros'], $row['Numero_centro'], $row['Nombre_centro'], $row['Geriatria'], $row['Traumatologo'], $row['Otorrino'], $row['Cardiologia'], $row['Dermatologo'], $row['Ginecologo'], $row['Neurologo'], $row['Oftalmologo'], $row['Urologo'], $row['Ginecobtetra'], $row['Cirujano'], $row['Salud_mental'], $row['Internista'], $row['Broncopulmonar'], $row['Endocrino'], $row['Fonoaudiologo'], $row['Gastroenterologo'], $row['Inmunologo'], $row['Kinesiologo'], $row['Nefrologo'], $row['Neurocirujano'], $row['Nutricionista'], $row['Psiquiatra'], $row['Psicologo'], $row['Reumatologo']);
		}else{}
		
	}else{
			header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
	//return $datos;
	return $row;
}

//función para sacar el id de una meta
function get_id_meta($tipo, $numero_meta, $categoria){
	
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//sacando el id
		$sql_check = mysql_query("SELECT Id_meta FROM info_metas WHERE Tipo = '".$tipo."' AND Numero_meta = '".$numero_meta."' AND Categoria = '".$categoria."'");
		
		if(mysql_num_rows($sql_check)){
		
				$row = mysql_fetch_array($sql_check);
				
				//poner pa' que fuarde las ciudades
				$id_meta = $row['Id_meta'];

		}else{}
		
	}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	mysql_free_result($sql_check);
	mysql_close($conecta);

return $id_meta;
}

//función para sacar el id de una meta con nivel
function get_id_meta_nivel($tipo, $numero_meta, $categoria, $nivel){
	
	//incluyendo conexión
	include $nivel.'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//sacando el id
		$sql_check = mysql_query("SELECT Id_meta FROM info_metas WHERE Tipo = '".$tipo."' AND Numero_meta = '".$numero_meta."' AND Categoria = '".$categoria."'");
		
		if(mysql_num_rows($sql_check)){
		
				$row = mysql_fetch_array($sql_check);
				
				//poner pa' que fuarde las ciudades
				$id_meta = $row['Id_meta'];

		}else{}
		
	}else{
			header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	mysql_free_result($sql_check);
	mysql_close($conecta);

return $id_meta;
}

//generar 2 numeros al azar, de 3
function random_metas($numero, $cantidad){
	//sacando 1 de 3 metas al azar
	
	if($numero == 1):
		$characters = array("A");
	elseif($numero == 2):
		$characters = array("A","B");
	elseif($numero == 3):
		$characters = array("A","B","C");
	elseif($numero == 32):
		$characters = array("A","C");
	elseif($numero == 4):
		$characters = array("A","B","C", "D");
	elseif($numero == 5):
		$characters = array("A","B","C", "D", "E");
	else:
		$characters = '';
	endif;
	

	//para almacenarlas
	$keys = array();

	while(count($keys) < $cantidad) {
		$x = mt_rand(0, count($characters)-1);
		if(!in_array($x, $keys)) {
		   $keys[] = $x;
		}
	}
	
	$random_chars = array($characters[$keys[0]], $characters[$keys[1]]);
return $random_chars;
}

function crear_metas($rut, $score_salud, $score_nutricion, $score_actividad_fisica, $guardar, $cardio, $cirujano, $trauma, $gine, $urologo, $nutri, $internista, $centro, $sexo, $nutricion, $pregunta51, $fisica, $edad){
	
	//generando metas para salud
	//$cardio, $cirujano, $trauma, $gine, $urologo, $nutri, $internista, $centro
	$especialidades = $cardio + $cirujano + $trauma + $gine + $urologo + $nutri + $internista;
	$importancia = array($cardio, $cirujano, $trauma, $gine, $urologo, $nutri, $internista);
	$especialidad = array('Cardi&oacute;logo', 'Cirujano', 'Traumat&oacute;logo', 'Ginecolog&iacute;a', 'Ur&oacute;logo', 'Nutricionista', 'Internista');
	
	//posición de las especialidades en la bd
	$num_especialidad = array(6, 13, 4, 8, 11, 24, 15);
	
	$aux_coma = 0;
	$aux_esp = 0;
	$info_centro = get_centro('../', $centro);
	
	//definiendo las metas cuando tiene 3 o más especialidades
	if($especialidades >= 3):
		
		//definiendo la meta1
		if($info_centro[15] == 1):
			//el centro tiene internista
			$meta1 = 'Por favor visite a un <u><span class="esp_centro">Internista</span></u>.';
			$esp_centros[] = 'Internista';
			
			if($importancia[6] == 1):
				$cantidad = 2;
			else:
				$cantidad = 1;
			endif;
			
			//meta2
			$meta2 = 'Le recomendamos tambi&eacute;n visitar a los siguientes especialistas: ';
			foreach($importancia as $imp):
				if(($imp == 1)&&($aux_esp != 6)):
					
					if(($aux_coma >= 1)&&($aux_coma != $especialidades - $cantidad)):
						if($sexo == 1):
							if($aux_esp != 3):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ', '.$especialidad[$aux_esp];
								endif;
							endif;
						else:
							if($aux_esp != 4):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ', '.$especialidad[$aux_esp];
								endif;
							endif;
						endif;
					elseif(($aux_coma >= 1)&&($aux_coma == $especialidades - $cantidad)):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ' y <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ' y '.$especialidad[$aux_esp];
								endif;
					else:
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= '<span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= $especialidad[$aux_esp];
								endif;
					endif;
					$aux_coma++;
					
				endif;
				$aux_esp++;
			endforeach;
			$meta2.='.';
			
		elseif($info_centro[3] == 1):
			//el centro tiene geriatría
			$meta1 = 'Por favor visite a un <u><span class="esp_centro">Geriatra</span></u>.';
			$esp_centros[] = 'Geriatra';
			//meta2
			$meta2 = 'Le recomendamos tambi&eacute;n visitar a los siguientes especialistas: ';
			foreach($importancia as $imp):
				if($imp == 1):
					
					if(($aux_coma >= 1)&&($aux_coma != $especialidades - 1)):
						if($sexo == 1):
							if($aux_esp != 3):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ', '.$especialidad[$aux_esp];
								endif;
							endif;
						else:
							if($aux_esp != 4):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ', '.$especialidad[$aux_esp];
								endif;
							endif;
						endif;
					elseif(($aux_coma >= 1)&&($aux_coma == $especialidades - 1)):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ' y <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ' y '.$especialidad[$aux_esp];
								endif;
					else:
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= '<span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= $especialidad[$aux_esp];
								endif;
					endif;
					$aux_coma++;
					
				endif;
				$aux_esp++;
			endforeach;
			$meta2.='.';
		elseif($info_centro[20] == 1):
			//el centro tiene inmunólogo
			$meta1 = 'Por favor visite a un <u><span class="esp_centro">Inmun&oacute;logo</span></u>.';
			$esp_centros[] = 'Inmun&oacute;logo';
			//meta2
			$meta2 = 'Le recomendamos tambi&eacute;n visitar a los siguientes especialistas: ';
			foreach($importancia as $imp):
				if($imp == 1):
					
					if(($aux_coma >= 1)&&($aux_coma != $especialidades - 1)):
						if($sexo == 1):
							if($aux_esp != 3):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ', '.$especialidad[$aux_esp];
								endif;
							endif;
						else:
							if($aux_esp != 4):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ', '.$especialidad[$aux_esp];
								endif;
							endif;
						endif;
					elseif(($aux_coma >= 1)&&($aux_coma == $especialidades - 1)):
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= ' y <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= ' y '.$especialidad[$aux_esp];
								endif;
					else:
								if($info_centro[$num_especialidad[$aux_esp]] == 1):
									$meta2.= '<span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
									$esp_centros[] = $especialidad[$aux_esp];
								else:
									$meta2.= $especialidad[$aux_esp];
								endif;
					endif;
					$aux_coma++;
					
				endif;
				$aux_esp++;
			endforeach;
			$meta2.='.';
		else:
			//cuando no tiene ninguno el centro
			$meta1 = 'Por favor visite a un <u>Internista</u>.';
			if($importancia[6] == 1):
				$cantidad = 2;
			else:
				$cantidad = 1;
			endif;
				//meta2
				$meta2 = 'Le recomendamos tambi&eacute;n visitar a los siguientes especialistas: ';
				foreach($importancia as $imp):
					if(($imp == 1)&&($aux_esp != 6)):
						
						if(($aux_coma >= 1)&&($aux_coma != $especialidades - $cantidad)):
							if($sexo == 1):
								if($aux_esp != 3):
									if($info_centro[$num_especialidad[$aux_esp]] == 1):
										$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
										$esp_centros[] = $especialidad[$aux_esp];
									else:
										$meta2.= ', '.$especialidad[$aux_esp];
									endif;
								endif;
							else:
								if($aux_esp != 4):
									if($info_centro[$num_especialidad[$aux_esp]] == 1):
										$meta2.= ', <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
										$esp_centros[] = $especialidad[$aux_esp];
									else:
										$meta2.= ', '.$especialidad[$aux_esp];
									endif;
								endif;
							endif;
						elseif(($aux_coma >= 1)&&($aux_coma == $especialidades - $cantidad)):
									if($info_centro[$num_especialidad[$aux_esp]] == 1):
										$meta2.= ' y <span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
										$esp_centros[] = $especialidad[$aux_esp];
									else:
										$meta2.= ' y '.$especialidad[$aux_esp];
									endif;
						else:
									if($info_centro[$num_especialidad[$aux_esp]] == 1):
										$meta2.= '<span class="esp_centro">'.$especialidad[$aux_esp].'</span>';
										$esp_centros[] = $especialidad[$aux_esp];
									else:
										$meta2.= $especialidad[$aux_esp];
									endif;
						endif;
						$aux_coma++;
						
					endif;
					$aux_esp++;
				endforeach;
				$meta2.='.';
				
		endif;		
		if($esp_centros != null):
			$aux_centro = 1;
			if(count($esp_centros) == 1):
				$meta3 = 'El '.$esp_centros[0].' mantiene un convenio exclusivo para afiliados de Los H&eacute;roes en centro m&eacute;dico '.$info_centro[2].'. Todos los convenios son para pensionados afiliados a Fonasa nivel 3.';
			else:
				$meta3 = 'Los especialistas ';
				foreach($esp_centros as $esp_c):
					if($aux_centro == 1):
						$meta3.= $esp_c;
						$aux_centro++;
					elseif(($aux_centro > 1)&&($aux_centro < count($esp_centros))):
						$meta3.= ', '.$esp_c;
						$aux_centro++;
					elseif(($aux_centro > 1)&&($aux_centro == count($esp_centros))):
						if($esp_c != 'Internista'):
							$meta3.= ' y '.$esp_c;
						else:
							$meta3.= ' e '.$esp_c;
						endif;
						$aux_centro++;
					endif;
				endforeach;
				$meta3.=' mantienen un convenio exclusivo para afiliados de Los H&eacute;roes en centro m&eacute;dico '.$info_centro[2].'. Todos los convenios son para pensionados afiliados a Fonasa nivel 3.';
			endif;
		else:
			$meta3 = '';
		endif;
		//fin 3 ó más especialidades
	elseif($especialidades == 0):
		//definiendo las metas cuando no tiene especialidades
		if($info_centro[$num_especialidad[6]] == 1):
			$meta1 = 'Si no se ha hecho un chequeo m&eacute;dico en el &uacute;ltimo a&ntilde;o, le recomendamos visitar a un <span class="esp_centro">Internista</span> o M&eacute;dico General.';
		else:
			$meta1 = 'Si no se ha hecho un chequeo m&eacute;dico en el &uacute;ltimo a&ntilde;o, le recomendamos visitar a un Internista o M&eacute;dico General.';
		endif;
		$meta2 = 'Ponga mucha atenci&oacute;n en las pr&oacute;ximas recomendaciones de Nutrici&oacute;n y Actividad F&iacute;sica para su salud.';
		$meta3 = '';
	else:
		//cuando tiene 1 ó 2 especialidades
		$aux_centro = 0;	
		foreach($importancia as $imp):
			if($imp == 1):
				$meta3 = '';
				if($especialidades < 2):
					// 1 especialidad
							if($info_centro[$num_especialidad[$aux_esp]] == 1):
								$meta1= 'Le recomendamos visitar a un <span class="esp_centro">'.$especialidad[$aux_esp].'</span> en centro m&eacute;dico '.$info_centro[2].'.';
							else:
								$meta1= 'Le recomendamos visitar a un '.$especialidad[$aux_esp].' en su centro m&eacute;dico m&aacute;s cercano.';
							endif;
							$meta2 = 'Ponga mucha atenci&oacute;n en las pr&oacute;ximas recomendaciones de Nutrici&oacute;n y Actividad F&iacute;sica para su salud.';
				else:
					// 2 especialidades
							if($info_centro[$num_especialidad[$aux_esp]] == 1):
								if($aux_coma == 0):
									$meta1= 'Le recomendamos visitar a un <span class="esp_centro">'.$especialidad[$aux_esp].'</span> en centro m&eacute;dico '.$info_centro[2].'.';
									$aux_coma++;
									$aux_centro++;
								else:
									if($aux_centro == 0):
										$meta2= 'Le recomendamos adem&aacute;s visitar a un <span class="esp_centro">'.$especialidad[$aux_esp].'</span> en centro m&eacute;dico '.$info_centro[2].'.';
									else:
										$meta2= 'Le recomendamos adem&aacute;s visitar a un <span class="esp_centro">'.$especialidad[$aux_esp].'</span> en el centro m&eacute;dico mencionado anteriormente.';
									endif;
								endif;
							else:
								if($aux_coma == 0):
									$meta1= 'Le recomendamos visitar a un '.$especialidad[$aux_esp].' en su centro m&eacute;dico m&aacute;s cercano.';
									$aux_coma++;
								else:
									$meta2= 'Le recomendamos adem&aacute;s visitar a un '.$especialidad[$aux_esp].'.';
								endif;
								
							endif;
						
				endif;
				$aux_coma++;
				
			endif;
			$aux_esp++;
		endforeach;
				
		// cuando tiene 1 ó 2 especialidades
		
	endif;
	
	$metas_nutricion = '';
	$metas_nutricion_aux = 0;
	
	//METAS DE NUTRICION
	for($i = 0; $i < count($nutricion); $i++):
		if($nutricion[$i] == 1):
			if(($i == 0)||($i == 2)||($i == 5)||($i == 7)||($i == 8)):
				// metas 1, 3, 6, 8 y 9
				$meta_n = random_metas(1, 1);
			elseif(($i == 1)||($i == 6)):
				// metas 2 y 7 
				$meta_n = random_metas(2, 1);
			else:
				// metas 4, 5 y 10
				if(($i == 9)&&($edad < 65)):
					$meta_n = random_metas(32, 1);
				else:
					$meta_n = random_metas(3, 1);
				endif;
			endif;
			
			if($metas_nutricion_aux == 0):
				$metas_nutricion= get_id_meta('Nutricion', $i+1, $meta_n[0]); //tipo, numero meta, categoria
				$metas_nutricion_aux++;
			else:
				$metas_nutricion.= ';'.get_id_meta('Nutricion', $i+1, $meta_n[0]);
			endif;
		endif;
	endfor;
	
	if($pregunta51 == 0):
		//METAS DE ALIMENTACIÓN
		$tipo_comida = random_metas(3,1);

		if($tipo_comida[0] == 'A'):
			//para desayuno
			$comida = random_metas(3,1);
			$texto_comida_largo = get_id_meta('Desayuno', 0, $comida[0]);
		elseif($tipo_comida[0] == 'B'):
			//para almuerzos
			$comida = random_metas(5,1);
			$texto_comida_largo = get_id_meta('Almuerzo', 0, $comida[0]);
		else:
			//para cenas
			$comida = random_metas(4,1);
			$texto_comida_largo = get_id_meta('Cena', 0, $comida[0]);
		endif;
	else:
		$texto_comida_largo = '';
	endif;
	
	//METAS DE ACTIVIDAD FÍSICA
	//array $fisica(12, 12a, 12b, 12c, 12d);
	if($fisica[0] == 0):
		//cuando sí hace act física
		$id_meta5 = '58;59;60';
		$id_meta6 = '';
		$aux = 0;
		
		if($fisica[1] == 0):
			$meta6 = random_metas(4,1);
			if($aux == 0):
				$id_meta6= get_id_meta('Actividad_resistencia', 0, $meta6[0]);
				$aux++;
			else:
				$id_meta6.= ';'.get_id_meta('Actividad_resistencia', 0, $meta6[0]);
			endif;
		endif;
		
		if($fisica[2] == 0):
			$meta6 = random_metas(4,1);
			if($aux == 0):
				$id_meta6= get_id_meta('Actividad_fortalecimiento', 0, $meta6[0]);
				$aux++;
			else:
				$id_meta6.= ';'.get_id_meta('Actividad_fortalecimiento', 0, $meta6[0]);
			endif;
		endif;
		
		if($fisica[3] == 0):
			$meta6 = random_metas(3,1);
			if($aux == 0):
				$id_meta6= get_id_meta('Actividad_equilibrio', 0, $meta6[0]);
				$aux++;
			else:
				$id_meta6.= ';'.get_id_meta('Actividad_equilibrio', 0, $meta6[0]);
			endif;
		endif;
		
		if($fisica[4] == 0):
			$meta6 = random_metas(5,2);
			if($aux == 0):
				$id_meta6= get_id_meta('Actividad_movilidad', 0, $meta6[0]);
				$id_meta6.= ';'.get_id_meta('Actividad_movilidad', 0, $meta6[1]);
				$aux++;
			else:
				$id_meta6.= ';'.get_id_meta('Actividad_movilidad', 0, $meta6[0]);
				$id_meta6.= ';'.get_id_meta('Actividad_movilidad', 0, $meta6[1]);
			endif;
		endif;
		
	else:
		//cuando no hace
		$meta5 = random_metas(3,1);
		$id_meta5 = '61;'.get_id_meta('Actividad_principal', 0, $meta5[0]);
		$id_meta6 = '';
		$aux = 0;
		
		$meta6 = random_metas(4,1);
		if($aux == 0):
			$id_meta6= get_id_meta('Actividad_resistencia', 0, $meta6[0]);
			$aux++;
		else:
			$id_meta6.= ';'.get_id_meta('Actividad_resistencia', 0, $meta6[0]);
		endif;
		
		$meta6 = random_metas(4,1);
		if($aux == 0):
			$id_meta6= get_id_meta('Actividad_fortalecimiento', 0, $meta6[0]);
			$aux++;
		else:
			$id_meta6.= ';'.get_id_meta('Actividad_fortalecimiento', 0, $meta6[0]);
		endif;
		
		$meta6 = random_metas(3,1);
		if($aux == 0):
			$id_meta6= get_id_meta('Actividad_equilibrio', 0, $meta6[0]);
			$aux++;
		else:
			$id_meta6.= ';'.get_id_meta('Actividad_equilibrio', 0, $meta6[0]);
		endif;
		
		$meta6 = random_metas(5,2);
		if($aux == 0):
			$id_meta6= get_id_meta('Actividad_movilidad', 0, $meta6[0]);
			$id_meta6.= ';'.get_id_meta('Actividad_movilidad', 0, $meta6[1]);
			$aux++;
		else:
			$id_meta6.= ';'.get_id_meta('Actividad_movilidad', 0, $meta6[0]);
			$id_meta6.= ';'.get_id_meta('Actividad_movilidad', 0, $meta6[1]);
		endif;
	endif;
	
	//sacando la meta a partir del tipo, letra y rango
	//$id_meta1 = get_id_meta('Salud', $cats_metas_salud[0], $rango_salud);
	//$id_meta2 = get_id_meta('Salud', $cats_metas_salud[1], $rango_salud);
	//$id_meta3 = get_id_meta('Nutricion', $numero_meta, $categoria[0]);
	//$id_meta4 = get_id_meta('Nutricion', $cats_metas_nutricion[1], $rango_nutricion);
	//$id_meta5 = get_id_meta('Actividad Fisica', $cats_metas_actividad_fisica[0], $rango_actividad_fisica);
	//$id_meta6 = get_id_meta('Actividad Fisica', $cats_metas_actividad_fisica[1], $rango_actividad_fisica);
	
	//sacando el id de la ficha
	$fichas = get_ficha($rut, '../');
	$id_ficha = $fichas[0][7];
	
	//incluyendo conexión
	include '../trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//mysql_query("INSERT INTO metas (Id_ficha, Meta1, Meta2, Meta3, Id_meta3, Id_meta4, Id_meta5, Id_meta6) VALUES ('".$id_ficha."','".$meta1."','".$meta2."','".$meta3."','".$metas_nutricion."','".$texto_comida_largo."','".$id_meta5."','".$id_meta6."')");
		
		//viendo si existen metas para una ficha
		$sql_check = mysql_query("SELECT Id_metas FROM metas WHERE Id_ficha = '".$id_ficha."'");
		
		if(mysql_num_rows($sql_check)){
			//actualizar la existente
			mysql_query("UPDATE metas SET Meta1='".$meta1."', Meta2='".$meta2."', Meta3='".$meta3."', Id_meta3='".$metas_nutricion."', Id_meta4='".$texto_comida_largo."', Id_meta5='".$id_meta5."', Id_meta6='".$id_meta6."' WHERE Id_ficha='".$id_ficha."'");
		
		}else{
			//insertar una nueva
			mysql_query("INSERT INTO metas (Id_ficha, Meta1, Meta2, Meta3, Id_meta3, Id_meta4, Id_meta5, Id_meta6) VALUES ('".$id_ficha."','".$meta1."','".$meta2."','".$meta3."','".$metas_nutricion."','".$texto_comida_largo."','".$id_meta5."','".$id_meta6."')");
		}
		
		if($guardar == 1){
		//guardando localmente las metas
		//$valor = guardar_metas($id_ficha, $id_meta1, $id_meta2, $id_meta3, $id_meta4, $id_meta5, $id_meta6);
		}
		
	}else{
			header("Location: ../error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
return $valor;
}

//funcion para sacar la meta
function get_metas($rut, $ficha){

	//sacando el id de la ficha
	$fichas = get_ficha($rut, '');
	
	if($ficha == 'ultima'){
		$id_ficha = $fichas[0][7];
	}else{
		$id_ficha = $ficha;
	}
	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		//$id_metas = array();
		
		// sacando los id de las metas para una ficha
		$sql_check = mysql_query("SELECT Meta1, Meta2, Meta3, Id_meta3, Id_meta4, Id_meta5, Id_meta6 FROM metas WHERE Id_ficha = '".$id_ficha."' ORDER BY Id_metas DESC");
		
		if(mysql_num_rows($sql_check)){
		
		$row = mysql_fetch_array($sql_check);
		
		//poner pa' que fuarde las metas
		$id_metas = array($row['Meta1'], $row['Meta2'], $row['Meta3'], $row['Id_meta3'], $row['Id_meta4'], $row['Id_meta5'], $row['Id_meta6']);

		}else{
		
		}
		
		$aux = 1;
		// sacando las metas a partir de su id
		
		for($i = 0; $i<count($id_metas); $i++):
			
			if($i < 3):
				$meta[$aux] = $id_metas[$i];
				$tipo[$aux] = 'Salud';
				
				$aux++;
			elseif($i < 4):
				$meta[$aux] = $id_metas[$i];
				$tipo[$aux] = 'Nutricion';
				
				$aux++;
			elseif($i < 5):
				$meta[$aux] = $id_metas[$i];
				
				if($meta[$aux]):
					$tipo[$aux] = 'Comida';
				else:
					$tipo[$aux] = '';
				endif;
				
				$aux++;
			elseif($i < 6):
				$meta[$aux] = $id_metas[$i];
				$tipo[$aux] = 'Actividad Fisica';
				
				$aux++;
			else:
				$meta[$aux] = $id_metas[$i];
				$tipo[$aux] = 'Ejercicios Actividad Fisica';
				
				$aux++;
			endif;
		
		endfor;
		
		$metas = array($tipo[1], $meta[1], $tipo[2], $meta[2], $tipo[3], $meta[3], $tipo[4], $meta[4], $tipo[5], $meta[5], $tipo[6], $meta[6], $tipo[7], $meta[7]);
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
	mysql_free_result($sql_check);
	mysql_free_result($sql_check2);
	mysql_close($conecta);
	
	return $metas;
}

//funcion para sacar la meta desde otro nivel 
function get_meta_nivel($id, $nivel){

	//incluyendo conexión
	include $nivel.'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// cuando saca el id_metas
		$sql_check2 = mysql_query("SELECT Tipo, Meta FROM info_metas WHERE Id_meta = '".$id."'");
		
		
		if(mysql_num_rows($sql_check2)){
		
		$row = mysql_fetch_array($sql_check2);
		$meta = array($row['Meta'],$row['Tipo']);

		}else{
		
		}
	}else{
			header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}

	mysql_free_result($sql_check2);
	mysql_close($conecta);
	
	return $meta;
}

//función para sacar la cantidad de veces que ha hecho una rutina en el control
function get_cantidad_rutina($ejercicio, $nivel){

	//incluyendo conexión
	include $nivel.'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	$cantidad = 0;
	
	if($conecta){
		session_start();
		
		// cuando saca el id_metas
		$sql_check2 = mysql_query("SELECT Pregunta31 FROM control WHERE Pregunta31 IS NOT NULL AND Pregunta3 = '1'");
		
		if(mysql_num_rows($sql_check2)){
		
		for($i = 0; $i < mysql_num_rows($sql_check2); $i++){	
		
			$row = mysql_fetch_array($sql_check2);

			$ejercicios = split(';', $row['Pregunta31']);
			
			//revisando para aumenta el número
			switch($ejercicio):
				case 'resistencia':
					if($ejercicios[0] == 1):
						$cantidad++;
					endif;
					break;
				case 'fortalecimiento':
					if($ejercicios[1] == 1):
						$cantidad++;
					endif;
					break;
				case 'equilibrio':
					if($ejercicios[2] == 1):
						$cantidad++;
					endif;
					break;
				case 'movilidad articular':
					if($ejercicios[3] == 1):
						$cantidad++;
					endif;
					break;
				default:
					
					break;
			endswitch;
			
			}
		}else{}
	}else{
			header("Location: ".$nivel."error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}

	mysql_free_result($sql_check2);
	mysql_close($conecta);
	
	return $cantidad;
}

/* otras funciones de la evaluación, fichas, control y metas / código protegido */

// FUNCIONES PAL CALL CENTER!!!!
// FUNCIONES PAL CALL CENTER!!!!
// FUNCIONES PAL CALL CENTER!!!!

//función para sacar el rut de un pensionado al azar
function pensionado_azar($region, $ciudad){

	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando los id de las metas para una ficha
		$sql_check = mysql_query("SELECT Rut FROM usuarios WHERE Region = '".$region."' AND Ciudad = '".$ciudad."' AND Llamado != '2'");
		
		if(mysql_num_rows($sql_check)){
		
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
					
				$row = mysql_fetch_array($sql_check);
				
				//verificando lo de la fecha
				$fichas = get_ficha($row['Rut'], '');
				
				$fecha_actual = date('d/m/Y');
				list($dia_actual, $mes_actual, $anio_actual) = explode('/', $fecha_actual);
				$numero_dias_actual = intval($dia_actual) + (intval($mes_actual) * 30) + (intval($anio_actual) * 365);
				
				$fecha = $fichas[0][0];
				list($dia, $mes, $anio) = explode('/', $fecha);
				$numero_dias = intval($dia) + (intval($mes) * 30) + (intval($anio) * 365);
				
				$seis_semanas = 6 * 7;
				
				//poner pa' que fuarde las rut
				/*if(($numero_dias_actual - $numero_dias) >= $seis_semanas){
				$ruts[$i] = $row['Rut'];
				}*/
				$ruts[$i] = $row['Rut'];
			}
		}else{
		
		}
		
		//sacando un número al azar del arreglo
		$numero = array_rand($ruts, 1);
		
		//sacando el valor del número seleccionado aleatoriamente
		$rut_pensionado = $ruts[$numero];
		
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_free_result($sql_check2);
	mysql_close($conecta);
	
return $rut_pensionado;
}

/* otras funciones de call center / código protegido */

/* total de línea de código sin proteger: 2752 */

