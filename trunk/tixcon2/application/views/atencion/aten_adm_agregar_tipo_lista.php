<script>
function agregarProcecimientoUrg()
{
var p_ape = $('descripcion').value;

		
	var var_url = '<?=site_url()?>/atencion/aten_adm_hc/AgregarClinicoList2/'+p_ape;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_procedimientos').get('html');
		$('div_lista_procedimientos').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
				
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
</script>


<td>
<?php

echo form_hidden('idpadre',$identifica);


?>
 <tr>
                    <td colspan="3">
                    <strong> Mostrar Observacion </strong>
                    <?php 
							$checked = false;
								
								$data = array('name'        => "lista_observacion",
								              'id'          => "lista_observacion",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								
							
							
							?>
                    
                    </td>
                    </tr>
<table>
        
                    
                       <tr>
                           <td>
                            <strong> Valor</strong> 
							</td>
							<td><?=form_input(array('name' => 'descripcion',
						'id'=> 'descripcion',
						'size'=> '10'))?>
                           </td> 
                           <td>
                           
                         <?
$data = array(  'name' => 'valorlista',
		'id' => 'valorlista',
        'value' => 'Guardar',
		'onclick' => 'agregarProcecimientoUrg()',
		'style'=>'width:60px',
        'type' =>'button');
echo form_input($data);
?>
</td>
                       </tr>
          
                       
    
                       
                    
 </table>
</td> 
<td colspan="2"> <table>
 <td><strong>Valores Lista</strong></td>
   <tr>
      <td>
         <div style="height: 70px; width:100px; overflow: auto;">
            <table>
            
            <div id="div_lista_procedimientos">
            
            </div>
              
            </table>
         </div>
      </td>
   </tr>
</table>
</td>