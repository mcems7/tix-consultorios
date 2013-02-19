<script type="text/javascript">
    var id_medico=0;
    var id_disponibilidad_marcada=0;
////////////////////////////////////////////////////////////////////////////////
function cargar_especialistas()
{
     var var_url = '<?=site_url()?>/agenda/disponibilidades/filtrar_especialistas/'+$('id_especialidad').value
         var ajax1 = new Request(
            {
                url: var_url,
                method: 'post',
                data: '',
                async: false,
                onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                            $('especialistas_listado').set('html',html);
                       },
                evalScripts: true,
                onFailure: function(){alert('Error asignando parámetro como activo');
                }

            });
          ajax1.send();
}
///////////////////////////////////////////////////////////////////////////////
function darBajaConsultorio(id)
{
    if(confirm('¿Seguro que desea modificar el estado de uso del consultorio?'))
        {
            cambiarEstadoConsultorio(id.value, document.getElementById(id.id).checked);
        }
    else
        document.getElementById(id.id).checked=!document.getElementById(id.id).checked;
}
//////////////////////////////////////////////////////////////////////////////
function marcar_disponibilidad(id_disponibilidad,hora_inicio, hora_fin,dia )
{
    if(dia==1)
        dia='Lunes';
    else if(dia==2)
        dia='Martes';
    else if(dia==3)
        dia='Miércoles';
     else if(dia==4)
        dia='Jueves';
    else if(dia==5)
        dia='Viernes';
    else if(dia==6)
        dia='Sábado';
    else if(dia==7)
        dia='Domingo';
    $('dia_marcado').set('html',dia + ': '+ hora_inicio + ' - ' + hora_fin )
    id_disponibilidad_marcada= id_disponibilidad;
}
///////////////////////////////////////////////////////////////////////////////
function existe_rango_horario()
{
    var existe=true;
    var var_url = '<?=site_url()?>/agenda/disponibilidades/existe_disponibilidad/'+id_medico+'/'+$('dia_disponibilidad').value+'/'+$('hora_inicial').value+'/'+$('hora_final').value;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
                async: false,
		onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                existe=html=="true"?true:false;     
                       },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');
                }
		
	});
	ajax1.send();
        return existe;
}
/////////////////////////////////////////////////////////////////////////////
function agregar_detalle_disponbilidad()
{
    if(existe_rango_horario())
        {
            alert("El Rango Horario ya está Asignado en las Disponibilidades");
        }
    else 
        {
         var var_url = '<?=site_url()?>/agenda/disponibilidades/agregar_detalle_disponbilidad/'+id_medico+'/'+$('dia_disponibilidad').value+'/'
                         +$('hora_inicial').value+'/'+$('hora_final').value+'/'+$('tipo_disponibilidad').value;
         var ajax1 = new Request(
            {
                url: var_url,
                method: 'post',
                data: '',
                async: false,
                onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                existe=html=="true"?true:false;     
                       },
                evalScripts: true,
                onFailure: function(){alert('Error asignando parámetro como activo');
                }

            });
          ajax1.send();
        }
    return false;
}
///////////////////////////////////////////////////////////////////////////////
function eliminar_disponibilidad()
{
    var var_url = '<?=site_url()?>/agenda/disponibilidades/eliminar_disponibilidad/'+id_disponibilidad_marcada;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
		onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                           },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');
                }
		
	});
	ajax1.send();
    return false;
}
///////////////////////////////////////////////////////////////////////////////
function cambiarEstadoConsultorio(id,estado)
{
    var var_url = '<?=site_url()?>/agenda/consultorios/cambiarEstadoConsultorio/'+id+'/'+estado;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
		onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                           },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');
                }
		
	});
	ajax1.send();
}










function agregar_disponibilidad()
{

    var var_url = '<?=site_url()?>/agenda/disponibilidades/agregar_disponibilidad/'+$('medico_disponibilidad').value+'/'+$('horas_mes').value;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
		onSuccess: function(html){ $('lista_especialidades').set('html', html)
                                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
        return true;
}
function disponibilidad_medico(id)
{       id_medico=id;
        var var_url = '<?=site_url()?>/agenda/disponibilidades/disponibilidades_medicos/'+id;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
		onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                    $('disponbilidad_medico').set('html', html)
                },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
}
//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Consulta Externa - Disponbilidades</h1>
<h2 class="subtitulo">Administrar Disponbilidades M&eacute;dicos</h2>
<center>
 <?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('agenda/disponibilidades/agregar_disponibilidad/',$attributes);
?>
    <table width="100%" class="tabla_form">
    <tr><th colspan="2">Disponbilidades M&eacute;dicas</th></tr>
    <tr><td colspan="2">

     <h2 class="subtitulo">M&eacute;dicos</h2>        
<table width="100%" class="tabla_form">
<tr>
  <td  class="campo_izquierda">Especialidades:</td><td><?=form_dropdown('id_especialidad',$listado_especialidades,'-1','id="id_especialidad" onChange="cargar_especialistas()"')?></td>
</tr>
<tr>
  <td class="campo_izquierda">Especialista:</td><td id="especialistas_listado" ><?=form_dropdown('medico_disponibilidad',$options_array_selected,'','id="medico_disponibilidad"')?></td>
</tr>
<tr>
  <td class="campo_izquierda">Horas Mes:</td><td><?=form_input('horas_mes','0','id="horas_mes"')?></td>
</tr>
</table>
     <?=form_submit('boton', 'Agregar')?>
    <?=form_close();?>
</td></tr>
<tr><td colspan="2">

     <h2 class="subtitulo">Disponibilidades</h2>        
<table width="100%" class="tabla_interna">
<tr>
  <td class="campo_centro">Especialidad</td><td class="campo_centro">Medico</td><td class="campo_centro">Horas Mes</td>
</tr>
<?php 
    foreach($disponibilidades as $item)
    {
 ?>
<tr onclick="disponibilidad_medico('<?=$item['id_medico']?>')">
  <td><?=$item['descripcion']?></td>
  <td><?=$item['primer_nombre'].' '.$item['segundo_nombre'].' '.$item['primer_apellido'].' '.$item['segundo_apellido']?></td>
  <td><?=$item['total_horas_mes']?></td>
</tr>
<?php
    }
?>
</table>
</td></tr>    
<tr><td colspan="2">
<?php
$attributes = array('id'=> 'formulario','name'=> 'formulario_eliminiar_disponbilidad',
                    'method' => 'post');
echo form_open('agenda/main/agregarParametroAgenda',$attributes);
?>
     <h2 class="subtitulo">Detalle Disponibilidad</h2>        
<table id="disponbilidad_medico" width="100%" class="tabla_interna">
<tr>
  <td class="campo_centro">Lunes</td><td class="campo_centro">Martes</td>
  <td class="campo_centro">Miercoles</td><td class="campo_centro">Jueves</td>
  <td class="campo_centro">Viernes</td><td class="campo_centro">Sabado</td>
  <td class="campo_centro">Domingo</td>  
</tr>
</table>
     <div style="float:left"><?=form_submit('boton', 'Eliminar')?></div><div id="dia_marcado" style="float:left"></div>
</td></tr>
    <?=form_close();?>
<tr><td colspan="2">
<?php
$attributes = array('id'=> 'formulario_disponibilidad','name'=> 'formulario',
                    'method' => 'post','onsubmit'=> 'return agregar_detalle_disponbilidad()');
echo form_open('agenda/main/agregarParametroAgenda',$attributes);
?>
     <h2 class="subtitulo">Agregar Disponibilidad</h2>        
<table width="50%" class="tabla_form">
<tr>
  <td class="campo">Dia:</td><td><?=form_dropdown('dia_disponibilidad',array('1'=>'Lunes',
                                                                       '2'=>'Martes','3'=>'Miercoles',
                                                                       '4'=>'Jueves',
                                                                       '5'=>'Viernes','6'=>'Sabado',
                                                                       '7' =>'Domingo'),'','id="dia_disponibilidad"')?></td>
  <td class="campo">Tipo:</td><td><?=form_dropdown('tipo_disponibilidad',array('disponible'=>'Disponible',
                                                                       'no_disponible'=>'No Disponible',),'no_disponible',
                                                                        'id="tipo_disponibilidad"')?></td>
</tr>
<tr>
  <td class="campo">Hora Inicial:</td><td><?=form_input('hora_inicial','0','id="hora_inicial"')?></td>
  <td class="campo">Hora Final:</td><td><?=form_input('hora_final','0','id="hora_final"')?></td>
</tr>
</table>
     <?=form_submit('boton', 'Agregar')?>
    <?=form_close();?>
</td></tr>
    </table>
</center>