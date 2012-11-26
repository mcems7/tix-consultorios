<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: HCE LABORATORIO
 *Tipo: controlador
 *Descripcion: Permite gestionar el historial de ordenes de laboratorio
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de octubre de 2011
*/
class Hce_laboratorio extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('lab/ordenes_model');
		
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
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
		$d['id_atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$id_paciente=$d['id_atencion']['id_paciente']; 
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['ordenes'] = $this -> ordenes_model -> obtenerOrdenes($id_paciente);
  
		$this->load->view('core/core_inicio');
		$this -> load -> view('lab/hce_ordListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	
	/* 
* @Descripcion: muestra la orden de laboratorio y permite su interpretacion.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	
	
	function interpretarOrdenLab($id_ordenes,$id_atencion)
	{
		$d = array();
		
			$d['urlRegresar'] 	= site_url('lab/hce_laboratorio/main/'.$id_atencion);
		$d['id_atencion']=$id_atencion;
		$d['ordenes'] = $this -> ordenes_model -> obtenerOrdenesInterpretar($id_ordenes);
		
		$id_paciente = $d['ordenes'][0]['id_paciente'];
		
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		//--------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('lab/hce_ordListadoPeriocidad', $d);
		$this->load->view('core/core_fin');
	}
	
		/* 
* @Descripcion: muestra la orden de laboratorio y permite su interpretacion.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	
	function OrdenInterpretar($id_ordenes,$registro_numero,$id_atencion)
	{
		$d = array();
		$d['urlRegresar'] 	= site_url("lab/hce_laboratorio/interpretarOrdenLab/".$id_ordenes.'/'.$id_atencion);
		$d['id_orden']= $id_ordenes;
		$d['id_atencion']=$id_atencion;
		$d['registro_numero']=$registro_numero;
		
		$d['ordenes'] = $this -> ordenes_model -> obtenerOrdenesInterpretar($id_ordenes);
		
		$d['resultado'] = $this -> ordenes_model -> OrdenInterpretar($id_ordenes,$registro_numero);
		
		$d['RutaArchivo'] = $this -> ordenes_model -> RutaArchivo($id_ordenes,$registro_numero);
		
		
		$d['contenedores'] = $this -> ordenes_model -> obtenercontenedorpadre($id_ordenes,$registro_numero);
		
		// capturamo el tamano del arreglo
		$d['tamaño'] = sizeof($d['contenedores']);
		
 
 		// ciclo para capturar la totalidad de nombres del contenedor
		for ($i = 0; $i < $d['tamaño']; $i++) 
		{
				$d['obtenernombrecont'][$i]= $this -> ordenes_model -> obtenernombrecont($d['contenedores'][$i]['contenedor']);
		
        }		
		$id_paciente = $d['ordenes'][0]['id_paciente'];
		
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		
		//--------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('lab/hce_resultadoorden', $d);
		$this->load->view('core/core_fin');
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
	
	
	function OrdenConsultar($id_ordenes,$registro_numero,$id_atencion)
	{
	  $d = array();
		
		$d['urlRegresar'] 	= site_url("lab/hce_laboratorio/interpretarOrdenLab/".$id_ordenes.'/'.$id_atencion);
		$d['id_orden']= $id_ordenes;
		$d['registro_numero']=$registro_numero;
		
		$d['ordenes'] = $this -> ordenes_model -> obtenerOrdenesInterpretar($id_ordenes);
		
		$d['resultado'] = $this -> ordenes_model -> OrdenInterpretar($id_ordenes,$registro_numero);
		
		$d['RutaArchivo'] = $this -> ordenes_model -> RutaArchivo($id_ordenes,$registro_numero);
		$d['interpretacion'] = $this -> ordenes_model -> OrdenInterpretada($id_ordenes,$registro_numero);
		
		
		$d['contenedores'] = $this -> ordenes_model -> obtenercontenedorpadre($id_ordenes,$registro_numero);
		
		// capturamo el tamano del arreglo
		$d['tamaño'] = sizeof($d['contenedores']);
		
 
 		// ciclo para capturar la totalidad de nombres del contenedor
		for ($i = 0; $i < $d['tamaño']; $i++) 
		{
				$d['obtenernombrecont'][$i]= $this -> ordenes_model -> obtenernombrecont($d['contenedores'][$i]['contenedor']);
		
        }		
		$id_paciente = $d['ordenes'][0]['id_paciente'];
		
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		
		//--------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('lab/hce_Consultaresultadoorden', $d);
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