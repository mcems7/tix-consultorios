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
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Solicitar_cita extends Controller
{
 function __construct()
  {
   parent::Controller();			
    $this->load->model('urg/urgencias_model');
    $this->load->model('core/paciente_model');
    $this->load->model('core/tercero_model'); 	 
    $this->load->model('citas/citas_model'); 
    $this->load->model('agenda/agenda_model');
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
    $this->load->view('core/core_inicio');
    $this->load->view('citas/buscar_paciente');
    $this->load->view('core/core_fin');
    }
///////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
 function generar_solicitud()
 {
    $this->load->view('core/core_inicio');
    $d['pin']=$this->input->post('pin');
    $d['datos_formulario_array']=elements(Array('fecha_solicitud','pin','id_especialidad',
                          'id_entidad_remitente','motivo_consulta','id_municipio',
                          'tipo_atencion','enfermedad_actual',
                          'antecedentes_familiares','antecedentes_personales',
                          'revision_sistemas','examen_fisico','impresiones_diagnosticas',
                          'paraclinicos_realizados','tratamientos_realizados',
                          'motivo_remision','tipo_atencion','medico_remite','observaciones',
                          'ten_arterial_s','ten_arterial_d','temperatura',
                          'frecuencia_cardiaca','frecuencia_respiratoria',
                          'id_entidad','id_cobertura','estado_civil',
                          'tipo_afiliado', 'nivel_categoria', 'desplazado'),$_POST);
    $d['datos_formulario_array']['solicitud_prioritaria']=$this->input->post('prioridad');
    $d['datos_formulario_array']['id_usuario']=$this -> session -> userdata('id_usuario');
	
	
	
    if($this->input->post('prioridad')=='prioritaria')
        $d['datos_formulario_array']['justificacion_solicitud_prioritaria']=$this->input->post('justificacion_prioridad');
           if($this->input->post('tipo') == 'tercero' ){
            //----------------------------------------------------
            $d_persona['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
            $d_persona['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
            $d_persona['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
            $d_persona['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
            $d_persona['id_tipo_documento'] = $this->input->post('id_tipo_documento');
            $d_persona['numero_documento'] 	= $this->input->post('numero_documento');
            $d_persona['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
            $d_persona['telefono'] 	= $this->input->post('telefono');
            $verTer = $this -> tercero_model ->verificaTercero($d_persona['numero_documento']);
            if($verTer != 0){
            $dat['mensaje']="Ya existe un tercero con el número de documento de identidad ".$d_persona['numero_documento']."!!";
            $dat['urlRegresar']=site_url('citas/solicitar_cita/index');
            $this->load-> view('core/presentacionMensaje', $dat);
            return;
            }
            //----------------------------------------------------
            $da['id_tercero']=$this -> urgencias_model -> crearTerceroUrg($d_persona);
            //----------------------------------------------------
            $da['genero']=$this->input->post('genero');
            $da['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
            //----------------------------------------------------
            $d['datos_formulario_array']['id_paciente'] =$this -> urgencias_model -> crearPacienteUrg($da);
            $d['datos_formulario_array']['id_tercero']=$da['id_tercero'];
            //----------------------------------------------------

    }else if($this->input->post('tipo')=='paciente'){
            //----------------------------------------------------
    		
			$d['datos_formulario_array']['id_tercero']=$da['id_tercero']	= $this->input->post('id_tercero');
			
            $da['genero']=$this->input->post('genero');
            //----------------------------------------------------
            $d['datos_formulario_array']['id_paciente'] =	$this -> urgencias_model -> crearPacienteUrg($da);
            //----------------------------------------------------
    }else{
		
		    $especialidad= $d['datos_formulario_array']['id_especialidad'];
			$id_paciente_c=$this->input->post('id_paciente');
			
	
						$existeremision[]= $this -> citas_model ->verificaExisteRemision($especialidad,$id_paciente_c);
						
	if ($existeremision != 0){
		 $dat['mensaje']="Ya existe una cita para el paciente en la especialidad seleccionada ";
         
          
		}
		
		
            $d['datos_formulario_array']['id_tercero']	= $this->input->post('id_tercero');
            $d['datos_formulario_array']['id_paciente'] 	= $this->input->post('id_paciente');
    }
    $d['datos_localizacion']['departamento']=$this->input->post('nombre_departamento_hidden');
    $d['datos_formulario_array']['id_municipio']=$d['datos_localizacion']['municipio']=$this->input->post('nombre_municipio_hidden');
    $d['datos_localizacion']['celular']=$this->input->post('celular');
    $d['datos_localizacion']['direccion']=$this->input->post('direccion');
    $d['datos_localizacion']['vereda']=$this->input->post('vereda');
    $d['datos_localizacion']['zona']=$this->input->post('zona');
    $d['datos_localizacion']['telefono']= $this->input->post('telefono');
    $d['datos_localizacion']['email'] 	= $this->input->post('email');
    $d['datos_paciente']['id_entidad'] 	= $this->input->post('id_entidad');
    $d['datos_paciente']['id_cobertura']= $this->input->post('id_cobertura');
    $d['datos_paciente']['estado_civil']= $this->input->post('estado_civil');
    $d['datos_paciente']['tipo_afiliado']= $this->input->post('tipo_afiliado');
    $d['datos_paciente']['nivel_categoria']= $this->input->post('nivel_categoria');
    $d['datos_paciente']['desplazado']= $this->input->post('desplazado');
    $this->citas_model->ingresar_remision($d['datos_formulario_array'],
                                          $d['datos_formulario_array']['id_tercero'],
                                          $d['datos_localizacion'],
                                          $d['datos_paciente']);
    $d['estado_cita']=$this->citas_model->datos_cita($d['pin']);
    $this->load->view('citas/cita_solicitada',$d);
    $this->load->view('core/core_fin');
 }
 ///////////////////////////////////////////////////////////////////////////////
 //
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
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
	
 function buscarPaciente()
 {   
    $lista=$this->agenda_model->lista_especialidades_contratadas();
    $especialidades=array();
    foreach($lista as $item)
    {
        $especialidades[$item['id_especialidad']]=$item['descripcion'];
    }
    $departamentos=$this->ubicacion_model->departamentos();
    $d['departamento']=array(-1=> "Todos");
    foreach($departamentos as $item)
    {
        if($item['nombre']!="No aplica")
            $d['departamento'][$item['id_departamento']]=$item['nombre'];
    }
    //print_r($especialidades);
    $d['especialidades'] =$especialidades;
    $d['urlRegresar'] 	= site_url('citas/solicitar_cita/index');
    $d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();	
    $d['pin']=$this->generar_pin();
    //$d['numero_documento'] = $numero_documento;
    $d['reingreso'] = 0;//$reingreso;
    $d['id_atencion'] = 0;//$id_atencion;
    $d['numero_documento']=$this->input->post('numero_documento');
    $verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);
    $d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
    $d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();

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
                        $d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($verPas);
                        $d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
                        $d['municipio']=$this->listar_municipios($d['tercero']['departamento']);
                        $this -> load -> view('citas/inicio_solicitud',$d);
                }else
                {
                        $d['tipo'] = 'paciente';
                        $d['tercero'] = $this -> urgencias_model -> obtenerTercero($verTer);
                        $d['municipio']=$this->listar_municipios($d['tercero']['departamento']);
                        $this -> load -> view('citas/inicio_solicitud',$d);
                }
        }else{
                $d['tipo'] = 'tercero';
                $this -> load -> view('citas/inicio_solicitud',$d);
        }	
        
		$this->load->view('core/core_fin');
}
////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
 function agregarParametroAgenda()
 {
     $this->agenda_model->ingresarNuevoParametroAgenda(elements(Array('horaInicio',
                        'horaFin','aplica_sabado','aplica_domingo'),$_POST));
     Redirect('/agenda/main/index');
 }
 //////////////////////////////////////////////////////////////////////////////
 //
 //////////////////////////////////////////////////////////////////////////////
 function asignarParametroActivo($id)
 {
     echo $id;
 }
 //////////////////////////////////////////////////////////////////////////////
 //
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
//
///////////////////////////////////////////////////////////////////////////////
function municipios2($id_departamento)
{
    /*$l = preg_replace("/[^a-z0-9 ]/si","",$l);
    $this->load->database();
    $this->db->like('nombre',$l);
    $this->db->where('id_departamento',$id_departamento);
    $r = $this->db->get('core_municipio ');
    $dat = $r -> result_array();
    foreach($dat as $d)
    {
            echo $d["id_municipio"]."###".$d["nombre"]."|";
    }*/
    echo "hola";
}
}
