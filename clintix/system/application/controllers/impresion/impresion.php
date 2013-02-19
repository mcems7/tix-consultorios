<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Impresion
 *Tipo: controlador
 *Descripcion: Genera las vistas para la impresión en papel de las atenciones a los usuarios
 *Autor: Mario Alberto Martínez Martínez  <mmartinez@opuslibertati.org>
 *Fecha de creación: 2 de febrero de 2011
*/
class Impresion extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
    $this -> load -> model('impresion/impresion_model');
		$this -> load -> model('urg/urgencias_model');
    $this -> load -> model('core/paciente_model');
    $this -> load -> model('core/tercero_model');
		$this -> load -> model('core/medico_model');
		$this -> load -> model('far/farmacia_model');
    $this -> load -> model('inter/interconsulta_model'); 
	$this -> load -> model('urg/enfermeria_model'); 
  }
  
  function index()
  {
    $this -> load -> view('impresion/index');
  }

///////////////////////////////////////////////////////////////////
/*
* Cargar el buscador de atenciones
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110223
* @version 20110223
* @return  string (html)
* @access  public 
*/  
///////////////////////////////////////////////////////////////////	
	
	public function buscador()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] = site_url('core/home/index');
		//----------------------------------------------------------
		$this -> load -> view('core/core_inicio');
		$this -> load -> view('impresion/buscador', $d);
		$this -> load -> view('core/core_fin');
		//----------------------------------------------------------
	}
	
///////////////////////////////////////////////////////////////////
/*
* Listar las atenciones de los pacientes que fueron buscados por nombre
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110225
* @version 20110225
* @return  string (html)
* @access  public 
*/  
///////////////////////////////////////////////////////////////////	
	
	public function atencionPaciente($documento)
	{
		$d['numero_documento'] = $documento;
		$datos['listaUrg']  = $this -> impresion_model -> verificarAtencionUrg($d);
		$datos['listaHosp'] = $this -> impresion_model -> verificarAtencionHosp($d);
		$datos['boton'] = true;
		//$datos['urlRegresar'] = site_url('core/home/index');
		
		$this -> load -> view('core/core_inicio');	
		$this -> load -> view('impresion/listadoAtenciones',$datos);
		$this -> load -> view('core/core_fin');
	}
	
///////////////////////////////////////////////////////////////////
/*
* Buscar los pacientes ó las atenciones de los pacientes que corresponden con los parámetros dados
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110223
* @version 20110223
* @return  vector
* @access  public 
*/  
///////////////////////////////////////////////////////////////////	
	
	public function buscarPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		
		$criterio = $this->input->post('criterio');
		
		if($criterio == 'documento')
		{
			$d['numero_documento'] = $this->input->post('numero_documento');
			
			$datos['listaUrg']  = $this -> impresion_model -> verificarAtencionUrg($d);
			$datos['listaHosp'] = $this -> impresion_model -> verificarAtencionHosp($d);
	
			echo $this->load->view('impresion/listadoAtenciones',$datos);
		}
		else if($criterio == 'nombre')
		{
			$d['nombre1'] 	= $this->input->post('nombre1');
			$d['nombre2'] 	= $this->input->post('nombre2');
			$d['apellido1'] = $this->input->post('apellido1');
			$d['apellido2'] = $this->input->post('apellido2');	
			
			$datos['listaUrg'] = $this -> impresion_model -> verificarAtencionUrg($d);

			echo $this->load->view('impresion/listadoPacientes',$datos);
		}
		else
		{
			echo 'Los par&aacute;metros proporcinados están incompletos';
		}
	}	
	
///////////////////////////////////////////////////////////////////
/*
* Detalle de la atención de un paciente en la sección de urgencias
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110225
* @version 20110225
* @return  string (html)
* @access  public 
*/  
///////////////////////////////////////////////////////////////////  

  public function atencionUrg($id_atencion)
  {
    //----------------------------------------------------------
    $d = array();
		//--------------------triage--------------------------------
		
		//--------------------consulta_inicial----------------------

		//--------------------epicrisis-----------------------------
		
		$d['epicrisis'] = $this -> urgencias_model -> obtenerEpicrisis($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['consulta_ant'] = $this -> urgencias_model -> obtenerConsulta_ant($d['consulta']['id_consulta']);
		$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		
		if($d['consulta']['verificado'] == 'SI'){
			$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico_verifica']);
		}else{
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);	
		}
		
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		
		//--------------------evoluciones---------------------------
		
		$d['evoluciones'] = $this->impresion_model->obtenerEvoluciones($id_atencion);
		$i = 0;
		foreach($d['evoluciones'] as $evolu)
		{
			$d['evo'][$i] = $this->urgencias_model->obtenerEvolucion($evolu['id_evolucion']);
			$d['dxEvo'][$i] = $this->urgencias_model->obtenerDxEvolucion($evolu['id_evolucion']);
			$i++;
		}
		
		//--------------------ordenamientos-------------------------
		
		$d['ordenes'] = $this->impresion_model->obtenerOrdenes($id_atencion);
		$i = 0;
		foreach($d['ordenes'] as $orden)
		{
			$d['orden'][$i] = $this->urgencias_model->obtenerOrden($orden['id_orden']);
			$d['ordenDietas'][$i] = $this -> urgencias_model -> obtenerDietasOrden($orden['id_orden']);
			$d['ordenMedi'][$i] = $this -> urgencias_model -> obtenerMediOrden($orden['id_orden']);
			$d['ordenCups'][$i] = $this -> urgencias_model -> obtenerCupsOrden($orden['id_orden']);
			$d['ordenCuid'][$i] = $this -> urgencias_model -> obtenerCuidadosOrden($orden['id_orden']);
			$d['ordenInsumos'][$i] = $this -> urgencias_model -> obtenerOrdenInsumos($orden['id_orden']);
			$i++;
		}
		$d['dietas'] = $this -> urgencias_model -> obtenerDietas();
		
    //----------------------------------------------------------
    $this -> load -> view('impresion/todoUrgencias',$d);
    //----------------------------------------------------------  
  }

///////////////////////////////////////////////////////////////////
/*
* Detalle de la atención de un paciente en la sección de hospitalización
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110225
* @version 20110225
* @return  string (html)
* @access  public 
*/  
///////////////////////////////////////////////////////////////////  
/*
  public function atencionHosp($id_atencion)
  {
    //----------------------------------------------------------
    $d = array();
		//--------------------consulta_inicial----------------------
		
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
    $d['tipo_usuario']  = $this -> paciente_model -> tipos_usuario();
    $d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);
    $d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
    $d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();

		//--------------------evoluciones---------------------------
		
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($id_evolucion);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['evo']['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($id_evolucion);
		
		//--------------------ordenamientos-------------------------
		
		$d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> urgencias_model -> obtenerOrdenInsumos($id_orden);
		
		//--------------------epicrisis-----------------------------
		
		$d['epicrisis'] = $this -> urgencias_model -> obtenerEpicrisis($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		
    //----------------------------------------------------------
    $this -> load -> view('impresion/todoHospitalizacion',$d);
    //----------------------------------------------------------  
  }
*/
///////////////////////////////////////////////////////////////////
/*
* Consultar un triage indicado
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110209
* @version 20110209
* @return  string (html)
* @access  public 
*/  
///////////////////////////////////////////////////////////////////  

  public function consultaTriage($id_atencion,$clas = 1)
  {
    //----------------------------------------------------------
    $d = array();  
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
	$clas=$d['atencion']['clasificacion'];  
    //-----------------------------------------------------------
    if($clas == 4){
		$this -> load -> view('impresion/triage_blanco',$d);
	}else{
		$this -> load -> view('impresion/triage',$d);
	}
    //----------------------------------------------------------  
  }

///////////////////////////////////////////////////////////////////
/*
* Consultar una atención inicial indicada
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110209
* @version 20110209
* @return  string (html)
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 
  
  public function consultaInicial($id_atencion)
  {
    //----------------------------------------------------------
    $d = array();
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
	$d['consulta_ant'] = $this -> urgencias_model -> obtenerConsulta_ant($d['consulta']['id_consulta']);
		$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
    $d['tipo_usuario']  = $this -> paciente_model -> tipos_usuario();
    $d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);
    $d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
    $d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
    //-----------------------------------------------------------
    $this -> load -> view('impresion/consulta',$d);
    //----------------------------------------------------------
  }

///////////////////////////////////////////////////////////////////
/*
* Consultar una orden médica indicada
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110209
* @version 20110209
* @return  string (html)
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 

  public function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
    $d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> urgencias_model -> obtenerOrdenInsumos($id_orden);
    //---------------------------------------------------------------
    $this -> load -> view('impresion/ordenamiento', $d);
    //---------------------------------------------------------------
  }

///////////////////////////////////////////////////////////////////
/*
* Consultar una evolución de paciente indicada
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110209
* @version 20110209
* @return  string (html)
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 

  public function consultaEvolucion($id_evolucion)
  {
    $d = array();
    $d['evo'] = $this->urgencias_model->obtenerEvolucion($id_evolucion);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['evo']['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($id_evolucion);
    //---------------------------------------------------------------
    $this->load->view('impresion/evolucion',$d);
    //---------------------------------------------------------------
  }

///////////////////////////////////////////////////////////////////
/*
* Consultar una epicrisis indicada
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110209
* @version 20110209
* @return  string (html)
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 

  public function consultaEpicrisis($id_atencion)
  {
    //---------------------------------------------------------------
    $d = array();
		$d['epicrisis'] = $this -> urgencias_model -> obtenerEpicrisis($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		
		$d['evo'] = $this -> urgencias_model -> obtenerEvosEpicrisis($d['epicrisis']['id_epicrisis']);
		$d['dxI'] = $this -> urgencias_model -> obtenerDxEpiI($d['epicrisis']['id_epicrisis']);
		$d['dxE'] = $this -> urgencias_model -> obtenerDxEpiE($d['epicrisis']['id_epicrisis']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($d['epicrisis']['id_usuario']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
    //---------------------------------------------------------------
    $this->load->view('impresion/epicrisis',$d);
    //---------------------------------------------------------------
  }

///////////////////////////////////////////////////////////////////
/*
* Generar el formato de solicitud de medicamentos no pos
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110223
* @version 20110223
* @return  string (html)
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 

  public function consultaMedicamentos($id_medicamento)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $this->load->view('impresion/medicamentos',$d);
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////  
  public function ordenMediInsuDespacho($id_orden)
  {
	//---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->farmacia_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['ordenMedi'] = $this -> farmacia_model -> obtenerMediOrdenDespa($id_orden);
	$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrden($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
	
	
	
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['diagnostico'] = $this->farmacia_model->obtenerDxFarmacia($id_atencion);
    $d['cama'] = $this->farmacia_model->obtenerCamaFarmacia($id_atencion);
   
    //---------------------------------------------------------------
    $this -> load -> view('impresion/despachoMedicamentos', $d); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
function retiroVoluntario($id_atencion)
{
	 //----------------------------------------------------------
    $d = array();  
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    //-----------------------------------------------------------
	$this -> load -> view('impresion/retiro_voluntario',$d);
    //----------------------------------------------------------  
}
///////////////////////////////////////////////////////////////////
function certificadoAccTransito($id_atencion)
{
	//----------------------------------------------------------
    $d = array();
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);

		$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
    $d['tipo_usuario']  = $this -> paciente_model -> tipos_usuario();
    $d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);
    $d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
    $d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
    //-----------------------------------------------------------
    $this -> load -> view('impresion/certificadoAccTran',$d);
    //----------------------------------------------------------
}
///////////////////////////////////diego carvajal////////////////////////////////
  public function consultaNotaEnfermeria($id_nota)
  {
    $d = array();
    $d['evo'] = $this->enfermeria_model->obtenerNotaEnfermeria($id_nota);
	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['evo'][0]['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    
    //---------------------------------------------------------------
    $this->load->view('impresion/NotaEnfermeria',$d);
    //---------------------------------------------------------------
  }
  
    public function consultaBalancelEnfermeria($id_atencion,$fecha_nota)
  {
    
		$d = array();
		$d['id_atencion']=$id_atencion;
		$d['fecha_nota']=$fecha_nota;
		$d['evo'] = $this->enfermeria_model->obtenerDatoBalanceEnfermeria($id_atencion,$fecha_nota);
		$d['BL_Adm7_12'] = $this->enfermeria_model->obtenerBlAdmFecha7_12($id_atencion,$fecha_nota);
		$d['BL_Adm13_18'] = $this->enfermeria_model->obtenerBlAdmFecha13_18($id_atencion,$fecha_nota);
		$d['BL_Adm19_6'] = $this->enfermeria_model->obtenerBlAdmFecha19_6($id_atencion,$fecha_nota);
		$d['BL_Adm24'] = $this->enfermeria_model->obtenerBlAdmFecha24($id_atencion,$fecha_nota);
		// eliminados
		$d['BL_Eli7_12'] = $this->enfermeria_model->obtenerBlEliFecha7_12($id_atencion,$fecha_nota);
		$d['BL_Eli13_18'] = $this->enfermeria_model->obtenerBlEliFecha13_18($id_atencion,$fecha_nota);
		$d['BL_Eli19_6'] = $this->enfermeria_model->obtenerBlEliFecha19_6($id_atencion,$fecha_nota);
		$d['BL_Eli24'] = $this->enfermeria_model->obtenerBlEliFecha24($id_atencion,$fecha_nota);
	
	
    //$d['evo'] = $this->enfermeria_model->obtenerBalancelEnfermeria($id_nota);
	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['evo'][0]['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    
    //---------------------------------------------------------------
    $this->load->view('impresion/BalancelEnfermeria',$d);
    //---------------------------------------------------------------
  }

//////////////////////////////////////////////////////////////////////////////////
 public function SvEnfermeria($id_atencion)
  {
    $d = array();
    $d['evo'] = $this->impresion_model->ConsultaSv($id_atencion);
	
	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['evo'][0]['id_atencion']);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    
    //---------------------------------------------------------------
   $this->load->view('impresion/SvEnfermeria',$d);
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
		$d['remision'] = $this -> urgencias_model -> obtenerRemision($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		
		$d['evo'] = $this -> urgencias_model -> obtenerEvosRemision($d['remision']['id_remision']);
		$d['dxI'] = $this -> urgencias_model -> obtenerDxRemI($d['remision']['id_remision']);
		$d['dxE'] = $this -> urgencias_model -> obtenerDxRemE($d['remision']['id_remision']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($d['remision']['id_usuario']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		
    //---------------------------------------------------------------
    $this->load->view('impresion/remision',$d);
    //---------------------------------------------------------------
  } 


///////////////////////////////////////////////////////////////////
/*
* Consultar una orden médica indicada
*
* @author Diego Ivan Carvajal GIl <dcarvajal@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20120601
* @version 20120601
* @return  string (html)
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 

  public function ImagenesDX()
  {
    //---------------------------------------------------------------
    $d = array();
	$orden = $this->input->post('id_orden');
	
	$id_orden = $orden['id_orden'];
    //---------------------------------------------------------------
	$d['imagenes'] = $this->input->post('imagenes');
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
  
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
    $d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
  
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> urgencias_model -> obtenerOrdenInsumos($id_orden);
	$d['analisis']= $this->input->post('analisis');
	$d['enfermedad_actual']= $this->input->post('enfermedad_actual');
	
		


    //---------------------------------------------------------------
    $this -> load -> view('impresion/ImagenesDX', $d);
    //--------------
  }


/*
* Agrega al listado los medicamentos que son modificados
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110610
* @version		20110610
* @return		HTML
*/
function ImprimirImagenesRx($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
	
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('urg/ordenamiento/main/'.$id_atencion);
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
    $d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> urgencias_model -> obtenerOrdenInsumos($id_orden);
	$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
	$fecha['minutos']=$this -> impresion_model -> diferenciafecha($d['consulta']['fecha_fin_consulta']);
if($fecha['minutos'][0]['minutos'] > 1440)
{
	
	$d['consulta'] = $this -> impresion_model -> obtenerConsulta($id_atencion);
	
	
	}
	
	
	
    //---------------------------------------------------------------
    $this->load->view('core/efecto_inicio');
    $this -> load -> view('urg/urg_ConsultarRXImp', $d);
    $this->load->view('core/efecto_fin'); 
    //---------------------------------------------------------------
  }



		//----------------------------------------------------------
			/* 
* @Descripcion: Permite consultar los signos vitales para monitoria.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120715
* @version		20120715
*/
	
public function consultaMonitoria($id_atencion,$fecha_turno)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		//Capturamos los datos de los signos vitales de un determinado dia.
		
		$d['listado'] = $this -> enfermeria_model -> obtenerMonitoriaFecha($id_atencion,$fecha_turno);
		
		$d['fecha_turno']=$fecha_turno;

		//-----------------------------------------------------------
		
		$this -> load -> view('impresion/urg_svMonitoria', $d);

		//----------------------------------------------------------
		}




}
?>
