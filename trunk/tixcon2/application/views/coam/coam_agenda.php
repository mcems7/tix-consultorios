<link rel="stylesheet" href="<?=base_url()?>resources/styles/calendario_agenda.css" type="text/css" media="screen" />
<script language="javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerConsultorio('<?=date('Y')?>','<?=date('m')?>');			 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerConsultorio(anno,mes)
{
	var consultorio = $('id_consultorio').value;
	if(consultorio == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/coam/coam_agenda_consultorio/agendaConsultorio/'+consultorio+'/'+anno+'/'+mes;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_consultorio').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function crear_agenda(d,m,a,id_consultorio)
{
	document.location = '<?=site_url()?>/coam/coam_agenda_consultorio/agenda_dia_crear/'+d+'/'+m+'/'+a+'/'+id_consultorio;	
}
function consultar_agenda(d,m,a,id_consultorio)
{
	document.location = '<?=site_url()?>/coam/coam_agenda_consultorio/agenda_dia_consultar/'+d+'/'+m+'/'+a+'/'+id_consultorio;	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Agenda de consultorio</h2>
<center>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Consultorio:&nbsp;
<?php
$id = $this->session->userdata('id_consultorioAgenda');
?>
<select name="id_consultorio" id="id_consultorio" onchange="obtenerConsultorio('<?=date('Y')?>','<?=date('m')?>');	">  <option value="0">-Seleccione uno-</option>
<?php
foreach($consultorios as $d)
{
	if($id == $d['id_consultorio']){
	echo '<option value="'.$d['id_consultorio'].'" selected="selected">'.$d['consultorio'].'</option>';	
	}else{
	echo '<option value="'.$d['id_consultorio'].'">'.$d['consultorio'].'</option>';	
	}
}
?>      
    </select>
</th></tr>
<tr><td id="div_detalle_consultorio">

</td></tr>
<tr><td class="linea_azul">&nbsp;</td></tr>
  <tr><td align="center">
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
  </td></tr>
</table>
&nbsp;
</center>
<?=form_close();?>