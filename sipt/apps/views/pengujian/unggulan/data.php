<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fdraftunggulan" id="fdraftunggulan" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA SAMPEL</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Informasi Sampel</h2>
            <table class="form_tabel" width="100%">
              <tr>
                <td class="td_left">Kode Sampel</td>
                <td class="td_right" style="width:300px;"><b><?php echo $sampel[0]['UR_KODESAMPEL']; ?></b></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right" style="width:300px;"><?php echo $sampel[0]['UR_KOMODITI']; ?></td>
                <td width="10"></td>
                <td class="td_left">Komoditi Tambahan</td>
                <td class="td_right"><?php echo $sampel[0]['KLASIFIKASI_TAMBAHAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama sampel</td>
                <td class="td_right"><?php echo $sampel[0]['NAMA_SAMPEL'];?></td>
                <td width="10"></td>
                <td class="td_left">No Registrasi</td>
                <td class="td_right"><?php echo $sampel[0]['NOMOR_REGISTRASI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kategori sampel</td>
                <td class="td_right"><?php echo $sampel[0]['UR_KATEGORI']; ?></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Asal Sampling</td>
                <td class="td_right"><b><?php echo $sampel[0]['ASAL_SAMPEL'];?></b></td>
                <td width="10"></td>
                <td class="td_left">Tujuan Sampling</td>
                <td class="td_right"><b><?php echo $sampel[0]['TUJUAN_SAMPLING']; ?></b></td>
              </tr>
              <tr>
                <td class="td_left">Pabrik</td>
                <td class="td_right"><?php echo $sampel[0]['PABRIK']; ?></td>
                <td width="10"></td>
                <td class="td_left">Importir</td>
                <td class="td_right"><?php echo $sampel[0]['IMPORTIR']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Bentuk Sediaan sampel</td>
                <td class="td_right"><?php echo $sampel[0]['BENTUK_SEDIAAN']; ?></td>
                <td width="10"></td>
                <td class="td_left">Kemasan sampel</td>
                <td class="td_right"><?php echo $sampel[0]['KEMASAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">No Bets</td>
                <td class="td_right"><?php echo $sampel[0]['NO_BETS']; ?></td>
                <td width="10"></td>
                <td class="td_left">Keterangan ED</td>
                <td class="td_right"><?php echo $sampel[0]['KETERANGAN_ED']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Komposisi</td>
                <td class="td_right"><?php echo $sampel[0]['KOMPOSISI']; ?></td>
                <td width="10"></td>
                <td class="td_left">Netto</td>
                <td class="td_right"><?php echo $sampel[0]['NETTO']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Evaluasi Penandaan</td>
                <td class="td_right"><?php echo $sampel[0]['EVALUASI_PENANDAAN']; ?></td>
                <td width="10"></td>
                <td class="td_left">Cara Penyimpanan</td>
                <td class="td_right"><?php echo $sampel[0]['CARA_PENYIMPANAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kondisi sampel</td>
                <td class="td_right"><?php echo $sampel[0]['KONDISI_SAMPEL']; ?></td>
                <td width="10"></td>
                <td class="td_left">Jumlah sampel</td>
                <td class="td_right"><?php echo array_key_exists('JUMLAH_SAMPEL', $sampel[0])?$sampel[0]['JUMLAH_SAMPEL']:"0"; ?>&nbsp;&nbsp;<?php echo $sampel[0]['SATUAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Segel sampel</td>
                <td class="td_right"><?php echo $sampel[0]['SEGEL']; ?></td>
                <td></td>
                <td class="td_left">Label sampel</td>
                <td class="td_right"><?php echo $sampel[0]['LABEL']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pengujian</td>
                <td class="td_right"><div style="padding-bottom:5px;"><span <?php echo $sampel[0]['UJI_KIMIA'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Kimia</span>&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sampel[0])?$sampel[0]['JUMLAH_KIMIA']:"0"; ?></div>
                  <div style="padding-bottom:5px;"><span <?php echo $sampel[0]['UJI_MIKRO'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Mikro</span>&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sampel[0])?$sampel[0]['JUMLAH_MIKRO']:"0"; ?></div>
                  <div><span>Sisa</span>&nbsp;<?php echo array_key_exists('SISA', $sampel[0])?$sampel[0]['SISA']:"0"; ?></div></td>
                <td></td>
                <td class="td_left">Harga Pembelian</td>
                <td class="td_right"><?php echo $sampel[0]['HARGA_SAMPEL']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><?php echo $sampel[0]['CATATAN']; ?></td>
                <td></td>
                <td class="td_left">Lampiran File</td>
                <td class="td_right"><?php
			  if(trim($sampel[0]['LAMPIRAN']) != ""){
			  ?>
                  <a href="<?php echo $file; ?>" target="_blank">Preview Photo</a>
                  <?php
			  }
			  ?></td>
              </tr>			  
            </table>
			<input type="hidden" name="KODE_SAMPEL" value="<?= $sampel[0]['KODE_SAMPEL']; ?>">
          </div>
        </div>
        <div style="height:5px;">&nbsp;</div>
		<div class="expand"><a title="expand/collapse" href="#" style="display: block;">Proses Data</a></div>    
		<div class="accCntnt">
    <?php
			if(count($proses)>1){
			?>
				<table class="form_tabel">
				  <?php
					echo $input;
					?>
				  <tr>
					<td class="td_left">Proses</td>
					<td class="td_right"><?php echo form_dropdown('STATUS',$proses,'','class="stext" title="Pilih salah satu, untuk memproses tindak lanjut hasil sampling" rel="required" style="width:500px;"', $disproses); ?></td>
				  </tr>
				  <tr>
					<td class="td_left">Catatan</td>
					<td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan verifikasi tindak lanjut hasil sampling" rel="required"></textarea></td>
				  </tr>
				</table>
            <?php				
			}
			?> 
		</div>
	  </div>
    </div>
  </form>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;">
    <?php
  if(count($proses)>1){
	  ?>
    <a href="#" class="button check" onclick="fpost('#fdraftunggulan','',''); return false;"><span><span class="icon"></span>&nbsp; Kirim Data &nbsp;</span></a>&nbsp;
    <?php
  }
  
  if($actkabalai){
	  ?>
    <a href="#" class="button check" onclick="fpost('#fdraftunggulan','',''); return false;"><span><span class="icon"></span>&nbsp; Kirim Ke Pusat &nbsp;</span></a>&nbsp;
    <?php
  }
  ?>

  <?php 
  $arrstat = array('70021','80021','70022');
  if(in_array($status_smpl,$arrstat)){
    ?>
        <a href="#" class="button download" id="pengantar" url="<?php echo site_url(); ?>/topdf/unggulan/surat_pengantar_unggulan/<?php echo $sampel[0]['KODE_SAMPEL']; ?>" onclick="blank_($(this)); return false;"><span><span class="icon"></span>&nbsp; Surat Pengantar &nbsp;</span></a>&nbsp;
        <?php
  }
  ?>

    <a href="#" class="button reload" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<script>
	$(document).ready(function(e){
    });
	function blank_(obj){
		var url = $(obj).attr("url");
		window.open(url, '_blank');
		return false;
	}
</script>