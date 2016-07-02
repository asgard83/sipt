<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="fnapza_" id="fnapza_" method="post" action="<?php echo $act; ?>" autocomplete="off" enctype="multipart/form-data"> 

<div class="adCntnr">
    <div class="acco2">
    	
              <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
              <div class="collapse">
                      <div class="accCntnt">
                          <h2 class="small garis">Informasi Sarana</h2>
                          <table class="form_tabel">
                              <tr><td class="td_left">Nama Sarana</td><td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td></tr>
                              <tr>
                                <td class="td_left">Penanggung Jawab</td>
                                <td class="td_right">
                                <?php if($sess['JENIS_SARANA_ID'] == '03AN'){
									echo array_key_exists('NAMA_APA', $sess)?$sess['NAMA_APA']:"";
								}else{
									echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:"";
								}
								?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_left">Alamat</td>
                                <td class="td_right"><?php echo array_key_exists('ALAMAT', $sess)?$sess['ALAMAT']:""; ?></td>
                            </tr>
                            
                              <tr><td class="td_left">Telp.</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul></td></tr>
                          </table>
                          
                          <h2 class="small">Informasi Pemeriksaan</h2>
                          <table class="form_tabel">
                              <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp; <?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:""; ?></td></tr>
                              <tr>
                                <td class="td_left">Tujuan Pemeriksaan</td>
                                <td class="td_right"><?php echo array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:""; ?></td>
                            </tr>
                              <tr>
                                <td class="td_left">Dasar Pemeriksaan</td>
                                <td class="td_right"><?php echo array_key_exists('DASAR_PEMERIKSAAN', $sess)?$sess['DASAR_PEMERIKSAAN']:""; ?></td>
                            </tr>
                          </table>
                          <h2 class="small">Informasi Petugas Pemeriksa</h2>
                          <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                          <div style="height:5px;"></div>
                          <h2 class="small"><a href="#" url="<?php echo $history_periksa; ?>" onclick="expand_detail($(this), 'detail_periksa'); return false;" id="detail_hisotry">Pemeriksaan Sebelumnya</a></h2>
                          <div id="detail_periksa"></div>
                     </div>
              </div><!-- Akhir Pemeriksaan !-->
              
              <div style="height:5px;"></div>
              
              <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN</a></div>
              <div class="collapse">
                      <div class="accCntnt">
                          <h2 class="small garis">Temuan</h2>
                          <table width="99%" id="FN_temuan" cellpadding="0" cellspacing="0" class="listtemuan">
                              <thead><tr>
                              <th>Nama Produk</th>
                              <th>Jenis Pelanggaran</th>
                              <th>Jenis Kriteria Pelanggaran</th>
                              <th>Jenis Penyimpangan</th>
                              <th>Klasifikasi Produk</th>
                              </tr></thead>
                              <tbody id="FN_bodytemuan">
                              <?php
                                if(count($temuan_produk) != 0){
                                    for($i=0; $i<count($temuan_produk); $i++){
                                        ?>
                                        <tr id="<?php echo $temuan_produk[$i]['SERI']; ?>"><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_KRITERIA_PELANGGARAN']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PENYIMPANGAN']; ?></td><td><?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?></td></tr>
                                        <?php
                                    }
                                }else{
                                    $temuan_produk = "";
                                }
                              ?>
                              </tbody>
                          </table>
                          <table class="form_tabel">
                            <tr><td class="td_left">File BAP</td><td class="td_right"><?php if(array_key_exists('FILE_BAP', $sess) && trim($sess['FILE_BAP']) != ""){ ?> <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_BAP']; ?>" target="_blank">File Lampiran</a> <?php } ?></td></tr>
                            <tr><td class="td_left">File Lampiran BAP</td><td class="td_right"><?php if(array_key_exists('FILE_LAMPIRAN_BAP', $sess) && trim($sess['FILE_LAMPIRAN_BAP']) != ""){ ?> <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_LAMPIRAN_BAP']; ?>" target="_blank">File Lampiran</a> <?php }?></td></tr>
                          </table>                          
                     </div>
              </div><!-- Akhir Temuan Produk !-->
              
              <div style="height:5px;"></div>
              
              <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
              <div class="collapse">
                      <div class="accCntnt">
                      <h2 class="small garis">Tindak Lanjut</h2>
                      <?php
					  if($isEditTLBalai){
						  ?>
                          <table class="form_tabel">
                              <tr><td class="td_left">Tanggal Tindakan</td><td class="td_right"><input type="text" name="<?php echo $obj_napza; ?>[TANGGAL_TINDAKAN_BALAI]" id="F02MM_tgbalai" class="sdate" rel="required" value="<?php echo array_key_exists('TANGGAL_TINDAKAN_BALAI', $sess)?$sess['TANGGAL_TINDAKAN_BALAI']:""; ?>" title="Tanggal Tindakan Balai"/></td></tr>
                            <tr>
                              <td class="td_left">Unit yang melakukan tindakan</td>
                              <td class="td_right"><textarea class="stext" name="<?php echo $obj_napza; ?>[UNIT_BALAI]" id="F02MM_unitbalai" title="Unit yang melakukan tindakan"><?php echo array_key_exists('UNIT_BALAI', $sess)?$sess['UNIT_BALAI']:$this->newsession->userdata('SESS_MBBPOM'); ?></textarea></td>
                              </tr>
                            <tr>
                              <td class="td_left">Saran Tindak Lanjut</td>
                              <td class="td_right"><textarea name="<?php echo $obj_napza; ?>[DETAIL_TINDAKAN_BALAI]" id="F02MM_detilbalai" class="stext catatan" rel="required" title="Detail Tindakan"><?php echo array_key_exists('DETAIL_TINDAKAN_BALAI', $sess)?$sess['DETAIL_TINDAKAN_BALAI']:""; ?></textarea></td>
                              </tr>
                            <?php
							if($ispelayanan == "03"){
							?>  
                            <tr>
                              <td class="td_left">File Tindak Lanjut</td>
                              <td class="td_right">
							  <?php
                              if($sess['FILE_TL_BALAI'] != "" && trim($sess['FILE_TL_BALAI']) != ""){
                                  ?>
                                  <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TL_BALAI']; ?>" target="_blank">File Lampiran</a><input type="hidden" name="<?php echo $obj_napza; ?>[FILE_TL_BALAI]" value="<?php echo $sess['FILE_TL_BALAI']; ?>" /><?php
                              }else{?> 
                                <span class="upload_FILE_TL_BALAI"><input type="file" class="stext upload" jenis="FILE_TL_BALAI" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_TL_BALAI" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;Tipe file : *.pdf</span><span class="file_FILE_TL_BALAI"></span>
                                <?php
                              }
                              ?></td>
                            </tr>
                            <?php
							}
							?>
                          </table>
                          <?php
					  }else{
					  ?>
                      <table class="form_tabel">
                        <tr><td class="td_left">Tanggal Tindakan</td><td class="td_right"><?php echo $sess['TANGGAL_TINDAKAN_BALAI']; ?></td></tr>
                        <tr><td class="td_left">Unit yang melakukan tindakan</td><td class="td_right"><?php echo $sess['UNIT_BALAI']; ?></td></tr>
                        <tr>
                          <td class="td_left">Saran Tindak Lanjut</td><td class="td_right"><?php echo $sess['DETAIL_TINDAKAN_BALAI']; ?></td></tr>
                        <?php
						if($ispelayanan == "03"){
						?>  
                        <tr>
                          <td class="td_left">File Tindak Lanjut</td>
                          <td class="td_right"><?php if(trim($sess['FILE_TL_BALAI']) != ""){ ?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TL_BALAI']; ?>" target="_blank">File Lampiran</a><?php } ?></td>
                        </tr>
                        <?php
						}
						?>
                      </table>
                      
                      <?php
					  if($sess['CREATE_BY'] == $this->newsession->userdata('SESS_USER_ID')){
						  ?>
						  <div style="height:5px;"></div>
						  <div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
							  <p><a href="javascript:void(0);" id="showtlbalai" url="<?php echo site_url(); ?>/get/pemeriksaan/get_tl_balai/<?php echo $sess['PERIKSA_ID']; ?>">Klik disini untuk menambahkan Tindak Lanjut Balai jika tindak lanjut belum diisi</a></p>
						  </div>
						  <?
					  }
					  ?>
                      
                      <?php
					  }
					  if($isEditTLPusat){
						  ?>
                        <h2 class="small garis">Tindak Lanjut Oleh Pusat</h2>
                          <table class="form_tabel">
                            <tr><td class="td_left">Tanggal Tindakan</td><td class="td_right"><input type="text" name="<?php echo $obj_napza; ?>[TANGGAL_TINDAKAN_PUSAT]" id="F02MM_tgpusat" class="sdate" value="<?php echo array_key_exists('TANGGAL_TINDAKAN_PUSAT', $sess)?$sess['TANGGAL_TINDAKAN_PUSAT']:""; ?>" title="Tanggal Tindakan Pusat" /></td></tr>
                            <tr><td class="td_left">Unit yang melakukan tindakan</td><td class="td_right"><textarea class="stext" name="<?php echo $obj_napza; ?>[UNIT_PUSAT]" id="F02MM_unitpusat" rel="required" title="Unit yang melakukan tindakan"><?php echo array_key_exists('UNIT_PUSAT', $sess)?$this->newsession->userdata('SESS_MBBPOM'):$sess['UNIT_PUSAT']; ?></textarea></td></tr>
                            <tr><td class="td_left">Detail Tindakan</td><td class="td_right"><textarea name="<?php echo $obj_napza; ?>[DETAIL_TINDAKAN_PUSAT]" id="F02MM_detilpusat" class="stext catatan" title="Detail Tindakan Pusat"><?php echo array_key_exists('DETAIL_TINDAKAN_PUSAT', $sess)?$sess['DETAIL_TINDAKAN_PUSAT']:""; ?></textarea></td></tr>
                            <?php
							if($ispelayanan == "03"){
							?>
                            <tr><td class="td_left">File Tindak Lanjut</td><td class="td_right"><?php
                              if($sess['FILE_TINDAK_LANJUT'] != "" && trim($sess['FILE_TINDAK_LANJUT']) != ""){
                                  ?>
                                  <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TINDAK_LANJUT']; ?>" target="_blank">File Lampiran</a><input type="hidden" name="<?php echo $obj_napza; ?>[FILE_TINDAK_LANJUT]" value="<?php echo $sess['FILE_TINDAK_LANJUT']; ?>" /><?php
                              }else{?> 
                                <span class="upload_TINDAK_LANJUT"><input type="file" class="stext upload" jenis="TINDAK_LANJUT" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_TINDAK_LANJUT" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;Tipe file : *.pdf</span><span class="file_TINDAK_LANJUT"></span>
                                <?php
                              }
                              ?></td></tr>
                              <?php
							}
							?>
                          </table>
                          <?php
					  }else{
						  ?>
                          <h2 class="small garis">Tindak Lanjut Oleh Pusat</h2>
                          <table class="form_tabel">
                            <tr><td class="td_left">Tanggal Tindakan</td><td class="td_right"><?php echo $sess['TANGGAL_TINDAKAN_PUSAT']; ?></td></tr>
                            <tr><td class="td_left">Unit yang melakukan tindakan</td><td class="td_right"><?php echo $sess['UNIT_PUSAT']; ?></td></tr>
                            <tr><td class="td_left">Detail Tindakan</td><td class="td_right"><?php echo $sess['DETAIL_TINDAKAN_PUSAT']; ?></td></tr>
                            <?php
							if($ispelayanan == "03"){
							?>
                            <tr>
                            	<td class="td_left">File Tindak Lanjut</td>
                                <td class="td_right">
								<?php if($sess['FILE_TINDAK_LANJUT'] != ""){ ?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TINDAK_LANJUT']; ?>" target="_blank">File Lampiran</a><?php } ?></td>
                            </tr>
                            <?php
							}
							?>
                            </table>
							<?php 
							} 
							?>
                     </div>
              </div><!-- Akhir Tindak Lanjut !-->
              
              <?php
			  if($isPerbaikan){
			  ?>
              <div style="height:5px;"></div>
              <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PERBAIKAN</a></div>
              <div class="collapse">
                  <div class="accCntnt">
                  <h2 class="small garis">Perbaikan</h2>
                    <table class="form_tabel">
                        <tr><td class="td_left">Tanggal Perbaikan</td><td class="td_right"><input type="text" name="PERBAIKAN[TANGGAL_PERBAIKAN]" id="F02MM_tgperbaikan" class="sdate" title="Tanggal Perbaikan" /></td></tr>
                        <tr><td class="td_left">Detail Perbaikan</td><td class="td_right"><textarea class="stext catatan" name="PERBAIKAN[DETAIL_PERBAIKAN]" id="F02MM_perbaikan" title="Detail Perbaikan"></textarea></td></tr>
                        <tr><td class="td_left">File Perbaikan</td><td class="td_right">
                        <span class="upload_PERBAIKAN"><input type="file" class="stext upload" jenis="PERBAIKAN" allowed="rar-zip" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_PERBAIKAN" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;Tipe File : *.rar, *.zip</span><span class="file_PERBAIKAN"></span></td></tr>
                      </table> 
                      <?php if($sess['JML_PERBAIKAN'] != "0"){?>
                      <div style="padding-top:5px;">
                      <h2 class="small"><a href="#" url="<?php echo $histori_perbaikan; ?>" onclick="expand_detail($(this), 'detil_perbaikan'); return false;" id="daftar_perbaikan">Daftar Perbaikan (<?php echo $sess['JML_PERBAIKAN']; ?>)</a></h2>
                      <div id="detil_perbaikan"></div>
                      </div> 
                      <?php } ?>
                 </div>
              </div><!-- Akhir Perbaikan !-->
              <?php
			  }
			  ?>
              
              <?php
			  if($this->newsession->userdata('SESS_BBPOM_ID') != "93"){
				  ?>
                  <div style="height:5px;"></div>
                  <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PERBAIKAN</a></div>
                  <div class="collapse">
                          <div class="accCntnt">
                          <h2 class="small garis">Perbaikan</h2>
                             <div id="perbaikan-list" url="<?php echo site_url().'/get/pemeriksaan/set_perbaikan/'.$sess['PERIKSA_ID'].'/'.$sess['JENIS_SARANA_ID']; ?>"></div>
                             
                             <?php
							if($sess['CREATE_BY'] == $this->newsession->userdata('SESS_USER_ID')){
								?>
								<div style="height:5px;"></div>
								<div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
									<p><a href="javascript:void(0);" id="showperbaikanbalai" url="<?php echo site_url(); ?>/get/pemeriksaan/input/perbaikan/napza/<?php echo $sess['PERIKSA_ID']; ?>">Klik disini untuk menambahkan perbaikan</a></p>
								</div>
								<?
							}
							?>
                         </div>
                  </div>
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


    <div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#fnapza_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a><input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="JML_PERBAIKAN" value="<?php echo $sess['JML_PERBAIKAN']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" /><input type="hidden" name="redir" value="<?php echo $redir; ?>" /></div>
    <div id="clear_fix"></div>


</form>
</div>
<div id="ctn-edit-tl-balai"></div>
<div id="ctn-edit-perbaikan-balai"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("#detail_petugas").html("Loading ...");
	$("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#perbaikan-list").html("Loading ...");
	$("#perbaikan-list").load($("#perbaikan-list").attr("url"));
	
	$("#F02MM_tgpusat, #F02MM_tgperbaikan").datepicker();
	$(".del_upload").live("click", function(){
		var jenis = $(this).attr("jns");
		$.ajax({
			type: "GET",
			url: $(this).attr("url"),
			data: $(this).serialize(),
			success: function(data){
				var arrdata = data.split("#");
				$(".upload_"+jenis+"").show();
				$("#fileToUpload_"+jenis+"").val('');
				$(".file_"+jenis+"").html("");
				if(jenis!="FILE_LAMPIRAN_BAP")$("#fileToUpload_"+jenis+"").attr("rel","required");
			}
		});
		return false;
	});
	$("#showtlbalai").click(function(){
		$.get($(this).attr("url"), function(data){
			$("#ctn-edit-tl-balai").html(data); 
			$("#ctn-edit-tl-balai").dialog({ 
				title: 'Tindak Lanjut Balai', 
				width: 700, 
				resizable: false, 
				modal: true
			}); 
		});
	});
	//showperbaikanbalai
	$("#showperbaikanbalai").click(function(){
		$.get($(this).attr("url"), function(data){
			$("#ctn-edit-perbaikan-balai").html(data); 
			$("#ctn-edit-perbaikan-balai").dialog({ 
				title: 'Perbaikan Balai', 
				width: 700, 
				resizable: false, 
				modal: true
			}); 
		});
	});
});

function do_upload(element){
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
					if(jenis == "TINDAK_LANJUT"){
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_NAPZA_PUSAT[FILE_"+arrdata[2]+"]\" value="+arrdata[0]+">");
					}else if(jenis == "PERBAIKAN"){
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PERBAIKAN[FILE_"+arrdata[2]+"]\" value="+arrdata[0]+">");
					}else if(jenis == "FILE_TL_BALAI"){
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"<?php echo $obj_napza; ?>["+arrdata[2]+"]\" value="+arrdata[0]+">");
					}
				}
			}
		},
		error: function (data, status, e){
			jAlert(e, "SIPT Versi 1.0 Beta");
		}
	});
}
</script>
