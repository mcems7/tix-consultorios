<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Observacion
 *Tipo: controlador
 *Descripcion: Permite gestionar los pacientes remitidos a observacion del servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 21 de octubre de 2010
*/
class Observacion extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('inter/interconsulta_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/medico_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('lab/ordenes_model');
		$this -> load -> model('hce/hce_model');
		$this->load->library('session');
	}
///////////////////////////////////////////////////////////////////
/*
* Listado salas de observación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20101025
* @version		20101025
*/		
	function index()
	{
		//-------------------------"salasObs---------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		$d['estados'] = $this->urgencias_model->obtenerEstadosCamas();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsSalas', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Gestión observación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20101103
* @version		20101103
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/observacion/index');
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		$d['observacion'] = $this -> urgencias_model -> obtenerObservacionAtencion($id_atencion);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['observacion']['id_medico_remite']);
		$d['inter'] = $this -> interconsulta_model -> obtenerInterconsultasAtencion($id_atencion);
		$d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dxEvo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		$d['rem'] = $this ->hce_model -> obtenerRemision($id_atencion);
		$d['puntaje'] = $this->urgencias_model->obtenerValoracionPuntajeRiesgo($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsGestionAtencion', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
/*
* Crear plan de manejo observación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20100928
* @version		20100928
*/	
	function crearOrden($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerUltOrden($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/gestion_atencion/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
		$d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
		$d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
		$d['cuidados'] = $this -> urgencias_model -> obtenerCuidadosE();
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrg(); 
		//---------------------------------------------------------------
		$d['dietas'] = $this -> urgencias_model -> obtenerDietas();
		$d['o2'] = $this -> urgencias_model -> obtenerOxigeno();
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsPlanManejoCrear', $d);
		//---------------------------------------------------------------
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Almacenar plan de manejo observación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20100928
* @version		20100928
*/	
	function crearOrden_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		$d['id_medico'] 	= $this->input->post('id_medico');
		$d['id_dieta'] 		= $this->input->post('id_dieta');
		$d['cama_cabeza'] 	= $this->input->post('cama_cabeza');
		$d['cama_pie'] 		= $this->input->post('cama_pie');
		$d['oxigeno'] 		= $this->input->post('oxigeno');
		$d['id_oxigeno'] 	= $this->input->post('id_oxigeno');
		$d['id_oxigeno_valor'] 	= $this->input->post('id_oxigeno_valor');
		$d['liquidos'] 		= $this->input->post('liquidos');
		
		$d['id_cuidado'] = $this->input->post('id_cuidado_');
		$d['frecuencia_cuidado'] = $this->input->post('frecuencia_cuidado_');
		$d['id_frecuencia_cuidado'] = $this->input->post('id_frecuencia_cuidado_');
		
		$d['cuidados_generales'] = mb_strtoupper($this->input->post('cuidados_generales'),'utf-8');
		
		$d['bandera'] 	= $this->input->post('bandera');
		$d['pos'] 	= $this->input->post('pos_');
		$d['atc'] 	= $this->input->post('atc_');
		$d['dosis'] 	= $this->input->post('dosis_');
		$d['id_unidad'] 	= $this->input->post('id_unidad_');
		$d['frecuencia'] 	= $this->input->post('frecuencia_');
		$d['id_frecuencia'] 	= $this->input->post('id_frecuencia_');
		$d['id_via'] 	= $this->input->post('id_via_');
		$d['observacionesMed'] 	= $this->input->post('observacionesMed_');
		$d['cups'] 	= $this->input->post('cups_');
		$d['cantidadCups'] 	= $this->input->post('cantidadCups_');
		$d['observacionesCups'] 	= $this->input->post('observacionesCups_');
		
		$d['verificado'] = $this->input->post('verificado');
		$d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
		$d['fecha_verificado'] 	= $this->input->post('fecha_verificado');
		$d['fecha_ini_ord'] 	= $this->input->post('fecha_ini_ord');
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		//Codificación de la nueva area de servicio
		switch ($d['atencion']['id_servicio']) {
    		case 12: $d['id_servicio'] = 16;break;
    		case 13: $d['id_servicio'] = 17;break;
			case 14: $d['id_servicio'] = 19;break;
    		case 15: $d['id_servicio'] = 18;break;
			case 16: $d['id_servicio'] = 16;break;
    		case 17: $d['id_servicio'] = 17;break;
    		case 18: $d['id_servicio'] = 18;break;
			case 19: $d['id_servicio'] = 19;break;
		}
		//----------------------------------------------------------
		$this -> urgencias_model -> actualizarEstado($d['id_atencion'],'5');
		$this -> urgencias_model -> remitirObservacion($d);
		
		$r = $this -> urgencias_model -> crearPlanManejoDb($d);
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del plan de manejo de observacion ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/gestion_atencion/main/'.$d['id_atencion']);
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);	
		redirect("auto/anexo2/generarAnexo2Obs/".$d['id_atencion']."/".$atencion['id_entidad']);
		
		//----------------------------------------------------
		$dt['mensaje']  = "El plan de manejo se ha creado exitosamente. El paciente ha sido remitido a observación!!!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index/");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
	
	function mensajeAnexo()
	{
			//----------------------------------------------------
		$dt['mensaje']  = "El plan de manejo se ha creado exitosamente. El paciente ha sido remitido a observación!!!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index/");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////	
	function ingresoObservacion($id_observacion)
	{
		$observacion = $this->urgencias_model->obtenerObservacion($id_observacion);
		$camas = $this->urgencias_model->obtenerCamasDispoServicio($observacion['id_servicio']);
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
							'onclick' => "asignarCama('".$id_observacion."')",
							'value' => 'Asignar',
							'type' =>'button');
			$cadena .= form_input($data);
		}else{
			$cadena = 'No hay camas disponibles';
		}
		echo $cadena;
	}
///////////////////////////////////////////////////////////////////
	function listadoPacientesSala()
	{	
		//----------------------------------------------------------
		$id_salaObs 	= $this->input->post('salasObs');
		
		if($id_salaObs == 0){
				$id_salaObs = $this->session->userdata('id_salaObs');
		}else{
		
			$this->session->unset_userdata('id_salaObs');
			$this->session->set_userdata('id_salaObs',$id_salaObs);
		}
			
		
		$id_servicio 	= $this->input->post('salasObs');
		$id_estado 	= $this->input->post('estado');
		$d['servicio'] = $this -> urgencias_model -> obtenerInfoServicio($id_salaObs);
		$d['lista'] = $this -> urgencias_model -> obtenerPacientesObservacionUrg($id_salaObs );
		$d['camas'] = $this -> urgencias_model -> obtenerCamasServicio($id_salaObs ,$id_estado);
		//echo $this->db->last_query();die();
		//----------------------------------------------------------
		$this -> load -> view('urg/urg_obsSalasDetalle',$d);
		//----------------------------------------------------------
	}
////////////////////////////////////////////////////////////////////
	function activarCama($id_cama)
	{	
		//----------------------------------------------------------
		$id_servicio 	= $this->input->post('salasObs');
		$id_estado 	= 0;
		$this -> urgencias_model -> activarCamaObservacion($id_cama);
		$d['servicio'] = $this -> urgencias_model -> obtenerInfoServicio($id_servicio);
		$d['lista'] = $this -> urgencias_model -> obtenerPacientesObservacionUrg($id_servicio);
		$d['camas'] = $this -> urgencias_model -> obtenerCamasServicio($id_servicio,$id_estado);
		//echo $this->db->last_query();die();
		//----------------------------------------------------------
		$this -> load -> view('urg/urg_obsSalasDetalle',$d);
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function ingresoObservacionCama($id_observacion,$id_cama)
	{
		$this -> urgencias_model -> ingresoObservacionDb($id_observacion,$id_cama);
		$cama = $this-> urgencias_model -> detalleCama($id_cama);
		echo $cama['numero_cama'];
	}
	function consultaTriage($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
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
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
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
	function epicrisis($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		$d['evo'] = $this -> urgencias_model -> obtenerEvoluciones($id_atencion);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsEpicrisis',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function epicrisis_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 		= $this->input->post('id_atencion');
		$d['id_medico'] 		= $this->input->post('id_medico');
		$d['fecha_egreso'] 		= $this->input->post('fecha_egreso');
		$d['id_servicio'] 		= $this->input->post('id_servicio');
		$d['estado_salida'] 	= $this->input->post('estado_salida');
		$d['tiempo_muerto'] 	= $this->input->post('tiempo_muerto');
		$d['incapacidad'] 		= $this->input->post('incapacidad');
		$d['incapacidad_dias'] 	= $this->input->post('incapacidad_dias');
		$d['dxI'] 				= $this->input->post('dxI');
		$d['dxE'] 				= $this->input->post('dxE');
		$d['examenes_auxiliares'] 	= $this->input->post('examenes_auxiliares');
		$d['evos']	 			= $this->input->post('evos');
		$d['traslado'] 			= $this->input->post('traslado');
		$d['nivel_traslado'] 	= $this->input->post('nivel_traslado');
		$d['lugar_traslado'] 	= $this->input->post('lugar_traslado');
		$d['cita_con_ext'] 		= $this->input->post('cita_con_ext');
		$d['id_especialidad'] 	= $this->input->post('id_especialidad');
		$d['cita_conext'] 		= $this->input->post('cita_conext');
		$d['cita_hosp_local'] 	= $this->input->post('cita_hosp_local');
		$d['municipio_cita'] 	= $this->input->post('municipio_cita');
		$d['cita_hopslocal'] 	= $this->input->post('cita_hopslocal');
		$d['id_destino'] 		= $this->input->post('id_destino');
		$d['observacion'] 		= $this -> urgencias_model -> obtenerObservacionAtencion($d['id_atencion']);
		$this->urgencias_model->liberarCama($d['observacion']['id_cama']);
		//----------------------------------------------------------
		$r = $this -> urgencias_model -> epicrisisDb($d);
		
	
		
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de la apicrisis id atencion".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realizo con exito.";
			$dat['urlRegresar'] = site_url('urg/salas/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		
		
		//----------------------------------------------------
		$dt['mensaje']  = "La epicrisis se ha almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/observacion/consultaEpicrisis/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------

	}
///////////////////////////////////////////////////////////////////
	function consultaEpicrisis($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/observacion/index');
		$d['epicrisis'] = $this -> urgencias_model -> obtenerEpicrisis($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		
		$d['evo'] = $this -> urgencias_model -> obtenerEvosEpicrisis($d['epicrisis']['id_epicrisis']);
		
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dxI'] = $this -> urgencias_model -> obtenerDxEpiI($d['epicrisis']['id_epicrisis']);
		$d['dxE'] = $this -> urgencias_model -> obtenerDxEpiE($d['epicrisis']['id_epicrisis']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsConEpicrisis',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Consultar una evolución epicrisis
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110407
* @version		20110407
*/	
	function consultaEvolucion($id_evolucion)
	{
		$d = array();
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($id_evolucion);
		$d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($id_evolucion);
		echo $this->load->view('urg/urg_obsEvoConsulta',$d);
	}

///////////////////////////////////////////////////////////////////
	function cambiarCamaObser($id_atencion)
	{
		
		$observacion = $this -> urgencias_model -> obtenerObservacionAtencion($id_atencion);
		$atencion = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		$camas = $this->urgencias_model->obtenerCamasDispoServicio($atencion['id_servicio']);
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
							'onclick' => "asignarCama('".$observacion['id_observacion']."')",
							'value' => 'Asignar',
							'type' =>'button');
			$cadena .= form_input($data);
		}else{
			$cadena = 'No hay camas disponibles';
		}
		echo $cadena;
	}
///////////////////////////////////////////////////////////////////
	function cambiarObservacionCama($id_observacion,$id_cama)
	{
		$observacion = $this->urgencias_model->obtenerObservacion($id_observacion);
		$this -> urgencias_model -> cambiarObservacionDb($id_observacion,$id_cama);
		$this->urgencias_model->liberarCama($observacion['id_cama']);
		$cama = $this-> urgencias_model -> detalleCama($id_cama);
		echo $cama['numero_cama'];
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/*Crear una remision
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120107
* @version		20120107
*/

///////////////////////////////////////////////////////////////////
	function remision($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		$d['evo'] = $this -> urgencias_model -> obtenerEvoluciones($id_atencion);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsRemision',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/* Guardar una remision una remision
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120107
* @version		20120107
*/
	function remision_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 		= $this->input->post('id_atencion');
		$d['id_medico'] 		= $this->input->post('id_medico');
		$d['fecha_egreso'] 		= $this->input->post('fecha_egreso');
		$d['id_servicio'] 		= $this->input->post('id_servicio');
		$d['estado_salida'] 	= $this->input->post('estado_salida');
		$d['motivo_remision'] 	= $this->input->post('motivo_remision');
		$d['resumen_anamnesis'] 		= $this->input->post('resumen_anamnesis');
		$d['complicaciones'] 	= $this->input->post('complicaciones');
		$d['dxI'] 				= $this->input->post('dxI');
		$d['dxE'] 				= $this->input->post('dxE');
		$d['examenes_auxiliares'] 	= $this->input->post('examenes_auxiliares');
		$d['evos']	 			= $this->input->post('evos');
		$d['traslado'] 			= $this->input->post('traslado');
		$d['nivel_traslado'] 	= $this->input->post('nivel_traslado');
		$d['lugar_traslado'] 	= $this->input->post('lugar_traslado');
		$d['cita_con_ext'] 		= $this->input->post('cita_con_ext');
		$d['id_especialidad'] 	= $this->input->post('id_especialidad');
		$d['cita_conext'] 		= $this->input->post('cita_conext');
		$d['cita_hosp_local'] 	= $this->input->post('cita_hosp_local');
		$d['municipio_cita'] 	= $this->input->post('municipio_cita');
		$d['cita_hopslocal'] 	= $this->input->post('cita_hopslocal');
		$d['id_destino'] 		= $this->input->post('id_destino');
		$d['observacion'] 		= $this -> urgencias_model -> obtenerObservacionAtencion($d['id_atencion']);
		//----------------------------------------------------------
		$rem = $this -> urgencias_model -> existe_remision($d['id_atencion']);
	    
		if ($rem != '')
		{
			$this -> urgencias_model -> cancelar_remision($d['id_atencion']);
			
		}
		
		$r = $this -> urgencias_model -> remisionDb($d);
		
	
		
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de la remision id atencion".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realizo con exito.";
			$dat['urlRegresar'] = site_url('urg/salas/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		
		
		//----------------------------------------------------
		$dt['mensaje']  = "La remision se ha almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/observacion/consultaRemision/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------

	}
///////////////////////////////////////////////////////////////////

/*Consultar una remision
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120107
* @version		20120107
*/
	function consultaRemision($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/observacion/index');
		$d['remision'] = $this -> urgencias_model -> obtenerRemision($id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		
		$d['evo'] = $this -> urgencias_model -> obtenerEvosRemision($d['remision']['id_remision']);
		
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dxI'] = $this -> urgencias_model -> obtenerDxRemI($d['remision']['id_remision']);
		$d['dxE'] = $this -> urgencias_model -> obtenerDxRemE($d['remision']['id_remision']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_obsConRemision',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
}
?>
