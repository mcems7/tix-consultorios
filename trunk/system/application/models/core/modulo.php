<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Modulo extends Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}
	
	public function obtener($id)
	{
		$this->db->where('modulo', $id);
		$result = $this->db->get('core_modulo');
		
		if($result->num_rows() == 0)
			return null;
			
		return $result->row_array();
	}
}

?>