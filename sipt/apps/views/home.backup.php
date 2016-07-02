<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
{_header_}
<title>{_appname_}</title>
</head><body>
<div align="center" id="wrap">
  <div id="menubox">
    <!-- Menu !-->
    <div id="menu-wrapper"> <!-- menu wrapper -->
      <ul id="menus">
        <li><a href="<?php echo base_url(); ?>" title="Home"> Home </a></li>
        <?php
     if (!in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
      if (in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) || in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) || in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
       ?>
        <li><a href="#" title="Jenis Pelaporan"> Entri </a>
          <ul class="submenu">
            <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Pemeriksaan Sarana </a>
              <ul class="submenu">
                <?php
           if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Administrator, Admin Balai / Unit
            ?>
                <li><a href="<?php echo site_url(); ?>/home/tracking/pemeriksaan" title="Pemeriksaan Sarana, Temuan Sarana"> Temuan Sarana </a></li>
                <li><a href="<?php echo site_url(); ?>/home/tracking/produk" title="Pemeriksaan Sarana, Temuan Produk"> Temuan Produk </a></li>
                <?php } ?>
                <?php
           if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) { # Operator
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
             $_opdraft = "20101";
             $_opsend = "20102";
            } else {
             $_opdraft = "20111";
             $_opsend = "20112";
            }
            ?>
                <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan" title="Pemeriksaan Sarana, Baru"> Baru </a></li>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Draft </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_opdraft; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_opdraft; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_opdraft; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { #Diterima Dari balai  ?>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Diterima Dari Balai </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/20115" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/20115" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/20115" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Ditolak Supervisor Satu </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_opsend; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_opsend; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_opsend; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="separator">&nbsp;</li>
                <?php } ?>
                <?php
           if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Supervisor Satu
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
             $_receivea = "30101";
             $_rejecta = "30102";
             $_recova = "30104";
            } else {
             $_receivea = "30111";
             $_rejecta = "30112";
             $_recova = "30114";
            }
            ?>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Diterima Supervisor Satu </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_receivea; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_receivea; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_receivea; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Review Perbaikan Operator </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_recova; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_recova; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_recova; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Ditolak Supervisor Dua </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_rejecta; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_rejecta; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_rejecta; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="separator">&nbsp;</li>
                <?php } ?>
                <?php
           if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Supervisor Dua
            if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
             $_receiveb = "40101";
             $_recovb = "40103";
             $_rejkd = "40102";
             $label = "Ditolak Kepala Balai";
            } else {
             $_receiveb = "40111";
             $_recovb = "40113";
             $_rejkd = "40112";
             $label = "Ditolak Direktur";
            }
            ?>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Diterima Supervisor Dua </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_receiveb; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_receiveb; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_receiveb; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Review Perbaikan Supervisor Satu</a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_recovb; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_recovb; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_recovb; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li><a href="#" title="Pemeriksaan Sarana" class="hasChild"><?php echo $label; ?></a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/<?php echo $_rejkd; ?>" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/<?php echo $_rejkd; ?>" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/<?php echo $_rejkd; ?>" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="separator">&nbsp;</li>
                <?php } ?>
                <?php if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Kepala Balai  ?>
                <li><a href="#" title="Diterima Kepala Balai"> Diterima Kepala Balai </a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/50101" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/50101" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/50101" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Direktur  ?>
                <li><a href="#" title="Diterima Kepala Balai"> Pemeriksaan Pusat</a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/pusat" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/pusat" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/pusat" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li><a href="#" title="Diterima Kepala Balai"> Pemeriksaan Balai</a>
                  <ul class="submenu">
                    <?php if (in_array('01', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/01/balai" title="Sarana Produksi"> Sarana Produksi </a></li>
                    <?php }if (in_array('02', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/02/balai" title="Sarana Distribusi"> Sarana Distribusi </a></li>
                    <?php }if (in_array('03', $this->newsession->userdata('SESS_SUB_SARANA'))) { ?>
                    <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/03/balai" title="Sarana Pelayanan"> Sarana Pelayanan </a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="separator">&nbsp;</li>
                <?php } ?>
                <?php if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <?php if (!in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/all/send" title="Pemeriksaan Sarana, Terkirim"> Terkirim </a></li>
                <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/all/60020" title="Pemeriksaan Sarana, Feedback Pusat">Feedback Pusat </a></li>
                <?php } ?>
                <li><a href="<?php echo site_url(); ?>/home/pelaporan/pemeriksaan/view/all/60010" title="Pemeriksaan Sarana, Selesai"> Selesai </a></li>
                <?php } ?>
              </ul>
            </li>
            <li><a href="#" title="Pengujian" class="hasChild"> Pengujian </a>
              <ul class="submenu">
                <!-- Pengujian di Pemdik Disini Yak !-->
                <?php
           if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Administrator, Admin Balai / Unit
            ?>
            	<li><a href="#" title="Data Sampling" class="hasChild">Sampel</a>
                  <ul>
                    <li><a href="<?php echo site_url(); ?>/home/tracking/sampling" title="Data Sampel"> Data Sampel</a></li>
                    <?php
					if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
					?>
                    <li><a href="<?php echo site_url(); ?>/home/tracking/sampel-deleted" title="Data Sampel Dihapus"> Data Sampel Dihapus</a></li>
                    <?php
					}
					?>
                  </ul>
                </li>
                <?php
				if ((in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) &&   !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){
				?>
                <li><a href="<?php echo site_url(); ?>/home/tracking/spu" title="Transaksi Surat Permintaan Uji"> Permintaan Uji</a></li>
                <li><a href="<?php echo site_url(); ?>/home/tracking/sps" title="Transaksi Surat Penyerahan Sampel ke Bidang"> Penyerahan Sampel Ke Bidang</a></li>
                <li><a href="<?php echo site_url(); ?>/home/tracking/spk" title="Transaksi Surat Perintah Kerja"> Perintah Kerja</a></li>

                <?php
				if($this->newsession->userdata('SESS_USER_ID') == '102155'){
					?>
                    <li><a href="<?php echo site_url(); ?>/home/tracking/spp" title="Transaksi Surat Perintah Pengujian"> Perintah Pengujian</a></li>
                    <?php
				}
				?>

                <li><a href="<?php echo site_url(); ?>/home/tracking/cp" title="Transaksi Catatan Pengujian"> Catatan Pengujian</a></li>
                <?php
			}
				?>

                <li><a href="#" title="Hasil Pengujian Balai dan Terkirim ke Pusat" class="hasChild"> Hasil Pengujian</a>
                  <ul>
                    <li><a href="<?php echo site_url(); ?>/home/tracking/hasil-uji/balai">Masih Di Balai</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/tracking/hasil-uji/terkirim">Terkirim Ke Pusat</a></li>
                  </ul>
                </li>
                <?php
           }
           if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {#Pusat
             ?>
                <li><a href="<?php echo site_url(); ?>/home/sampel/absah/ms" title="Pengujian sampel MS"> Sampel MS </a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampel/absah/hpst" title="Pengujian sampel HPST"> Sampel HPST </a></li>
                <?php
				 if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
					 $tmp = "Sampel TMS Diterima Operator";
				 }else if(in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))){
					 $tmp = "Sampel TMS Diterima SPV Satu";
				 }else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
					 $tmp = "Sampel TMS Diterima SPV Dua";
				 }else if(in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))){
					 $tmp = "Sampel TMS Diterima Direktur";
				 }
				 ?>
                <li><a href="<?php echo site_url(); ?>/home/sampel/absah/tms" title="Pengujian sampel <?= $tmp; ?>"> <?php echo $tmp; ?></a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampel/absah/send" title="Pengujian sampel yang telah ditindak lanjut"> Sampel Terkirim </a></li>
                <?php
           } else {#Balai
            if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
             if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {
              ?>
                <li><a href="<?php echo site_url(); ?>/home/sampel/new">Sampling Baru</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampel/list/draft">Draft Sampling</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampel/list/all">Sampel Dalam Proses</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampel/list/reject">Perbaikan Sampel</a></li>
                <li class="separator">&nbsp;</li>
                <li><a href="<?php echo site_url(); ?>/home/spu/list/all">Permintaan Uji Dalam Proses</a></li>
                <li class="separator">&nbsp;</li>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/data/internal">Daftar Hasil Pengujian</a></li>
                <?php
             }
             if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {
              ?>
                <li><a href="<?php echo site_url(); ?>/home/spu/list/verifikasi">Verifikasi SPU</a></li>
                <li><a href="<?php echo site_url(); ?>/home/spu/list/all">Permintaan Uji Dalam Proses</a></li>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/data/internal">Daftar Hasil Pengujian</a></li>
                <?php
             }
            } if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Kepala Balai
             ?>
                <li><a href="#" title="Pengujian Rutin" class="hasChild"> Pengujian Rutin</a>
                  <ul class="submenu">
                    <li><a href="<?php echo site_url(); ?>/home/pengujian/data/internal/hasil"> Hasil Uji</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/pengujian/data/internal/pusat"> Proses Pusat</a></li>
                  </ul>
                </li>
                <li><a href="#" title="Pengujian Rutin" class="hasChild"> Pengujian Pihak Ke-3</a>
                  <ul class="submenu">
                    <li><a href="<?php echo site_url(); ?>/home/pengujian/data/external/hasil"> Hasil Uji</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/pengujian/data/external/pusat"> Proses Pusat</a></li>
                  </ul>
                </li>
                <?php
            }
           }
           ?>
                <!-- Akhir Pengujian Pemdik Disini Yak !-->
              </ul>
            </li>
            <?php
         if ($this->newsession->userdata('SESS_BBPOM_ID') == "50" || $this->newsession->userdata('SESS_BBPOM_ID') == "92" || $this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) || (in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) ||in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')))) {
//          if (in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
           ?>
            <!--Iklan-->
            <li><a href="#" title="Pengawasan Iklan" class="hasChild">Pengawasan Iklan </a>
              <ul class="submenu">
                <?php
             if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Administrator, Admin Balai / Unit
              ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/monitoring" title="Pengawasan Iklan, Monitoring"> Monitoring Iklan </a></li>
                <?php }
            if (in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) { ?>
                <?php if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/home/iklan/PengawasanIklan" title="Entri, Pemantauan Iklan"> Baru </a></li>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1101/2" title="Pengawasan Iklan - Draft"> Draft </a></li>
                <?php if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1111/2" title="Tindak Lanjut Balai"> Tindak Lanjut Balai </a></li>
                <?php } ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0101/2" title="Ditolak Supervisor Satu"> Ditolak Supervisor Satu </a></li>
                <?php } if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1101/3" title="Diterima Supervisor Satu"> Diterima Supervisor Satu </a></li>
                <?php if (!(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0303/3" title="Diterima Supervisor Satu"> Perbaikan Operator Balai </a></li>
                <?php } else if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) { ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0313/3" title="Diterima Supervisor Satu"> Perbaikan Operator Pusat </a> </li>
                <?php } ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0101/3" title="Ditolak Supervisor Dua"> Ditolak Supervisor Dua </a></li>
                <?php } if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1101/4" title="Diterima Supervisor Dua"> Diterima Supervisor Dua </a></li>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0404/4" title="Review Perbaikan Supervisor Satu"> Review Perbaikan Supervisor Satu </a></li>
                <?php
              if ((in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) {
               ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0101/4" title="Ditolak Direktur"> Ditolak Direktur </a></li>
                <?php
              } if ((!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')))) {
               ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/0101/4" title="Ditolak Kepala Balai"> Ditolak Kepala Balai </a></li>
                <?php
              }
             } if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
              ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1101/5" title="Diterima Kepala Balai"> Diterima Kepala Balai </a></li>
                <?php
             } if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
              ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1221/6" title="Pengawasan Iklan"> Pengawasan Balai </a></li>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1222/6" title="Pengawasan Iklan"> Pengawasan Pusat </a></li>
                <?php } if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1122/6" title="Selesai, Pengawasan Iklan"> Selesai </a></li>
                <?php
             } else {
              if ((in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) || in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && !in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
               ?>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1212/01"  title="Terkirim, Pengawasan Iklan"> Terkirim </a></li>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/setListFormIklanLanjutan/1122/01"  title="Selesai, Pengawasan Iklan"> Selesai </a></li>
                <?php
              }
             }
         }
             ?>
              </ul>
            </li>
            <!--akhir iklan-->
            <?php
//          } if (in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {
           ?>
            <!--Penandaan-->
            <li><a href="#" title="Pengawasan Penandaan" class="hasChild"> Pengawasan Penandaan </a>
              <ul class="submenu">
                <?php
             if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Administrator, Admin Balai / Unit
              ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/monitoring" title="Pengawasan Penandaan, Monitoring"> Monitoring Penandaan </a></li>
                <?php }
                if (in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) { ?>
                <?php if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/home/penandaan/penandaan" title="Entri, Pemantauan Penandaan"> Baru </a></li>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/2" title="Pengawasan Penandaan - Draft" > Draft </a></li>
                <?php if (in_array($this->newsession->userdata("SESS_BBPOM_ID"), $this->config->item('cfg_unit'))) { ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1111/2" title="Tindak Lanjut Balai"> Tindak Lanjut Balai </a></li>
                <?php } ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0101/2" title="Ditolak Supervisor Satu"> Ditolak Supervisor Satu </a></li>
                <?php } if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/3" title="Diterima Supervisor Satu"> Diterima Supervisor Satu </a></li>
                <?php if (!in_array($this->newsession->userdata("SESS_BBPOM_ID"), $this->config->item('cfg_unit'))) { ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0303/3" title="Diterima Supervisor Satu"> Perbaikan Operator Balai </a></li>
                <?php } else if (in_array($this->newsession->userdata("SESS_BBPOM_ID"), $this->config->item('cfg_unit'))) { ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0303/3" title="Diterima Supervisor Satu"> Perbaikan Operator Pusat </a></li>
                <?php } ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0101/3" title="Ditolak Supervisor Dua"> Ditolak Supervisor Dua </a></li>
                <?php } if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/4" title="Diterima Supervisor Dua"> Diterima Supervisor Dua </a></li>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0404/4" title="Diterima Supervisor Satu"> Review Perbaikan Supervisor Satu </a></li>
                <?php
              if (in_array($this->newsession->userdata("SESS_BBPOM_ID"), $this->config->item('cfg_unit'))) {
               ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0101/4" title="Ditolak Direktur"> Ditolak Direktur </a></li>
                <?php
              } if (!in_array($this->newsession->userdata("SESS_BBPOM_ID"), $this->config->item('cfg_unit'))) {
               ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/0101/4" title="Ditolak Kepala Balai"> Ditolak Kepala Balai </a></li>
                <?php
              }
             } if (in_array('5', $this->newsession->userdata('SESS_KODE_ROLE'))) {
              ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1101/5" title="Diterima Kepala Balai"> Diterima Kepala Balai </a></li>
                <?php
             } if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) {
              ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1221/6" title="Data Balai, Pengawasan Penandaan"> Pengawasan Balai </a></li>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1222/6" title="Data Pusat, Pengawasan Penandaan"> Pengawasan Pusat </a></li>
                <?php } if (in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1122/6" title="Selesai, Pengawasan Penandaan"> Selesai </a></li>
                <?php
             } else {
              if ((in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) || in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && !in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
               ?>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1212/01"  title="Terkirim, Pengawasan Penandaan"> Terkirim </a></li>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/setListFormPenandaanLanjutan/1122/01"  title="Selesai, Pengawasan Penandaan"> Selesai </a></li>
                <?php
               }
              }
             }
             ?>
              </ul>
            </li>
            <?php
//          }
         }
         ?>
            <!-- akhir penandaan !-->
          </ul>
          <!-- AKhir Menu Pengujian sampling di Rilll !-->
          <!-- sub menu end -->
        </li>
        <?php
      } else if (in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && $this->newsession->userdata('SESS_BBPOM_ID') != "99") {#Pengujian
       ?>
        <li><a href="#" title="Pengujian" class="hasChild"> Pengujian </a>
          <ul class="submenu">
            <!-- Remark Pengujian Disini Yak !-->
            <?php
         if (in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))) { #TPS
          ?>
            <li><a href="#" title="Data Penyerahan Sampel" class="hasChild"> Permintaan Uji Rutin</a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/sps/list/verifikasi"> Penerimaan Sampel </a></li>
                <li><a href="<?php echo site_url(); ?>/home/sps/list/sp"> Perintah dan Permintaan Uji</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sps/list/all"> SPS dan Surat Perintah</a></li>
              </ul>
            </li>
            <li><a href="#" class="hasChild"> Sampel Pihak Ke - 3 </a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/sampelx/new">Sampel Baru</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampelx/list/draft">Draft Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sampelx/list/all">Sampel Dalam Proses</a></li>
                <li><a href="<?php echo site_url(); ?>/home/spsx/list/sp"> Perintah dan Permintaan Uji</a></li>
                <li><a href="<?php echo site_url(); ?>/home/spsx/list/all"> SPS dan Surat Perintah</a></li>
              </ul>
            </li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/data/internal"> Hasil Pengujian Rutin</a></li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/data/external"> Hasil Pengujian Pihak Ke-3</a></li>
            <?php
         }
         if (in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))) { #MA
          ?>
            <li><a href="#" title="Permintaan Uji Rutin" class="hasChild"> Permintaan Uji Rutin</a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/sps/list/verifikasi"> Verifikasi Penerimaan Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/sps/list/all"> SPS Dalam Proses</a></li>
              </ul>
            </li>
            <li><a href="#" title="Permintaan Uji Pihak Ke - 3" class="hasChild"> Sampel Pihak Ke - 3 </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/spsx/list/verifikasi"> Verifikasi Penerimaan Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/spsx/list/all"> SPS Dalam Proses</a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) { #MT
          ?>
            <li><a href="#" title="Perintah Kerja" class="hasChild"> Perintah Uji</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/sp/list/verifikasi"> Daftar Pengujian Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/sp/list/send"> SPK Terkirim</a></li>
                <?php /*?><li><a href="<?php echo site_url(); ?>/home/pengujian/sp/list/review"> Revisi SPK Terkirim</a></li><?php */?>
              </ul>
            </li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/lhu/list/draft" title="Laporan Hasil Uji"> Laporan Hasil Uji</a></li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/lhu/list/all" title="Catatan Pengujian"> Konsep Laporan / Sertifikat</a></li>
            <?php
         }
         if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) { #Penyelia
          ?>
            <li><a href="#" title="Perintah Kerja" class="hasChild"> Perintah Kerja</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/spp/list/verifikasi">Perintah Kerja Baru</a></li>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/spp/list/all">Perintah Kerja Terkirim</a></li>
              </ul>
            </li>
            <li><a href="#" title="Catatan Pengujian" class="hasChild"> Catatan Pengujian</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/cp/list/draft"> Draft </a></li>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/cp/list/all"> Data CP </a></li>
              </ul>
            </li>
            <li><a href="#" title="Catatan Pengujian" class="hasChild"> Laporan Hasil Uji</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/pengujian/lhu/list/data"> Verifikasi MT </a></li>
              </ul>
            </li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/lhu/list/all" title="Catatan Pengujian"> Konsep Laporan / Sertifikat</a></li>
            <?php
         }
         if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) { #Penguji
          ?>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/uji/list/20201"> Perintah Pengujian</a></li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/uji/list/20202"> Parameter Uji di Tolak</a></li>
            <li><a href="<?php echo site_url(); ?>/home/pengujian/uji/list/all"> Data Hasil Pengujian</a></li>
            <?php
         }
         ?>
            <!-- End Remark Pengujian Disini Yak !-->
          </ul>
        </li>
        <?php
      } else if ($this->newsession->userdata('SESS_BBPOM_ID') == "99") {#PPOMN
       ?>
        <li><a href="#" title="Pengujian" class="hasChild"> Pengujian </a>
          <ul class="submenu">
            <!-- Remark Pengujian PPOMN Yak !-->
            <?php
         if (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Admin PPOM
          ?>
            <li><a href="#" class="hasChild" title="Hasil Pengujian">Pengujian Balai</a>
              <ul class="submenu">
                <li><a href="#" class="hasChild" title="Hasil Pengujian">Hasil Uji</a>
                  <ul class="submenu">
                    <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/ms" title="Hasil Uji Sampel MS"> Sampel MS</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/hpst" title="Hasil Uji Sampel HPST"> Sampel HPST</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/tms" title="Hasil Uji Sampel TMS"> Sampel TMS</a></li>
                  </ul>
                </li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/respon" title="Hasil Uji Ditanggapi"> Hasil Uji Ditanggapi</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/absah" title="Hasil Uji Di Uji Absah"> Sampel Di Uji Absah</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/arsip" title="Arsip Sampel"> Arsip Sampel</a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Penerima Sampel di TU
          ?>
            <li><a href="#" class="hasChild" title="Hasil Pengujian">Pengujian Balai</a>
              <ul class="submenu">
                <li><a href="#" class="hasChild" title="Hasil Pengujian">Hasil Uji</a>
                  <ul class="submenu">
                    <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/ms" title="Hasil Uji Sampel MS"> Sampel MS</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/hpst" title="Hasil Uji Sampel HPST"> Sampel HPST</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/tms" title="Hasil Uji Sampel TMS"> Sampel TMS</a></li>
                  </ul>
                </li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/respon" title="Hasil Uji Ditanggapi"> Hasil Uji Ditanggapi</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/absah" title="Hasil Uji Di Uji Absah"> Sampel Di Uji Absah</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/arsip" title="Arsip Sampel"> Arsip Sampel</a></li>
              </ul>
            </li>
            <li><a href="#" class="hasChild"> Sampel Pihak Ke - 3 </a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/sampelx/new">Sampel Baru</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/sampelx/list/draft">Draft Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/sampelx/list/reject">Penolakan Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/sampelx/list/all">Sampel Dalam Proses</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spsx/list/sp"> Perintah dan Permintaan Uji</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spsx/list/all"> SPS dan Surat Perintah</a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Kepala TU PPOMN
          ?>
            <li><a href="#" title="Permintaan Uji Pihak Ke - 3" class="hasChild"> Sampel Pihak Ke - 3 </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spsx/list/verifikasi"> Verifikasi Penerimaan Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spsx/list/all"> SPS Dalam Proses</a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('11', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Tim Penerima Sampel di Bidang
          ?>
            <li><a href="#" class="hasChild"> Surat Perintah Uji</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spux/konsep">Draft SPU Diterima</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spux/all">SPU Dalam Proses</a></li>
              </ul>
            </li>
            <li><a href="#" class="hasChild"> Hasil Uji Balai</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/respon" title="Hasil Uji Ditanggapi"> Hasil Uji Ditanggapi</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/absah" title="Hasil Uji Absah"> Hasil Uji Absah</a></li>
              </ul>
            </li>
            <li><a href="#" class="hasChild"> Sertifikat </a>
              <ul>
                <li><a href="#">Konsep</a></li>
                <li><a href="#">Hasil Uji</a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))) {#MT Bidang Pengujian
          ?>
            <li><a href="#" title="Perintah Kerja" class="hasChild"> Perintah Uji</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/sp/list/verifikasi"> Daftar Pengujian Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/sp/list/send"> SPK Terkirim</a></li>
              </ul>
            </li>
            <li><a href="<?php echo site_url(); ?>/home/ppomn/lhu/list/draft" title="Laporan Hasil Uji"> Data Laporan Hasil Uji</a></li>
            <li><a href="<?php echo site_url(); ?>/home/ppomn/lhu/list/all" title="Catatan Pengujian"> Konsep Laporan / Sertifikat</a></li>
            <li><a href="#" class="hasChild"> Hasil Uji Balai</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/laporan/respon" title="Hasil Uji Ditanggapi"> Hasil Uji Ditanggapi</a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('3', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Penyelia
          ?>
            <li><a href="#" title="Perintah Kerja" class="hasChild"> Perintah Kerja</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spp/list/verifikasi">Perintah Kerja Baru</a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/spp/list/all">Perintah Kerja Terkirim</a></li>
              </ul>
            </li>
            <li><a href="#" title="Catatan Pengujian" class="hasChild"> Catatan Pengujian</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/cp/list/draft"> Draft </a></li>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/cp/list/all"> Data CP </a></li>
              </ul>
            </li>
            <li><a href="#" title="Catatan Pengujian" class="hasChild"> Laporan Hasil Uji</a>
              <ul>
                <li><a href="<?php echo site_url(); ?>/home/ppomn/lhu/list/data"> Verifikasi MT </a></li>
              </ul>
            </li>
            <?php
         }
         if (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) {#Penguji
          ?>
            <li><a href="<?php echo site_url(); ?>/home/ppomn/uji/list/20201"> Perintah Pengujian</a></li>
            <li><a href="<?php echo site_url(); ?>/home/ppomn/uji/list/20202"> Parameter Uji di Tolak</a></li>
            <li><a href="<?php echo site_url(); ?>/home/ppomn/uji/list/all"> Data Hasil Pengujian</a></li>
            <?php
         }
         ?>
            <!-- End Remark Pengujian PPOMN Yak !-->
          </ul>
        </li>
        <?php
      }
     }
     ?>
        <li><a href="#" title="Jenis Pelaporan"> Report </a>
          <ul class="submenu">
            <li><a href="#" title="Report, Pemeriksaan Sarana" class="hasChild"> Pemeriksaan Sarana </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/sarana" title="Laporan Pemeriksaan Sarana"> Laporan Sarana</a></li>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/produk" title="Laporan Temuan Produk"> Laporan Temuan Produk </a></li>
                <?php if ($this->newsession->userdata('SESS_BBPOM_ID') == "00") { ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/log-sarana" title="Laporan Log Sarana"> Laporan Log Sarana </a></li>
                <? } ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/rekapperiksa" title="Rekapitulasi Jumlah Sarana yang Diperiksa"> Rekap Jumlah Sarana Yang Diperiksa</a></li>
                <?php if ($this->newsession->userdata('SESS_BBPOM_ID') == "00") { ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/rekapkomoditi" title="Rekapitulasi Pemeriksaan Komoditi"> Rekap Pemeriksaan Komoditi </a></li>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/statuskomoditi" title="Rekapitulasi Status Komoditi"> Rekap Status Komoditi </a></li>
                <?php } ?>
                <?php
         if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('5', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('6', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
          ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/rekapsarana" title="Rekapitulasi Pemeriksaan Sarana"> RHPK Sarana</a></li>
                <?php
          if (array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
           ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/rekapstatus" title="RHPK Per Jenis Sarana"> RHPK Per Jenis Sarana</a></li>
                <?php
          } else {
           ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pemeriksaan/rekapstatus" title="Rekapitulasi Status Dokumen"> Rekapitulasi Status Dokumen </a></li>
                <?php
          }
          ?>
                <?php
         }
         ?>
              </ul>
            </li>
            <!-- Report Pengujian !-->
            <li><a href="#" title="Report, Pengujian" class="hasChild"> Pengujian </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/sampel" title="Laporan Data Sampling"> Laporan Sampel </a></li>
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/hasil-uji" title="Laporan Data Hasil Pengujian"> Laporan Hasil Uji </a></li>
                <?php
         if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {#RHPK Pengujian
          ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/rekapsampel" title="RHPK Data Sampling"> RHPK Data Sampling </a></li>
                <?php /* ?><li><a href="<?php echo site_url(); ?>/home/report/pengujian/rekap-pnbp" title="Rekapitulasi Data PNBP"> Rekapitulasi PNBP Pihak Ke 3 </a></li><?php */ ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/rekap-status" title="Rekapitulasi Status Sampel"> Rekapitulasi Status Sampel</a></li>
                <?php
         }
         if (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {#RHPK Pengujian
          ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/rekap-status" title="Rekapitulasi Status Sampel"> Rekapitulasi Status Sampel</a></li>
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/rekapsampel" title="RHPK Data Sampling"> RHPK Data Sampling </a></li>
                <?php
         }
		 if (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {#RHPK Pengujian
          ?>
                <li><a href="<?php echo site_url(); ?>/home/report/pengujian/rekap-status" title="Rekapitulasi Status Sampel"> Rekapitulasi Status Sampel</a></li>
                <?php
         }
         ?>
              </ul>
            </li>
            <!-- End Report Pengujian !-->
            <!-- Report Iklan dan Penandaan !-->
            <?php
//       if ($this->newsession->userdata('SESS_BBPOM_ID') == "50") {
        if (in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) || in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))) {
         ?>
            <li><a href="#" title="Report, Pengawasan Iklan" class="hasChild"> Pengawasan Iklan </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/report/pengawasan/iklanReport" title="Laporan Pengawasan Iklan"> Laporan Pengawasan Iklan</a></li>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/report/pengawasan/iklanRHPK" title="Laporan RHPK Iklan"> Laporan RHPK</a></li>
                <li><a href="<?php echo site_url(); ?>/iklan/iklanController/report/pengawasan/iklanRekapStatus" title="Laporan Rekap Status Iklan"> Rekapitulasi Status Dokumen</a></li>
              </ul>
            </li>
            <?php } if (in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) || (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('10', $this->newsession->userdata('SESS_KODE_ROLE')))) { ?>
            <li><a href="#" title="Report, Pengawasan Penandaan" class="hasChild"> Pengawasan Penandaan </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/report/pengawasan/penandaanReport" title="Laporan Pengawasan Penandaan"> Laporan Pengawasan Penandaan</a></li>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/report/pengawasan/penandaanRHPK" title="Laporan RHPK Penandaan"> Laporan RHPK</a></li>
                <li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/report/pengawasan/penandaanRekapStatus" title="Laporan Rekap Status Penandaan"> Rekapitulasi Status Dokumen</a></li>
              </ul>
            </li>
            <!-- sub menu end -->
            <?php }
//} ?>
            <!-- End Report Iklan dan penandaan !-->
          </ul>
          <!-- sub menu end -->
        </li>
        <?php
if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('6', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
 ?>
        <li><a href="#" title="Master Data"> Master Data </a>
          <ul class="submenu">
            <li><a href="<?php echo site_url(); ?>/home/master/sarana" title="Master Data Sarana"> Sarana </a></li>
            <?php if (in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) { ?>
            <li><a href="<?php echo site_url(); ?>/home/master/mediaIklan/new" title="Master Data Media Iklan"> Media Iklan </a></li>
            <?php } if (!in_array('5', $this->newsession->userdata('SESS_KODE_ROLE')) || !in_array('6', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
            <li><a href="#" title="Master Data Produk" class="hasChild"> Produk </a>
              <ul class="submenu">
                <li><a href="http://www.pom.go.id/webreg/" target="_blank">Web Registrasi</a></li>
                <li><a href="<?php echo site_url(); ?>/home/master/lokal">Spefisik Lokal</a></li>
              </ul>
            </li>
            <?php } ?>
            <?php
			 if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
			  ?>
            <li><a href="#" title="Standar Ruang Lingkup Pengujian" class="hasChild"> Standar Ruang Lingkup </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/master/golongan"> Bentuk Sediaan / Golongan</a></li>
                <li><a href="<?php echo site_url(); ?>/home/master/parameter-uji"> Parameter Uji</a></li>
                <li class="separator">&nbsp;</li>
                <li><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik" title="Parameter Uji Spesifik Lokal">Parameter Uji Spesifik Lokal</a></li>
              </ul>
            </li>
            <?php
        }
        ?>
        
            <?php if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
            <li><a href="#" title="Petugas" class="hasChild"> Petugas </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/petugas/new" title="Petugas Baru"> Petugas Baru </a></li>
                <li><a href="<?php echo site_url(); ?>/home/petugas/list/aktif" title="Petugas Aktif"> Petugas Aktif </a></li>
                <li><a href="<?php echo site_url(); ?>/home/petugas/list/non-aktif" title="Petugas Non Aktif"> Petugas Non Aktif </a></li>
              </ul>
            </li>
            <?php if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
            <li><a href="#" title="Standar Ruang Lingkup Pengujian" class="hasChild"> Standar Ruang Lingkup </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/master/golongan"> Bentuk Sediaan / Golongan</a></li>
                <li><a href="<?php echo site_url(); ?>/home/master/parameter-uji"> Parameter Uji</a></li>
              </ul>
            </li>
            <li><a href="#" title="Prioritas Sampling" class="hasChild"> Prioritas Sampling </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/prioritas/kategori"> Kategori </a></li>
                <li><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji"> Parameter Uji </a></li>
              </ul>
            </li>
			<?php
         }
         if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
          ?>
            <li><a href="<?php echo site_url(); ?>/home/master/daerah" title="Produk"> Daerah </a></li>
            <?php if (in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
            <li><a href="#" title="Standar Ruang Lingkup Pengujian" class="hasChild"> Standar Ruang Lingkup </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/master/parameter-uji"> Parameter Uji</a></li>
              </ul>
            </li>
            <li><a href="#" title="Prioritas Sampling" class="hasChild"> Prioritas Sampling </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/prioritas/kategori"> Kategori </a></li>
                <li><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji"> Parameter Uji </a></li>
              </ul>
            </li>
            <?php
   }
   ?>
            <!-- Spesifik Lokal !-->
            <li><a href="#" title="Master Data Spesifik Lokal" class="hasChild"> Spesifik Lokal </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/master/golongan-spesifik" title="Data Golongan Spesifik Lokal">Golongan</a></li>
                <li><a href="<?php echo site_url(); ?>/home/master/parameter-uji-spesifik" title="Parameter Uji Spesifik Lokal">Parameter Uji Spesifik Lokal</a></li>
              </ul>
            </li>
            <!-- Akhir Spesifik Lokal !-->
            <?php
         }
         if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE')) && $this->newsession->userdata('SESS_BBPOM_ID') == "93" || $this->newsession->userdata('SESS_BBPOM_ID') == "00") {
          ?>
            <li><a href="<?php echo site_url(); ?>/home/master/pelanggaran" title="Master Data Pelanggaran"> Pelanggaran </a></li>
            <?php
   if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    ?>
            <li><a href="<?php echo site_url(); ?>/home/master/pverifikasi" title="Master Data Proses Verifikasi"> Verifikasi </a></li>
            <li><a href="<?php echo site_url(); ?>/home/master/bpom" title="Master Data BBPOM / BPOM"> BBPOM / BPOM </a></li>
            <?php
          }
         }
        } #Admin, Admin Balai / Unit
        ?>
            <li><a href="<?php echo site_url(); ?>/home/master/mediaIklan/list" title="Master Data Media Iklan"> Media Iklan </a></li>
          </ul>
        </li>
        <!-- Akhir Master Data !-->
        <?php
     }
     if (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {#Update Master Data SRL untuk MT
      ?>
        <li><a href="#" title="Master Data"> Master Data </a>
          <ul class="submenu">
            <li><a href="#" title="Standar Ruang Lingkup Pengujian" class="hasChild"> Standar Ruang Lingkup </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/master/golongan"> Bentuk Sediaan / Golongan</a></li>
                <li><a href="<?php echo site_url(); ?>/home/master/parameter-uji"> Parameter Uji</a></li>
              </ul>
            </li>
            <li><a href="#" title="Prioritas Sampling" class="hasChild"> Prioritas Sampling </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/prioritas/kategori"> Kategori </a></li>
                <li><a href="<?php echo site_url(); ?>/home/prioritas/parameter-uji"> Parameter Uji </a></li>
              </ul>
            </li>
          </ul>
        </li>
        <?php
     }
     ?>
        <?php ?>
        <?php if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
        <li><a href="#" title="Monitoring"> Monitoring </a>
          <ul class="submenu">
            <li><a href="#" title="Grafik" class="hasChild"> Grafik </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/utility/sarana" title="Dashboard, Pemeriskaan Sarana">Data Sarana</a></li>
                <li><a href="<?php echo site_url(); ?>/home/utility/grafik/pemeriksaan" title="Dashboard, Pemeriksaan Sarana">Data Jenis Sarana</a></li>
              </ul>
            </li>
            <li><a href="<?php echo site_url(); ?>/home/utility/log" title="Aktivitas Pengguna"> Aktivitas Pengguna </a></li>
            <li><a href="<?php echo site_url(); ?>/home/utility/session" title="Sesi Pengguna"> Sesi Pengguna </a></li>
            <li><a href="<?php echo site_url(); ?>/home/utility/wslog" title="WS Log Sinkronisasi Modul Offline"> WS Log Sinkronisasi </a></li>
          </ul>
          <!-- sub menu end -->
        </li>
        <?php } ?>
        <li><a href="#" title="Utility"> Utility </a>
          <ul class="submenu">
            <li><a href="<?php echo site_url(); ?>/home/utility/news" title="News Update Aplikasi"> News Update Aplikasi</a></li>
            <li><a href="#" title="Frequently Asked Questions" class="hasChild"> FAQ </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/utility/faq/draft" title="Draft FAQ"> Draft FAQ </a></li>
                <li><a href="<?php echo site_url(); ?>/home/utility/faq/publish" title="FAQ"> FAQ </a></li>
                <?php if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))) { ?>
                <li><a href="<?php echo site_url(); ?>/home/utility/faq/unpublish" title="Unpublish FAQ"> Unpublish FAQ </a></li>
                <li><a href="<?php echo site_url(); ?>/home/utility/faq/reference" title="Referensi FAQ"> Referensei FAQ </a></li>
                <?php } ?>
              </ul>
            </li>
            <li><a href="#" class="hasChild">Download Center</a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/download/data/Juknis_Pemeriksaan_Sarana.pdf" title="Download Juknis Pemeriksaan Sarana">Juknis Pemeriksaan Sarana</a></li>
                <li><a href="<?php echo site_url(); ?>/download/data/Juknis_Sampling_Pengujian_Versi_II_06032014.rar" title="Download Juknis Sampling dan Pengujian">Juknis Sampling dan Pengujian</a></li>
                <li><a href="<?php echo site_url(); ?>/download/data/SIPT-OFFLINE.rar" title="Download SIPT Modul Offline (Sarana Distribusi)">SIPT Modul Offline</a></li>
                <li><a href="<?php echo site_url(); ?>/download/data/UPLOAD_EXCEL.rar" title="Download Format Upload Temuan Produk dalam bentuk file excel">Format Upload Temuan Produk</a></li>
              </ul>
            </li>
            <?php
if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))) {
 ?>
            <li><a href="#" title="Tools SIPT" class="hasChild"> Tools </a>
              <ul class="submenu">
                <li><a href="<?php echo site_url(); ?>/home/tools/pemeriksaan-sarana" title="Pemeriksaan Sarana">Pemeriksaan Sarana </a></li>
                <?php
          if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
           ?>
                <li><a href="<?php echo site_url(); ?>/home/tools/sampling-pengujian" title="Sampling dan Pengujian">Sampling Pengujian </a></li>
                <!-- <li><a href="#" title="Pemantauan Iklan">Pemantauan Iklan </a></li>!-->
                <!-- <li><a href="#" title="Penandaan Label">Penandaan Label </a></li>!-->
                <li><a href="#" title="Setting Penomoran Kode Sampel, SPU, SPS, SPK, SPP, CP dan LHU" class="hasChild">Setting Penomoran</a>
                  <ul class="submenu">
                    <li><a href="<?php echo site_url(); ?>/home/setting/sampel">Sampel</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/spu">Permintaan Uji</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/sps">Penerimaan Sampel</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/spk">Perintah Kerja</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/spp">Perintah Pengujian</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/uji">Pengujian Lab</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/cp">Catatan Pengujian</a></li>
                    <li><a href="<?php echo site_url(); ?>/home/setting/lhu">Laporan Hasil Uji</a></li>
                  </ul>
                </li>
                <?php
			}
			?>
              </ul>
            </li>
            <?php
}
?>
          </ul>
          <!-- sub menu end -->
        </li>
        <li><a href="#" title="Jenis Pelaporan"> Profil </a>
          <ul class="submenu">
            <li><a href="<?php echo site_url(); ?>/home/user/profil" title="Profil, Ubah Profil">Ubah Profil</a></li>
            <li><a href="<?php echo site_url(); ?>/home/user/password" title="Profil, Ubah Password">Ubah Password</a></li>
          </ul>
        </li>
        <!-- sub menu end -->
        </li>
        <li><a href="<?php echo site_url(); ?>/home/logout" title="Keluar"> Keluar </a></li>
      </ul>
    </div>
    <!-- End Menu !-->
    <div id="welcomebox">
      <div>Selamat Datang <b>{_name_}</b></div>
      <div id="info">
        <?php if ($this->newsession->userdata('SESS_BBPOM_ID') != "00") { ?>
        <div class="kiri">
          <div class="dropdown"><a href="#"> Notifikasi</a>
            <div>
              <ul id="notifall" url="<?php echo site_url(); ?>/load/utility/get_all">
              </ul>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="kanan">
          <ul id="news" class="tags green">
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div id="contentbox"> {_content_} </div>
  <div class="footer"> <b>Sistem Informasi Pelaporan Terpadu</b> Versi 1.0<br />
    Copyright &copy; 2011 - BPOM </div>
</div>
<div id="indicator">Memuat ...</div>
<div id="modal_pop"></div>
<div id="pengumuman">
<!--<div id="pengumuman" style="display:none;">!-->
  <marquee>
  Untuk penambahan Parameter uji pada Komoditi Obat Prioritas Sampling 2015 bisa merujuk ke <a href="<?php echo site_url(); ?>/home/utility/faq/new/206" target="_blank">FAQ No. 206</a>. Dan untuk penambahan Parameter Uji Sampling 2014 seluruh komoditi bisa merujuk <a href="<?php echo site_url(); ?>/home/utility/faq/new/177" target="_blank">FAQ No. 177</a>
  </marquee>
</div>
</body>
</html>