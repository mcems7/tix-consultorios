<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: aten_adm_hc
 *Tipo: controlador
 *Descripcion: Permite crear y administrar de manera dinámica los formatos
 *             historias clínicas electrónicas por especialidades, permitiendo
 *             generar los formularios de captura de datos.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class aten_adm_hc extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
    $this -> load -> model('lab/laboratorio_model'); 
    $this -> load -> model('urg/urgencias_model'); 
    $this -> load -> model('core/paciente_model');
    $this -> load -> model('atenciones/atenciones_model');
  }
  
///////////////////////////////////////////////////////////////////
   function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
    $this->load->library('Nodo');
    $datos['listado'] = $this->atenciones_model->TomarNodo();
    $d['json']= Nodo::llenarTreeView($datos['listado']);
///////////////////////////////////////////////////////////////////////////////
    $this->load->view('core/core_inicio');
    $this -> load -> view('atencion/aten_Ordenestree', $d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
  
function AgregarClinico()
  {
   //----------------------------------------------------------
    $d = array();	 
    $this -> load -> view('atencion/aten_adm_agregar',$d);
    //----------------------------------------------------------
  }
function AgregarClinicoNum()
  { 
    //----------------------------------------------------------
    $d = array();	 
    $this -> load -> view('atencion/aten_adm_agregar_tipo_num',$d);
    //----------------------------------------------------------
  }
function AgregarClinicoText()
  {
 //----------------------------------------------------------
    $d = array();	 
    $this -> load -> view('atencion/aten_adm_agregar_tipo_texto',$d);
    //----------------------------------------------------------
  }
function AgregarClinicoList($identificador)
  {
    //----------------------------------------------------------
    $datos = array();	 
    $datos['identifica']=$identificador;
    $datos['lista'] = $this -> atenciones_model -> Listado_Valores_List($identificador);
    $this -> load -> view('atencion/aten_adm_agregar_tipo_lista',$datos);
    //----------------------------------------------------------
  }
     function AgregarClinicoList2($dato)
  {
    //----------------------------------------------------------
    $result=array();
    $result['identifica']="$dato";	
    $this -> load -> view('atencion/aten_adm_agregar_tipo_lista_dato',$result);
    //----------------------------------------------------------
  }
 ///////////////////////////////////////////////////////////////////////////////
 function Agregar_cont_Clinico($id)
  {
    
    //----------------------------------------------------------
	
	$d = array();
	$d['listado'] = $this -> atenciones_model -> Tipos_laboratorios($id);
			 
    $this -> load -> view('atencion/aten_adm_agregar_cont',$d);
    
	//----------------------------------------------------------
  }
   
   
   
   /////////////////////////////////////////////////////////////////
     /////////////////////////////////////////////////////////////////
       function Agregar_Clinico($id)
  {
    
    //----------------------------------------------------------
	
	$d = array();
	$d['listado'] = $this -> atenciones_model -> Tipos_laboratorios($id);
			 
    $this -> load -> view('atencion/aten_adm_agregar_clinico',$d);
    
	//----------------------------------------------------------
  }
   /////////////////////////////////////////////////////////////////
      function AgregarValorList()
  {
    
    //----------------------------------------------------------
	
	$datos = array();
	$datos['id_clinico'] = $this->input->post('idpadre');
    $datos['descripcion'] = $this->input->post('descripcion');
	$datos['listado'] = $this -> atenciones_model -> Insert_Valores_List($datos);
	$datos['lista'] = $this -> atenciones_model -> Listado_Valores_List($datos['id_clinico']);
	$datos['identifica']=$datos['id_clinico'];
	
	
	
			 
    $this -> load -> view('atencion/aten_adm_agregar_tipo_lista',$datos);
    
	//----------------------------------------------------------
  }
  
   
   
   
   /////////////////////////////////////////////////////////////////
   
       function ingresa_tipo_lab()
  {
    
    //----------------------------------------------------------
	$datos = array();
	$datos['abreviatura'] = $this->input->post('abreviatura');
    $datos['nombre'] = $this->input->post('nombre');
	$datos['tipo'] = "grupo";
	$d['listado'] = $this -> atenciones_model -> Insert_tipo_lab($datos);
	
	
	 
	 
    redirect('/atencion/aten_adm_hc/index', 'refresh');
	
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   
   
   
  
      function Ingresa_contenedor_Clinico()
  {
    
    //----------------------------------------------------------
	$datos = array();
	$datos['abreviatura'] = $this->input->post('abreviatura');
    $datos['nombre'] = $this->input->post('nombre');
	$datos['idpadre']= $this->input->post('idpadre');
	
	$datos['accion_alerta']= $this->input->post('accion_alerta');
	$datos['vigilancia_epidemiologica']= $this->input->post('vigilancia_epidemiologica');
	$datos['seguimiento_individuo']= $this->input->post('seguimiento_individuo');
	$datos['diagnostico']= $this->input->post('diagnostico');
	$datos['restriccion_sumatoria']= $this->input->post('restriccion_sumatoria');
	$datos['normalidad_atomica']= $this->input->post('normalidad_atomica');
	$datos['valor_grupo_suma']= $this->input->post('valor_grupo_suma');
	$datos['mensaje_grupo_suma']= $this->input->post('mensaje_grupo_suma');
	$datos['id_especialidad']= $this->input->post('cups_ID');
	
	
	$datos['mensaje_normalidad_atomica']= $this->input->post('mensaje_normalidad_atomica');
	
	$datos['tipo'] = "contenedor";
	$d['listado'] = $this -> atenciones_model -> Insert_contenedor_aten($datos);
	
	
	 
	 
    redirect('/atencion/aten_adm_hc/index', 'refresh');
	
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   
   function Ingresa_Clinico()
  {
    
    //----------------------------------------------------------
	$datos = array();
	$datos['abreviatura'] = $this->input->post('abreviatura');
    $datos['nombre'] = $this->input->post('nombre');
	$datos['idpadre']= $this->input->post('idpadre');
	$datos['valormaximonumerico'] = $this->input->post('valormaximonumerico');
	$datos['valorminimonumerico']= $this->input->post('valorminimonumerico');
	$datos['tipo_dato']= $this->input->post('tipo_dato');
	$datos['id_cup']= $this->input->post('cups_ID');
	$datos['tipo'] = "clinico";
	
	$datos['lista_observacion']= $this->input->post('lista_observacion');
	$datos['restriccion_sumatoria']= $this->input->post('restriccion_sumatoria');
	print_r ($datos['lista_observacion']);
	$d=array();
	$d['listado'] = $this -> atenciones_model -> Insert_clinico_lab($datos);
	$d['descripcion']= $this->input->post('descripcion');
	//datos valores listado
	
	if($d['descripcion']!=''){ 
	
	
	$d['ultimoid'] = $this -> atenciones_model -> Id_ultimo_clinico_insertado();
	//capturo el id del ultimo clinico generado para apuntarlo a los valores de la lista.
	$idfinal=$d['ultimoid'][0]['id'];
	
	$this -> atenciones_model -> Insert_Valores_List($d,$idfinal);
	}
	redirect('/atencion/aten_adm_hc/index', 'refresh');
	
    //----------------------------------------------------------
  }
   
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
	  
	  $this->atenciones_model->registra_lab_orden($d);
	  
	  }
   if($d['rechazo']=='NO'){
	   $d['estado']='APROBADA';
	  
	  $this->atenciones_model->registra_lab_orden($d);
		  
	  }
	   $this->load->view('core/core_inicio');
        $this -> load -> view('/atencion/aten_ordenes', $d);
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
   
   
       function rechazoOrden($id_ordenes)
  {
    
    //----------------------------------------------------------
	$d = array();

	
		
	$d['listado'] = $this -> laboratorio_model -> RegistraRechazoOrd($id_ordenes);
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   
   /////////////////////////////////////////////////////////////////
   
   
       function MuestraEnviadaLab($id_ordenes)
  {
    
    //----------------------------------------------------------
	$d = array();
		
	$d['listado'] = $this -> laboratorio_model -> RegistraEnvioLab($id_ordenes);
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////
   


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
    /////////////////////////////////////////////////////////////////
   
   
       function cambionombre($Newname,$id)
  {
    
    //----------------------------------------------------------
	
	$d = array();
	$d['listado'] = $this -> atenciones_model -> RegistraCambioNom($Newname,$id);
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////  
	
   	function cupsLab($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('descripcion',$l);
	
		
		$r = $this->db->get('core_especialidad ');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id_especialidad"]."###".$d["descripcion"]."|";
		}
	}
   
function listadoValores($dato){
	
	$d = array();
		
	$d['listado'] = $this -> atenciones_model -> CargaListadoValor($dato);
	
	$this -> load -> view('atencion/aten_ordenesListadoValores', $d);
	
	
	}
	
	
function listadoValoresCont($dato){
	
	$d = array();
	$d['id_clinicosCont']=$this->atenciones_model->obtenerClinicos($dato);	
	
	$d['listado'] = $this -> atenciones_model -> CargaListadoValor($dato);
	$this -> load -> view('atencion/aten_ordRegistroCont', $d);
	
	//$this -> load -> view('lab/lab_ordenesListadoValores', $d);
	
	
	}	
////////////////////////////////////////////////////
/////////////fin////////////////////////////////////
}





?>