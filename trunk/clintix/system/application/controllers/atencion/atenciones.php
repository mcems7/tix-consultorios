<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: atenciones
 *Tipo: controlador
 *Descripcion: Permite la atención del paciente por parte del especialista
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Atenciones extends Controller
{
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function __construct()
  {
    parent::Controller();     
    $this->load->model('lab/laboratorio_model'); 
    $this->load->model('urg/urgencias_model'); 
    $this->load->model('core/paciente_model');
    $this->load->model('citas/citas_model');
    $this->load->model('atenciones/atenciones_model');
    $this->load->model('agenda/consultorios_model');
    $this->load->helper('form');
    $this->load->helper(array('form', 'url'));
    $this->load->helper('datos_listas');
    $this->load->helper('url');
    $this->load->helper('utilidades_fechas');
    $this->load->library('lib_edad');
  }
////////////////////////////////////////////////////////////////////////////////  
//
////////////////////////////////////////////////////////////////////////////////
function index($valor_temporal,$id_cita)
{
    $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
    $d['info_cita']=$d['info_cita'][0];
    $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
    $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
    $d['registrar_hce']=($this->atenciones_model->numero_datos_hce_cita($id_cita)==0 ||$this->atenciones_model->numero_diagnosticos_cita($id_cita)==0)?true:false;
    $d['total_ordenes']=$this->atenciones_model->numero_datos_ordenes_medicamentos($id_cita)+$this->atenciones_model->numero_datos_ordenes_ayudas_diagnosticas($id_cita);
    $d['existe_remision']=$this->atenciones_model->existe_remision($id_cita);
    $d['existe_control']=$this->atenciones_model->existe_control($id_cita);
    $d['existe_incapacidad']=$this->atenciones_model->exite_incapacidad($id_cita)==0?false:true;
	$d['ordenMedi'] = $this -> atenciones_model -> obtenerMediOrdenNoPos($id_cita);
	$d['id_atencion']=$id_cita;
	$d['valor_temporal']=$valor_temporal;
    $this->atenciones_model->iniciar_atencion($id_cita);
    $this->load->view('core/core_inicio');
    $this->load->view('atencion/aten_acciones', $d);
    $this->load->view('core/core_fin'); 
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function cargar_datos_basico($id_cita,&$d)
{
    $d['tercero']=$this->atenciones_model->datos_pacientes($id_cita);
    $d['tercero']=$d['tercero'][0];
    $d['medico']=$this->urgencias_model->obtenerMedico($d['tercero']['id_especialista']);
    $d['paciente']=$d['tercero'];
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function finalizar_atencion($id_cita)
{
    $dt['urlRegresar']=site_url().'/atencion/lista_atencion/index';
    $this->atenciones_model->finalizar_atencion($id_cita);
    $dt['mensaje']  = "Atención del Paciente Finalizada Correctamente!!";
    $this -> load -> view('core/presentacionMensaje',  $dt);
    //redirect($urlRegresar, 'refresh');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function registro_hce($id_especialidad,$id_cita)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
	$d['especialidad']=$this->atenciones_model->obtenerEspecialidad($id_especialidad);
	$d['info_cita']=$this->citas_model->detalle_cita($id_cita);
        $d['info_cita']=$d['info_cita'][0];
        $d['id_cita']=$id_cita;
        $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
        $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
    // capturamos el clinico que corresponde a el ID
	$d['id_clinico_cup']=$this->atenciones_model->obtenerIdClinico($id_especialidad); 
	if ($d['id_clinico_cup']!= null)
            {
                $id_clinico_cup = $d['id_clinico_cup'][0]['id'];
                //capturamos los clinicos correspondientes a; contenedor
                $d['id_clinicos']=$this->atenciones_model->obtenerClinicos($id_clinico_cup);
            }
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this->load->view('atencion/aten_ordRegistro', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function registro_ordenes($id_cita)
{
    $d['urlRegresar']="";
    $this->cargar_datos_basico($id_cita,$d);
    $d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
    $d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
    $d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
    $this->load->view('core/core_inicio');
    $this->load->view('atencion/aten_crear_ordenes',$d);
    $this->load->view('core/core_fin'); 
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function registrar_hce()
  {
      $dt = array();
      $config = array();
      $d = array();
      //----------------------------------------------------------------------------
      $d['urlRegresar']   = site_url('lab/laboratorio/index');
      $d['id_orden'] = $this->input->post('id_cita');
      $this->agregar_item_hce($this->input->post('numero'),$d['id_orden']);
      $this->agregar_item_hce($this->input->post('texto'),$d['id_orden']);
      $this->agregar_item_hce($this->input->post('lista'),$d['id_orden']);
      $principal=$this->input->post('principal_dx');
      $this->agregar_diagnostico($this->input->post('dx_ID_'),$d['id_orden'],$principal);
      $cant_registro= $this->laboratorio_model->Cantidad_registro_numero($d['id_orden']);
      $d['cantidad']=$this->laboratorio_model->Cantidad_registro_tomar($d['id_orden']);
      $this->atenciones_model->agregar_plan($d['id_orden'],$this->input->post('plan_manejo'));
      $id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($d['id_orden']);
      $dt['urlRegresar']= site_url().'/atencion/atenciones/index/'.$id_especialidad[0]['id_especialidad'].'/'.$d['id_orden'];
      $dt['mensaje']  = "Registro de la historia clínica!";
      $this -> load -> view('core/presentacionMensaje',  $dt);
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  private function agregar_diagnostico($lista_diagnosticos,$id_cita,$principal)
  {
      foreach($lista_diagnosticos as $item)
      {
        $this->atenciones_model->agregar_diagnostico($id_cita,$item,$principal);
      }
  }
 ////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  private function agregar_item_hce($listado,$id_cita)
  {
     if($listado=='')
          return;
      foreach($listado as $key=>$item)
      {
        $this->atenciones_model->agregar_hce($id_cita,$key,$item);
      }
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function registrar_orden()
  {
   $id_atencion=$this->input->post('id_atencion');
   $id_medico=$this->input->post('id_medico');
   //registrar Medicamentos.
   $atc=$this->input->post('atc_');
   $dosis=$this->input->post('dosis_');
   $id_unidad=$this->input->post('id_unidad_');
   $frecuencia=$this->input->post('frecuencia_');
   $id_frecuencia=$this->input->post('id_frecuencia_');
   $id_via=$this->input->post('id_via_');
   $observacion=$this->input->post('observacionesMed_');
   $es_pos=$this->input->post('pos_');
   $total_medicamentos=count($atc);
   $cont = 0;
   for($i=0;$i<$total_medicamentos;$i++)
   { 
        //registrar medicamento pos
		
        if($es_pos[$i]=='SI'){
			
            $this->atenciones_model->agregar_medicamento_pos_orden($id_atencion, $atc[$i],$dosis[$i],$id_unidad[$i],$frecuencia[$i],$id_frecuencia[$i],$id_via[$i],$observacion[$i]);
		}
		//registrar medicamento No pos para asignarlo
		   if($es_pos[$i]=='NO'){
			$cont=$cont+1;
			 $this->atenciones_model->agregar_medicamento_nopos_orden($id_atencion, $atc[$i],$dosis[$i],$id_unidad[$i],$frecuencia[$i],$id_frecuencia[$i],$id_via[$i],$observacion[$i]);
		}
		
		
		
   }
   //registrar Ayudas Diagnósticas
   $cups=$this->input->post('cups_');
   $observacionesCups=$this->input->post('observacionesCups_');
   $cantidadCups=$this->input->post('cantidadCups_');
   $total_ayudas_diagnosticas=count($cantidadCups);
   if(!$cups=='')
   {
       for($i=0;$i<$total_ayudas_diagnosticas;$i++)
       {
           $this->atenciones_model->agregar_ayuda_diagnostica($cups[$i], $observacionesCups[$i],$cantidadCups[$i],$id_atencion);
       }
   }
   //Volver a pantalla básica de atención de paciente.

   
   
   $id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($id_atencion);
   $dt['urlRegresar']= site_url().'/atencion/atenciones/index/'.$id_especialidad[0]['id_especialidad'].'/'.$id_atencion;
   $dt['mensaje']  = "Ordenes Creadas Satisfactoriamente";
   $this -> load -> view('core/presentacionMensaje',  $dt);
   
  }
////////////////////////////////////////////////////////////////////////////////
//
function formatoNoPos($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		 $d['urlRegresar']   = site_url('atencion/atenciones/index');
	$d['id_atencion']=$id_atencion;
	$this->cargar_datos_basico($id_atencion,$d);
   $d['info_cita']=$this->citas_model->detalle_cita($id_atencion);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
	
	$d['ordenMedi'] = $this -> atenciones_model -> obtenerMediOrdenNoPos($id_atencion);

		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('atencion/aten_ListadoNoPos', $d);
		$this->load->view('core/core_fin'); 
		//---------------------------------------------------------------
	}

////////////////////////////////////////////////////////////////////////////////
//
function SolicitudformatoNoPos($id_orden_medicamento,$id_atencion,$valor_temporal)
	{
		//---------------------------------------------------------------
		$d = array();
		$d['urlRegresar']   = site_url('atencion/atenciones/index/'.$valor_temporal.'/'.$id_atencion);
	$d['id_atencion']=$id_atencion;
	$this->cargar_datos_basico($id_atencion,$d);
   $d['info_cita']=$this->citas_model->detalle_cita($id_atencion);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
	
	$d['ordenMedi'] = $this -> atenciones_model -> obtenerMediOrdenNoPosId($id_orden_medicamento,$id_atencion);
	

		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('atencion/aten_ordNoPos', $d);
		$this->load->view('core/core_fin'); 
		//---------------------------------------------------------------
	}



////////////////////////////////////////////////////////////////////////////////
 function registrar_incapacidad()
 {
    $id_atencion=$this->input->post('id_atencion');;
    $id_diagnostico=$this->input->post('id_diagnostico');;
    $observacion=mb_strtoupper($this->input->post('observacion'));
    $fecha_inicio=$this->input->post('fecha_agenda');
    $duracion=$this->input->post('duracion');
    $this->atenciones_model->crear_incapacidad($id_atencion, $id_diagnostico,$observacion, $fecha_inicio, $duracion);
    //Volver a pantalla básica de atención de paciente.
   $id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($id_atencion);
   $dt['urlRegresar']= site_url().'/atencion/atenciones/index/'.$id_especialidad[0]['id_especialidad'].'/'.$id_atencion;
   $dt['mensaje']  = "Ordenes Creadas Satisfactoriamente";
   $this -> load -> view('core/presentacionMensaje',  $dt);
 }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
 function registro_incapacidad($id_cita)
  {
    $d['urlRegresar']="";
    $this->cargar_datos_basico($id_cita, $d);
    $principal=$this->atenciones_model->diagnostico_principal($id_cita);
    $d['principal']=$principal[0]['id_diagnostico'];
    $this->load->view('core/core_inicio');
    $this->load->view('atencion/aten_crear_incapacidad',$d);
    $this->load->view('core/core_fin'); 
  }
////////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////// 
function registro_remision($id_cita)
  {
    $d['urlRegresar']="";
    $this->cargar_datos_basico($id_cita, $d);
    $principal=$this->atenciones_model->diagnostico_principal($id_cita);
    if(count($principal)!=0)
        $d['principal']=$principal[0]['id_diagnostico'];
    $d['listadoEspecialidades']=$this->consultorios_model->lista_especialidades();
    $temporal_array=array();
     foreach($d['listadoEspecialidades'] as $item)
     {
         $temporal_array[$item['id_especialidad']]=$item['descripcion'];
     }
     $d['listadoEspecialidades']=$temporal_array;
    $this->load->view('core/core_inicio');
    $this->load->view('atencion/aten_crear_remision',$d);
    $this->load->view('core/core_fin');
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  function registrar_remision()
  {
    $id_atencion=$this->input->post('id_atencion');
    $motivo_remision=$this->input->post('motivo_remision');
    $observacion=mb_strtoupper($this->input->post('observacion'));
    $especialidad=$this->input->post('especialidad');
    $prioridad=$this->input->post('prioridad');
    $otra_especialidad=mb_strtoupper($this->input->post('cual_especialidad'));
    $this->atenciones_model->crear_remision( $id_atencion,$motivo_remision,
                                             $observacion,$especialidad,
                                             $prioridad,$otra_especialidad);
   //Volver a pantalla básica de atención de paciente.
   $id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($id_atencion);
   $dt['urlRegresar']= site_url().'/atencion/atenciones/index/'.$id_especialidad[0]['id_especialidad'].'/'.$id_atencion;
   $dt['mensaje']  = "Ordenes Creadas Satisfactoriamente";
   $this -> load -> view('core/presentacionMensaje',  $dt);
  }
 //////////////////////////////////////////////////////////////////////////////
 function registro_cita_control($id_cita)
 {
    $this->cargar_datos_basico($id_cita, $d);
	
    $this->load->view('core/core_inicio');
    $this->load->view('atencion/aten_crear_cita_control',$d);
    $this->load->view('core/core_fin');     
 }
 //////////////////////////////////////////////////////////////////////////////
 function registrar_cita_control()
 {
    $id_atencion=$this->input->post('id_atencion');
	$id_entidad=$this->input->post('id_entidad');
    $dias=$this->input->post('dias_cita_control');
    $observacion=mb_strtoupper($this->input->post('observacion'));
    $pin=$this->crear_remision_desde_control($_POST);
    $this->atenciones_model->crear_cita_control($id_atencion,$dias,$observacion,$pin);
   //Volver a pantalla básica de atención de paciente.
   $id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($id_atencion);
   $dt['urlRegresar']=site_url().'/atencion/atenciones/index/'.$id_especialidad[0]['id_especialidad'].'/'.$id_atencion;
   $dt['mensaje']="Solicitud Cita Control Creada Satisfactoriamente";
   $this->load->view('core/presentacionMensaje',$dt);
 }
 //////////////////////////////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////////////////
function lista_atenciones($id_paciente)
{
  // $this->cargar_datos_basico($id_cita, $d);
    $this->load->view('core/core_inicio');
    $d['listado_atenciones']=$this->atenciones_model->atenciones_paciente($id_paciente);
    $this->load->view('atencion/aten_otras_atenciones',$d);
    $this->load->view('core/core_fin');     
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
private function crear_remision_desde_control($d)
{
    $this->cargar_datos_basico($d['id_atencion'], $d1);
    $datos['pin']=$this->generar_pin();
    $datos['id_tercero']=$d1['paciente']['id_tercero'];
    $datos['id_paciente']=$d1['paciente']['id_paciente'];
    $datos['motivo_remision']='CITA DE CONTROL';
    $datos['motivo_consulta']='CITA DE CONTROL';
    $datos['fecha_solicitud']=suma_fechas(date('Y-m-d'),$d['dias_cita_control']);
    $datos['id_especialidad']=$d1['paciente']['id_especialidad'];
    if($this->lib_edad->annos($d1['paciente']['fecha_nacimiento'])>=18 && $this->lib_edad->annos($d1['paciente']['fecha_nacimiento'])<=59)
    {
        $datos['estado']='autorizada';
        $datos['prioridad']=$d1['paciente']['prioridad'];
    }
    else
        $datos['estado']='solicitada';
    if($d['dias_cita_control']<5)
        {
            $datos['prioritaria']='prioritaria';
            $datos['justificacion_solicitud_prioritaria']='SOLICITUD DE CONTROL MENOR A 5 DIAS';
        }
    else
        $datos['prioritaria']='no_prioritaria';
    $datos['tipo_cita']=$d['tipo_cita'];
    $datos['fecha_rechazo_aprobacion']=date('Y-m-d');
    $datos['id_entidad_remitente']='RPROPI'; //aquí cambiar por cada entidad que resulte usuaria del sw
    //$datos['id_entidad']=$d1['paciente']['id_entidad'];
	    $datos['id_entidad']=$d['id_entidad'];
	
	$datos['tipo_afiliado']=$d1['paciente']['tipo_afiliado'];
    $datos['id_cobertura']=$d1['paciente']['id_cobertura'];
    $datos['nivel_categoria']=$d1['paciente']['nivel_categoria'];
    $datos['estado_civil']=$d1['paciente']['estado_civil'];
    $datos['desplazado']=$d1['paciente']['desplazado'];
    $datos['medico_remite']=$d1['medico']['primer_nombre'].' '.$d1['medico']['segundo_nombre'].' '.
                            $d1['medico']['primer_apellido'].' '.$d1['medico']['segundo_apellido'];
    $datos['tipo_atencion']=$d1['paciente']['tipo_atencion'];
    $datos['id_municipio']=$d1['paciente']['id_municipio'];
    $datos['tratamientos_realizados']=$d1['paciente']['conducta'];
    $datos['observaciones']=$d['observacion'];
    $datos['fecha_rechazo_aprobacion']=date('Y-m-d');
    $resultado=$this->atenciones_model->diagnostico_principal($d['id_atencion']);
    $resultado=$this->atenciones_model->datos_diagnosticos($resultado[0]['id_diagnostico']);
    $datos['impresiones_diagnosticas']=$resultado['diagnostico'];
    $duracion_citas=$this->citas_model->tiempos_consulta($datos['id_especialidad']);
    $datos['duracion_cita']= $duracion_citas[0][$datos['tipo_cita']];
    $this->citas_model->ingresar_remision_control($datos,$datos['id_tercero']);
    return $datos['pin'];
}
///////////////////////////////////////////////////////////////////////////////
private function generar_pin()
{
    $continuar=true; 
    do
     {
     $resultado=""; 
     $valores = array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F");
     $valoresNum = count($valores) - 1;
     $numCaracteres = 6;
     for ($i=0;$i<=$numCaracteres;$i++)
        {
            $aleatorio = rand(0,$valoresNum);
            $resultado .= $valores[$aleatorio];
        }
     if(count($this->citas_model->buscar_pin($resultado))==0)
             $continuar=false;
     }
     while($continuar);
     return $resultado;
}

//diego
function agregarPosSustituto()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$cont   = $this->input->post('cont');
		$d['atc_pos']   = $this->input->post($cont.'atc_pos');		
		$d['atcNoPos']   = $this->input->post($cont.'atcNoPos');
		$d['dias_tratamientoPos']   = $this->input->post($cont.'dias_tratamientoPos');
		$d['dosis_diariaPos']   = $this->input->post($cont.'dosis_diariaPos');
		$d['cantidad_mes']   = $this->input->post($cont.'cantidad_mes');
		$d['resp_clinica']   = $this->input->post($cont.'resp_clinica');
		$d['resp_clinica_cual']   = $this->input->post($cont.'resp_clinica_cual');
		$d['contraindicacion']   = $this->input->post($cont.'contraindicacion');
		$d['contraindicacion_cual']   = $this->input->post($cont.'contraindicacion_cual');
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc_pos']);
		$this -> load -> view('atencion/aten_ordInfoMedicamentoNoPos', $d);
		//--------------------------------------------------------------- 
	}


///////////////////////////////////////////////////////////////////	
	function formatoNoPos_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion']   = $this->input->post('id_atencion');
		//$d['id_orden']   = $this->input->post('id_orden');
		$d['atcNoPos']   = $this->input->post('atcNoPos');
		$d['resumen_historia']   = $this->input->post('resumen_historia');
		$d['dias_tratamiento']   = $this->input->post('dias_tratamiento');
		$d['dosis_diaria']   = $this->input->post('dosis_diaria');
		$d['cantidad_mes']   = $this->input->post('cantidad_mes');
		$d['ventajas']   = $this->input->post('ventajas');
		
		$d['atc_pos']   = $this->input->post('atc_pos_');
		$d['atcNoPosSus']   = $this->input->post('atcNoPos_');
		$d['dias_tratamientoPos']   = $this->input->post('dias_tratamientoPos_');
		$d['dosis_diariaPos']   = $this->input->post('dosis_diariaPos_');
		$d['cantidad_mesPos']   = $this->input->post('cantidad_mesPos_');
		$d['resp_clinica']   = $this->input->post('resp_clinica_');
		$d['resp_clinica_cual']   = $this->input->post('resp_clinica_cual_');
		$d['contraindicacion']   = $this->input->post('contraindicacion_');
		$d['contraindicacion_cual']   = $this->input->post('contraindicacion_cual_');
		$d['id_medicamento']   = $this->input->post('id_medicamento');
		$d['justificacion']   = $this->input->post('justificacion');
		
		//--------------------------------------------------------------- 
		$this -> atenciones_model -> formatoNoPosDb($d);
		//---------------------------------------------------------------
		$id_especialidad=$this->atenciones_model->obtener_id_especialidad_cita($d['id_atencion']);
		
		redirect("atencion/atenciones/index/".$id_especialidad[0]['id_especialidad'].'/'.$d['id_atencion']);
	}
	
	//el 12 en la tarde urgencias pediatria  victor coronado se quemo un brazo y bajo proteccion del icbf





}
?>