<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	//document.location = "<?php //echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	
 var exValidatorA = new fValidator("formulario");		 
});
////////////////////////////////////////////////////////////////////////////////
function dato()
{

        var pin = $('pin2').value;

	if(pin == '')

	{
   	    
		alert("Ingrese un dato para realizar la busqueda!!");
                return false;

	}else {
		
		buscar();
		}
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function buscar()
{
       var var_url = '<?=site_url()?>/citas/cambios_cita/buscar';
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

function validar()
{
    if(confirm('Se procederá a realizar el cambio de entidad ¿Esta seguro que desea continuar?')){
		cambiar();
		}
	    else{ 
    return false;
		}
}

function cambiar()
{
       var var_url = '<?=site_url()?>/citas/cambios_cita/modificar_entidad';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario2').toQueryString(),
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
<h2 class="subtitulo">Buscar cita en el sistema</h2>
<center>
<table width="90%" class="tabla_form">
<tr><th colspan="2">Buscar cita</th></tr>
<tr><td width="50%" class="campo_izquierda">PIN:</td>
<td width="50%"><?=form_input(array('name' => 'pin2',
							'id'=> 'pin2',
							'maxlength'   => '20',
							'size'=> '20',
							))?>
</td></tr>


<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bb',
				'id' => 'bb',
				'onclick' => 'dato()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);


echo form_close();
?>
</td></tr>
<tr><td colspan='2' id='div_buscar'>
</td></tr>

</table>
<div id="div_buscar">

</div>
</center>
