<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f01HH_" id="f01HH_" method="post" action="<?php echo $act; ?>" autocomplete="off">

<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Informasi Sarana</h2>
                <table class="form_tabel">
                	<tr><td class="td_left">Nama Sarana</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td></tr>
                    <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul></td></tr>
                    <tr><td class="td_left">Alamat Pabrik / Gudang</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?></ul></td></tr>
                    <tr><td class="td_left">Jenis Industri</td><td class="td_right"><?php echo $sess['JENIS_INDUSTRI']; ?></td></tr>
                <tr><td class="td_left">Kegiatan yang dilakukan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $kegiatan = explode(";", $sess['KEGIATAN_SARANA']); echo "<li>".join("</li><li>", $kegiatan)."</li>"; ?></ul></td></tr>
                    <tr><td class="td_left">Nama Pemilik</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
                    <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
                </table>
                
                <h2 class="small">Izin yang Dimiliki</h2>
                <div id="div_izin" url="<?php echo $url_izin; ?>"></div>                
                <div class="div-sertifikat" <?php if(in_array('TUJUAN_PEMERIKSAAN', $sess)){ if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style=""'; else echo 'style="display:none"'; }else{ echo 'style="display:none"';}?>>
                <h2 class="small">Sertifikat</h2>
                <div id="div_sert" url="<?php echo $url_sertifikat; ?>"></div>
                </div>
                <h2 class="small">Informasi Petugas Pemeriksa</h2>
                <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                <div style="height:5px;"></div>
                <h2 class="small">Informasi Pemeriksaan</h2>
                <h2 class="small" <?php if($sess['PERIKSA_SEBELUMNYA']!= 0) echo 'style=""'; else echo 'style="display:none;"'; ?>><a href="#" onclick="show_detail('#detil_inspeksi', '<?php echo $urlinspeksi; ?>'); return false;">Inspeksi Sebelumnya</a></h2>
                <div id="detil_inspeksi"></div>
                <div style="height:5px;"></div>
                <table class="form_tabel">
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
                  <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
                  <tr><td class="td_left">Standard yang Digunakan</td><td class="td_right"><?php echo $sess['STANDARD']; ?></td></tr>
                  <tr><td class="td_left">Kepatuhan CPOTB dan Keputusan</td><td class="td_right"><?php echo $sess['KEPATUHAN_CPOTB']; ?></td></tr>
                  <tr><td class="td_left">Latar Belakang Hasil Pemeriksaan yang Lalu</td><td class="td_right"><?php echo $sess['LATAR_BELAKANG']; ?></td></tr>
                  <tr><td class="td_left">Perubahan Bermakna sejak inspeksi terakhir</td><td class="td_right"><?php echo $sess['PERUBAHAN_BERMAKNA']; ?></td></tr>
                  <tr><td colspan="2"><h2 class="small">Penjelasan Singkat Dari Kegiatan Inspeksi yang Dilakukan</h2></td></tr>
                  <tr><td class="td_left">Ruang Lingkup</td><td class="td_right"><?php echo $sess['RUANG_LINGKUP']; ?></td></tr>
                  <tr><td class="td_left">Area Inspeksi</td><td class="td_right"><?php echo $sess['AREA_INSPEKSI']; ?></td></tr>
                </table>
				</div>
        </div><!-- Akhir Informasi Sarana !-->

		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN OBSERVASI</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Temuan Observasi</h2>
                <div id="data_temuan" url="<?php echo $url_observasi; ?>"></div>
                <div style="height:5px;"></div>
                <table class="form_tabel">
                  <tr><td class="td_left">Distribusi dan Pengangkutan</td><td class="td_right"><?php echo $sess['DISTRIBUSI_PENGANGKUTAN']; ?></td></tr>
                  <tr><td class="td_left">Pertanyaan Berkaitan dengan Penilaian Permohonan Pendaftaran Produk</td><td class="td_right"><?php echo $sess['PERMOHONAN_PENDAFTARAN_PRODUK']; ?></td></tr>
                  <tr><td class="td_left">Isu Spesifik Lainnya</td><td class="td_right"><?php echo $sess['ISU_SPESIFIK_LAINNYA']; ?></td></tr>
                  <tr>
                    <td class="td_left">Site Master File</td><td class="td_right"><?php echo $sess['SITE_FILE_MASTER']; ?></td></tr>
                  <tr><td class="td_left">Lain-Lain</td><td class="td_right"><?php echo $sess['LAIN_LAIN']; ?></td></tr>
                  <tr><td class="td_left">Sampel yang Diambil</td><td class="td_right"><?php echo $sess['SAMPEL_DIAMBIL']; ?></td></tr>
                  <tr><td class="td_left">Distribusi Laporan</td><td class="td_right"><?php echo $sess['DISTRIBUSI_LAPORAN']; ?></td></tr>
                  <tr><td class="td_left">Lampiran</td><td class="td_right"><?php 
				  if($sess['LAMPIRAN'] != "" && trim($sess['LAMPIRAN']) != ""){
					  ?>
                      <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>
                      <?php
				  }
				  ?></td></tr>
                </table>
              
                <h2 class="small">Tindak Lanjut Temuan dan Observasi</h2> 
                <table class="form_tabel">
                  <tr><td class="td_left">Tindakan</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php echo "<li>".join("</li><li>", $sel_tindakan_observasi)."</li>"; ?></ul></td></tr>
                </table>
              
            </div>
        </div><!-- Akhir Temuan Observasi !-->

		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DAFTAR KLASIFIKASI TEMUAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Daftar Klasifikasi Temuan</h2>
              <table class="form_tabel">
                  <tr><td class="td_left">1. Temuan Kritikal</td><td class="td_right"><?php echo $sess['TEMUAN_KRITIKAL']; ?></td></tr>
                  <tr><td class="td_left">2. Temuan Major</td><td class="td_right"><?php echo $sess['TEMUAN_MAJOR']; ?></td></tr>
                  <tr><td class="td_left">3. Temuan Minor</td><td class="td_right"><?php echo $sess['TEMUAN_MINOR']; ?></td></tr></table>
				</div>
        </div><!-- Akhir Informasi Sarana !-->
        
		<div class="div-temuan" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style="display:none"'; else echo 'style=""';?>>
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
                <table width="99%" id="F01HH_temuankos" cellpadding="0" cellspacing="0" class="listtemuan">
                    <thead>
                        <tr>
                        <th>Detil Obat Tradisional</th><th>Nama<br />Perusahaan</th><th>Kategori<br />Temuan</th>
                        <th>Jenis <br /> Pelanggaran</th>
                        <th>Harga Total</th><th>Keterangan<br />(sumber perolehan)</th></tr>
                    </thead>
                    <tbody id="F01HH_temuanbodykos">
					<?php
					    if(!$temuan_produk==''){
							if($sess['JMLTEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
                                    <tr id="baris<?php echo $i; ?>"><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br />Klasifikasi : <?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?><br />No. Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Batch :<?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire :<?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><br>Netto : <?php echo $temuan_produk[$i]['NETTO']; ?><br>Jenis Satuan : <?php echo $temuan_produk[$i]['SATUAN']; ?><br />Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br><?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td><?php echo $temuan_produk[$i]['KATEGORI']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?><br />Tindakan Produk : <?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>

                                    <?php
								}
							}else{
								$temuan_produk = "";
							}
						}
					  ?>                  
                    </tbody>
                </table>
				</div>
        </div><!-- Akhir Informasi Sarana !-->
        </div>
        
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;"><?php if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){?> KESIMPULAN dan TINDAK LANJUT <?php }else ?> KESIMPULAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan</h2>
                <?php
				if($isEditTLBalai){
					?>
                    <table id="F02OT_tbhasil" class="form_tabel">
                    <tr id="row_hasil" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style="display:none"'; else echo 'style=""';?>><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo $sess['HASIL']; ?></td></tr>
                    <tr id="row_catatan" <?php if($sel_hasil == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Catatan<td class="td_right"><?php echo $sess['REKOMENDASI']; ?></td></tr>
                    <tr id="row_tmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Detil Hasil Pemeriksaan</td><td class="td_right"><?php if(trim($sess["DETIL_HASIL"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $detil_hasil = explode("#", $sess['DETIL_HASIL']); echo "<li>".join("</li><li>", $detil_hasil)."</li>"; ?></ul><?php } ?></td></tr>
                    <tr id="row_dttmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left" id="F02OT_tdlabeldetiltmk">Detil Kesimpulan TMK</td><td class="td_right" id="F02OT_tddetiltmk"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess["KESIMPULAN_DETIL_TMK"])); ?></td></tr>
                    </table>                
                    <?php
				}else{
					?>
                    <table id="F02OT_tbhasil" class="form_tabel">
                    <tr id="row_hasil" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style="display:none"'; else echo 'style=""';?>><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN[HASIL]', $hasil, array_key_exists('HASIL', $sess)?$sess['HASIL']:'', 'id="F02OT_hasil" class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td></tr>
                    <tr id="row_catatan" <?php if($sess['HASIL'] == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Catatan<td class="td_right"><textarea class="stext catatan" title="Catatan" name="PEMERIKSAAN_CPOTB[REKOMENDASI]"><?php echo $sess['REKOMENDASI']; ?></textarea></td></tr>
                    <tr id="row_tmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Detil Hasil Pemeriksaan</td><td class="td_right"><span class="F02OT_mk" style="display:none;"></span><span class="F02OT_temuan_kos"><?php echo form_dropdown('PEMERIKSAAN_CPOTB[DETIL_HASIL][]',$detil_tmk,is_array($sel_tmk)?$sel_tmk:'','id="F02OT_detiltmk" class="stext multiselect" multiple title="Detil hasil pemeriksaan. Jika lebih dari satu tekan klik + Ctrl"'); ?></span></td></tr>
                    <tr id="row_dttmk"  <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left" id="F02OT_tdlabeldetiltmk">Detil Kesimpulan TMK</td><td class="td_right" id="F02OT_tddetiltmk">
                    <div style="padding-bottom:5px;"><textarea class="stext chk" name="PEMERIKSAAN_CPOTB[KESIMPULAN_DETIL_TMK]" id="F02OT_detilkesimpulantmk" title="Detil Kesimpulan TMK"><?php echo $sess['KESIMPULAN_DETIL_TMK']; ?></textarea></div>
                    </td></tr>
                    </table>
                    <?php
				}
				?>
                <h2 class="small">Hasil Pusat</h2>
                <table class="form_tabel">
                <?php 
				if($this->newsession->userdata('SESS_BBPOM_ID') == "94" && $BBPOM_ID != "94"){
				?>
                <tr><td class="td_left"> Hasil</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPPKB[HASIL_PUSAT]',$hasil,$sess['HASIL_PUSAT'],'class="stext" title="Rekomendasi Hasil Pusat"'); ?></td></tr>
                <tr>
                  <td class="td_left">Catatan</td><td class="td_right"><textarea class="stext chk" title="Catatan rekomendasi pusat" name="PEMERIKSAAN_CPPKB[CATATAN_PUSAT]"><?php echo $sess['CATATAN_PUSAT']; ?></textarea></td></tr>
				<?php }else{ ?>
                <tr><td class="td_left">Hasil</td><td class="td_right"><?php echo $sess['HASIL_PUSAT']; ?></td></tr>
                <tr>
                  <td class="td_left">Catatan</td><td class="td_right"><?php echo $sess['CATATAN_PUSAT']; ?></td></tr>
                <?php } ?>
                </table>
                <?php
				if($isEditTL){
					?>
                    <h2 class="small garis">Tindak Lanjut</h2>
                    <table class="form_tabel">
                    <tr><td class="td_left">Tindak Lanjut Hasil Inspeksi</td><td class="td_right"><?php echo $sess['TINDAK_LANJUT']; ?></td></tr>
                    <tr><td class="td_left">Time Line</td><td class="td_right"><?php echo $sess['TIME_LINE']; ?></td></tr>
                    </table>
                    <h2 class="small">C A P A</h2>
                    <table class="form_tabel">
                    <tr><td class="td_left">Hasil Evaluasi CAPA</td><td class="td_right"><?php echo $sess['STATUS_CAPA']; ?></td></tr>
                    </table>
                    <?php
				}else{
					?>
                    <h2 class="small garis">Tindak Lanjut</h2>
                      <table class="form_tabel">
                      <tr><td class="td_left">Tindak Lanjut Hasil Inspeksi</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPOTB[TINDAK_LANJUT]',$tl_cpotb,$sess['TINDAK_LANJUT'],'class="stext" id="F01OO_tindaklanjut" rel="required" title="Tindak lanjut hasil inspeksi" onchange="sel_inspeksi($(this), \'#timeline\'); return false;"'); ?></td></tr>
                      <tr><td class="td_left">Time Line</td><td class="td_right"><textarea class="stext catatan" id="timeline" name="PEMERIKSAAN_CPOTB[TIME_LINE]" title="Timeline tindak lanjut hasil inspeksi"><?php echo $sess['TIME_LINE']; ?></textarea></td></tr>
                      </table>
                      <h2 class="small">C A P A</h2>
                      <table class="form_tabel">
                      <tr><td class="td_left">Hasil Evaluasi CAPA</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPOTB[STATUS_CAPA]',$capa_cpotb,$sess['STATUS_CAPA'],'class="stext" id="F01OO_capa" title="Hasil evaluasi CAPA"'); ?></td></tr>
                      </table>
                    <?php
				}
				?>
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        
		<?php
        if($isPerbaikan){
        ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PERBAIKAN</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Perbaikan</h2>
              
                <table class="form_tabel">
               	<tr><td class="td_left">Tanggal Perbaikan</td><td class="td_right"><input type="text" class="sdate" id="F01HH_tgl_perbaikan" name="PERBAIKAN[TANGGAL_PERBAIKAN]" title="Tanggal perbaikan" /></td></tr>
                <tr id="row_perbaikan" <?php if($sess['STATUS_CAPA'] == "CAPA Closed") echo 'style="display:none;"'; else echo 'style=""'; ?>><td class="td_left">Detail Perbaikan</td><td class="td_right"><textarea id="F01HH_perbaikan" name="PERBAIKAN[DETAIL_PERBAIKAN]" class="stext catatan" title="Detail perbaikan"></textarea></td></tr>
                <tr id="row_attach" <?php if($sess['STATUS_CAPA'] == "CAPA Closed") echo 'style="display:none;"'; else echo 'style=""'; ?>><td class="td_left"></td><td class="td_right td_attach"><input type="file" class="stext upload" name="userfile" id="attach_perbaikan" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/perbaikan/<?php echo $sess['SARANA_ID']; ?>" allowed="xls-xlsx-doc-docx-rar-zip-pdf" onchange="attach_doc_perbaikan($(this)); return false;" title="File perbaikan" />&nbsp;File tipe : *.doc, *.docx, *.xls, *.xlsx, *.rar, *.zip, *.pdf</td></tr>
                <tr id="row_capa_close" <?php if( $sess['STATUS_CAPA'] == "Perbaikan CAPA" || trim($sess['STATUS_CAPA']) == "") echo 'style="display:none;"'; else echo 'style=""'; ?>><td class="td_left">Detail Perbaikan</td><td class="td_right"><?php echo form_dropdown($obj_ot.'[CAPA_CLOSED]',$capa_close_cpotb,$sess['CAPA_CLOSED'],'class="stext" title="Detail perbaikan CAPA"'); ?></td>
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
<div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f01HH_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
</form>
</div>


<script type="text/javascript">
$(document).ready(function(){
	create_ck("textarea.chk",505)
	$("#detail_petugas").html("Loading ..."); $("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#data_temuan").html("Loading ..."); $("#data_temuan").load($("#data_temuan").attr("url"));
	$("#div_izin").html('Loading..'); $("#div_izin").load($("#div_izin").attr("url"));
	$("#div_sert").html('Loading..'); $("#div_sert").load($("#div_sert").attr("url"));
	$('#F01HH_tgl_perbaikan').datepicker({ changeMonth: true,changeYear: true,autoSize: true, dateFormat: 'dd/mm/yy',regional: 'id'});
	$("#F02OT_hasil").change(function(){val = $(this).val(); if(val == "TMK"){ $("#row_catatan").hide(); $("#row_tmk").show();$("#row_dttmk").show(); }else{ $("#row_catatan").show(); $("#row_tmk").hide(); $("#row_dttmk").hide(); } });
			
	$("#F02OT_detiltmk").change(function(){
		var str = "";
		var gabung = "Detail TMK : \r\n";
		$("#F02OT_tbhasil #F02OT_tdlabeldetiltmk").html("Detil Kesimpulan TMK");
		$("#F02OT_detiltmk option:selected").each(function(i){
			str += '<div style="padding-bottom:5px;"><textarea class="stext catatan" name="PEMERIKSAAN_CPOTB[KESIMPULAN_DETIL_TMK][]" id="F02OT_detilkesimpulantmk" title="Detil Kesimpulan TMK">'+$(this).text()+' : </textarea></div>';
			gabung += '- '+$(this).text()+"\r\n";
		});
		$("#F02OT_tbhasil #F02OT_tddetiltmk").html(str);
	});
	
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
		  	  
});

function sel_inspeksi(element, obj_keterangan){
	var val = $(element).val();
	if(val == "Perbaikan"){
		$(obj_keterangan).val('3 Bulan');
	}else if(val == "Peringatan Keras"){
		$(obj_keterangan).val('2 Bulan');
	}else if(val == ""){
		$(obj_keterangan).val('');
	}else{
		$(obj_keterangan).val('1 Bulan');
	}
}

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
</script>
