<script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{

	var glucometria =$('glucometria').value;
	var insulina =$('insulina').value;
	var via_administracion =$('via_administracion').value;

	if(glucometria == 0)
		{
		    alert('Debe ingresar un dato para la glucometria!!');
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
echo form_open('/urg/sv_enfermeria/crearNotaGlucometria_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">



<tr>
  <td colspan="6" class="campo_centro">
 Glucometria
</td></tr>
<tr>
<td rowspan="4"> 
<strong>HORA</strong> <br><br>
<? 


if (date("G")>2 && date("G")<=23)
{
		for ($i=date("G")-3;$i<=date("G");$i++){
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

<td width="40%">Glucometria</td>
<td width="40%">Insulina &nbsp;&nbsp; Via </td>
</tr>
<tr>


<td><?=form_input(array('name' => 'glucometria',
							'id'=> 'glucometria',
							'maxlength' => '4',
							'size'=> '4',
							'autocomplete'=>'off',
							))?> mg/dl</td>

<td><?=form_input(array('name' => 'insulina',
							'id'=> 'insulina',
							'maxlength' => '4',
							'size'=> '4',
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
