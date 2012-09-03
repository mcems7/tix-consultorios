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