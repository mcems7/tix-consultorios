<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: sv_enfermeria
 *Tipo: controlador
 *Descripcion: Gestiona los signos vitales en enfermeria 
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/

class Hospi_sv_enfermeria extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('hospi/hospi_model');
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('hospi/hospi_enfermeria_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
		$this -> load -> helper('html');	
				
	}
///////////////////////////////////////////////////////////////////


	
	/* 
* @Descripcion: genera la lista de signos vitales y su correspondiente grafica.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/
	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
		$d['monitor'] = $this -> hospi_enfermeria_model -> obtenerMonitoria($id_atencion);
	
		$d['urlRegresar'] 	= site_url('/hospi/hospi_enfermeria/main/'.$id_atencion);
		
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_svListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		}
///////////////////////////////////////////////////////////////////

	/* 
* @Descripcion: Consultar un signo vital
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/
	function consultaNota($id)
	{
		$d = array();
		$d['nota'] = $this->hospi_enfermeria_model->obtenerSvNotaConsulta($id);
		echo $this->load->view('hospi/hospi_notaSvConsulta',$d);
	}

///////////////////////////////////////////////////////////////////

	/* 
* @Descripcion:  Crear un registro de un signo vital.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/	
	function crearNota($id_atencion)
	{
				$this -> load -> model('urg/urgencias_model'); 
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
	
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> hospi_model -> obtenerNotaInicial($id_atencion);
		
		//---------------------------------------------------------------
		
		$this -> load -> view('hospi/hospi_svnotaCrear',$d);
		
		//---------------------------------------------------------------
	}


	/* 
* @Descripcion: Crear una nota de enfermeria partiendo de la ultima registrada
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/
	function crearNotaEdit($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['nota'] = $this->hospi_enfermeria_model->obtenerUltNota($id_atencion);
		$d['urlRegresar'] 	= site_url('hospi/notas_enfermeria/main/'.$id_atencion);
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> hospi_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> hospi_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> hospi_model -> obtenerNotaInicial($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');	
		$this -> load -> view('hospi/hospi_notaCrearEdit',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	/* 
* @Descripcion: Guarda el registro de los signos vitales.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/
	function crearNota_()
	{
		//---------------------------------------------------------------

		//---------------------------------------------------------------
		$d = array();
		$d['pulso'] = $this->input->post('frecuencia_cardiaca');
		$d['frecuencia_respiratoria']  =$this->input->post('frecuencia_respiratoria');
		$d['ten_arterial_s']  = $this->input->post('ten_arterial_s');
		$d['ten_arterial_d']  = $this->input->post('ten_arterial_d');
		$d['temperatura']  = $this->input->post('temperatura');
		$d['spo2']  = $this->input->post('spo2');
		$d['peso']  = $this->input->post('peso');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_servicio'] = $this->input->post('id_servicio');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$d['glucometria'] = $this->input->post('glucometria');
		$d['fraccion_inspirada_oxigeno'] = $this->input->post('fraccion_inspirada_oxigeno');
		$d['saturacion_oxigeno'] = $this->input->post('saturacion_oxigeno');
		$d['insulina'] = $this->input->post('insulina');
		$d['via_administracion'] = $this->input->post('via_administracion');
		$d['hora'] = $this->input->post('hora');
		$d['tencion_arterial_m'] = (($d['ten_arterial_d']*2)+$d['ten_arterial_s']) / 3;
		
		$atencion = $this -> hospi_model -> obtenerAtencion($d['id_atencion']);
		
		$fecha_turno = date('Y-m-d');
		
		$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
		//verificamos la hora para poder identificar el turno de la enfermera.
		 if ($hora > '00:00' && $hora < 07)
	     {
				 $fecha_turno = date('Y-m-d', strtotime("$hoy - 1 day"));
				 $dato['existe'] = $this -> hospi_enfermeria_model -> VerificarExistencia($d['id_atencion'],$fecha_turno,$d['hora']);
		 }
		 	else{
      		 	$dato['existe'] = $this -> hospi_enfermeria_model -> VerificarExistencia($d['id_atencion'],$fecha_turno,$d['hora']);
			   }
		//verificamos si ya hay un registro en el rango horario
		if($dato['existe']==0)
		{
			$d['id_nota'] = $this -> hospi_enfermeria_model -> crearSvNotaDb($d,$dato['existe']);	
		}
			else{
			/*verificamos si ya se han almacenado los registros de los gases arteriales para la fecha y hora indicada
		 	si ya han sido almacenados saldra una alerta y no grabara este dato */
				if($dato['existe'][0]['signos_ingresados']=='SI')
					{
				$d['id_nota'] = $this -> hospi_enfermeria_model -> crearSvNotaDbMinute($d);
					}
					 else{
						 $existe=1;
						   $d['id_nota'] = $this -> hospi_enfermeria_model -> crearSvNotaDb($d,$existe);
						 }
				
		}
		
	
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de los signos vitales se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_sv_enfermeria/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
	
		/* 
* @Descripcion: Permite consultar los signos vitales.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/
	
function consultarSv($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	 
		
		$id_serv = $d['atencion']['id_servicio'];
		$d['monitor'] = $this -> hospi_enfermeria_model -> obtenerMonitoria($id_atencion);
		$d['urlRegresar'] 	= site_url('/hospi/hospi_gestion_atencion/main/'.$id_atencion);
		
		
		$data_1 = array();
		$data_2 = array();
		$data_3 = array();
		$data_4 = array();
		$data_5 = array();	
		$data_6 = array();		
			
			if ($d['notas']!=0){
			foreach ($d['notas'] as $item){
			$data_1[] = $item['ten_arterial_s'];
			$data_2[] = $item['ten_arterial_d'];
			$data_3[] = $item['temperatura'];
			$data_4[] = $item['pulso'];
			$data_5[] = $item['fecha_nota'];
			$data_6[] = $item['spo2'];		
			}
			}
			  $this->graph->title( 'Signos Vitales', '{font-size: 20px; color: #736AFF}' );
			  
			  // we add 3 sets of data:
			  $this->graph->set_data( $data_1 );
			  $this->graph->set_data( $data_2 );
			  $this->graph->set_data( $data_3 );
			  $this->graph->set_data( $data_4 );
			  $this->graph->set_data( $data_6 );
			  
			  
			  // we add the 3 line types and key labels
			  $this->graph->line_hollow( 2, 4, '0x80a033', 'P_SISTOLICA', 10 );
			  $this->graph->line_hollow( 2, 4, '0x80a033', 'P_DISTOLICA', 10 );
			  
			  $this->graph->line_dot( 3, 5, '0xCC0000', 'TEMPERATURA', 10); 
			  $this->graph->line( 2, '0xCC3399', 'PULSO', 10); 
			  $this->graph->line_hollow( 2,5, '0x000066', 'SPO2', 10); 
				 // <-- 3px thick + dots
			  
			  $this->graph->set_x_labels($data_5 );
			  $this->graph->set_x_label_style( 10, '0x000000', 0, 2 );
			  
			  $this->graph->set_y_max( 300 );
			  $this->graph->set_y_min( 0 );
			  $this->graph->y_label_steps( 10 );
			  $this->graph->set_y_legend( 'Opus Libertati', 12, '#736AFF' );
			  $this->graph->set_output_type('js');


		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_svListadoM', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		}	
///////////////////////////////////////////////////////////////////
		/* 
* @Descripcion: Permite consultar los signos vitales para los efectos.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110312
* @version		20110312
*/
	
function consultarSvEfecto($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	 
		
		$id_serv = $d['atencion']['id_servicio'];
		
		$d['urlRegresar'] 	= site_url('/hospi/observacion/main/'.$id_atencion);
		
		
		$data_1 = array();
		$data_2 = array();
		$data_3 = array();
		$data_4 = array();
		$data_5 = array();	
		$data_6 = array();		
			
			if ($d['notas']!=0){
			foreach ($d['notas'] as $item){
			$data_1[] = $item['ten_arterial_s'];
			$data_2[] = $item['ten_arterial_d'];
			$data_3[] = $item['temperatura'];
			$data_4[] = $item['pulso'];
			$data_5[] = $item['fecha_nota'];
			$data_6[] = $item['spo2'];		
			}
			}
		  $this->graph->title( 'Signos Vitales', '{font-size: 20px; color: #736AFF}' );
		  
		  // we add 3 sets of data:
		  $this->graph->set_data( $data_1 );
		  $this->graph->set_data( $data_2 );
		  $this->graph->set_data( $data_3 );
		  $this->graph->set_data( $data_4 );
		  $this->graph->set_data( $data_6 );
		  
		  
		  // we add the 3 line types and key labels
		  $this->graph->line_hollow( 2, 4, '0x80a033', 'P_SISTOLICA', 10 );
		  $this->graph->line_hollow( 2, 4, '0x80a033', 'P_DISTOLICA', 10 );
		  
		  $this->graph->line_dot( 3, 5, '0xCC0000', 'TEMPERATURA', 10); 
		  $this->graph->line( 2, '0xCC3399', 'PULSO', 10); 
		  $this->graph->line_hollow( 2,5, '0x000066', 'SPO2', 10); 
			 // <-- 3px thick + dots
		  
		  $this->graph->set_x_labels($data_5 );
		  $this->graph->set_x_label_style( 10, '0x000000', 0, 2 );
		  
		  $this->graph->set_y_max( 300 );
		  $this->graph->set_y_min( 0 );
		  $this->graph->y_label_steps( 10 );
		  $this->graph->set_y_legend( 'Opus Libertati', 12, '#736AFF' );
		  $this->graph->set_output_type('js');


		//-----------------------------------------------------------
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('hospi/hospi_svListadoEfecto', $d);
		$this->load->view('core/efecto_fin');
		//----------------------------------------------------------
		}	
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
		/* 
* @Descripcion: Permite consultar los signos vitales para monitoria.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120715
* @version		20120715
*/
	
function consultaMonitoria($id_atencion,$fecha_turno)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		//Capturamos los datos de los signos vitales de un determinado dia.
		$d['listado'] = $this -> hospi_enfermeria_model -> obtenerMonitoriaFecha($id_atencion,$fecha_turno);
		$d['fecha_turno']=$fecha_turno;


		//-----------------------------------------------------------
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('hospi/hospi_svMonitoria', $d);
		$this->load->view('core/efecto_fin');
		//----------------------------------------------------------
		}	
///////////////////////////////////////////////////////////////////

	/* 
* @Descripcion:  Crear un registro de los gases arteriales.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120715
* @version		20120715
*/	
	function crearNotaGases($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
	
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		//$d['consulta'] = $this -> hospi_model -> obtenerConsulta($id_atencion);
		
		//---------------------------------------------------------------
		
		$this -> load -> view('hospi/hospi_svgases',$d);
		
		//---------------------------------------------------------------
	}
	
	
	///////////////////////////////////////////////////////////////////
	/* 
* @Descripcion: Guarda el registro de los gases arteriales.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111115
* @version		20111115
*/
	function crearNotaGases_()
	{
		//---------------------------------------------------------------
		$d = array();
		$d['ph'] = $this->input->post('ph');
		$d['paco2']  =$this->input->post('paco2');
		$d['pao2']  = $this->input->post('pao2');
		$d['hco3']  = $this->input->post('hco3');
		$d['sao2']  = $this->input->post('sao2');
		$d['svo2']  = $this->input->post('svo2');
		$d['lactato']  = $this->input->post('lactato');
		$d['fraccion_inspirada_oxigeno'] = $this->input->post('fraccion_inspirada_oxigeno');
		$d['hora'] = $this->input->post('hora');
		$d['pao2_fio2']  = $d['paco2'] / $d['fraccion_inspirada_oxigeno'];
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_servicio'] = $this->input->post('id_servicio');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$fecha_turno = date('Y-m-d');
		
		$hoy= date("Y-m-d");
	    $hora =date('H:i:s');
		//verificamos la hora para poder identificar el turno de la enfermera.
		 if ($hora > '00:00' && $hora < 07)
	     {
				 $fecha_turno = date('Y-m-d', strtotime("$hoy - 1 day"));
				 $dato['existe'] = $this -> hospi_enfermeria_model -> VerificarExistencia($d['id_atencion'],$fecha_turno,$d['hora']);
		 }
		 	else{
      		 	$dato['existe'] = $this -> hospi_enfermeria_model -> VerificarExistencia($d['id_atencion'],$fecha_turno,$d['hora']);
			   }
		//verificamos si ya hay un registro en el rango horario
		if($dato['existe']==0)
		{
			$d['id_nota'] = $this -> hospi_enfermeria_model -> crearSvNotaGasesDb($d,$dato['existe']);	
		}
			else{
			/*verificamos si ya se han almacenado los registros de los gases arteriales para la fecha y hora indicada
		 	si ya han sido almacenados saldra una alerta y no grabara este dato */
				if($dato['existe'][0]['gases_ingresados']=='SI')
					{
						//----------------------------------------------------
					$dt['mensaje']  = "Los gases arteriales para las".$d['hora']." horas ya han sido grabados anteriromente !!";
					$dt['urlRegresar'] 	= site_url("hospi/hospi_sv_enfermeria/main/".$d['id_atencion']);
					$this -> load -> view('core/presentacionMensaje', $dt);
					return;	
					//----------------------------------------------------------
					}
					 else{
						 $existe=1;
						   $d['id_nota'] = $this -> hospi_enfermeria_model -> crearSvNotaGasesDb($d,$existe);
						 }
				
		}
			

	
		
	
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de los gases arteriales se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_sv_enfermeria/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
	



function presion_arterial($id_atencion)
	{

	// generate some random data:


  $this->load->library("graph");

$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
	
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	
	
		
		

		
	$data_1 = array();
		$data_2 = array();
		$data_3 = array();
		$data_4 = array();
		$data_5 = array();	
		$data_6 = array();		
			
			if ($d['notas']!=0){
			foreach ($d['notas'] as $item){
				if($item['ten_arterial_s']!=0){
			$data_1[] = $item['ten_arterial_s'];
			$data_2[] = $item['ten_arterial_d'];
			$data_3[] = number_format((($item['ten_arterial_d']*2)+$item['ten_arterial_s'])/3,1);
			$data_5[] = $item['fecha_nota'];
				}
			}
			}
$this->graph->title( 'Presion Arterial', '{font-size: 15px; color:0x000000}' );

// we add 3 sets of data:
$this->graph->set_data( $data_1 );
$this->graph->set_data( $data_2 );
$this->graph->set_data( $data_3 );




// we add the 3 line types and key labels
$this->graph->line_hollow( 2, 4, '0x80a033', 'P_SISTOLICA', 10 );
$this->graph->line_hollow( 2, 4, '0x80a033', 'P_DISTOLICA', 10 );

$this->graph->line_dot( 3, 5, '0x0033CC', 'P_MEDIA', 10); 

   // <-- 3px thick + dots

$this->graph->set_x_labels($data_5 );
$this->graph->set_x_label_style( 10, '0xFFFFCC', 0, 2 );

$this->graph->set_y_max( 300 );
$this->graph->set_y_min( 0 );
$this->graph->y_label_steps( 30 );
$this->graph->set_y_legend( 'Opus Libertati', 12, '#736AFF' );
echo $this->graph->render();
//$this->graph->set_output_type('js');


		}
		
		
		
function temperatura($id_atencion)
	{

	// generate some random data:

srand((double)microtime()*1000000);


  $this->load->library("graph");

$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
	
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	
	
		
		

		
		$data_3 = array();
		$data_5 = array();

		
			
			if ($d['notas']!=0){
			foreach ($d['notas'] as $item){
				if($item['temperatura']!=0){
			$data_3[] = $item['temperatura'];
			$data_5[] = $item['fecha_nota'];
				}
			
			}
			}
$this->graph->title( 'Temperatura', '{font-size: 15px; color: 0x000000}' );

// we add 3 sets of data:

$this->graph->set_data( $data_3 );



// we add the 3 line types and key labels

$this->graph->line_dot( 3, 5, '0xCC0000', 'TEMPERATURA', 10); 

   // <-- 3px thick + dots
$this->graph->set_x_labels($data_5 );
$this->graph->set_x_label_style( 10, '0xFFFFCC', 0, 2 );


$this->graph->set_y_max( 43 );
$this->graph->set_y_min( 30 );
$this->graph->y_label_steps( 13);
$this->graph->set_y_legend( 'Opus Libertati', 12, '#736AFF' );
echo $this->graph->render();
//$this->graph->set_output_type('js');




	}
///////////////////////////////////////////////////////////////////
function frecuencia_cardiaca($id_atencion)
	{

	// generate some random data:

srand((double)microtime()*1000000);


  $this->load->library("graph");

$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
	
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	
	
		
		

		
		$data_3 = array();
		$data_5 = array();
		
			
			if ($d['notas']!=0){
			foreach ($d['notas'] as $item){
				if($item['pulso']!=0){
			$data_3[] = $item['pulso'];
			$data_5[] = $item['fecha_nota'];
				}
			
			
			}
			}
$this->graph->title( 'Frecuencia Cardiaca', '{font-size: 15px; color: 0x000000}' );

// we add 3 sets of data:

$this->graph->set_data( $data_3 );



// we add the 3 line types and key labels

$this->graph->line_dot( 3, 5, '0x663300', 'Frecuencia cardiaca', 10); 

   // <-- 3px thick + dots

$this->graph->set_x_labels($data_5 );
$this->graph->set_x_label_style( 10, '0xFFFFCC', 0, 2 );

$this->graph->set_y_max(300);
$this->graph->set_y_min(0);
$this->graph->y_label_steps( 30);
$this->graph->set_y_legend( 'Opus Libertati', 12, '#736AFF' );
echo $this->graph->render();
//$this->graph->set_output_type('js');
	}

////////////////////////////////////
function frecuencia_respiratoria($id_atencion)
	{

	// generate some random data:

srand((double)microtime()*1000000);


  $this->load->library("graph");

$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
	
	
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	
	
		
		

		
		$data_3 = array();
		$data_5 = array();
		
			
			if ($d['notas']!=0){
			foreach ($d['notas'] as $item){
				if($item['frecuencia_respiratoria']!=0)
				{
				
			$data_3[] = $item['frecuencia_respiratoria'];
			$data_5[] = $item['fecha_nota'];
				}
			}
			}
$this->graph->title( 'Frecuencia Respiratoria', '{font-size: 15px; color:0x000000}' );

// we add 3 sets of data:

$this->graph->set_data( $data_3 );



// we add the 3 line types and key labels

$this->graph->line_dot( 3, 5, '0xCC6600', 'Frecuencia respiratoria', 10); 

   // <-- 3px thick + dots

$this->graph->set_x_labels($data_5 );
$this->graph->set_x_label_style( 10, '0xFFFFCC', 0, 2 );

$this->graph->set_y_max(100);
$this->graph->set_y_min(0);
$this->graph->y_label_steps( 10);
$this->graph->set_y_legend( 'Opus Libertati', 12, '#736AFF' );
echo $this->graph->render();
//$this->graph->set_output_type('js');


	}



}
?>
