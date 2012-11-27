<script type="text/javascript">
var id_consultorio=-99;
function darBajaConsultorio(id)
{
    if(confirm('¿Seguro que desea modificar el estado de uso del consultorio?'))
        {
            cambiarEstadoConsultorio(id.value, document.getElementById(id.id).checked);
        }
    else
        document.getElementById(id.id).checked=!document.getElementById(id.id).checked;
}
///////////////////////////////////////////////////////////////////////////////
 function agregar_especialidad()
{
    if(id_consultorio==-99)
        {
            alert("Seleccione un Consultorio");
             return false;
        }
    var var_url = '<?=site_url()?>/agenda/consultorios/agregar_especialidad_consultorio/'+id_consultorio.id+'/'+$('especialidad').value;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
                async: false,
		onSuccess: function(html){ 
                    //('lista_especialidades').set('html', html)
                            listaEspecialidades(id_consultorio);
                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
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
///////////////////////////////////////////////////////////////////////////////
function agregar_consultorio()
{
    if(existe_consultorio())
        {
            alert("Consultorio ya Existe");
            return false;
        }
    var var_url = '<?=site_url()?>/agenda/consultorios/agregar_consultorio/'+$('nombre_consultorio').value;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
                async: false,
		onSuccess: function(html){ 
                    //('lista_especialidades').set('html', html)
                                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
        return true;
}
function existe_consultorio()
{
    var respuesta=false;
    var var_url = '<?=site_url()?>/agenda/consultorios/existe_consultorio/'+$('nombre_consultorio').value;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
                async: false,
		onSuccess: function(html){ 
                    respuesta=html=="true"?true:false;
                    //$('lista_especialidades').set('html', html)
                                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
        return respuesta;
}
///////////////////////////////////////////////////////////////////////////////
function listaEspecialidades(id)
{
    id_consultorio=id;
    var var_url = '<?=site_url()?>/agenda/consultorios/especialidadesConsultorio/'+id.id;
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
}
function cambiarEstadoEspecialidad(id)
{
    if(!confirm('¿Seguro que desea modificar el estado de uso del consultorio por parte de la especialidad?'))
        {
            alert(id.name);
            document.getElementById(id.id).checked=!document.getElementById(id.id).checked;
            return;
        }
    cadenas_id=id.value.split('-');
    var var_url = '<?=site_url()?>/agenda/consultorios/cambiarEstadoEspecialidadConsultorio/'+cadenas_id[0]+'/'+cadenas_id[1]+'/'+id.checked;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
		onSuccess: function(html){ //$('lista_especialidades').set('html', html)
                },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Consulta Externa - Agenda</h1>
<h2 class="subtitulo">Administración Consultorios</h2>
<table width="100%" class="tabla_form">
    <tr><th colspan="2">Administrar Consultorios</th></tr>
    <tr><td colspan="2">  
            <table>
                <tr>
                    <td colspan="2">
                        <table width="100%" class="tabla_interna">
                        <tr>
                          <td class="campo_izquierda" width="140px">Nombre Consultorio:</td><td class="campo_izquierda" width="150px"><?=form_input('nombre_consultorio','','id="nombre_consultorio" size="40"')?></td>
                          <td><?=form_submit('boton', 'Agregar')?></td>
                        </tr>
                        </table>
                    </td>
                </tr>
                 <tr>
                    <td colspan="3">
                        <table class="tabla_interna">
                            <tr>
                               <td class="campo_izquierda">Especialidad:</td><td><?=form_dropdown('especialidad',$listadoEspecialidades,'','id="especialidad"')?></td>
                               <td><?=form_submit('boton', 'Agregar')?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><!-- inicio columna -->
                     <?php
                        $attributes = array('id'=>'formulario','name'=> 'formulario',
                                            'method'=> 'post',
                                            'onsubmit'=>'return agregar_consultorio()');
                        echo form_open('agenda/consultorios/',$attributes);
                        ?>
                     <table width="40%" class="tabla_interna" border="1"border=1 rules=none>
                        <tr><td colspan="2"><h4 class="subtitulo">Dar click sobre el consultorio para ver la lista de especialidades asignadas</h3></td></tr>
                        <tr>
                                  <td class="campo_centro">En Uso</td>
                                  <td class="campo_centro">Consultorio</td>
                        </tr>
                        <?php 
                            foreach($listadoConsultorios as $itemArray)
                            {
                               ?>
                                <tr id="<?=$itemArray['id_consultorio']?>"onClick="listaEspecialidades(this);">
                                  <td><?=form_checkbox('estado', $itemArray['id_consultorio'],$itemArray['estado']==1?TRUE:FALSE,'onClick="darBajaConsultorio(this)" id="consultorio_'.$itemArray['id_consultorio'].'"')?></td>
                                  <td><?=$itemArray['descripcion']?></td>      
                                </tr>
                               <?php
                            }
                        ?>
                    </table>
                    <?=form_close();?>
                    </td> <!-- fin columna izquierda-->
                    <td colspan="2"> <!-- inicio columna derecha-->
                        <h2 class="subtitulo">Especialidades Usando Consultorio</h2>        
                        <table width="100%" class="tabla_interna" id="lista_especialidades">
                            <tr>
                               <td class="campo_centro">Usando</td>
                               <td class="campo_centro">Consultorio</td>
                            </tr>
                            </table>
                        <table width="100%" class="tabla_interna" id="lista_especialidades">
                        </table>
                    </td> <!-- fin columna derecha-->
                </tr>
            </table>
        </td>
</table>
        