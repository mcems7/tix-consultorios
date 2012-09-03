
<script language='javascript'>


function clinico_tipo_num(){
	
	 var var_url = '<?=site_url()?>/lab/lab_adm_clinicos/AgregarClinicoNum'
  var ajax1 = new Request(
  {
    url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_clinico').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send(); 
	
	}
	
function clinico_tipo_texto(){
	
	 var var_url = '<?=site_url()?>/lab/lab_adm_clinicos/AgregarClinicoText'
  var ajax1 = new Request(
  {
    url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_clinico').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send(); 
	
	}
function clinico_tipo_lista(identificador){
	
	
	
	 var var_url = '<?=site_url()?>/lab/lab_adm_clinicos/AgregarClinicoList/'+identificador
  var ajax1 = new Request(
  {
    url: var_url,

    onRequest: function (){$('div_precarga').style.display = "block";},
    onSuccess: function(html){$('div_tipos_clinico').set('html', html);
    $('div_precarga').style.display = "none";},
    onComplete: function(){},
    evalScripts: true,
    onFailure: function(){alert('Error ejecutando ajax!');}
  });
  ajax1.send(); 
	
	}	

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////






</script>



<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/lab/lab_adm_clinicos/Edita_Clinico',$attributes);
echo form_hidden('idpadre',$listado[0]['id']);
$identificador=$listado[0]['id'];


?>
 <strong> <?php echo $listado[0]['nombre']; ?></strong> <br /><br />
<table cellspacing='0' cellpadding='0' >
<tr> 
     <td>

  <strong>Abreviatura:</strong> 
  <?=form_input(array('name' => 'abreviatura',
						'id'=> 'abreviatura',
						'class'=> "fValidate['integer']",
						'value'=> $listado[0]['abreviatura'],					
						'size'=> '15'))?>
      </td>    
       <td>

  <strong>Nombre:</strong> 
  <?=form_input(array('name' => 'nombre',
						'id'=> 'nombre',
						'class'=> "fValidate['integer']",
						'value'=> $listado[0]['nombre'],					
						'size'=> '60'))?>
      </td>                 
              
<tr>
              </table>      
                    <table cellspacing='0' cellpadding='0' >
						<tr>
                        <td rowspan="3">
                        <strong>Tipo</strong>
                        </td>
							<td>
								Numerico&nbsp;
							</td>
							<td>
<?php
			
								$data = array('name'        => 'tipo_dato',
								              'id'          => 'tipo_dato',
								              'value'       => 'numero',
											  'onchange'       => 'clinico_tipo_num()',
								              'checked'     => false
								             );
			
								echo form_radio($data);
			
?>							
							</td>
                            <td rowspan="3">

<div id="div_tipos_clinico">
</div>
</td>
                          
						</tr>
						<tr>
							<td>
								Texto&nbsp;
							</td>
							<td>
								<?php
								
								$data = array('name'        => 'tipo_dato',
								              'id'          => 'tipo_dato',
								              'value'       => 'texto',
											  'onchange'       => 'clinico_tipo_texto()',
								              'checked'     => false
								             );
			
								echo form_radio($data);
								
								?>							
							</td>
						</tr>
                        <tr>
							<td>
								Lista&nbsp;
							</td>
							<td>
								<?php
			
								$data = array('name'        => 'tipo_dato',
								              'id'          => 'tipo_dato',
								              'value'       => 'lista',
											  'onchange'       => 'clinico_tipo_lista('.$identificador.')',
								              'checked'     => false
								             );
			
								echo form_radio($data);
			
								?>							
							</td>
                            
						</tr>
                        
					</table>
                    
                    
<div align="center">						
<?=form_submit('boton', 'Guardar')?>
</div>

<?=form_close();?>                        