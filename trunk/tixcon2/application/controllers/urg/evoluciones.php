<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Evoluciones
 *Tipo: controlador
 *Descripcion: Permite gestionar crear y registrar nuevas evoluciones en una atencion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 20 de septiembre de 2010
*/
class Evoluciones extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('core/medico_model');
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de evoluciones y consulta de las anteriores
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100920
* @version		20100920
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['ultima_evolucion'] = $this -> urgencias_model -> obtenerUltimaEvolucion($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['evo'] = $this -> urgencias_model -> obtenerEvoluciones($id_atencion);
		$id_serv = $d['atencion']['id_servicio'];
		if($id_serv == 16 || $id_serv == 17 || $id_serv == 18){
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
		}else{
		$d['urlRegresar'] 	= site_url('urg/gestion_atencion/main/'.$id_atencion);
		}
    //print_r($d['evo']);die();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_evoListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Consultar una evolución indicada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100920
* @version		20100920
*/	
	function consultaEvolucion($id_evolucion)
	{
		$d = array();
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($id_evolucion);
		$d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($id_evolucion);
		echo $this->load->view('urg/urg_evoConsulta',$d);
	}

///////////////////////////////////////////////////////////////////
/*
* Crear una nueva evolucion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100920
* @version		20100920
*/	
	function crearEvolucion($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('urg/evoluciones/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['tiposEvo'] = $this -> urgencias_model ->obtenerTiposEvolucion();
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dxEvo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_evoCrear',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
/*
* Crear una nueva evolucion partiendo de la ultima registrada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20101021
* @version		20101021
*/	
	function crearEvolucionEdit($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['evo'] = $this->urgencias_model->obtenerUltEvolucion($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/evoluciones/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['dx'] = $this->urgencias_model->obtenerDxEvolucion($d['evo']['id_evolucion']);
		$d['tiposEvo'] = $this -> urgencias_model ->obtenerTiposEvolucion();
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dxEvo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');	
		$this -> load -> view('urg/urg_evoCrearEdit',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////

/*
* Verifica la ultima evolucion registrada
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since    20101101
* @version    20101104
*/  
  function verificarEvolucionEdit($id_atencion)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['evo'] = $this->urgencias_model->obtenerUltEvolucion($id_atencion);
    $d['urlRegresar']   = site_url('urg/evoluciones/main/'.$id_atencion);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
    $d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($d['evo']['id_evolucion']);
    $d['tiposEvo'] = $this -> urgencias_model ->obtenerTiposEvolucion();
    $d['especialidades']= $this -> medico_model -> tipos_especialidades();
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');  
    $this -> load -> view('urg/urg_evoVerificarEdit',$d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////


/*
* Verificar una evolución indicada
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since    20101104
* @version    20101104
*/
  function verificarEvolucion_()
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['id_evolucion'] = $this->input->post('id_evolucion');
    $d['id_tipo_evolucion'] = $this->input->post('id_tipo_evolucion');
    $d['id_especialidad'] = $this->input->post('id_especialidad');
    $d['subjetivo'] = mb_strtoupper($this->input->post('subjetivo'),'utf-8');
    $d['objetivo']  = mb_strtoupper($this->input->post('objetivo'),'utf-8');
    $d['analisis']  = mb_strtoupper($this->input->post('analisis'),'utf-8');
    $d['conducta']  = mb_strtoupper($this->input->post('conducta'),'utf-8');
    $d['dx'] = $this->input->post('dx_ID_');
    $d['verificado'] = $this->input->post('verificado');
    $d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
    $d['id_medico'] = $this->input->post('id_medico');
    $d['id_atencion'] = $this->input->post('id_atencion');
    $atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
    $d['id_servicio'] = $atencion['id_servicio']; 
    //----------------------------------------------------------
    $this -> urgencias_model -> verificarEvolucionDb($d);
    //----------------------------------------------------------
    if( ($d['verificado'] == 'SI') && ($d['id_tipo_evolucion'] == 3) ){
      $this -> urgencias_model -> solicitudInterconsulta($d);
    }
    //----------------------------------------------------
    $dt['mensaje']  = "La Verificacion de la evolución se han almacenado correctamente!!";
    $dt['urlRegresar']  = site_url("urg/evoluciones/main/".$d['id_atencion']);
    $this -> load -> view('core/presentacionMensaje', $dt);
    return; 
    //----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////



/*
* Consultar una evolución indicada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100921
* @version		20100921
*/
	function crearEvolucion_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_tipo_evolucion'] = $this->input->post('id_tipo_evolucion');
		$d['id_especialidad'] = $this->input->post('id_especialidad');
		$d['subjetivo'] = mb_strtoupper($this->input->post('subjetivo'),'utf-8');
		$d['objetivo']  = mb_strtoupper($this->input->post('objetivo'),'utf-8');
		$d['analisis']  = mb_strtoupper($this->input->post('analisis'),'utf-8');
		$d['conducta']  = mb_strtoupper($this->input->post('conducta'),'utf-8');
		$d['dx'] = $this->input->post('dx_ID_');
		$d['verificado'] = $this->input->post('verificado');
		$d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] = $atencion['id_servicio']; 
		//----------------------------------------------------------
		$d['id_evolucion'] = $this -> urgencias_model -> crearEvolucionDb($d);
		//----------------------------------------------------------
		if( ($d['verificado'] == 'SI') && ($d['id_tipo_evolucion'] == 3) ){
			$this -> urgencias_model -> solicitudInterconsulta($d);
		}
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de la evolución se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/evoluciones/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Metodo de autocompletado para diagnosticos simple 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100901
* @version		20100901
* @return		HTML
*/	
	function diagnosticos($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('diagnostico',$l);
		$this->db->or_like('id_diag',$l);
		$r = $this->db->get('core_diag_item');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id_diag"]."###<strong>".$d["id_diag"]."</strong> ".$d["diagnostico"]."|";
		}
	}
///////////////////////////////////////////////////////////////////
/*
* Verifica y confirma las historias clinicas gestionadas por internos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100910
* @version		20100910
* @return		HTML
*/
	function evoConfirma()
	{
		$d['_username'] 		= $this->input->post('user_log');
		$d['_password'] 		= md5($this->input->post('pass_log'));
		$dat['med'] = $this -> urgencias_model -> verificarMedicoConsulta($d);
		if($dat['med'] == 0){
			
			echo "<script>alert('Verifique los datos del usuario e intente de nuevo!!');</script>";
			echo $this->load->view('urg/urg_evoConfirm');	
		}else{
			echo $this->load->view('urg/urg_evoMedConfirm',$dat);
		}
		
	}
///////////////////////////////////////////////////////////////////
	function respInterconsultaUrg($id_interconsulta,$id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('urg/gestion_atencion/main/'.$id_interconsulta);
		//---------------------------------------------------------------
		$d['inter'] = $this -> interconsulta_model -> ontenerInterconsulta($id_interconsulta);
		
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($d['inter']['id_evolucion']);
		$d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($d['inter']['id_evolucion']);;
		$d['medicoInter'] = $this -> urgencias_model -> obtenerMedico($d['inter']['id_medico']);
		
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('inter/inter_respInter',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function respInterconsultaUrg_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_interconsulta'] = $this->input->post('id_interconsulta');
		$d['id_tipo_evolucion'] = $this->input->post('id_tipo_evolucion');
		$d['id_especialidad'] = '';
		$d['subjetivo'] = $this->input->post('subjetivo');
		$d['objetivo']  = $this->input->post('objetivo');
		$d['analisis']  = $this->input->post('analisis');
		$d['conducta']  = $this->input->post('conducta');
		$d['dx'] = $this->input->post('dx_ID_');
		$d['verificado'] = $this->input->post('verificado');
		$d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] = $atencion['id_servicio']; 
		//----------------------------------------------------------
		$d['id_evolucion'] = $this -> urgencias_model -> crearEvolucionDb($d);
		$this -> interconsulta_model -> cerrarInterconsulta($d);
		//----------------------------------------------------------
		$dt['mensaje']  = "Los datos de la evolución se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/gestion_atencion/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
function respInterconsultaObs($id_interconsulta,$id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_interconsulta);
		//---------------------------------------------------------------
		$d['inter'] = $this -> interconsulta_model -> ontenerInterconsulta($id_interconsulta);
		
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		
		$d['evo'] = $this->urgencias_model->obtenerEvolucion($d['inter']['id_evolucion']);
		$d['dxEvo'] = $this->urgencias_model->obtenerDxEvolucion($d['inter']['id_evolucion']);;
		$d['medicoInter'] = $this -> urgencias_model -> obtenerMedico($d['inter']['id_medico']);
		
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('inter/inter_respInterObs',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function respInterconsultaObs_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_interconsulta'] = $this->input->post('id_interconsulta');
		$d['id_tipo_evolucion'] = $this->input->post('id_tipo_evolucion');
		$d['id_especialidad'] = '';
		$d['subjetivo'] = $this->input->post('subjetivo');
		$d['objetivo']  = $this->input->post('objetivo');
		$d['analisis']  = $this->input->post('analisis');
		$d['conducta']  = $this->input->post('conducta');
		$d['dx'] = $this->input->post('dx_ID_');
		$d['verificado'] = $this->input->post('verificado');
		$d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] = $atencion['id_servicio']; 
		//----------------------------------------------------------
		$d['id_evolucion'] = $this -> urgencias_model -> crearEvolucionDb($d);
		$this -> interconsulta_model -> cerrarInterconsulta($d);
		//----------------------------------------------------------
		$dt['mensaje']  = "Los datos de la evolución se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/observacion/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
