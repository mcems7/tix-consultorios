<?php $this -> load -> view('impresion/inicio'); ?>

<h4>DESPACHO DE MEDICAMENTOS</h4>
<h5>Datos del paciente</h5>
<table width="100%" id="interna">
  <tr>
    <td class="negrita" width="25%">Apellidos:</td>
    <td class="centrado" width="25%"><?=$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
    <td class="negrita" width="25%">Nombres:</td>
    <td class="centrado" width="25%"><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']?></td>
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
    <td class="centrado" ><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
  </tr>
  <tr>
  <td class="negrita">Servicio:</td><td class="centrado"><?=$atencion['nombre_servicio']?></td>
  <td class="negrita">Cama:</td><td class="centrado">
<?=$cama['numero_cama']?>
  </td></tr>
  <tr>
  <td class="negrita">Fecha y hora orden:</td>
  <td class="centrado"><?=$orden['fecha_creacion']?></td>
  <td class="negrita">Número orden:</td>
  <td class="centrado"><?=$orden['id_orden']?></td>
  </tr>
</table>
<h5>Medicamentos despachados</h5>

<table id="interna">
	<tr>
    <td class="negrita centrado" width="300px">Medicamento</td>
    <td class="negrita centrado" width="57px">Dosis</td>
    <td class="negrita centrado" width="57px">Unidad</td>
    <td class="negrita centrado" width="57px">Frecuencia</td>
    <td class="negrita centrado" width="57px">Estado</td>
    <td class="negrita centrado" width="57px">V&iacute;a</td>
    <td class="negrita centrado" width="57px">Obs.<br />Ord.</td>
    <td class="negrita centrado" width="57px">Despacho</td>
    <td class="negrita centrado" width="57px">Obs.<br />Des.</td>
  </tr>
<?php
	foreach($ordenMedi as $d)
	{
		
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc_despa']);
		
?>
  <tr>
    <td class="centrado" style="text-align:left"><?=$d['medicamento']?></td>
    <td class="centrado"><?=$d['dosis']?></td>
    <td class="centrado"><?=$d['unidad']?></td>
    <td class="centrado"><?="Cada ".$d['frecuencia']." ".$d['uni_frecuencia']?></td>
    <td class="centrado"><?=$d['estado']?></td>
    <td class="centrado"><?=$d['via']?></td>
    <td class="centrado"><?=$d['observacionesMed']?></td>
    <td class="centrado"><?=$d['despachoMed']?> : <?=$d['cantidadMed']?></td>
    <td class="centrado"><?=$d['observacionMed']?></td>
  </tr>
<?php
	}
?>
</table>
<h5>Insumos y Dispositivos M&eacute;dicos</h5>
<table id="interna">
  <tr>
    <td class="negrita centrado" width="300px">Insumo</td>
    <td class="negrita centrado" width="80px">Despacho</td>
    <td class="negrita centrado" width="80px">Cant<br />Soli</td>
    <td class="negrita centrado" width="80px">Cant<br />Desp</td>
    <td class="negrita centrado" width="80px">Obs.<br />Ord</td>
    <td class="negrita centrado" width="80px">Obs.<br />Desp</td> 
  </tr>
<?php
	foreach($ordenInsu as $d)
	{
?>
  <tr>
    <td class="centrado" style="text-align:left"><?=$d['insumo']?></td>
    <td class="centrado"><?=$d['despacho']?></td>
    <td class="centrado"><?=$d['cantidad']?></td>
    <td class="centrado"><?=$d['cantidad_despachada']?></td>
		<td class="centrado"><?=$d['observaciones']?></td> 
    <td class="centrado"><?=$d['obsDespacho']?></td>    
  </tr>
<?php
	}
?>
</table>
<?php $this -> load -> view('impresion/fin'); ?>
