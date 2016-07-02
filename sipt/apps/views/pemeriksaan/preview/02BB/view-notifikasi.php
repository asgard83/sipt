<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana">Tindak Lanjut Bahan Berbahaya</div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
      <div class="collapse">
        <div class="accCntnt">
        <h2 class="small">Sarana Yang Diperiksa</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left">Nama Sarana Distribusi/Ritel/Toko/Apotek/PBF</td>
              <td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Bertindak Sebagai</td>
              <td class="td_right"><?php echo $sess['SARANA_BB']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Alamat Kantor</td>
              <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                  <?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?>
                </ul></td>
            </tr>
            <tr>
              <td class="td_left">Alamat Gudang</td>
              <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                  <?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?>
                </ul></td>
            </tr>
            <tr>
              <td class="td_left">Telepon</td>
              <td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
                  <?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?>
                </ul></td>
            </tr>
            <tr>
              <td class="td_left">Nomor Izin</td>
              <td class="td_right"><?php echo $sess['NOMOR_IZIN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Nama Pemilik / Pimpinan Usaha</td>
              <td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Nama Penanggung Jawab</td>
              <td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Tujuan Pemeriksaan</td>
              <td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Status Sarana</td>
              <td class="td_right"><?php echo $sess['STATUS_SARANA']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Pemeriksaan</td>
              <td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td>
            </tr>
          </table>
          <div style="height:5px;"></div>
          <h2 class="small">Detil Pengadaan B2, Distribusi B2 dan Repacking B2</h2>
          <div style="height:5px;"></div>
          <div id="laporan-bb" url="<?php echo site_url(); ?>/get/pemeriksaan/get_lap_bb/<?php echo $sess['PERIKSA_ID']; ?>"></div>
          <div style="height:5px;"></div>
          <h2 class="small">Konfirmasi Tindak Lanjut Sarana BB</h2>
          <div style="height:5px;"></div>
          <div>
          <form action="<?php echo $act; ?>" id="ftlbb" method="post" autocomplete="off">
          <table class="listtemuan" width="100%">
          <thead>
              <tr>
                  <th width="300">Nama Sarana</th>
                  <th>Konfirmasi Tindak Lanjut</th>
              </tr>
          </thead>
          <tbody>
          <?php
		  $jml = count($notifikasi);
		  if($jml > 0){
			  for($i = 0; $i < $jml; $i++){
				  ?>
                  <tr>
                  	<td><?php echo $notifikasi[$i]['NAMA_SARANA']; ?>
                    <div><?php echo $notifikasi[$i]['ALAMAT_SARANA']; ?></div>
                    <div><?php echo $notifikasi[$i]['SARANA_ID'] == "0" ? '(Tidak Terdapat di Master Data)' : ' <a href="javascript:void(0);" class="view-data" id="'.$notifikasi[$i]['SARANA_ID'].'">Lihat Data Sarana</a>'; ?></div>
                    </td>
                    <td>
                    <?php
					if($notifikasi[$i]['KONFIRM_PERIKSA'] == ""){
						if($notifikasi[$i]['DAERAH_ID'] == $this->newsession->userdata('SESS_PROP_ID')){
						?>
                        <input type="hidden" name="NOTIF[PERIKSA_ID][]" value="<?php echo $notifikasi[$i]['PERIKSA_ID']; ?>" />
                        <input type="hidden" name="NOTIF[ID_TMP][]" value="<?php echo $notifikasi[$i]['ID_TMP']; ?>" />
                        <div style="padding-bottom:5px;"><select class="stext" title="Pilih konfirmasi tindak lanjut" name="NOTIF[KONFIRM_PERIKSA][]" rel="required"><option value=""></option><option value="1">Telah Diperiksa</option></select></div>
                        <div><textarea class="stext catatan" title="Hasil konfirmasi tindak lanjut" rel="required" name="NOTIF[CATATAN][]"></textarea></div>
                        <?php
						}else{
							if(strlen($notifikasi[$i]['CATATAN']) == 0 )
							echo 'Agar segera melakukan verifikasi kebenaran data sarana dan menginput hasil verifikasi ke Master Data';
							else echo '<div style="padding-bottom:5px;">'.$notifikasi[$i]['CATATAN'].'</div><div>Diupdate oleh : '.$notifikasi[$i]['UPDATE_BY'].', '.$notifikasi[$i]['UPDATE_DATE'].'</div>';
						}
					}else{
						if(strlen($notifikasi[$i]['CATATAN']) == 0 )
						echo 'Agar segera melakukan verifikasi kebenaran data sarana dan menginput hasil verifikasi ke Master Data';
						else echo '<div style="padding-bottom:5px;">'.$notifikasi[$i]['CATATAN'].'</div><div>Diupdate oleh : '.$notifikasi[$i]['UPDATE_BY'].', '.$notifikasi[$i]['UPDATE_DATE'].'</div>';
					}
					?>
                    </td>
                  </tr>
                  <?php
			  }
		  }
		  ?>
          </tbody>
          </table>
          </form>
		  </div>
          
        </div>
      </div>
      <!-- Akhir Detil Pemeriksaaan !--> 
    </div>
  </div>
  <div id="clear_fix"></div>
  <div>
  <?php
  if($boleh == $this->newsession->userdata('SESS_PROP_ID')){
	  if(strlen($konfirm) == 0){
		  ?>
          <a href="#" class="button check" onclick="fpost('#ftlbb','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
          <?php
	  }
  }
  if($this->newsession->userdata('SESS_BBPOM_ID') == "96"){
  ?>
  <a href="<?php echo site_url(); ?>/home/notifikasi/cetak-form/<?php echo $id; ?>" target="_blank" class="button download"><span><span class="icon"></span>&nbsp; Cetak Form &nbsp;</span></a>&nbsp;
  <?php
  }
  ?>
  <a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
  <div id="clear_fix"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#laporan-bb").html('Loading..');
		$("#laporan-bb").load($("#laporan-bb").attr("url"));
	});
</script>