<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
///////////////////////////////////////////////////////////////////////////////
function agregarMedPos(id_div,cont)
{
	if(!validarMedi(cont))
	{
		return false;
	}
		
	var div = "div"+id_div;
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarPosSustituto';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $(div).get('html');
		$(div).set('html',html2, html);
		$('div_precarga').style.display = "none";},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarMedicamento(id_tabla)
{	
	if(confirm('¿Desea eliminar el medicamento seleccionado?'))
		$(id_tabla).dispose();	
}

////////////////////////////////////////////////////////////////////////////////
function validarMedi(cont)
{
	var v1 = cont+'atc_pos';
	if($(v1).value == 0 ){
		alert("Se debe seleccionar un medicamento POS que es sustituido");
		return false;
	}
	
	var v2 = cont+'dias_tratamientoPos';
	if($(v2).value == 0){
		alert("Debe ingresar los días del tratamiento");
		return false;
	}
	
	var v3 = cont+'dosis_diariaPos';
	if($(v3).value == 0){
		alert("Debe ingresar la dosis diaria");
		return false;
	}
	
	var v4 = cont+'cantidad_mes';
	if($(v4).value == 0){
		alert("Debe ingresar la cantidad total por mes");
		return false;
	}
	
	
	
	return true;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Formato de solicitud de medicamentos No POS</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/urg/ordenamiento/formatoNoPos_',$attributes);
?>
<input type="hidden" id="id_orden" name="id_orden" value="<?=$orden['id_orden']?>" />
<input type="hidden" id="id_atencion" name="id_atencion" value="<?=$atencion['id_atencion']?>" /> 
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
  <th colspan="2">Medicamentos NO POS</th></tr>
<tr>
<td class="campo">Resumen de la historia clínica:</td>
<td>

<?=form_textarea(array('name' => 'resumen_historia',
								'id'=> 'resumen_historia',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr>
  <td colspan="2">
<?php
	$cont=1;
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		$d['pos'] = $this->urgencias_model->obtenerMedicamentoPos($d['atc']);
		$d['cont'] = $cont;
		echo $this->load->view('urg/urg_ordFormNoPos',$d) ,"<br>";
		$cont++;
	}
?>  
  </td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
</td></tr></table>
<?=form_close();?>