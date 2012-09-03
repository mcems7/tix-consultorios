<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	
 var exValidatorA = new fValidator("formulario");		 
});
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
	echo form_open('/coam/coam_admision/buscarPaciente',$attributes);
?>
<center>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Admisión de un paciente</h2>

<table width="70%" class="tabla_form">
<tr><th colspan="2">Paciente a ser ingresado al sistema</th></tr>
<tr><td width="50%" class="campo">Número de documento del paciente:</td>
<td width="50%"><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['nit']"))?>
</td></tr>
<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Buscar')?></td></tr>
</table>
</center>
<?=form_close().br();?>
<table width="100%" class="tabla_form">
<tr><th>Listado pacientes activos</th></tr>
<tr><td>
<table width="100%" class="tabla_interna" cellpadding="5">
<tr>
<td class='campo_centro'>No.</td>
<td class='campo_centro'>Fecha y hora de llegada</td>
<td class='campo_centro'>Nombre e identificación del paciente</td>
<td class='campo_centro'>Consultorio</td>
<td class='campo_centro'>Estado</td>
<td class='campo_centro'>Opciones</td>
</tr>
<?php
$n = count($lista);
if($n>0)
{
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr class="fila">
<td align="center"><strong><?=$i?></strong></td>
<input type='hidden' name='id_estado<?=$d['id_atencion']?>' id='id_estado<?=$d['id_atencion']?>' value='<?=$d['id_estado']?>' />
<?php 
$res = $this->lib_tiempo->alerta($d['fecha_ingreso'],'3');
?>
<td>	
<?=$d['fecha_ingreso']?>
</td>
<td><strong>
<?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></strong><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?></td>
 <td align="center">
<?=$d['consultorio']?>
</td>
<td align="center">
<?php
echo $d['estado'];
?>
</td>
<td class="opcion">
<?=anchor('coam/coam_admision/editar_admision/'.$d['id_atencion'], 'Editar', 'title="Editar"');?>
 </td>
</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="6" align="center">No hay pacientes en la sala de espera del consultorio</td></tr>
<?php
}
?>
</table>
</td>
</tr>
</table>