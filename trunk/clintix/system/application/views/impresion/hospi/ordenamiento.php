<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Unidad de Cuidados Intensivos - Orden M&eacute;dica del paciente</h4>
<h5>Datos del paciente</h5>
<table id="interna">
  <tr>
    <td class="negrita">Apellidos:</td>
    <td class="centrado"><?=$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
    <td class="negrita">Nombres:</td>
    <td class="centrado"><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Documento de identidad:</td>
    <td class="centrado"><?=$tercero['tipo_documento'].' '.$tercero['numero_documento']?></td>
    <td class="negrita">G&eacute;nero:</td>
    <td class="centrado"><?=$paciente['genero']?></td>
  </tr>
  <tr>
    <td class="negrita">Fecha de nacimiento:</td>
    <td class="centrado"><?=$tercero['fecha_nacimiento']?></td>
    <td class="negrita">Edad:</td>
    <td class="centrado"><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
  </tr>
</table>
<h5>Datos de la atenci&oacute;n del paciente</h5>
<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora de la orden:</td>
    <td class="centrado"><?=$orden['fecha_creacion']?></td>
    <td class="negrita">M&eacute;dico tratante:</td>
    <td class="centrado"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Tipo m&eacute;dico:</td>
    <td class="centrado"><?=$medico['tipo_medico']?></td>
    <td class="negrita">Especialidad:</td>
    <td class="centrado"><?=$medico['especialidad']?></td>
  </tr>
</table>
<h5>Datos de la orden m&eacute;dica</h5>
<table id="interna">
<tr>
  <td class="negrita">Dieta:</td>
  <td class="centrado">
  <?php
	foreach($ordenDietas as $data)
	{
		foreach($dietas as $d)
		{
			if($data['id_dieta'] == $d['id_dieta'])
			{
				echo $d['dieta']." ";
			}
		}
	}
  ?>
  </td>
  <td class="negrita">Posici&oacute;n de la cama:</td>
  <td class="centrado">
	Cabecera: <strong><?=$orden['cama_cabeza']?></strong> Grados<br/>
	Pie de cama: <strong><?=$orden['cama_pie']?></strong> Grados   
  </td>
</tr>
<tr>
  <td class="negrita">Suministro de Oxigeno:</td>
  <td class="centrado">
<?php
	if($orden['oxigeno'] == 'SI')
	{
?>
		Tipo de Oxigeno a suministrar:	<strong><?=$orden['tipoO2']?></strong>
		Cocentraci&oacute;n de oxigeno: <strong><?=$orden['valorO2']?></strong>
<?php
	}
	else
		echo $orden['oxigeno'];
?>
  </td>
  <td class="negrita">Suministro de l&iacute;quidos:</td>
  <td class="centrado"><?=$orden['liquidos']?></td>
</tr>
</table>
<h5>Datos de los cuidados generales y enfermer&iacute;a</h5>
<table id="interna">
<?php
	foreach($ordenCuid as $d)
	{
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia_cuidado']);
		$d['cuidado'] = $this->urgencias_model->obtenerCuidadoDetalle($d['id_cuidado']);
?>  
  <tr>
    <td class="negrita" style="width:15%">Cuidado:</td>
    <td class="centrado" style="width:35%"><?=$d['cuidado']?></td>
    <td class="negrita" style="width:15%">Frecuencia:</td>
    <td class="centrado" style="width:35%"><?="Cada ".$d['frecuencia_cuidado']." ".$d['uni_frecuencia']?></td>
  </tr>
<?php
	}
?>
  <tr>
    <td class="negrita">Otros cuidados:</td>
    <td colspan="3"><?=$orden['cuidados_generales']?></td>
  </tr>
</table>
<h5>Datos de los medicamentos</h5>
<table id="interna">
<?php
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
?>
  <tr>
    <td class="negrita centrado">Medicamento</td>
    <td class="negrita centrado">Estado</td>
    <td class="negrita centrado">Dosis</td>
    <td class="negrita centrado">Unidad</td>
    <td class="negrita centrado">Frecuencia</td>
    <td class="negrita centrado">V&iacute;a</td>
  </tr>
  <tr>
    <td class="centrado"><?=$d['medicamento']?></td>
    <td class="centrado"><?=$d['estado']?></td>
    <td class="centrado"><?=$d['dosis']?></td>
    <td class="centrado"><?=$d['unidad']?></td>
    <td class="centrado"><?="Cada ".$d['frecuencia']." ".$d['uni_frecuencia']?></td>
    <td class="centrado"><?=$d['via']?></td>
  </tr>
  <tr>
    <td class="negrita">Observaciones:</td>
    <td class="centrado" colspan="4"><?=$d['observacionesMed']?></td>
  </tr>
<?php
	}
?>
</table>
<h5>Insumos y Dispositivos M&eacute;dicos</h5>
<table id="interna">
  <tr>
    <td class="negrita centrado" style="width:30%">Insumo:</td>
    <td class="negrita centrado" style="width:30%">Cantidad:</td>
    <td class="negrita centrado" style="width:40%">Observaciones:</td> 
  </tr>
<?php
	foreach($ordenInsumos as $d)
	{
?>
  <tr>
    <td class="centrado"><?=$d['insumo']?></td>
    <td class="centrado"><?=$d['observaciones']?></td>
    <td class="centrado"><?=$d['cantidad']?></td>
  </tr>
<?php
	}
?>
</table>
<h5>Procedimientos y ayudas diagn&oacute;sticas</h5>
<table id="interna">
  <tr>
    <td class="negrita centrado" style="width:30%">Procedimiento:</td>
    <td class="negrita centrado" style="width:30%">Cantidad:</td>
    <td class="negrita centrado" style="width:40%">Observaciones:</td>
  </tr>
<?php
	foreach($ordenCups as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>
  <tr>
    <td class="centrado"><?=$d['procedimiento']?></td>
    <td class="centrado"><?=$d['cantidadCups']?></td>
    <td class="centrado"><?=$d['observacionesCups']?></td>
  </tr>
<?php
	}
?>
<?php
	foreach($ordenCupsLaboratorios as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>
  <tr>
    <td class="centrado"><?=$d['procedimiento']?></td>
    <td class="centrado"><?=$d['cantidadCups']?></td>
    <td class="centrado"><?=$d['observacionesCups']?></td>
  </tr>
<?php
	}
?>
<?php
	foreach($ordenCupsImagenes as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>
  <tr>
    <td class="centrado"><?=$d['procedimiento']?></td>
    <td class="centrado"><?=$d['cantidadCups']?></td>
    <td class="centrado"><?=$d['observacionesCups']?></td>
  </tr>
<?php
	}	
	
?>
</table>

<?php $this -> load -> view('impresion/fin'); ?>
