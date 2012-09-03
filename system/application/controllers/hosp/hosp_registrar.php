<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Hosp_registrar extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('hosp/hosp_model'); 
		$this -> load -> model('urg/urgencias_model');	
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
	}
///////////////////////////////////////////////////////////////////
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hosp/hosp_buscarRegistrar',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function buscarPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hosp/hosp_registrar/index');
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		
		$verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);

		if($verTer != 0)
		{
			$verPas = $this -> paciente_model -> verificarPaciente($verTer);
			//Verifica la existencia del tercero como paciente
			if($verPas != 0)
			{	
				$verAtenHosp = $this -> hosp_model -> verificarAtencionHosp($d['numero_documento']);
			
				if($verAtenHosp != 0){
					$d['lista'] = $verAtenHosp;
				}else{
					$d['lista'] = array();
				}
				
				$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($verPas);
				$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
				$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
				
				$this->load->view('core/core_inicio');
				$this->load->view('hosp/hosp_registro_atencion',$d);
				$this->load->view('core/core_fin');
			}else
			{
				$dt['mensaje']  = "El paciente no se encuentra registrado en el sistema!!";
				$dt['urlRegresar'] 	= site_url("hosp/hosp_registrar/index");
				$this -> load -> view('core/presentacionMensaje', $dt);
				return;
			}
		}else{
			$dt['mensaje']  = "El paciente no se encuentra registrado en el sistema!!";
			$dt['urlRegresar'] 	= site_url("hosp/hosp_registrar/index");
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;
		}	
	}
///////////////////////////////////////////////////////////////////
	function registrarAtencion($id_paciente)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('hosp/hosp_registrar/index');
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['servicios'] = $this -> urgencias_model -> obtenerServicios();
		$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hosp/hosp_registro_atencion_paciente', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function registrarAtencion_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$hora_ing 		= $this->input->post('hora_ing');
		$fecha_ing 	= $this->input->post('fecha_ing');
		$d['fecha_ingreso'] = $fecha_ing." ".$hora_ing; 
		$d['id_paciente'] 	= $this->input->post('id_paciente');
		$d['id_entidad'] 	= $this->input->post('id_entidad');
		$d['id_servicio'] 	= $this->input->post('id_servicio');
		$d['cama'] 			= $this->input->post('cama');
		$d['id_origen'] 	= $this->input->post('id_origen');
		$d['id_entidad_pago']= $this->input->post('id_entidad_pago');
		$d['numero_ingreso'] = $this->input->post('numero_ingreso');
		$d['dx'] 			= $this->input->post('dx_ID_');
		//----------------------------------------------------------
		$r = $this -> hosp_model -> registrarAtencioDb($d);
		//----------------------------------------------------	
		if($r['error'])
		{
			$this -> Registro -> agregar(
			$this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de la atención".$d['id_paciente']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('hosp/hosp_registrar/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
			$dat['mensaje'] = "La atención se registro correctamente.";
			$dat['urlRegresar'] = site_url('hosp/hosp_registrar/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;	
	}
///////////////////////////////////////////////////////////////////
/*
* Agrega los diagnosticos al listado de la consulta
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20101019
* @version		20101019
* @return		HTML
*/	
	function agregar_dx()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['dx_ID'] = $this->input->post('dx_ID');
		$d['dx'] = $this->urgencias_model->obtenerDxCon($d['dx_ID']);
		echo $this->load->view('urg/urg_dxInfo',$d);
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con metodo avanzado de codificar diagnosticos 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxAvanzados()
	{
		$d['capitulos'] = $this -> urgencias_model -> obtenerDxCap();		
		echo $this->load->view('urg/urg_dxAvanzado',$d);
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con metodo simple de codificar diagnosticos 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxSimple()
	{
		echo $this->load->view('urg/urg_dxSimple');
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
* Organiza el select con la lista de capitulos de diagnosticos CIE10 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxCaps($cap)
	{
		$nivel1 = $this -> urgencias_model -> obtenerDxNivel1($cap);
		
		$cadena ='';
		$cadena .= '<select name="nivel1" id="nivel1" onChange="nivel1Dx()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($nivel1 as $d)
			{
				$cadena .='<option value="'.$d['id_nivel1'].'">'.$d['desc_nivel1'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;		
	}
///////////////////////////////////////////////////////////////////
/*
* Organiza el select con la lista de subgrupos de diagnosticos  CIE10
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/
	function dxNivel1($nivel1)
	{
		$nivel2 = $this -> urgencias_model -> obtenerDxNivel2($nivel1);
		
		$cadena ='';
		$cadena .= '<select name="nivel2" id="nivel2" onChange="nivel2Dx()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($nivel2 as $d)
			{
				$cadena .='<option value="'.$d['id_nivel2'].'">'.$d['desc_nivel2'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////	
/*
* Organiza el select con la lista de diagnosticos CIE10
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/
	function dxNivel2($nivel2)
	{
		$diag = $this -> urgencias_model -> obtenerDx($nivel2);
		
		$cadena ='';
		$cadena .= '<select id="dx_hidden" name="dx_ID"';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($diag as $d)
			{
				$cadena .='<option value="'.$d['id_diag'].'"><strong>'.$d['id_diag']."</strong>&nbsp;".$d['diagnostico'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
	function verificarEntidad()
	{
		$entidad	= $this -> paciente_model -> obtenerEntidades();
		$id_origen = $this->input->post('id_origen');
		
		if($id_origen == 6 || $id_origen == 4 || $id_origen == 3 || $id_origen == 2)
		{
		$cadena = '<select name="id_entidad_pago" id="id_entidad_pago" style="font-size:9px">';
		$cadena .= '<option value="0">-Seleccione uno-</option>';
		foreach($entidad as $d)
		{
			$cadena .= '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';	
		}
		$cadena .= '</select>';	
			
		}else{
		$cadena = '<input name="id_entidad_pago" id="id_entidad_pago" type="hidden" value="0" />No Aplica';
		}
		echo $cadena;
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
