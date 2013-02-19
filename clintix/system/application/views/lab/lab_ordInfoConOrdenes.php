<script type="text/javascript">


function laboratorio_rechazo(val)
{
	if(val == 'NO')
		rechazo.slideOut();
	if(val == 'SI')
		rechazo.slideIn();
}

window.addEvent("domready", function(){

 
 rechazo = new Fx.Slide('div_rechazo');
 rechazo.hide();
	 
});
</script>

<?=form_hidden('cups',$cups);?>
<?=form_hidden('id_orden',$id_ordenes);?>


<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
  
  <tr>
  	<td width="100" class="campo_centro">Orden</td>
    <td width="100" class="campo_centro">Codigo</td>
    <td colspan="3"class="campo_centro">Examen</td>
    <td width="50" class="campo_centro">Cantidad</td>
  </tr>
  <tr>
  <td align="center"><?=$id_ordenes?></td>
    <td align="center"><?=$cups?></td>
    <td colspan="3" align="center"><?=$desc_subcategoria?></td>
    <td align="center"><?=$cantidadCups?></td>
  </tr>
  <tr>
    <td class="campo_centro">Observaciones:</td>
    <td class="campo_centro" colspan='5'><?=$observacionesCups?></td>
  </tr>
  
  
 <tr>
   <td class='campo_centro'>Estado:</td>
<td colspan="5">
Aprobada&nbsp;<input name="rechazo" id="rechazo" type="radio" value="NO" onchange="laboratorio_rechazo('NO')"/>&nbsp;
Rechazada&nbsp;<input name="rechazo" id="rechazo" type="radio" value="SI" onchange="laboratorio_rechazo('SI')"/>
<div id="div_rechazo"><br />
Tipo Rechazo:&nbsp;
<select name="codigo_rechazo" id="codigo_rechazo">
  <option value="0">-Seleccione una-</option>
<?php
	foreach($rechazo as $d)
	{
	echo '<option value="'.$d['id_rechazo'].'">'.$d['motivo'].'</option>';
	}
?>
</select>
</div>
</td>
</tr>
 
   <tr>
    <td width="173" class="campo_centro">Motivo:</td>
    <td colspan='5' class="campo_centro"><?=form_textarea(array('name' => 'razon',
                                                                'rows' => '3',
                                                                'cols'=> '30'))?></td>
  </tr>
</table>

  