<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *TIX - http://www.tix.com.co
 *Proyecto: TIX CONSULTORIOS
 *Nobre: Coam_agenda_citas
 *Tipo: controlador
 *Descripcion: Permite crear citas sobre las agendas creadas para los medicos
 *Autor: Carlos Andrés Jaramillo Patiño <cajaramillo@tix.com.co>
 *Fecha de creación: 11 de enero de 2013
 *Última fecha modificación: 14 de enero de 2013
*/
class Coam_agenda_citas extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('coam/coam_model');
		$this->load->model('core/registro');
		$this->load->model('core/tercero_model');	
		$this->load->model('core/paciente_model');	 		
	}
///////////////////////////////////////////////////////////////////
function index()
{
	redirect('coam/coam_agenda_citas/calendario');
}
///////////////////////////////////////////////////////////////////
function agendaCitas()
{
	$d = array();
	//----------------------------------------------------------
	$d['mes'] 	= $this->input->post('mes');
	$d['anno'] 	= $this->input->post('anno');
	//----------------------------------------------------------
	$prefs = array (
		'start_day'	=> 'monday',
		'month_type'=> 'long',
		'day_type'	=> 'short'
	);
$prefs['template'] = '{table_open}<table border="0" cellpadding="2" cellspacing="3" width="100%" class="calendario">{/table_open}
{heading_row_start}<tr>{/heading_row_start}
{heading_previous_cell}<td><a href="{previous_url}">&lt;&lt;</a></td>{/heading_previous_cell}
{heading_title_cell}<td colspan="{colspan}" class="mes"><strong>{heading}</strong>&nbsp;-&nbsp;TEXTO</td>{/heading_title_cell}
{heading_next_cell}<td><a href="{next_url}">&gt;&gt;</a></td>{/heading_next_cell}
{heading_row_end}</tr>{/heading_row_end}
{week_row_start}<tr>{/week_row_start}
{week_day_cell}<td class="dia">{week_day}</td>{/week_day_cell}
{week_row_end}</tr>{/week_row_end}
{cal_row_start}<tr>{/cal_row_start}
{cal_cell_start}<td class="celda">{/cal_cell_start}
{cal_cell_content}<strong>{day}</strong><div class="contenido_cita">{content}</div></strong>{/cal_cell_content}
{cal_cell_content_today}<strong>{day}<div class="hoy_contenido_cita">{content}</div></strong>{/cal_cell_content_today}
{cal_cell_no_content}<strong>{day}</strong>{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="hoy_no_contenido">{day}</div>{/cal_cell_no_content_today}
{cal_cell_blank}&nbsp;{/cal_cell_blank}
{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}
{table_close}</table>{/table_close}';
$this->load->library('calendar', $prefs);
$this->load->view('coam/coam_calendario_citas', $d);
}
///////////////////////////////////////////////////////////////////
function calendario()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	//$d['agendas'] = $this ->coam_model->obtenerAgendas();
	$this->load->model('core/tiempo');
	$d['meses'] = $this->tiempo->obtenerMesesAno();
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_citas_agenda', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function citas_dia_medico($id)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_agenda_citas/calendario');
	//----------------------------------------------------------
	$d['dispo'] = $this ->coam_model->obtenerDisponibilidadDia($id);
	$d['consultorio'] = $this ->coam_model->obtenerConsultorio($d['dispo']['id_consultorio']);
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_agenda_citas_dia', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function agregarCitaForm($hora,$id_agenda)
{ 	 		
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['hora'] = $hora;
	$d['id_agenda'] = $id_agenda;
	$d['tipo_documento'] = $this->tercero_model->tipos_documento();
	$d['entidad'] = $this->paciente_model->obtenerEntidades();	
	echo $this->load->view("coam/coam_citas_agregar_form",$d);	
}
///////////////////////////////////////////////////////////////////
function agregarCita()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_agenda'] 		= $this->input->post('id_agenda');
	$d['hora'] 				= $this->input->post('hora');
	$paciente_nuevo 	= $this->input->post('paciente_nuevo');
	if($paciente_nuevo == 'SI')
	{
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
		$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
		$d['numero_documento'] 	= $this->input->post('documento');
	}else{
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido_'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido_'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre_'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre_'),'utf-8');
		$d['id_tipo_documento'] = $this->input->post('id_tipo_documento_');
		$d['numero_documento'] 	= $this->input->post('documento');
	}
	$d['id_entidad'] = $this->input->post('id_entidad');
	//----------------------------------------------------------
	$this->coam_model->agregarCitaDb($d);
	echo "<script>
alert('La cita se ha creado exitosamente!!');
window.opener.location.reload()
window.close()
</script>";
	redirect("coam/coam_agenda_citas/citas_dia_medico/".$d['id_agenda']);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function buscar_paciente_cita($l)
{
	//----------------------------------------------------------
	//$l = preg_replace("/[^a-z0-9 ]/si","",$l);
	$this->load->database();
	$this->db->like('core_tercero.numero_documento',$l);
	$this->db->select("core_tercero.numero_documento,core_paciente.id_paciente",FALSE);
  $this->db->from('core_tercero');
  $this->db->JOIN('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
	$r = $this->db->get();
	$dat = $r -> result_array();
	//----------------------------------------------------------
	foreach($dat as $d)
	{
		echo $d["id_paciente"]."###".$d["numero_documento"]."|";
	}
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function obtener_paciente_cita($id_paciente)
{
	$paciente = $this->paciente_model->obtenerPacienteConsulta($id_paciente);
	$tercero = $this->paciente_model->obtenerTercero($paciente['id_tercero']);
	
	$js = "<script language='javascript'>
			$('primer_apellido').value = '".$tercero['primer_apellido']."'
			$('segundo_apellido').value = '".$tercero['segundo_apellido']."'
			$('primer_nombre').value = '".$tercero['primer_nombre']."'
			$('segundo_nombre').value = '".$tercero['segundo_nombre']."'
			$('paciente_nuevo').value = 'NO'
			$('id_tipo_documento').selectedIndex = '".$tercero['id_tipo_documento']."'
			$('documento_hidden').disabled = true;
		</script>";
		
	$js .= form_hidden('primer_apellido_',$tercero['primer_apellido']);
	$js .= form_hidden('segundo_apellido_',$tercero['segundo_apellido']);
	$js .= form_hidden('primer_nombre_',$tercero['primer_nombre']);
	$js .= form_hidden('segundo_nombre_',$tercero['segundo_nombre']);
	$js .= form_hidden('id_tipo_documento_',$tercero['id_tipo_documento']);
	echo $js;
}
///////////////////////////////////////////////////////////////////

}