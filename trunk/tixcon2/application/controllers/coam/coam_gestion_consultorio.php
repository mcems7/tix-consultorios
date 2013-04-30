<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *TIX - http://www.tix.com.co
 *Proyecto: TIX CONSULTORIOS
 *Nobre: Coam_gestion_consultorio
 *Tipo: controlador
 *Descripcion: Permite gestionar consultorios
 *Autor: Carlos Andrés Jaramillo Patiño <cajaramillo@tix.com.co>
 *Fecha de creación: 28042013
 *Última fecha modificación: 28042013
*/
class Coam_gestion_consultorio extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('coam/coam_model');
		$this->load->model('core/registro');	 		
	}
///////////////////////////////////////////////////////////////////
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_gestion_consultorio', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function obtenerAgendas()
{
	//----------------------------------------------------------
	$d = array();
	$fecha_completa = $this->input->post('fecha');
	$fecha = explode("-",$fecha_completa);
	$d['anno'] = $fecha[0];
	$d['mes'] = $fecha[1];
	$d['dia'] = $fecha[2];
	
	/*$d['anno'] = '2013';
	$d['mes'] = '01';
	$d['dia'] = '30';*/
	
	$d['citas'] = $this ->coam_model->obtenerCitasFecha($d);
	$this->load->view('coam/coam_consulta_citas_dia', $d);
	//----------------------------------------------------------
	
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}