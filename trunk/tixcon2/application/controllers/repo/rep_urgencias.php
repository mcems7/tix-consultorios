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
class Rep_urgencias extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
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
		$this -> load -> view('repo/listado_reportes', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
}
?>
