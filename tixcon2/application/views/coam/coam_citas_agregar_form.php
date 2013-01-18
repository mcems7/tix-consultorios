<?=form_hidden('hora',$hora);?>
<table width="100%" class="tabla_interna">
<tr><th colspan="4" colspan="2">Información de la cita (Hora: <?=date("H:i",$hora)?>)</th></tr>
<tr>
<td width="25%" class="campo_centro">Primer apellido</td>
<td  width="25%" class="campo_centro">Segundo apellido</td>
<td class="campo_centro"  width="25%">Primer nombre</td>
<td class="campo_centro" width="25%">Segundo nombre:</td>
</tr><tr>
<td class="campo_centro">
<?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'class'=>"fValidate['alphanumtilde']",
					'maxlength'   => '20',
					'size'=> '20'))?></td>
<td class="campo_centro">
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?>	
	</td>

    
    <td class="campo_centro">
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"
					))?></td>
    
    <td class="campo_centro">
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?>
    </td>
  </tr>
<tr><td class="campo">Tipo documento:</td>
<td>
<select name="id_tipo_documento" id="id_tipo_documento">
<?
foreach($tipo_documento as $d)
{
	echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';
}
?>
</select>
</td><td class="campo">Número documento:</td>
<td><?=form_input(array('name' => 'numero_documento',
					'id'=> 'numero_documento',
					'maxlength'   => '20',
					'size'=> '20'))?></td></tr>
<tr><td class="campo">Entidad:</td>
<td colspan="4"><select name="id_entidad" id="id_entidad">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($entidad as $d)
{
	echo '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';
}
?>
</select></td></tr>
<tr><td align="center" colspan="4">
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'agregarCita()',
				'value' => 'Agregar cita',
				'type' =>'button');
echo form_input($data);
?>
  </td></tr>
</table>