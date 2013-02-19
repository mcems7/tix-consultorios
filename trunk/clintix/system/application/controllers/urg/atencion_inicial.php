<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Atencion_inicial
 *Tipo: controlador
 *Descripcion: Permite crear el registro de la atención inicial en el servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 06 de septiembre de 2010
*/
class Atencion_inicial extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con formulario para atención inicial de urgencias
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100901
* @version		20100901
*/	
	function consultaInicial($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();

		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		//----------------------------------------------------------
		$consulta = $d['atencion']['consulta'];
		if($consulta == 'SI'){
		redirect('urg/gestion_atencion/main/'.$id_atencion);
		}
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('urg/salas/index');
		
		$this -> urgencias_model -> actualizarEstado($id_atencion,'3');
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		//Verifica si el usuario del sistema esta creado como medico para poder acceder a la consulta
		if(!$d['id_medico'])
		{
			$dt['mensaje']  = "El usuario ".$this->session->userdata('_username')." no se encuentra asignado al personal medico!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		}
		
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['fecha_ini_consulta'] = date('Y-m-d H:i:s');
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_consultaInicial', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		
	}


function editarConsultaInicial($id_atencion)
  {
    //----------------------------------------------------------
    $d = array();
    $e = array();

    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
	$d['consulta_ant'] = $this -> urgencias_model -> obtenerConsulta_ant($d['consulta']['id_consulta']);
	$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
    //----------------------------------------------------------
    $d['urlRegresar']   = site_url('urg/salas/index');
    
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
    $d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['tipo_usuario']  = $this -> paciente_model -> tipos_usuario();
    $d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
    $d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
    //Verifica si el usuario del sistema esta creado como medico para poder acceder a la consulta
    if(!$d['id_medico'])
    {
      $dt['mensaje']  = "El usuario ".$this->session->userdata('_username')." no se encuentra asignado al personal medico!!";
    $dt['urlRegresar']  = site_url("urg/salas/index");
    $this -> load -> view('core/presentacionMensaje', $dt);
    return; 
    }
    
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
    $d['fecha_ini_consulta'] = date('Y-m-d H:i:s');
    //-----------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('urg/urg_editarconsultaInicial', $d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
    
  }
///////////////////////////////////////////////////////////////////
/*
* Verifica y confirma las historias clinicas gestionadas por internos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100910
* @version		20100910
* @return		HTML
*/
	function consultaConfirma()
	{
		$d['_username'] 		= $this->input->post('user_log');
		$d['_password'] 		= md5($this->input->post('pass_log'));
		$dat['med'] = $this -> urgencias_model -> verificarMedicoConsulta($d);
		if($dat['med'] == 0){
			
			echo "<script>alert('Verifique los datos del usuario e intente de nuevo!!');</script>";
			echo $this->load->view('urg/urg_consultaConfirm');	
		}else{
			echo $this->load->view('urg/urg_consultaMedConfirm',$dat);
		}
		
	}
///////////////////////////////////////////////////////////////////
/*
* Recibe la información consignada en la consulta inicial. historia clinica
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100910
* @version		20100910
*/
	function consultaInicial_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['motivo_consulta'] 		= mb_strtoupper($this->input->post('motivo_consulta'),'utf-8');
		$d['enfermedad_actual']  	= mb_strtoupper($this->input->post('enfermedad_actual'),'utf-8');
		$d['revicion_sistemas']  	= mb_strtoupper($this->input->post('revicion_sistemas'),'utf-8');
		$d['ant_patologicos']  		= mb_strtoupper($this->input->post('ant_patologicos'),'utf-8');
		$d['ant_famacologicos'] 	= mb_strtoupper($this->input->post('ant_famacologicos'),'utf-8');
		$d['ant_toxicoalergicos'] 	= mb_strtoupper($this->input->post('ant_toxicoalergicos'),'utf-8');
		$d['ant_quirurgicos'] 		= mb_strtoupper($this->input->post('ant_quirurgicos'),'utf-8');
		$d['ant_familiares'] 		= mb_strtoupper($this->input->post('ant_familiares'),'utf-8');
		$d['ant_ginecologicos'] 	= mb_strtoupper($this->input->post('ant_ginecologicos'),'utf-8');
		$d['ant_otros'] 			= mb_strtoupper($this->input->post('ant_otros'),'utf-8');
		$d['condiciones_generales'] = mb_strtoupper($this->input->post('condiciones_generales'),'utf-8');
		$d['talla'] 	= $this->input->post('talla');
		$d['peso'] 		= $this->input->post('peso');		
		$d['frecuencia_cardiaca'] 		= $this->input->post('frecuencia_cardiaca');
		$d['frecuencia_respiratoria'] 	= $this->input->post('frecuencia_respiratoria');
		$d['ten_arterial_s'] 			= $this->input->post('ten_arterial_s');
		$d['ten_arterial_d'] 			= $this->input->post('ten_arterial_d');
		$d['temperatura'] 				= $this->input->post('temperatura');
		$d['spo2'] 						= $this->input->post('spo2');
		$d['exa_cabeza'] 			= mb_strtoupper($this->input->post('exa_cabeza'),'utf-8');
		$d['exa_ojos'] 				= mb_strtoupper($this->input->post('exa_ojos'),'utf-8');
		$d['exa_oral'] 				= mb_strtoupper($this->input->post('exa_oral'),'utf-8');
		$d['exa_cuello'] 			= mb_strtoupper($this->input->post('exa_cuello'),'utf-8');
		$d['exa_dorso'] 			= mb_strtoupper($this->input->post('exa_dorso'),'utf-8');
		$d['exa_torax'] 			= mb_strtoupper($this->input->post('exa_torax'),'utf-8');
		$d['exa_abdomen'] 			= mb_strtoupper($this->input->post('exa_abdomen'),'utf-8');
		$d['exa_genito_urinario'] 	= mb_strtoupper($this->input->post('exa_genito_urinario'),'utf-8');
		$d['exa_extremidades'] 		= mb_strtoupper($this->input->post('exa_extremidades'),'utf-8');
		$d['exa_neurologico'] 		= mb_strtoupper($this->input->post('exa_neurologico'),'utf-8');
		$d['exa_piel'] 				= mb_strtoupper($this->input->post('exa_piel'),'utf-8');
		$d['exa_mental'] 			= mb_strtoupper($this->input->post('exa_mental'),'utf-8');
		$d['dx'] = $this->input->post('dx_ID_');
		$d['tipo_dx'] = $this->input->post('tipo_dx_');
		$d['orden_dx'] = $this->input->post('orden_dx_');
		$d['analisis'] 				= mb_strtoupper($this->input->post('analisis'),'utf-8');
		$d['conducta'] 				= mb_strtoupper($this->input->post('conducta'),'utf-8');
		$d['verificado'] 			= $this->input->post('verificado');
		$d['id_medico_verifica'] 	= $this->input->post('id_medico_verifica');
		$d['id_medico'] 			= $this->input->post('id_medico');
		$d['id_atencion'] 			= $this->input->post('id_atencion');
		$d['id_paciente'] 			= $this->input->post('id_paciente');
		$d['id_servicio'] 			= $this->input->post('id_servicio');
		$d['fecha_ini_consulta'] 	= $this->input->post('fecha_ini_consulta');
		//----------------------------------------------------------
		// Datos valoración de riesgos de caídas. Escala de crichton //
		$d['limitacion_fisica'] = $this->input->post('limitacion_fisica');
		$d['estado_mental'] = $this->input->post('estado_mental');
		$d['tratamiento_farmacologico'] = $this->input->post('tratamiento_farmacologico');
		$d['problemas_de_idioma'] = $this->input->post('problemas_de_idioma');
		$d['incontinencia_urinaria'] = $this->input->post('incontinencia_urinaria');
		$d['deficit_sensorial'] = $this->input->post('deficit_sensorial');
		$d['desarrollo_psicomotriz'] = $this->input->post('desarrollo_psicomotriz');
		$d['pacientes_sin_facores'] = $this->input->post('pacientes_sin_facores');
		//----------------------------------------------------------
		// Vigilancia epidemiologica
		$this->load->model('epi/epi_model');
		$this->epi_model->verificarAtencionVigilancia($d);
		//----------------------------------------------------------
		$r = $this->urgencias_model->segu_riesgo_caidasDb($d);
		//----------------------------------------------------------
		$this -> urgencias_model -> actualizarEstado($d['id_atencion'],'4');
		$r = $this -> urgencias_model -> consultaInicialDb($d);
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de la consulta id ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/salas/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de consulta se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/gestion_atencion/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////


function editarConsultaInicial_()
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['id_consulta']   = $this->input->post('id_consulta');
	 $d['motivo_consulta'] 		= mb_strtoupper($this->input->post('motivo_consulta'),'utf-8');
		$d['enfermedad_actual']  	= mb_strtoupper($this->input->post('enfermedad_actual'),'utf-8');
		$d['revicion_sistemas']  	= mb_strtoupper($this->input->post('revicion_sistemas'),'utf-8');
		$d['ant_patologicos']  		= mb_strtoupper($this->input->post('ant_patologicos'),'utf-8');
		$d['ant_famacologicos'] 	= mb_strtoupper($this->input->post('ant_famacologicos'),'utf-8');
		$d['ant_toxicoalergicos'] 	= mb_strtoupper($this->input->post('ant_toxicoalergicos'),'utf-8');
		$d['ant_quirurgicos'] 		= mb_strtoupper($this->input->post('ant_quirurgicos'),'utf-8');
		$d['ant_familiares'] 		= mb_strtoupper($this->input->post('ant_familiares'),'utf-8');
		$d['ant_ginecologicos'] 	= mb_strtoupper($this->input->post('ant_ginecologicos'),'utf-8');
		$d['ant_otros'] 			= mb_strtoupper($this->input->post('ant_otros'),'utf-8');
		$d['condiciones_generales'] = mb_strtoupper($this->input->post('condiciones_generales'),'utf-8');
		$d['talla'] 	= $this->input->post('talla');
		$d['peso'] 		= $this->input->post('peso');		
		$d['frecuencia_cardiaca'] 		= $this->input->post('frecuencia_cardiaca');
		$d['frecuencia_respiratoria'] 	= $this->input->post('frecuencia_respiratoria');
		$d['ten_arterial_s'] 			= $this->input->post('ten_arterial_s');
		$d['ten_arterial_d'] 			= $this->input->post('ten_arterial_d');
		$d['temperatura'] 				= $this->input->post('temperatura');
		$d['spo2'] 						= $this->input->post('spo2');
		$d['exa_cabeza'] 			= mb_strtoupper($this->input->post('exa_cabeza'),'utf-8');
		$d['exa_ojos'] 				= mb_strtoupper($this->input->post('exa_ojos'),'utf-8');
		$d['exa_oral'] 				= mb_strtoupper($this->input->post('exa_oral'),'utf-8');
		$d['exa_cuello'] 			= mb_strtoupper($this->input->post('exa_cuello'),'utf-8');
		$d['exa_dorso'] 			= mb_strtoupper($this->input->post('exa_dorso'),'utf-8');
		$d['exa_torax'] 			= mb_strtoupper($this->input->post('exa_torax'),'utf-8');
		$d['exa_abdomen'] 			= mb_strtoupper($this->input->post('exa_abdomen'),'utf-8');
		$d['exa_genito_urinario'] 	= mb_strtoupper($this->input->post('exa_genito_urinario'),'utf-8');
		$d['exa_extremidades'] 		= mb_strtoupper($this->input->post('exa_extremidades'),'utf-8');
		$d['exa_neurologico'] 		= mb_strtoupper($this->input->post('exa_neurologico'),'utf-8');
		$d['exa_piel'] 				= mb_strtoupper($this->input->post('exa_piel'),'utf-8');
		$d['exa_mental'] 			= mb_strtoupper($this->input->post('exa_mental'),'utf-8');
		$d['dx'] = $this->input->post('dx_ID_');
		$d['tipo_dx'] = $this->input->post('tipo_dx_');
		$d['orden_dx'] = $this->input->post('orden_dx_');
		$d['analisis'] 				= mb_strtoupper($this->input->post('analisis'),'utf-8');
		$d['conducta'] 				= mb_strtoupper($this->input->post('conducta'),'utf-8');
    $d['verificado'] = $this->input->post('verificado');
    $d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
    $d['id_medico'] = $this->input->post('id_medico');
    $d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_paciente'] 			= $this->input->post('id_paciente');
	$d['id_servicio'] 			= $this->input->post('id_servicio');
    $d['fecha_ini_consulta'] = $this->input->post('fecha_ini_consulta');
	//----------------------------------------------------------
	// Vigilancia epidemiologica
	$this->load->model('epi/epi_model');
	$this->epi_model->verificarAtencionVigilanciaEdit($d);
    //----------------------------------------------------------
    $r = $this -> urgencias_model -> editarConsultaInicialDb_($d);
    if($r['error'])
    {
      $this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
      ,'aplicacion',"Error en la creación de la consulta id ".$d['id_atencion']);
      $dat['mensaje'] = "La operación no se realio con exito.";
      $dat['urlRegresar'] = site_url('urg/salas/index');
      $this -> load -> view('core/presentacionMensaje', $dat);
      return;
    }
    //----------------------------------------------------
    $dt['mensaje']  = "Los datos de consulta se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("urg/gestion_atencion/main/".$d['id_atencion']);
    $this -> load -> view('core/presentacionMensaje', $dt);
    return; 
    //----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
	function desistirAtencion($id_atencion)
	{
		$this -> urgencias_model -> actualizarEstado($id_atencion,'2');
		//----------------------------------------------------
		$dt['mensaje']  = "La consulta ha finalizado!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
	
	///////////////////////////////////////////////////////////////////
/*
* Metodo de autocompletado para diagnosticos simple 
*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100901
* @version		20100901
* @return		HTML
*/	
	function diagnosticos($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('diagnostico',$l);
		$this->db->or_like('id_diag',$l);
		$r = $this->db->get('core_diag_item');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id_diag"]."###<strong>".$d["id_diag"]."</strong> ".$d["diagnostico"]."|";
		}
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con metodo avanzado de codificar diagnosticos 
*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxAvanzados()
	{
		$d['capitulos'] = $this -> urgencias_model -> obtenerDxCap();		
		echo $this->load->view('urg/urg_dxAvanzado',$d);
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con metodo simple de codificar diagnosticos 
*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxSimple()
	{
		echo $this->load->view('urg/urg_dxSimple');
	}
///////////////////////////////////////////////////////////////////
/*
* Organiza el select con la lista de capitulos de diagnosticos CIE10 
*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxCaps($cap)
	{
		$nivel1 = $this -> urgencias_model -> obtenerDxNivel1($cap);
		
		$cadena ='';
		$cadena .= '<select name="nivel1" id="nivel1" onChange="nivel1Dx()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($nivel1 as $d)
			{
				$cadena .='<option value="'.$d['id_nivel1'].'">'.$d['desc_nivel1'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;		
	}
///////////////////////////////////////////////////////////////////
/*
* Organiza el select con la lista de subgrupos de diagnosticos  CIE10
*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/
	function dxNivel1($nivel1)
	{
		$nivel2 = $this -> urgencias_model -> obtenerDxNivel2($nivel1);
		
		$cadena ='';
		$cadena .= '<select name="nivel2" id="nivel2" onChange="nivel2Dx()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($nivel2 as $d)
			{
				$cadena .='<option value="'.$d['id_nivel2'].'">'.$d['desc_nivel2'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////	
/*
* Organiza el select con la lista de diagnosticos CIE10
*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/
	function dxNivel2($nivel2)
	{
		$diag = $this -> urgencias_model -> obtenerDx($nivel2);
		
		$cadena ='';
		$cadena .= '<select id="dx_hidden" name="dx_ID"';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($diag as $d)
			{
				$cadena .='<option value="'.$d['id_diag'].'"><strong>'.$d['id_diag']."</strong>&nbsp;".$d['diagnostico'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
/*
* Agrega los diagnosticos al listado de la consulta

*
* @author Carlos AndrÃ©s Jaramillo PatiÃ±o <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20101019
* @version		20101019
* @return		HTML
*/	
	function agregar_dx()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['dx_ID'] = $this->input->post('dx_ID');
		$d['dx'] = $this->urgencias_model->obtenerDxCon($d['dx_ID']);
		echo $this->load->view('urg/urg_dxInfo',$d);
	}
///////////////////////////////////////////////////////////////////


}
?>
