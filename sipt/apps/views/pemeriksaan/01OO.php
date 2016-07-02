<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#detail_petugas").html("Loading ..."); $("#detail_petugas").load($("#detail_petugas").attr("url"));
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
	$(".addtemuan").click(function(){ var nom = $(this).attr("terakhir"); var idtr = $(this).attr("periksa"); var cls = idtr + nom; $("#tb_temuan").append('<tr class= "' + cls + '"><td width="545px;"><div style="padding-bottom:5px;"><?php echo str_replace(chr(10), '', form_dropdown("TEMUAN[TEMUAN_OBSERVASI][]", $temuan_observasi, "", 'class="text"')); ?></div><div><b>Keterangan Temuan</b><textarea class="stext temuan" name="TEMUAN[TEMUAN_TEKS][]" id="TEMUAN_OBS'+nom+'"></textarea></div></td><td><div style="padding-bottom:5px;"><?php echo str_replace(chr(10), '', form_dropdown("TEMUAN[TEMUAN_KRITERIA][]", $cb_observasi, "", 'class="sel_penyimpangan" title="Pilih salah satu pilihan : Kritikal, Major, Minor, Observasi" hasil="yes" onchange="CountKriteria($(this).val());"')); ?>&nbsp;&nbsp;<a href="#" class="min" onclick="$(\'.' + cls + '\').remove(); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Klik disini untuk membatalkan atau menghapus temuan" /></a></div><div><span class="attach' +  nom + '"><input type="file" class="stext" file_ke="file_ke' +  nom + '" id="attach' +  nom + '" name="userfile" allowed="xls-xlsx-doc-docx-jpg-jpeg-rar-zip-pdf-csv-png-gif" onchange="attach_doc_tabel($(this));" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/temuan/<?php echo $sarana_id; ?>" /></span><span class="file' +  nom + '"></span><input type="hidden" name="TEMUAN[TEMUAN_FILE][]" class="hd_file' + nom + '" /></div></tr>'); $(this).attr('terakhir', parseInt(nom) + 1); create_ck("#TEMUAN_OB"+nom, 505); create_ck("#TEMUAN_OBS"+nom, 505); return false;});
	$(".del_upload").live("click", function(){ var baris_ke = $(this).attr("baris_ke"); var urut = baris_ke.substring(6,7); $.ajax({ type: "GET", url: $(this).attr("url"), data: $(this).serialize(), success: function(data){ $(".attach"+urut).show(); $(".attach"+urut).html('<input type="file" class="stext" file_ke="file_ke' +  urut + '" id="attach' +  urut + '" name="userfile" allowed="xls-xlsx-doc-docx-jpg-jpeg-rar-zip-pdf-csv-png-gif" onchange="attach_doc_tabel($(this));" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/temuan/<?php echo $sarana_id; ?>" />'); $(".file"+urut).hide(); $(".hd_file"+urut).val(''); }  }); return false; });
});

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

	function attach_doc_tabel(element){
		var id = $(element).attr("id");
		var urut = id.substring(6,8);
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
			beforeSend:function(){CallIndikator();},
			complete:function(){$("#indicator").fadeOut();},     
			success: function(data){
					var arrdata = data.msg.split("#");
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							jAlert(data.error, "SIPT Versi 1.0 Beta");
						}else{
							$("."+id).hide();
							$(".file"+urut).show();
							$(".file"+urut).html("<b>1 File telah dilampirkan. </b><br><a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" baris_ke=\""+id+"\" file_ke=\"file_ke"+urut+"\">Edit atau Hapus File ?</a>");$(".hd_file"+urut).val(arrdata[0]);
						}
					}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
		return false;
	}


</script>


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
                <tr><td class="td_left">Kegiatan yang dilakukan</td><td class="td_right"><?php echo form_dropdown('SARANA[KEGIATAN_SARANA][]',$kegiatan_farmasi,explode("|",$sess['KEGIATAN_SARANA']),'class="stext multiselect" multiple title="Pilih salah satu atau lebih kegiatan yang dilakukan oleh sarana : Pembuatan bahan aktif obat, Pembuatan obat jadi, Pembuatan produk antara bulk, Pengemasan, Importir, Pengujian/laboratorium, Pelulusan bets dan pengawasan bets. Jika lebih dari satu tekan klik + Ctrl"'); ?></td></tr>
                <tr><td class="td_left">&nbsp;</td><td class="td_right"><input type="text" class="stext" name="SARANA[KEGIATAN_SARANA][]" title="Kegiatan sarana lainnya yang tidak tercantum dalam kegiatan di atas" /></td></tr>              
              </table>
              <h2 class="small">Informasi Petugas Pemeriksa</h2>
              <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
              <div style="height:5px;"></div>
              <h2 class="small">Informasi Pemeriksaan</h2>
              <h2 class="small" <?php if($sess['PERIKSA_SEBELUMNYA']!= 0) echo 'style=""'; else echo 'style="display:none;"'; ?>><a href="#" onclick="show_detail('#detil_inspeksi', '<?php echo $urlinspeksi; ?>'); return false;">Inspeksi Sebelumnya</a></h2>
              <div id="detil_inspeksi"></div>
              <table class="form_tabel">
              <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" /><input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td></tr>
           	  <tr><td class="td_left">Nomor Inspeksi</td><td class="td_right"><input type="text" name="PEMERIKSAAN_CPOB[NOMOR_INSPEKSI]" id="F01OO_nomorinspeksi" class="stext" title="Nomor Inspeksi" value="<?php echo array_key_exists('NOMOR_INSPEKSI', $sess)?$sess['NOMOR_INSPEKSI']:""; ?>" /></td></tr>
              <tr>
                <td class="td_left">Referensi</td><td class="td_right"><textarea name="PEMERIKSAAN_CPOB[STANDARD]" class="stext chk" title="misal, Pedoman CPOB 2006, Petunjuk Operasional Pedoman CPOB 2006, Suplemen I 2009 Pedoman CPOB"><?php echo array_key_exists('STANDARD', $sess)?$sess['STANDARD']:""; ?></textarea></td></tr>
              <tr>
                  <td class="td_left"><h2 class="small">Pendahuluan</h2></td>
                  <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Ringkasan inspeksi sebelumnya</td><td class="td_right"><textarea class="stext chk" id="F01OO_latarbelakang" name="PEMERIKSAAN_CPOB[LATAR_BELAKANG]" title="Ringkasan hasil inspeksi sebelumnya"><?php echo array_key_exists('LATAR_BELAKANG', $sess)?$sess['LATAR_BELAKANG']:""; ?></textarea></td></tr>
              <tr><td class="td_left">Perubahan Bermakna sejak inspeksi terakhir</td><td class="td_right"><textarea class="stext chk" id="F01OO_perubahanmajor2" name="PEMERIKSAAN_CPOB[PERUBAHAN_BERMAKNA]" title="Perubahan bermakna (major) sejak inspeksi terakhir "><?php echo array_key_exists('PERUBAHAN_BERMAKNA', $sess)?$sess['PERUBAHAN_BERMAKNA']:""; ?></textarea></td></tr>
              <tr><td colspan="2"><h2 class="small">Penjelasan Singkat Dari Kegiatan Inspeksi yang Dilakukan</h2></td></tr>
              <tr><td class="td_left">Ruang Lingkup</td><td class="td_right"><textarea class="stext chk" id="F01OO_ruanglingkup" name="PEMERIKSAAN_CPOB[RUANG_LINGKUP]" title="Penjelasan singkat inspeksi yang dilakukan (produk terkait inspeksi dan atau inspeksi CPOB secara umum)."><?php echo array_key_exists('RUANG_LINGKUP', $sess)?$sess['RUANG_LINGKUP']:""; ?></textarea></td></tr>
              <tr><td class="td_left">Area Inspeksi</td><td class="td_right"><textarea class="stext chk" id="F01OO_areainspeksi" name="PEMERIKSAAN_CPOB[AREA_INSPEKSI]" title="Area Inspeksi"><?php echo array_key_exists('AREA_INSPEKSI', $sess)?$sess['AREA_INSPEKSI']:""; ?></textarea></td></tr>
            </table>
              
            </div>
        </div><!-- Akhir Pemeriksaan !-->  
    
    	<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN OBSERVASI</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Observasi</h2>
              <table class="form_tabel">
              <tr><td class="td_left"><textarea class="stext chk" id="F01OO_observasi" name="PEMERIKSAAN_CPOB[OBSERVASI]" title="Area Inspeksi"><?php echo array_key_exists('OBSERVASI', $sess)?$sess['OBSERVASI']:""; ?></textarea></td></tr>
              </table>

                <table class="listtemuan" id="tb_temuan" width="100%">
                    <thead><tr><th>Klasifikasi dan Keterangan Temuan</th><th>Kriteria Temuan dan Lampiran File</th></tr></thead>
                    <?php
                        $jmldata = count($temuan);
                        if($jmldata==0){
                            $jmldata = 1;
                            $temuan[] = "";
                        }
                        $currenttemuan = "";
                        $i = 0;
                        do{
                        ?>
                        <tr class="urut<?php echo $i; ?>"><td width="545px;"><div style="padding-bottom:5px;"><?php echo form_dropdown('TEMUAN[TEMUAN_OBSERVASI][]',$temuan_observasi,$temuan[$i]['TEMUAN_OBSERVASI'],'class="stext"'); ?></div>
                        <div><b>Keterangan Temuan</b>
                        <textarea class="stext chk" id="TEMUAN_OB<?php echo $i; ?>" name="TEMUAN[TEMUAN_TEKS][]"><?php echo $temuan[$i]['TEMUAN_TEKS']; ?></textarea>
                        </div>
                        
                        </div></td><td><div style="padding-bottom:5px;"><?php echo form_dropdown('TEMUAN[TEMUAN_KRITERIA][]', $cb_observasi, $temuan[$i]['TEMUAN_KRITERIA'], 'class="sel_penyimpangan" title="Pilih salah satu pilihan : Kritikal, Major, Minor, Observasi" hasil="yes" onchange="CountKriteria($(this).val());"'); ?>&nbsp;&nbsp;
                        <?php
                        if($i==0){
                        ?>
                            <a href="#" class="addtemuan" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Klik disini untuk menambah temuan" /></a>
                        <?php
                        }else{
                        ?>
                            <a href="#" class="min" onclick="$('.urut<?php echo  $i; ?>').remove(); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Klik disini untuk membatalkan atau menghapus temuan" /></a>
                        <?php
                        }
                        ?>        
                        </div><div>
                        <?php if(trim($temuan[$i]['TEMUAN_FILE']) == ""){ ?>
                        <span class="attach<?php echo $i; ?>"><input type="file" class="stext" file_ke="file_ke<?php echo $i; ?>" id="attach<?php echo $i; ?>" name="userfile" allowed="xls-xlsx-doc-docx-jpg-jpeg-rar-zip-pdf-csv-png-gif" onchange="attach_doc_tabel($(this));" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/temuan/<?php echo $sarana_id; ?>" /></span>
                        <span class="file<?php echo $i; ?>"></span>
                        <?php }else{ ?>
                        <span class="attach<?php echo $i; ?>"></span>
                        <span class="file<?php echo $i; ?>"><b>1 File telah dilampirkan. </b><br><a href="<?php echo base_url(); ?>files/<?php echo $sarana_id; ?>/<?php echo $temuan[$i]['TEMUAN_FILE']; ?>" target="_blank">Tampilkan File</a>&nbsp;&bull;&nbsp;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sarana_id; ?>/<?php echo $temuan_cpob[$i]['TEMUAN_FILE']; ?>" baris_ke="attach<?php echo $i; ?>" file_ke="file_ke<?php echo $i; ?>">Edit atau Hapus File ?</a></span>
                        <?php } ?>
                        
                        <input type="hidden" name="TEMUAN[TEMUAN_FILE][]" class="hd_file<?php echo $i; ?>" value="<?php echo $temuan_cpob[$i]['TEMUAN_FILE']; ?>" /></div></td></tr>
                        <?php
                        $i++;
                        }while($i<$jmldata);
                    ?>
                </table>
                <div style="height:5px;"></div>
                <table class="form_tabel">
                  <tr><td class="td_left">Pertanyaan Berkaitan dengan Penilaian Permohonan Pendaftaran Produk</td><td class="td_right"><textarea class="stext chk" id="F01OO_personel" name="PEMERIKSAAN_CPOB[PERMOHONAN_PENDAFTARAN_PRODUK]" title="Pertanyaan berkaitan dengan penilaian permohonan pendaftaran produk, misal inspeksi pre-market)"><?php echo array_key_exists('PERMOHONAN_PENDAFTARAN_PRODUK', $sess)?$sess['PERMOHONAN_PENDAFTARAN_PRODUK']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Isu Spesifik Lainnya</td><td class="td_right"><textarea class="stext chk" id="F01OO_isu" name="PEMERIKSAAN_CPOB[ISU_SPESIFIK_LAINNYA]" title="Isu spesifik lainnya, misal perubahan pada waktu mendatang yang disampaikan industri)"><?php echo array_key_exists('ISU_SPESIFIK_LAINNYA', $sess)?$sess['ISU_SPESIFIK_LAINNYA']:""; ?></textarea></td></tr>
                  <tr>
                    <td class="td_left">Site Master File</td><td class="td_right"><textarea class="stext chk" id="F01OO_sitefile" name="PEMERIKSAAN_CPOB[SITE_FILE_MASTER]" title="Site master file, penilaian terhadap SMF, bila ada ; tanggal SMF"><?php echo array_key_exists('SITE_FILE_MASTER', $sess)?$sess['SITE_FILE_MASTER']:""; ?></textarea></td></tr>
                  <tr>
                    <td class="td_left"><h2 class="small">Lain-lain</h2></td>
                    <td class="td_right">&nbsp;</td>
                  </tr>
                  <tr><td class="td_left">Sampel yang Diambil</td><td class="td_right"><textarea class="stext chk" id="F01OO_sampel" name="PEMERIKSAAN_CPOB[SAMPEL_DIAMBIL]" title="Sampel yang diambil, bila dilakukan pengambilan sampel)"><?php echo array_key_exists('SAMPEL_DIAMBIL', $sess)?$sess['SAMPEL_DIAMBIL']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Distribusi Laporan</td><td class="td_right"><textarea class="stext chk" id="F01OO_distribusilaporan" name="PEMERIKSAAN_CPOB[DISTRIBUSI_LAPORAN]" title="Distribusi laporan disampaikan kepada Industri Farmasi tsb dan Ditwasprod, Balai /Balai Besar POM atau Instansi lain)"><?php echo array_key_exists('DISTRIBUSI_LAPORAN', $sess)?$sess['DISTRIBUSI_LAPORAN']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Lampiran</td><td class="td_right">
                  <?php
				  if(array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != ""){
					  ?>
                      <span class="upload_LAMPIRAN" style="display:none;"><input type="file" class="stext upload" jenis="LAMPIRAN" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_lampiran($(this)); return false;" title="File Lampiran Berita Acara Pemeriksaan"/>&nbsp;Tipe file : *.rar,*.zip</span><span class="file_LAMPIRAN"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_lampiran" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" jns="LAMPIRAN">Edit atau Hapus File ?</a></span>                      
					  <?php
				  }else{
					  ?>
                      <span class="upload_LAMPIRAN"><input type="file" class="stext upload" jenis="LAMPIRAN" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_lampiran($(this)); return false;" title="File Lampiran Berita Acara Pemeriksaan"/>&nbsp;Tipe file : *.rar,*.zip</span><span class="file_LAMPIRAN"></span>                      
					  <?php
				  }
				  ?></td></tr>
                </table>
              
            </div>
        </div><!-- Akhir Temuan Observasi !-->


    	<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DAFTAR TEMUAN KLASIFIKASI</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Daftar Temuan Klasifikasi</h2>
              <table class="form_tabel">
                  <tr><td class="td_left">1. Temuan Kritikal</td><td class="td_right"><input type="text" class="scode" id="jumlah_kritikal" readonly="readonly" name="PEMERIKSAAN_CPOB[TEMUAN_KRITIKAL]" title="Jumlah temuan kritikal" value="<?php echo array_key_exists('TEMUAN_KRITIKAL', $sess)?$sess['TEMUAN_KRITIKAL']:""; ?>" /></td></tr>
                  <tr><td class="td_left">2. Temuan Major</td><td class="td_right"><input type="text" class="scode" id="jumlah_major" readonly="readonly" name="PEMERIKSAAN_CPOB[TEMUAN_MAJOR]" title="Jumlah temuan major" value="<?php echo array_key_exists('TEMUAN_MAJOR', $sess)?$sess['TEMUAN_MAJOR']:""; ?>" /></td></tr>
                  <tr><td class="td_left">3. Temuan Minor</td><td class="td_right"><input type="text" class="scode" id="jumlah_minor" readonly="readonly" name="PEMERIKSAAN_CPOB[TEMUAN_MINOR]" title="Jumlah temuan minor" value="<?php echo array_key_exists('TEMUAN_MINOR', $sess)?$sess['TEMUAN_MINOR']:""; ?>" /></td></tr></table>
            </div>
        </div><!-- Akhir Temuan Observasi !-->
        
		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Kesimpulan</h2>
              <table class="form_tabel">
                <tr><td class="td_left">Rekomendasi</td><td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_CPOB[REKOMENDASI]" title="Rekomendasi"><?php echo array_key_exists('REKOMENDASI', $sess)?$sess['REKOMENDASI']:''; ?></textarea></td></tr>
                <tr><td class="td_left">Kesimpulan</td><td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_CPOB[KESIMPULAN]" title="Kesimpulan"><?php echo array_key_exists('KESIMPULAN', $sess)?$sess['KESIMPULAN']:''; ?></textarea></td></tr>

              </table>
            </div>
        </div><!-- Akhir Kesimpulan !-->      
        
        <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "91"){ ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Tindak Lanjut</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Tindak Lanjut Hasil Inspeksi</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPOB[TINDAK_LANJUT][]',$tl_cpob,is_array($tindak_lanjut)?$tindak_lanjut:'','class="stext multiselect" multiple style="height:100px;" rel="required" title="Tindak lanjut hasil inspeksi"'); ?></td></tr>
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
        <?php } ?>
        
            
        <?php
		if(!array_key_exists('PERIKSA_ID', $sess)){
		?>
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN KLASIFIKASI KOMODITI LAIN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Klasifikasi Komoditi Lain</h2>
                <table class="form_tabel">
                	<tr><td class="td_left">Jenis Temuan</td><td class="td_right"><?php echo form_dropdown('cb_konfirm', $this->config->item('konfirmasi'), '', 'id="cb_konfirm" class="stext" title="Pilih salah satu jenis temuan" onchange="sel_konfirmasi($(this));"'); ?></td></tr>
                    <tr id="tr_jenis_sarana" style="display:none;"><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('jns', $jenis_sarana, '', 'id="jns" class="stext" url="'.site_url().'/get/pemeriksaan/set_klasifikasi_sarana/" onchange="get_klasifikasi($(this));" title="Pilih salah satu jenis sarana"', $disinput); ?></td></tr>
                    <tr id="tr_jenis_klasifikasi" style="display:none;"><td class="td_left">Jenis Klasifikasi</td><td class="td_right"><?php echo form_dropdown('kk', $klasifikasi_kategori, '', 'id="kk" class="stext" title="Pilih salah satu jenis klasifikasi"'); ?></td>
                    </tr>
                </table>
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        <?php
		}
		if($stat=="20102" || $stat=="20103" || $stat=="20113" || $stat=="20112" || $stat=="60020"){ ?>
		<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Verifikasi Pemeriksaan</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Proses Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[STATUS]',$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td></tr>
                    <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td></tr>
                </table>
                
                <div style="padding-top:5px;">
                      <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan</a></h2>
                      <div id="detail_log"></div>
                </div> 
                
                </div>
        </div><!-- Akhir Verifikasi !-->        
        <?php
		}
		?>
    
    
    </div>
</div>

<div id="clear_fix"></div>

<div><a href="#" class="button save" onclick="fpost('#f01OO_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
<div id="clear_fix"></div>
    <input type="hidden" name="PEMERIKSAAN[HASIL]" value="<?php echo $sess['HASIL'];?>" id="hasil_cpob"/>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" /> 
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />   
</form>
</div>

