<script language='javascript'>
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");			 
});
</script>


<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('/atencion/aten_adm_hc/Ingresa_contenedor_Clinico',$attributes);
echo form_hidden('idpadre',$listado[0]['id']);?>
 

<strong> <?php echo $listado[0]['nombre'].' '; ?></strong> <br /><br />


<table cellspacing='0' cellpadding='0' >
<tr> 
     <td>

  <strong>Abreviatura:</strong> 
  <?=form_input(array('name' => 'abreviatura',
						'id'=> 'abreviatura',
						'class'=> "fValidate['integer']",					
						'size'=> '15'))?>
      </td>                  
         <td>     <div id="agregarPro">
                    <?=$this->load->view('/atencion/aten_adm_agregar_clinico_cups')?>
                  </div>     
         </td>          
<tr>
              </table>  

                        
<table cellspacing='0' cellpadding='0' >
						<tr>
							<td>
								Sin Restriccion Atomica&nbsp;
							</td>
							<td>
<?php
			
								$data = array('name'        => 'accion_alerta',
								              'id'          => 'accion_alerta',
								              'value'       => 'sin restriccion atomica',
								              'checked'     => false
								             );
			
								echo form_radio($data);
			
?>							
							</td>
                            <td rowspan="4">
<?php

								$checked = false;
								
								$data = array('name'        => "investigativo",
								              'id'          => "investigativo",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								echo "Investigativo ";
?> <br /> 
<?php

								$checked = false;
								
								$data = array('name'        => "vigilancia_epidemiologica",
								              'id'          => "vigilancia_epidemiologica",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								echo "Vigilancia Epidemiologica";
?> <br /> 
<?php

								$checked = false;
								
								$data = array('name'        => "seguimiento_individuo",
								              'id'          => "seguimiento_individuo",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								echo "Seguimiento Individuo";
?> <br /> 
<?php

								$checked = false;
								
								$data = array('name'        => "diagnostico",
								              'id'          => "diagnostico",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								echo "Diagnostico";
?> 

                            </td>
						</tr>
						<tr>
							<td>
								Sugerencia&nbsp;
							</td>
							<td>
								<?php
								
								$data = array('name'        => 'accion_alerta',
								              'id'          => 'accion_alerta',
								              'value'       => 'sugerencia',
								              'checked'     => false
								             );
			
								echo form_radio($data);
								
								?>							
							</td>
						</tr>
                        <tr>
							<td>
								Obligatoriedad Atomica&nbsp;
							</td>
							<td>
								<?php
			
								$data = array('name'        => 'accion_alerta',
								              'id'          => 'accion_alerta',
								              'value'       => 'obligatoriedad atomica',
								              'checked'     => false
								             );
			
								echo form_radio($data);
			
								?>							
							</td>
						</tr>
                        
					</table>   
                    <table>
                    <tr>
                    <td colspan="3">
                    <strong> Restriccion Sumatoria </strong>
                    <?php 
							$checked = false;
								
								$data = array('name'        => "restriccion_sumatoria",
								              'id'          => "restriccion_sumatoria",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								
							
							
							?>
                    
                    </td>
                    </tr>
                       <tr>
                           <td>
                            <strong> Valor Grupo Suma</strong> <?=form_input(array('name' => 'valor_grupo_suma',
						'id'=> 'valor_grupo_suma',
						'class'=> "fValidate['integer']",
						'size'=> '4'))?>
                           </td> 
                           <td>
                            <strong> Mensaje</strong>
                            </td>
                            <td>
                            <?=form_textarea(array('name' => 'mensaje_grupo_suma',
							            'id'=>'mensaje_grupo_suma',
                                                                'rows' => '3',
                                                                'cols'=> '30'))?>
                           </td> 
                       </tr>
                        <tr>
                           <td>
                            <strong> Normalidad Atomica</strong> 
						
                            
							<?php 
							$checked = false;
								
								$data = array('name'        => "normalidad_atomica",
								              'id'          => "normalidad_atomica",
								              'value'       => "1",
								              'checked'     => $checked
								             );
			
								echo form_checkbox($data);
								
							
							
							?>
                           </td> 
                           <td>
                            <strong> Mensaje</strong>
                            </td>
                            <td>
                            <?=form_textarea(array('name' => 'mensaje_normalidad_atomica',
							                                 'id' => 'mensaje_normalidad_atomica',
                                                             'rows' => '3',
                                                             'cols'=> '30'))?>
                           </td> 
                       </tr>
                       
                       
                       
                    
                    </table>
                    
                             
                    
						
<?=form_submit('boton', 'Guardar')?>

<?=form_close();?>                        