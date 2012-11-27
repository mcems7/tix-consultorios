<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Home_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerNovedades()
{
	$this->db->order_by('fecha_publicacion','desc');
	$result = $this->db->get('core_novedades');
	$num = $result -> num_rows();
	if($num == 0){
	return $num;}
	$res = $result -> result_array();
	return  $res;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}
