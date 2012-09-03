<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Hospi_Impresion
 *Tipo: controlador
 *Descripcion: Genera las vistas para la impresión en papel de las atenciones a los pacientes
 *Autor: Diego Ivan Carvajal  <mmartinez@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/
class Hospi_impresion extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
    $this -> load -> model('impresion/hospi/hospi_impresion_model');
	$this -> load -> model('hospi/hospi_model');
	$this -> load -> model('urg/urgencias_model');
    $this -> load -> model('core/paciente_model');
    $this -> load -> model('core/tercero_model');
	$this -> load -> model('core/medico_model');
	$this -> load -> model('far/farmacia_model');
    $this -> load -> model('inter/interconsulta_model'); 
	$this -> load -> model('hospi/hospi_enfermeria_model'); 
	
  }
  
  function index()
  {
    $this -> load -> view('impresion/index');
  }


///////////////////////////////////diego carvajal////////////////////////////////
  public function consultaNotaEnfermeria($id_nota)
  {
    $d = array();
    $d['evo'] = $this->hospi_enfermeria_model->obtenerNotaEnfermeria($id_nota);
	$d['atencion'] = $this -> hospi_model -> obtenerAtencion($d['evo'][0]['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
    //---------------------------------------------------------------
    $this->load->view('impresion/hospi/hospi_NotaEnfermeria',$d);
    //---------------------------------------------------------------
  }
  
    public function consultaBalancelEnfermeria($id_atencion,$fecha_nota)
  {
    
		$d = array();
		$d['id_atencion']=$id_atencion;
		$d['fecha_nota']=$fecha_nota;
		$d['evo'] = $this->hospi_enfermeria_model->obtenerDatoBalanceEnfermeria($id_atencion,$fecha_nota);
		$d['BL_Adm7_12'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha7_12($id_atencion,$fecha_nota);
		$d['BL_Adm13_18'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha13_18($id_atencion,$fecha_nota);
		$d['BL_Adm19_6'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha19_6($id_atencion,$fecha_nota);
		$d['BL_Adm24'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha24($id_atencion,$fecha_nota);
		// eliminados
		$d['BL_Eli7_12'] = $this->hospi_enfermeria_model->obtenerBlEliFecha7_12($id_atencion,$fecha_nota);
		$d['BL_Eli13_18'] = $this->hospi_enfermeria_model->obtenerBlEliFecha13_18($id_atencion,$fecha_nota);
		$d['BL_Eli19_6'] = $this->hospi_enfermeria_model->obtenerBlEliFecha19_6($id_atencion,$fecha_nota);
		$d['BL_Eli24'] = $this->hospi_enfermeria_model->obtenerBlEliFecha24($id_atencion,$fecha_nota);
	
	
    //$d['evo'] = $this->hospi_enfermeria_model->obtenerBalancelEnfermeria($id_nota);
	
    $d['atencion'] = $this -> hospi_model -> obtenerAtencion($d['evo'][0]['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	 $d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
    
    //---------------------------------------------------------------
    $this->load->view('impresion/hospi/hospi_BalancelEnfermeria',$d);
    //---------------------------------------------------------------
  }

//////////////////////////////////////////////////////////////////////////////////
 public function SvEnfermeria($id_atencion)
  {
    $d = array();
    $d['evo'] = $this->hospi_impresion_model->ConsultaSv($id_atencion);
	$d['atencion'] = $this -> hospi_model -> obtenerAtencion($d['evo'][0]['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	
    //---------------------------------------------------------------
   $this->load->view('impresion/hospi/hospi_SvEnfermeria',$d);
    //---------------------------------------------------------------
  }
  
 /*
* Consultar una remision
*Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @return  string (html)
* @access  public 
*/  
///////////////////////////////////////////////////////////////////

  public function consultaRemision($id_atencion)
  {
    //---------------------------------------------------------------
    $d = array();
		$d['remision'] = $this -> hospi_model -> obtenerRemision($id_atencion);
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> hospi_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> hospi_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['evo'] = $this -> hospi_model -> obtenerEvosRemision($d['remision']['id_remision']);
		$d['dxI'] = $this -> hospi_model -> obtenerDxRemI($d['remision']['id_remision']);
		$d['dxE'] = $this -> hospi_model -> obtenerDxRemE($d['remision']['id_remision']);
		$d['id_medico'] = $this -> hospi_model -> obtenerIdMedico($d['remision']['id_usuario']);
		$d['medico'] = $this -> hospi_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> hospi_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> hospi_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->hospi_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
		
    //---------------------------------------------------------------
    $this->load->view('impresion/hospi/hospi_remision',$d);
    //---------------------------------------------------------------
  }
  ///////////////////////////////////////////////////////////////////
public function notaInicial($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
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
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	//-----------------------------------------------------------
	$this->load->view('impresion/hospi/hospi_notaInicial',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
 public function consultaEvolucion($id_evolucion)
  {
    $d = array();
    $d['evo'] = $this->hospi_model->obtenerEvolucion($id_evolucion);
    $d['atencion'] = $this -> hospi_model -> obtenerAtencion($d['evo']['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['dxEvo'] = $this->hospi_model->obtenerDxEvolucion($id_evolucion);
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
    //---------------------------------------------------------------
    $this->load->view('impresion/hospi/evolucion',$d);
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
public function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->hospi_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['ordenDietas'] = $this -> hospi_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> hospi_model -> obtenerMediOrdenNueva($id_orden);
    $d['ordenCups'] = $this -> hospi_model -> obtenerCupsOrden($id_orden);
    $d['ordenCupsLaboratorios'] = $this -> hospi_model -> obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this -> hospi_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> hospi_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> hospi_model -> obtenerOrdenInsumos($id_orden);
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
    //---------------------------------------------------------------
    $this -> load -> view('impresion/hospi/ordenamiento', $d);
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
public function consultaEpicrisis($id_atencion)
{
	//---------------------------------------------------------------
	$d = array();
	$d['epicrisis'] = $this -> hospi_model -> obtenerEpicrisis($id_atencion);
	$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	
	$d['evo'] = $this -> hospi_model -> obtenerEvosEpicrisis($d['epicrisis']['id_epicrisis']);
	$d['dxI'] = $this -> hospi_model -> obtenerDxEpiI($d['epicrisis']['id_epicrisis']);
	$d['dxE'] = $this -> hospi_model -> obtenerDxEpiE($d['epicrisis']['id_epicrisis']);
	$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($d['epicrisis']['id_usuario']);
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$d['mediAtencion'] = $this -> hospi_model ->obtenerMediAtencion($id_atencion);
	$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
	$d['especialidades']= $this -> medico_model -> tipos_especialidades();
	$d['destino'] = $this -> hospi_model -> obtenerDestinos();
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	//---------------------------------------------------------------
	$this->load->view('impresion/hospi/epicrisis',$d);
	//---------------------------------------------------------------
}
}
?>
