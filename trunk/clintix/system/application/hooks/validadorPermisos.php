<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
///////////////////////////////////////////////////////////////////////
       
setlocale(LC_ALL, "es_CO");

putenv("TZ=America/Bogota");

///////////////////////////////////////////////////////////////////////

class ValidadorPermisos
{
	public function validar()
	{		
		////////////////////////////////////////////////////////
		
		$CI = &get_instance();  // Recursos nativos de CodeIgniter
   
   		$CI -> load -> model('core/Autenticador');
   		$CI -> load -> model('core/Permisoentidad');
   		$CI -> load -> model('core/Usuario');
		$CI -> load -> helper('url');
		$CI -> load -> helper('cookie');
		$CI -> load -> database();  

		////////////////////////////////////////////////////////
		
		// Obtener la información de la sección a ejecutarse
		
		$modulo      = $CI -> uri -> segment(1);
		$controlador = $CI -> uri -> segment(2);
		$accion      = $CI -> uri -> segment(3);
		
		if ($controlador == null)
			$controlador = 'main';
		
		if ($accion == null)
			$accion = 'index';
		
		////////////////////////////////////////////////////////

		// Evitar los casos que no requieren validación de permisos
		// ni autenticacián de usuario

		// Página incial (llamado sin parámetros)
		
		if ($modulo === false && $controlador === false && $accion === false)
			return true;
			
		// Página inicial (index - formulario de ingreso)
		
		if ($modulo == "main" /* && $controlador == "index" */)
			return true;
		
		// Permiso Web Service	
		if ($modulo == "servidor_nusoap")
			return true;
		
		// Controlador de autenticacion
		
		if ($modulo == "core" && $controlador == "autenticacion")
			return true;
			
		// Login

		if ($modulo == "core" && $controlador == "login")
			return true;
			
		////////////////////////////////////////////////////////

		// Obtiene la informaci�n del usuario activo de la sesi�n

		$CI -> load -> library('session');

		$id_usuario = $CI -> session -> userdata('id_usuario');
		$username   = $CI -> session -> userdata('username');
		$password   = $CI -> session -> userdata('password');
		
		// Si existe un usuario en la sesi�n
		
		if($id_usuario !== false)
		{
			// El usuario anónimo no puede iniciar una sesión
			
			if ($id_usuario == 1)							// Usuario anónimo
			{
				redirect('main/index/2', 'location');
				exit;
			}
			
			// Verificar que el usuario sea quien dice ser: correspondencia
			// entre el id de usuario, nombre de usuario y contrase�a
			
			$usr = $CI -> Usuario -> obtener($id_usuario);
			
			if($usr['_username'] != $username ||			// usuario
			   $usr['_password'] != $password ||			// contrase�a en MD5
			   $usr['estado'] != 'activo')				// estado activo
			{
				$CI -> Autenticador -> logout();
				redirect('main/index/9', 'location');
				exit;
			}
		}
		
		// Si no existe un usuario en la sesión
		
		if ($id_usuario === false)
		{
			// Verificar si el usuario an�nimo tiene permiso de
			// acceder al m�dulo/controlador/acci�n solicitado
			
			$control = $CI -> Permisoentidad -> validarPermisodeUsuarioSegunSeccion('1', $modulo, $controlador, $accion);
			
			if ($control)
				return true;

			// Tengo problemas no encontr� una sesi�n de usuario y
			// el usuario an�nimo no tiene los permisos necesarios
			
			redirect('main/index/3', 'location');
			exit;
		}
		
		////////////////////////////////////////////////////////

		// Evitar los casos que no requieren validaci�n de permisos
		// pero si requieren de autenticaci�n de usuario
		
		if ($modulo == "core" && $controlador == "home")
		{
			return true;
		}

		if ($modulo == "core" && $controlador == "perfil")
			return true;

		////////////////////////////////////////////////////////
		
		// Verificar que la entidad (en este caso id_usuario) cuente con el
		// permiso necesario para acceder a la secci�n solicitada (m�dulo/controlador/acci�n)

		$CI -> load -> model('core/Permisoentidad');
		
		$res = $CI -> Permisoentidad -> gruposPermisoDenegado($id_usuario,$modulo,$controlador,$accion);
		$CI->load->database();
		//echo $CI->db->last_query();die();
		if($res >= 1){
			redirect('core/home/volverError', 'location');
			exit;
		}
		
		$control1 = $CI -> Permisoentidad -> validarPermisodeUsuarioSegunSeccion('1',         $modulo, $controlador, $accion);
		$control2 = $CI -> Permisoentidad -> validarPermisodeUsuarioSegunSeccion($id_usuario, $modulo, $controlador, $accion);

		if (!$control1 && !$control2)
		{		
			/*redirect('main/index/4', 'location');
			exit;*/
			
			redirect('core/home/volverError', 'location');
			exit;
		}

		////////////////////////////////////////////////////////
		
		return true;
	}
}

?>
