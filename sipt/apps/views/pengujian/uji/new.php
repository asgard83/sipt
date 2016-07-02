<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fuji" id="fuji" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENGUJIAN</a></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small garis">Informasi Surat Perintah Pengujian</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Berdasarkan :</td>
              <td class="td_right bold">&nbsp;</td>
            </tr>
            <tr>
              <td class="td_left">Nomor Surat Perintah Pengujian</td>
              <td class="td_right bold" width="300"><?php echo $sp[0]['UR_SPP'];  ?></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Surat Perintah Pengujian</td>
              <td class="td_right bold"><?php echo $sp[0]['TGL_SPP']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Nomor Surat Perintah Kerja</td>
              <td class="td_right bold"><?php echo $sp[0]['UR_SPK']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Surat Perintah Kerja</td>
              <td class="td_right bold"><?php echo $sp[0]['TGL_SPK']; ?></td>
            </tr>
            <tr>
              <td class="td_left">&nbsp;</td>
              <td class="td_right">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="td_left">Agar dilakukan pengujian kode sampel <b><?php echo $sampel[0]['UR_KODESAMPEL']; ?></b>, sesuai dengan parameter uji di bawah ini.</td>
            </tr>
          </table>
          <div style="height:5px;">&nbsp;</div>
          <h2 class="small garis">Informasi Sampel</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left">Kode Sampel</td>
              <td class="td_right bold"><b><?php echo $sampel[0]['UR_KODESAMPEL']; ?></b></td>
            </tr>
            <tr>
              <td class="td_left">Pemerian</td>
              <td class="td_right">
			  	<?php
			  	if(strlen($sampel[0]['PJ_PEMERIAN']) == 0 || $sampel[0]['PJ_PEMERIAN'] == "NULL" || $sampel[0]['PJ_PEMERIAN'] == ""){
				?>
                	<textarea class="stext" name="PEMERIAN" rel="required" title="Pemerian" style="height:50px;"></textarea>
                <?php
				}else{
					echo $sampel[0]['PEMERIAN'];
			    }?></td>
            </tr>
          </table>
          <table class="form_tabel" width="100%">
            <tr>
              <td class="td_left">Komoditi</td>
              <td class="td_right" style="width:300px;"><?php echo $sampel[0]['KOMODITI']; ?></td>
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
              <td width="10"></td>
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
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PARAMETER UJI DAN HASIL PENGUJIAN</a></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small garis">Form Hasil Uji</h2>
          <table class="form_tabel" width="100%">
            <tr>
              <td class="td_left">Kode Sampel</td>
              <td class="td_right"><?php echo $sampel[0]['UR_KODESAMPEL']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Jumlah sampel yang diterima</td>
              <td class="td_right"><input type="text" id="jterima" class="sdate" title="Jumlah sampel yang diterima" value="<?php echo in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) ? $jml[0]['JUMLAH_KIMIA'] : $jml[0]['JUMLAH_MIKRO']; ?>" readonly/>
                &nbsp; <?php echo $jml[0]['SATUAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Sisa Sampel</td>
              <td class="td_right"><input type="text" class="scode" id="sisa_uji" readonly value="<?php echo in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) ? $sampel[0]['SISA_KIMIA'] : $sampel[0]['SISA_MIKRO']; ?>" title="Sisa sampel yang diuji <?php echo in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) ? 'kimia' : 'mikro' ?>" /></td>
            </tr>
          </table>
          <?php
                 $jparams = count($sess);
                 if($jparams > 0){
                     for($i=0; $i < $jparams; $i++){
                         ?>
          <div>
            <input type="hidden" name="UJI[UJI_ID][]" value="<?php echo $sess[$i]['UJI_ID']; ?>" />
            <input type="hidden" name="UJI[PENGUJI][]" value="<?php echo $sess[$i]['PENGUJI']; ?>" />
            <table class="listtemuan" width="100%">
              <tr style="background:#e7e7e7;">
                <td width="300"><b>Parameter Uji</b></td>
                <td width="100"><b>Metode</b></td>
                <td width="350"><b>Pustaka</b></td>
                <td><b>Syarat</b></td>
              </tr>
              <tr>
                <td><?php echo $sess[$i]['PARAMETER_UJI']; ?></td>
                <td><?php echo $sess[$i]['METODE']; ?></td>
                <td><?php echo $sess[$i]['PUSTAKA']; ?></td>
                <td><?php echo $sess[$i]['SYARAT']; ?></td>
              </tr>
            </table>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Mulai Diuji </td>
                <td class="td_right"><input type="text" class="sdate datepick" title="Mulai Di Uji" name="UJI[AWAL_UJI][]" value="<?php echo $sp[0]['TGL_SPP']; ?>" rel="required" /></td>
                <td></td>
                <td class="td_left">Selesai Diuji</td>
                <td class="td_right"><input type="text" class="sdate datepick" title="Selesai Di Uji" name="UJI[AKHIR_UJI][]" value="<?php echo $sess[$i]['AKHIR_UJI']; ?>" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Jumlah Sampel</td>
                <td colspan="4" class="td_right"><div style="padding-bottom:5px;"><span>Diuji </span><span style="margin-left:39px;">
                    <input type="text" class="sdate jpakai" ke="<?php echo $i; ?>" title="Jumlah sampel yang diuji" name="UJI[JUMLAH_UJI][]" value="<?php echo $sess[$i]['JUMLAH_UJI'] == 0 ? '0' : $sess[$i]['JUMLAH_UJI']; ?>" rel="required" id="jpakai<?php echo $i; ?>" onkeyup="numericOnly($(this))"/>
                    </span></div></td>
              </tr>
              <tr>
                <td class="td_left">Hasil Kualitatif</td>
                <td class="td_right"><textarea class="stext" name="UJI[HASIL][]" rel="required" title="Hasil Kualitatif"><?php echo $sess[$i]['HASIL']; ?></textarea></td>
                <td></td>
                <td class="td_left">Hasil Kuantitatif</td>
                <td class="td_right"><textarea class="stext" name="UJI[HASIL_KUALITATIF][]" rel="required" title="Hasil Kuantitatif"><?php echo $sess[$i]['HASIL_KUALITATIF']; ?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">LCP</td>
                <td class="td_right"><span class="upload_LCP<?php echo $i; ?>">
                  <input type="file" class="stext upload" allowed="xls-doc-xlsx-docx-pdf-rar-zip" ke="<?php echo $i; ?>" url="<?php echo site_url(); ?>/utility/uploads/set_lcp/<?php echo $sess[$i]['KODE_SAMPEL'];?>" id="fileToUpload_LCP<?php echo $i; ?>" title="File Lampiran Catatan Pengujian" name="userfile" onchange="do_upload($(this)); return false;"/>
                  &nbsp;
                  <div>Tipe File : *.xls, *.xlsx, *.doc, *.docx, *.rar, *.zip, *.pdf</div>
                  </span><span class="file_LCP<?php echo $i; ?>"><input type="hidden" name="UJI[LCP][]" value="" /></span></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
	    <tr>
                <td class="td_left" colspan="5">
			<div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
				<p><b>Hasil Pengujian TMS (Tidak Memenuhi Syarat) wajib melampirkan LCP</b></p>
			</div>
		</td>
              </tr>
            </table>
          </div>
          <div style="height:2px; padding-bottom:4px; padding-top:4px; border-bottom:1px solid #3c7faf">&nbsp;</div>
          <div style="height:10px;">&nbsp;</div>
          <?php
                     }
                 }else{
                     ?>
          <div>Tidak ditemukan data parameter uji dengan kode sampel : <b><?php echo $kode_sampel; ?></b>
            <?php
                 }
                 ?>
          </div>
        </div>
      </div>
      <div style="height:10px;">&nbsp;</div>
      <div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fuji','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
      <div style="height:10px;">&nbsp;</div>
    </div>
    <input type="hidden" name="KODE_SAMPEL" value="<?php echo $kode_sampel; ?>" />
    <input type="hidden" name="SPK_ID" value="<?php echo $spk_id; ?>" />
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var jsisa = $("#sisa_uji").val();
		var total = parseFloat($("#jterima").val()).toFixed(2);
		$('input.datepick').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
		$(".del_upload").live("click", function(){
			var ke = $(this).attr("ke");
			$.ajax({
				type: "GET",
				url: $(this).attr("url"),
				data: $(this).serialize(),
				success: function(data){
					var arrdata = data.split("#");
					$(".upload_LCP"+ke+"").show();
					$("#fileToUpload_LCP"+ke+"").val('');
					$(".file_LCP"+ke+"").html("");
				}
			});
			return false;
		});
		
		$(".jpakai").blur(function(){
			var ke = $(this).attr("ke");
			var jml = 0;
			if($(this).val() > parseFloat($("#jterima").val())){
				jAlert('Jumlah sampel yang di uji melebihi jumlah sampel yang diterima','SIPT versi 1.0');
				$("#jpakai"+ke+"").focus();
				$("#jpakai"+ke+"").val('0');
				return false;
			}
			$(".jpakai").each(function(){
				jml += parseFloat($(this).val());
			});
			if(parseFloat(jsisa) > 0){
				sisa = parseFloat(jsisa) - parseFloat(jml);
			}else{
				sisa = parseFloat($("#jterima").val()) - parseFloat(jml);
			}
			if(parseFloat(sisa) < 0){
				jAlert('Jumlah sampel diterima dikurangi dengan jumlah yang dipakai mohon diperiksa kembali','SIPT versi 1.0');
				if(parseFloat(jsisa) > 0){
					sisa = parseFloat($("#sisa_uji").val()) - parseFloat(jml);
				}else{
					sisa = parseFloat($("#jterima").val()) - parseFloat($("#sisa_uji").val());
				}
				$("#sisa_uji").val(parseFloat(sisa).toFixed(2));
				$(this).val('0');
				$(this).focus();
				return false;
			}else{
				$("#sisa_uji").val(parseFloat(sisa).toFixed(2));
			}
		});
	});
	
	function do_upload(element){
		var allowed = $(element).attr("allowed");
		var ke = $(element).attr("ke");
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0 ");
					}else{
						$(".upload_LCP"+ke+"").hide();
						$("#fileToUpload_LCP"+ke+"").removeAttr("rel");
						$(".file_LCP"+ke+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/LCP/"+arrdata[2]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[2]+"/"+arrdata[0]+"\" ke="+ke+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"UJI[LCP][]\" value="+arrdata[0]+">");
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}
</script>