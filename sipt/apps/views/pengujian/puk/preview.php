<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fnewparam" id="freviewpuk" method="post" autocomplete="off" action="<?= $act; ?>">
    <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">View Parameter Uji Kritis</a></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small garis">Informasi Sampel</h2>
            <table class="form_tabel" width="100%">
              <tr>
                <td class="td_left">Kode Sampel</td>
                <td class="td_right" style="width:300px;"><b><?php echo $sess['UR_KODESAMPEL']; ?></b></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right" style="width:300px;"><?php echo $sess['UR_KOMODITI']; ?></td>
                <td width="10"></td>
                <td class="td_left">Komoditi Tambahan</td>
                <td class="td_right"><?php echo $sess['KLASIFIKASI_TAMBAHAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama sampel</td>
                <td class="td_right"><?php echo $sess['NAMA_SAMPEL'];?></td>
                <td width="10"></td>
                <td class="td_left">No Registrasi</td>
                <td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kategori sampel</td>
                <td class="td_right"><?php echo $sess['UR_KATEGORI']; ?></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Asal Sampling</td>
                <td class="td_right"><b><?php echo $sess['ASAL_SAMPEL'];?></b></td>
                <td width="10"></td>
                <td class="td_left">Tujuan Sampling</td>
                <td class="td_right"><b><?php echo $sess['TUJUAN_SAMPLING']; ?></b></td>
              </tr>
              <tr>
                <td class="td_left">Pabrik</td>
                <td class="td_right"><?php echo $sess['PABRIK']; ?></td>
                <td width="10"></td>
                <td class="td_left">Importir</td>
                <td class="td_right"><?php echo $sess['IMPORTIR']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Bentuk Sediaan sampel</td>
                <td class="td_right"><?php echo $sess['BENTUK_SEDIAAN']; ?></td>
                <td width="10"></td>
                <td class="td_left">Kemasan sampel</td>
                <td class="td_right"><?php echo $sess['KEMASAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">No Bets</td>
                <td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
                <td width="10"></td>
                <td class="td_left">Keterangan ED</td>
                <td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Komposisi</td>
                <td class="td_right"><?php echo $sess['KOMPOSISI']; ?></td>
                <td width="10"></td>
                <td class="td_left">Netto</td>
                <td class="td_right"><?php echo $sess['NETTO']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Evaluasi Penandaan</td>
                <td class="td_right"><?php echo $sess['EVALUASI_PENANDAAN']; ?></td>
                <td width="10"></td>
                <td class="td_left">Cara Penyimpanan</td>
                <td class="td_right"><?php echo $sess['CARA_PENYIMPANAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kondisi sampel</td>
                <td class="td_right"><?php echo $sess['KONDISI_SAMPEL']; ?></td>
                <td width="10"></td>
                <td class="td_left">Jumlah sampel</td>
                <td class="td_right"><?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>&nbsp;&nbsp;<?php echo $sess['SATUAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Segel sampel</td>
                <td class="td_right"><?php echo $sess['SEGEL']; ?></td>
                <td></td>
                <td class="td_left">Label sampel</td>
                <td class="td_right"><?php echo $sess['LABEL']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pengujian</td>
                <td class="td_right"><div style="padding-bottom:5px;"><span <?php echo $sess['UJI_KIMIA'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Kimia</span>&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?></div>
                  <div style="padding-bottom:5px;"><span <?php echo $sess['UJI_MIKRO'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Mikro</span>&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?></div>
                  <div><span>Sisa</span>&nbsp;<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?></div></td>
                <td></td>
                <td class="td_left">Harga Pembelian</td>
                <td class="td_right"><?php echo $sess['HARGA_SAMPEL']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><?php echo $sess['CATATAN']; ?></td>
                <td></td>
                <td class="td_left">Lampiran File</td>
                <td class="td_right"><?php
			  if(trim($sess['LAMPIRAN']) != ""){
			  ?>
                  <a href="<?php echo $file; ?>" target="_blank">Preview Photo</a>
                  <?php
			  }
			  ?></td>
              </tr>
            </table>
          <h2 class="small garis">Daftar Parameter Uji</h2>
          <?php
		  if($input){
		  ?>
          <div style="height:10px;">&nbsp;</div>
          <table class="form_tabel" width="100%">
          	<tr>
            	<td class="td_left">Proses</td>
                <td class="td_right"><?= form_dropdown('STATUS', $verifikasi, '', 'class="stext" rel="required" title="Proses verifikasi PUK" id="chkproses"'); ?></td>
            </tr>
          </table>
          <?php
		  }
		  ?>
          <table class="listtemuan" width="100%">
            <thead>
              <tr>
                <th width="200">Ketetuan Khusus</th>
                <th width="200">Parameter Uji</th>
                <th width="75">Metode</th>
                <th width="100">Pustaka</th>
                <th width="75">Syarat</th>
                <th width="75">Diuji</th>
              </tr>
            </thead>
            <tbody id="list-parameter">
              <?php
				$jml = count($puk);
				if($jml > 0){
					for($i = 0; $i < $jml; $i++){
					  ?>
              <tr id="<?php echo $puk[$i]['PUK_ID'].'-'.$puk[$i]['SERI']; ?>">
                <td><?php echo $puk[$i]['KETERANGAN']; ?>
                <td><?php echo $puk[$i]['PARAMETER_UJI']; ?>
                  <input type="hidden" name="PUK[PUK_ID][]" value="<?= $puk[$i]['PUK_ID']; ?>">
                  <input type="hidden" name="PUK[SERI][]" value="<?= $puk[$i]['SERI']; ?>"></td>
                <td><?php echo $puk[$i]['METODE']; ?></td>
                <td><?php echo $puk[$i]['PUSTAKA']; ?></td>
                <td><?php echo $puk[$i]['SYARAT']; ?></td>
                <td>
                <?
				if($revisi){
					?>
                    <?= form_dropdown('PUK[STATUS][]', $cbuji, $puk[$i]['STATUS'], 'class="sdate" title="Diuji / Tidak Diuji"'); ?>
                    <?php
				}
				else
				{
				?>
                <span class="view"><?= $puk[$i]['STATUS'] == "1" ? "Diuji" : "Tidak Diuji"; ?></span>
				<span class="editable"><?= form_dropdown('PUK[STATUS][]', $cbuji, $puk[$i]['STATUS'], 'class="sdate" title="Diuji / Tidak Diuji"'); ?></span>
                <?php
				}
				?>
                </td>
              </tr>
              <?php
					}
				}else{
				?>
              <tr>
                <td colspan="6"><b>Data tidak ditemukan</b></td>
              </tr>
              <?php
							  }
							?>
            </tbody>
          </table>
          <?php
		  if($input || $revisi){
		  ?>
          <div style="height:10px;">&nbsp;</div>
          <table class="form_tabel" width="100%">
            <tr>
              <td class="td_left">Catatan</td>
              <td class="td_rigth"><textarea class="stext catatan" name="JUSTIFIKASI" rel="required" title="Catatan Review PUK" ></textarea></td>
            </tr>
          </table>
          <?php
		  }
		  ?>
        <div style="height:10px;"></div>
        <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_puk/<?php echo $sess['PUK_ID']; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log PUK (
          <?= $logpuk; ?>
          )</a></h2>
        <div id="detail_log"></div>
        </div>
      </div>
    </div>
    <input type="hidden" name="PUK_ID" value="<?php echo $sess['PUK_ID']; ?>" />
    <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
    <input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
    <input type="hidden" name="STTS" value="<?php echo $sess['STATUS']; ?>" />
  </form>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"> 
  <?php
  if($input || $proses)
  {
  ?>
  <a id="btn-proses" href="#" class="button check" onclick="fpost('#freviewpuk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a> 
  <?php
  }
  ?>
  &nbsp;<a href="#" class="button reload" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
</div>
<script>
	$(document).ready(function(e){
		$(".editable").css("display","none");
		$("#chkproses").change(function(e){
            var $this = $(this);
			if($this.val() == "00002"){
				$(".editable").css("display","");
				$(".view").css("display","none");
			}else{
				$(".editable").css("display","none");
				$(".view").css("display","");
			}
        });
    });
</script>