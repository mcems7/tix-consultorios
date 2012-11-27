<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Autenticador extends Model
{
	function __construct()
	{
		parent::Model();
		
		$this -> load -> database();
		$this -> load -> helper('url');
		$this -> load -> helper('string');
		$this -> load -> library('session');
		$this -> load -> model('core/Registro');
		$this -> load -> model('core/Usuario');
	}
	
	public function logout($registrar=true)
	{
		// Terminar sesi�n

		if ($registrar)
		{
			// Generar un registro del evento sucedido

			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'), 
			                             'core', __CLASS__, __FUNCTION__, 
			                             'sistema', "Terminar sesi�n: " . $this -> session -> userdata('username') . ".");
		}

		$this -> session -> sess_destroy();
	}
	
	public function getRoutingUrlInfo()
	{
		$this -> router =& load_class('Router');
		
		return array(
			'directory'  => trim_slashes($this -> router -> fetch_directory()),
			'controller' => $this -> router -> fetch_class(),
			'action'     => $this -> router -> fetch_method()
		);
	}
}

?>