<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	
 var exValidatorA = new fValidator("formulario");		 
});
////////////////////////////////////////////////////////////////////////////////
function dato()
{
	var id_tipo_doc = $('numero_documento').value;
	var primer_apellido = $('primer_apellido').value;
	var primer_nombre = $('primer_nombre').value;
	var segundo_nombre = $('segundo_nombre').value;
	var segundo_apellido = $('segundo_apellido').value;

	if(id_tipo_doc == 0 && primer_apellido == 0 && segundo_apellido == 0 && primer_nombre == 0 && segundo_nombre == 0)

	{
   	    
		alert("Ingrese un dato para realizar la busqueda!!");

                

                return false;

	}else {
		
		buscar();
		}
}
///////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////


function buscar()
{
	var var_url = '<?=site_url()?>/hce/main/buscar_atenciones_paciente';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_buscar').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$this->load->helper('form');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
	echo form_open('',$attributes);
?>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Buscar un paciente en el sistema</h2>
<center>
<table width="90%" class="tabla_form">
<tr><th colspan="2">Buscar paciente</th></tr>
<tr><td width="50%" class="campo">Número de documento del paciente:</td>
<td width="50%"><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['nit']"))?>
</td></tr>
<tr>
    <td width="50%" class="campo">Primer apellido:</td>
    <td width="50%"><?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'maxlength'   => '20',
					'size'=> '20'))?>	</td>
  </tr>
   <tr>
    <td class="campo">Segundo apellido:</td>
    <td><?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20',
					'size'=> '20'))?>	</td>
  </tr>
  <tr>
    <td class="campo">Primer nombre:</td>
    <td><?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20'))?></td>
  </tr>
   <tr>
    <td class="campo">Segundo nombre:</td>
    <td><?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20'))?></td>
  </tr>

<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
echo nbs();
$data = array(	'name' => 'bb',
				'id' => 'bb',
				'onclick' => 'dato()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>




<tr><td colspan='2' id='div_buscar'>

</td></tr>

</table>
<div id="div_buscar">

</div>
</center>
<?=form_close();?>
