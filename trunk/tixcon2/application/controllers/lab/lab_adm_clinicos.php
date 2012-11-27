<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: lab_adm_clinicos
 *Tipo: controlador
 *Descripcion: Permite administrar los clinicos 
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de octubre de 2011
*/
class Lab_adm_clinicos extends CI_Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::__construct();     
    $this -> load -> model('lab/laboratorio_model'); 
     $this -> load -> model('urg/urgencias_model'); 
    $this -> load -> model('core/paciente_model');
  }
  
///////////////////////////////////////////////////////////////////
   	/* 
* @Descripcion: muestra el menu principal para la creacion de clinicos.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
///////////////////////////////////////////////////////////////////
   function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
	$this->load->library('Nodo');
	$datos['listado'] = $this -> laboratorio_model -> TomarNodo();
	
	
	
	$d['json']= Nodo::llenarTreeView($datos['listado']);
	
	
	
	 //////////////////////////////////////////
   
    $this->load->view('core/core_inicio');
   
	$this -> load -> view('lab/lab_Ordenestree', $d);
	
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
  	/* 
* @Descripcion: Carga el formulario para agregar un clinico.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
  
    function AgregarClinico()
  {
    
    //----------------------------------------------------------
	$d = array();	 
    $this -> load -> view('lab/lab_adm_agregar',$d);
    //----------------------------------------------------------
  }
  
   	/* 
* @Descripcion: Grabar un clinico de tipo numerico
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
  
    function AgregarClinicoNum()
  {
    
    //----------------------------------------------------------
	$d = array();	 
    $this -> load -> view('lab/lab_adm_agregar_tipo_num',$d);
    //----------------------------------------------------------
  }
    	/* 
* @Descripcion: Grabar un clinico de tipo texto
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
  
    function AgregarClinicoText()
  {
    
    //----------------------------------------------------------
	$d = array();	 
    $this -> load -> view('lab/lab_adm_agregar_tipo_texto',$d);
    //----------------------------------------------------------
  }
  
    	/* 
* @Descripcion: Grabar un clinico de tipo lista
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
  
    function AgregarClinicoList($identificador)
  {
   
    //----------------------------------------------------------
	$datos = array();	 
	$datos['identifica']=$identificador;
	$datos['lista'] = $this -> laboratorio_model -> Listado_Valores_List($identificador);
	
    $this -> load -> view('lab/lab_adm_agregar_tipo_lista',$datos);
    //----------------------------------------------------------
  }
  
  
      	/* 
* @Descripcion: Grabar un clinico de tipo lista
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
     function AgregarClinicoList2($dato)
  {
  
    //----------------------------------------------------------
		
	$result=array();
	
	$result['identifica']="$dato";
	
	
	
   $this -> load -> view('lab/lab_adm_agregar_tipo_lista_dato',$result);
	
	
    //----------------------------------------------------------
  }
  
  
   /////////////////////////////////////////////////////////////////
       function Agregar_cont_Clinico($id)
  {
    
    //----------------------------------------------------------
	
	$d = array();
	$d['listado'] = $this -> laboratorio_model -> Tipos_laboratorios($id);
			 
    $this -> load -> view('lab/lab_adm_agregar_cont',$d);
    
	//----------------------------------------------------------
  }
   
   
   
   /////////////////////////////////////////////////////////////////
       	/* 
* @Descripcion: Agregar un clinico
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
     /////////////////////////////////////////////////////////////////
       function Agregar_Clinico($id)
  {
    
    //----------------------------------------------------------
	
	$d = array();
	$d['listado'] = $this -> laboratorio_model -> Tipos_laboratorios($id);
			 
    $this -> load -> view('lab/lab_adm_agregar_clinico',$d);
    
	//----------------------------------------------------------
  }
   /////////////////////////////////////////////////////////////////
       	/* 
* @Descripcion: Editar un clinico
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
   
       /////////////////////////////////////////////////////////////////
       function Editar_Clinico($id)
  {
    
    //----------------------------------------------------------
	
	$d = array();
	$d['listado'] = $this -> laboratorio_model -> Editar_Clinico($id);
	print_r($d['listado']);		 
   $this -> load -> view('lab/lab_adm_editar_clinico',$d);
    
	//----------------------------------------------------------
  }
   /////////////////////////////////////////////////////////////////
       	/* 
* @Descripcion: se graban los valores del clinico tipo lista
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
   
      function AgregarValorList()
  {
    
    //----------------------------------------------------------
	
	$datos = array();
	$datos['id_clinico'] = $this->input->post('idpadre');
    $datos['descripcion'] = $this->input->post('descripcion');
	$datos['listado'] = $this -> laboratorio_model -> Insert_Valores_List($datos);
	$datos['lista'] = $this -> laboratorio_model -> Listado_Valores_List($datos['id_clinico']);
	$datos['identifica']=$datos['id_clinico'];
	
	
	
			 
    $this -> load -> view('lab/lab_adm_agregar_tipo_lista',$datos);
    
	//----------------------------------------------------------
  }
  
   
       	/* 
* @Descripcion: Grabar un clinico de tipo lista
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
   
   /////////////////////////////////////////////////////////////////
   
       function ingresa_tipo_lab()
  {
    
    //----------------------------------------------------------
	$datos = array();
	$datos['abreviatura'] = $this->input->post('abreviatura');
    $datos['nombre'] = $this->input->post('nombre');
	$datos['tipo'] = "grupo";
	$d['listado'] = $this -> laboratorio_model -> Insert_tipo_lab($datos);
	
	redirect('/lab/lab_adm_clinicos/index', 'refresh');
	
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
	$datos['investigativo'] = $this->input->post('investigativo');
	$datos['accion_alerta']= $this->input->post('accion_alerta');
	$datos['vigilancia_epidemiologica']= $this->input->post('vigilancia_epidemiologica');
	$datos['seguimiento_individuo']= $this->input->post('seguimiento_individuo');
	$datos['diagnostico']= $this->input->post('diagnostico');
	$datos['restriccion_sumatoria']= $this->input->post('restriccion_sumatoria');
	$datos['normalidad_atomica']= $this->input->post('normalidad_atomica');
	$datos['valor_grupo_suma']= $this->input->post('valor_grupo_suma');
	$datos['mensaje_grupo_suma']= $this->input->post('mensaje_grupo_suma');
	$datos['id_cup']= $this->input->post('cups_ID');
	
	$datos['mensaje_normalidad_atomica']= $this->input->post('mensaje_normalidad_atomica');
	
	$datos['tipo'] = "contenedor";
	$d['listado'] = $this -> laboratorio_model -> Insert_contenedor_lab($datos);
	
	
	 
	 
    redirect('/lab/lab_adm_clinicos/index', 'refresh');
	
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
	$d=array();
	$d['listado'] = $this -> laboratorio_model -> Insert_clinico_lab($datos);
	$d['descripcion']= $this->input->post('descripcion');
	//datos valores listado
	
	if($d['descripcion']!=''){ 
	
	
	$d['ultimoid'] = $this -> laboratorio_model -> Id_ultimo_clinico_insertado();
	//capturo el id del ultimo clinico generado para apuntarlo a los valores de la lista.
	$idfinal=$d['ultimoid'][0]['id'];
	
	$this -> laboratorio_model -> Insert_Valores_List($d,$idfinal);
	}
	redirect('/lab/lab_adm_clinicos/index', 'refresh');
	
    //----------------------------------------------------------
  }
   
///////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
   
   function Edita_Clinico()
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
	$d=array();
	$d['listado'] = $this -> laboratorio_model -> Insert_clinico_lab($datos);
	$d['descripcion']= $this->input->post('descripcion');
	//datos valores listado
	
	if($d['descripcion']!=''){ 
	
	
	$d['ultimoid'] = $this -> laboratorio_model -> Id_ultimo_clinico_insertado();
	//capturo el id del ultimo clinico generado para apuntarlo a los valores de la lista.
	$idfinal=$d['ultimoid'][0]['id'];
	
	$this -> laboratorio_model -> Insert_Valores_List($d,$idfinal);
	}
	redirect('/lab/lab_adm_clinicos/index', 'refresh');
	
    //----------------------------------------------------------
  }
   
///////////////////////////////////////////////////////////////////
       	/* 
* @Descripcion: registra la recepcion en el laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
  
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


  /////////////////////////////////////////////////////////////////
         	/* 
* @Descripcion: Registra un laboratorio rechazado
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
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
	$d['listado'] = $this -> laboratorio_model -> RegistraCambioNom($Newname,$id);
	
     redirect('/lab/lab_lista_enfermeria/index', 'refresh');
    //----------------------------------------------------------
  }
  
   /////////////////////////////////////////////////////////////////  
          	/* 
* @Descripcion: muestra los cups para laboratorio
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
	
   	function cupsLab($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('desc_subcategoria',$l);
		$this->db->where('id_subcategoria >','90');
		$this->db->where('id_subcategoria <','91');
		
		$r = $this->db->get('core_cups_subcategoria');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id_subcategoria"]."###".$d["desc_subcategoria"]."|";
		}
	}
   
          	/* 
* @Descripcion: Carga los valores de un listado clinico
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/
function listadoValores($dato){
	
	$d = array();
		
	$d['listado'] = $this -> laboratorio_model -> CargaListadoValor($dato);
	
	$this -> load -> view('lab/lab_ordenesListadoValores', $d);
	
	
	}
	
	
function listadoValoresCont($dato){
	
	$d = array();
	$d['id_clinicosCont']=$this->laboratorio_model->obtenerClinicos($dato);	
		
	$d['listado'] = $this -> laboratorio_model -> CargaListadoValor($dato);
	$this -> load -> view('lab/lab_ordRegistroCont', $d);
	
	//$this -> load -> view('lab/lab_ordenesListadoValores', $d);
	
	
	}	
////////////////////////////////////////////////////
/////////////fin////////////////////////////////////
}





?>