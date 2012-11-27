<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Autenticacion extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this -> load -> model('core/Autenticador');
		$this -> load -> model('core/Registro'); 
	}
	
	public function login()
	{
		///////////////////////////////////////////////////////
		
		$this -> load -> helper('url');
		$this -> load -> model('core/Registro');
		$this -> load -> model('core/Usuario');
		
		// Verificar si existe una sesiï¿½n de usuario vigente

		$this -> load -> library('session');

		$session_username = $this -> session -> userdata('username');
		
		if ($session_username !== false)
		{
			// Terminar sesiï¿½n activa
			
			$this -> logout(false);
		}
		
		///////////////////////////////////////////////////////

		// Revisar que existan los parï¿½metros requeridos: username, password
		
		$username = $this -> input -> post('username', true);
		$password = $this -> input -> post('password', true);

		if ($username === false || $password === false)
		{
			// Generar un registro del evento sucedido

			$this -> Registro -> agregar('1', 'core', __CLASS__, __FUNCTION__, 
			                             'sistema', 'Parámetros incompletos.');

			// Terminar sesiï¿½n activa
			
			$this -> logout(false);

			// Redirecciona al inicio con condiciï¿½n de error
			
			redirect('main/index/1', 'location');
			
			exit;
		}
		
		///////////////////////////////////////////////////////

		// Determinar los parï¿½metros mï¿½dulo/controlador/acciï¿½n solicitados,
		// si no son especificados por el usuario externamente, se toman
		// los valores por defecto

		$modulo_solicitado = $this -> input -> post('modulo_solicitado', true);

		if ($modulo_solicitado === false)
			$modulo_solicitado = "core";

		$controlador_solicitado = $this -> input -> post('controlador_solicitado', true);

		if ($controlador_solicitado === false)
			$controlador_solicitado = "home";

		$accion_solicitado = $this -> input -> post('accion_solicitado', true);
		
		if ($accion_solicitado === false)
			$controlador_solicitado = "index";
		
		///////////////////////////////////////////////////////

		// Verificar la autenticidad del usuario
		
		$info = $this -> Usuario -> validar($username, $password);

		// Si falla la verificaciï¿½n, redireccionar con mensaje de error
		
		if ($info === false)
		{
			// Generar un registro del evento sucedido

			$this -> Registro -> agregar('1', 'core', __CLASS__, __FUNCTION__, 
			                             'sistema', "Autenticación fallida: {$username}.");

			// Terminar sesiï¿½n activa
			
			$this -> logout(false);

			// Redirecciona al inicio con condiciï¿½n de error

			redirect('main/index/2', 'location');
			
			exit;
		}
		
		///////////////////////////////////////////////////////

		// Usuario autenticado!
		
		$usuario = $this -> Usuario -> obtenerPorNombreUsuario($username);
		
		// Se crea la sesiï¿½n con la informaciï¿½n del usuario autenticado
		
		$this -> session -> set_userdata('id_usuario', $usuario['id_usuario']);
		$this -> session -> set_userdata('username',   $usuario['_username']);
		$this -> session -> set_userdata('password',   $usuario['_password']);
		$this -> session -> set_userdata('nombres',    $usuario['nombres']);
		$this -> session -> set_userdata('apellidos',  $usuario['apellidos']);
		
		// Generar un registro del evento sucedido
		
		$this -> Registro -> agregar($usuario['id_usuario'], 'core', __CLASS__, __FUNCTION__, 
		                             'sistema', "Autenticación exitosa: {$usuario['_username']}.");
		
		// Se redirige al cliente a la secciï¿½n solicitada
		// Nota: la verificaciï¿½n de permisos (basada en hooks) es la responsable
		//       de determinar si el usuario puede o no acceder a la secciï¿½n
		//       solicitada.
		
		$destino = $modulo_solicitado . "/" . $controlador_solicitado . "/" . $accion_solicitado;

		redirect($destino, 'location');

		exit;

		///////////////////////////////////////////////////////
	}
	
	public function logout($registrar=true)
	{
		return $this -> Autenticador -> logout($registrar);
	}
}

?>
