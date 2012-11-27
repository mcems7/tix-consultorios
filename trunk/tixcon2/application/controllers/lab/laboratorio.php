<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: LABORATORIO
 *Tipo: controlador
 *Descripcion: Permite gestionar las ordenes que llegan al laboratorio
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de octubre de 2011
*/
class Laboratorio extends CI_Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::__construct();     
    $this -> load -> model('lab/laboratorio_model'); 
     $this -> load -> model('urg/urgencias_model'); 
    $this -> load -> model('core/paciente_model');
	$this->load->helper(array('form', 'url'));
  }
  
///////////////////////////////////////////////////////////////////
   function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('lab/lab_ordenes', $d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
         	/* 
* @Descripcion: Muestra las ordenes que llegan al laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
    function listadoOrdenesLab($sala)
  {
    
    //----------------------------------------------------------
	$d = array();
    if ($sala==1){
		$accion="todas";
		}
	if ($sala==2){
		$accion="recepcionar";
		}
	if ($sala==3){
		$accion="tomar";
		}
	if ($sala==4){
		$accion="registrar";
		}	
		
	$d['lista'] = $this -> laboratorio_model -> OrdenesLab($accion);
	 
    $this -> load -> view('lab/lab_OrdenesListado',$d);
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
          	/* 
* @Descripcion: Se recepcionan las ordenes que llegan al laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
  
  function recepcionarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
	$d['laboratorio']=$this->laboratorio_model->obtenerLabOrden($id_orden);
  
	$ordenLab = $d['laboratorio'][0]['id_lab_orden']; 
	$id_atencion = $d['laboratorio'][0]['id_atencion'];

    $d['urlRegresar']   = site_url('lab/laboratorio/index');

	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
   
	$d['rechazo']= $this->laboratorio_model -> lista_lab_rechazo();
	
	
    $d['diagnostico'] = $this->laboratorio_model->obtenerDxFarmacia($id_atencion);
	$d['usuario']=$this -> session -> userdata('id_usuario');
	
  
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('lab/lab_ordRecepcion', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
       	/* 
* @Descripcion: Se registra la recepcion de la orden se aprueba o se rechaza
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
///////////////////////////////////////////////////////////////////
  
  function registraRecepcionLab_()
  {
  //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
  
     $d['urlRegresar']   = site_url('lab/laboratorio/index');
  $d['id_orden'] = $this->input->post('id_orden');
  $d['cups'] = $this->input->post('cups');
  $d['codigo_rechazo']=$this->input->post('codigo_rechazo');
  $d['razon']=$this->input->post('razon');
  $d['rechazo']=$this->input->post('rechazo');
  
  if($d['rechazo']=='SI'){
	   $d['estado']='RECHAZADA';
	  
	  $this->laboratorio_model->registra_lab_orden($d);
	  
	  }
   if($d['rechazo']=='NO'){
	   $d['estado']='APROBADA';
	  
	  $this->laboratorio_model->registra_lab_orden($d);
		  
	  }
	   $this->load->view('core/core_inicio');
        $this -> load -> view('lab/lab_ordenes', $d);
    $this->load->view('core/core_fin'); 
	 
	 
  
  }
/////////////////////////////////////////////////////////////////////////

       	/* 
* @Descripcion: muestra la orden para ser registrada
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
////////////////////////////////////////////////////////////////////////
function registrarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
	$d['laboratorio']=$this->laboratorio_model->obtenerLabOrden($id_orden);
	//print_r ($d['laboratorio']);
	$cup = $d['laboratorio'][0]['cups'];
    // capturamos el clinico que corresponde a el cup
	$d['id_clinico_cup']=$this->laboratorio_model->obtenerIdClinico($cup); 
	
	if ($d['id_clinico_cup']!= null){
	
			$id_clinico_cup = $d['id_clinico_cup'][0]['id'];
	//capturamos los clinicos correspondientes a; contenedor
	$d['id_clinicos']=$this->laboratorio_model->obtenerClinicos($id_clinico_cup);
	//print_r ($d['id_clinicos']);
		}

	
	
	
	
  
	$ordenLab = $d['laboratorio'][0]['id_lab_orden']; 
	$id_atencion = $d['laboratorio'][0]['id_atencion'];

    $d['urlRegresar']   = site_url('lab/laboratorio/index');

	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
   
	$d['rechazo']= $this->laboratorio_model -> lista_lab_rechazo();
	
	
    $d['diagnostico'] = $this->laboratorio_model->obtenerDxFarmacia($id_atencion);
	$d['usuario']=$this -> session -> userdata('id_usuario');
	
  
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('lab/lab_ordRegistro', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////

       	/* 
* @Descripcion: Graba el registro de la orden
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
function registraOrdenLab_(){
	 $dt = array();
	 $config = array();
	 $d = array();
    //---------------------------------------------------------------
  
  $d['urlRegresar']   = site_url('lab/laboratorio/index');
  $d['id_orden'] = $this->input->post('id_orden');
  $d['numero'] = $this->input->post('numero');
  $d['texto'] = $this->input->post('texto');
  $d['lista'] = $this->input->post('lista');
  $cant_registro= $this->laboratorio_model->Cantidad_registro_numero($d['id_orden']);
  $d['cantidad']=$this->laboratorio_model->Cantidad_registro_tomar($d['id_orden']);
 
  $d['registro_numero']= $cant_registro[0]['registro_numero'] + 1;
  
  //Configuración de la libreria upload
		$config['upload_path'] = "./uploads/laboratorio/";
		$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf|jpg|bmp|gif';
		$config['max_size']	= '600000';
		$this -> load -> library('upload');
		$this -> upload -> initialize($config);
		//----------------------------------------------------------
		if (!$this->upload->do_upload() )
		{	
		
			//----------------------------------------------------------
			$dt['mensaje']  = $this -> upload -> display_errors();
			$this -> load -> view('core/presentacionMensaje', $dt);
			$d['ruta']='no se anexa imagen ';
			
			$this->laboratorio_model->registra_informe_lab($d);
			redirect('/lab/laboratorio/index', 'refresh');
			
			//----------------------------------------------------------
		}	
		else
		{	
			$res = $this->upload->data();
			$d['archivo'] = $res['file_name'];
			$d['ext'] = $res['file_ext'];
			$d['ruta']=$res['file_name'];
			
			
			$this->laboratorio_model->registra_informe_lab($d);
		//----------------------------------------------------------
			
			
			$dt['mensaje']  = "El archivo fue cargado exitosamente!!";
			
			
			$this -> load -> view('core/presentacionMensaje', $dt);
		 
		 
        //redirect('/lab/laboratorio/index', 'refresh');
		}
 
 
	}


////////////////////////////////////////////////////
//////////////////////////////////////////////////
}





?>