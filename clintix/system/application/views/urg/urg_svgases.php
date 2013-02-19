<script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////
function validarFormulario2()
{

  var ph = $('ph').value;
  var paco2 = $('paco2').value;
  var pao2 = $('pao2').value;
  var hco3 = $('hco3').value;
  var sao2 = $('sao2').value;
  var BE = $('BE').value;
  var fraccion_inspirada_oxigeno = $('fraccion_inspirada_oxigeno').value;
	
	
	
	if (ph == '')
	{
		alert('debe ingresar un valor para el PH!!');
			return false;
	}
	
	if (paco2 == '')
	{
		alert('debe ingresar un valor para paco2!!');
			return false;
	}
	if (pao2 == '')
	{
		alert('debe ingresar un valor para pao2!!');
			return false;
	}

	if (hco3 == '')
	{
		alert('debe ingresar un valor para hco3!!');
			return false;
	}
		if (sao2 == '')
	{
		alert('debe ingresar un valor para sao2!!');
			return false;
	}
	
		if (BE == '')
	{
		alert('debe ingresar un valor para BE!!');
			return false;
	}
		if (fraccion_inspirada_oxigeno == '')
	{
		alert('debe ingresar un valor para la fraccion inspirada oxigeno!!');
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
$attributes = array('id'       => 'formulario2',
	                'name'     => 'formulario2',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario2()');
echo form_open('/urg/sv_enfermeria/crearNotaGases_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">



<tr><td colspan="6" class="campo_centro">
Gases Arteriales
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
                  '23'  => '23',
                  '0'    => '0',
				  '1'  => '1',
                  '2'    => '2',
				  
				   
                );
	}
echo form_dropdown('hora', $options);


?>



</td>
<td width="20%">PH</td>
<td width="20%">PaCO2</td>
<td width="20%">PaO2</td>
<td width="20%">HCO3</td>
<td width="20%">OBSERVACION</td>


</tr>
<tr>
<td><?=form_input(array('name' => 'ph',
							'id'=> 'ph',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',
							'class' => "fValidate['integer']"
							))?> </td>
<td><?=form_input(array('name' => 'paco2',
							'id'=> 'paco2',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',
							'class' => "fValidate['integer']",
						
							))?> </td>
<td><?=form_input(array('name' => 'pao2',
							'id'=> 'pao2',
							'maxlength' => '4',
							'autocomplete'=>'off',
							'size'=> '4'
							))?> </td>
<td><?=nbs().form_input(array('name' => 'hco3',
							'id'=> 'hco3',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',))?>
                          </td>
<td rowspan="6"><?=nbs().form_textarea(array('name' => 'observacion',
							'id'=> 'observacion',
							'rows'=> '4',
							'cols'=> '17',
							'autocomplete'=>'off',))?>
                          </td>


                            
                            <tr>

<tr><td colspan="4" class="linea_azul"></td></tr>       
<tr>
<td width="20%">SaO2</td>

<td width="20%">BE</td>
<td width="20%">FiO2</td>




</tr>
<tr>
<td><?=form_input(array('name' => 'sao2',
							'id'=> 'sao2',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',
							))?></td>


<td><?=form_input(array('name' => 'BE',
							'id'=> 'BE',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',
							))?> </td>
<td><?=form_input(array('name' => 'fraccion_inspirada_oxigeno',
							'id'=> 'fraccion_inspirada_oxigeno',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',))?> </td>


                            
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
