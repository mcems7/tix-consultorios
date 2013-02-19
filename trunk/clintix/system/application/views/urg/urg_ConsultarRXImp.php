<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validar()
{
	
		//alert("Debe seleccionar una , Urbana o Rural!!");
	 var checkboxes = document.getElementById("formulario").imagenes;
	    if (checkboxes.length == null){
			checkboxes.length=1;
			}
		
     
    var cont = 0;
     
	 
	if (checkboxes.length!=1)
	{
    for (var x=0; x < checkboxes.length; x++) {
    if (checkboxes[x].checked) {
    cont = 1;
    }
    }
	}else
	 if (checkboxes.checked) {
    cont = 1;
    }
	if (cont == 0){
	alert("Debe seleccionar un procedimiento");
	return false;
	}
	
}


</script>
<h1 class="tituloppal">Servicio dew urgencias</h1>
<h2 class="subtitulo"></h2>
<center>

<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validar()');
echo form_open('/impresion/impresion/ImagenesDX',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_orden',$orden);
?>
<table width="100%" class="tabla_form" style="margin-bottom:50px">

<tr>
  <th colspan="4">Observaciones</th></tr>
<tr>
   <td class="negrita">Enfermedad actual:<td>
  <td><?=form_textarea(array('name' => 'enfermedad_actual',
							'id'=> 'enfermedad_actual',
							'rows' => '5',
							'value' => $consulta['enfermedad_actual'],
							'class'=>"fValidate['required']",
							'cols'=> '45'))?></td>
  </tr>
  
  <tr>
   <td class="negrita">Analisis:<td>
  <td><?=form_textarea(array('name' => 'analisis',
							'id'=> 'analisis',
							'rows' => '5',
							'value' => $consulta['analisis'],
							'class'=>"fValidate['required']",
							'cols'=> '45'))?></td>
  </tr>
<tr>
  <th colspan="4">Procedimientos y ayudas diagnosticas</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">
<?php


foreach($ordenCupsImagenes as $d)
	{
		?>
		<tr>
<td>
<input name="imagenes[]" id="imagenes" type="checkbox" value="<?=$d['id']?>" />
</td>
<td colspan="2">		
	<?	
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('urg/urg_ordInfoConProcedimiento',$d);
	}

?>
  </div>
  </td></tr>
<tr>
<tr><td colspan="4" class="linea_azul"></td></tr> 

</div>
<br />
<tr>

<td colspan="4">
<center>

<?=form_submit('boton', 'Imprimir')?>   
</center>
</td>
</tr>              
</table>


