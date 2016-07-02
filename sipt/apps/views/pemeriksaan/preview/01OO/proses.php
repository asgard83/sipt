<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f01OO_" id="f01OO_" method="post" action="<?php echo $act; ?>" autocomplete="off" enctype="multipart/form-data">
<div class="adCntnr">
    <div class="acco2">
    
    	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Informasi Sarana</h2>
              <table class="form_tabel">
              	<tr><td class="td_left">Nama Industrsi Farmasi</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td></tr>
                <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul></td></tr>
                <tr><td class="td_left">Alamat Pabrik / Gudang</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?></ul></td></tr>
                <tr><td class="td_left">Nomor Izin Industri Farmasi</td><td class="td_right"><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
                <tr><td class="td_left">Kegiatan yang dilakukan</td><td class="td_right">
                <?php if(trim($sess['KEGIATAN_SARANA']) != "") { 
				$kegiatan = explode("|", $sess['KEGIATAN_SARANA']);
				?>
                <ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php echo "<li>".join("</li><li>", $kegiatan)."</li>"; ?></ul>
                <?php } ?>
                </td></tr>
              </table>
              <h2 class="small">Informasi Petugas Pemeriksa</h2>
              <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
              <div style="height:5px;"></div>
              <h2 class="small">Informasi Pemeriksaan</h2>
              <h2 class="small" <?php if($sess['PERIKSA_SEBELUMNYA']!= 0) echo 'style=""'; else echo 'style="display:none;"'; ?>><a href="#" onclick="show_detail('#detil_inspeksi', '<?php echo $urlinspeksi; ?>'); return false;">Inspeksi Sebelumnya</a></h2>
              <div id="detil_inspeksi"></div>
              <table class="form_tabel">
              <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
           	  <tr><td class="td_left">Nomor Inspeksi</td><td class="td_right"><?php echo $sess['NOMOR_INSPEKSI']; ?></td></tr>
              <tr><td class="td_left">Referensi</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['STANDARD'])); ?></td></tr>
              <tr><td class="td_left"><h2 class="small">Pendahuluan</h2></td><td class="td_right">&nbsp;</td></tr>
              <tr><td class="td_left">Ringkasan inspeksi sebelumnya</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['LATAR_BELAKANG'])); ?></td></tr>
              <tr><td class="td_left">Perubahan Bermakna sejak inspeksi terakhir</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['PERUBAHAN_BERMAKNA'])); ?></td></tr>
              <tr><td colspan="2"><h2 class="small">Penjelasan Singkat Dari Kegiatan Inspeksi yang Dilakukan</h2></td></tr>
              <tr><td class="td_left">Ruang Lingkup</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['RUANG_LINGKUP'])); ?></td></tr>
              <tr><td class="td_left">Area Inspeksi</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['AREA_INSPEKSI'])); ?></td></tr>
            </table>
              
            </div>
        </div><!-- Akhir Pemeriksaan !-->  
    
    	<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN OBSERVASI</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Observasi</h2>
              <table class="form_tabel">
              <tr><td class="td_left"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['OBSERVASI'])); ?></td></tr>
              </table>
                <div id="data_temuan" url="<?php echo $url_observasi; ?>"></div>
                <div style="height:5px;"></div>
                <table class="form_tabel">
                  <tr><td class="td_left">Pertanyaan Berkaitan dengan Penilaian Permohonan Pendaftaran Produk</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['PERMOHONAN_PENDAFTARAN_PRODUK'])); ?></td></tr>
                  <tr><td class="td_left">Isu Spesifik Lainnya</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['ISU_SPESIFIK_LAINNYA'])); ?></td></tr>
                  <tr><td class="td_left">Site Master File</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['SITE_FILE_MASTER'])); ?></td></tr>
                  <tr><td class="td_left"><h2 class="small">Lain-lain</h2></td><td class="td_right">&nbsp;</td></tr>
                  <tr><td class="td_left">Sampel yang Diambil</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['SAMPEL_DIAMBIL'])); ?></td></tr>
                  <tr><td class="td_left">Distribusi Laporan</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DISTRIBUSI_LAPORAN'])); ?></td></tr>
                  <tr><td class="td_left">Lampiran</td><td class="td_right"><?php if(trim($sess['LAMPIRAN'])!=""){?>
        <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>
        <?php
	} ?></td></tr>
                </table>
              
            </div>
        </div><!-- Akhir Temuan Observasi !-->


    	<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DAFTAR TEMUAN KLASIFIKASI</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Daftar Temuan Klasifikasi</h2>
              <table class="form_tabel">
                  <tr><td class="td_left">1. Temuan Kritikal</td><td class="td_right"><?php echo $sess['TEMUAN_KRITIKAL']; ?></td></tr>
                  <tr><td class="td_left">2. Temuan Major</td><td class="td_right"><?php echo $sess['TEMUAN_MAJOR']; ?></td></tr>
                  <tr><td class="td_left">3. Temuan Minor</td><td class="td_right"><?php echo $sess['TEMUAN_MINOR']; ?></td></tr></table>
            </div>
        </div><!-- Akhir Temuan Observasi !-->
        
		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Kesimpulan</h2>
              <table class="form_tabel">
				<?php if($isEditTLBalai){ ?>
                <tr><td class="td_left">Rekomendasi</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['REKOMENDASI'])); ?></td></tr>
                <tr><td class="td_left">Kesimpulan</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KESIMPULAN'])); ?></td></tr>
                <?php }else{ ?>
                <tr><td class="td_left">Rekomendasi</td><td class="td_right"><textarea name="PEMERIKSAAN_CPOB[REKOMENDASI]" class="stext catatan" title="Rekomendasi"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',$sess['REKOMENDASI']); ?></textarea></td></tr>
                <tr><td class="td_left">Kesimpulan</td><td class="td_right"><textarea name="PEMERIKSAAN_CPOB[KESIMPULAN]" class="stext catatan" title="Kesimpulan"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',$sess['REKOMENDASI']); ?></textarea></td></tr>
                <?php } ?>
              </table>
            </div>
        </div><!-- Akhir Kesimpulan !-->      
		<?php if($isEditTLPusat){ ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Tindak Lanjut</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Tindak Lanjut Hasil Inspeksi</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPOB[TINDAK_LANJUT][]',$tl_cpob,is_array($tindak_lanjut)?$tindak_lanjut:'','class="stext multiselect" multiple style="height:100px;" id="F01OO_tindaklanjut" rel="required" title="Tindak lanjut hasil inspeksi"'); ?></td></tr>
                <tr><td class="td_left">Time Line</td><td class="td_right"><textarea class="stext catatan" id="F01OO_timeline" name="PEMERIKSAAN_CPOB[TIME_LINE]" title="Timeline tindak lanjut hasil inspeksi"><?php echo $sess['TIME_LINE']; ?></textarea></td></tr>
                <tr>
                  <td class="td_left">Lampiran Tindak Lanjut Hasil Inspeksi</td>
                  <td class="td_right">
				 <?php
				  if(array_key_exists('LAMPIRAN_TINDAK_LANJUT', $sess) && trim($sess['LAMPIRAN_TINDAK_LANJUT']) != ""){
					  ?>
                      <span class="upload_LAMPIRAN_TINDAK_LANJUT" style="display:none;"><input type="file" class="stext upload" jenis="LAMPIRAN_TINDAK_LANJUT" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN_TINDAK_LANJUT" name="userfile" onchange="do_lampiran($(this)); return false;" title="File Lampiran Perbaikan Tindak Lanjut"/>&nbsp;Tipe file : *.xls,*.xlsx,*.doc,*.docx,*.rar,*.zip,*.pdf</span><span class="file_LAMPIRAN_TINDAK_LANJUT"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN_TINDAK_LANJUT']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_lampiran" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" jns="LAMPIRAN_TINDAK_LANJUT">Edit atau Hapus File ?</a></span>                      
					  <?php
				  }else{
					  ?>
                      <span class="upload_LAMPIRAN_TINDAK_LANJUT"><input type="file" class="stext upload" jenis="LAMPIRAN_TINDAK_LANJUT" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN_TINDAK_LANJUT" name="userfile" onchange="do_lampiran($(this)); return false;" title="File Lampiran Perbaikan Tindak Lanjut"/>&nbsp;Tipe file : *.xls,*.xlsx,*.doc,*.docx,*.rar,*.zip,*.pdf</span><span class="file_LAMPIRAN_TINDAK_LANJUT"></span>                      
					  <?php
				  }
				  ?>                  
                  </td>
                </tr>
                </table>
                <h2 class="small">C A P A</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Hasil Evaluasi CAPA</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPOB[STATUS_CAPA]',$capa_cpob,$sess['STATUS_CAPA'],'class="stext" id="F01OO_capa" title="Hasil evaluasi CAPA"'); ?></td></tr>
                </table>
            </div>
        </div>
        <?php }else{ ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Tindak Lanjut</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Tindak Lanjut Hasil Inspeksi</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_pusat= explode("#", $sess['TINDAK_LANJUT']); echo "<li>".join("</li><li>", $tl_pusat)."</li>"; ?></ul></td></tr>
                <tr><td class="td_left">Time Line</td><td class="td_right"><?php echo $sess['TIME_LINE']; ?></td></tr>
<tr>
                  <td class="td_left">Lampiran Tindak Lanjut Hasil Inspeksi</td>
                  <td class="td_right"><?php if(trim($sess['LAMPIRAN_TINDAK_LANJUT'])!=""){ ?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN_TINDAK_LANJUT']; ?>" target="_blank">File Lampiran</a><?php } ?></td>
                </tr>                </table>
                <h2 class="small">C A P A</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Hasil Evaluasi CAPA</td><td class="td_right"><?php echo $sess['STATUS_CAPA']; ?></td></tr>
                </table>
            </div>
        </div>
        <?php } ?>
        

		<?php
        if($isPerbaikan){
        ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PERBAIKAN</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Perbaikan</h2>
                <table class="form_tabel">
               	<tr><td class="td_left">Tanggal Perbaikan</td><td class="td_right"><input type="text" class="sdate" id="waktuperiksa_" name="PERBAIKAN[TANGGAL_PERBAIKAN]" title="Tanggal perbaikan" /></td></tr>
                <tr id="row_perbaikan" <?php if($sess['STATUS_CAPA'] == "CAPA Closed") echo 'style="display:none;"'; else echo 'style=""'; ?>><td class="td_left">Detail Perbaikan</td><td class="td_right"><textarea id="F01OO_perbaikan" name="PERBAIKAN[DETAIL_PERBAIKAN]" class="stext catatan" title="Detail perbaikan"></textarea></td></tr>
                <tr id="row_attach" <?php if($sess['STATUS_CAPA'] == "CAPA Closed") echo 'style="display:none;"'; else echo 'style=""'; ?>><td class="td_left"></td><td class="td_right td_attach"><?php /*?><input type="file" class="stext upload" name="attach_perbaikan" id="attach_perbaikan" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/perbaikan/<?php echo $sess['SARANA_ID']; ?>" allowed="xls-xlsx-doc-docx-rar-zip-pdf" onchange="attach_doc_perbaikan($(this)); return false;" title="File perbaikan" />&nbsp;File tipe : *.doc, *.docx, *.xls, *.xlsx, *.rar, *.zip, *.pdf<?php */?></td></tr>
                <tr id="row_capa_close" <?php if( $sess['STATUS_CAPA'] != "Perbaikan CAPA" || trim($sess['STATUS_CAPA']) == "") echo 'style=""'; else echo 'style="display:none;"'; ?>><td class="td_left">Detail Perbaikan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPOB[CAPA_CLOSED]',$capa_close_cpob,$sess['CAPA_CLOSED'],'class="stext" title="Detail perbaikan CAPA"'); ?></td>
              </tr>
                </table> 
                <div style="padding-top:5px;">
				<?php
                if($sess['JML_PERBAIKAN'] <> 0){
                    ?>
                    <h2 class="small"><a href="#" url="<?php echo $histori_perbaikan; ?>" onclick="expand_detail($(this), 'detail_expand'); return false;" id="detail_perbaikan">Daftar Perbaikan ( <?php echo array_key_exists('JML_PERBAIKAN', $sess)?$sess['JML_PERBAIKAN']:''; ?> )</a></h2>
                    <div id="detail_expand"></div>
                    <?php
                }
                ?>
                </div>
            </div>
        </div><!-- Akhir Perbaikan !-->      
        <?php
        }
        ?>

		<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Verifikasi Pemeriksaan</h2>
                <?php if($isverifikasi){ ?>
                <table class="form_tabel">
                    <tr><td class="td_left">Proses Pemeriksaan</td><td class="td_right"><?php echo form_dropdown($obj_status,$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td></tr>
                    <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td></tr>
                </table>
                <?php } ?>
                <div style="padding-top:5px;">
                <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan (<?php echo $sess['JML_PROSES']; ?>)</a></h2>
                <div id="detail_log"></div>
                </div> 
                
                </div>
        </div><!-- Akhir Verifikasi !-->        
    
    </div>
</div>

<div id="clear_fix"></div>

<div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f01OO_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
</form>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#detail_petugas").html("Loading ..."); $("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#data_temuan").html("Loading ..."); $("#data_temuan").load($("#data_temuan").attr("url"));
	$("#F01OO_capa").change(function(){ if($(this).val() == "Perbaikan CAPA"){ $("#row_perbaikan, #row_attach").show(); $("#row_capa_close").hide(); }else{ $("#row_capa_close").show(); $("#row_perbaikan, #row_attach").hide(); } });
	$(".del_upload").live("click", function(){
		$.ajax({
			type: "GET",
			url: $(this).attr("url"),
			data: $(this).serialize(),
			success: function(data){
				var arrdata = data.split("#");
				$('td.td_attach').html('<input type="file" class="stext upload" name="userfile" id="attach_perbaikan" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/perbaikan/<?php echo $sess['SARANA_ID']; ?>" allowed="xls-xlsx-doc-docx-rar-zip" onchange="attach_doc_perbaikan($(this)); return false;" />&nbsp;File tipe : *.doc, *.docx, *.xls, *.xlsx, *.rar, *.zip');
			}
		});
		return false;
	});
		$(".del_lampiran").live("click", function(){
		var jenis = $(this).attr("jns");
		$.ajax({
			type: "GET",
			url: $(this).attr("url"),
			data: $(this).serialize(),
			success: function(data){
				var arrdata = data.split("#");
				$(".upload_"+jenis+"").show();
				$("#fileToUpload_"+jenis+"").val('');
				$(".file_"+jenis+"").html('<input type=\"hidden\" name=\"PEMERIKSAAN_CPOB['+jenis+']\" value="">');
			}
		});
		return false;
	});

});
function attach_doc_perbaikan(element){
	var id = $(element).attr("id");
    $("#indicator").ajaxStart(function(){
		jLoadingOpen('Upload File','SIPT Versi 1.0');
    }).ajaxComplete(function(){
		jLoadingClose();
	});
	$.ajaxFileUpload({
		url: $(element).attr("url")+'/ajax/'+$(element).attr("allowed")+'/'+$(this).attr("id"),
		secureuri: false,
		fileElementId: $(element).attr("id"),
		dataType: "json",
		success: function(data){
				  var arrdata = data.msg.split("#");
				  if(typeof(data.error) != "undefined"){
					  if(data.error != ""){
						  jAlert(data.error, "SIPT Versi 1.0 Beta");
					  }else{
						  $("td.td_attach").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[2]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[2]+"/"+arrdata[0]+"\">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PERBAIKAN[FILE_PERBAIKAN]\" id=\"attach_perbaikan\" value="+arrdata[0]+">");
					  }
				  }
		},
		error: function (data, status, e){
			jAlert(e, "SIPT Versi 1.0 Beta");
		}
	});
	return false;
}

	function do_lampiran(element){
		var jenis = $(element).attr("jenis");
		var allowed = $(element).attr("allowed");
		$("#indicator").ajaxStart(function(){
			jLoadingOpen('Upload File','SIPT Versi 1.0');
		}).ajaxComplete(function(){
			jLoadingClose();
		});
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+jenis+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0 Beta");
					}else{
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_lampiran\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_CPOB["+arrdata[2]+"]\" value="+arrdata[0]+">");
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}



</script>
