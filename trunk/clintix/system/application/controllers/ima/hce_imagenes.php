<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: HCE IMAGENES
 *Tipo: controlador
 *Descripcion: Permite gestionar el historial de ordenes de laboratorio
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de octubre de 2011
*/
class Hce_imagenes extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('ima/imagenologia_model');
		
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> library('lib_edad');
		$this -> load -> helper( array('url','form') );
	}
///////////////////////////////////////////////////////////////////
/* 
* @Descripcion: Muestra la lista de las ordenes realizadas de laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$id_paciente=$d['atencion']['id_paciente']; 
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['ordenes'] = $this -> imagenologia_model -> obtenerOrdenesDx($id_atencion);
		$this->load->view('core/core_inicio');
		$this -> load -> view('ima/hce_ordListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	

	///////////////////////////////////////////////////////////////////////
		/* 
* @Descripcion: Permite consultar una orden.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	//////////////////////////////////////////////////////////////////////
	
	
	function OrdenConsultar($id,$id_atencion)
	{
	  $d = array();
		
		$d['urlRegresar'] 	= site_url("ima/hce_imagenes/main/".$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$id_paciente=$d['atencion']['id_paciente']; 
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		
		//$d['ordenes'] = $this -> ordenes_model -> obtenerOrdenesInterpretar($id_ordenes);
		
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['resultado'] = $this -> imagenologia_model -> obtenerInformeDX($id);
		//--------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('ima/hce_Consultaresultado', $d);
		$this->load->view('core/core_fin');
		
	
	}
	///////////////////////////////////////////////////////////////////////////////
		/* 
* @Descripcion: Guarda la interpretacion generada por el medico de la orden del labpratorio. 
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	////////////////////////////////////////////////////////////////////////////////
	
	
	function guardarInterpretacion()
	{
		 $d = array();
    //---------------------------------------------------------------
  
  		$d['id_orden'] = $this->input->post('id_orden');
  		$d['registro_numero'] = $this->input->post('registro_numero');
  		$d['id_usuario'] = $this->input->post('id_usuario');
  		$d['interpretacion'] = $this->input->post('interpretacion');
		$id_atencion = $this->input->post('id_atencion');
		
		$this -> ordenes_model -> guardarInterpretacion($d);
		
		redirect('/lab/hce_laboratorio/interpretarOrdenLab/'.$d['id_orden'].'/'.$id_atencion, 'refresh');
	
		
		
	}
	
	
 
		
		
	
	///////////////////////FIN////////////////////////////////
}
?>