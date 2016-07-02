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
              <h1><span>Kategori Prioritas Sampling</span></h1>
              <p>&nbsp;</p>
            </div>
          </div>
          <ul class="list-group" id="notif-pelaporan">
            <li class="list-group-item active bypass"><b>Kategori</b></li>
            <?php
					if($this->newsession->userdata('SESS_BBPOM_ID') == "91" || $this->newsession->userdata('SESS_BBPOM_ID') == "92" || $this->newsession->userdata('SESS_BBPOM_ID') == "93"){#Ditwas Produksi, Distribusi Obat, DitNapza
						?>
            <li class="list-group-item notif">Obat</li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0101" class="link-jml" id="0101-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0101">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0102" class="link-jml" id="0102-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0102">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0103" class="link-jml" id="0103-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0103">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0104" class="link-jml" id="0104-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0104">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0105" class="link-jml" id="0105-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0105">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0106" class="link-jml" id="0106-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0106">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori E<span class="badge bg-info"><?php /*?><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0107" class="link-jml" id="0107-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0107">0</a><?php */?>Parameter uji diambil dari semua kategori</span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0111" class="link-jml" id="0111-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0111">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0108" class="link-jml" id="0108-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0108">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0112" class="link-jml" id="0112-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0112">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori H<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0109" class="link-jml" id="0109-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0109">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0110" class="link-jml" id="0110-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0110">0</a></span></li>
            <?php
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == "94"){#Insert OT KOS SM
			?>
            <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/10" class="link-jml" id="10-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/10">0</a></span></li>
            <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/11" class="link-jml" id="11-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/11">0</a></span></li>
            <li class="list-group-item notif">Kosmetika<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/12" class="link-jml" id="12-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/12">0</a></span></li>
            <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "95"){#Insert Pangan
						?>
            <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/13" class="link-jml" id="13-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/13">0</a></span></li>
            <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "96"){#Ditwas BB
						?>
            <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/14" class="link-jml" id="14-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/14">0</a></span></li>
            <?php
					}else{#PPOM, PIOM, Balai
						?>
            <li class="list-group-item notif">Obat</li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0101" class="link-jml" id="0101-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0101">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0102" class="link-jml" id="0102-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0102">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0103" class="link-jml" id="0103-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0103">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0104" class="link-jml" id="0104-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0104">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0105" class="link-jml" id="0105-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0105">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0106" class="link-jml" id="0106-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0106">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori E<span class="badge bg-info"><?php /*?><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0107" class="link-jml" id="0107-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0107">0</a><?php */?>Parameter uji diambil dari semua kategori</span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0111" class="link-jml" id="0111-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0111">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0108" class="link-jml" id="0108-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0108">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0112" class="link-jml" id="0112-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0112">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori H<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0109" class="link-jml" id="0109-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0109">0</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/0110" class="link-jml" id="0110-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/0110">0</a></span></li>
            <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/10" class="link-jml" id="10-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/10">0</a></span></li>
            <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/11" class="link-jml" id="11-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/11">0</a></span></li>
            <li class="list-group-item notif">Kosmetika<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/12" class="link-jml" id="12-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/12">0</a></span></li>
            <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/13" class="link-jml" id="13-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/13">0</a></span></li>
            <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji/14" class="link-jml" id="14-all" url="<?php echo site_url(); ?>/load/utility/get_prioritas/14">0</a></span></li>
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
<script>
$(".link-jml").each(function(n,i){
	var url = $(this).attr("url");
	var id = $(this).attr("id");
	$.get(url, function(data){
		if(data) $("#"+id).html(data);
		else $("#"+id).html('0');
	});
});
</script>