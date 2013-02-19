<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: bl_enfermeria
 *Tipo: controlador
 *Descripcion: Gestiona el balance de liquidos de observacion enfermeria
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 15 de noviembre de 2011
*/

class Hospi_bl_enfermeria extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
			$this -> load -> model('hospi/hospi_model');
		$this -> load -> model('hospi/hospi_enfermeria_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
		$this -> load -> helper('html');	
				
	}
///////////////////////////////////////////////////////////////////

/* 
* @Descripcion: genera la lista de balance de liquidos con su respectiva grafica
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
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
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerBlNotasEli($id_atencion);
		if ($d['notas'] == 0)
		{
		  $d['notas'] = $this -> hospi_enfermeria_model -> obtenerBlNotasAdm($id_atencion);
		}

		$d['urlRegresar'] 	= site_url('/hospi/hospi_enfermeria/main/'.$id_atencion);
	
		
	///////////capturamos los valores de los liquidos eliminados/////////////////////
		
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
			$d['valorelimi'] = $this -> hospi_enfermeria_model -> obtenerBlEliminados($id_atencion,$d['atencion']['id_servicio']);
			
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
		
		////////////////////capturamos los valores de los liquidos administrados/////////////////////
			
			$d['valoradmi'] = $this -> hospi_enfermeria_model -> obtenerBlAdministrados($id_atencion,$d['atencion']['id_servicio']);
			
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
$this->graph->set_y_min( -3000);
$this->graph->set_y_max( 3000);
$this->graph->y_label_steps( 10 );
$this->graph->set_y_legend( 'mililitros (mL)', 12, '#736AFF' );
$this->graph->set_output_type('js');
			
		

		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_blListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		
		}
///////////////////////////////////////////////////////////////////
/* 
* @Descripcion: Consultar la nota registrada en los balances de liquidos
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/
	function consultaNota($id_nota)
	{
		$d = array();
		$d['nota'] = $this->hospi_enfermeria_model->obtenerNota($id_nota);
		echo $this->load->view('hospi/hospi_notaConsulta',$d);
	}

/* 
* @Descripcion: Consultar los balances registrados por horarios definidos.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/
	function consultaBalance($id_atencion,$fecha_nota)
	{
		
		$d = array();
		$d['id_atencion']=$id_atencion;
		$d['fecha_nota']=$fecha_nota;
		$d['BL_Adm7_12'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha7_12($id_atencion,$fecha_nota);
		$d['BL_Adm13_18'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha13_18($id_atencion,$fecha_nota);
		$d['BL_Adm19_6'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha19_6($id_atencion,$fecha_nota);
		$d['BL_Adm24'] = $this->hospi_enfermeria_model->obtenerBlAdmFecha24($id_atencion,$fecha_nota);
		// eliminados
		$d['BL_Eli7_12'] = $this->hospi_enfermeria_model->obtenerBlEliFecha7_12($id_atencion,$fecha_nota);
		$d['BL_Eli13_18'] = $this->hospi_enfermeria_model->obtenerBlEliFecha13_18($id_atencion,$fecha_nota);
		$d['BL_Eli19_6'] = $this->hospi_enfermeria_model->obtenerBlEliFecha19_6($id_atencion,$fecha_nota);
		$d['BL_Eli24'] = $this->hospi_enfermeria_model->obtenerBlEliFecha24($id_atencion,$fecha_nota);
		
	
		// se trae el total de los liquidos administrados de 7 a 12
		if ($d['BL_Adm7_12']!=0)
		{
			foreach ($d['BL_Adm7_12'] as $item)
			{
			    $administrado7_12[] = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}
		//// se trae el total de los liquidos administrados de 13 a 18
		if ($d['BL_Adm13_18']!=0)
		{
			foreach ($d['BL_Adm13_18'] as $item)
			{
			    $administrado13_18[] = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}
		//// se trae el total de los liquidos administrados de 19 a 6
		if ($d['BL_Adm19_6']!=0)
		{
			foreach ($d['BL_Adm19_6'] as $item)
			{
			    $administrado19_6[] = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}
		
		// DATOS ELIMINADOS//
			// se trae el total de los liquidos eliminados de 7 a 12
		if ($d['BL_Eli7_12']!=0)
		{
			foreach ($d['BL_Eli7_12'] as $item)
			{
			    $eliminado7_12[] =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			   
			}
			
		}
		//// se trae el total de los liquidos eliminados de 13 a 18
		if ($d['BL_Eli13_18']!=0)
		{
			foreach ($d['BL_Eli13_18'] as $item)
			{
			   $eliminado13_18[] =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			  
			}
			
		}
		//// se trae el total de los liquidos eliminados de 19 a 6
		if ($d['BL_Eli19_6']!=0)
		{
			foreach ($d['BL_Eli19_6'] as $item)
			{
			    $eliminado19_6[] =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			    
			}
			
		}
		
		
		echo $this->load->view('hospi/hospi_BLnotaConsulta',$d);
	}
///////////////////////////////////////////////////////////////////
/* 
* @Descripcion: crea un registro de un balance de liquido administrado
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/
	function crearNotaAdm($id_atencion)
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
		
		$this -> load -> view('hospi/hospi_blnotaCrear',$d);
		
		//---------------------------------------------------------------
	}
	
	/* 
* @Descripcion: crea un registro de un balance de liquido Eliminado
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/
	
		function crearNotaEli($id_atencion)
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
		
		$this -> load -> view('hospi/hospi_blnotaCrearEliminados',$d);
		
		//---------------------------------------------------------------
	}
	/* 
* @Descripcion: edit una nota realizada
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
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
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> hospi_model -> obtenerNotaInicial($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');	
		$this -> load -> view('hospi/hospi_notaCrearEdit',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	/* 
* @Descripcion: Guarda el registro del balance de liquidos administrados
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/
	function crearNotaBlAdm_()
	{
		//---------------------------------------------------------------
		$d = array();
		$d['l_administrado'] = $this->input->post('l_administrado');
		$d['via_oral']  =$this->input->post('via_oral');
		$d['sng']  = $this->input->post('sng');
		$d['liv']  = $this->input->post('liv');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_servicio'] = $this->input->post('id_servicio');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$atencion = $this -> hospi_model -> obtenerAtencion($d['id_atencion']);
		
		//----------------------------------------------------------
		$d['id_nota'] = $this -> hospi_enfermeria_model -> crearBl_admi($d);
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de balance de liquidos  se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_bl_enfermeria/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	/* 
* @Descripcion: Guarda el registro del balance de liquidos eliminados
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/

function crearNotaBlElimi_()
	{
		//---------------------------------------------------------------
		$d = array();
		$d['orina'] = $this->input->post('orina');
		$d['deposicion']  =$this->input->post('deposicion');
		$d['sng']  = $this->input->post('sng');
		$d['vomito']  = $this->input->post('vomito');
		$d['drend']  = $this->input->post('drend');
		$d['drene']  = $this->input->post('drene');
		$d['storaxe']  = $this->input->post('storaxe');
		$d['storaxd']  = $this->input->post('storaxd');
		$d['otros']  = $this->input->post('otros');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_servicio'] = $this->input->post('id_servicio');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$atencion = $this -> hospi_model -> obtenerAtencion($d['id_atencion']);
		
		//----------------------------------------------------------
		$d['id_nota'] = $this -> hospi_enfermeria_model -> crearBl_elimi($d);
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de balance de liquidos  se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_bl_enfermeria/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////

	/* 
* @Descripcion: Consultar el balance de liquidos
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/

function consultaBl($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
	
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerBlNotasEli($id_atencion);
		if ($d['notas'] == 0)
		{
		  $d['notas'] = $this -> hospi_enfermeria_model -> obtenerBlNotasAdm($id_atencion);
		}	
	 
		
		$id_serv = $d['atencion']['id_servicio'];
		
		
		$d['urlRegresar'] 	= site_url('/hospi/hospi_gestion_atencion/main/'.$id_atencion);
		
		
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
			$d['valorelimi'] = $this -> hospi_enfermeria_model -> obtenerBlEliminados($id_atencion,$d['atencion']['id_servicio']);
			
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
			
			$d['valoradmi'] = $this -> hospi_enfermeria_model -> obtenerBlAdministrados($id_atencion,$d['atencion']['id_servicio']);
			
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
$this->graph->set_y_min( -3000);
$this->graph->set_y_max( 3000);
$this->graph->y_label_steps( 10 );
$this->graph->set_y_legend( 'mililitros (mL)', 12, '#736AFF' );
$this->graph->set_output_type('js');
			
		

		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_blListadoM', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
		
		}

///////////////////////////////////////////////////////////////////

	/* 
* @Descripcion: Consultar el balance de liquidos para efecto
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111207
* @version		20111207
*/

function consultaBlEfecto($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
	
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerBlNotasEli($id_atencion);
		if ($d['notas'] == 0)
		{
		  $d['notas'] = $this -> hospi_enfermeria_model -> obtenerBlNotasAdm($id_atencion);
		}	
	 
		
		$id_serv = $d['atencion']['id_servicio'];
		
		
		$d['urlRegresar'] 	= site_url('/hospi/observacion/main/'.$id_atencion);
		
		
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
			$d['valorelimi'] = $this -> hospi_enfermeria_model -> obtenerBlEliminados($id_atencion,$d['atencion']['id_servicio']);
			
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
			
			$d['valoradmi'] = $this -> hospi_enfermeria_model -> obtenerBlAdministrados($id_atencion,$d['atencion']['id_servicio']);
			
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
$this->graph->set_y_min( -3000);
$this->graph->set_y_max( 3000);
$this->graph->y_label_steps( 10 );
$this->graph->set_y_legend( 'mililitros (mL)', 12, '#736AFF' );
$this->graph->set_output_type('js');
			
		

		//-----------------------------------------------------------
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('hospi/hospi_blListadoEfecto', $d);
		$this->load->view('core/efecto_fin');
		//----------------------------------------------------------
		
		}




}
?>
