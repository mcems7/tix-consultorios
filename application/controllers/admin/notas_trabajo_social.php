<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Notas_trabajo_social
 *Tipo: controlador
 *Descripcion: Permite gestionar crear y registrar notas de trabajo social
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 20 de agosto de 2011
*/
class Notas_trabajo_social extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('admin/admin_model');
		$this -> load -> model('core/Registro'); 
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de notas realizadas en la atención
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110820
* @version		20110820
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('admin/main/gestion_atencion/'.$id_atencion);
		//----------------------------------------------------------
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['notas'] = $this -> admin_model -> obtenerNotasAtencion($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('admin/admin_trabajoSocialListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Consultar una nota de trabajo social
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110820
* @version		20110820
*/	
	function consultaNota($id_nota)
	{
		$d = array();
		$d['nota'] = $this->admin_model->obtenerNotaTrabajoSocial($id_nota);
		echo $this->load->view('admin/admin_notaTrabajoSocialConsulta',$d);
	}

///////////////////////////////////////////////////////////////////
/*
* Crear una nueva nota de trabajo social
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110820
* @version		20110820
*/	
	function crearNota($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('admin/notas_trabajo_social/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['funcionario'] = $this -> admin_model -> obtenerFuncionario($this->session->userdata('id_usuario'));
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('admin/admin_notaTrabajoSocialCrear',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function crearNota_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] = $this->input->post('id_atencion');
		$d['id_funcionario'] = $this->input->post('id_funcionario');
		$d['titulo_nota'] = mb_strtoupper($this->input->post('titulo_nota'),'utf-8');
		$d['nota']  = mb_strtoupper($this->input->post('nota'),'utf-8'); 
		//----------------------------------------------------------
		$id_nota = $this -> admin_model -> crearNotaDb($d);
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'admin',__CLASS__,__FUNCTION__
			,'aplicacion',"Se ha creado la nota con el id ".$id_nota);
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de la nota se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("admin/notas_trabajo_social/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
}
?>
