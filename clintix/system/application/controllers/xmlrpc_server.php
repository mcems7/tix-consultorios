<?php
class Xmlrpc_server extends Controller {
	
	function __construct()
  {
   parent::Controller();			
    $this->load->model('urg/urgencias_model');
    $this->load->model('core/paciente_model');
    $this->load->model('core/tercero_model'); 	 
    $this->load->model('citas/citas_model'); 
	$this->load->model('citas/asignacion_model'); 
    $this->load->model('agenda/agenda_model');
    $this->load->helper(array('url','form') );
    $this->load->model('core/ubicacion_model');
    $this->load->helper('array');
    $this->load->helper('intervalos');
    $this->load->helper('datos_listas');
  }
  
function index()
{
$this->load->library('xmlrpc');
$this->load->library('xmlrpcs');
$config['functions']['Buscar'] = array('function' =>
'Xmlrpc_server.buscarpaciente');
$config['functions']['Greetings'] = array('function' =>
'Xmlrpc_server.process');
$config['functions']['generarsolicitud'] = array('function' =>
'Xmlrpc_server.generarsolicitud');
$config['functions']['estadocita'] = array('function' =>
'Xmlrpc_server.imprimir_estado_cita');
$config['functions']['listaespecialidades'] = array('function' =>
'Xmlrpc_server.listadoespecialidades');
$config['functions']['filtrando'] = array('function' =>
'Xmlrpc_server.filtrar');




$config['object'] = $this;
$this->xmlrpcs->initialize($config);
$this->xmlrpcs->serve();
}

function process($request)
{

$parameters = $request->output_parameters();

        $this->load->database();
		$this->db->from('core_usuario');
		$this->db->where('_username',$parameters['0']);
		$consulta=$this->db->get();
		
			if($fila=$consulta->row_array())
		{
			$usu_pass = md5($parameters['1']);
			
			if($fila['_password'] == $usu_pass)
			{
				if($fila['estado']!='activo')
				{
					$response = array(
									array(
											'error3' => 'Su usuario ha sido desactivado. Comuniquese con el administrador.'),
											'struct');
												return $this->xmlrpc->send_response($response);
				
				}
				else
				{
					$response = array(
									array('id_usuario' => $fila['id_usuario']),
											'struct');
												return $this->xmlrpc->send_response($response);
				}
			}
				else
			{
					$response = array(
					array(
					'error1' => 'Contraseña incorrecta.'),
					'struct');
					return $this->xmlrpc->send_response($response);
				
			}
		}
			
			else
		{
			$response = array(
					array(
					'error2' => 'Ha escrito su nombre de usuario incorrectamente'),
					'struct');
					return $this->xmlrpc->send_response($response);
			
		}
}

	
function buscarpaciente($request)
 {   
 
 $parameters = $request->output_parameters();
// $this->load->library('easyxmlrpc');
 $numero_documento =$parameters['0'];
 
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
	//print_r($d['especialidades']);
	
	
	$response = array($d['especialidades'],'struct');			
	
					
	$response1 = array(
array(
'flerror' => array(FALSE, 'boolean'),
'message' => 'Thanks for the ping'),
'struct');
					
					
$response2 = array(
$d['departamento'],'struct'

);			
	//return $this->xmlrpc->send_response($response2);		

   $d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();
   //   print_r($d['entidades_remision']);
    $d['urlRegresar'] 	= site_url('citas/solicitar_cita/index');
    $d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();	
	//print_r($d['tipo_usuario']);
    $d['generapin']=array('valor'=>$this->generar_pin());
	
	
	//$d['numero_documento'] = $numero_documento;
    $d['reingreso'] = 0;//$reingreso;
    $d['id_atencion'] = 0;//$id_atencion;
    $d['numero_documento']=$numero_documento;
    $d['verTer']= array('valor'=>$this -> tercero_model -> verificaTercero($d['numero_documento']));
    $d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
   	$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
    //$this->load->view('core/core_inicio');
    //Verifica la existencia del tercero en el sistema
        if($d['verTer']['valor'] != 0)
        {
                $d['verPas'] = array('valor'=>$this -> paciente_model -> verificarPaciente($d['verTer']['valor']));
			
                //Verifica la existencia del tercero como paciente
                if($d['verPas']['valor'] != 0)
                {
                        $d['tipo'] = 'n';
                        $d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['verPas']['valor']);
						//print_r($d['paciente']);
                        $d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
                       // $d['municipio']=$this->listar_municipios($d['tercero']['departamento']);
						
						$response = array(
						array(

							'especialidades' => array(
    						$d['especialidades'],'struct'
											  ),
							'paciente' => array(
    						$d['paciente'],'struct'
											  ),
						'tercero' => array(
    						$d['tercero'],'struct'
											  ),
						'generapin' => array(
    						$d['generapin'],'struct'
											  ),
						'verTer' => array(
    						$d['verTer'],'struct'
											  ),
						'verPas' => array(
    						$d['verPas'],'struct'
											  ),	
				 ), 'struct'); 
			
			return $this->xmlrpc->send_response($response);		
						
						
						
						
                       // $this -> load -> view('citas/inicio_solicitud',$d);
                }else
                {
                        $d['tipo'] = 'paciente';
                        $d['tercero'] = $this -> urgencias_model -> obtenerTercero($d['verTer']['valor']);
           
						$response = array(
						array(

							'especialidades' => array(
    						$d['especialidades'],'struct'
											  ),
						     'tercero' => array(
    						$d['tercero'],'struct'
											  ),
							'generapin' => array(
    						$d['generapin'],'struct'
											  ),	
							'verTer' => array(
    						$d['verTer'],'struct'
											  ),		
							'verPas' => array(
    						$d['verPas'],'struct'
											  ),	
							
				 ), 'struct'); 
			
			return $this->xmlrpc->send_response($response);		
						
						
						
                       // $this -> load -> view('citas/inicio_solicitud',$d);
                }
        }else{
                $d['tipo'] = 'tercero';
               // $this -> load -> view('citas/inicio_solicitud',$d);
			   $response= array(
						array(
							'especialidades' => array(
    						$d['especialidades'],'struct'
											  ),
							'generapin' => array(
    						$d['generapin'],'struct'
											  ),
							'verTer' => array(
    						$d['verTer'],'struct'
											  ),
							
							
				 ), 'struct'); 
			
			return $this->xmlrpc->send_response($response);	
			   
			   
			   
			   
        }	
        
		$this->load->view('core/core_fin');
		
}

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

function generarsolicitud($request)
 {   
 
 $parameters = $request->output_parameters();
 
 /* la variable parameters tiene 5 posiciones en las cuales:
	en la posicion 	 $parameters[0] estaran los datos de la variable $d['datos_pacientes']
	en la posicion 	 $parameters[1] estaran los datos de la variable $d['datos_formulario_array']
	en la posicion 	 $parameters[2] estaran los datos de la variable $d['datos_localizacion']
	en la posicion 	 $parameters[3] estaran los datos de la variable $d_persona,
	en la posicion 	 $parameters[4] estaran los datos de la variable $da.
	
	todos enviados desde el cliente de la funcion generar_solicitud.
 */
 
// print_r($parameters);


 
 $d['datos_formulario_array']=$parameters[1];
 
 
    $d['pin']=$parameters[1]['pin'];
	//echo $d['pin'];
    
    
    if($parameters[1]['prioridad']=='prioritaria')
        $d['datos_formulario_array']['justificacion_solicitud_prioritaria']=$parameters[1]['justificacion_solicitud_prioritaria'];
           if($parameters[1]['tipo'] == 'tercero' ){
            //----------------------------------------------------
            $d_persona['primer_apellido'] 	= $parameters[3]['primer_apellido'];
            $d_persona['segundo_apellido'] 	= $parameters[3]['segundo_apellido'];
            $d_persona['primer_nombre'] 	= $parameters[3]['primer_nombre'];
            $d_persona['segundo_nombre'] 	= $parameters[3]['segundo_nombre'];
            $d_persona['id_tipo_documento'] = $parameters[3]['id_tipo_documento'];
            $d_persona['numero_documento'] 	= $parameters[3]['numero_documento'];
            $d_persona['fecha_nacimiento'] 	= $parameters[3]['fecha_nacimiento'];
            $d_persona['telefono'] 	= $parameters[3]['telefono'];
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
            $da['genero']=$parameters[4]['genero'];
            $da['fecha_nacimiento'] = $parameters[4]['fecha_nacimiento'];
            //----------------------------------------------------
            $d['datos_formulario_array']['id_paciente'] =$this -> urgencias_model -> crearPacienteUrg($da);
            $d['datos_formulario_array']['id_tercero']=$da['id_tercero'];
            //----------------------------------------------------

    }else if($parameters[1]['tipo']=='paciente'){
            //----------------------------------------------------
            $d['datos_formulario_array']['id_tercero']=$da['id_tercero'] = $parameters[1]['id_tercero'];
            $da['genero']=$parameters[4]['genero'];
            //----------------------------------------------------
            $d['datos_formulario_array']['id_paciente'] =	$this -> urgencias_model -> crearPacienteUrg($da);
            //----------------------------------------------------
    }else{
            $d['datos_formulario_array']['id_tercero']	= $parameters[1]['id_tercero'];
            $d['datos_formulario_array']['id_paciente'] 	= $parameters[1]['id_paciente'];
    }
    $d['datos_localizacion']['departamento']=$parameters[2]['departamento'];
    $d['datos_formulario_array']['id_municipio']=$d['datos_localizacion']['municipio']=$parameters[2]['municipio'];
    $d['datos_localizacion']['celular']=$parameters[2]['celular'];
    $d['datos_localizacion']['direccion']=$parameters[2]['direccion'];
    $d['datos_localizacion']['vereda']=$parameters[2]['vereda'];
    $d['datos_localizacion']['zona']=$parameters[2]['zona'];
    $d['datos_localizacion']['telefono']= $parameters[2]['telefono'];
    $d['datos_localizacion']['email'] 	= $parameters[2]['email'];
    $d['datos_paciente']['id_entidad'] 	= $parameters[0]['id_entidad'];
    $d['datos_paciente']['id_cobertura']= $parameters[0]['id_cobertura'];
    $d['datos_paciente']['estado_civil']= $parameters[0]['estado_civil'];
    $d['datos_paciente']['tipo_afiliado']= $parameters[0]['tipo_afiliado'];
    $d['datos_paciente']['nivel_categoria']= $parameters[0]['nivel_categoria'];
    $d['datos_paciente']['desplazado']= $parameters[0]['desplazado'];
	//ingresamos los datos de la remision
    $this->citas_model->ingresar_remision($d['datos_formulario_array'],
                                          $d['datos_formulario_array']['id_tercero'],
                                          $d['datos_localizacion'],
                                          $d['datos_paciente']);
    $d['estado_cita']=$this->citas_model->datos_cita($d['pin']);
  // print_r($d['estado_cita']);
  // print_r($d['estado_cita']);
$response1 = array(
$d['estado_cita'],'struct'

);	




return $this->xmlrpc->send_response($response1);	

}



function imprimir_estado_cita($request)
{

	 $parameters = $request->output_parameters();
	
    $d['estado_cita']=$this->citas_model->datos_cita($parameters[0]);
    $d['pin']=$parameters[0];
    if($d['estado_cita']['estado']=='asignada'||$d['estado_cita']['estado']=='confirmada' ||
       $d['estado_cita']['estado']=='atendida')
    {
        $parametros_agenda=$this->agenda_model->cargar_parametros();
        $minutos=$this->asignacion_model->minutos_cita($d['estado_cita']['intervalo_cita'], $d['estado_cita']['id']);
		//print_r($parametros_agenda);
        $d['minutos']=$minutos[0];
        $d['parametros_agenda']=$parametros_agenda;
		$arreglo= arreglo_a_hora($d['estado_cita']['intervalo_cita'],$parametros_agenda).':'.strlen(count($minutos)==1?'0':'').$minutos[0]['minutos'];
		
		 $d['hora'] = array('valor'=>$arreglo);
		
		
		 $response= array(
						array(
							'estado_cita' => array(
    						$d['estado_cita'],'struct'
											  ),
							'minutos' => array(
    						$d['minutos'],'struct'
											  ),
							'hora' => array(
    						$d['hora'],'struct'
											  ),
							
				 ), 'struct'); 
			return $this->xmlrpc->send_response($response);	
		}
  $response= array(
						array(
							'estado_cita' => array(
    						$d['estado_cita'],'struct'
							),		
				 ), 'struct'); 

			return $this->xmlrpc->send_response($response);	
  

}
/////////////////

function listadoespecialidades($request)
 {   
 
 $parameters = $request->output_parameters();
// $this->load->library('easyxmlrpc');
 $numero_documento =$parameters['0'];
 
   $lista=$this->agenda_model->lista_especialidades_contratadas();
    $especialidades=array();
    foreach($lista as $item)
    {
        $especialidades[$item['id_especialidad']]=$item['descripcion'];
    }
  
    $d['especialidades'] =$especialidades;
	//print_r($d['especialidades']);
	
		// genero el arreglo para devolver al cliente.
	        $response = array($d['especialidades'],'struct');			
	
				return $this->xmlrpc->send_response($response);		
							
}

/////////////////////////////////////////
// filtramos los resultados de las ordenes solicitadas por una determinada ips
function filtrar($request)
{ 
	
	$parameters = $request->output_parameters();
	
    
	
	
    $d=$this->citas_model->buscar_citas_listas_usuario($parameters[0]);
	$n=1;
	
	 
	if($d==0){
		$response = array(
					array(
					'error2' => 'error'),
					'struct');
					return $this->xmlrpc->send_response($response);
		
		}
	
	 foreach($d as $item){
	   $response[] = array($item,'struct');	
	   	 }
		//print_r($respuesta);
 $responser = $this->convert_to_xmlrpc_values($response);	
	 return $this->xmlrpc->send_response($responser);

					
		 $response = $this->convert_to_xmlrpc_values($d);			
			return $this->xmlrpc->send_response($response);	
    $d['filtros']=$parameters;
    $d['id_estado']=$parameters[0]['id_estado'];
    //$minutos=$this->asignacion_model->minutos_cita($d['citas']['intervalo_cita'], $d['citas']['id']);
    //$this->load->view('citas/lista_citas_filtrada',$d);
}
///////////


function convert_to_xmlrpc_values($obj)
    {
        $return = $obj;
        $type = 'string';
        
        if (is_object($obj)) {
            $return = (array) $obj;
            $type = 'struct';
        } elseif (is_numeric($obj)) {
            $type = 'int';    
        } elseif (is_bool($obj)) {
            $type = 'bool';    
        } elseif (is_array($obj)) {
            $each = array();
            foreach ($obj as $key => $value) {
                if (is_object($value)) {
                    $each[$key] = $this->convert_to_xmlrpc_values($value);
                } else {
                    $each[$key] = $value;    
                }
            }
            $return = $each;
            $type = 'array';
        }
        
        return array($return, $type);
    } // convert_to_xmlrpc_values()

}
?>
