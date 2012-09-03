<?php
/*********************************************************************************
 * @AUTOR:            ULTIMINIO RAMOS GALAN.
 * @SISTEMA:          CI_training.
 * @FECHA:            19/07/2010, 01:04:51 PM.
 * @ARCHIVO:          servidor_nusoap.php
 * @DESCRIPCION:      Controlador.
 * @Encoding file:    UTF-8
 * Notas:             Convenciones de nombres de archivos, clases, metodos,
 *                    variables, estructuras de control {}, manejo de operadores,
 *                    etc, son adoptadas segun la guia de referencia de
 *                    CodeIgniter.
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No se permite el acceso directo a las p&aacute;ginas de este sitio.');

class Servidor_nusoap extends Controller {

   function  __construct() {
      parent::Controller();

      // Libreria personalizada que hicimos previamente para integrar la clase NuSoap con CI
      $this->load->library('nu_soap');
	    // $this->load->model('citas/citas_model');
   
    //$this->load->helper('array');
   // $this->load->helper('intervalos');
    //$this->load->helper('datos_listas');

      // Instanciamos la clase servidor de nusoap
      $this->NuSoap_server = new nusoap_server();

      // Creamos el End Point, es decir, el lugar donde la petición cliente va a buscar la estructura del WSDL
      // aunque hay que recordar que nusoap genera dinámicamente dicha estructura XML
      $end_point = base_url().index_page().'/servidor_nusoap/index/wsdl';

      // Indicamos cómo se debe formar el WSDL
      $this->NuSoap_server->configureWSDL('UsuariosWSDL', 'urn:UsuariosWDSL', $end_point, 'rpc');

      $this->NuSoap_server->wsdl->addComplexType(
              'Usuarios'         # Creamos nuestro propio tipo de datos, llamado Usuarios, lo vamos a utilizar para regresar la respuesta
              , 'complexType'    # Es de tipo complejo, es decir, un array o array asociativo
              , 'array'          # Su equivalencia en PHP en este caso, es de tipo array, ('struct' equivale a array asociativo)
              , ''               # Composición: 'all' | 'sequence' | 'choice', en nuestro caso no aplica
              , 'SOAP-ENC:Array' # Cómo se debe tratar y validar esta estructura de dato
              , array(           # Los elementos del array
                  'id' => array('name' => 'id', 'type' => 'xsd:int')
                  , 'nombre' => array('name' => 'nombre', 'type' => 'xsd:string')
                  , 'apellidos' => array('name' => 'apellidos', 'type' => 'xsd:string')
              )
      );

      $this->NuSoap_server->register(
              // crear en forma de clase (controller..nombre del método)
              'Servidor_nusoap..obtenerUsuario'    # El nombre de la función PHP: Clase.método ó Clase..método
              , array('id' => 'xsd:string')           # Qué datos recibe
              , array('return' => 'tns:Usuarios')  # Qué datos regresa, aquí se aprecia nuestro propio tipo de datos que definimos en addComplexType()
              , 'urn:UsuariosWSDL'                 # El elemento namespace de nuestro método
              , 'urn:UsuariosWSDL#obtenerUsuario'  # La acción u operación de nuestro método
              , 'rpc'                              # El estilo del XML
              , 'encoded'                          # Cómo se usa: 'literal' | 'encode'
              , "Provee el nombre completo de un usuario del cual se conoce su ID." # Texto de ayuda de nuestro método
      );
   } // end Constructor

   function index() {
      $_SERVER['QUERY_STRING'] = '';

      if ( $this->uri->segment(3) == 'wsdl' ) {
         $_SERVER['QUERY_STRING'] = 'wsdl';
      } // endif

      $this->NuSoap_server->service(file_get_contents('php://input'));
   }  // end function
   function parametros_agenda()
 {
	 $CI =& get_instance();
	 
	  $CI->load->model('agenda/agenda_model');


 }

   function obtenerUsuario($pin) {
	   try
	   {
	   
	  
	  
	$CI =& get_instance();

      $CI->load->model('citas_model');
	  $CI->load->model('agenda/agenda_model');

      $obj_db_result = $CI->citas_model->datos_cita_online($pin,'');
    $obj_db_result['pin']=$pin;
    if($obj_db_result['estado_cita']=='asignada'||$obj_db_result['estado_cita']=='confirmada' ||$obj_db_result['estado_cita']=='atendida')
    {
        $parametros_agenda=$this->agenda_model->cargar_parametros();
        $minutos=$this->asignacion_model->minutos_cita($obj_db_result['estado_cita']['intervalo_cita'], $obj_db_result['estado_cita']['id']);
        $obj_db_result['minutos']=$minutos;
        $obj_db_result['parametros_agenda']=$parametros_agenda;
    }
	  
	  
	  $tamano = count ($obj_db_result);
	  
	  if ($tamano==0){
		   
		   $error = array(
              array(
                      'error' => 'error',
							   
					       )
      );
		   return $error;   
		  
		  }
	  

	 // $this->load->model('citas_model');
	  
	 //$obj_db_result = $CI->citas_model->datos_ejemplo($pin);
	 //$CI->citas_model->datos_ejemplo($pin);
	  
	  
      $row = array(
              array(
                      'pin' =>  $obj_db_result['pin'],
					   'estado' => $obj_db_result['estado'], 
					   'fecha_solicitud' => $obj_db_result['fecha_solicitud'],
					   'especialidad' => $obj_db_result['especialidad'],
					   'entidad' => $obj_db_result['entidad'],
					   'numero_documento' => $obj_db_result['numero_documento'],
					   'primer_nombre' => $obj_db_result['primer_nombre'],
					   'segundo_nombre' => $obj_db_result['segundo_nombre'],
					   'primer_apellido' => $obj_db_result['primer_apellido'],
					   'segundo_apellido' => $obj_db_result['segundo_apellido'],
					   'estado' => $obj_db_result['estado'],
					   'fecha_cita' => $obj_db_result['fecha_cita'],
					   'consultorio' => $obj_db_result['consultorio'],
					   'primer_nombre_medico' => $obj_db_result['primer_nombre_medico'],
					   'segundo_nombre_medico' => $obj_db_result['segundo_nombre_medico'],
					   'primer_apellido_medico' => $obj_db_result['primer_apellido_medico'],
					   'segundo_apellido_medico' => $obj_db_result['segundo_apellido_medico'],
					   'minutos' => $obj_db_result['minutos'],
					    'parametros_agenda' => $obj_db_result['parametros_agenda'],
						'orden_intervalo' => $obj_db_result['orden_intervalo'],
						 'error' => '',
					   
					  
					   
					   
					       )
      );

      /* Este bloque muestra como se puede trabajar con un modelo de CodeIgniter */
      /*
      // Obtener el superobjeto de CodeIgniter, get_instance() sirve para tener acceso a todos los métodos del framework
      $CI =& get_instance();

      $CI->load->model('mod_cruds');

      $obj_db_result = $CI->mod_cruds->traer_usuario($id_usuario);

      $row = array(
              array(
                      'id' => $obj_db_result[0]->id_meta_campo
                      , 'campo' => $obj_db_result[0]->meta_campo
                      , 'etiqueta' => $obj_db_result[0]->meta_etiqueta
              )
      );
      */
      
      return $row;
	   }
	   catch(Exception $e){
		   $error = 'no se encuentra ninguna orden pendiente';
		   return $error;   
         //$this->error( 1,$e->getMessage());
	   }
   } // end function
   function error($numero,$texto)
   {
	$ddf = fopen('error.log','a');
	fwrite($ddf,"[".date("r")."] Error $numero:$textorn");
	fclose($ddf);
	}


} // end Class

/* End of file servidor_nusoap.php */