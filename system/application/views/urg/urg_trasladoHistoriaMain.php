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
function validarForm()
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
		
		buscarPaciente();
		}
}
///////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////


function buscarPaciente()
{
	var var_url = '<?=site_url()?>/urg/traslado_atenciones/buscar_atenciones_paciente';
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
function verAtencionesPac(id_paciente)
{
	var var_url = '<?=site_url()?>/urg/traslado_atenciones/buscar_atenciones/'+id_paciente;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('listado_atenciones').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function trasladarAtencion()
{
	var n = document.getElementsByName('operacion').length;
	var ope = document.getElementsByName('operacion');
	var operador = '';
	
	for(i=0; i <n; i++){
    	if(ope[i].checked == true){
			operador = ope[i].value;   		
		}
	}
	
	var n2 = document.getElementsByName('atencion').length;
	var aten = document.getElementsByName('atencion');
	var atencion = '';
	var cont = 0;
	
	for(i=0; i <n2; i++){
    	if(aten[i].checked == true){
			atencion = aten[i].value;   		
		}else{
			cont++;	
		}
	}
	if(n2 == cont){
		var mes = "Debe seleccionar la atención a "+operador+"!!"; 
		alert(mes);
		return false;	
	}else{
		var url = "<?=site_url('urg/traslado_atenciones/trasladar_atencion')?>";
		url = url+"/"+atencion+"/"+operador;
		document.location = url;
	}
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
<h1 class="tituloppal">Servicio de urgencias - Traslado atenci&oacute;n</h1>
<h2 class="subtitulo">Buscar atenciones de un paciete</h2>
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
$data = array(	'name' => 'buscar',
				'id' => 'buscar',
				'onclick' => 'validarForm()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);

?>
</td></tr>




<tr><td colspan='2' id='div_buscar'>

</td></tr>
<tr><td colspan='2' align="center">
<?php
$data = array(	'name' => 'regresar',
				'id' => 'regresar',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);

?>
</td></tr>
</table>

</center>
<?=form_close();?>