<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Gestion_atencion
 *Tipo: controlador
 *Descripcion: Permite gestionar el proceso de atencion del paciente en el servicio
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 16 de septiembre de 2010
*/
class Gestion_atencion extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
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
* @copyright    GNU GPL 3.0
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
		$this -> load -> view('urg/urg_inicioGestion',$d);
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
		
		echo $this->load->view('urg/urg_listadoGestion',$d);
		
	}
	
	
	function buscar_paciente_atencion()
	{
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/home/index');	
		//----------------------------------------------------------
		$d['primer_apellido'] 	= $this->input->post('primer_apellido');
		$d['primer_nombre'] 	= $this->input->post('primer_nombre');
		$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
		$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		//----------------------------------------------------------
		$d['lista'] = $this->urgencias_model->verificarAtencionUrg($d);
		
		$verAten = $this ->urgencias_model -> verificarAtencionUrg($d);
		if($verAten != 0){
			$d['atencion'] = $verAten;
		}
		//----------------------------------------------------------
		
		
		echo $this->load->view('urg/urg_listadoGestion',$d);
		
	}
	
	
	
	
	
	
///////////////////////////////////////////////////////////////////
/*
* Vista con las opciones disponibles de atencion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100901
* @version		20100901
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		if($d['atencion']['activo'] != 'SI'){
				redirect('hce/main/consultarAtencion/'.$id_atencion);
		}
		
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
		$d['puntaje'] = $this->urgencias_model->obtenerValoracionPuntajeRiesgo($id_atencion);
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
		
		if($d['consulta']['verificado'] == 'SI'){
			$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico_verifica']);
		}else{
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);	
		}
		
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
* @copyright    GNU GPL 3.0
* @since		20110329
* @version		20110329
*/	
	function egresoUrgencias()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		$d['estado_salida'] = $this->input->post('estado_salida');
		$d['id_destino'] 		= $this->input->post('destino');
		$d['obser_destino'] = $this->input->post('obser_destino');
		$this -> urgencias_model -> egresoUrgenciasDb($d);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		
		redirect("auto/anexo2/generarAnexo2/".$d['id_atencion']."/".$atencion['id_entidad']."/1");
	}
///////////////////////////////////////////////////////////////////
	function generarAnexos($id_atencion)
	{	
		
		$atencion = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		if($atencion['id_entidad_pago'] != '-'){
			redirect("auto/anexo2/generarAnexo2/".$id_atencion."/".$atencion['id_entidad_pago']."/2");
		}
		//----------------------------------------------------
		$dt['mensaje']  = "El egreso se ha realizado satisfactoriamente!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function generarOtro()
	{
		//----------------------------------------------------
		$dt['mensaje']  = "El egreso se ha realizado satisfactoriamente!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
function egreso($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('urg/salas/index');
	//----------------------------------------------------------
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_egresoAtencion', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
