<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Consultar orden médica</h2>
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
<td class="campo">Dieta:</td><td>
<?php
	foreach($ordenDietas as $data)
	{

	foreach($dietas as $d)
	{
		if($data['id_dieta'] == $d['id_dieta'])
		{
			echo $d['dieta'].br();
		}
	}
}
?>
</td></tr>
<tr><td class="campo">Posición de la cama:</td>
<td>
Cabezera:&nbsp;<strong><?=$orden['cama_cabeza']?></strong>&nbsp;Grados&nbsp;&nbsp;&nbsp;
Pie de cama:&nbsp;<strong><?=$orden['cama_pie']?></strong>&nbsp;Grados&nbsp;                         
</td></tr>
<tr><td class="campo">Suministro de Oxigeno:</td>
    <td><?=$orden['oxigeno']?>
<?php
	if($orden['oxigeno'] == 'SI')
	{
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Tipo de Oxigeno a suministrar:</td>
    <td><?=$orden['tipoO2']?>
</td>
  </tr>
  <tr>
    <td>Cocentración de oxigeno:</td>
    <td><?=$orden['valorO2']?>  
    </td>
  </tr>
</table>
<?php
	}
?>
<tr>
    <td class="campo">Suministro de líquidos:</td>
    <td>
<?=$orden['liquidos']?>
</td></tr>
<tr><th colspan="2" id="mosAgrCui">Cuidados generales y enfermería:</th></tr>
<tr><td colspan="2">
<?php
	foreach($ordenCuid as $d)
	{
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia_cuidado']);
		$d['cuidado'] = $this->urgencias_model->obtenerCuidadoDetalle($d['id_cuidado']);
		echo $this->load->view('urg/urg_ordInfoConCuidado',$d);
	}
?>  
</td></tr>
<tr>
    <td class="campo">Otros cuidados:</td>
    <td><?=$orden['cuidados_generales']?></td></tr>
<tr>
  <th colspan="2">Medicamentos</th></tr>
<tr>
<tr>
  <td colspan="2">
<?php
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		echo $this->load->view('urg/urg_ordInfoConMedicamento',$d);
	}
?>  
  </td></tr> 

<tr>
  <th colspan="2">Insumos y Dispositivos Medicos</th></tr>
<tr>
<tr>
  <td colspan="2">
<?php //print_r($ordenInsumos);die();
  foreach($ordenInsumos as $d)
  {
    
    echo $this->load->view('urg/urg_ordInfoConInsumos',$d);
  }
?>  
  </td></tr> 



<tr>
  <th colspan="2">Procedimientos y ayudas diagnosticas</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">
<?php
	foreach($ordenCups as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('urg/urg_ordInfoConProcedimiento',$d);
	}

foreach($ordenCupsLaboratorios as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('urg/urg_ordInfoConProcedimiento',$d);
	}


foreach($ordenCupsImagenes as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('urg/urg_ordInfoConProcedimiento',$d);
	}

?>
  </div>
  </td></tr>
<tr>
<?php
	if($medico['id_tipo_medico'] == '1')
	{
?>
<tr><td colspan="2" id="div_verificar">
<?=$this->load->view('urg/urg_ordConfirm')?>
</td></tr>
<?php
	}else{
		echo form_hidden('verificado','SI');
		echo form_hidden('id_medico_verifica',$medico['id_medico']);
		echo form_hidden('fecha_verificado',date('Y-m-d H:i:s'));
	}
?>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/hospi_impresion/consultarOrden/'.$orden['id_orden'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>
</div>
<br />
</td></tr></table>
