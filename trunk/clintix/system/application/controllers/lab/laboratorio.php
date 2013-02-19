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
class Laboratorio extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
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
    $this -> load -> view('lab/lab_areas', $d);
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
	
  
  //lectura xml
  // Ejemplo de lectura con simpleXml ( libreria incluida en php > 5.x)
// 1) Cargo el archivo com la sentencia simplexml_load_file
$prueba   = simplexml_load_file("files/laboratorio/".$id_orden.".xml");
// 2) En el momento en que se carga el objeto, en este caso en la variable $book_example
//  la variable queda ASOCIADA A LA RAIZ DEL DOCUMENTO; a partir de este momento es "navegar"
//  sobre el XML de la misma manera que si fuera un arbol
// 3) Leer atributos; La lectura de un atributo es similar a la de un campo en un array, solo hay que definir
// quien es el padre en este caso es el 0
// Tambien Puedo hacerlo en bucles
$contador=0;
foreach ($prueba->controlActProcess->subject->observationReport->component1->specimenObservationCluster->component1->observationBattery->component1 as $language) {
  $name= $language->observationEvent->code['displayName']; 
  $code = $language->observationEvent->id['extension'];
  $value = $language->observationEvent->value['value'];
  $d['analizador']['nombre'][$contador]=$name;
  $d['analizador']['codigo'][$contador]=$code;
  $d['analizador']['valor'][$contador]=$value;
  $contador++;
} 
$d['imagen']=$prueba->controlActProcess->subject->observationReport->component1->specimenObservationCluster->component1->observationBattery->value;

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
 
 // valores de los analizadores
  $d['codigo'] = $this->input->post('codigo');
  $d['nombre'] = $this->input->post('nombre');
  $d['valor'] = $this->input->post('valor');
///////////////////////////////////////////////
  
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
		 
		 
        redirect('/lab/laboratorio/index', 'refresh');
		}
 
 
	}



function OrdenesHematologia()
{
	$accion="registrar";
	$area='hematologia';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	print_r($d['lista']);
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}

function OrdenesUroanalisis()
{
	$accion="registrar";
	$area='Parasitología';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}

function OrdenesQuimica()
{
	$accion="registrar";
	$area='quimica';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	//print_r($d['lista']);
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}

function OrdenesMicrobiologia()
{
	$accion="registrar";
	$area='microbiologia';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	//print_r($d['lista']);
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}

function OrdenesInmunologia()
{
	$accion="registrar";
	$area='inmunologia';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	//print_r($d['lista']);
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}

function OrdenesCoagulacion()
{
	$accion="registrar";
	$area='coagulacion';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	//print_r($d['lista']);
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}

function OrdenesSerologia()
{
	$accion="registrar";
	$area='serologia';
	$d['lista'] = $this -> laboratorio_model -> OrdenesLabAreas($accion,$area);
	
	//print_r($d['lista']);
	 
    $this -> load -> view('lab/lab_OrdenesListadoProcesar',$d);
		
}


function hl7($id_orden,$id_atencion)
{
	
	    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
	$d['laboratorio']=$this->laboratorio_model->obtenerLabOrden($id_orden);
	//print_r ($d['laboratorio']);
	$cup = $d['laboratorio'][0]['cups'];
	$cup_sin = str_replace(".", "",$cup);
	
	//quitamos los puntos de los documentos
	
	
	
	$analizador=$this->laboratorio_model->obtenerNombreAnalizador($cup);
	print_r($analizador);
	$ordenLab = $d['laboratorio'][0]['id_lab_orden']; 

    $d['urlRegresar']   = site_url('lab/laboratorio/index');

	
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	//print_r($d['paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
	//print_r($d['tercero']);
	$fecha=date('Y-m-d H:i:s');
	$cambio = array(":", "-", " ");
	$fecha_sin= str_replace($cambio, "",$fecha);
	
	$tipo_doc=$d['tercero']['tipo_documento'];
	
	$tipo_doc_sin= str_replace(".", "",$tipo_doc);
	
	if($d['paciente']['genero']=='Femenino')
	{
		$genero_cod='F';
	}else{
			 $genero_cod='M';
			}
		

	
 $list_data = array( 'Fecha'     => $fecha_sin,
 					 'id_cajero' => '1234567', // NO OBLIGATORIO
 					 'id_orden'  => $id_orden,
 					 'serial_AD' => 'SN1234', //NO OBLIGATORIO
 					 'cajero_primer_nombre'    => 'primer nombre', //NO OBLIGATORIO
 					 'cajero_segundo_nombre'   => 'segundo nombre cajero', //NO OBLIGATORIO
 					 'cajero_primer_apellido'  => "Apellido Cajero 1", //NO OBLIGATORIO
 					 'cajero_segundo_apellido' => "", //NO OBLIGATORIO
 					 'paciente_primer_nombre'    => $d['tercero']['primer_nombre'], //NO OBLIGATORIO
 					 'paciente_segundo_nombre'   => $d['tercero']['segundo_nombre'], //NO OBLIGATORIO
 					 'paciente_primer_apellido'  => $d['tercero']['primer_apellido'], //NO OBLIGATORIO
 					 'paciente_segundo_apellido' => $d['tercero']['segundo_apellido'], //NO OBLIGATORIO
 					 'Id_pat_HC'          => $d['atencion']['id_paciente'],// id del paciente 
 					 'tipo_id_pat'        => $tipo_doc_sin,    // tipo de documento
 					 'Id_pat'             => $d['tercero']['numero_documento'], // numero de documento
 					 'Genero_pat_code'    => $genero_cod, // genero
 					 'Genero_pat_val'     => $d['paciente']['genero'],
 					 'paciente_fecha_nac' => '' ,  //NO OBLIGATORIO
 					 'medico_primer_nombre'    => "Nombre Medico 1", //NO OBLIGATORIO
 					 'medico_segundo_nombre'   => "", //NO OBLIGATORIO
 					 'medico_primer_apellido'  => "Apellido Medico 1", //NO OBLIGATORIO
 					 'medico_segundo_apellido' => "", //NO OBLIGATORIO
 					 'medico_id'               => "928374",   //NO OBLIGATORIO
 					 'localizacion'			   => "Urgencias",  //NO OBLIGATORIO
 					 'pruebas'                 => array($id_orden.'_1',$cup_sin,'Hemograma Tipo 1'), 
 					 									
 					);

// 1) Creo el XML Generando el Elemento Raiz
$NewOrderRoot = new SimpleXMLElement("<POOR_IN200901UV></POOR_IN200901UV>");
// 2) Creo los atributos del elemento Raiz, 
$NewOrderRoot["ITSVersion"] = "XML_1.0";
// 3) ELEMENTO CONSTANTE. Identificación de la plantilla de mensajes 
// Observe que solo se debe definir un nuevo elemento añadiendolo a la raiz
// u a otro elemento usando al concatenacion '->'' y el nombre del elemento
$NewOrderRoot->templateId['extension'] = "POOR_RM201270CO01";
$NewOrderRoot->id['root'] = "UNK";
$NewOrderRoot->id['displaylable'] = "true";
$NewOrderRoot->id['extension'] = $id_orden;

// 4) Fecha y hora de generación del mensaje. Formato AAAAMMDDhhmmss
$NewOrderRoot->creationTime['value'] = $list_data['Fecha'];
//$NewOrderRoot->creationTime['value'] = "201208211726";



// 5) Elementos Constantes, Versión del estandar HL7 v3 utilizada.
$NewOrderRoot->versionCode['code'] = "V3-2009N";
// 6) Elementos Constantes, Identificación de la interacción de mensajes
$NewOrderRoot->interactionId['root'] = "2.16.840.1.113883.1.6";
$NewOrderRoot->interactionId['extension'] = "POOR_IN200901UV";
// 7) Elementos Constantes, Código de tratamiento para el procesamiento del mensaje
//   (code="{D|P|T}" displayName="{Debugging|Production|Training}"
$NewOrderRoot->processingCode['code'] = "P";
// 8) Elementos Constantes, Código modo de procesamiento del mensaje
$NewOrderRoot->processingModeCode['code'] = "T";
// 9) Elementos Constantes, Código de condicionamiento de respuestas ACK
//   (code="{AL|ER|NE}" displayName="{Always|Error/reject only|Never}"
$NewOrderRoot->acceptAckCode['code'] = "AL";
// 10) Set de datos de información del receptor
$NewOrderRoot->receiver['typeCode'] = "RCV";
// LA CONCATENACION DE ELEMENTOS A SUB ELEMENTOS UTILIZA EL MISMO PRINCIPIO
$NewOrderRoot->receiver[0]->device['classCode'] = "DEV";
$NewOrderRoot->receiver[0]->device['determinerCode'] = "INSTANCE";
// 11)  Identificación unívoca transaccional del dispositivo
// (máquina, sistema o aplicación de software) receptor (filler)
$NewOrderRoot->receiver[0]->device[0]->id['root'] = "UNK";
$NewOrderRoot->receiver[0]->device[0]->id['extension'] = $analizador[0]['MAQUINA'];
// 12) Nombre del Software
$NewOrderRoot->receiver[0]->device[0]->softwareName['displayName'] = $analizador[0]['MAQUINA'];
// 13) Set de datos de información del emisor
//******  ******  -->
$NewOrderRoot->sender['typeCode']  = "SND";
$NewOrderRoot->sender[0]->device['classCode'] = "DEV";
$NewOrderRoot->sender[0]->device['determinerCode'] = "INSTANCE";
// 14) Identificación unívoca transaccional del dispositivo 
// (máquina, sistema o aplicación de software) emisor (placer). 
$NewOrderRoot->sender[0]->device[0]->id['root'] = "UNK";
$NewOrderRoot->sender[0]->device[0]->id['extension'] = "YAGE";
$NewOrderRoot->sender[0]->device[0]->softwareName['displayName']= "YAGE";
// 15 Capa del control del acto , Datos constantes
$NewOrderRoot->controlActProcess['classCode']     = "CACT";
$NewOrderRoot->controlActProcess['moodCode']      = "EVN";
$NewOrderRoot->controlActProcess[0]->code['code'] = "POOR_TE200901UV";
$NewOrderRoot->controlActProcess[0]->code['codeSystem'] = "2.16.840.1.113883.1.18";
$NewOrderRoot->controlActProcess[0]->code['codeSystemName'] = "TriggerEventID";
$NewOrderRoot->controlActProcess[0]->code['displayName'] = "Composite Order Activate";
$NewOrderRoot->controlActProcess[0]->languageCode['code'] = "es-co";
$NewOrderRoot->controlActProcess[0]->languageCode['codeSystem'] = "2.16.840.1.113883.1.11.11526";
$NewOrderRoot->controlActProcess[0]->languageCode['codeSystemName'] = "HumanLanguage";
$NewOrderRoot->controlActProcess[0]->languageCode['displayName'] = "Espanol Colombia";
// 16) Set de datos del usuario del LIS o responsable de la transcripción de la información
$NewOrderRoot->controlActProcess[0]->dataEnterer['contextControlCode'] = "AP";
$NewOrderRoot->controlActProcess[0]->dataEnterer['typeCode'] = "ENT";
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson['classCode'] = "ASSIGNED";
//17 ) Identificación del usuario (tarjeta profesional, id de empleado, id de usuario, etc)
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->id['root'] = "UNK";
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->id['extension'] = $list_data['id_cajero'];
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->assignedPerson['classCode'] = "PSN";
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->assignedPerson['determinerCode'] = "INSTANCE";
// 18) Nombre del usuario
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->name[0]->given[0] = $list_data['cajero_primer_nombre'];
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->name[0]->given[1] = $list_data['cajero_segundo_nombre'];
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->name[0]->family[0] = $list_data['cajero_primer_apellido'];
$NewOrderRoot->controlActProcess[0]->dataEnterer[0]->assignedPerson[0]->name[0]->family[1] = $list_data['cajero_segundo_apellido'];
// 19) Sujeto y acto
$NewOrderRoot->controlActProcess[0]->subject['typeCode']             = "SUBJ";
$NewOrderRoot->controlActProcess[0]->subject['contextConductionInd'] = "true";
// 20) Observacion de la orden
$NewOrderRoot->controlActProcess[0]->subject->observationRequest['classCode']   = "OBS";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest['moodCode']    = "RQO";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest['negationInd'] = "false";
// 21) Id de la orden
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->id['root']      = "UNK";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->id['extension'] = $list_data['id_orden'];
// 22) Elemento Constante,Código de tipo se solicitud (Pruebas diagnósticas de laboratorio) 
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->code['code']          = "26436-6";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->code['codeSystem']    = "2.16.840.1.113883.6.1";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->code['codSystemName'] = "LOINC";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->code['displayName']   = "Pruebas diagnosticas de laboratorio";
// Comentarios generales adicionales sobre la orden (valor por defecto = "Solicitud de pruebas diagnosticas de laboratorio") 
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->text = "Solicitud de pruebas diagnosticas de laboratorio";
// 23) Estado de la orden
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->statusCode['code'] = "active";
// 24) Dispositivo
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device['typeCode'] = "DEV";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device['contextControlCode'] = "ON";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice['classCode'] = "ASSIGNED";
// 25) Número Serial del dispositivo
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice->id['root'] = "UNK";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice->id['extension'] = $analizador[0]['serial'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice->assignedDevice['classCode'] = "DEV";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice->assignedDevice['determinerCode'] = "INSTANCE";
// 26) Código y nombre del dispositivo analizador de laboratorio
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice[0]->assignedDevice->manufacturerModelName['code'] = $analizador[0]['MAQUINA'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->device->assignedDevice[0]->assignedDevice->manufacturerModelName['displayName'] = $analizador[0]['MAQUINA'];
// 27) Record Target 
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget['typeCode'] = "RCT";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget['contextControlCode'] = "OP";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient['classCode'] = "PAT";
// 28) Número de identificación del rol de paciente (Número de historia clínica)
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->id['root'] = "UNK";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->id['extension'] = $list_data['Id_pat_HC'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson['classCode'] = "PSN";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson['determinerCode'] = "INSTANCE";
// 29) Número de identificación de la persona root="{CC|PA|CE|TI|NUI|RC|AS|MS}"
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->id['root'] = $list_data['tipo_id_pat'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->id['extension'] = $list_data['Id_pat'];
// 30) Nombre paciente
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->name->given[0] = $list_data['paciente_primer_nombre'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->name->given[1] = $list_data['paciente_segundo_nombre'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->name->family[0] = $list_data['paciente_primer_apellido'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->name->family[1] = $list_data['paciente_segundo_apellido'];
// 31) genero paciente Sexo code="{M|F}" displayName="{MASCULINO|FEMENINO}"
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->administrativeGenderCode['code']           = $list_data['Genero_pat_code'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->administrativeGenderCode['codeSystem']     = '2.16.840.1.113883.5.1';
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->administrativeGenderCode['codeSystemName'] = 'AdministrativeGender';
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->administrativeGenderCode['displayName']    = $list_data['Genero_pat_val'];
// 32) Fecha de nacimiento del paciente. [Formato AAAAMMDD]
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->recordTarget->patient->patientPerson->birthTime['value'] = $list_data['paciente_fecha_nac'];
// 33) Autor
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author['typeCode'] = "AUT";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author['contextControlCode'] = "OP";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity['classCode'] = "ASSIGNED";
// 34) Identificador del médico que ordena el procedimiento de laboratorio
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->id['root'] = "UNK";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->id['extension'] = $list_data['medico_id'];
// 34) Correo electrónico de médico ordenante
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->telecom['value'] = "mailto: nombre@example.com";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson['classCode'] = "PSN";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson['determinerCode'] = "INSTANCE";
// 35) Nombre del médico que ordena el procedimiento de laboratorio
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->name->given[0] = $list_data['medico_primer_nombre'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->name->given[1] = $list_data['medico_segundo_nombre'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->name->family[0] = $list_data['medico_primer_apellido'];
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->name->family[1] = $list_data['medico_segundo_apellido'];
// 36) Nombre del departamento que remite la orden de procedimiento 
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->asLocatedEntity['classCode']                = 'LOCE';
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->asLocatedEntity->location['classCode']      = 'PLC';
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->asLocatedEntity->location['determinerCode'] = 'INSTANCE';
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->assignedPerson->asLocatedEntity->location->name             = $list_data['localizacion']; 
// 37)Identificación de la organización (IPS). root="{codHabilitacionPrestadorSalud|NIT} assigningAuthorityName="{MinProteccionSocial|DIAN}"-->
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->representedOrganization['classCode']                  = "ORG";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->representedOrganization['determinerCode']             = "INSTANCE";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->representedOrganization->id['root']                   = "codHabilitacionPrestadorSalud";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->representedOrganization->id['extension']              = "1100200001";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->representedOrganization->id['assigningAuthorityName'] = "MinProteccionSocial";
$NewOrderRoot->controlActProcess[0]->subject->observationRequest->author->assignedEntity->representedOrganization->name = "HOSPITAL UNVERSITARIO SAN JUAN DE DIOS";

/* Proceso recurrente de generacion pruebas*/

	// Datos Constantes
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]['typeCode'] = "COMP";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]['contextControlCode']   = "AP";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]['contextConductionInd'] = "true";
 // Número de secuencia de la prueba dentro de la orden (1, 2, 3, ...., n)
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->sequenceNumber['value'] = 1;
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest['classCode']   = "OBS";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest['moodCode']    = "RQO";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest['negationInd'] = "false";
 //Número de identificación de la prueba dentro de la orden
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->id['root'] = "UNK";
 //print_r($list_data['pruebas']);
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->id['extension'] = $list_data['pruebas'][0];
 // Código de la prueba diagnóstica de laboratorio solicitada (code="Assay Number" displayName="Assay Name") 
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->code['code'] = $list_data['pruebas'][1];
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->code['codeSystemName'] = "CUPS";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->code['displayName'] = $list_data['pruebas'][2];

 // Observaciones y comentarios de la prueba o item 
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->text = "Comentarios";
 // Estado prueba
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->statusCode['code'] = 'active';
 // Código de prioridad de la orden. code="{R|UR|A}" displayName="{Rutina|Urgente|Tan pronto como sea posible}" 
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->priorityCode['code']             = 'R';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->priorityCode['codeSystem']       = '2.16.840.1.113883.5.7';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->priorityCode['codeSystemName']   = 'ActPriority';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->priorityCode['displayName']      = 'Rutina';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->interpretationCode['nullFlavor'] = 'UNK';
 // Set de datos de la muestra asociada a la prueba o item 
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen['typeCode'] = 'SPC';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen['contextControlCode'] = 'OP';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen['classCode'] = 'SPEC';
 // Identificación unívoca del espécimen o código de barras (15 caracteres máximo)
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->id['root'] = 'UNK';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->id['extension'] = $list_data['pruebas'][0];
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->code['code']       = 'P';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->code['codeSystem'] = '2.16.840.1.113883.1.11.16515';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->code['codeSystemName']            = 'SpecimenRoleType';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->code['displayName']               = 'Paciente';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural['classCode']      = 'ENT';
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural['determinerCode'] = 'INSTANCE';
 // Código del tipo de muestra code="{BLD|PLAS}" displayName="{Sangre|Plasma}"-->
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->code['code']           = "BDL";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->code['codeSystem']     = "2.16.840.1.113883.5.129";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->code['codeSystemName'] = "SpecimenType";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->code['displayName']    = "Sangre Completa";
 // Descripción textual de la muestra 
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->desc = "";
 // Código de riesgo asociado a la muestra. code="{AGG|BIO|COR|ESC|IFL|EXP|INF|BHZ|INJ|POI|RAD|}" displayName="{Agresivo|Biologico|Corrosivo|Riesgo de escapa|Inflamable|Explosivo|Infeccioso|Peligro biologico|Peligro de lesiones|Veneno|Radioactivo}" (Valor por defecto: code="BIO" displayName="Biológico")
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->riskCode['code']           = "BIO";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->riskCode['codeSystem']     = "2.16.840.1.113883.5.46";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->riskCode['codeSystemName'] = "EntityRisk";
 $NewOrderRoot->controlActProcess[0]->subject->observationRequest->component2[0]->observationRequest->specimen[0]->specimen->specimenNatural->riskCode['displayName']    = "Biologico";

 
/* Proceso recurrente de generacion pruebas*/

// 39) Almaceno el XML con el Nombre del Id de la orden
$NewOrderRoot->asXML("files/laboratorio/".$analizador[0]['MAQUINA']."/".$id_orden.".xml");	
	//redirect('lab/laboratorio');
}


function cups_datolab($id_tipo)
	{
		$d = array();
		//---------------------------------------------------------------
		$d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
		$d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
		$d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
		$cupsUrg = $this->urgencias_model -> obtenerCupsUrg($id_tipo);
		
		if($id_tipo=="6")
		{
			$this->load->view('urg/urg_ordAgredatolab',$d);
		}	
	}



function etiqueta ($id_orden,$documento,$nombre)
{
	$d['etiqueta']=$id_orden;
	$d['documento'] = $documento;
	$d['nombre'] = $nombre;
$this->load->view('impresion/codigo_barras',$d);
}


////////////////////////////////////////////////////
////////////////////////fin//////////////////////////
}





?>