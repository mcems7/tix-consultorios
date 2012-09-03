<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Asignar_medico_servicio
 *Tipo: controlador
 *Descripcion: Permite asignar personal asistencial a servicios de hospitalización
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 30 de agosto de 2011
*/
class Asignar_medico_servicio extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('core/medico_servicio_model'); 
	}
///////////////////////////////////////////////////////////////////
/*
* Pagina de inicio, listado de personal servicio
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110820
* @version		20110820
*/
function index()
{
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('core/medico_servicio_principal', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Obtener medico segun documento
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110831
* @version		20110831
* @return		HTML
*/
function obtenerMedicoDocumento()
{
	$d['numero_documento'] = $this->input->post('numero_documento');
	$medico = $this->medico_servicio_model->obtenerDatosMedico($d);
	if($medico != 0){
		
		$dat['medico'] = $medico;
		$dat['servicios'] =  $this->medico_servicio_model->obtenerServiciosHospitalizacion();
		$dat['servicios_asig'] = $this->medico_servicio_model->obtenerServiciosMedico($dat['medico']['id_medico']);
		
			
		echo $this->load->view('core/medico_servicio_infomedico',$dat);
		
		if($dat['servicios_asig'] != 0){
			
		echo $this->load->view('core/medico_servicio_infomedicoser',$dat['servicios_asig']);

		}
		
	}else{
		
		$cadena = '<script language="javascript">alert("No hay personal asistencial con el número de documento ingresado!!")</script>';
		
		echo $cadena;	
	}
}
///////////////////////////////////////////////////////////////////
function asignar_medico()
{
	$d['id_medico'] = $this->input->post('id_medico');
	$d['id_servicio'] = $this->input->post('id_servicio');
	$this->medico_servicio_model->agregar_medico_servicio($d);
	
	$cadena = '<script language="javascript">alert("Asignación realizada correctamente!!")</script>';
		
	echo $cadena;	
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
