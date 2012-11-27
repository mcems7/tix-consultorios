<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_enfermeria
 *Tipo: controlador
 *Descripcion: Permite realizar la admision del paciente a hospitalizacion
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/
class Hospi_enfermeria extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('hospi/hospi_model');
		$this->load->model('core/tercero_model');
		$this->load->model('core/paciente_model');  	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Vista que permite seleccionar el servicio a gestionar
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	$d['estados'] = $this->hospi_model->obtenerEstadosCamas();
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_camas_enfermeria', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Lista el estado de las camas de un servicio indicado
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function listadoPacientesPiso()
{
	//----------------------------------------------------------
	$id_servicio 	= $this->input->post('id_servicio');
	//----------------------------------------------------------
	if($id_servicio == 0){
		$id_servicio = $this->session->userdata('id_servicioHospi');
	}else{
		$this->session->unset_userdata('id_servicioHospi');
		$this->session->set_userdata('id_servicioHospi',$id_servicio);
	}
	$id_estado 	= $this->input->post('estado');
	$d['lista'] = $this->hospi_model->obtPacPendientesCamaServicio($id_servicio);
	$d['camas'] = $this->hospi_model->obtenerCamasServicio($id_servicio,$id_estado);
	//----------------------------------------------------------
	$this->load->view('hospi/hospi_piso_detalle_enfermeria',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Muestra el listado de camas disponibles
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
* @return		HTML
*/	
function ingresoServicio($id_atencion,$id_servicio)
{
	$camas = $this->hospi_model->obtenerCamasDispoServicio($id_servicio);
	if(count($camas)>0)
	{
		$cadena = '';
		$cadena .='<select name="id_cama" id="id_cama">';
		$cadena .='<option value="0">-Disponibles-</option>';
		foreach($camas as $d)
		{
		$cadena .='<option value="'.$d['id_cama'].'">'.$d['numero_cama'].'</option>';	
		}
		$cadena .= '</select>';
		$data = array(	'name' => 'bv',
		'onclick' => "asignarCama('".$id_atencion."')",
		'value' => 'Asignar',
		'type' =>'button');
		$cadena .= form_input($data);
	}else{
		$cadena = 'No hay camas disponibles';
	}
	echo $cadena;
}
///////////////////////////////////////////////////////////////////
/*
* Accion que permite asignar cama al paciente
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
*/	
function ingresoServicioCama($id_servicio,$id_cama)
{
	$this->hospi_model->ingresoServicioDd($id_servicio,$id_cama);
	$cama =$this->hospi_model->detalleCama($id_cama);
	echo $cama['numero_cama'];
}
///////////////////////////////////////////////////////////////////
/*
* Accion que permite activar una cama
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
*/	
function activarCama($id_cama)
{	
	//----------------------------------------------------------
	$id_servicio 	= $this->input->post('id_servicio');
	$id_estado 	= 0;
	$this->hospi_model->activarCamaServicio($id_cama);
	$d['lista'] = $this->hospi_model->obtPacPendientesCamaServicio($id_servicio);
	$d['camas'] = $this->hospi_model->obtenerCamasServicio($id_servicio,$id_estado);
	//----------------------------------------------------------
	$this->load->view('hospi/hospi_piso_detalle',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Gestion de la atencion de un paciente hospitalizado
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20101103
* @version		20101103
*/	
function main($id_atencion)
{
	$this->load->model('urg/urgencias_model');
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_enfermeria/index');
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvoluciones($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_gestion_atencion_enfermeria', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/*
* Muestra la opcion de cambiar un paciente de cama
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
* @return		HTML
*/	
function cambiarCamaHospi($id_atencion)
{
	$aten = $this->hospi_model->obtenerAtencion($id_atencion);
	$camas = $this->hospi_model->obtenerCamasDispoServicio($aten['id_servicio']);
	if(count($camas)>0)
	{
		$cadena = '';
		$cadena .='<select name="id_cama" id="id_cama">';
		$cadena .='<option value="0">-Disponibles-</option>';
		foreach($camas as $d)
		{
			$cadena .='<option value="'.$d['id_cama'].'">'.$d['numero_cama'].'</option>';	
		}
		$cadena .= '</select>';
		$data = array(	'name' => 'bv',
			'onclick' => "asignarCama('".$aten['id_atencion']."')",
			'value' => 'Asignar',
			'type' =>'button');
		$cadena .= form_input($data);
	}else{
		$cadena = 'No hay camas disponibles';
	}
	echo $cadena;
}
///////////////////////////////////////////////////////////////////
/*
* Realiza el cambio de la cama
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
* @return		HTML
*/
function cambiarHospiCama($id_atencion,$id_cama)
{
	$aten = $this->hospi_model->obtenerAtencion($id_atencion);
	$this->hospi_model->cambiarCamaHospiDb($id_atencion,$id_cama);
	$this->hospi_model->liberarCama($aten['id_cama']);
	$cama = $this->hospi_model->detalleCama($id_cama);
	echo $cama['numero_cama'];
}
///////////////////////////////////////////////////////////////////
/*
* Permite consultar el contenido de la nota de atencion inicial
*
* @author Carlos Andres Jaramillo <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
*/
function consultaNotaInicial($id_atencion)
{
	$this->load->model('urg/urgencias_model');
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('hospi/hospi_enfermeria/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['consulta_ant'] = $this->hospi_model->obtenerNotaInicial_ant($d['consulta']['id_consulta']);
	$d['consulta_exa'] = $this->hospi_model->obtenerNotaInicial_exa($d['consulta']['id_consulta']);
	$d['tipo_usuario'] = $this->paciente_model->tipos_usuario();
	$d['dx'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['consulta']['id_medico']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_nota_inicial_consulta',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////

function ordenamiento($id_atencion)
{
	
	$this->load->model('urg/urgencias_model');
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_enfermeria/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['id_atencion'] = $id_atencion;
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);	
	$d['ordenes'] = $this->hospi_model->obtenerOrdenes($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_ord_listado_enfermeria', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}

//////////////////////////////////////////////////////
function consultarOrden($id_orden)
{
	$this->load->model('urg/urgencias_model');
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['orden'] = $this->hospi_model->obtenerOrden($id_orden);
	$d['id_oxigeno_valor'] = $this->urgencias_model->obtenerTipoOxigeno($d['orden']['id_tipo_oxigeno']);
	$d['ordenDietas'] = $this->hospi_model->obtenerDietasOrden($d['orden']['id_orden']);
	$d['ordenCuid'] = $this->hospi_model->obtenerCuidadosOrden($d['orden']['id_orden']);
	$d['ordenMedi'] = $this->hospi_model->obtenerMediOrdenNueva($d['orden']['id_orden']);
	$d['ordenCups'] = $this->hospi_model->obtenerCupsOrden($d['orden']['id_orden']);
	$d['ordenCupsLaboratorios'] = $this->hospi_model->obtenerCupsLaboratorios($d['orden']['id_orden']);
	$d['ordenCupsImagenes'] = $this->hospi_model->obtenerCupsImagenes($d['orden']['id_orden']);  
	$id_atencion = $d['orden']['id_atencion'];
	$d['urlRegresar']   = site_url('hospi/hospi_enfermeria/ordenamiento/'.$id_atencion);
	
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['dietas'] = $this->urgencias_model->obtenerDietas();
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	$d['ordenCuid'] = $this->urgencias_model->obtenerCuidadosOrden($id_orden);
	$d['ordenInsumos'] = $this->urgencias_model->obtenerOrdenInsumos($id_orden);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_ord_consultar', $d);
	$this->load->view('core/core_fin'); 
	//---------------------------------------------------------------
}





}
?>