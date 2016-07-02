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
            <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0101">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0102">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0103">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0104">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0105">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0106">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori E<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0107">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0111">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0108">Detil</a></span></li>
            
            <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0112">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori H<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0109">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0110">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori Trigerred<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0113">Detil</a></span></li>
            <?php
			}else if($this->newsession->userdata('SESS_BBPOM_ID') == "94"){#Insert OT KOS SM
			?>
            <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/10">Detil</a></span></li>
            <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/11">Detil</a></span></li>
            <li class="list-group-item notif">Kosmetika<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/12">Detil</a></span></li>
            <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "95"){#Insert Pangan
						?>
            <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/13">Detil</a></span></li>
            <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "96"){#Ditwas BB
						?>
            <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/14">Detil</a></span></li>
            <?php
					}else{#PPOM, PIOM, Balai
						?>
            <li class="list-group-item notif">Obat</li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0101">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0102">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0103">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0104">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0105">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori D2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0106">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori E<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0107">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0111">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0108">Detil</a></span></li>
            
            <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0112">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori H<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0109">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0110">Detil</a></span></li>
            <li class="list-group-item notif">&bull;&nbsp;Kategori Trigerred<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/01/0113">Detil</a></span></li>
            <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/10">Detil</a></span></li>
            <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/11">Detil</a></span></li>
            <li class="list-group-item notif">Kosmetika<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/12">Detil</a></span></li>
            <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/13">Detil</a></span></li>
            <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/prioritas/kategori/14">Detil</a></span></li>
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
