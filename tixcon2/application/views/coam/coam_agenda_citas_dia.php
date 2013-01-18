<script language="javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function agregarCita()
{	
	var var_url = '<?=site_url()?>/coam/coam_agenda_citas/agregarCita';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(){recargar();},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function agregarCitaForm(hora)
{	
	var var_url = '<?=site_url()?>/coam/coam_agenda_citas/agregarCitaForm/'+hora;
	var ajax1 = new Request(
	{
		url: var_url,
		onSuccess: function(html){$('tabla_cita').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function recargar()
{
	document.location = "<?=site_url("coam/coam_agenda_citas/citas_dia_medico/".$dispo['id'])?>";	
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
 var exValidatorA = new fValidator("formulario");		 
});
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onSubmit' => 'return validar_dispo()');
echo form_open('coam/coam_agenda_citas/agregar_dispo',$attributes);
echo form_hidden('id',$dispo['id']);
?>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Citas del día</h2>
<center>
<table width="100%" class="tabla_form">
<tr><td>
<table width="100%" class="tabla_interna">
<tr>
  <th colspan="2">Agenda médica<?=nbs(3).str_pad($dispo['dia'],2,'0',STR_PAD_LEFT)."-".$dispo['mes']."-".$dispo['anno'].nbs(3).$consultorio['consultorio']?></th></tr>
<tr><td width="80%">
<strong>Hora inicio:</strong>&nbsp;
<?=str_pad($dispo['hora_inicio'],2,'0',STR_PAD_LEFT)?>:<?=str_pad($dispo['min_inicio'],2,'0',STR_PAD_LEFT)?>
&nbsp;<strong>Hora fin:</strong>&nbsp;
<?=str_pad($dispo['hora_fin'],2,'0',STR_PAD_LEFT)?>:<?=str_pad($dispo['min_fin'],2,'0',STR_PAD_LEFT)?>
&nbsp;<strong>Tiempo duración por consulta:</strong>&nbsp;<?=$dispo['tiempo_consulta']?>
</td>
</tr>
<tr><td><strong>Nombre del médico:</strong>&nbsp;<?=$dispo['medico']?>
</td></tr>
</table>
</td></tr>
<tr><td>
<div id="tabla_cita">
</div>
</td></tr>
<tr><td>
<table width="100%" class="tabla_interna">
<tr><th colspan="2">Agregar citas del día - <?=$dispo['medico']?></th></tr>
<?php
$inicio = mktime($dispo['hora_inicio'],$dispo['min_inicio'],0,$dispo['mes'],$dispo['dia'],$dispo['anno']);
$fin = mktime($dispo['hora_fin'],$dispo['min_fin'],0,$dispo['mes'],$dispo['dia'],$dispo['anno']);
$cont = $inicio;
while($cont < $fin)
{
	$cita = $this->coam_model->obtener_cita_hora($dispo['id'],$cont);
	if($cita !=0)
{
?>
<tr><td class="campo" width="15%" style="background-color:#F60">
<?=date("H:i",$cont)?>
</td>
<td>
<?php

	echo $cita['numero_documento']," - ",$cita['primer_nombre']," ",$cita['segundo_nombre']," ",$cita['primer_apellido']," ",$cita['segundo_apellido'];
?>

<?php
}else{
?>
<tr><td class="campo" width="15%" style="background-color:#0C0">
<?=date("H:i",$cont)?>
</td>
<td>
<strong>[<a href="#tabla_cita" onclick="agregarCitaForm('<?=$cont?>')">Asignar</a>]</strong>
<?php
}
?>
</td>
</tr>
<?php
$cont = $cont + ($dispo['tiempo_consulta']*60);		
}
?>
</table>
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
</center>
<?=form_close();?>