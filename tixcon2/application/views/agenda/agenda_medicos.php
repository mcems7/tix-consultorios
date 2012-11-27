<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />

<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function traer_agenda()
{
    var var_url = '<?=site_url()?>/agenda/consultar_agendas/agenda_medico/'+$('fecha_agenda_inicial').value+'/'+$('fecha_agenda').value+'/'+$('id_medico').value
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: '',
                async: false,
		onSuccess: function(html){ 
                    //('lista_especialidades').set('html', html)
                        $('agenda_medico').set('html',html);   
                        },
		evalScripts: true,
		onFailure: function(){alert('Error asignando parámetro como activo');}
		
	});
	ajax1.send();
     return false;

}
////////////////////////////////////////////////////////////////////////////////
</script>
<div id="formularioagenda">
    <h2 class="subtitulo">Ingresar Item Agenda</h2> 
    <table width="100%" class="tabla_form">
        <tr><th colspan="2">Datos </th></tr>
        <tr><td colspan="2">
            <?php
                $attributes = array('id'=> 'formulario_carga_agenda',
                                    'name'=> 'formulario_carga_agenda',
                                    'method' => 'post',
                                    'onsubmit'=> 'return traer_agenda()');
                echo form_open('',$attributes);
            ?>
            <table width="60%" class="tabla_interna">
                <tr>
                    <td class="campo">Fecha Inicial:</td>
                    <td><input name="fecha_agenda_inicial" type="text" id="fecha_agenda_inicial" value="" size="10" maxlength="10" READONLY="readonly" class="fValidate['dateISO8601']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_agenda_botton_inicial' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_agenda_inicial',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d',
                                daFormat       :    '%Y-%m-%d',          // format of the input field
                                displayArea	   :	'fecha_agenda_inicial',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_agenda_botton_inicial',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>
                    </td></tr><tr>
                      <td class="campo">Fecha Final:</td>
                      <td><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
                      <img src='<?=base_url()?>/resources/img/calendario_boton.png' id='fecha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                    <script type='text/javascript'>
                    Calendar.setup({
                        inputField     :    'fecha_agenda',     		// id of the input field
                        ifFormat       :    '%Y-%m-%d',
                        daFormat       :    '%Y-%m-%d',          // format of the input field
                        displayArea	   :	'fecha_agenda',
                        showsTime      :	true,
                        timeFormat     :    '12',
                        button         :    'fecha_agenda_botton',       // trigger for the calendar (button ID)
                        align          :    'Br',                   // alignment (defaults to 'Bl')
                        singleClick    :    true
                    });
                    </script></td>
</tr>
<tr>
    <td class="campo">Especialista:</td>
    <td><?=form_dropdown('id_medico', $medicos,'','id="id_medico"');?></td>
</tr>
</table>
        </td></tr>
        <tr><td class="campo_centro"><center><?=form_submit('boton', 'Traer Agenda')?></center></td></tr>
    </table>
</div>
<?=form_close();?>
<div id="agenda_medico" ></div>

