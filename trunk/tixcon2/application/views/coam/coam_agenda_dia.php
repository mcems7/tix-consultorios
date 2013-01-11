<?php
//PARAMETROS
$hora_inicio = 7;
$hora_fin = 21;
?>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<link rel="stylesheet" href="<?=base_url()?>resources/styles/calendario_agenda.css" type="text/css" media="screen" />
<script language="javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function eliminar(id)
{
	if(confirm("¿Está seguro que desea eliminar esta asignación?"))
	{
		document.location = "<?=site_url('coam/coam_agenda_consultorio/agenda_dia_eliminar');?>/<?=$dia.'/'.$mes.'/'.$anno.'/'.$consultorio['id_consultorio']?>/"+id;
	}
	
	return false;
}
////////////////////////////////////////////////////////////////////////////////
function validar_dispo()
{
	var hora_inicio = parseInt($('hora_inicio').value);
	var min_inicio = parseInt($('min_inicio').value);
	var hora_fin= parseInt($('hora_fin').value);
	var min_fin= parseInt($('min_fin').value);
	var tiempo_consulta= parseInt($('tiempo_consulta').value);
	var id_medico= $('medico_hidden').value;
	var medico= $('medico').value;
	
	var mins = 0;
	mins = ((hora_fin - hora_inicio) * 60 )+(min_fin + min_inicio);
	if( (mins % tiempo_consulta) != 0)
	{
		alert("Las horas de inicio y fin no concuerdan con el tiempo de consulta!!");
		return false;
	}
	
	if(hora_inicio > hora_fin)
	{
		alert("La hora de inicio no puede ser posterior a la hora de fianlización!!");
		return false;	
	}
	
	if(hora_inicio == hora_fin)
	{
		if(min_inicio > min_fin)
		{
			alert("La hora de inicio no puede ser posterior a la hora de fianlización!!");
			return false;
		}
		
		if(min_inicio == min_fin)
		{
			alert("La hora de inicio no puede ser igual a la hora de fianlización!!");
			return false;
		}
	}
	
	if(id_medico == '-' || medico.length < 8){
		alert("Debe buscar el médico a asignar!!");
		return false;	
	}
		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onSubmit' => 'return validar_dispo()');
echo form_open('coam/coam_agenda_consultorio/agregar_dispo',$attributes);
echo form_hidden('id_consultorio',$consultorio['id_consultorio']);
echo form_hidden('dia',$dia);
echo form_hidden('mes',$mes);
echo form_hidden('anno',$anno);
?>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Agenda de consultorio día</h2>
<center>
<script language="javascript">
<?php
if($val == 'f')
	echo "alert('Existe un conflicto en los horarios. Verifique e intente nuevamente!!');";
?>
</script>
<table width="100%" class="tabla_form">
<tr><td>
<table width="100%" class="tabla_interna">
<tr><th colspan="2">Agregar disponibilidad de agenda - <?=$consultorio['consultorio']?></th></tr>
<tr><td width="80%">
<strong>Hora inicio:</strong>&nbsp;
<select name="hora_inicio" id="hora_inicio">
<?php
for($i=$hora_inicio;$i<$hora_fin;$i++)
{
?>
<option value="<?=$i?>"><?=str_pad($i,2,'0',STR_PAD_LEFT)?></option>
<?php
}
?>
</select>:
<select name="min_inicio" id="min_inicio">
<?php
for($i=0;$i<60;$i++)
{
?>
<option value="<?=$i?>"><?=str_pad($i,2,'0',STR_PAD_LEFT)?></option>
<?php
}
?>
</select>
&nbsp;
<strong>Hora fin:</strong>&nbsp;
<select name="hora_fin" id="hora_fin">
<?php
for($i=$hora_inicio;$i<$hora_fin;$i++)
{
?>
<option value="<?=$i?>"><?=str_pad($i,2,'0',STR_PAD_LEFT)?></option>
<?php
}
?>
</select>:
<select name="min_fin" id="min_fin">
<?php
for($i=0;$i<60;$i++)
{
?>
<option value="<?=$i?>"><?=str_pad($i,2,'0',STR_PAD_LEFT)?></option>
<?php
}
?>
</select>
&nbsp;<strong>Tiempo duración consulta:</strong>&nbsp;
<select name="tiempo_consulta" id="tiempo_consulta">
<?php
$i=5;
while($i<=90)
{
?>
<option value="<?=$i?>"><?=str_pad($i,2,'0',STR_PAD_LEFT)?></option>
<?php
$i=$i+5;
}
?>
</select>
</td>
<td rowspan="2" width="20%">  <?
$data = array(	'name' => 'ad',
				'id' => 'ad',
				'value' => 'Agregar',
				'type' =>'submit');
echo form_input($data);
?></td></tr>
<tr><td><strong>Nombre del médico:</strong>&nbsp;
<input size="60" type="text" id="medico" name="medico" value="" 
onkeyup="ajax_showOptions(this,'coam/coam_agenda_consultorio/obtener_medico',event)" AUTOCOMPLETE="off">
<input type="hidden" id="medico_hidden" name="medico_ID" value="-">
</td></tr>
</table>
</td></tr>
<tr><td>
<table width="100%" class="tabla_interna">
<tr><th colspan="2">Agenda médica<?=nbs(3).str_pad($dia,2,'0',STR_PAD_LEFT)."-".$mes."-".$anno.nbs(3).$consultorio['consultorio']?></th></tr>
<?php
	foreach($agenda as $d){
?>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td class="campo" width="15%">Hora inicio:</td>
    <td><?=str_pad($d['hora_inicio'],2,'0',STR_PAD_LEFT).':'.str_pad($d['min_inicio'],2,'0',STR_PAD_LEFT)?>&nbsp;</td>
    <td rowspan="2" class="campo_centro" width="60%"><?=$d['medico']?>&nbsp;</td>
    <td rowspan="2" class="campo_centro" width="10%"><?=$d['tiempo_consulta']?>&nbsp;Mins</td>
     <td rowspan="2" width="15%">  <?
$data = array(	'name' => 'e',
				'id' => 'e',
				'onclick' => "eliminar('".$d['id']."')",
				'value' => 'Eliminar',
				'type' =>'button');
echo form_input($data);
?></td>
  </tr>
  <tr>
    <td class="campo">Hora fin:</td>
    <td><?=str_pad($d['hora_fin'],2,'0',STR_PAD_LEFT).':'.str_pad($d['min_fin'],2,'0',STR_PAD_LEFT)?>&nbsp;</td>
  </tr>
</table>
</td></tr>
<?php
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
&nbsp;
</center>
<?=form_close();?>