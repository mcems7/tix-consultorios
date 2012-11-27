<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Mensaje extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}
	
	public function obtener($id)
	{
		$this->db->where('id_mensaje', $id);
		$result = $this->db->get('core_mensaje');
		
		if($result->num_rows() == 0)
			return null;
			
		return $result->row_array();
	}
}

?>