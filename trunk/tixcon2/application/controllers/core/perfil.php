<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Perfil extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this -> load -> database();
		$this -> load -> model('core/usuario');
		$this -> load -> model('core/tiempo');
		$this -> load -> helper('form');
		$this -> load -> model('core/Registro'); 
	}
	
	public function index()
	{
		$this -> mostrar();
	}

	public function mostrar()
	{
		// Usuario
		
		$uid = $this -> session -> userdata('id_usuario');
		
		$datos['usuario'] = $this -> usuario -> obtener($uid);
		$this -> load -> view('core/core_inicio');
		$this -> load -> view('core/perfil', $datos);
		$this -> load -> view('core/core_fin');
	}
	
	public function editar()
	{
		
		$d['_password'] = $this -> input -> post('_password');
		$d['password'] = $this -> input -> post('password');
		$d['passwordAct'] = $this -> input -> post('passwordAct');
		$d['id_usuario'] = $this -> session -> userdata('id_usuario');
		
		if($d['_password'] == $d['password']){
		
		$res = $this -> usuario -> cambiarPassword($d);
		if($res){
		
		$this -> Registro -> agregar($d['id_usuario'],'core',__CLASS__,__FUNCTION__
			,'aplicacion',"El usuario ha cambiado la contraseña ");
		
		//----------------------------------------------------
		$dt['mensaje']  = "La contraseña se ha cambiado satisfactoriamente!!";
		$dt['urlRegresar'] 	= site_url("main");
		$this -> load -> view('core/presentacionMensaje', $dt);
		$this -> session -> sess_destroy();
		return;	
		//----------------------------------------------------------
		}else{
			$this -> Registro -> agregar($d['id_usuario'],'core',__CLASS__,__FUNCTION__
				,'aplicacion',"Error al intentar cambiar la contraseña");
			
			//----------------------------------------------------
			$dt['mensaje']  = "La contraseña actual es incorrecta!!";
			$dt['urlRegresar'] 	= site_url("core/perfil/index");
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;	
			//----------------------------------------------------------
		}
		}else{
			$this -> Registro -> agregar($d['id_usuario'],'core',__CLASS__,__FUNCTION__
				,'aplicacion',"Error al intentar cambiar la contraseña");
			
			//----------------------------------------------------
			$dt['mensaje']  = "Error al intentar cambiar la contraseña!!";
			$dt['urlRegresar'] 	= site_url("main");
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;	
			//----------------------------------------------------------
		}
		
		
	}
}

?>
