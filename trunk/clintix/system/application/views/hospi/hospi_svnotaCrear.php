
<script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{

 var ten_arterial_s = $('ten_arterial_s').value;
	var ten_arterial_d = $('ten_arterial_d').value;
	var frecuencia_cardiaca = $('frecuencia_cardiaca').value;
	var frecuencia_respiratoria = $('frecuencia_respiratoria').value;

	var temperatura = $('temperatura').value;
	var spo2 = $('spo2').value;
	var fraccion_inspirada_oxigeno =$('fraccion_inspirada_oxigeno').value;
	
	var insulina =$('insulina').value;
	var via_administracion =$('via_administracion').value;
	
	
	
	
	if (frecuencia_cardiaca == '')
	{
		alert('debe ingresar un valor para la frecuencia cardiaca!!');
			return false;
	}
	if (frecuencia_respiratoria == '')
	{
		alert('debe ingresar un valor para la frecuencia respiratoria!!');
			return false;
	}
	
	
	
	if (ten_arterial_s == '')
	{
		alert('debe ingresar un valor para la tensión arterial sistolica!!');
			return false;
	}
	
	if (ten_arterial_d == '')
	{
		alert('debe ingresar un valor para la tensión arterial distolica!!');
			return false;
	}
	
	
		if (temperatura == '')
	{
		alert('debe ingresar un valor para la temperatura!!');
			return false;
	}
	
		if (fraccion_inspirada_oxigeno == '')
	{
		alert('debe ingresar un valor para FiO2!!');
			return false;
	}
		if (spo2 == '')
	{
		alert('debe ingresar un valor para s02!!');
			return false;
	}
	
	
	if( parseInt(ten_arterial_s) <= parseInt(ten_arterial_d) ){
			alert('La tensión arterial sistólica debe ser mayor a la diastólica!!');
			return false;
	}
	
	
	if(insulina != '')
	{
		if(via_administracion == 0)
		{
		    alert('Debe seleccionar la via de administracion de la insulina!!');
			return false;
		}
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
echo form_open('/hospi/hospi_sv_enfermeria/crearNota_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
?>




<table width="100%" border="0" cellspacing="2" cellpadding="2">



<tr><td colspan="6" class="campo_centro">
Signos vitales
</td></tr>
<tr>
<td rowspan="6"> 
<strong>HORA</strong> <br><br>
<? 


if (date("G")>2 && date("G")<=23)
{
		for ($i=date("G")-1;$i<=date("G");$i++){
		$options[$i]=$i;	}
}else{
	$options = array(
                  '23' => '23',
                  '0'  => '0',
				  '1'  => '1',
                  '2'  => '2',
				  
				   
                );
	}
echo form_dropdown('hora', $options);


?>



</td>
<td width="18%">Frecuencia cardiaca</td>
<td width="18%">Frecuencia respiratoria</td>
<td width="18%">Tensi&oacute;n arterial</td>
<td width="18%">Temperatura</td>
<td width="18%">FiO2</td>


</tr>
<tr>

<td><?=form_input(array('name' => 'frecuencia_cardiaca',
							'id'=> 'frecuencia_cardiaca',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',
							'class' => "fValidate['integer']",
							'onChange' => "vNum('frecuencia_cardiaca','0','400')"
							))?> Lpm</td>
<td><?=form_input(array('name' => 'frecuencia_respiratoria',
							'id'=> 'frecuencia_respiratoria',
							'autocomplete'=>'off',
							'onChange' => "vNum('frecuencia_respiratoria','0','100')",
							'maxlength' => '2',
							'size'=> '2'
							))?> Rpm</td>
<td><b>S</b><?=nbs().form_input(array('name' => 'ten_arterial_s',
							'id'=> 'ten_arterial_s',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',
							'onChange' => "vNum('ten_arterial_s','0','350')"))?>
                           <?=br()?><b>D</b><?=nbs().form_input(array('name' => 'ten_arterial_d',
							'id'=> 'ten_arterial_d',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',
							'onChange' => "vNum('ten_arterial_d','0','250')"))?> </td>
<td><?=form_input(array('name' => 'temperatura',
							'id'=> 'temperatura',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',
							'onChange' => "vNum('temperatura','30','45')"))?> &deg;C</td>
<td><?=form_input(array('name' => 'fraccion_inspirada_oxigeno',
							'id'=> 'fraccion_inspirada_oxigeno',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',))?> %</td>

                            
                            <tr>

<tr><td colspan="7" class="linea_azul"></td></tr>       
<tr>
<td width="18%">Pulsioximetr&iacute;a (SO2)</td>
<td width="18%">Peso</td>
<td width="18%">Glucometria</td>
<td width="18%">Insulina &nbsp;&nbsp; Via </td>
</tr>
<tr>

<td><?=form_input(array('name' => 'spo2',
							'id'=> 'spo2',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',
							'onChange' => "vNum('spo2','0','100')"))?> %</td>
                            <td><?=form_input(array('name' => 'peso',
							'id'=> 'peso',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off', ))?> Kg</td>
<td><?=form_input(array('name' => 'glucometria',
							'id'=> 'glucometria',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',
							))?> mg/dl</td>

<td><?=form_input(array('name' => 'insulina',
							'id'=> 'insulina',
							'maxlength' => '3',
							'size'=> '3',
							'autocomplete'=>'off',))?> Ui  <select name="via_administracion" id="via_administracion">
    <option value="0">--</option>
      <option value="SC">SC</option>
      <option value="EV">EV</option>
    </select></td>

                            
                            <tr>                        
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
