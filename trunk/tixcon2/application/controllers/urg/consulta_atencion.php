<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Consulta_atencion
 *Tipo: controlador
 *Descripcion: Permite consultar las atenciones de un paciente en el servicio de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 20 de abril de 2011
*/
class Consulta_atencion extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('inter/interconsulta_model'); 
		$this -> load -> helper('text');
	}
///////////////////////////////////////////////////////////////////
/*
* Busqueda de un paciente para ser atendido
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110308
* @version		20110308
*/
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_inicioConsulta',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	
	function buscar_atencion()
	{
		$numero_documento 	= $this->input->post('numero_documento');
		
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = array();
		$verAten = $this ->urgencias_model -> verificarAtencionUrg($numero_documento);
		if($verAten != 0){
			$d['atencion'] = $verAten;
		}
		
		echo $this->load->view('urg/urg_listadoConsulta',$d);
		
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con las opciones disponibles de atencion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100901
* @version		20100901
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/salas/index');
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		$d['ultima_evolucion'] = $this -> urgencias_model -> obtenerUltimaEvolucion($id_atencion);
		$d['inter'] = $this -> interconsulta_model -> obtenerInterconsultasAtencion($id_atencion);
		$d['ultima_orden'] = $this -> urgencias_model -> obtenerUltOrden($id_atencion);
		$d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dxEvo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_gestionAtencion', $d);
    $this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function consultaTriage($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/gestion_atencion/main/'.$id_atencion);
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_gesConTriage',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function consultaAtencion($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/gestion_atencion/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['consulta_ant'] = $this -> urgencias_model -> obtenerConsulta_ant($d['consulta']['id_consulta']);
		$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_gesConAtencion',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Egreso de paciente de Urgencias
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110329
* @version		20110329
*/	
	function egresoUrgencias()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		$d['id_destino'] 		= $this->input->post('destino');
		$d['obser_destino'] = $this->input->post('obser_destino');
		$this -> urgencias_model -> egresoUrgenciasDb($d);
		//generarAnexo2($id_atencion,$id_entidad)
		//----------------------------------------------------
		$dt['mensaje']  = "El egreso se ha realizado satisfactoriamente!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
