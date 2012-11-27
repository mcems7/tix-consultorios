<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Triage
 *Tipo: controlador
 *Descripcion: Gestiona la realización del triage a los pacientes que llegan al servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 26 de agosto de 2010
*/
class Triage extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	 		
		$this -> load -> helper( array('url','form') );
		$this -> load -> model('core/Registro'); 
	}
///////////////////////////////////////////////////////////////////
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------7
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_triage_busqueda', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function buscarPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/triage');
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		//----------------------------------------------------------
		//Verificar atención previa
		$d['verAten'] = $this ->urgencias_model -> verificarAtencionTriage($d['numero_documento']);
		
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		//Verifica si el usuario del sistema esta creado como medico para poder acceder a la consulta
		if(!$d['id_medico'])
		{
			$dt['mensaje']  = "El usuario ".$this->session->userdata('_username')." no se encuentra asignado al personal medico!!";
		$dt['urlRegresar'] 	= site_url("urg/salas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		}
		$this->load->view('core/core_inicio');
		$this->load->view('urg/urg_listadoAtenciones',$d);
		$this->load->view('core/core_fin');
	}
	
	function inicioTriage($numero_documento,$reingreso,$id_atencion = 0)
	{
		$d['urlRegresar'] 	= site_url('urg/triage/index');
		$d['numero_documento'] = $numero_documento;
		$d['reingreso'] = $reingreso;
		$d['id_atencion'] = $id_atencion;
		$verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['entidades_remision'] = $this -> urgencias_model -> obtenerEntidadesRemision();
		
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$this->load->view('core/core_inicio');
		//Verifica la existencia del tercero en el sistema
		if($verTer != 0)
		{
			$verPas = $this -> paciente_model -> verificarPaciente($verTer);
			//Verifica la existencia del tercero como paciente
			if($verPas != 0)
			{
				$d['tipo'] = 'n';
				$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($verPas);
				$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
				$this -> load -> view('urg/urg_triage',$d);
			}else
			{
				$d['tipo'] = 'paciente';
				$d['tercero'] = $this -> urgencias_model -> obtenerTercero($verTer);
				$this -> load -> view('urg/urg_triage',$d);
			}
		}else{
			$d['tipo'] = 'tercero';
			$this -> load -> view('urg/urg_triage',$d);
		}	
		$this->load->view('core/core_fin');
	}
///////////////////////////////////////////////////////////////////
	function crearTriage_()
	{
		$d = array();
		$da = array();
		$dat = array();
		$d['tipo'] 	= $this->input->post('tipo');
		$reingreso 	= $this->input->post('reingreso');
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		if($reingreso == 1){
			$d['reingreso'] = 'SI';
			$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
			$d['ingreso'] = $atencion['ingreso'];
		}else{
			$d['reingreso'] = 'NO';
			$d['ingreso'] = '';
		}		
		
		//----------------------------------------------------
		if($d['tipo'] == 'tercero' ){
			//----------------------------------------------------
			$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
			$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
			$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
			$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
			$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
			$d['numero_documento'] 	= $this->input->post('numero_documento');
			$d['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
			

			$verTer = $this -> tercero_model ->verificaTercero($d['numero_documento']);
			if($verTer != 0){
			$dat['mensaje'] = "Ya existe un tercero con el número de documento de identidad ".$d['numero_documento']."!!";
			$dat['urlRegresar'] = site_url('urg/triage/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
			}
			//----------------------------------------------------
		
			$da['id_tercero'] = $this -> urgencias_model -> crearTerceroUrg($d);
			//----------------------------------------------------
			$da['genero']			= $this->input->post('genero');
			$da['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
			//----------------------------------------------------
			$d['id_paciente'] =$this -> urgencias_model -> crearPacienteUrg($da);
			//----------------------------------------------------
			
		}else if($d['tipo'] == 'paciente'){
			//----------------------------------------------------
			$da['id_tercero']	= $this->input->post('id_tercero');
			$da['genero']		= $this->input->post('genero');
			//----------------------------------------------------
			$d['id_paciente'] =	$this -> urgencias_model -> crearPacienteUrg($da);
			//----------------------------------------------------
		}else{
			$d['id_tercero']	= $this->input->post('id_tercero');
			$d['id_paciente'] 	= $this->input->post('id_paciente');
		}
		//----------------------------------------------------------
		$d['fecha_ini_triage'] 	= $this->input->post('fecha_ini_triage');
		$d['remitido'] 			= $this->input->post('remitido');
		$d['codigo_entidad'] 	= $this->input->post('codigo_entidad');
		$d['motivo_consulta'] 	= mb_strtoupper($this->input->post('motivo_consulta'),'utf-8');	
		$d['antecedentes'] 		= mb_strtoupper($this->input->post('antecedentes'),'utf-8');
		$d['frecuencia_cardiaca'] 		= $this->input->post('frecuencia_cardiaca');
		$d['frecuencia_respiratoria'] 	= $this->input->post('frecuencia_respiratoria');
		$d['ten_arterial_s'] 	= $this->input->post('ten_arterial_s');
		$d['ten_arterial_d'] 	= $this->input->post('ten_arterial_d');
		$d['temperatura'] 		= $this->input->post('temperatura');
		$d['spo2'] 				= $this->input->post('spo2');
		$d['resp_ocular'] 		= $this->input->post('resp_ocular');
		$d['resp_verbal'] 		= $this->input->post('resp_verbal');
		$d['resp_motora'] 		= $this->input->post('resp_motora');
		$d['id_servicio'] 		= $this->input->post('id_servicio');
		$d['embarazo'] 			= $this->input->post('embarazo');
		$d['clasificacion'] 	= $this->input->post('clasificacion');
		$d['just_blanco'] 		= mb_strtoupper($this->input->post('just_blanco'),'utf-8');
		$d['recomendaciones'] 	= mb_strtoupper($this->input->post('recomendaciones'),'utf-8');
		//----------------------------------------------------------
		if($d['clasificacion'] == 4){
			$d['estado'] = 1;
			$d['activo'] = 'NO'; // 1 = Derivado a otro nivel de atención
		}else{
			$d['estado'] = 2; // 2 = En espera de consulta
			$d['activo'] = 'SI';
		}
		//----------------------------------------------------------
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		//----------------------------------------------------------
		$d['id_atencion'] = $this -> urgencias_model -> crearAtencionDb($d);
		//----------------------------------------------------------
		$r = $this -> urgencias_model -> crearTriageDb($d);
		//----------------------------------------------------	
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del triage id ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/triage/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		
		if($d['clasificacion'] == 4){
			$dat['id_atencion'] = $d['id_atencion'];
			$dat['urlRegresar'] = site_url('urg/triage/index');
			$this -> load -> view('urg/urg_tri_mensaje', $dat);
			return;	
		}
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos se han almacenado correctamente\\n\\nEl paciente puede proseguir a la sala de espera seleccionada!!";
		$dt['urlRegresar'] 	= site_url("urg/triage/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	
	}
///////////////////////////////////////////////////////////////////
	function editarTercero()
	{
		$d = array();
		$d['id_tercero'] 	= $this->input->post('id_tercero');
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['id_tercero']);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		echo $this->load->view('urg/urg_tri_editar_tercero',$d);		
	}
///////////////////////////////////////////////////////////////////
	function editarTerceroGuardar()
	{
		$d = array();
		$d['id_tercero'] 		= $this->input->post('id_tercero');
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
		$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$d['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
		$this -> urgencias_model -> editarTerceroDb($d);
		$tercero = $this -> paciente_model -> obtenerTercero($d['id_tercero']);
		echo $this -> load -> view('urg/urg_tri_consulta_tercero',$tercero);
	}
///////////////////////////////////////////////////////////////////
	function editarPaciente()
	{
		$dat = array();
		$id_paciente 	= $this->input->post('id_paciente');
		$dat['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		echo $this->load->view('urg/urg_tri_editar_paciente',$dat);		
	}
///////////////////////////////////////////////////////////////////
	function editarPacienteGuardar()
	{
		$d = array();
		$da = array();
		$d['id_paciente'] 		= $this->input->post('id_paciente');
		$d['genero'] 			= $this->input->post('genero');
		$this -> urgencias_model -> editarPacienteDb($d);
		$da['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['id_paciente']);
		$this -> load -> view('urg/urg_tri_consulta_paciente',$da);
	}
///////////////////////////////////////////////////////////////////
	function comprobarTercero()
	{
		$d = array();
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
		$d['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
		$r = $this -> paciente_model -> comprobarTercero($d);
		if($r == 0)
		{
			echo '<script language="javascript">
			slideTri.slideIn();
			</script>';	
		}else{
			$dat['lista'] = $r;
			echo $this -> load -> view('urg/urg_tri_lista_tercero',$dat);	
		}
	}
///////////////////////////////////////////////////////////////////
	function obtenerTercero($id_tercero)
	{
		$tercero = $this -> paciente_model -> obtenerTercero($id_tercero);
		
		$verPas = $this -> paciente_model -> verificarPaciente($id_tercero);
		if($verPas != 0)
		{
			echo "<script language='javascript'>
					pacienteExiste('".$verPas."');
				</script>";		
		}	
		echo $this -> load -> view('urg/urg_tri_consulta_tercero',$tercero);
	}
///////////////////////////////////////////////////////////////////
	function obtenerPaciente($id_paciente) 
	{
		$da = array();
		$da['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		echo $this -> load -> view('urg/urg_tri_consulta_paciente',$da);	
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
