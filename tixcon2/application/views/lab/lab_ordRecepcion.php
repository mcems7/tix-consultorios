<script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////


function validarFormulario()
{

	var crechazo = $('codigo_rechazo').value;
    var elementos = document.getElementsByName("rechazo");
 
    var aprobado = elementos[0].checked;
	var rechazado = elementos[1].checked; 
	if (rechazado == false && aprobado == false){
			alert ("Debe seleccionar un estado");
			document.getElementById('rechazo').focus();
			return false;
		}
		
	if (rechazado == true && crechazo == 0){
			alert ("Debe seleccionar un tipo de rechazo");
			document.getElementById('codigo_rechazo').focus();
			return false;
		}
	
	
	
  if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////




</script>
<?php
$attributes = array('id'       => 'formulario',
                    'name'     => 'formulario',
                    'method'   => 'post',
                    'onsubmit' => 'return validarFormulario()');
echo form_open('lab/laboratorio/registraRecepcionLab_',$attributes);

?> 

<h1 class="tituloppal">Laboratorio Clinico</h1>
<h2 class="subtitulo">Orden De Examenes</h2>
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
<tr><td class="campo">Peso:</td><td><?php $peso=$this->laboratorio_model->obtenerConsulta($atencion['id_atencion']); echo $peso['peso']; ?></td>
<td class="campo">Ingreso Dinamica:</td><td><?=$atencion['ingreso']?></td></tr>
<tr></tr>
</table>
</td></tr>

<tr>
  <th colspan="2">Orden médica de Examenes de Laboratorio</th></tr>
<tr>
  <td colspan="2">
<?php 

  foreach($laboratorio as $d)
  {
          echo $this->load->view('lab/lab_ordInfoConOrdenes',$d);
  }
?>  
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
