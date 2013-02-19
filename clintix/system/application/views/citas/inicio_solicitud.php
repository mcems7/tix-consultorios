<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<script type="text/javascript">
<?=isset($tercero)?'yaCargo=false;':'yaCargo=true;'?>
slideTri = null;
botones = null;
remitido = null;
triage = null;
////////////////////////////////////////////////////////////////////////////////
/*function blanco(num)
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
}*/
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
function terceroNolista()
{
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
            
           // alert("Debe seleccionar genero del paciente!!");
                // document.getElementById('genero').focus();
               // return false;
           
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
	var ten_arterial_s = $('ten_arterial_s').value;
	var ten_arterial_d = $('ten_arterial_d').value;
	
	if( parseInt(ten_arterial_s) <= parseInt(ten_arterial_d) ){
			alert('La tensión arterial sistólica debe ser mayor a la diastólica!!');
			return false;
	}
	/*if(val != 4)
	{
	*/
	//}
     if((id_tipo_doc == 1) &&(annos < 18) || (id_tipo_doc == 2) &&(annos < 18))
	{
		alert("Debe seleccionar un tipo de documento válido para la edad del paciente!!");
                    document.getElementById('id_tipo_documento').focus();  
		return false;
	} 
      if($('nombre_municipio_hidden').value=="-1")
          {
              alert("Debe seleccionar un municipio válido");
                    document.getElementById('nombre_municipio_hidden').focus();  
              return false;
          }
        if($('tipo_atencion').value=="-1")
            {
                alert("Debe seleccionar la causa externa de atención");
                    document.getElementById('tipo_atencion').focus();  
              return false; 
            }
        if($('tipo_afiliado').value=="-1")
            {
                alert("Debe seleccionar el tipo de afiliado");
                    document.getElementById('tipo_afiliado').focus();  
              return false; 
            }
          if($('id_entidad').value=="0")
            {
                alert("Debe seleccionar la entidad responsable del pago");
                    document.getElementById('id_entidad').focus();  
              return false; 
            }
         if($('id_cobertura').value=="0")
            {
                alert("Debe seleccionar el tipo de usuario");
                    document.getElementById('id_cobertura').focus();  
              return false; 
            }
         if($('estado_civil').value=="0")
            {
                alert("Debe seleccionar el estado civil");
                    document.getElementById('estado_civil').focus();  
              return false; 
            }
        if($('id_entidad_remitente').value=="0")
            {
                alert("Debe seleccionar la entidad que remite");
                    document.getElementById('id_entidad_remitente').focus();  
              return false; 
            }
         if(confirm('Se procederá a realizar la operación ¿Esta seguro que desea continuar?'))
            return true;     
	return false;	
}
///////////////////////////////////////////////
function municipios()
{
    
}
///////////////////////////////////////////////////////////////////////////////
/*function paciente_remitido(val)
{
	if(val == 'NO')
		remitido.slideOut();
	if(val == 'SI')
		remitido.slideIn();
}*/

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
function cargar_municipios()
{
    	if(!yaCargo)
            {
                yaCargo=true;
                return
            }
        var var_url = '<?=site_url()?>/citas/solicitar_cita/municipios/'+$('nombre_departamento_hidden').value;
	var ajax1 = new Request(
	{
		url: var_url,
		onSuccess: function(html){
                    $('nombre_municipio').set('html',html);
                },
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function mostrar(valor)
{
  if(valor.value=='prioritaria')
        html='<td class="campo_izquierda">Justificación Cita Prioritaria:</td>'+
        '<td><?=form_textarea(array('name' => 'justificacion_prioridad',
								'id'=> 'justificacion_prioridad',
								'rows' => '5',
								'class'=>'fValidate["required"]',
								'cols'=> '50'))?></td>';
    else
        html='';
    $('justificacion_prioritaria').set('html',html);
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
 slideTri = new Fx.Slide('datos_triage');
 <?php
 if(isset($tercero))
     echo "cargar_municipios(-1);";
 ?>
 //remitido = new Fx.Slide('div_remitido');
 //remitido.hide();
 
 /*triage = new Fx.Slide('t_blanco');
 triage.hide();*/

<?php
	if($tipo == 'tercero')
	{
		echo "slideTri.hide();";
	}
?>			 
});
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de Consulta Externa - Solicitud Cita</h1>
<h2 class="subtitulo">Registro de Solicitud Cita </h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Informaci&oacute;n de la atenci&oacute;n</th></tr>
<tr><td>
<?php
$attributes = array('id'=>'formulario',
	            'name'=> 'formulario',
		    'method'=>'post',
		    'onsubmit'=>'return validarFormulario()');
echo form_open('/citas/solicitar_cita/generar_solicitud',$attributes);
echo form_hidden('fecha_solicitud',date('Y-m-d H:i:s'));
//echo form_hidden('reingreso',$reingreso);
echo form_hidden('id_atencion',$id_atencion);
echo form_hidden('tipo',$tipo);
echo form_hidden('pin',$pin);

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
  <tr>
    <td class="campo_izquierda">Estado civil:</td>
<?php
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
if(isset($paciente))
{
    if($paciente['estado_civil'] == 'Soltero'){
            $res1 = 'selected="selected"';
    }else if($paciente['estado_civil'] == 'Casado'){
            $res2 = 'selected="selected""';
    }else if($paciente['estado_civil'] == 'Viudo'){
            $res3 = 'selected="selected"';
    }else if($paciente['estado_civil'] == 'Union libre'){
            $res4 = 'selected="selected"';
    }
}
?>
    <td><select name="estado_civil" id="estado_civil">
    <option value="0">-Seleccione uno-</option>
      <option value="Soltero" <?=$res1?>>Soltero</option>
      <option value="Casado" <?=$res2?>>Casado</option>
      <option value="Viudo" <?=$res3?>>Viudo</option>
      <option value="Union libre" <?=$res4?>>Unión libre</option>
    </select></td>
  </tr>
  <tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr><td class="campo_izquierda">Tipo usuario:</td>
<td><select name="id_cobertura" id="id_cobertura">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_usuario as $d)
{
	if($paciente['id_cobertura'] == $d['id_cobertura'] ){
	echo '<option value="'.$d['id_cobertura'].'" selected="selected">'.$d['cobertura'].'</option>';
	}else{
	echo '<option value="'.$d['id_cobertura'].'">'.$d['cobertura'].'</option>';
	}
}
?>
</select></td></tr>
<tr><td class="campo_izquierda">Entidad Encargada del Pago:</td>
<td>
    <select name="id_entidad" id="id_entidad" style="font-size:9px">
        <option value="0" selected="selected">-Seleccione uno-</option>
        <?php
        foreach($entidades_remision as $d)
        {
            
            if($paciente['id_entidad'] == $d['id_entidad'] )
                echo '<option value="'.$d['id_entidad'].'" selected="selected">'.$d['nombre'].'</option>';
            else
                echo '<option value="'.$d['id_entidad'].'">'.$d['nombre'].'</option>';
            
        }
        ?>
    </select>
</td></tr>
<tr><td class="campo_izquierda">Tipo de afiliado:</td>
<?php
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
if(isset($paciente))
{
    if($paciente['tipo_afiliado'] == 'Cotizante'){
            $res1 = 'selected="selected"';
    }else if($paciente['tipo_afiliado'] == 'Beneficiario'){
            $res2 = 'selected="selected""';
    }else if($paciente['tipo_afiliado'] == 'Adicional'){
            $res3 = 'selected="selected"';
    }else if($paciente['tipo_afiliado'] == 'Particular'){
            $res4 = 'selected="selected"';
    }
}
?>
<td><select value="-1"name="tipo_afiliado" id="tipo_afiliado">
    <option value="0">-Seleccione uno-</option>
    <option value="Cotizante" <?=$res1?>>Cotizante</option>
    <option value="Beneficiario" <?=$res2?>>Beneficiario</option>
    <option value="Adicional" <?=$res3?>>Adicional</option>
      <option value="Particular" <?=$res4?>>Particular</option>
</select></td></tr>
<tr><td class="campo_izquierda">Nivel o categoria:</td>
<td>
<?=form_input(array('name' => 'nivel_categoria',
                                'id'=> 'nivel_categoria',
                                'maxlength' => '2',
                                'class'=>"fValidate['required']",
                                'size'=> '2',
                                'value' => isset($paciente)?$paciente['nivel_categoria']:''))?>
</td></tr>
<tr><td class="campo_izquierda">Desplazado:</td>
<?php
$res1 = '';
$res2 = '';
if(!isset($paciente))
    $res2 = 'checked="checked"';
else if($paciente['desplazado'] == 'SI'){
	$res1 = 'checked="checked"';
}else if($paciente['desplazado'] == 'NO'){
	$res2 = 'checked="checked"';
}
?>
<td>Si&nbsp;<input name="desplazado" id="desplazado" type="radio" value="SI" <?=$res1?>/>
    No&nbsp;<input name="desplazado" id="desplazado" type="radio" value="NO" <?=$res2?>/></td>
</tr>  
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr>
    <td class="campo_izquierda">Barrio / Vereda:</td>
    <td><?=form_input(array('name' => 'vereda',
                            'id'=> 'vereda',
                            'maxlength' => '200',
                            'size'=> '40',
                            'class'=>"fValidate['alphanumtilde']",
                            'value' => isset($tercero)?$tercero['vereda']:''))?>
    </td>
  </tr>
  <tr>
    <td class="campo_izquierda">Zona:</td>
     <?php
	$res1 = '';
	$res2 = '';
        if(!isset($tercero))
            $res1 = 'checked="checked"';
        else if($tercero['zona'] == "Rural")
	{
		$res2 = 'checked="checked"';
	}else{
		$res1 = 'checked="checked"';
	}
	?>
    <td>Urbana&nbsp;<input name="zona" id="zona" type="radio" value="Urbana" <?=$res1?> />
    Rural&nbsp;<input name="zona" id="zona" type="radio" value="Rural" <?=$res2?>/></td>
  </tr>
  <tr>
<td class='campo_izquierda'>Dirección Residencia:</td>
<td><?=form_input(array('name' => 'direccion',
                        'id'=> 'direccion',
                        'class'=>"fValidate['required']",
                        'size'=> '65',
                        'value'=>isset($tercero)?$tercero['direccion']:''))?></td></tr>
<tr>
<td class='campo_izquierda'>Celular:</td>
<td><?=form_input(array('name' => 'celular',
                        'id'=> 'celular',
                        'class'=>"fValidate['required']",
                        'size'=> '65',
                        'value'=>isset($tercero)?$tercero['celular']:''
                                            ))?></td></tr>
<tr>
<td class='campo_izquierda'>Teléfono:</td>
<td><?=form_input(array('name' => 'telefono',
								'id'=> 'telefono',
                                                                'size'=> '65',
                        'value'=>isset($tercero)?$tercero['telefono']:''))?></td></tr>

  <tr>
    <td class="campo_izquierda">Correo electrónico:</td>
    <td><?=form_input(array('name' => 'email',
							'id'=> 'email',
							'maxlength' => '60',
							'size'=> '40',
							'class'=>"fValidate['email']",
							'value' => isset($tercero)?$tercero['email']:'correo@dominio.com'))?></td>
  </tr>
<tr>
<td class='campo_izquierda' id="td_departamento">Departamento Residencia:</td>
<td>
<?=form_dropdown('nombre_departamento_hidden',$departamento,isset($tercero)?$tercero['departamento']:'','id="nombre_departamento_hidden" onchange="cargar_municipios()"')?>

</td></tr>
<tr>
<td class='campo_izquierda' >Municipio Residencia:</td>
<td id="nombre_municipio"><?=isset($tercero)?form_dropdown('nombre_municipio_hidden',$municipio,$tercero['municipio'],'id="nombre_municipio_hidden"'):''?></td></tr>
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr>
    <td class='campo_izquierda'>Prioritaria</td>
    <td>
    No Prioritaria <input id="prioridad1" type="radio" onclick="mostrar(this)" checked="checked" value="no_prioritaria" name="prioridad"></input>
    Prioritaria <input id="prioridad2" type="radio" onclick="mostrar(this)" value="prioritaria" name="prioridad"></input>
    </td>
</tr>
<tr id="justificacion_prioritaria"></tr>
<tr>
<td class='campo_izquierda'>Causa Externa de Consulta:</td>
<td><select name="tipo_atencion" id="tipo_atencion">
  <option value="-1">Seleccione una-</option>
  <option value="01">Accidente Trabajo</option>
  <option value="02">Accidente Tránsito</option>
  <option value="03">Accidente Rábico</option>
  <option value="04">Accidente Ofídico</option>
  <option value="05">Otro Accidente</option>
  <option value="06">Evento Catastrófico</option>
  <option value="07">Lesión por Agresión</option>
  <option value="08">Lesión Autoinfligida</option>
  <option value="09">Sospecha Maltrato Físico</option>
  <option value="10">Sospecha Abuso Sexual</option>
  <option value="11">Sospecha Violencia Sexual</option>
  <option value="12">Sospecha Maltr. Emocional</option>
  <option value="13">Enfermedad General</option>
  <option value="14">Enfermedad Profesional</option>
  <option value="15">Otra</option>
</select>
</td>
</tr>
<tr>
<td class='campo_izquierda'>Entidad remitente:</td>
<td><select name="id_entidad_remitente" id="id_entidad_remitente" style="font-size:9px">
  <option value="0">-Seleccione una-</option>
<?php
	foreach($entidades_remision as $d)
	{
		echo '<option value="'.$d['codigo_entidad'].'">'.$d['nombre'].'</option>';
	}
?>
</select>
</td>
</tr>
<tr>
<td class='campo_izquierda'>Médico Remitente:</td>
<td><?=form_input(array('name' => 'medico_remite',
                        'id'=> 'medico_remite',
                        'class'=>"fValidate['required']",
                        'size'=> '65'))?></td></tr>
<tr>
<td class='campo_izquierda'>Especialidad:</td>
<td><?=form_dropdown('id_especialidad',$especialidades,'','id=id_especialidad');?>
</td>
</tr>
<tr>
<td width="40%" class='campo_izquierda'>Motivo de la consulta:</td>
<td width="60%">
<?=form_textarea(array('name' => 'motivo_consulta',
								'id'=> 'motivo_consulta',
								'rows' => '2',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo_izquierda'>Enfermedad Actual:</td>
<td><?=form_textarea(array('name' => 'enfermedad_actual',
								'id'=> 'enfermedad_actual',
								'rows' => '2',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo_izquierda'>Impresiones Diagnósticas:</td>
<td><?=form_textarea(array('name' => 'impresiones_diagnosticas',
                            'id'=> 'impresiones_diagnosticas',
                            'rows' => '2',
                            'class'=>"fValidate['required']",
			    'cols'=> '50'))?>
</td></tr>
<tr>
<td class='campo_izquierda'>Motivos de Remisión:</td>
<td><?=form_textarea(array('name' => 'motivo_remision',
								'id'=> 'motivo_remision',
								'rows' => '2',
								'class'=>"fValidate['required']",
								'cols'=> '50'))?></td></tr>
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr>
<td class='campo_izquierda'>Antecedentes Personales:</td>
<td><?=form_textarea(array('name' => 'antecedentes_personales',
								'id'=> 'antecedentes_personales',
								'rows' => '2',
                                                                'cols'=> '50'))?></td></tr>
<tr>
<tr>
<td class='campo_izquierda'>Antecedentes Familiares:</td>
<td><?=form_textarea(array('name' => 'antecedentes_familiares',
								'id'=> 'antecedentes_familiares',
								'rows' => '2',
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo_izquierda'>Revisión por Sistemas:</td>
<td><?=form_textarea(array('name' => 'revision_sistemas',
								'id'=> 'revision_sistemas',
								'rows' => '2',
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo_izquierda'>Examen Físico(Aspectos Positivos):</td>
<td><?=form_textarea(array('name' => 'examen_fisico',
								'id'=> 'examen_fisico',
								'rows' => '2',
								'cols'=> '50'))?></td></tr>
<tr>
<td colspan="2">
<table width="100%" border="1" cellspacing="0" cellpadding="2" style="text-align:center" rules=NONE>
<tr><td colspan="5" class="campo_izquierda">
Signos vitales
</td></tr>
<tr>
<td width="20%">Frecuencia cardiaca</td>
<td width="20%">Frecuencia respiratoria</td>
<td width="20%">Tensi&oacute;n arterial</td>
<td width="20%">Temperatura</td>
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
</table>
</td></tr>
<tr>
<td class='campo_izquierda'>Paraclínicos Realizados:</td>
<td><?=form_textarea(array('name' => 'paraclinicos_realizados',
								'id'=> 'paraclinicos_realizados',
								'rows' => '2',
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo_izquierda'>Tratamientos Realizados:</td>
<td><?=form_textarea(array('name' => 'tratamientos_realizados',
								'id'=> 'tratamientos_realizados',
								'rows' => '2',
								'cols'=> '50'))?></td></tr>
<tr>
<td class='campo_izquierda'>Observaciones:</td>
<td><?=form_textarea(array('name' => 'observaciones',
								'id'=> 'observacione',
								'rows' => '2',
								'cols'=> '50'))?></td></tr>
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
<br/>
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>
