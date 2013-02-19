
<?php 

  foreach($id_clinicosCont as $dato)
  {
          echo $this->load->view('lab/lab_ordInsertRegistroCont',$dato);
  }
?>  