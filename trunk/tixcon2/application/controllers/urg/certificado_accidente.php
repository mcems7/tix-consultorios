<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Generación certificado medico accidente de transito
 *Tipo: Controlador
 *Descripcion: Permite generar el certificado de accidente de transito de pacientes ingresados al servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 2 de junio de 2011
*/
class Certificado_accidente extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Formulario de generación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright 	GNU GPL 3.0	
* @since		20110602
* @version		20110602
*/	
function main($id_atencion)
{
//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hce/main/consultarAtencion/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['consulta_ant'] = $this -> urgencias_model -> obtenerConsulta_ant($d['consulta']['id_consulta']);
		$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		
		if($d['consulta']['verificado'] == 'SI'){
			$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico_verifica']);
		}else{
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);	
		}
		
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_certifiAccTransito', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function abrirAtencion()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$id_atencion = $this->input->post('id_atencion');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
}
?>
