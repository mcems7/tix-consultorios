
<?php 

  foreach($id_clinicosCont as $dato)
  {
          echo $this->load->view('atencion/aten_ordInsertRegistroCont',$dato);
  }
?>  