<?php $this->load->library('lib_edad');?>
<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////
function cargar_especialidad()
{
    var var_url = '<?=site_url()?>/atencion/confirmacion/lista/'+$('id_especialidad').value;
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
                async: false,
		onSuccess: function(html){ 
                    $('lista_pacientes').set('html',html)
                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
     return false;
 }
function validar(id_cita)
{
factura=prompt('Ingrese el número de la factura:','HUSD000');
if(factura==null || factura=="" || factura=="HUSD000" || factura=="0")
       {
        alert("Número de Factura no Válido")
        return false;   
       }
if(confirm('Confirmará la cita para proceder para ser atendido ¿Esta seguro que desea continuar?'))
	{
           window.location=("<?=site_url('atencion/confirmacion/confirmar/')?>/"+id_cita+'/'+factura);  
        }    
}
window.addEvent("domready", function(){	
   cargar_especialidad();	
});
</script>
<h1 class="tituloppal">Servicio de Consulta Externa </h1>
<h2 class="subtitulo">Listado Pacientes para Confirmar </h2>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Pacientes Agendados</th></tr>
<tr><td colspan="2">   
        <strong>Especialidad:</strong><?=form_dropdown('id_especialidad',$especialidad,'-1','id="id_especialidad" onChange="cargar_especialidad()"')?>
<div width="100%" id="lista_pacientes"> 
</div>
    </td>
</tr>
</table>