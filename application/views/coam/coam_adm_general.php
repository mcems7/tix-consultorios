</tr>
<tr><td  class="campo">Contrato:</td><td id="div_contrato">
<select name="id_contrato" id="id_contrato">
    <option value="0">-Seleccione uno-</option>   
    </select></td></tr>  
<tr><td  class="campo">Consultorio:</td><td >
<select name="id_consultorio" id="id_consultorio">
    <option value="0">-Seleccione uno-</option>
<?php
	foreach($consultorios as $d)
	{
		echo '<option value="'.$d['id_consultorio'].'">'.$d['consultorio'].'</option>';	
	}
?>      
    </select></td></tr>
<tr><td class="campo" width="40%">Origen de la atenci&oacute;n:</td>
<td width="60%">
<select name="id_origen" id="id_origen" onchange="verificar_entidad()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
	foreach($origen as $d)
	{		
		echo '<option value="'.$d['id_origen'].'">'.$d['origen'].'</option>';
	}
?>
</select>
</td>
</tr>
<tr><td class="campo" width="40%">Responsable de pago:</td>
<td id="responsable_pago">
</td>
</tr>
<tr>
    <td class="campo">Observaciones admisión:</td>
    <td><?=form_textarea(array('name' => 'observaciones_adm',
								'id'=> 'observaciones_adm',
								'value' => '',
								'rows' => '3',
								'cols'=> '50'))?></td>
  </tr>