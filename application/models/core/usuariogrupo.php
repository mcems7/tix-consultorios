<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Usuariogrupo extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}
	
	public function obtenerGruposDeUsuario($id_usuario)
	{
		$this->db->where('id_usuario', $id_usuario);
		$result = $this->db->get('core_usuario_grupo');
		
		return $result->result_array();
	}
}
?>