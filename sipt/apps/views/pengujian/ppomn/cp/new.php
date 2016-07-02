<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">FORM CATATATAN PENGUJIAN</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Data Sampel</h2>
        <form name="fcp" id="fcp" method="post" action="<?php echo $act; ?>" autocomplete="off">
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Kode Sampel</td>
              <td class="td_right" width="300"><?php echo $sess['KODE']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Nama Sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_SAMPEL']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Pengirim Sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Tempat dan Tanggal Sampling</td>
              <td class="td_right"><div><?php echo $sess['TEMPAT_SAMPLING']; ?></div>
                <div><?php echo $sess['ALAMAT_SAMPLING']; ?></div>
                <div>Tanggal, <?php echo $sess['TANGGAL_SAMPLING']; ?></div></td>
            </tr>
            <tr>
              <td class="td_left bold">Nomor Surat</td>
              <td class="td_right"><?php echo $sess['NOMOR_SURAT']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Tanggal Surat</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SURAT']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Terima</td>
              <td class="td_right"><?php echo $sess['TANGGAL_TERIMA_TPS']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Laboratorium</td>
              <td class="td_right">-</td>
            </tr>
            <tr>
              <td class="td_left bold">Kemasan / Netto</td>
              <td class="td_right"><?php echo $sess['KEMASAN']; ?> / <?php echo $sess['NETTO']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Komposisi</td>
              <td class="td_right"><?php echo $sess['KOMPOSISI']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Komoditi</td>
              <td class="td_right" width="300"><div><?php echo $sess['KOMODITI']; ?></div>
                <div><?php echo $sess['KATEGORI']; ?></div></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Nomor Registrasi</td>
              <td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">No. Batch</td>
              <td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Keterangan ED</td>
              <td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Pabrik</td>
              <td class="td_right"><?php echo $sess['PABRIK']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Importir</td>
              <td class="td_right"><?php echo $sess['IMPORTIR']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Segel Sampel</td>
              <td class="td_right"><?php echo $sess['SEGEL']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left bold">Label Sampel</td>
              <td class="td_right"><?php echo $sess['LABEL']; ?></td>
            </tr>
          </table>
          <h2 class="small garis">Hasil Pengujian</h2>
          <div style="height:5px;">&nbsp;</div>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Pemerian</td>
              <td class="td_right"><?php echo $sess['PEMERIAN']; ?></td>
            </tr>
          </table>
          <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
            <p>
              <input type="checkbox" id="chktolak" >
              &nbsp; <b>Tandai sebagai hasil pengujian yang ditolak.</b></p>
            <p class="phide" style="margin-left:22px;">Pilih salah satu atau beberapa parameter uji yang akan ditolak pada daftar hasil pengujian parameter di bawah ini</p>
          </div>
          <table class="listtemuan" width="100%">
            <thead>
              <tr>
                <th class="rwhidden">&nbsp;</th>
                <th>Uji yang dilakukan</th>
                <th>Hasil</th>
                <th>Syarat</th>
                <th>Metode</th>
                <th>Pustaka</th>
                <th>LCP</th>
                <th>Hasil</th>
              </tr>
            </thead	
		>
            <?php
			$jparameter = count($parameter);
			if($jparameter > 0){
				for($x = 0; $x < $jparameter; $x++){
					?>
            <tr>
              <td class="rwhidden"><input type="checkbox" class="chk_parameter" name="PU[STATUS][]" id="chk_<?php echo $parameter[$x]['UJI_ID']; ?>" value="30202" />
                <input type="hidden" name="PU[STATUS][]" value="30202"></td>
              <td><input type="hidden" name="PU[UJI_ID][]" value="<?php echo $parameter[$x]['UJI_ID']; ?>" />
                <?php echo $parameter[$x]['PARAMETER_UJI']; ?></td>
              <td><div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div>
                <div><?php echo $parameter[$x]['HASIL']; ?></div></td>
              <td><?php echo $parameter[$x]['SYARAT']; ?></td>
              <td><?php echo $parameter[$x]['METODE']; ?></td>
              <td><?php echo $parameter[$x]['PUSTAKA']; ?></td>
              <td><?php
						if(strlen(trim($parameter[$x]['LCP'])) > 0){
							?>
                <a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a>
                <?php
						}else{
							?>
                Tidak melampirkan LCP
                <?php
						}
						?></td>
              <td><?php echo form_dropdown('PU[HASIL_PARAMETER][]', $hasil_pu, '', 'class="sel_header" title="Pilih salah satu pilihan : MS atau TMS" rel="required"'); ?></td>
            </tr>
            <?php
				}
			}
		?>
          </table>
          <div style="height:5px;">&nbsp;</div>
          <?php
		$arrmin = explode("-",$tanggaluji[0]['MINTGL']);
		$arrmax = explode("-",$tanggaluji[0]['MAXTGL']);
		?>
          <table class="form_tabel">
            <tr class="hidden">
              <td class="td_left bold">Mulai diuji</td>
              <td class="td_right"><?php echo $arrmin[2]."/".$arrmin[1]."/".$arrmin[0]; ?>&nbsp; <b>selesai diuji</b>&nbsp;&nbsp;<?php echo $arrmax[2]."/".$arrmax[1]."/".$arrmax[0]; ?></td>
            </tr>
            <tr class="hidden">
              <td class="td_left bold">Kesimpulan Sampel</td>
              <td class="td_right"><?php echo form_dropdown('CP[HASIL]',$hasil,'','class="stext" title="Kesimpulan" id="hasil" rel="required"'); ?></td>
            </tr>
            <tr class="hidden">
              <td class="td_left bold">Sisa Contoh : habis / disimpan di </td>
              <td class="td_right"><?php
				if($sisa_uji > 0){
				?>
                <input type="text" class="stext" title="Sisa contoh" name="TEMPAT_SISA"  />
                <input type="hidden" name="SISA" value="<?php echo $sisa_uji; ?>"  />
                <?php
				}else{
				?>
                <input type="hidden" class="stext" name="SISA" value="0"  />
                habis
                <?php
				}
				?></td>
            </tr>
            <tr>
              <td class="td_left bold">Catatan</td>
              <td class="td_right"><textarea class="stext catatan" title="Catatan" name="CP[CATATAN]"></textarea></td>
            </tr>
            <tr class="hidden">
              <td class="td_left bold">Penguji</td>
              <td class="td_right"><?php
				$jpenguji = count($penguji);
				if($penguji > 0){
					$nama = "";
					for($i = 0; $i < $jpenguji; $i++){
						if($penguji[$i]['NAMA_USER'] != $nama){
							echo $penguji[$i]['NAMA_USER'] . "<br>";
						}
						$nama = $penguji[$i]['NAMA_USER'];
					}
				}
				?></td>
            </tr>
          </table>
          <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
          <input type="hidden" name="MT" value="<?php echo $kabid[0]['MT']; ?>" />
          <input type="hidden" name="SPU_ID" value="<?php echo $SPU_ID; ?>" />
          <input type="hidden" name="SPK_ID" value="<?php echo $SPK_ID; ?>" />
        </form>
      </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" id="btn-proses" class="button check" onclick="fpost('#fcp','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp; <a href="#" id="btn-tolak" style="display:none;" class="button cancel" onclick="ftolak('#fcp','',''); return false;"><span><span class="icon"></span>&nbsp; Tolak Data Pengujian &nbsp;</span></a>&nbsp;<a href="#" class="button back" onclick="javascript:history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".rwhidden, .phide").css("display","none");
		$('input.datepick').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$("#chktolak").change(function(){
			if($(this).attr("checked")){
				$("#fcp").attr("action", "<?php echo site_url().'/post/ppomn/cp_act/tolak'; ?>");
				$("#btn-tolak").show();
				$(".rwhidden").show();
				$(".phide").show();
				$("#btn-proses").hide();
				$(".hidden").hide();
			}else{
				$("#fcp").attr("action", "<?php echo site_url().'/post/ppomn/cp_act/save'; ?>");
				$("#btn-tolak").hide();
				$(".rwhidden").hide();
				$(".phide").hide();
				$(".chk_parameter").removeAttr("checked");
				$("#btn-proses").show();
				$(".hidden").show();
			}
		});
		$(".chk_parameter").change(function(){
			var id = $(this).attr("id");
			if($(this).attr("checked")){
				$("#"+id).attr("value","20202");
			}else{
				$("#"+id).attr("value","30202");
			}
			return false;
		});
	});
	
	function ftolak(formid){
		var pjg = $('.chk_parameter:checked').length;
		if(pjg == 0){
			jAlert('Maaf, tidak ada parameter uji yang ditolak. \n Silahkan pilih salah satu atau beberapa parameter uji yang akan ditolak \n pada daftar parameter uji di atas.','SIPT Versi 1.0');
			return false;
		}else{
			$.ajax({
				type: "POST", 
				url: $(formid).attr('action') + '/ajax', 
				data: $(formid).serialize(),
				error: function(){ 
					jAlert('Maaf, Request halaman tidak ditemukan', 'SIPT Versi 1.0'); 
				}, 
				beforeSend: function(){
					jLoadingOpen('','SIPT Versi 1.0');
				}, 
				complete: function(){ 
					jLoadingClose();
				},
				success: function(data){
					if(data.search("MSG")>=0){
						arrdata = data.split('#');
						if(arrdata[1]=="YES"){
							jAlert(arrdata[2],'SIPT Versi 1.0');
							if(arrdata.length>2) setTimeout(function(){location.href = arrdata[3];}, 1000); 
							return false;
						}else{
							jAlert(arrdata[2],'SIPT Versi 1.0');
						}
					}else{
						jAlert(arrdata[2],'SIPT Versi 1.0');
					}
					return false;  
				} 
			}); 
		}
		return false;
	}
</script>