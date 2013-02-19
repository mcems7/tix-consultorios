<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Reportes servicio de urgencias
 *Tipo: controlador
 *Descripcion: Permite obtener distinta información de las atenciones del servicio
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 12 de julio de 2011
*/
class Rep_morbilidad extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('repo/urgencias');	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de reportes disponibles
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110712
* @version		20110712
*/	
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('repo/morb_principal', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function obtener_datos()
{
	//----------------------------------------------------------
	$d = array();
	$d['servicio'] 	= $this->input->post('servicio');
	$d['fecha_inicio'] 	= $this->input->post('fecha_inicio');
	$d['fecha_fin'] 	= $this->input->post('fecha_fin');
	$d['total'] 	= $this->input->post('total');
	//----------------------------------------------------------
	$d['lista'] = $this->urgencias->morbilidad($d);
	//$d['numero'] = $this->urgencias->contar_morbilidad($d);
	echo $this -> load -> view('repo/morb_lista',$d);
	
}
///////////////////////////////////////////////////////////////////
function imprimir($servicio,$total,$fecha_inicio='',$fecha_fin='')
{
	$d['servicio'] 	= $servicio;
	$d['fecha_inicio'] 	= $fecha_inicio;
	$d['fecha_fin'] 	= $fecha_fin;
	$d['total'] 	= $total;
	$d['lista'] = $this->urgencias->morbilidad($d);
	$this -> load -> view('repo/morb_imprimir',$d);
}
}
?>
