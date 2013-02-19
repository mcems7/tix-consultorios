<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: lab_lista_enfermeria
 *Tipo: controlador
 *Descripcion: Permite gestionar las ordenes de enfermeria
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de octubre de 2011
*/
class Lab_lista_enfermeria extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
    $this -> load -> model('lab/laboratorio_model'); 
     $this -> load -> model('urg/urgencias_model'); 
    $this -> load -> model('core/paciente_model');
  }
  
///////////////////////////////////////////////////////////////////
   function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
	//$this->load->library('Nodo');
	//$datos['listado'] = $this -> laboratorio_model -> TomarNodo();
	
	
	
	//$d['json']= Nodo::llenarTreeView($datos['listado']);

	
	 //echo $prueba->get_json_format();
	 
	 
	
	 //////////////////////////////////////////
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('lab/lab_ordenes_enfermeria', $d);

	
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
         	/* 
* @Descripcion: Muestra las ordenes rechazadas del laboratorio 
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
    function listadoOrdenesLabRechazada($id_servicio)
  {
    
    //----------------------------------------------------------
	$d = array();
	$accion="rechazada";
	
	$d['lista'] = $this -> laboratorio_model -> obtenerLabOrdenRechazada($accion,$id_servicio);
	
	
		 
    $this -> load -> view('lab/lab_OrdenesListadoRechazo',$d);
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////
   
          	/* 
* @Descripcion: Muestra el listado de las ordenes de enfermeria
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
       function listadoOrdenesLabEnfermeria($id_servicio)
  {
    
    //----------------------------------------------------------
	$datos = array();
	
	$fecha_actual = date('Y-m-d H:i:s');
	$accion="tomar";
	$datos['listado'] = $this -> laboratorio_model -> TomarLabOrdenEnf($accion,$id_servicio,$fecha_actual);
	
	
	 
	 
    $this -> load -> view('lab/lab_OrdenesListadoTomar',$datos);
	
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   
   
      function listadoOrdenesRegUrg($id_servicio)
  {
    
    //----------------------------------------------------------
	$d = array();
	
	$accion="registrar";	
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabRegUrg($accion,$id_servicio);
	 
    $this -> load -> view('lab/lab_OrdenesListadoRegUrg',$d);
    //----------------------------------------------------------
  }
         	/* 
* @Descripcion: recepcion de ordenes de laboratorio
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

    $d['urlRegresar']   = site_url('lab/main/index');

	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
   
	$d['rechazo']= $this->laboratorio_model -> lista_lab_rechazo();
	$d['usuario']=$this -> session -> userdata('id_usuario');
	
  
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('lab/lab_ordRecepcion', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
       	/* 
* @Descripcion: Registra la recepcion de la orden 
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
	 
	    
	  /*
  $this->laboratorio_model->registraRealizaLab($d);
  
  //----------------------------------------------------------
  $this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'lab',__CLASS__,__FUNCTION__
      ,'aplicacion',"Se le han agregado insumos a la orden id ".$d['id_orden']);
  //----------------------------------------------------------
  $dt['mensaje']  = "Los datos se han almacenado correctamente!!";
  $dt['urlRegresar']  = site_url("lab/main/index");
  $this -> load -> view('core/presentacionMensaje', $dt);
  return; */
  //----------------------------------------------------------
  
  }


  /////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////
          	/* 
* @Descripcion: Grabar un clinico de tipo lista
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
   
       function rechazoOrden($id_ordenes)
  {
    
    //----------------------------------------------------------
	$d = array();

	
		
	$d['listado'] = $this -> laboratorio_model -> RegistraRechazoOrd($id_ordenes);
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
          	/* 
* @Descripcion: muestra enviada al laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
   /////////////////////////////////////////////////////////////////
   
   
       function MuestraEnviadaLab($id_ordenes)
  {
    
    //----------------------------------------------------------
	$d = array();
		
	$d['listado'] = $this -> laboratorio_model -> RegistraEnvioLab($id_ordenes);
	$d['cantreg'] = $this -> laboratorio_model -> listadoOrdenesRegUrg($id_ordenes);
	
	if ($d['cantreg']>0){
		$d['id_orden']=$id_ordenes;
	  
	  $this->laboratorio_model->RegistraOrdRegUrg($d);
		
		}
		
		
		
		
	
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////
   
   
       function MuestraEnviadaLab2($id_ordenes)
  {
    
    //----------------------------------------------------------
	$d = array();
		
	$d['listado'] = $this -> laboratorio_model -> RegistraEnvioLab($id_ordenes);
	
	$d['cantreg'] = $this -> laboratorio_model -> listadoOrdenesRegUrg($id_ordenes);
	echo $d['cantreg'];
	
	
	
     //redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   
       	/* 
* @Descripcion: muestra remitida a laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/

   /////////////////////////////////////////////////////////////////
   
   
       function MuestraRemitidaLab($id_ordenes)
  {
    
    //----------------------------------------------------------
	$d = array();
		
	$d['listado'] = $this -> laboratorio_model -> RegistraRemiteLab($id_ordenes);
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////
/////////////fin////////////////////////////////////
}





?>