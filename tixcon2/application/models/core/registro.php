<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Registro extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}
	
	public function agregar($id_usuario, $modulo, $controlador, $accion, $tipo, 
	                        $informacion)
	{
		$this -> load -> helper('date');

		$CI = &get_instance();
		$CI -> load -> model('core/Tiempo');
		
		$datos = array('momento'               => $CI -> Tiempo -> obtenerDateTimeActual(),
		               'id_usuario'            => $id_usuario,
					   'modulo'                => $modulo,
					   'controlador'           => $controlador,
					   'accion'                => $accion,
					   'tipo'                  => $tipo,
					   'informacion_adicional' => $informacion,
					   'ip'                    => getenv('REMOTE_ADDR'));
		
		$this -> db -> insert('core_registro', $datos);
		
		return $this -> db -> affected_rows();
	}
}

?>