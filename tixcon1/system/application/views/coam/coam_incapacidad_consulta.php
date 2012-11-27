<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Consulta incapacidad de un paciente</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo" colspan="2">&nbsp;</td></tr>
</table>
</td>
</tr>

<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo">Motivo de consulta:</td>
<td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Enfermedad actual:</td>
<td colspan="3"><?=$consulta['enfermedad_actual']?>&nbsp;</td>
</tr>
   <tr>
  <td class="campo">Diagn&oacute;sticos consulta:</td>
  <td colspan="3">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta';
}
?>
  </td></tr>
</table>
</td>
</tr>
<tr><th colspan="2" id="opciones">Incapacidad</th></tr>
 <tr>
    <td class="campo">Médico que incapacita:</td>
    <td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?>&nbsp;</td>
    </tr>
<tr>
<td class="campo">Fecha incapacidad:</td>
<td><?=$inca['fecha_incapacidad']?></td>
</tr>
<tr>
<td class="campo">Fecha de inicio incapacidad:</td>
<td><?=$inca['fecha_inicio']?></td>
</tr>
<tr>
<td class="campo">Duración incapacidad:</td>
<td><?=$inca['duracion'].nbs()?>(D&iacute;as)
</td>
</tr>
<tr>
<td class="campo">Observación:</td>
<td><?=$inca['observacion']?></td>
</tr>
<tr><td class="linea_azul" colspan="2"></td></tr>      
<tr><td align="center" colspan="2">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/coam/incapacidad/'.$inca['id_incapacidad'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);

?>
</td></tr>
</table>
</center>