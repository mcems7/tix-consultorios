<script language="javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Consultar agenda de consultorio día</h2>
<center>
<table width="100%" class="tabla_form">
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
    <td width="15%"><?=str_pad($d['hora_inicio'],2,'0',STR_PAD_LEFT).':'.str_pad($d['min_inicio'],2,'0',STR_PAD_LEFT)?>&nbsp;</td>
    <td rowspan="2" class="campo_centro" width="70%"><?=$d['medico'].br()."Especialidad: ".$d['descripcion']?>&nbsp;</td>
    <td rowspan="2" class="campo_centro" width="10%"><?=$d['tiempo_consulta']?>&nbsp;Mins</td>
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