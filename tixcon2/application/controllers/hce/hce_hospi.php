<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hce_hospi
 *Tipo: controlador
 *Descripcion: Permite consultar la historia dle modulo hospi
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 18 de septiembre de 2012
*/
class Hce_hospi extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('urg/urgencias_model');
		$this->load->model('urg/enfermeria_model');
		$this->load->model('hce/hce_model');
		$this->load->model('core/medico_model');
		$this->load->model('core/paciente_model');
		$this->load->model('core/tercero_model');
		$this->load->model('hospi/hospi_model'); 
	}
///////////////////////////////////////////////////////////////////
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hce/main/index');
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	
	$d['dxCon'] = array();
	$d['dxEvo'] = array();
	$d['obs'] = 0;
	$d['rem'] = 0;
	
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	
	$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this->hospi_model ->obtenerDxEvoluciones($id_atencion);
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hce/hospi/gestionAtencion', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Permite consultar el contenido de la nota de atencion inicial
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
*/
function consultaNotaInicial($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('hce/hce_hospi/main/'.$id_atencion);
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

function consultaEvoluciones($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hce/hce_hospi/main/'.$id_atencion);
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	
	$d['evo'] = $this->hospi_model->obtenerEvoluciones($id_atencion);
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hce/hospi/evolucionesListado', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}

function consultaEvolucion($id_evolucion)
{
	$d = array();
	$d['evo'] = $this->hospi_model->obtenerEvolucion($id_evolucion);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvolucion($id_evolucion);
	echo $this->load->view('hospi/hospi_piso_evo_consulta',$d);
}
///////////////////////////////////////////////////////////////////
function consultarOrdenes($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['id_atencion'] = $id_atencion;
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['urlRegresar'] 	= site_url('hce/hce_hospi/main/'.$id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['ordenes'] = $this->hospi_model->obtenerOrdenes($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hce/hospi/ordenesListado', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function consultarOrden($id_orden)
{
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->hospi_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('hce/hce_hospi/consultarOrdenes/'.$id_atencion);
    $d['ordenDietas'] = $this->hospi_model->obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this->hospi_model->obtenerMediOrdenNueva($id_orden);
    $d['ordenCups'] = $this->hospi_model->obtenerCupsOrden($id_orden);
	$d['ordenCupsLaboratorios'] = $this->hospi_model->obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this->hospi_model->obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
    $d['dietas'] = $this->urgencias_model->obtenerDietas();
    $d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this->hospi_model->obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this->hospi_model->obtenerOrdenInsumos($id_orden);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this->load->view('hospi/hospi_piso_ord_consultar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function consultaEpicrisis($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hce/hce_hospi/main/'.$id_atencion);
	$d['epicrisis'] = $this->hospi_model->obtenerEpicrisis($id_atencion);
	$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	
	$d['evo'] = $this -> hospi_model -> obtenerEvosEpicrisis($d['epicrisis']['id_epicrisis']);
	
	$d['consulta'] = $this -> hospi_model -> obtenerNotaInicial($id_atencion);
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['dxI'] = $this -> hospi_model -> obtenerDxEpiI($d['epicrisis']['id_epicrisis']);
	$d['dxE'] = $this -> hospi_model -> obtenerDxEpiE($d['epicrisis']['id_epicrisis']);
	
	$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($d['epicrisis']['id_usuario']);
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
	$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
	$d['especialidades']= $this -> medico_model -> tipos_especialidades();
	$d['destino'] = $this -> hospi_model -> obtenerDestinos();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hce/hospi/consultaEpicrisis',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}

}
?>
