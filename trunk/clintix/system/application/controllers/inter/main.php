<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Main extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('inter/interconsulta_model'); 
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');	
	}
	
///////////////////////////////////////////////////////////////////
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('inter/inter_listadoInterconsultas', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function listadoInterconsultas()
	{
		$estado = $this->input->post('estado');
		$d['lista']	= $this -> interconsulta_model -> obtenerInterconsultas($estado);
		echo $this -> load -> view('inter/inter_listado',$d);
	}
///////////////////////////////////////////////////////////////////
	function consultaInterconsulta($id_interconsulta)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('inter/main/index');
		//---------------------------------------------------------------
		$d['inter'] = $this -> interconsulta_model -> ontenerInterconsulta($id_interconsulta);
		
		if($d['inter']['estado'] == 'Sin consultar'){
		$this -> interconsulta_model -> actualizarEstadoInterconsulta($id_interconsulta,'Consultada');
		$d['inter']['estado'] = 'Consultada';
		}
		
		$d['inter'] = $this -> interconsulta_model -> ontenerInterconsulta($id_interconsulta);
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($d['inter']['id_evolucion']);
		$d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($d['inter']['id_evolucion']);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['evo']['id_atencion']);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['inter']['id_medico']);
		
		$d['obs'] = $this -> interconsulta_model -> obtenerObsInterconsulta($id_interconsulta);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('inter/inter_consulta', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------		
	}
///////////////////////////////////////////////////////////////////
	function notificarInterconsulta()
	{
		$d['id_interconsulta'] = $this->input->post('id_interconsulta');
		$d['nombres'] = $this->input->post('nombres');
		$d['documento'] = $this->input->post('documento');
		$this -> interconsulta_model -> notificarInterconsultaDb($d);
		//----------------------------------------------------
		$dt['mensaje']  = "La interconsulta ha sido notificada!!";
		$dt['urlRegresar'] 	= site_url("inter/main/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function agregarObsInterconsulta()
	{
		$d['id_interconsulta'] = $this->input->post('id_interconsulta');
		$d['observacion'] = $this->input->post('observacion');
	
		$this->interconsulta_model->agregarObsInterconsultaDb($d);
		
		$obs = $this -> interconsulta_model -> obtenerObsInterconsulta($d['id_interconsulta']);
		
		foreach($obs as $d)
		{
			echo $this->load->view('inter/inter_observaciones',$d);
		}	

	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
