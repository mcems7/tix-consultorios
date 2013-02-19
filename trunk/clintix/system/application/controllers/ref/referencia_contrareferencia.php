<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: solicitar_cita
 *Tipo: controlador
 *Descripcion: Permite la gestión de la solicitud de la cita por parte de los
 *             terceros.
 *Autor: Diego Ivan Carvajak <diegoivanc@gmail.com>
 *Fecha de creación: 26 de Noviembre de 2012
*/
class Referencia_contrareferencia extends Controller
{
 function __construct()
  {
   parent::Controller();			
    $this->load->model('urg/urgencias_model');
    $this->load->model('core/paciente_model');
    $this->load->model('core/tercero_model'); 	 
    $this->load->model('citas/citas_model'); 
	$this -> load -> model('hce/hce_model');
	 $this->load->model('ref/ref_contra_model'); 
    $this->load->helper(array('url','form') );
    $this->load->model('core/ubicacion_model');
    $this->load->helper('array');
    $this->load->helper('intervalos');
    $this->load->helper('datos_listas');
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function index()
    {
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
    $this->load->view('core/core_inicio');
    $this->load->view('ref/buscar_paciente',$d);
	//	$this -> load -> view('hce/inicio',$d);
	
	
	$this->load->view('core/core_fin');
    }
///////////////////////////////////////////////////////////////////////////////
//
 function buscarPaciente()
 {   
 
    $departamentos=$this->ubicacion_model->departamentos();
    $d['departamento']=array(-1=> "Todos");
    foreach($departamentos as $item)
    {
        if($item['nombre']!="No aplica")
            $d['departamento'][$item['id_departamento']]=$item['nombre'];
    }
	$d['urlRegresar'] 	= site_url('ref/referencia_contrareferencia/index');
    $d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();	
    //$d['numero_documento'] = $numero_documento;
    $d['reingreso'] = 0;//$reingreso;
    $d['id_atencion'] = 0;//$id_atencion;
    $d['numero_documento']=$this->input->post('numero_documento');
    $verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);
    $d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
    $d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();

   
    $this->load->view('core/core_inicio');
    //Verifica la existencia del tercero en el sistema
        if($verTer != 0)
        {
                $verPas = $this -> paciente_model -> verificarPaciente($verTer);
                //Verifica la existencia del tercero como paciente
                if($verPas != 0)
                {
                        $d['tipo'] = 'n';
                        $d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($verPas);
                        $d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
						
                        $d['municipio']=$this->listar_municipios($d['tercero']['departamento']);
                        $this -> load -> view('ref/ref_inicio',$d);
                }else
                {
                        $d['tipo'] = 'paciente';
                        $d['tercero'] = $this -> urgencias_model -> obtenerTercero($verTer);
                        $d['municipio']=$this->listar_municipios($d['tercero']['departamento']);
                        $this -> load -> view('ref/ref_inicio',$d);
                }
        }else{
               
		 $dt['urlRegresar']= site_url().'/ref/referencia_contrareferencia/index/';
      $dt['mensaje']  = "El documento no existe en el sistema debe crear un paciente!!";
      $this -> load -> view('core/presentacionMensaje',  $dt);
		
        }	
        
		$this->load->view('core/core_fin');
}
////////////////////////////////////////////////////////////////////////////////
//
function agregar_dx()
{
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['dx_ID'] = $this->input->post('dx_ID');
    $d['dx'] = $this->urgencias_model->obtenerDxCon($d['dx_ID']);
    $d['contador']= $this->input->post('contador');
    echo $this->load->view('atencion/atencion_dxInfo',$d);
}
 //////////////////////////////////////////////////////////////////////////////
 function municipios($id_departamento)
 {
     echo form_dropdown('nombre_municipio_hidden',$this->listar_municipios($id_departamento),'','id="nombre_municipio_hidden" onchange="lista_pacientes_espera()"');
 }
 
 
private function listar_municipios($id_departamento)
{
     $municipios= $this->ubicacion_model->municipios_filtrado_id_departamento($id_departamento);
     $arreglo_municipios=array("-1"=>"Todos");
     foreach($municipios as $item)
     {
      $arreglo_municipios[$item['id_municipio']]=$item['nombre'];   
     }
     return $arreglo_municipios;
}
///////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
function registrar_ref()
  {
      $dt = array();
      $config = array();
      $d = array();
      //----------------------------------------------------------------------------
      $d['urlRegresar']   = site_url('ref/referencia_contrareferencia/index');
      $d['tipo_atencion'] = $this->input->post('tipo_atencion');
	  $d['id_tercero']=$this->input->post('id_tercero');
      $d['id_entidad']=$this->input->post('id_entidad');
	  $d['solicitud_remision']=$this->input->post('solicitud_remision');
	  $d['gestion_servicio']=$this->input->post('gestion_servicio');
	  $d['nota']=$this->input->post('nota');
	  $d['aceptado']=$this->input->post('aceptado');
	  $d['traslado_hospital']=$this->input->post('traslado_hospital');
	  $d['medico_responsable']=$this->input->post('medico_responsable');
	  $d['sin_autorizacion']=$this->input->post('sin_autorizacion');
	  $d['medico_remitente']=$this->input->post('medico_remitente');
	  $d['pendiente']=$this->input->post('pendiente');
	  $aprobacion=$this->ref_contra_model->crearRef($d);
      $principal=$this->input->post('principal_dx');
	  echo $aprobacion;
      $this->agregar_diagnostico($this->input->post('dx_ID_'),$aprobacion,$principal);
      $dt['urlRegresar']= site_url().'/ref/referencia_contrareferencia/index/';
      $dt['mensaje']  = "Registro generado!".$aprobacion;
      $this -> load -> view('core/presentacionMensaje',  $dt);
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  private function agregar_diagnostico($lista_diagnosticos,$id_cita,$principal)
  {
      foreach($lista_diagnosticos as $item)
      {
        $this->ref_contra_model->agregar_diagnostico($id_cita,$item,$principal);
      }
  }
 ////////////////////////////////////////////////////////////////////////////////
//

function buscar_ref_contra_paciente()
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
		
		$d['atencionesUrg'] = $this ->ref_contra_model->obtenerRefContraPaciente($d);
		echo $this->load->view('ref/ref_listadoPacientesRefContra',$d);
	}

function buscar_listado($tipo,$fecha_ini,$fecha_fin)
	{
	//----------------------------------------------------------
	
		$d['atencionesUrg'] = $this ->ref_contra_model->obtenerlistado($tipo,$fecha_ini,$fecha_fin);
		//print_r($d['atencionesUrg']);
	echo $this->load->view('ref/ref_listadoPacientesRefContraF',$d);
	
	}

///////////////////////////////////////////////////////////////////
function consultar_ref_contra($id_autorizacion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('ref/referencia_contrareferencia/index');
	//----------------------------------------------------------
	$d['traslado'] = $this->ref_contra_model->obtener_ref_contra($id_autorizacion);
	
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['traslado']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['traslado']['id_entidad']);	
    $d['dx'] = $this->ref_contra_model->obtenerDxAtencion($d['traslado']['id']);
	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('ref/ref_contra_consultar',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
//////////////
function editar_ref_contra($id_autorizacion)
{
	 $departamentos=$this->ubicacion_model->departamentos();
    $d['departamento']=array(-1=> "Todos");
    foreach($departamentos as $item)
    {
        if($item['nombre']!="No aplica")
            $d['departamento'][$item['id_departamento']]=$item['nombre'];
    }
	$d['urlRegresar'] 	= site_url('ref/referencia_contrareferencia/index');
    $d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();	
    //$d['numero_documento'] = $numero_documento;
    $d['reingreso'] = 0;//$reingreso;
    $d['id_atencion'] = 0;//$id_atencion;
   
    $d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
    $d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();

   $d['traslado'] = $this->ref_contra_model->obtener_ref_contra($id_autorizacion);
    $this->load->view('core/core_inicio');
    //Verifica la existencia del tercero en el sistema
                $verPas = $this -> paciente_model -> verificarPaciente($d['traslado']['id_tercero']);
    
                        $d['tipo'] = 'paciente';
						$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['traslado']['id_tercero']);
						$d['tercero'] = $this->paciente_model->obtenerTercero($d['traslado']['id_tercero']);
                        $d['municipio']=$this->listar_municipios($d['tercero']['departamento']);
                        $this -> load -> view('ref/ref_inicio_edit',$d);
    
        
		$this->load->view('core/core_fin');
	
	}

/////////////////////////////////////////////////////////////////////////////
function edit_ref()
  {
      $dt = array();
      $config = array();
      $d = array();
      //----------------------------------------------------------------------------
      $d['urlRegresar']   = site_url('ref/referencia_contrareferencia/index');
	  $d['id'] = $this->input->post('id');
      $d['tipo_atencion'] = $this->input->post('tipo_atencion');
	  $d['id_tercero']=$this->input->post('id_tercero');
      $d['id_entidad']=$this->input->post('id_entidad');
	  $d['solicitud_remision']=$this->input->post('solicitud_remision');
	  $d['gestion_servicio']=$this->input->post('gestion_servicio');
	  $d['nota']=$this->input->post('nota');
	  $d['aceptado']=$this->input->post('aceptado');
	  $d['traslado_hospital']=$this->input->post('traslado_hospital');
	  $d['medico_responsable']=$this->input->post('medico_responsable');
	  $d['sin_autorizacion']=$this->input->post('sin_autorizacion');
	  $d['medico_remitente']=$this->input->post('medico_remitente');
	  $d['pendiente']=$this->input->post('pendiente');
	  $this->ref_contra_model->editRef($d);
      $dt['urlRegresar']= site_url().'/ref/referencia_contrareferencia/index/';
      $dt['mensaje']  = "Registro Editado CERCA ".$d['id'];
      $this -> load -> view('core/presentacionMensaje',  $dt);
  }



//////////FIN////////////////////////////////////////////

}
