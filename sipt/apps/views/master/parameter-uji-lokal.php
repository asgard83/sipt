<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<link href="<?php echo base_url(); ?>css/front/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/front/style.css" rel="stylesheet">
<div id="juduluji" class="judul"></div>
<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-lg-11"> 
        <!--user info table start-->
        <section class="panel">
          <div class="panel-body progress-panel">
            <div class="task-progress">
              <h1><span>Parameter Uji Lokal Spesifik</span></h1>
              <p>&nbsp;</p>
            </div>
          </div>
          <ul class="list-group" id="notif-pelaporan">
            <li class="list-group-item active bypass"><b>Kategori</b></li>
            <?php
			$jml = count($srl);
			if($jml > 0){
				for($x = 0; $x < $jml; $x++){
			?>
            <li class="list-group-item notif"><?php echo $srl[$x]['KLASIFIKASI']; ?><span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik/view/<?php echo $srl[$x]['KLASIFIKASI_ID']; ?>"><?php echo $srl[$x]['JML']; ?></a></span></li>
            <?php
				}
			}else{
				?>
                <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik/view/10">0</a></span></li>
                <li class="list-group-item notif">Produk Komplemen<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik/view/11">0</a></span></li>
                <li class="list-group-item notif">Kosmetik<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik/view/12">0</a></span></li>
                <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik/view/13">0</a></span></li>
                <?php
			}
			?>
          </ul>
        </section>
        <!--user info table end--> 
      </div>
    </div>
  </section>
</section>
