<script>
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
</script>

<div style="float:left; width:150px; margin:10, 10, 10, 10"> 

  	
   

  <?php 
  if ($tipo=='clinico'){
	  echo $nombre;
  if ($tipo_dato=='numero'){
	 
	  echo form_input(array('name' => 'numero['.$id.']',
						'id'=> "$id",
						'autocomplete'=>'off',
						'class'=>"fValidate['integer']"));
	  
	  
	  }
  if ($tipo_dato=='texto'){
	 echo form_textarea(array('name' => 'texto['.$id.']',
	 'id'=> $id,
	 'autocomplete'=>'off',
                                                                'rows' => '3',
                                                                'cols'=> '15'));
	  
	 
	  }
 if ($tipo_dato=='lista'){
	   echo $this->load->view('lab/lab_ListadoValor',$id);
	  
	  
	  }
  }else if($tipo=='contenedor'){
	      ?></div><div style="clear:both"><strong>
    <?php
	   
	          echo $nombre;
	?></strong>
      <?php
	          echo $this->load->view('lab/lab_ListadoValorCont',$id);
      ?>
             </div><?php
	  }
  
  ?>
 

  </div>