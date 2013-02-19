<div id="nombres_tercero">
<?=form_hidden('tipo','paciente')?>
<?=form_hidden('id_tercero',$id_tercero)?>
<input type='hidden' id='id_tipo_documento' name='id_tipo_documento' value='$id_tipo_documento' />
<input type='hidden' id='annos' name='annos' value='<?=$this->lib_edad->annos($fecha_nacimiento)?>' />
<table width="100%">
<tr><td colspan="2">
<span class="boton_modificar"><a href="#" onclick="editarTercero()">Editar</a></span>
</td></tr>
<tr><td width="40%">Apellidos:</td>
<td width="60%"><?=$primer_apellido." ".$segundo_apellido?></td></tr>
<tr><td>Nombres:</td>
<td><?=$primer_nombre." ".$segundo_nombre?></td></tr>
<tr><td>Documento de identidad:</td>
<td><?=$tipo_documento.": ".$numero_documento?></td></tr>
<tr><td>Fecha de nacimiento:</td><td><?=$fecha_nacimiento?></td></tr>
<tr><td>Edad:</td><td><?=$this->lib_edad->edad($fecha_nacimiento)?></td></tr>
</table>
</div>
