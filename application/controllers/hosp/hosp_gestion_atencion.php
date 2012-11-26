<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hosp_gestion_atencion
 *Tipo: controlador
 *Descripcion: Permite gestionar las atenciones en hospitalización
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 21 de febrero de 2012
*/
class Hosp_gestion_atencion extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('auto/autorizaciones_model');			
		$this -> load -> model('hosp/hosp_model');
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
	}
///////////////////////////////////////////////////////////////////
/*
* Busqueda de un paciente ppara gestionar atencion hospitalizacion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120222
* @version		20120222
*/
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hosp/hosp_inicioGestion',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	
	function buscar_atencion()
	{
		$numero_documento 	= $this->input->post('numero_documento');
		
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = array();
		
		$verAtenHosp = $this -> hosp_model -> verificarAtencionHosp($d['numero_documento']);		
		
		if($verAten != 0){
			$d['atencion'] = $verAtenHosp;
		}
		
		echo $this->load->view('hops/hops_listadoGestion',$d);
		
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

		$verAten = $this ->hosp_model -> verificarAtencionHopsGes($d);
		if($verAten != 0){
			$d['atencion'] = $verAten;
		}
		//----------------------------------------------------------
		
		echo $this->load->view('hosp/hosp_listadoGestion',$d);	
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con las opciones disponibles de atencion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120222
* @version		20120222
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = $this -> hosp_model -> obtenerAtencion($id_atencion);
		
		$d['urlRegresar'] 	= site_url('core/home/index');
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dxCon'] = $this -> hosp_model -> obtenerDxAtencion($id_atencion);
$d['anexo3'] = $this -> hosp_model ->obtenerAnexos3Atencion($id_atencion);

		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hosp/hosp_gestionAtencion', $d);
   		 $this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
function editar_atencion($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hosp/hosp_gestion_atencion/main/'.$id_atencion);
	$d['atencion'] = $this -> hosp_model -> obtenerAtencion($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['servicios'] = $this -> urgencias_model -> obtenerServicios();
	$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
	$d['dxCon'] = $this -> hosp_model -> obtenerDxAtencion($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hosp/hosp_registro_atencion_paciente_edit', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function registrarAtencionEdit_(){
//----------------------------------------------------------
$d = array();
//----------------------------------------------------------
$d['id_atencion'] = $this->input->post('id_atencion');
$d['fecha_ingreso'] = $this->input->post('fecha_ingreso');
$d['id_entidad'] 	= $this->input->post('id_entidad');
$d['id_servicio'] 	= $this->input->post('id_servicio');
$d['cama'] 			= $this->input->post('cama');
$d['id_origen'] 	= $this->input->post('id_origen');
$d['id_entidad_pago']= $this->input->post('id_entidad_pago');
$d['numero_ingreso'] = $this->input->post('numero_ingreso');
$d['dx'] 			= $this->input->post('dx_ID_');
//----------------------------------------------------------
$this -> hosp_model -> registrarAtencionEditDb($d);
//----------------------------------------------------	
$dat['mensaje'] = "La atención fue modificada correctamente.";
$dat['urlRegresar'] = site_url('hosp/hosp_gestion_atencion/main/'.$d['id_atencion']);
$this -> load -> view('core/presentacionMensaje', $dat);
return;		
}
///////////////////////////////////////////////////////////////////
function egreso_paciente($id_atencion){
	$d= array();
	$d['id_atencion'] = $id_atencion;	
	$this->hosp_model->egresoHospDb($d);
	//----------------------------------------------------
	$dt['mensaje']  = "El egreso se ha realizado satisfactoriamente!!";
	$dt['urlRegresar'] 	= site_url("core/home/index");
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
}
?>
