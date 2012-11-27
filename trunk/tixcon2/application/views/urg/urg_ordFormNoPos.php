<?php
$marca = mt_rand();
?>
<?=form_hidden('atcNoPos[]',$atc);?>
<table width="100%" class="tabla_registro">
<tr><td colspan="2" class="campo_centro">Medicamento NO POS solicitado</td></tr>
<tr><td class="campo"  width="40%">Principio activo:</td>
<td  width="60%"><?=$pos['principio_activo']?><?=form_hidden($cont.'atcNoPos',$atc);?></td></tr>
<tr><td class="campo">Grupo terapéutico:</td>
<td><?=$pos['grupos']?></td></tr>
<tr><td class="campo">Forma farmacéutica y concentración:</td>
<td><?=$pos['descripcion']?></td></tr>
<tr><td class="campo">Días tratamiento:</td>
<td><?=form_input(array('name' => 'dias_tratamiento[]',
						'id'=> 'dias_tratamiento[]',
						'maxlength' => '3',
						'value' => '0',
						'class' => "fValidate['integer']",
						'size'=> '3'))?></td></tr>
<tr><td class="campo">Dosis diaria:</td>
<td><?=form_input(array('name' => 'dosis_diaria[]',
						'id'=> 'dosis_diaria[]',
						'maxlength' => '5',
						'value' => '0',
						'class' => "fValidate['real']",
						'size'=> '5'))?></td></tr>
<tr><td class="campo">Cantidad total por mes:</td>
<td><?=form_input(array('name' => 'cantidad_mes[]',
						'id'=> 'cantidad_mes[]',
						'maxlength' => '5',
						'value' => '0',
						'class' => "fValidate['real']",
						'size'=> '5'))?></td></tr>
<tr>
<td class="campo">Ventajas del medicamento solicitado sobre los otros de la misma categoría farmacológica incluidos en el POS:</td>
<td>
<?=form_textarea(array('name' => 'ventajas[]',
								'id'=> 'ventajas[]',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr>
<td colspan="2" style="background:#F5F7F2; padding:0px">
<div id="div<?=$marca?>">

</div>
<?php
	$noPos = $this->urgencias_model->obtenerSustitutosPos($pos['atc_full']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="campo">Medicamento POS que se remplaza o sustituye</td>
    <td>
    <?=form_hidden('cont',$cont);?>
    <select name="<?=$cont?>atc_pos" id="<?=$cont?>atc_pos">
      <option value="0">-Seleccione uno-</option>
    <?php
	foreach($noPos as $data)
	{
		echo "<option value='".$data['atc_full']."'>",$data['principio_activo']," ", $data['descripcion'],"</option>";
	}
?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="campo">Dias de tratamiento:</td>
    <td><?=form_input(array('name' => $cont.'dias_tratamientoPos',
						'id'=> $cont.'dias_tratamientoPos',
						'maxlength' => '3',
						'value' => '0',
						'class' => "fValidate['integer']",
						'size'=> '3'))?></td>
  </tr>
  <tr>
    <td class="campo">Dosis diaria:</td>
    <td><?=form_input(array('name' => $cont.'dosis_diariaPos',
						'id'=> $cont.'dosis_diariaPos',
						'maxlength' => '5',
						'value' => '0',
						'class' => "fValidate['real']",
						'size'=> '5'))?></td>
  </tr>
    <tr>
    <td class="campo">Cantidad total por mes:</td>
    <td><?=form_input(array('name' => $cont.'cantidad_mes',
						'id'=> $cont.'cantidad_mes',
						'maxlength' => '5',
						'value' => '0',
						'class' => "fValidate['integer']",
						'size'=> '5'))?></td>
  </tr>
   <tr>
    <td class="campo">Respuesta clinica observada:</td>
    <td><p>
        <input type="radio" name="<?=$cont?>resp_clinica" value="No mejora" id="<?=$cont?>resp_clinica" checked="checked" />
        No mejora&nbsp;&nbsp;
        <input type="radio" name="<?=$cont?>resp_clinica" value="Reacción adversa" id="<?=$cont?>resp_clinica" />
        Reacción adversa</p>
        Cual:<?=form_input(array('name' => $cont.'resp_clinica_cual',
						'id'=> $cont.'resp_clinica_cual',
						'maxlength' => '100',
						'value' => ' ',
						'class' => "fValidate['alphanum']",
						'size'=> '40'))?></td>
  </tr>
 <tr>
    <td class="campo">Contraindicación:</td>
    <td><p>
        <input type="radio" name="<?=$cont?>contraindicacion" value="SI" id="<?=$cont?>contraindicacion" />
        Si&nbsp;&nbsp;
        <input type="radio" name="<?=$cont?>contraindicacion" value="NO" id="<?=$cont?>contraindicacion" checked="checked" />
        No</p>
        Cual:<?=form_input(array('name' => $cont.'contraindicacion_cual',
						'id'=> $cont.'contraindicacion_cual',
						'maxlength' => '100',
						'value' => ' ',
						'class' => "fValidate['alphanum']",
						'size'=> '40'))?></td>
  </tr>
  <tr> <td colspan="2">
<center>
<?
$data = array(	'name' => 'ba',
				'onclick' => "agregarMedPos('".$marca."','".$cont."')",
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>
</td></tr> 
</table>

</td>
</tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr>
<td class="campo">Justificación del riesgo inminente para la vida y la salud del usuario si no es administrado el medicamento NO POS:</td>
<td>
<?=form_textarea(array('name' => 'justificacion[]',
								'id'=> 'justificacion[]',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
                               
</table>