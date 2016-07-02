<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f01PK_" id="f01PK_" method="post" action="<?php echo $act; ?>" autocomplete="off">

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
                
                <h2 class="small"><input type="checkbox" id="cek_izin" <?php if($jmlizin != 0) echo 'checked="checked"'; ?> />&nbsp;Ada Izin yang Dimiliki</h2>
                <div id="div_izin" url="<?php echo $url_izin; ?>" jml="<?php echo $jmlizin; ?>"></div>                
                <div class="div-sertifikat" <?php 
				if(in_array('TUJUAN_PEMERIKSAAN', $sess)){ if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style=""'; else echo 'style="display:none"'; }else{ echo 'style="display:none"';}?>>
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
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" /><input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td></tr>
                  <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPPKB[TUJUAN_PEMERIKSAAN]', $tujuan_pemeriksaan, $sess['TUJUAN_PEMERIKSAAN'], 'class="stext" title="Pilih salah satu tujuan pemeriksaan" onchange="sel_tujuan($(this));"'); ?></td></tr>
                  <tr><td class="td_left">Standard yang Digunakan</td><td class="td_right"><textarea name="PEMERIKSAAN_CPPKB[STANDARD]" class="stext chk" title="Pedoman Standard"><?php echo array_key_exists('STANDARD', $sess)?$sess['STANDARD']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Kepatuhan dan Keputusan</td><td class="td_right"><textarea class="stext chk" id="F01OO_keputusan" name="PEMERIKSAAN_CPPKB[KEPATUHAN_CPPKB]" title="Kepatuhan CPPKB dan Keputusan"><?php echo array_key_exists('KEPATUHAN_CPPKB', $sess)?$sess['KEPATUHAN_CPPKB']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Latar Belakang Hasil Pemeriksaan yang Lalu</td><td class="td_right"><textarea class="stext chk" id="F01OO_latarbelakang" name="PEMERIKSAAN_CPPKB[LATAR_BELAKANG]" title="Latar belakang hasil pemeriksaan yang lalu"><?php echo array_key_exists('LATAR_BELAKANG', $sess)?$sess['LATAR_BELAKANG']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Perubahan Bermakna sejak inspeksi terakhir</td><td class="td_right"><textarea class="stext chk" id="F01OO_perubahanmajor2" name="PEMERIKSAAN_CPPKB[PERUBAHAN_BERMAKNA]" title="Perubahan bermaknsa sejak inspeksi terkahir"><?php echo array_key_exists('PERUBAHAN_BERMAKNA', $sess)?$sess['PERUBAHAN_BERMAKNA']:""; ?></textarea></td></tr>
                  <tr><td colspan="2"><h2 class="small">Penjelasan Singkat Dari Kegiatan Inspeksi yang Dilakukan</h2></td></tr>
                  <tr><td class="td_left">Ruang Lingkup</td><td class="td_right"><textarea class="stext chk" id="F01OO_ruanglingkup" name="PEMERIKSAAN_CPPKB[RUANG_LINGKUP]" title="Ruang lingkup"><?php echo array_key_exists('RUANG_LINGKUP', $sess)?$sess['RUANG_LINGKUP']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Area Inspeksi</td><td class="td_right"><textarea class="stext chk" id="F01OO_areainspeksi" name="PEMERIKSAAN_CPPKB[AREA_INSPEKSI]" title="Area Inspeksi"><?php echo array_key_exists('AREA_INSPEKSI', $sess)?$sess['AREA_INSPEKSI']:""; ?></textarea></td></tr>
                </table>
				</div>
        </div><!-- Akhir Informasi Sarana !-->

		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN OBSERVASI</a></div>
        <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Temuan Observasi</h2>
              <table class="listtemuan" id="tb_temuan" width="100%">
                  <thead><tr><th>Klasifikasi Temuan dan Keterangan Temuan</th><th>Kriteria Temuan dan Lampiran File</th></tr></thead>
                  <?php
                      $jmldata = count($temuan_cpotb);
                      if($jmldata==0){
                          $jmldata = 1;
                          $temuan_cpotb[] = "";
                      }
                      $currenttemuan = "";
                      $i = 0;
                      do{
                      ?>
                      <tr class="urut<?php echo $i; ?>"><td width="545px;"><div style="padding-bottom:5px;"><?php echo form_dropdown('TEMUAN[TEMUAN_OBSERVASI][]',$temuan_observasi,$temuan_cpotb[$i]['TEMUAN_OBSERVASI'],'class="stext"'); ?></div><div><textarea class="stext chk" id="TEMUAN_OB<?php echo $id; ?>" name="TEMUAN[TEMUAN_TEKS][]"><?php echo $temuan_cpotb[$i]['TEMUAN_TEKS']; ?></textarea></div></td><td><div style="padding-bottom:5px;"><?php echo form_dropdown('TEMUAN[TEMUAN_KRITERIA][]', $cb_observasi, $temuan_cpotb[$i]['TEMUAN_KRITERIA'], 'class="sel_penyimpangan" title="Pilih salah satu pilihan : Kritikal, Major, Minor, Observasi" hasil="" onchange="CountKriteria($(this).val());"'); ?>&nbsp;&nbsp;
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
                      <?php if(trim($temuan_cpotb[$i]['TEMUAN_FILE']) == ""){ ?>
                      <span class="attach<?php echo $i; ?>"><input type="file" class="stext" file_ke="file_ke<?php echo $i; ?>" id="attach<?php echo $i; ?>" name="userfile" allowed="xls-xlsx-doc-docx-jpg-jpeg-rar-zip-pdf-csv-png-gif" onchange="attach_doc_tabel($(this));" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/temuan/<?php echo $sarana_id; ?>" /></span>
                      <span class="file<?php echo $i; ?>"></span>
                      <?php }else{ ?>
                      <span class="attach<?php echo $i; ?>"></span>
                      <span class="file<?php echo $i; ?>"><b>1 File telah dilampirkan. </b><br><a href="<?php echo base_url(); ?>files/<?php echo $sarana_id; ?>/<?php echo $temuan_cpotb[$i]['TEMUAN_FILE']; ?>" target="_blank">Tampilkan File</a>&nbsp;&bull;&nbsp;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sarana_id; ?>/<?php echo $temuan_cpotb[$i]['TEMUAN_FILE']; ?>" baris_ke="attach<?php echo $i; ?>" file_ke="file_ke<?php echo $i; ?>">Edit atau Hapus File ?</a></span>
                      <?php } ?>
                      
                      <input type="hidden" name="TEMUAN[TEMUAN_FILE][]" class="hd_file<?php echo $i; ?>" value="<?php echo $temuan_cpotb[$i]['TEMUAN_FILE']; ?>" /></div></td></tr>
                      <?php
                      $i++;
                      }while($i<$jmldata);
                  //}
                  ?>
              </table>

                <div style="height:5px;"></div>
                <table class="form_tabel">
                  <tr><td class="td_left">Distribusi dan Pengangkutan</td><td class="td_right"><textarea class="stext chk" id="F01OO_distribusiangkut" name="PEMERIKSAAN_CPPKB[DISTRIBUSI_PENGANGKUTAN]" title="Distribusi dan pengangkutan"><?php echo array_key_exists('DISTRIBUSI_PENGANGKUTAN', $sess)?$sess['DISTRIBUSI_PENGANGKUTAN']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Pertanyaan Berkaitan dengan Penilaian Permohonan Pendaftaran Produk</td><td class="td_right"><textarea class="stext chk" id="F01OO_personel" name="PEMERIKSAAN_CPPKB[PERMOHONAN_PENDAFTARAN_PRODUK]" title="Pertanyaan berkaitan dengan penilaian permohonan pendaftaran produk"><?php echo array_key_exists('PERMOHONAN_PENDAFTARAN_PRODUK', $sess)?$sess['PERMOHONAN_PENDAFTARAN_PRODUK']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Isu Spesifik Lainnya</td><td class="td_right"><textarea class="stext chk" id="F01OO_isu" name="PEMERIKSAAN_CPPKB[ISU_SPESIFIK_LAINNYA]" title="Isu spesifik lainnya"><?php echo array_key_exists('ISU_SPESIFIK_LAINNYA', $sess)?$sess['ISU_SPESIFIK_LAINNYA']:""; ?></textarea></td></tr>
                  <tr>
                    <td class="td_left">Site Master File</td><td class="td_right"><textarea class="stext chk" id="F01OO_sitefile" name="PEMERIKSAAN_CPPKB[SITE_FILE_MASTER]" title="Site master file"><?php echo array_key_exists('SITE_FILE_MASTER', $sess)?$sess['SITE_FILE_MASTER']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Lain-Lain</td><td class="td_right"><textarea class="stext chk" id="F01OO_lainlain" name="PEMERIKSAAN_CPPKB[LAIN_LAIN]" title="Lain-lain"><?php echo array_key_exists('LAIN_LAIN', $sess)?$sess['LAIN_LAIN']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Sampel yang Diambil</td><td class="td_right"><textarea class="stext chk" id="F01OO_sampel" name="PEMERIKSAAN_CPPKB[SAMPEL_DIAMBIL]" title="Sampel yang diambil"><?php echo array_key_exists('SAMPEL_DIAMBIL', $sess)?$sess['SAMPEL_DIAMBIL']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Distribusi Laporan</td><td class="td_right"><textarea class="stext chk" id="F01OO_distribusilaporan" name="PEMERIKSAAN_CPPKB[DISTRIBUSI_LAPORAN]" title="Distribusi laporan"><?php echo array_key_exists('DISTRIBUSI_LAPORAN', $sess)?$sess['DISTRIBUSI_LAPORAN']:""; ?></textarea></td></tr>
                  <tr><td class="td_left">Lampiran</td><td class="td_right">
                  <?php
				  if(array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != ""){
					  ?>
                      <span class="upload_LAMPIRAN" style="display:none;"><input type="file" class="stext upload" jenis="LAMPIRAN" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_lampiran($(this)); return false;" title="File Lampiran Berita Acara Pemeriksaan"/>&nbsp;Tipe file : *.xls,*.xlsx,*.doc,*.docx,*.rar,*.zip,*.pdf</span><span class="file_LAMPIRAN"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_lampiran" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" jns="LAMPIRAN">Edit atau Hapus File ?</a></span>                      
					  <?php
				  }else{
					  ?>
                      <span class="upload_LAMPIRAN"><input type="file" class="stext upload" jenis="LAMPIRAN" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_lampiran($(this)); return false;" title="File Lampiran Berita Acara Pemeriksaan"/>&nbsp;Tipe file : *.xls,*.xlsx,*.doc,*.docx,*.rar,*.zip,*.pdf</span><span class="file_LAMPIRAN"></span>                      <?php
				  }
				  ?></td></tr>
                </table>
              
                <h2 class="small">Tindak Lanjut Temuan dan Observasi</h2> 
                <table class="form_tabel">
                  <tr><td class="td_left">Tindakan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPPKB[TINDAKAN_OBSERVASI][]', $tindakan_observasi, is_array($sel_tindakan_observasi)?$sel_tindakan_observasi:'', 'class="stext multiselect" title="Pilih salah satu, atau untuk lebih dari satu Klik + tekan Ctrl" multiple'); ?></td></tr>
                </table>
              
            </div>
        </div><!-- Akhir Temuan Observasi !-->

		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DAFTAR KLASIFIKASI TEMUAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Daftar Klasifikasi Temuan</h2>
              <table class="form_tabel">
                  <tr><td class="td_left">1. Temuan Kritikal</td><td class="td_right"><input type="text" class="scode" id="jumlah_kritikal" readonly="readonly" name="PEMERIKSAAN_CPPKB[TEMUAN_KRITIKAL]" title="Jumlah temuan kritikal" value="<?php echo array_key_exists('TEMUAN_KRITIKAL', $sess)?$sess['TEMUAN_KRITIKAL']:""; ?>" /></td></tr>
                  <tr><td class="td_left">2. Temuan Major</td><td class="td_right"><input type="text" class="scode" id="jumlah_major" readonly="readonly" name="PEMERIKSAAN_CPPKB[TEMUAN_MAJOR]" title="Jumlah temuan major" value="<?php echo array_key_exists('TEMUAN_MAJOR', $sess)?$sess['TEMUAN_MAJOR']:""; ?>" /></td></tr>
                  <tr><td class="td_left">3. Temuan Minor</td><td class="td_right"><input type="text" class="scode" id="jumlah_minor" readonly="readonly" name="PEMERIKSAAN_CPPKB[TEMUAN_MINOR]" title="Jumlah temuan minor" value="<?php echo array_key_exists('TEMUAN_MINOR', $sess)?$sess['TEMUAN_MINOR']:""; ?>" /></td></tr></table>
				</div>
        </div><!-- Akhir Informasi Sarana !-->
        
		<div class="div-temuan" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style="display:none"'; else echo 'style=""';?>>
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
				<input type="hidden" value="0" id="flag">
                <table id="F01PK_tbtms" class="form_temuan">
                <tr><td class="temuan_left">Nama Produk Komplemen</td><td class="temuan_right"><input type="text" class="stext" id="F01PK_temuan_obat" title="Nama obat tradisional" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/pk" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Nama Perusahaan</td><td class="temuan_right"><input type="text" class="stext" id="F01PK_temuan_perusahaan" title="Nama perusahaan"/></td></tr>
                <tr><td class="temuan_left">Klasifikasi</td><td class="temuan_right"><?php echo form_dropdown('F01PK_klasifikasi_produk',$klasifikasi_temuan,'','class="stext" id="F01PK_klasifikasi_produk" title="Klasifikasi produk"'); ?></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Alamat Perusahaan</td><td class="temuan_right"><textarea class="stext" name="F01PK_temuan_alamat" id="F01PK_temuan_alamat" title="Alamat perusahaan"></textarea></td></tr>
                <tr><td class="temuan_left">No Registrasi</td><td class="temuan_right"><input type="text" class="stext" id="F01PK_temuan_noreg" name="F01PK_temuan_noreg" title="Nomor registrasi"/></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">No Batch</td><td class="temuan_right"><input type="text" class="stext" id="F01PK_temuan_nobatch" name="F01PK_temuan_nobatch" title="No Batch" /></td></tr>
                <tr><td class="temuan_left">Tanggal Expire</td><td class="temuan_right"><input type="text" class="sdate" name="F01PK_temuan_expire" id="F01PK_temuan_expire" title="Tanggal expire" />&nbsp;<small>Jika kosong, isi dengan tanda - (strip)</small></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Netto</td><td class="temuan_right"><input type="text" class="sdate" id="F01PK_temuan_satuan" name="F01PK_temuan_satuan" title="Netto Produk"/></td></tr>
                <tr><td class="temuan_left">Harga Satuan</td><td class="temuan_right"><input type="text" class="sdate" id="F01PK_temuan_harga" name="F01PK_temuan_harga" onkeyup="numericOnly($(this))" title="Harga satuan" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Kategori Temuan</td><td class="temuan_right"><?php echo form_dropdown('F01PK_kategori_temuan',$kategori_temuan,'','class="stext" id="F01PK_temuan_kategori" title="Kategori temuan"'); ?></td></tr>
                <tr id="td_temuan" style="display:none;"><td class="temuan_left">&nbsp;</td><td class="temuan_right">&nbsp;</td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">&nbsp;</td><td class="temuan_right">
				<span class="tmk_penandaan" style="display:none;"><input type="text" id="F01PK_temuan_pelanggaran" class="stext" name="F01PK_temuan_pelanggaran" value="-" title="Keterangan TMK Penandaan" /></span><span class="farmasetik" style="display:none;"><?php echo form_dropdown('F01PK_temuan_farmasetik',$farmasetik,'','class="stext" id="F01PK_temuan_farmasetik" title="Kategori temuan farmasetik"'); ?></span></td></tr>
                <tr><td class="temuan_left">Jenis satuan</td><td class="temuan_right"><select name="F01PK_satuan" id="F01PK_satuan" class="sel_penyimpangan" title="Satuan kemasan"><option value="Buah/Pieces">Buah/Pieces</option><option value="Sachet">Sachet</option><option value="Bungkus">Bungkus</option><option value="Botol">Botol</option><option value="Kaleng">Kaleng</option><option value="Karton">Karton</option><option value="Cup">Cup</option><option value="Kotak">Kotak</option><option value="Tube">Tube</option><option value="Lainnya">Lainnya</option></select>&nbsp;<input type="text" class="sdate" id="F01PK_satuan_lain" style="display:none;" value="-" title="Satuan lainnya"/></td><td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Tindakan Terhadap Produk</td>
                <td class="temuan_right"><?php echo form_dropdown('F01PK_tindakan_produk',$tindak_lanjut_temuan_produk, '','class="stext" id="F01PK_tindakan_produk" title="Pilih salah satu tindak lanjut terhadap produk."'); ?></td></tr>
                <tr><td class="temuan_left">Jumlah Temuan</td><td class="temuan_right"><input type="text" name="F01PK_temuan_jumlah" id="F01PK_temuan_jumlah" class="sdate" onkeyup="numericOnly($(this))" title="Jumlah temuan" /></td><td class="temuan_pemisah">&nbsp;</td><td class="temuan_left">Keterangan (sumber perolehan)</td><td class="temuan_right"><input type="text" id="F01PK_temuan_keterangan" class="stext" name="F01PK_temuan_keterangan" title="Keterangan (sumber perolehan)" /></td></tr>
                </table>
                <div class="btn"><span><a href="#" id="F01PK_add_temuan">Tambah Temuan</a></span></div>                  
                <div style="padding-bottom:5px;"></div>
                <table width="99%" id="F01PK_temuankos" cellpadding="0" cellspacing="0" class="listtemuan">
                    <thead>
                        <tr>
                        <th>Detil Produk Komplemen</th><th>Nama<br />Perusahaan</th><th>Kategori<br />Temuan</th>
                        <th>Jenis <br /> Pelanggaran</th>
                        <th>Harga Total</th><th>Keterangan<br />(sumber perolehan)</th></tr>
                    </thead>
                    <tbody id="F01PK_temuanbodykos">
					<?php
					    if(!$temuan_produk==''){
							if($sess['JUMLAH_TEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
                                    <tr id="baris<?php echo $i; ?>"><td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="<?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?>"><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br />Klasifikasi : <?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?><input type="hidden" name="TEMUAN_PRODUK[KLASIFIKASI_PRODUK][]" value="<?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?>"><br />No. Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="<?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?>"><br>No. Batch :<?php echo $temuan_produk[$i]['NO_BATCH']; ?><input type="hidden" name="TEMUAN_PRODUK[NO_BATCH][]" value="<?php echo $temuan_produk[$i]['NO_BATCH']; ?>"><br>Tanggal Expire :<?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><input type="hidden" name="TEMUAN_PRODUK[TANGGAL_EXPIRE][]" value="<?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?>"><br>Netto : <?php echo $temuan_produk[$i]['NETTO']; ?><input type="hidden" name="TEMUAN_PRODUK[NETTO][]" value="<?php echo $temuan_produk[$i]['NETTO']; ?>"><br>Jenis Satuan : <?php echo $temuan_produk[$i]['SATUAN']; ?><input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="<?php echo $temuan_produk[$i]['SATUAN']; ?>"><br />Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><input type="hidden" name="TEMUAN_PRODUK[HARGA_SATUAN][]" value="<?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?>"><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?><input type="hidden" name="TEMUAN_PRODUK[JUMLAH_TEMUAN][]" value="<?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>"></td><td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="<?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?>"><?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br><?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?><input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="<?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?>"></td><td><?php echo $temuan_produk[$i]['KATEGORI']; ?><input type="hidden" name="TEMUAN_PRODUK[KATEGORI][]" value="<?php echo $temuan_produk[$i]['KATEGORI']; ?>"></td><td><input type="hidden" name="TEMUAN_PRODUK[JENIS_PELANGGARAN][]" value="<?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?>"><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?><br /><input type="hidden" name="TEMUAN_PRODUK[TINDAKAN_PRODUK][]" value="<?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?>">Tindakan Produk : <?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?><input type="hidden" name="TEMUAN_PRODUK[HARGA_TOTAL][]" value="<?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?>"></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?><input type="hidden" name="TEMUAN_PRODUK[KETERANGAN_SUMBER][]" value="<?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?>"><span style="float:right;"><a href="#" onclick="$('#baris<?php echo $i ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td></tr>

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
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;"><?php if($this->newsession->userdata('SESS_BBPOM_ID') == '93'){?> KESIMPULAN dan TINDAK LANJUT <?php }else ?> KESIMPULAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan</h2>
                <table id="F02OT_tbhasil" class="form_tabel">
                <tr id="row_hasil" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Sertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Prasertifikasi" || $sess['TUJUAN_PEMERIKSAAN'] == "Resertifikasi") echo 'style="display:none"'; else echo 'style=""';?>><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN[HASIL]', $hasil, array_key_exists('HASIL', $sess)?$sess['HASIL']:'', 'id="F02OT_hasil" class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td></tr>
                <tr id="row_catatan" <?php if($sel_hasil == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Catatan<td class="td_right"><textarea class="stext chk" title="Catatan" name="PEMERIKSAAN_CPPKB[REKOMENDASI]"><?php echo $sess['REKOMENDASI']; ?></textarea></td></tr>
                <tr id="row_tmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Detil Hasil Pemeriksaan</td><td class="td_right"><span class="F02OT_mk" style="display:none;"></span><span class="F02OT_temuan_kos"><?php echo form_dropdown('PEMERIKSAAN_CPPKB[DETIL_HASIL][]',$detil_tmk,is_array($sel_tmk)?$sel_tmk:'','id="F02OT_detiltmk" class="stext multiselect" multiple title="Detil hasil pemeriksaan. Jika lebih dari satu tekan klik + Ctrl"'); ?></span></td></tr>
                <tr id="row_dttmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left" id="F02OT_tdlabeldetiltmk">Detil Kesimpulan TMK</td><td class="td_right" id="F02OT_tddetiltmk"><textarea name="PEMERIKSAAN_CPPKB[KESIMPULAN_DETIL_TMK]" id="KESIMPULAN_DETIL_TMK" class="stext chk" title="Detil Kesimpulan TMK"><?php echo $sess['KESIMPULAN_DETIL_TMK']; ?></textarea></td></tr>
                </table>
                
                <?php
				if($this->newsession->userdata('SESS_BBPOM_ID') == '94'){
					?>
                    <h2 class="small garis">Tindak Lanjut</h2>
                      <table class="form_tabel">
                      <tr><td class="td_left">Tindak Lanjut Hasil Inspeksi</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPPKB[TINDAK_LANJUT]',$tl_cpotb,$sess['TINDAK_LANJUT'],'class="stext" id="F01OO_tindaklanjut" rel="required" title="Tindak lanjut hasil inspeksi" onchange="sel_inspeksi($(this), \'#timeline\'); return false;"'); ?></td></tr>
                      <tr><td class="td_left">Time Line</td><td class="td_right"><textarea class="stext chk" id="timeline" name="PEMERIKSAAN_CPPKB[TIME_LINE]" title="Timeline tindak lanjut hasil inspeksi"><?php echo $sess['TIME_LINE']; ?></textarea></td></tr>
                      </table>
                      <h2 class="small">C A P A</h2>
                      <table class="form_tabel">
                      <tr><td class="td_left">Hasil Evaluasi CAPA</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_CPPKB[STATUS_CAPA]',$capa_cpotb,$sess['STATUS_CAPA'],'class="stext" id="F01OO_capa" title="Hasil evaluasi CAPA"'); ?></td></tr>
                      </table>
                    <?php
				}
				?>
                
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        
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
<div><a href="#" class="button save" onclick="fpost('#f01PK_','#div_izin',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
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
	create_ck("#KESIMPULAN_DETIL_TMK", 505);
	$("#detail_petugas").html("Loading ..."); $("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#data_temuan").html("Loading ..."); $("#data_temuan").load($("#data_temuan").attr("url"));
	$("#div_izin").html('Loading..'); $("#div_izin").load($("#div_izin").attr("url"));
	$("#div_sert").html('Loading..'); $("#div_sert").load($("#div_sert").attr("url"));
	$("#F01PK_temuan_kategori").change(function(){if($(this).val() == "TMK Penandaan"){$("#td_temuan").show();$(".tmk_penandaan").show();$(".farmasetik").hide();}else if($(this).val() == "Farmasetik"){$("#td_temuan").show();$(".tmk_penandaan").hide();$(".farmasetik").show();}else{$("#td_temuan").hide();$(".tmk_penandaan").hide();$(".farmasetik").hide();}});	  
	$("#F02OT_hasil").change(function(){val = $(this).val(); if(val == "TMK"){ $("#row_catatan").hide(); $("#row_tmk").show(); $("#row_dttmk").show(); }else{ $("#row_catatan").show(); $("#row_tmk").hide(); $("#row_dttmk").hide(); } });

	$("#F01PK_temuan_obat").autocomplete($("#F01PK_temuan_obat").attr('url'), {width: 244, selectFirst: false});
	$("#F01PK_temuan_obat").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#F01PK_temuan_noreg").val(data[2]);
			$("#F01PK_temuan_perusahaan").val(data[3]);
			$("#F01PK_temuan_alamat").val(data[5]);
			$("#flag").val('1');
		}
	});
			
	$("#F01PK_add_temuan").click(function(){
		if(!beforeSubmit("#F01PK_tbtms")){ return false;
		}else{	
			var urut = $("#F01PK_temuanbodykos tr").length;
			var kategori;
			if($("#F01PK_temuan_kategori").val() == "Farmasetik"){
				kategori = $("#F01PK_temuan_kategori option:selected").text()+'<br>'+$("#F01PK_temuan_farmasetik option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[KATEGORI][]" value="'+$("#F01PK_temuan_farmasetik").val()+'">';
			}else{
				kategori = $("#F01PK_temuan_kategori option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[KATEGORI][]" value="'+$("#F01PK_temuan_kategori").val()+'">';
			}
			var satuan;
			if($("#F01PK_satuan").val() != "Lainnya"){
				satuan = $("#F01PK_satuan option:selected").text();
			}else{
				satuan = $("#F01PK_satuan_lain").val();
			}
			var total_harga = $("#F01PK_temuan_jumlah").val() * $("#F01PK_temuan_harga").val();
			var str = '<tr id="baris'+(urut+1)+'"><td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="'+$("#F01PK_temuan_obat").val()+'">'+$("#F01PK_temuan_obat").val();
			str += '<br>Klasifikasi : '+$("#F01PK_klasifikasi_produk option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[KLASIFIKASI_PRODUK][]" value="'+$("#F01PK_klasifikasi_produk").val()+'">';
			str += '<br>No. Registrasi : '+$("#F01PK_temuan_noreg").val()+'<input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="'+$("#F01PK_temuan_noreg").val()+'">';
			str += '<br>No. Batch : '+$("#F01PK_temuan_nobatch").val()+'<input type="hidden" name="TEMUAN_PRODUK[NO_BATCH][]" value="'+$("#F01PK_temuan_nobatch").val()+'">';
			str += '<br>Tanggal Expire :'+$("#F01PK_temuan_expire").val()+'<input type="hidden" name="TEMUAN_PRODUK[TANGGAL_EXPIRE][]" value="'+$("#F01PK_temuan_expire").val()+'">';
			str += '<br>Netto : '+$("#F01PK_temuan_satuan").val()+'<input type="hidden" name="TEMUAN_PRODUK[NETTO][]" value="'+$("#F01PK_temuan_satuan").val()+'">';
			str += '<br>Jenis Satuan: '+satuan+'<input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="'+satuan+'">';
			str += '<br>Harga Satuan : '+$("#F01PK_temuan_harga").val()+'<input type="hidden" name="TEMUAN_PRODUK[HARGA_SATUAN][]" value="'+$("#F01PK_temuan_harga").val()+'">';
			str += '<br>Jumlah Temuan : '+$("#F01PK_temuan_jumlah").val()+'<input type="hidden" name="TEMUAN_PRODUK[JUMLAH_TEMUAN][]" value="'+$("#F01PK_temuan_jumlah").val()+'">';
			str += '</td><td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="'+$("#F01PK_temuan_perusahaan").val()+'">'+$("#F01PK_temuan_perusahaan").val();
			str += '<br>'+$("#F01PK_temuan_alamat").val()+'<input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="'+$("#F01PK_temuan_alamat").val()+'"></td>';
			str += '<td>'+kategori+'</td><td>'+$("#F01PK_temuan_pelanggaran").val()+'<input type="hidden" name="TEMUAN_PRODUK[JENIS_PELANGGARAN][]" value="'+$("#F01PK_temuan_pelanggaran").val()+'"><br>Tindakan : '+$("#F01PK_tindakan_produk option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[TINDAKAN_PRODUK][]" value="'+$("#F01PK_tindakan_produk").val()+'"></td><td>'+total_harga+'<input type="hidden" name="TEMUAN_PRODUK[HARGA_TOTAL][]" value="'+total_harga+'"></td><td>'+$("#F01PK_temuan_keterangan").val()+'<input type="hidden" name="TEMUAN_PRODUK[KETERANGAN_SUMBER][]" value="'+$("#F01PK_temuan_keterangan").val()+'"><input type="hidden" name="TEMUAN_PRODUK[FLAG][]" value="'+$("#flag").val()+'"><span style="float:right;"><a href="#" onclick="$(\'#baris' + (urut+1) + '\').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td></tr>';
			$("#F01PK_temuanbodykos").append(str);
			clearForm("#F01PK_tbtms");
			$("#F01PK_temuan_pelanggaran").val('-');
			$("#F01PK_satuan_lain").val('-');
			$("#F01PK_satuan_lain, #td_temuan").hide();
			$("#flag").val('0');
			return false;
		}
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
				$(".file_"+jenis+"").html('<input type=\"hidden\" name=\"PEMERIKSAAN_CPPKB[LAMPIRAN]\" value="">');
			}
		});
		return false;
	});
	
	$(".addtemuan").click(function(){ var nom = $(this).attr("terakhir"); var idtr = $(this).attr("periksa"); var cls = idtr + nom; $("#tb_temuan").append('<tr class= "' + cls + '"><td width="545px;"><div style="padding-bottom:5px;"><?php echo str_replace(chr(10), '', form_dropdown("TEMUAN[TEMUAN_OBSERVASI][]", $temuan_observasi, "", 'class="text"')); ?></div><div><textarea class="stext chk" name="TEMUAN[TEMUAN_TEKS][]" id="TEMUAN_OB'+nom+'"></textarea></div></td><td><div style="padding-bottom:5px;"><?php echo str_replace(chr(10), '', form_dropdown("TEMUAN[TEMUAN_KRITERIA][]", $cb_observasi, "", 'class="sel_penyimpangan" title="Pilih salah satu pilihan : Kritikal, Major, Minor, Observasi" hasil="" onchange="CountKriteria($(this).val());"')); ?>&nbsp;&nbsp;<a href="#" class="min" onclick="$(\'.' + cls + '\').remove(); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Klik disini untuk membatalkan atau menghapus temuan" /></a></div><div><span class="attach' +  nom + '"><input type="file" class="stext" file_ke="file_ke' +  nom + '" id="attach' +  nom + '" name="userfile" allowed="xls-xlsx-doc-docx-jpg-jpeg-rar-zip-pdf-csv-png-gif" onchange="attach_doc_tabel($(this));" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/temuan/<?php echo $sarana_id; ?>" /></span><span class="file' +  nom + '"></span><input type="hidden" name="TEMUAN[TEMUAN_FILE][]" class="hd_file' + nom + '" /></div></tr>'); $(this).attr('terakhir', parseInt(nom) + 1); create_ck("#TEMUAN_OB"+nom, 505); return false;});
	$(".del_upload").live("click", function(){ var baris_ke = $(this).attr("baris_ke"); var urut = baris_ke.substring(6,7); $.ajax({ type: "GET", url: $(this).attr("url"), data: $(this).serialize(), success: function(data){ $(".attach"+urut).show(); $(".attach"+urut).html('<input type="file" class="stext" file_ke="file_ke' +  urut + '" id="attach' +  urut + '" name="userfile" allowed="xls-xlsx-doc-docx-jpg-jpeg-rar-zip-pdf-csv-png-gif" onchange="attach_doc_tabel($(this));" url="<?php echo site_url(); ?>/utility/uploads/get_upload_tabel/temuan/<?php echo $sarana_id; ?>" />'); $(".file"+urut).hide(); $(".hd_file"+urut).val(''); }  }); return false; });
	  
});


function sel_tujuan(element){
	var val = $(element).val();
	if(val == "Sertifikasi" || val == "Prasertifikasi" || val == "Resertifikasi"){
		$(".div-sertifikat").show();
		$(".div-temuan").hide();
		$("#row_hasil").hide();
	}else{
		$(".div-sertifikat").hide();
		$(".div-temuan").show();
		$("#row_hasil").show();	  
	}
}

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
					if(jenis == "LAMPIRAN"){
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_lampiran\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_CPPKB[LAMPIRAN]\" value="+arrdata[0]+">");
					}
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
