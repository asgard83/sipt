<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERMINTAAN UJI</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Informasi Data Surat Permintaan Uji</h2>
        <table class="form_tabel">
          <tr>
            <td class="td_left">Nomor Surat Permintaan Uji</td>
            <td class="td_right"><?php echo $sess['FORMAT_SPU']; ?></td>
          </tr>
          <tr>
            <td class="td_left">Tanggal Surat Permintaan Uji</td>
            <td class="td_right"><?php echo $sess['TANGGAL']; ?></td>
          </tr>
          <tr>
            <td class="td_left">Anggaran Sampling</td>
            <td class="td_right"><?php echo $sess['ANGGARAN']; ?></td>
          </tr>
          <tr>
            <td class="td_left">Asal Sampel</td>
            <td class="td_right"><?php echo $sess['ASAL SAMPEL']; ?></td>
          </tr>
          <tr>
            <td class="td_left">Komoditi</td>
            <td class="td_right"><?php echo $sess['KOMODITI']; ?></td>
          </tr>
        </table>
        <div style="height:20px;">&nbsp;</div>
      </div>
      <!-- Akhir Informasi SPU!-->
      
      <div style="height:5px;">&nbsp;</div>
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DATA SAMPLING</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Lampiran Detail Data Sampling</h2>
        <div><?php echo $tabel; ?></div>
        <div style="height:5px;">&nbsp;</div>
        <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
          <p><b>Keterangan :</b></p>
          <p>Untuk detil data sampel klik link pada tiap-tiap nama sampel</p>
        </div>
        <?php
		if($showjml > 1){
		?>
        <div style="height:5px;">&nbsp;</div>
        <div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
          <p>Ada beberapa sampel yang diperbaiki pada Nomor <?php echo $sess['FORMAT_SPU']; ?>, klik <a href="#" id="showtolak" url="<?php echo site_url(); ?>/get/pengujian/status/<?php echo $sess['SPU_ID']; ?>" onclick="expand_detail($(this), 'detil-tolak'); return false;">disini</a> untuk detil data yang diperbaiki</a>
          <div style="padding-top:5px; padding-bottom:5px;" id="detil-tolak"></div>
        </div>
        <?php
		}
		if(!in_array('B5',$this->newsession->userdata('SESS_SUB_SARANA')) && in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
			if($chkmikro > 0){
			?>
        <div style="height:5px;">&nbsp;</div>
        <div style="background:#ffffa4; border:1px solid #ccc; padding:5px;"> Terdapat sebanyak <b><?php echo $chkmikro; ?></b> sampel yang memerlukan uji mikrobiologi. Klik <a href="<?php echo site_url(). '/home/ppomn/spk/new/'.$sess['SPU_ID'].'.'.$sess['STATUS']; ?>"><b>disini</b></a> untuk memohon uji ke bidang mikrobiologi. </div>
        <?php
			}
		}
		?>
      </div>
      <!-- Akhir Informasi Data Sampel !-->
      
      <div style="height:5px;">&nbsp;</div>
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LOG SPU</a></div>
      <div class="accCntnt">
        <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_spu/<?php echo $id; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log SPU (
          <?= $jml_log; ?>
          )</a></h2>
        <div id="detail_log"></div>
      </div>
      <?php
	  if(count($status) > 1){
	  ?>
      <div style="height:5px;">&nbsp;</div>
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Verifikasi Surat Permintaan Uji</h2>
        <form action="<?php echo $act; ?>" id="fver-spu" method="post" autocomplete="off">
          <table class="form_tabel">
            <?php
          	if(in_array('8', $this->newsession->userdata('SESS_KODE_ROLE'))){
			?>
            <tr>
              <td class="td_left">Diterima di TPS Tanggal</td>
              <td class="td_right"><?php echo $sess['TANGGAL_TERIMA_TPS']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Petugas Penerima Sampel</td>
              <td class="td_right"><?php
							$ada = strpos(strtolower($sess['PETUGAS_PENERIMA']), ";");
							if($ada === false ){
								echo $sess['PETUGAS_PENERIMA'];
							}else{
								$petugas = explode(";", $sess['PETUGAS_PENERIMA']);
								array_pop($petugas);
								echo join("<br>",$petugas);
							}
							?></td>
            </tr>
            <tr>
              <td class="td_left">Mengetahui Ka. PPOMN</td>
              <td class="td_right"><input type="text" class="stext" title="Petugas penerima sampel" readonly="readonly" value="<?php echo $kabalai[0]; ?>" />
                <input type="hidden" name="TTD_MP" value="<?php echo $kabalai[1]; ?>" /></td>
            </tr>
            <tr>
              <td class="td_left">Catatan</td>
              <td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td>
            </tr>
            <?php 
			} 
			?>
          </table>
          <input type="hidden" name="GET_DISPO" value="<?php echo $get_dispo; ?>" />
          <input type="hidden" name="SPU_ID" value="<?php echo $id; ?>" />
        </form>
        <div style="height:20px;">&nbsp;</div>
      </div>
      <!-- Akhir Verifikasi SPU!-->
      
      <div style="height:10px;">&nbsp;</div>
      <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fver-spu','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button back" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
      <div style="height:10px;">&nbsp;</div>
      <?php
	  }else{
	  ?>
      <div style="height:10px;">&nbsp;</div>
      <div style="padding-left:5px;"><a href="#" class="button back" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
      <div style="height:10px;">&nbsp;</div>
      <?php
	  }
	  ?>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
    });
</script>