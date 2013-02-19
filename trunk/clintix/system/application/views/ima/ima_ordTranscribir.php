<script type="text/javascript" src="<?=base_url()?>resources/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
  if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}

function imagen_realizada(val)
{
	if(val == 'SI')
		rechazo.slideOut();
	if(val == 'NO')
		rechazo.slideIn();
}

window.addEvent("domready", function(){

 
 rechazo = new Fx.Slide('div_rechazo');
 rechazo.hide();
	 
});

////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
                    'name'     => 'formulario',
                    'method'   => 'post',
                    'onsubmit' => 'return validarFormulario()');
echo form_open('ima/imaginologia/guardar_transcripcion',$attributes);
echo form_hidden('id',$procedimiento['id']);
echo form_hidden('id_orden',$procedimiento['id_orden']);

?> 

<h1 class="tituloppal">Imagenes Diagnosticas</h1>
<h2 class="subtitulo">Orden De Imagenologia</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Peso:</td><td><?php $peso=$this->imagenologia_model->obtenerConsulta($atencion['id_atencion']); echo $peso['peso']; ?></td>
<td class="campo">Ingreso Dinamica:</td><td><?=$atencion['ingreso']?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Fecha y hora de la orden:</td><td><?=date('Y-m-d H:i:s')?></td></tr>
<tr><td class="campo" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr><td class="campo">Servicio:</td><td><?php $servicio=$this->imagenologia_model->obtenerInfoServicio($atencion['id_servicio']); echo $servicio['nombre_servicio']; ?></td></tr>
<tr><td class="campo">Cama:</td><td><?php $cama=$this->imagenologia_model->obtenerCamaFarmacia($atencion['id_atencion']); echo $cama['numero_cama']; ?></td></tr>
<tr><td class="campo">Diagnostico(s):</td><td><?php $diagnostico=$this->imagenologia_model->obtenerDxFarmacia($atencion['id_atencion']); 

foreach($diagnostico as $d)
  {
    echo $d['diagnostico']; echo "";?> <br> <?php } ?></td></tr>
<tr><td class="campo">Asegurador:</td><td><?php $entidad=$this->imagenologia_model->obtenerNombreEntidad($atencion['id_paciente']); echo $entidad['razon_social']; ?></td></tr>
<tr>
  <th colspan="2">Orden Médica de Imagenes Diagnosticas</th></tr>
<tr>
  <td colspan="2">
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
  
  <tr>
    <td width="100" class="campo_centro">Codigo</td>
    <td colspan="4"class="campo_centro">Examen</td>
  </tr>
  <tr>
    <td align="center"><?=$procedimiento['cups']?></td>
    <td colspan="4" align="center"><?=$procedimiento['desc_subcategoria']?></td>
   
  </tr>
  <tr>
    <td class="campo_centro">Observaciones:</td>
    <td class="campo_centro" colspan='4'><?=$procedimiento['observacionesCups']?></td>
  </tr>
   <tr>
   <td class='campo_centro'>Realizado:</td>
<td colspan="5">
Si&nbsp;<input name="realizado" id="realizado" type="radio" value="SI" onchange="imagen_realizada('SI')"/>&nbsp;
No&nbsp;<input name="realizado" id="realizado" type="radio" value="NO" onchange="imagen_realizada('NO')"/>
<div id="div_rechazo"><br />
Tipo Rechazo:&nbsp;
<?=form_textarea(array('name' => 'motivo',
						 'rows' => '7',
						'cols'=> '25'))?>

</div>
</td>
</tr>
    
 
    <tr>
    <td class="campo_centro">Informe:</td>
    <td colspan='4' class="campo_centro">
	 <textarea cols="70" id="informe" name="informe" rows="35"></textarea>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'informe',{toolbar : 'Basic',uiColor : '#CCCCCC'});
CKFinder.SetupCKEditor( editor, '/pt/resources/js/ckfinder/' ) ;
</script>
	</td>
  </tr>
</table> 
  </td></tr> 
                               
</table>
<center>
<?
$data = array(  'name' => 'bv',
        'onclick' => 'regresar()',
        'value' => 'Volver',
        'type' =>'button');
echo form_input($data);
?>
<?=form_submit('boton', 'Guardar')?>
<?=form_close();?>
</center>
</div>
<br />
</td></tr></table>
