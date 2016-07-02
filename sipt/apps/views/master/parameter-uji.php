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
							<h1><span>Standar Ruang Lingkup</span></h1>
							<p>&nbsp;</p>
						</div>
					</div>
                    <?php
					if(!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && $this->newsession->userdata('SESS_BBPOM_ID') != '00'){
					?>
                    <div class="alert alert-block alert-danger fade in">
                    	<strong><a href="<?php echo site_url(); ?>/home/master/srlpengujian/new">Klik disini</a></strong> untuk menambah paameter uji baru yang tidak terdapat pada prioritas sampling ataupun standar ruang lingkup. (Dengan catatan bahwa data tersebut akan terlebih dahulu di verifikasi oleh Ditwas / Insert yang bersangkutan).
                    </div>    
                    <?php
					}
					?>
                    <ul class="list-group" id="notif-pelaporan">
                    <li class="list-group-item active bypass"><b>Kategori</b></li>
                    <?php
					if($this->newsession->userdata('SESS_BBPOM_ID') == "91" || $this->newsession->userdata('SESS_BBPOM_ID') == "92" || $this->newsession->userdata('SESS_BBPOM_ID') == "93"){#Ditwas Produksi, Distribusi Obat, DitNapza
						?>
						<li class="list-group-item notif">Obat</li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0101" class="link-jml" id="0101-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0101">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0102" class="link-jml" id="0102-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0102">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0103" class="link-jml" id="0103-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0103">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0104" class="link-jml" id="0104-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0104">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori D<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0105" class="link-jml" id="0105-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0105">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0106" class="link-jml" id="0106-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0106">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0107" class="link-jml" id="0107-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0107">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0108" class="link-jml" id="0108-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0108">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0109" class="link-jml" id="0109-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0109">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0110" class="link-jml" id="0110-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0110">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Napza (Kategori H)<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/20" class="link-jml" id="20-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/20">0</a></span></li>                   
                        <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0111" class="link-jml" id="0111-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0111">0</a></span></li>
                        
                        <?php
						if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){
							?>
                            <li class="list-group-item notif">Rokok<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/07" class="link-jml" id="07-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/07">0</a></span></li>    
                            <?php
						}
						?>
                        
                        <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "94"){#Insert OT KOS SM
						?>
                        <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/10" class="link-jml" id="10-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/10">0</a></span></li>
                        <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/11" class="link-jml" id="11-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/11">0</a></span></li>
                        <li class="list-group-item notif">Kosmetika<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/12" class="link-jml" id="12-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/12">0</a></span></li>
                        <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "95"){#Insert Pangan
						?>
                        <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/13" class="link-jml" id="13-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/13">0</a></span></li>
                        <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "96"){#Ditwas BB
						?>
                        <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/14" class="link-jml" id="14-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/14">0</a></span></li>
                        <?php
					}else{#PPOM, PIOM, Balai
						?>
						<li class="list-group-item notif">Obat</li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0101" class="link-jml" id="0101-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0101">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0102" class="link-jml" id="0102-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0102">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0103" class="link-jml" id="0103-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0103">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0104" class="link-jml" id="0104-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0104">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori D<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0105" class="link-jml" id="0105-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0105">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0106" class="link-jml" id="0106-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0106">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0107" class="link-jml" id="0107-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0107">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0108" class="link-jml" id="0108-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0108">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0109" class="link-jml" id="0109-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0109">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0110" class="link-jml" id="0110-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0110">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Napza (Kategori H)<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/20" class="link-jml" id="20-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/20">0</a></span></li>
                                           
                        <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/0111" class="link-jml" id="0111-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/0111">0</a></span></li>
                        <li class="list-group-item notif">Produk Biologi<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/02" class="link-jml" id="02-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/02">0</a></span></li>
                        <li class="list-group-item notif">Alkes / PKRT<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/03" class="link-jml" id="03-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/03">0</a></span></li>
                        <li class="list-group-item notif">Rokok<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/07" class="link-jml" id="07-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/07">0</a></span></li>
                        <li class="list-group-item notif">Obat Tradisional<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/10" class="link-jml" id="10-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/10">0</a></span></li>
                        <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/11" class="link-jml" id="11-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/11">0</a></span></li>
                        <li class="list-group-item notif">Kosmetika<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/12" class="link-jml" id="12-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/12">0</a></span></li>
                        <li class="list-group-item notif">Produk Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/13" class="link-jml" id="13-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/13">0</a></span></li>
                        <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-info"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/view/14" class="link-jml" id="14-all" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/01/14">0</a></span></li>
                        <?php
					}
					?>
                    </ul>
                    
                    <div>&nbsp;</div>
                    <ul class="list-group">
                    <li class="list-group-item active bypass"><b>Verifikasi Data Parameter Uji</b></li>
                    <?php
					if($this->newsession->userdata('SESS_BBPOM_ID') == "91" || $this->newsession->userdata('SESS_BBPOM_ID') == "92" || $this->newsession->userdata('SESS_BBPOM_ID') == "93"){#Ditwas Produksi, Distribusi Obat, DitNapza
						?>
						<li class="list-group-item notif">Obat</li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0101" class="link-verifikasi" id="0101-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0101">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0102" class="link-verifikasi" id="0102-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0102">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0103" class="link-verifikasi" id="0103-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0103">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0104" class="link-verifikasi" id="0104-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0104">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori D<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0105" class="link-verifikasi" id="0105-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0105">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E1<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0106" class="link-verifikasi" id="0106-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0106">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E2<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0107" class="link-verifikasi" id="0107-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0107">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0108" class="link-verifikasi" id="0108-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0108">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0109" class="link-verifikasi" id="0109-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0109">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0110" class="link-verifikasi" id="0110-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0110">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Napza (Kategori H)<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/20" class="link-verifikasi" id="20-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/20">0</a></span></li>
                         <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0111" class="link-verifikasi" id="0111-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0111">0</a></span></li>
                        <?php
						if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){
							?>
                            <li class="list-group-item notif">Rokok<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/07" class="link-verifikasi" id="07-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/07">0</a></span></li>    
                            <?php
						}
						?>
                        
                        <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "94"){#Insert OT KOS SM
						?>
                        <li class="list-group-item notif">Obat Tradisional<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/10" class="link-verifikasi" id="10-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/10">0</a></span></li>
                        <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/11" class="link-verifikasi" id="11-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/11">0</a></span></li>
                        <li class="list-group-item notif">Kosmetika<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/12" class="link-verifikasi" id="12-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/12">0</a></span></li>
                        <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "95"){#Insert Pangan
						?>
                        <li class="list-group-item notif">Produk Pangan<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/13" class="link-verifikasi" id="13-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/13">0</a></span></li>
                        <?php
					}else if($this->newsession->userdata('SESS_BBPOM_ID') == "96"){#Ditwas BB
						?>
                        <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/14" class="link-verifikasi" id="14-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/14">0</a></span></li>
                        <?php
					}else{#PPOM, PIOM, Balai
						?>
						<li class="list-group-item notif">Obat</li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori A<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0101" class="link-verifikasi" id="0101-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0101">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori B<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0102" class="link-verifikasi" id="0102-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0102">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C1<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0103" class="link-verifikasi" id="0103-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0103">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori C2<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0104" class="link-verifikasi" id="0104-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0104">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori D<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0105" class="link-verifikasi" id="0105-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0105">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E1<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0106" class="link-verifikasi" id="0106-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0106">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori E2<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0107" class="link-verifikasi" id="0107-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0107">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori F<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0108" class="link-verifikasi" id="0108-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0108">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G1<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0109" class="link-verifikasi" id="0109-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0109">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori G2<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0110" class="link-verifikasi" id="0110-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0110">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Napza (Kategori H)<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/20" class="link-verifikasi" id="20-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/20">0</a></span></li>
                        <li class="list-group-item notif">&bull;&nbsp;Kategori I<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/0111" class="link-verifikasi" id="0111-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/0111">0</a></span></li>
                        <li class="list-group-item notif">Produk Biologi<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/02" class="link-verifikasi" id="02-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/02">0</a></span></li>
                        <li class="list-group-item notif">Alkes / PKRT<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/03" class="link-verifikasi" id="03-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/03">0</a></span></li>
                        <li class="list-group-item notif">Rokok<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/07" class="link-verifikasi" id="07-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/07">0</a></span></li>
                        <li class="list-group-item notif">Obat Tradisional<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/10" class="link-verifikasi" id="10-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/10">0</a></span></li>
                        <li class="list-group-item notif">Suplemen Makanan<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/11" class="link-verifikasi" id="11-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/11">0</a></span></li>
                        <li class="list-group-item notif">Kosmetika<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/12" class="link-verifikasi" id="12-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/12">0</a></span></li>
                        <li class="list-group-item notif">Produk Pangan<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/13" class="link-verifikasi" id="13-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/13">0</a></span></li>
                        <li class="list-group-item notif">Kemasan Pangan<span class="badge bg-warning"><a href="<?php echo site_url(); ?>/home/master/parameter-uji/verifikasi/14" class="link-verifikasi" id="14-verifikasi" url="<?php echo site_url(); ?>/load/utility/get_jml_srl/00/14">0</a></span></li>
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
$(".link-jml, .link-verifikasi").each(function(n,i){
	var url = $(this).attr("url");
	var id = $(this).attr("id");
	$.get(url, function(data){
		if(data) $("#"+id).html(data);
		else $("#"+id).html('0');
	});
});
</script>