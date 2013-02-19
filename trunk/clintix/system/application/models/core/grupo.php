<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Grupo extends Model
{
	function __construct()
	{
		parent::Model();
		
		$this -> load -> database();
	}
	
	public function obtener($id)
	{
		$this -> db -> where('id_grupo', $id);
		$result = $this -> db -> get('core_grupo');
		
		if($result -> num_rows() == 0)
			return null;
			
		return $result->row_array();
	}
	
	public function estaActivo($id)
	{
		$grupo = $this -> obtener($id);
		
		if ($usuario == null)
			return false;
		
		if($grupo["estado"] == "activo")
			return true;
			
		return false;
	}
	
	function obtenerTodos()
	{
		$this -> db -> orderby('nombre');
		$result = $this -> db -> get('core_grupo');
		
		if($result -> num_rows() == 0)
			return null;
			
		return $result->result_array();
	}
}

?>