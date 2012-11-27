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
class Main extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('urg/enfermeria_model');
		$this -> load -> model('hce/hce_model');
		$this -> load -> model('core/medico_model');
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
* @copyright	GNU GPL 3.0
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
		$this -> load -> view('hce/inicio',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	
	function buscar_atenciones($id_paciente)
	{	
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/index');
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);	
		$d['atencionesUrg'] = $this ->hce_model -> obtenerAtencionesUrg($id_paciente);
		$d['atencionesHospi'] = $this ->hce_model -> obtenerAtencionesHospi($id_paciente);
		$this->load->view('core/core_inicio');
		echo $this->load->view('hce/hce_listadoAtenciones',$d);
		$this->load->view('core/core_fin');	
	}
	
	function buscar_atenciones_paciente()
	{
	//----------------------------------------------------------
		$d = array();
		
		$d['atencionesUrg'] = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/home/index');	
		//----------------------------------------------------------
		$d['primer_apellido'] 	= $this->input->post('primer_apellido');
		$d['primer_nombre'] 	= $this->input->post('primer_nombre');
		$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
		$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
		$d['numero_documento'] 	= $this->input->post('numero_documento');	
		
		$d['pacientes'] = $this ->hce_model->verificarPaciente($d);
		
		echo $this->load->view('hce/hce_listadoPacientes',$d);
	}
///////////////////////////////////////////////////////////////////
	function consultaTriage($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
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
	function consultaTriageBlanco($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/index');
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_gesConTriageBlanco',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function consultaAtencion($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
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
	function consultarAtencion($id_atencion)
	{
		
		
		$this -> load -> model('auto/autorizaciones_model');
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/index');
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		
		$d['dxCon'] = array();
		$d['dxEvo'] = array();
		$d['obs'] = 0;
		$d['rem'] = 0;
		
		if($d['atencion']['id_estado'] != 2 && $d['atencion']['id_estado'] != 3 ){
		
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['obs'] = $this ->hce_model -> obtenerObservacion($id_atencion);
		
		$d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dxEvo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		}
		$d['rem'] = $this ->hce_model -> obtenerRemision($id_atencion);
		//Listado de anexos 2 de la atención
		$d['anexo2'] = $this ->hce_model -> obtenerAnexo2Atencion($id_atencion);
		
		//Listado de anexos 3 de la atención
		$d['anexo3'] = $this ->hce_model -> obtenerAnexo3Atencion($id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hce/gestionAtencion', $d);
    	$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de evoluciones y consulta de las anteriores
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110512
* @version		20110512
*/
	function consultaEvoluciones($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		
		$d['evo'] = $this -> urgencias_model -> obtenerEvoluciones($id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hce/evolucionesListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/*
* Vista con el formato de ingreso de la orden de insumos médicos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110512
* @version		20110512
*/	
	function consultarOrdenes($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ordenes'] = $this -> urgencias_model -> obtenerOrdenes($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hce/ordenesListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('hce/main/consultarAtencion/'.$id_atencion);
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
    $this->load->view('core/core_inicio');
    $this -> load -> view('urg/urg_ordConsultar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
	function consultaEpicrisis($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar']   = site_url('hce/main/consultarAtencion/'.$id_atencion);
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
		
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($d['epicrisis']['id_usuario']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['mediAtencion'] = $this -> urgencias_model ->obtenerMediAtencion($id_atencion);
		$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['destino'] = $this -> urgencias_model -> obtenerDestinos();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hce/consultaEpicrisis',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/*
* Consultar una evolución indicada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100920
* @version		20100920
*/	
	function consultaEvolucion($id_evolucion)
	{
		$d = array();
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($id_evolucion);
		$d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($id_evolucion);
		echo $this->load->view('urg/urg_evoConsulta',$d);
	}

///////////////////////////////////////////////////////////////////

/*
* Consultar una Balance de liquidos
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright

*/	

function consultaBl($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> enfermeria_model -> obtenerBlNotas($id_atencion,$d['atencion']['id_servicio']);
		//print_r($d['notas']);	
	 
		
		$id_serv = $d['atencion']['id_servicio'];
		
		
		$d['urlRegresar'] 	= site_url('/hce/main/consultarAtencion/'.$id_atencion);
		
		
		////////////////////capturamos los valores de los liquidos eliminados/////////////////////
		
		$bar_1 = array();
		$bar_2 = array();
		$bar_3 = array();	
			$tamano = array();
			$tamanoadmi = 0;
			$tamanoelimi =0;
			$eliminadodia = array();
			$administradodia = array();
			$balance =array();
			$fechas = array();
			$d['valorelimi'] = $this -> enfermeria_model -> obtenerBlEliminados($id_atencion,$d['atencion']['id_servicio']);
			
		if ($d['valorelimi']!=0)
		{
			foreach ($d['valorelimi'] as $item)
			{
			   $eliminadodia[] =  -$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			    $fechas[] = $item['fecha_nota'];
			}
			$tamanoelimi = sizeof($eliminadodia);
		}
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		////////////////////capturamos los valores de los liquidos eliminados/////////////////////
			
			$d['valoradmi'] = $this -> enfermeria_model -> obtenerBlAdministrados($id_atencion,$d['atencion']['id_servicio']);
			
		if ($d['valoradmi']!=0)
		{
			foreach ($d['valoradmi'] as $item)
			{
			   $administradodia[] = $item['liv']+$item['sng']+$item['via_oral'];
			  
			}
			$tamanoadmi = sizeof($administradodia);
		}
		
		
		
		
		if($tamanoadmi == $tamanoelimi){
				$tamano= $tamanoelimi;			
			}else if($tamanoadmi > $tamanoelimi){
				$tamano= $tamanoelimi;
				}else if($tamanoadmi < $tamanoelimi){
					$tamano= $tamanoadmi;
					}
			/////////////////////////////////////////////////////////////////////////////////////////////
			
		
			
			
			for($i=0; $i<$tamano; $i++){
		$balance[]=	$administradodia[$i] + $eliminadodia[$i];
			}
		//print_r($balance);
  
			// generate some random data
srand((double)microtime()*1000000);


$bar_1 = new bar_glass( 55, '#5E83BF', '#424581' ); 

$bar_1->key( 'Administrados', 10 );

// add 10 bars with random heights
$maxadmi=0;
if ($administradodia !=0){
foreach ($administradodia as $item)
{  
  $bar_1->data[] =$item;
   if($maxadmi<$item)
	  {
		 $maxadmi=$item;
	   }
  
  }
}

//
// create a 2nd set of bars:
//
$bar_2 = new bar_glass( 55, '#D54C78', '#C31812' );
$bar_2->key( 'Eliminados', 10 );
$maxelimi=0;
// make 10 bars of random heights
if ($eliminadodia !=0){

	foreach ($eliminadodia as $item)
	{  
	  $bar_2->data[] =$item;
	  if($maxelimi>$item)
	  {
		 $maxelimi=$item;
	   }
	}
}


$bar_3 = new bar_glass( 55, '#83bf5d', '#448141' ); 

$bar_3->key( 'Balance', 10 );

// add 10 bars with random heights\
if ($balance !=0){

foreach ($balance as $item)
{  
  $bar_3->data[] =$item;
	}

}

$this->graph->title( 'Balance de líquidos', '{font-size:20px; color: #5e6b7f; margin:10px; padding: 5px 15px 5px 15px;}' );

// add both sets of bars:
$this->graph->data_sets[] = $bar_1;
$this->graph->data_sets[] = $bar_2;
$this->graph->data_sets[] = $bar_3;
// label the X axis (10 labels for 10 bars):
$this->graph->set_x_labels( $fechas );

// colour the chart to make it pretty:
$this->graph->x_axis_colour( '#909090', '#D2D2FB' );
$this->graph->y_axis_colour( '#909090', '#D2D2FB' );

//$this->graph->set_y_min( $maxelimi);
//$this->graph->set_y_max( $maxadmi);
$this->graph->set_y_min( -2000);
$this->graph->set_y_max( 2000);
$this->graph->y_label_steps( 10 );
$this->graph->set_y_legend( 'mililitros (mL)', 12, '#736AFF' );
$this->graph->set_output_type('js');
			
		

		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_blListadoM', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		
		}

////////////////////////////////////////////////////////////////////
/*
* Consultar una Balance de liquidos
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright

*/	
function consultarSv($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> enfermeria_model -> obtenerSvNotas($id_atencion,$d['atencion']['id_servicio']);	
	 
		
		$id_serv = $d['atencion']['id_servicio'];
		
		$d['urlRegresar'] 	= site_url('/hce/main/consultarAtencion/'.$id_atencion);
		
		
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
		$this -> load -> view('urg/urg_svListadoM', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		}	
////////////////////////////////////////////////////////////////////
/*
* Gestión de las notas de enfermería
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright

*/	
	function consultarNota($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> enfermeria_model -> obtenerNotas($id_atencion,$d['atencion']['id_servicio']);
		$id_serv = $d['atencion']['id_servicio'];
	
		$d['urlRegresar'] 	= site_url('/hce/main/consultarAtencion/'.$id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hce/hce_notasEnfermeria', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	function consultaNota($id_nota)
	{
		$d = array();
		$d['nota'] = $this->enfermeria_model->obtenerNota($id_nota);
		echo $this->load->view('urg/urg_notaConsulta',$d);
	}


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
		$d['urlRegresar'] 	= site_url('/hce/main/consultarAtencion/'.$id_atencion);
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

function consultaAtencionEfecto($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
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
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('urg/urg_gesConAtencionEfecto',$d);
		$this->load->view('core/efecto_fin');
		//----------------------------------------------------------
	}

///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de evoluciones y consulta de las anteriores para visualizar con efecto
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
*/
	function consultaEvolucionesEfecto($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		
		$d['evo'] = $this -> urgencias_model -> obtenerEvoluciones($id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('hce/evolucionesListadoEfecto', $d);
		$this->load->view('core/efecto_fin');
		//----------------------------------------------------------
	}
}
?>
