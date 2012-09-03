<?php
echo $this->load->view('util/util_orden_js');
echo $this->load->view('util/util_cups_js');
?>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
var sMed = null;
var sPro = null;
slideO2 = null;
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
	slideO2 = new Fx.Slide('div_oxigeno');
	slideO2.hide();
});
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
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Unidad de hospitalizaci&oacute;n</h1>
<h2 class="subtitulo">Nueva orden m&eacute;dica</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Informaci&oacute;n del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/hospi/hospi_ordenamiento/crearOrden_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('fecha_ini_ord',date('Y-m-d H:i:s'));
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Fecha y hora de la orden:</td><td><?=date('Y-m-d H:i:s')?></td></tr>
<tr><td class="campo" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr>
  <th colspan="2">Orden médica</th></tr>
<tr>
<td class="campo" rowspan="2">Dieta:</td>
<td id="div_lista_dietas">

</td>
</tr>
<tr>
<td>
<center>
<select id="id_dieta_" name="id_dieta_">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
foreach($dietas as $d)
{
	echo '<option value="'.$d['id_dieta'].'">'.$d['dieta'].'</option>';
}
?>
</select>
<?
$data = array(	'name' => 'bv',
				'onclick' => "agregarDieta()",
				'value' => 'Agregar',
				'type' =>'button');
echo nbs(),form_input($data);
?>
</center>
</td></tr>
<tr><td class="campo">Posición de la cama:</td>
<td>
Cabecera:&nbsp;<?=form_input(array('name' => 'cama_cabeza',
							'id'=> 'cama_cabeza',
							'maxlength'   => '3',
							'size'=> '3',
							'value' => '0',
							'onChange' => "vNum('cama_cabeza','0','90')",
							'class' => "fValidate['integer']"))?>Grados&nbsp;&nbsp;&nbsp;
Pie de cama:&nbsp;<?=form_input(array('name' => 'cama_pie',
							'id'=> 'cama_pie',
							'maxlength'   => '3',
							'size'=> '3',
							'value' => '0',
							'onChange' => "vNum('cama_pie','0','45')",
							'class' => "fValidate['integer']"))?>Grados&nbsp;                         
</td></tr>
<tr><td class="campo">Suministro de Oxigeno:</td>
    <td>SI&nbsp;<input name="oxigeno" id="oxigeno" type="radio" value="SI" onchange="tipoOxigeno('SI')" />
    NO&nbsp;<input name="oxigeno" id="oxigeno" type="radio" value="NO" checked="checked" onchange="tipoOxigeno('NO')" />
    <div id="div_oxigeno">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Tipo de Oxigeno a suministrar:</td>
    <td><select name="id_oxigeno" id="id_oxigeno" onchange="saturacionOxigeno()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($o2 as $d)
{
	echo '<option value="'.$d['id_oxigeno'].'">'.$d['oxigeno'].'</option>';
}
?>
</select></td>
  </tr>
  <tr>
    <td>Concentración de oxigeno:</td>
    <td id="tipo_oxigeno">
    <select name="id_oxigeno_valor" id="id_oxigeno_valor">
<option value="0" selected="selected">-Seleccione uno-</option>
</select>
    
    </td>
  </tr>
</table>

    <br />
</div>
<tr>
    <td class="campo">Suministro de líquidos:</td>
    <td>SI&nbsp;<input name="liquidos" id="liquidos" type="radio" value="SI" />
    NO&nbsp;<input name="liquidos" id="liquidos" type="radio" value="NO" checked="checked"/></td></tr>
<tr><th colspan="2" id="mosAgrCui">Cuidados generales y enfermería:</th></tr>
<tr><td colspan="2">
<div id="div_lista_cuidados">
  
</div>
</td></tr>
<tr><td colspan="2">
<?=$this->load->view('urg/urg_ordAgreCuidados',$med)?>
</td></tr>
<tr>
    <td class="campo">Otros cuidados:</td>
    <td><?=form_textarea(array('name' => 'cuidados_generales',
							'id'=> 'cuidados_generales',
							'rows' => '5',
							'cols'=> '45'))?></td></tr>
<tr>
  <th colspan="2" id="mosAgrMed">Medicamentos</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_medicamento">
  
  </div>
  </td></tr>
<tr>
  <td colspan="2">
  <?=$this->load->view('util/util_orden_medicamento',$med)?>
  </td></tr>
<tr>
  <th colspan="2" id="mosAgrPro">Procedimientos y ayudas diagnosticas</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">
  
  </div>
  </td></tr>
  <tr><td class='campo_centro' colspan='2'>Procedimientos y servicios comunes de Urgencias</td></tr>
  <tr>
  <td class='campo_centro'>Tipo de procedimiento</td><td class='campo_centro'>Procedimiento</td>
  <tr>
  <td>
  <select name="id_tipo" id="id_tipo" onchange="tipoCups()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($tipo_cups as $d)
{
	echo '<option value="'.$d['id_tipo'].'">'.$d['nombre_tipo'].'</option>';
}
?>
</select>
  
  </td><td id='div_cupsUrge'>
  <select name="id_subcategoriaUrg" id="id_subcategoriaUrg">
  <option value="0" selected="selected">-Seleccione uno-</option>
  </select>
  </td>
  </tr>
  
 <tr><td colspan="2">
<table width="100%" cellspacing="0" cellpadding="0">

<tr><td class="campo" width="20%">Observaciones:</td>
<td width="80%"><?=form_textarea(array('name' => 'observacionesCups',
							'id'=> 'observacionesCups',
							'rows' => '5',
							'cols'=> '45'))?></td></tr>
</table>
</td></tr>
  
                        
                            
  
  <tr><td colspan ='2'>
  <center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarProcecimientoUrg()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center></td>
  </tr>
  <tr><td colspan="2" class="linea_azul"></td></tr> 
  <tr>
  <td colspan="2">
  <div id="agregarPro">
  <?=$this->load->view('util/util_cups_simple')?>
  </div>
  <center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarProcecimiento()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>
  </td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>