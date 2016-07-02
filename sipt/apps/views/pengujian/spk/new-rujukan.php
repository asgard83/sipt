<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<?php 
if($existing > 0)
	$allowed = FALSE;
else
	$allowed = TRUE;
if(!$allowed){
?>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH KERJA</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Surat perintah kerja sudah dibuat.</h2>
        <div style="padding-left:5px;"><a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
      </div>
    </div>
  </div>
</div>
<?php
}else{
?>
<div class="content">
  <form name="fspk" id="fspk" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA SAMPEL</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Perintah Pengujian</h2>
            <table class="form_tabel" width="100%">
              <tr>
                <td class="td_left">Nomor Surat Perintah Pengujian</td>
                <td class="td_right bold" style="width:300px;"><?php echo $sampel[0]['UR_SPP'];  ?></td>
                <td></td>
                <td class="td_left">Tanggal Surat Perintah Pengujian</td>
                <td class="td_right bold"><?php echo $sampel[0]['TGL_SPP']; ?></td>
              </tr>
            </table>
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
          </div>
        </div>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PARAMETER UJI</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <?php
			if($notallowed){#Jika Sudah Entri Parameter Uji
			?>
            <h2 class="small garis">Informasi Tanggal Surat Perintah Kerja</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left bold">Tanggal Surat Perintah Kerja</td>
                <td class="td_right"><?php echo $sess['TANGGAL']; ?></td>
              </tr>
              <tr>
                <td class="td_left bold">Nama Penyelia</td>
                <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
              </tr>
            </table>
            <h2 class="small garis">Penentuan</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th width="200">Parameter Uji</th>
                  <th width="75">Metode</th>
                  <th width="100">Pustaka</th>
                  <th width="75">Syarat</th>
                  <!-- <th width="75">Ruang Lingkup</th> !-->
				  <th width="75">Mampu Uji</th>
                </tr>
              </thead>
              <tbody>
                <?php
			  $jml = count($parameter);
			  if($jml > 0){
				  for($i = 0; $i < $jml; $i++){
					  ?>
                <tr>
                  <td><?php echo $parameter[$i]['PARAMETER_UJI']; ?></td>
                  <td><?php echo $parameter[$i]['METODE']; ?></td>
                  <td><?php echo $parameter[$i]['PUSTAKA']; ?></td>
                  <td><?php echo $parameter[$i]['SYARAT']; ?></td>
                  <!-- <td><?php //echo $parameter[$i]['RUANG_LINGKUP']; ?></td> !-->
				  <td><?php echo $parameter[$i]['UJI_MAMPU']; ?></td>
                </tr>
                <?php
				  }
			  }else{
			  ?>
                <tr>
                  <td colspan="5"><b>Data tidak ditemukan</b></td>
                  <?php
			  }
			  ?>
              </tbody>
            </table>
            <?php
			}else{#Jika Belum Entri Parameter  Uji
			?>
            <h2 class="small garis">Informasi Tanggal Surat Perintah Kerja</h2>
            <table class="form_tabel">
              <tr>
              	<td class="td_left">Verifikasi</td>
                <td class="td_right">
                	<select id="cb_verifikasi" name="verifikasi" class="stext" title="Verifikasi data sampel dan parameter rujukan" wajib="yes">
                    	<option value="1">Diuji</option>
                    	<option value="0">Tidak diuji</option>
                    </select>
                </td>
              </tr>	
              <tr class="txtcatatan" style="display:none;">
              	<td class="td_left">Catatan</td>
                <td class="td_right"><textarea class="stext catatan" name="CATATAN_VERIFIKASI" id="catatan_verifikasi" title="Catatan verifikasi jika sampel rujukan tidak perlu di uji"></textarea></td>
              </tr>
              <tr class="inputspk">
                <td class="td_left bold">Tanggal Surat Perintah Kerja</td>
                <td class="td_right"><input type="text" class="sdate" rel="required" title="Tanggal Surat Perintah Keja" name="TANGGAL" id="tanggal_spk"/></td>
              </tr>
              <tr class="inputspk">
                <td class="td_left bold">Nama Penyelia</td>
                <td class="td_right"><input type="text" class="stext operator" title="Penyelia Penerima SPK" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>" id="acpenyelia" rel="required"/>
                  <input type="hidden" id="penyelia" name="KASIE" />
                  <input type="hidden" name="spuid" value="<?php echo $sampel[0]['SPU_ID']; ?>" />
                  <input type="hidden" name="kode_sampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
                  <input type="hidden" name="komoditi" value="<?php echo $sampel[0]['KOMODITI']; ?>" />
                  <input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
                  <input type="hidden" name="KODE_RUJUKAN" value="<?php echo $sampel[0]['KODE_RUJUKAN']; ?>" />
                </td>
              </tr>
            </table>
            <h2 class="small garis">Parameter Uji yang dirujuk</h2>
            <table class="listtemuan" width="100%" id="draft-parameter">
              <thead>
                <tr>
                  <th width="75">Bidang Uji</th>
                  <th width="200">Parameter Uji</th>
                  <th width="75">Metode</th>
                  <th width="100">Pustaka</th>
                  <th width="75">Syarat</th>
                  <!-- <th width="75">Ruang Lingkup</th> !-->
                  <th width="75">LCP</th>
                  <th width="75">Jumlah Sampel</th>
                  <th width="75">Balai Rujukan</th>
                </tr>
              </thead>
              <tbody id="body-paramater">
                <?php
			  $jml = count($paramrujuk);
			  if($jml > 0){
				  for($i = 0; $i < $jml; $i++){
					  ?>
                <tr>
                  <td><?php echo $paramrujuk[$i]['BIDANG_UJI']; ?><input type="hidden" name="UJI_ID[]" value="<?= $paramrujuk[$i]['UJI_ID']; ?>"></td>
                  <td><?php echo $paramrujuk[$i]['PARAMETER_UJI']; ?></td>
                  <td><?php echo $paramrujuk[$i]['METODE']; ?></td>
                  <td><?php echo $paramrujuk[$i]['PUSTAKA']; ?></td>
                  <td><?php echo $paramrujuk[$i]['SYARAT']; ?></td>
                  <!-- <td><?php //echo $paramrujuk[$i]['LINGKUP_UJI']; ?></td> !-->
                  <td>
                  <?php
				  if(strlen(trim($paramrujuk[$i]['LCP'])) > 0){
			      ?>
                      <a href="<?php echo base_url().'files/LCP/'.$sampel[0]['KODE_RUJUKAN'].'/'.$paramrujuk[$i]['LCP']; ?>" target="_blank">LCP</a>
                   <?php
				   }else{
				   ?>
                       Tidak melampirkan LCP
                   <?php
				   }
				   ?>
                  </td>
                  <td><?php echo $paramrujuk[$i]['JUMLAH_SAMPEL']; ?></td>
                  <td><?php echo $paramrujuk[$i]['BALAI_TUJUAN']; ?></td>
                </tr>
                <?php
				  }
			  }else{
			  ?>
                <tr>
                  <td colspan="7"><b>Data tidak ditemukan</b></td>
                  <?php
			  }
			  ?>
              </tbody>
            </table>
            <?php    
			}
			?>
            <div style="height:10px;">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;">
  <a href="#" class="button download" id="clhu" url="<?php echo site_url(); ?>/topdf/lhu/konsep/<?php echo $sampel[0]['KODE_RUJUKAN']; ?>" onclick="blank_($(this)); return false;"><span><span class="icon"></span>&nbsp; Preview LHU Balai Asal &nbsp;</span></a>&nbsp;
    <?php
  if($notallowed){
	  ?>
    <a href="#" class="button download" onclick="batal($(this)); return false;" url="<?php echo site_url(); ?>/topdf/spk/prints/<?php echo $sampel[0]['KODE_SAMPEL']; ?>"><span><span class="icon"></span>&nbsp; Cetak SPK &nbsp;</span></a>
    <?php
  }else{
	  ?>
    <a href="#" class="button check" onclick="fpost('#fspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>
    <?php
  }?>
    &nbsp;<a href="#" class="button reload" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<div id="ctn-kategori-edit"></div>
<script>
	$(document).ready(function(e){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', minDate: new Date()});
		$("#acpenyelia").autocomplete($("#acpenyelia").attr('url'), {width: 244, selectFirst: false});
		$("#acpenyelia").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2]);
				$("#penyelia").val(data[1]);
				$(this).attr("readonly","readonly");
			}
		});
		$("#chkpenyelia").change(function(){
			if($(this).is(':checked')){
				$("#acpenyelia").attr("readonly","readonly");
				$("#acpenyelia").removeAttr("url");
			}else{
				$("#acpenyelia").removeAttr("readonly");
				$("#acpenyelia").attr("url","<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>");
				$("#penyelia").val('');
				$("#acpenyelia").val('');
			}
		});
		$("#cb_verifikasi").change(function(e){
            var $this = $(this);
			if($this.val() == 0){
				$(".inputspk").css("display","none");
				$("#tanggal_spk").removeAttr("rel");
				$("#acpenyelia").removeAttr("rel");
				$(".txtcatatan").css("display","");
			}else{
				$(".inputspk").css("display","");
				$("#tanggal_spk").attr("rel","required");
				$("#acpenyelia").attr("rel","required");
				$(".txtcatatan").css("display","none");
				$("#catatan_verifikasi").val('');
			}
			return false;
        });
    });
	
	function blank_(obj){
		var url = $(obj).attr("url");
		window.open(url, '_blank');
		return false;
	}
</script>
<?php
}
?>
