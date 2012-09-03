<script type="text/javascript">
slideTri = null;
botones = null;
remitido = null;
triage = null;
embarazo = null;
////////////////////////////////////////////////////////////////////////////////
function embarazoGineco()
{
	var sala = $('id_servicio').value;
	
	if(sala == 14){
		embarazo.slideIn();
	}else{
		embarazo.slideOut();
	}
}
////////////////////////////////////////////////////////////////////////////////
function blanco(num)
{
	if(num == 4)
	{
		$('just_blanco').value = '';
		$('recomendaciones').value = '';
		triage.slideIn();
	}else{
		triage.slideOut();
		$('just_blanco').value = 'NO APLICA';
		$('recomendaciones').value = 'NO APLICA';
	}
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
function SumaGlasgow()
{
	var ocu = $('resp_ocular').value;
	var ver = $('resp_verbal').value;
	var mot = $('resp_motora').value;
	var r = parseInt(ocu) + parseInt(ver) + parseInt(mot); 
	$('glasgow').value = r;	
}
////////////////////////////////////////////////////////////////////////////////
function terceroNolista(){
	slideLis.slideOut();
	slideTri.slideIn();
	document.formulario.tipo.value = 'tercero';
}
////////////////////////////////////////////////////////////////////////////////
function pacienteExiste(id_paciente)
{
	var var_url = '<?=site_url()?>/urg/triage/obtenerPaciente/'+id_paciente;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('crear_paciente').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function terceroConfirmado(id_tercero)
{
	slideLis.slideOut();
	slideTri.slideIn();
	document.formulario.tipo.value = 'paciente';
	var var_url = '<?=site_url()?>/urg/triage/obtenerTercero/'+id_tercero;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('datos_tercero').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			$('datos_triage').setStyle('height','600px');
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function comprobar()
{
	
	var p_ape = $('primer_apellido').value.length;
	var p_nom = $('primer_nombre').value.length;
	
	
	
	if(p_ape < 3 || p_nom < 3){
		alert("Debe ingresar al menos un nombre y apellido para ser verificado!!");
		return false;
	}
	
	var id_tipo_doc = $('id_tipo_documento').value;
	if(id_tipo_doc == 0)
	{
		alert("Debe seleccionar un tipo de documento válido!!");
		return false;
	}
	
	var fecha = $('fecha_nacimiento').value.length;
	if(fecha != 10){
		alert("Debe ingresar la fecha de nacimiento del paciente!!");
		return false;
	}
	
	botones.slideOut();
	var var_url = '<?=site_url()?>/urg/triage/comprobarTercero';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('lista_terceros').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function editarTercero()
{
	
	var var_url = '<?=site_url()?>/urg/triage/editarTercero';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('nombres_tercero').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function editarTerceroGuardar()
{
	var tipo_documento = $('id_tipo_documento').value;
	if(tipo_documento == 0){
		alert("Debe seleccionar un tipo de documento de la lista!!");
		return false;}
	
	var var_url = '<?=site_url()?>/urg/triage/editarTerceroGuardar';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('nombres_tercero').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function editarPaciente()
{
	var var_url = '<?=site_url()?>/urg/triage/editarPaciente';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('datos_paciente').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function editarPacienteGuardar()
{	
	var var_url = '<?=site_url()?>/urg/triage/editarPacienteGuardar';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('datos_paciente').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function calcular_edad(fecha){ 

   	//calculo la fecha de hoy 
   	hoy=new Date() 

   	//calculo la fecha que recibo 
   	//La descompongo en un array 
   	var array_fecha = fecha.split("-") 
   	//si el array no tiene tres partes, la fecha es incorrecta 
   	if (array_fecha.length!=3) 
      	 return false 

   	//compruebo que los ano, mes, dia son correctos 
   	var ano 
   	ano = parseInt(array_fecha[0]); 
   	if (isNaN(ano)) 
      	 return false 

   	var mes 
   	mes = parseInt(array_fecha[1]); 
   	if (isNaN(mes)) 
      	 return false 

   	var dia 
   	dia = parseInt(array_fecha[2]);	
   	if (isNaN(dia)) 
      	 return false 

   	//resto los años de las dos fechas 
   	edad=hoy.getFullYear() - ano - 1; //-1 porque no se si ha cumplido años ya este año 

   	//si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido 
   	if (hoy.getMonth() + 1 - mes < 0) //+ 1 porque los meses empiezan en 0 
      	 return edad 
   	if (hoy.getMonth() + 1 - mes > 0) 
      	 return edad+1 

   	//entonces es que eran iguales. miro los dias 
   	//si resto los dias y me da menor que 0 entonces no ha cumplido años. Si da mayor o igual si ha cumplido 
   	if (hoy.getUTCDate() - dia >= 0) 
      	 return edad + 1 

   	return edad
   /*	
   	$dia=date("j"); 
		$mes=date("n"); 
		$anno=date("Y"); 
		
		$dia_nac=substr($fecha_nac, 8, 2); 
		$mes_nac=substr($fecha_nac, 5, 2); 
		$anno_nac=substr($fecha_nac, 0, 4); 
		
		if($mes_nac>$mes){ 
			$calc_edad= $anno-$anno_nac - 1;
			$calc_edad_mes = 12 - ($mes_nac - $mes); 
		}else{ 
			if($mes == $mes_nac AND $dia_nac > $dia){ 
				$calc_edad= $anno-$anno_nac-1;
				$calc_edad_mes = $mes_nac - $mes;  
			}else{ 
				$calc_edad= $anno-$anno_nac;
				$calc_edad_mes = $mes - $mes_nac; 
				
			} 
		} 
		return $calc_edad; 
    }*/
} 

////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	
<?php

	if($tipo == 'n'){
?>
	var genero = $('genero').value;
       
	var annos = $('annos').value;
	
	
<?php	
	}else if($tipo == 'tercero' || $tipo == 'paciente'){
?>
       
	
	for(i=0; i <document.formulario.genero.length; i++){
    if(document.formulario.genero[i].checked){
      var genero = document.formulario.genero[i].value;}  
    }
    // verificamos que el genero se encuentre seleccionado
      if(genero != 'Femenino' && genero != 'Masculino' && genero != 'Indefinido'){
            
           alert("Debe seleccionar genero del paciente!!");
                 document.getElementById('genero').focus();
                return false;
           
        }
    
    fecha = $('fecha_nacimiento').value;
    var annos =calcular_edad(fecha);
    
<?php		
	}
?>
	var id_tipo_doc = $('id_tipo_documento').value;
	if(id_tipo_doc == 0)
	{
		alert("Debe seleccionar un tipo de documento válido!!");
                 document.getElementById('id_tipo_documento').focus();
                return false;
	}
	
	for(i=0; i <document.formulario.remitido.length; i++){
    if(document.formulario.remitido[i].checked){
      var val = document.formulario.remitido[i].value;}
    }
	if(!(val == 'SI' || val == 'NO')){
		alert("Debe seleccionar una opción en el campo Paciente remitido!!");
		return false;
	}
	
	var ten_arterial_s = $('ten_arterial_s').value;
	var ten_arterial_d = $('ten_arterial_d').value;
	
	if( parseInt(ten_arterial_s) <= parseInt(ten_arterial_d) ){
			alert('La tensión arterial sistólica debe ser mayor a la diastólica!!');
			return false;
	}
	
	var resp_ocular = $('resp_ocular').value;
	var resp_verbal = $('resp_verbal').value;
	var resp_motora = $('resp_motora').value;

	
	if(resp_ocular == 0){
		alert("Debe seleccionar un tipo de respuesta ocular!!");
		return false;}
	
	if(resp_verbal == 0){
		alert("Debe seleccionar un tipo de respuesta verbal!!");
		return false;}
	
	if(resp_motora == 0){
		alert("Debe seleccionar un tipo de respuesta motora!!");
		return false;}
	

	for(i=0; i <document.formulario.clasificacion.length; i++){
    if(document.formulario.clasificacion[i].checked){
      var val = document.formulario.clasificacion[i].value;}
    }
	
	/*if(val != 4)
	{
	*/
	
	var sala = $('id_servicio').value;	
	if(sala == 0){
	alert("Debe seleccionar una sala de espera!!");
        document.getElementById('id_servicio').focus(); 
		return false;}	
		
		if( (sala == 14) && (genero !='Femenino') )
		{
				alert('Solo esta permitido enviar pacientes de genero Femenino a la sala de espera seleccionada!!');
				document.getElementById('genero').focus();
                                return false;
		}
		
		if( (sala == 13) && (annos > 13) || (sala != 13) && (annos < 13) )
		{
				alert('La edad del paciente no coincide con sala de espera seleccionada!!');
                                document.getElementById('id_servicio').focus(); 
				return false;
		}
	//}
     if((id_tipo_doc == 1) &&(annos < 18) || (id_tipo_doc == 2) &&(annos < 18))
	{
		alert("Debe seleccionar un tipo de documento válido para la edad del paciente!!");
                    document.getElementById('id_tipo_documento').focus();  
		return false;
	}   
     

	if(!(val == 1 || val == 2 || val == 3 || val == 4)){
		alert("Debe seleccionar un tipo de clasificación de paciente!!");
		document.getElementById('clasificacion4').focus(); 
                return false;
	}
	
	
		
	return true;	
}
///////////////////////////////////////////////

function paciente_remitido(val)
{
	if(val == 'NO')
		remitido.slideOut();
	if(val == 'SI')
		remitido.slideIn();
}

function esFechaValida(fecha){
    if (fecha != undefined && fecha != "" ){
        
		if (!/^\d{2}\-\d{2}\-\d{4}$/.test(fecha)){
	
			return false;
        }

   		var dia  =  parseInt(fecha.substring(8),10);
        var mes  =  parseInt(fecha.substring(5,7),10);
        var anio =  parseInt(fecha.substring(0,4),10);
 
    switch(mes){
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            numDias=31;
            break;
        case 4: case 6: case 9: case 11:
            numDias=30;
            break;
        case 2:
            if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
            break;
        default:
            alert("Fecha introducida errÃ³nea");
            return false;
    }
 
        if (dia>numDias || dia==0){
            alert("Fecha introducida errÃ³nea");
            return false;
        }
        return true;
    }
}

function comprobarSiBisisesto(anio){
if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
    return true;
    }
else {
    return false;
    }
}

////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
 slideTri = new Fx.Slide('datos_triage');
 
 remitido = new Fx.Slide('div_remitido');
 remitido.hide();
 
 embarazo = new Fx.Slide('div_embarazo');
 embarazo.hide();
 
 triage = new Fx.Slide('t_blanco');
 triage.hide();

<?php
	if($tipo == 'tercero')
	{
		echo "slideTri.hide();";
	}
?>			 
});
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - TRIAGE</h1>
<h2 class="subtitulo">Registro de TRIAGE</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Informaci&oacute;n de la atenci&oacute;n</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/triage/crearTriage_',$attributes);
echo form_hidden('fecha_ini_triage',date('Y-m-d H:i:s'));
echo form_hidden('reingreso',$reingreso);
echo form_hidden('id_atencion',$id_atencion);
echo form_hidden('tipo',$tipo);

	//$d['entidad'] = $entidad;
	$d['tipo_documento'] = $tipo_documento;
if($tipo == 'n'){
	echo $this -> load -> view('urg/urg_tri_consulta_tercero',$tercero);
	echo '<div id="datos_triage">';
	echo $this -> load -> view('urg/urg_tri_consulta_paciente',$paciente);	
}else if($tipo == 'paciente' ){
	echo $this -> load -> view('urg/urg_tri_consulta_tercero',$tercero);
	echo '<div id="datos_triage">';
	echo $this -> load -> view('urg/urg_tri_crear_paciente',$d);	
}else if($tipo == 'tercero'){
	echo $this -> load -> view('urg/urg_tri_crear_tercero',$d);
	echo '<div id="datos_triage">';
	echo $this -> load -> view('urg/urg_tri_crear_paciente',$d);	
}
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr><td class='campo'>Paciente remitido:</td>
<td>
Si&nbsp;<input name="remitido" id="remitido" type="radio" value="SI" onchange="paciente_remitido('SI')"/>&nbsp;
No&nbsp;<input name="remitido" id="remitido" type="radio" value="NO" onchange="paciente_remitido('NO')"/>
<div id="div_remitido"><br />
Entidad remitente:&nbsp;
<select name="codigo_entidad" id="codigo_entidad">
  <option value="0">-Seleccione una-</option>
<?php
	foreach($entidades_remision as $d)
	{
		echo '<option value="'.$d['codigo_entidad'].'">'.$d['nombre'].'</option>';
	}
?>
</select>
</div>
</td>
</tr>
<tr>
<td width="40%" class='campo'>Motivo de la consulta:</td>
<td width="60%">
<?=form_textarea(array('name' => 'motivo_consulta',
								'id'=> 'motivo_consulta',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo'>Antecedentes:</td>
<td><?=form_textarea(array('name' => 'antecedentes',
								'id'=> 'antecedentes',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr>
<td colspan="2">
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="text-align:center">
<tr><td colspan="5" class="campo_centro">
Signos vitales
</td></tr>
<tr>
<td width="20%">Frecuencia cardiaca</td>
<td width="20%">Frecuencia respiratoria</td>
<td width="20%">Tensi&oacute;n arterial</td>
<td width="20%">Temperatura</td>
<td width="20%">Pulsioximetr&iacute;a (SPO2)</td>
</tr>
<tr>
<td><?=form_input(array('name' => 'frecuencia_cardiaca',
							'id'=> 'frecuencia_cardiaca',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('frecuencia_cardiaca','0','400')"
							))?> X min</td>
<td><?=form_input(array('name' => 'frecuencia_respiratoria',
							'id'=> 'frecuencia_respiratoria',
							'onChange' => "vNum('frecuencia_respiratoria','0','100')",
							'maxlength' => '3',
							'size'=> '3'
							))?>   X min</td>
<td><b>S</b><?=nbs().form_input(array('name' => 'ten_arterial_s',
							'id'=> 'ten_arterial_s',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('ten_arterial_s','0','350')"))?>
                           <?=br()?><b>D</b><?=nbs().form_input(array('name' => 'ten_arterial_d',
							'id'=> 'ten_arterial_d',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('ten_arterial_d','0','250')"))?></td>
<td><?=form_input(array('name' => 'temperatura',
							'id'=> 'temperatura',
							'maxlength' => '4',
							'size'=> '4',
							'onChange' => "vNum('temperatura','20','45')"))?> &deg;C</td>
<td><?=form_input(array('name' => 'spo2',
							'id'=> 'spo2',
							'maxlength' => '4',
							'size'=> '4',
							'onChange' => "vNum('spo2','0','100')"))?> %</td>
</table>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="text-align:center">
<tr><td colspan="3" class="campo_centro">
Escala Glasgow 
<input size="2" id="glasgow" type="text" value="0" disabled="disabled" maxlength="2"/>&nbsp;/&nbsp;15
</td></tr>
<tr>
<td>Respuesta ocular:&nbsp;
<select name="resp_ocular" id="resp_ocular" onchange="SumaGlasgow()">
<option value="0" selected="selected">-Seleccione-</option>
<option value="1">1 - No Respuesta</option> 
<option value="2">2 - A Dolor</option>
<option value="3">3 - A Ordenes</option>
<option value="4">4 - Espontanea</option>
</select></td>
<td>Respuesta verbal:&nbsp;
<select name="resp_verbal" id="resp_verbal" onchange="SumaGlasgow()">
<option value="0" selected="selected">-Seleccione-</option>
<option value="1">1 - Ninguna</option>
<option value="2">2 - Sonido Incomprensible</option>
<option value="3">3 - Respuesta Inadecuada</option>
<option value="4">4 - Confuso</option>
<option value="5">5 - Orientado</option>
</select></td>
<td>Respuesta motora:&nbsp;
<select name="resp_motora" id="resp_motora" onchange="SumaGlasgow()">
<option value="0" selected="selected">-Seleccione-</option>
<option value="1">1 - Ninguna</option>
<option value="2">2 - Extensión</option>
<option value="3">3 - Flexion</option>
<option value="4">4 - Retira a Estimulo</option>
<option value="5">5 - Localiza al Estimulo</option>
<option value="6">6 - Obedece</option>
</select></td>
</tr>
</table>
<br />
</td></tr>
<tr>
<tr><td class='campo'>Sala de espera:</td>
<td>
<select name="id_servicio" id="id_servicio" onchange="embarazoGineco()">
  <option value="0">-Seleccione una-</option>
  <option value="12">Urgencias Adultos</option>
  <option value="13">Urgencias Pediátricas</option>
  <option value="14">Urgencias Ginecobstétricas</option>
  <option value="15">Urgencias Psiquiátricas</option>
</select></td></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="div_embarazo">
<tr>
<td width="30%" class="campo">Paciente embarazada:</td>
<td width="70%">
<input name="embarazo" id="embarazo" type="radio" value="SI"/>SI&nbsp;&nbsp;&nbsp;
<input name="embarazo" id="embarazo" type="radio" value="NO" checked="checked"/>NO
</td>
</tr>
</table>
</td></tr>
<tr>
<td class='campo'>Clasificaci&oacute;n:</td>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:right">
  <tr height="50px">
    <td>Rojo:</td>
    <td class="triage_rojo"><input name="clasificacion" id="clasificacion1" type="radio" value="1" onChange='blanco(1)' /></td>
    <td>Amarillo:</td>
    <td class="triage_amarillo"><input name="clasificacion" id="clasificacion2" type="radio" value="2" onChange='blanco(2)' /></td>
    <td>Verde:</td>
    <td class="triage_verde"><input name="clasificacion" id="clasificacion3" type="radio" value="3" onChange='blanco(3)' /></td>
    <td>Blanco:</td>
    <td class="triage_blanco"><input name="clasificacion" id="clasificacion4" type="radio" value="4" onChange='blanco(4)' /></td>
  </tr>
</table>
</td></tr>
<tr><td colspan='2'>
<table id='t_blanco'>
		<tr>

<td width="40%" class='campo'>Justificación no admisión:</td>
			<td width="60%"><?=form_textarea(array('name' => 'just_blanco',
								'id'=> 'just_blanco',
								'class'=>"fValidate['required']",
								'value' => 'NO APLICA',
								'rows' => '5',
								'cols'=> '60'))?></td>
			
		</tr>
		<tr>

<td width="40%" class='campo'>Recomendaciones:</td>
			<td width="60%"><?=form_textarea(array('name' => 'recomendaciones',
								'id'=> 'recomendaciones',
								'class'=>"fValidate['required']",
								'value' => 'NO APLICA',
								'rows' => '5',
								'cols'=> '60'))?></td>
			
		</tr>
</table>
</td>
</tr>
		
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
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>
