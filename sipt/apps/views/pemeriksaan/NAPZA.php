<?php 
$SESS_TGL = $this->session->userdata('SURAT');
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
						  <?php 
						  if($jenis_sarana_id == '03AN'){
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
                        <tr><td class="td_left">Telp.</td><td class="td_right"><?php if(trim($sess['TELEPON']) != ""){?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul><?php } ?></td></tr>
                    </table>
                    <h2 class="small">Informasi Pemeriksaan</h2>
                    <table class="form_tabel">
                        <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" /><input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td></tr>
                        <tr>
                          <td class="td_left">Tujuan Pemeriksaan</td>
                          <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_NAPZA[TUJUAN_PEMERIKSAAN]', $tujuan_periksa, array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:'', 'id="tujuanperiksa_" class="stext" rel="required" title="Tujuan pemeriksaan"'); ?></td>
                      </tr>
                        <tr>
                          <td class="td_left">Dasar Pemeriksaan</td>
                          <td class="td_right"><textarea class="stext" name="PEMERIKSAAN_NAPZA[DASAR_PEMERIKSAAN]" rel="required" title="Dasar Pemeriksaan"><?php echo array_key_exists('DASAR_PEMERIKSAAN', $sess)?$sess['DASAR_PEMERIKSAAN']:""; ?></textarea></td>
                      </tr>
                    </table>
                    <h2 class="small">Informasi Petugas Pemeriksa</h2>
                    <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                    <div style="padding-top:5px;">
                    <h2 class="small">Pemeriksaan Sebelumnya</h2>
                    <div id="detail_periksa" url="<?php echo $history_periksa; ?>"></div>
                  </div> 

                  </div>
          </div><!-- End Informasi Pemeriksaan !-->
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN</a></div>
              <div class="collapse">
                  <div class="accCntnt">
                  <h2 class="small garis">Temuan</h2>
				  <div>
				  <input type="hidden" value="0" id="flag">
                  <table class="form_tabel" id="FN_tbnapza">
                  	<tr><td class="td_left">Nama Produk</td><td class="td_right"><input type="text" class="stext" id="FN_produk" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/1" title="Nama Produk" /><input type="hidden" id="FN_produk_id" /></td></tr>
                    <tr><td class="td_left">Jenis Pelanggaran</td><td class="td_right">
                    <textarea class="stext" id="FN_jenis_pelanggaran" url="<?php echo site_url(); ?>/autocompletes/autocomplete/jenis_pelanggaran/<?php echo $jenis_sarana_id; ?>/<?php echo $klasifikasi; ?>" title="Jenis Pelanggaran Produk" ></textarea><input type="hidden" id="FN_klasifikasi" />&nbsp;<a href="#" id="jenis_pelanggaran" url="<?php echo site_url(); ?>/load/master/list_pelanggaran/<?php echo $jenis_sarana_id; ?>" onclick="PopupCenter('#jenis_pelanggaran'); return false;" judul="Master_Data_Pelanggaran" lebar="900" tinggi="400"><img src="<?php echo base_url(); ?>images/info.png" align="absmiddle" style="border:none" title="Daftar Master Jenis Pelanggaran" /></a></td></tr>
                    <tr><td class="td_left">Jenis Penyimpangan</td><td class="td_right">
                    <textarea class="stext" id="FN_jenis_penyimpangan" title="Jenis Penyimpangan Produk" readonly="readonly" ></textarea><input type="hidden" id="FN_KK_ID" /></td></tr>
                    <tr><td class="td_left">Jenis Kriteria Pelanggaran</td><td class="td_right"><input type="text" id="FN_kriteria_pelanggaran" class="stext" readonly="readonly" title="Jenis Kriteria Pelanggaran Produk" /></td></tr>
                  </table>
                  <div class="btn"><span><a href="#" id="FN_addtemuan">Tambah Temuan</a></span></div>                  
				  <div style="padding-bottom:5px;"></div>
				  </div>
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
					    if(!$temuan_produk==''){
							if($sess['JML_TEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
									<tr id="<?php echo $temuan_produk[$i]['SERI']; ?>"><td><input type="hidden" name="TEMUAN[NAMA_PRODUK][]" value="<?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?>" /><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?></td><td><input type="hidden" name="TEMUAN[JENIS_PELANGGARAN][]" value="<?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?>" /><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?></td><td><input type="hidden" name="TEMUAN[JENIS_KRITERIA_PELANGGARAN][]" value="<?php echo $temuan_produk[$i]['JENIS_KRITERIA_PELANGGARAN']; ?>" /><?php echo $temuan_produk[$i]['JENIS_KRITERIA_PELANGGARAN']; ?></td><td><input type="hidden" name="TEMUAN[JENIS_PENYIMPANGAN][]" value="<?php echo $temuan_produk[$i]['JENIS_PENYIMPANGAN']; ?>" /><?php echo $temuan_produk[$i]['JENIS_PENYIMPANGAN']; ?></td><td><input type="hidden" name="TEMUAN[KLASIFIKASI_PRODUK][]" value="<?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?>" /><?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?><span style="float:right;"><a href="#" id="FN_delrow"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Batalkan atau hapus temuan produk" /></a></span></td></tr>
									<?php
								}
							}else{
								$temuan_produk = "";
							}
						}
					  ?>
					  </tbody>
				  </table>
				  <div id="clear_fix"></div>
				  <table class="form_tabel">
					<tr><td class="td_left">File BAP</td><td class="td_right">
					<?php
					if(array_key_exists('FILE_BAP', $sess) && trim($sess['FILE_BAP']) != ""){
						?>
                        <span class="upload_FILE_BAP" style="display:none;"><input type="file" class="stext upload" jenis="FILE_BAP" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_BAP" name="userfile" <?php echo array_key_exists('FILE_BAP', $sess)? "rel=''":"rel='required'";?> onchange="do_upload($(this)); return false;" title="Lampiran File BAP" />&nbsp;Tipe file : *.pdf</span><span class="file_FILE_BAP"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_BAP']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_BAP']; ?>" jns="FILE_BAP">Edit atau Hapus File ?</a></span>
						<?php
					}else{
					?>
						<span class="upload_FILE_BAP"><input type="file" class="stext upload" jenis="FILE_BAP" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_BAP" name="userfile" rel="required" onchange="do_upload($(this)); return false;" />
						&nbsp;Tipe File : *.pdf</span><span class="file_FILE_BAP"></span>
					<?php 
					}
					?>
					</td></tr>
					<tr><td class="td_left">File Lampiran BAP</td><td class="td_right">
					<?php
					if(array_key_exists('FILE_LAMPIRAN_BAP', $sess) && trim($sess['FILE_LAMPIRAN_BAP']) != ""){
						?>
                        <span class="upload_FILE_LAMPIRAN_BAP" style="display:none;"><input type="file" class="stext upload" jenis="FILE_LAMPIRAN_BAP" allowed="rar-zip" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_LAMPIRAN_BAP" name="userfile" <?php echo array_key_exists('FILE_LAMPIRAN_BAP', $sess)? "rel=''":"rel='required'";?> onchange="do_upload($(this)); return false;" title="File Lampiran BAP"/>&nbsp;Tile File : *.rar, *.zip</span><span class="file_FILE_LAMPIRAN_BAP"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_LAMPIRAN_BAP']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_LAMPIRAN_BAP']; ?>" jns="FILE_LAMPIRAN_BAP">Edit atau Hapus File ?</a></span>
						<?php
					}else{
					?>
					<span class="upload_FILE_LAMPIRAN_BAP"><input type="file" class="stext upload" jenis="FILE_LAMPIRAN_BAP" allowed="rar-zip" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_LAMPIRAN_BAP" name="userfile" onchange="do_upload($(this)); return false;" rel="required"/>&nbsp;Tile File : *.rar, *.zip</span><span class="file_FILE_LAMPIRAN_BAP"></span>
					<?php
					}
					?>
				  </td></tr>
				  </table>
                  </div>
          </div><!-- End Temuan Produk !-->
    	  <div style="height:5px;"></div>	
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
          <div class="collapse">
                  <div class="accCntnt">
                  <h2 class="small garis">Tindak Lanjut</h2>
                  <table class="form_tabel">
                    <tr><td class="td_left">Tanggal Tindakan</td><td class="td_right"><input type="text" name="PEMERIKSAAN_NAPZA[TANGGAL_TINDAKAN_BALAI]" id="F02MM_tgbalai" class="sdate" value="<?php echo array_key_exists('TANGGAL_TINDAKAN_BALAI', $sess)?$sess['TANGGAL_TINDAKAN_BALAI']:""; ?>" title="Tanggal Tindakan Balai"/></td></tr>
                    <tr>
                      <td class="td_left">Unit yang melakukan tindakan</td>
                      <td class="td_right"><textarea class="stext" name="PEMERIKSAAN_NAPZA[UNIT_BALAI]" id="F02MM_unitbalai" title="Unit yang melakukan tindakan"><?php echo array_key_exists('UNIT_BALAI', $sess)?$sess['UNIT_BALAI']:$this->newsession->userdata('SESS_MBBPOM'); ?></textarea></td>
                      </tr>
                    <tr>
                      <td class="td_left">Saran Tindak Lanjut</td>
                      <td class="td_right"><textarea name="PEMERIKSAAN_NAPZA[DETAIL_TINDAKAN_BALAI]" id="F02MM_detilbalai" class="stext catatan" title="Detail Tindakan"><?php echo array_key_exists('DETAIL_TINDAKAN_BALAI', $sess)?$sess['DETAIL_TINDAKAN_BALAI']:""; ?></textarea></td>
                      </tr>
                    <?php
					if($ispelayanan == "03"){
					?>  
                    <tr><td class="td_left">File Tindak Lanjut</td>
                    	<td class="td_right">
                        <?php
						if($sess['FILE_TL_BALAI'] != "" && trim($sess['FILE_TL_BALAI']) != ""){
                          ?>
                          <span class="upload_FILE_TL_BALAI" style="display:none;"><input type="file" class="stext upload" jenis="FILE_TL_BALAI" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_TL_BALAI" name="userfile" onchange="do_upload($(this)); return false;" title="File Lampiran Tindak Lanjut"/>&nbsp;Tipe file : *.pdf</span><span class="file_FILE_TL_BALAI"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TL_BALAI']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TL_BALAI']; ?>" jns="FILE_TL_BALAI">Edit atau Hapus File ?</a></span>                          
						  <?php }else{ ?> 
                        <span class="upload_FILE_TL_BALAI"><input type="file" class="stext upload" jenis="FILE_TL_BALAI" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_TL_BALAI" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;Tipe File : *.pdf</span><span class="file_FILE_TL_BALAI"></span>
                        <?php
                      }
                      ?>
                        
                    </td></tr>
                    <?
					}
					?>
                  </table>
                  
                  <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "93"){ ?>
                  <h2 class="small garis">Tindak Lanjut Oleh Pusat</h2>
                  <table class="form_tabel">
                    <tr><td class="td_left">Tanggal Tindakan</td><td class="td_right"><input type="text" name="PEMERIKSAAN_NAPZA[TANGGAL_TINDAKAN_PUSAT]" id="F02MM_tgpusat" class="sdate" value="<?php echo array_key_exists('TANGGAL_TINDAKAN_PUSAT', $sess)?$sess['TANGGAL_TINDAKAN_PUSAT']:""; ?>" title="Tanggal Tindakan Pusat" /></td></tr>
                    <tr><td class="td_left">Unit yang melakukan tindakan</td><td class="td_right"><textarea class="stext" name="PEMERIKSAAN_NAPZA[UNIT_PUSAT]" id="F02MM_unitpusat" title="Unit yang melakukan tindakan"><?php echo array_key_exists('UNIT_PUSAT', $sess)?$this->newsession->userdata('SESS_MBBPOM'):$sess['UNIT_PUSAT']; ?></textarea></td></tr>
                    <tr><td class="td_left">Detail Tindakan</td><td class="td_right"><textarea name="PEMERIKSAAN_NAPZA[DETAIL_TINDAKAN_PUSAT]" id="F02MM_detilpusat" class="stext catatan" title="Detail Tindakan Pusat"><?php echo array_key_exists('DETAIL_TINDAKAN_PUSAT', $sess)?$sess['DETAIL_TINDAKAN_PUSAT']:""; ?></textarea></td></tr>
                    <?php
					if($ispelayanan == "03"){
					?>
                    <tr><td class="td_left">File Tindak Lanjut</td><td class="td_right"><?php
                      if($sess['FILE_TINDAK_LANJUT'] != "" && trim($sess['FILE_TINDAK_LANJUT']) != ""){
                          ?>
                          <span class="upload_FILE_TINDAK_LANJUT" style="display:none;"><input type="file" class="stext upload" jenis="FILE_TINDAK_LANJUT" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_TINDAK_LANJUT" name="userfile" <?php echo array_key_exists('FILE_LAMPIRAN_BAP', $sess)? "rel=''":"rel='required'";?> onchange="do_upload($(this)); return false;" title="File Lampiran BAP"/>&nbsp;Tipe file : *.pdf</span><span class="file_FILE_TINDAK_LANJUT"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TINDAK_LANJUT']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['FILE_TINDAK_LANJUT']; ?>" jns="FILE_TINDAK_LANJUT">Edit atau Hapus File ?</a></span>                          
						  <?php }else{ ?> 
                        <span class="upload_FILE_TINDAK_LANJUT"><input type="file" class="stext upload" jenis="FILE_TINDAK_LANJUT" allowed="pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_FILE_TINDAK_LANJUT" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;Tipe File : *.pdf</span><span class="file_FILE_TINDAK_LANJUT"></span>
                        <?php
                      }
                      ?></td></tr>
                      <?php
					}
					?>
                  </table>
                  <?php } ?>
                  
                  </div>
          </div>
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
        
    </div><!-- End Accordian !-->
</div>
    <div id="clear_fix"></div>

    <div><a href="#" class="button save" onclick="fpost('#fnapza_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#detail_petugas").html("Loading ...");
	$("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#detail_periksa").html("Loading ...");
	$("#detail_periksa").load($("#detail_periksa").attr("url"));
	$("#F02MM_tgl_surat, #F02MM_tgpusat, #F02MM_tgbalai, #F02MM_tgperbaikan").datepicker();
	$("#F02MM_delrow, #FN_delrow").live("click", function(){
		id = $(this).closest("table tr").attr("id");
		$("table #"+id).remove();
		return false;
	});
 
	$("#FN_produk").autocomplete($("#FN_produk").attr('url'), {width: 244, selectFirst: false});
	$("#FN_produk").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#FN_produk_id").val(data[1]);
			$("#FN_jenis_pelanggaran").focus();
			$("#flag").val('1');
		}
	});
	
	$("#FN_jenis_pelanggaran").autocomplete($("#FN_jenis_pelanggaran").attr('url'), {width: 244, selectFirst: false});
	$("#FN_jenis_pelanggaran").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#FN_kriteria_pelanggaran").val(data[3]);
			$("#FN_jenis_penyimpangan").val(data[4]);
			$("#FN_klasifikasi").val(data[2]);
			$("#FN_KK_ID").val(data[5]);
			$("#FN_addtemuan").focus();
		}
	});

	$("#FN_addtemuan").click(function(){
		var nama = $("#FN_produk_id").val();
		if(!beforeSubmit("#FN_tbnapza") && nama == ""){
			return false;
		}else{
			var id = $('#FN_bodytemuan tr').length;
			$("#FN_temuan #FN_bodytemuan").append('<tr id="'+(id+1)+'"><td>'+$("#FN_produk").val()+'<input type="hidden" name="TEMUAN[NAMA_PRODUK][]" value="'+$("#FN_produk").val()+'"></td><td>'+$("#FN_jenis_pelanggaran").val()+'<input type="hidden" name="TEMUAN[JENIS_PELANGGARAN][]" value="'+$("#FN_jenis_pelanggaran").val()+'"></td><td>'+$("#FN_kriteria_pelanggaran").val()+'<input type="hidden" name="TEMUAN[JENIS_KRITERIA_PELANGGARAN][]" value="'+$("#FN_kriteria_pelanggaran").val()+'"></td><td>'+$("#FN_jenis_penyimpangan").val()+'<input type="hidden" name="TEMUAN[JENIS_PENYIMPANGAN][]" value="'+$("#FN_jenis_penyimpangan").val()+'"></td><td>'+$("#FN_klasifikasi").val()+'<input type="hidden" name="TEMUAN[KLASIFIKASI_PRODUK][]" value="'+$("#FN_klasifikasi").val()+'"><input type="hidden" name="TEMUAN[KK_ID][]" value="'+$("#FN_KK_ID").val()+'"><input type="hidden" name="TEMUAN[FLAG][]" value="'+$("#flag").val()+'"><span style="float:right;"><a href="#" id="FN_delrow"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Batalkan atau hapus temuan produk" /></a></span></td></tr>');
			clearForm("#FN_tbnapza");
			$("#flag").val('0');
			return false;
		}
	});
		
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
					if(arrdata[2] == "FILE_BAP" || arrdata[2] == "FILE_TINDAK_LANJUT" || arrdata[2] == "FILE_LAMPIRAN_BAP"){
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
					}
					$(".upload_"+arrdata[2]+"").hide();
					$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_NAPZA["+arrdata[2]+"]\" value="+arrdata[0]+">");
				}
			}
		},
		error: function (data, status, e){
			jAlert(e, "SIPT Versi 1.0 Beta");
		}
	});
}

</script>
