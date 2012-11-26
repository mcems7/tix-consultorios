<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Usuario extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this -> load -> database();
	}
	
	public function obtener($id)
	{
		$this -> db -> where('id_usuario', $id);
		$result = $this -> db -> get('core_usuario');
		
		if($result -> num_rows() == 0)
			return null;
			
		return $result->row_array();
	}
	
	public function obtenerPorNombreUsuario($username)
	{
		$this -> db -> where('_username', $username);
		$result = $this -> db -> get('core_usuario');
		
		if($result -> num_rows() == 0)
			return null;
			
		return $result->row_array();
	}
				
	public function estaActivo($id)
	{
		$usuario = $this -> obtener($id);
		
		if ($usuario == null)
			return false;
		
		if($usuario["estado"] == "Activo")
			return true;
			
		return false;
	}
	
	public function validar($username, $password, $tipo_password='plano')
	{
		$usuario = $this -> obtenerPorNombreUsuario($username);
		
		if ($usuario == null)
			return false;

		if (!$this -> estaActivo($usuario['id_usuario']))
			return false;
			
		if($tipo_password == 'plano')
		{
			if ($usuario["pass"] == md5($password))
				return true;
		}
						
		if($tipo_password == 'md5')
		{
			if ($usuario["pass"] == $password)
				return true;
		}
						
		return false;
	}
	
	function obtenerTodos()
	{
		$result = $this -> db -> get('core_usuario');
		
		if($result -> num_rows() == 0)
			return null;
			
		return $result->result_array();
	}
	
	public function obtenerNombreTercero($id_usuario)
	{
		$this->db->SELECT(' 
  core_usuario.id_usuario,
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre');
$this->db->FROM('core_usuario');
  $this->db->JOIN('core_tercero','core_usuario.numero_documento = core_tercero.numero_documento');
  $this->db->where('core_usuario.id_usuario',$id_usuario);
  $res = $this->db->get();
  return $res->row_array();	
	}
	
	public function cambiarPassword($d)
	{
		$this->db->where('id_usuario',$d['id_usuario']);
		$result = $this->db->get('core_usuario');
		$res = $result -> row_array();
		
		if(md5($d['passwordAct']) == $res['_password']){
			$update = array(
			'_password' => md5($d['_password']),
			'fecha_actualizacion' => date('Y-m-d H:i:s')
			);
			$this->db->where('id_usuario',$d['id_usuario']);
			$this->db->update('core_usuario',$update);
			return true;
		}else{
			return false;
		}
	}
	
	public function validarPassword($id_usuario, $password)
	{
		$usuario = $this -> obtener($id_usuario);
		
		if ($usuario == null)
			return false;
	
		
		if ($usuario["_password"] == md5($password))
				return true;

						
		return false;
	}
}
?>