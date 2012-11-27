<script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{

 var ten_arterial_s = $('ten_arterial_s').value;
	var ten_arterial_d = $('ten_arterial_d').value;
	
	if( parseInt(ten_arterial_s) <= parseInt(ten_arterial_d) ){
			alert('La tensión arterial sistólica debe ser mayor a la diastólica!!');
			return false;
	}
	
  if (confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}
////////////////////////////////////////////////////////////////////////////////
</script>


<center>


<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/sv_enfermeria/crearNota_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">



<tr><td colspan="6" class="campo_centro">
Signos vitales
</td></tr>
<tr>
<td width="16%">Frecuencia cardiaca</td>
<td width="16%">Frecuencia respiratoria</td>
<td width="16%">Tensi&oacute;n arterial</td>
<td width="16%">Temperatura</td>
<td width="16%">Pulsioximetr&iacute;a (SPO2)</td>
<td width="16%">Peso </td>
</tr>
<tr>
<td><?=form_input(array('name' => 'frecuencia_cardiaca',
							'id'=> 'frecuencia_cardiaca',
							'maxlength' => '3',
							'size'=> '3',
							'class' => "fValidate['integer']",
							'onChange' => "vNum('frecuencia_cardiaca','0','400')"
							))?> X min</td>
<td><?=form_input(array('name' => 'frecuencia_respiratoria',
							'id'=> 'frecuencia_respiratoria',
							'onChange' => "vNum('frecuencia_respiratoria','0','100')",
							'maxlength' => '3',
							'size'=> '3'
							))?>   X min</td>
<td><b>S</b><?=nbs().form_input(array('name' => 'ten_arterial_s',
							'id'=> 'ten_arterial_s',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('ten_arterial_s','0','350')"))?>
                           <?=br()?><b>D</b><?=nbs().form_input(array('name' => 'ten_arterial_d',
							'id'=> 'ten_arterial_d',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('ten_arterial_d','0','250')"))?></td>
<td><?=form_input(array('name' => 'temperatura',
							'id'=> 'temperatura',
							'maxlength' => '4',
							'size'=> '4',
							'onChange' => "vNum('temperatura','20','45')"))?> &deg;C</td>
<td><?=form_input(array('name' => 'spo2',
							'id'=> 'spo2',
							'maxlength' => '4',
							'size'=> '4',
							'onChange' => "vNum('spo2','0','100')"))?> %</td>
<td><?=form_input(array('name' => 'peso',
							'id'=> 'peso',
							'maxlength' => '4',
							'size'=> '4' ))?> Kg</td>                            
                            <tr>

<tr><td colspan="6" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data);
?>

&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr>
