<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f02mm_" id="f02mm_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">INFORMASI SARANA</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama PBF</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Kantor</td>
                <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                    <?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Gudang</td>
                <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                    <?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Telp.</td>
                <td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
                    <?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Nomor Izin</td>
                <td class="td_right"><?php echo array_key_exists('NOMOR_IZIN', $sess)?$sess['NOMOR_IZIN']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Izin</td>
                <td class="td_right"><?php echo array_key_exists('TANGGAL_IZIN', $sess)?$sess['TANGGAL_IZIN']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Pimpinan</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Penanggung Jawab</td>
                <td class="td_right"><?php echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">SIK</td>
                <td class="td_right"><?php echo array_key_exists('NO_SIK', $sess)?$sess['NO_SIK']:""; ?></td>
              </tr>
            </table>
            <h2 class="small">Informasi Petugas Pemeriksa</h2>
            <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Pemeriksaan</td>
                <td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" />
                  <input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />
                  &nbsp; sampai dengan &nbsp;
                  <input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN_DISTRIBUSI[TUJUAN_PEMERIKSAAN]', $tujuan_periksa, array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:'', 'id="F02MM_tujuanperiksa" class="stext" rel="required" title="Pilih salah satu tujuan pemeriksaan"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Lampiran BAP</td>
                <td class="td_right"><?php
            	if(array_key_exists('LAMPIRAN_BAP', $sess) && trim($sess['LAMPIRAN_BAP']) != ""){
              ?>
                  <span class="upload_LAMPIRAN_BAP" style="display:none;">
                  <input type="file" class="stext upload" jenis="LAMPIRAN_BAP" allowed="rar-zip" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN_BAP" title="File lampiran BAP" name="userfile" onchange="do_upload($(this)); return false;"/>
                  &nbsp;Tipe File : *.rar, *.zip</span><span class="file_LAMPIRAN_BAP"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN_BAP']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN_BAP']; ?>" jns="LAMPIRAN_BAP">Edit atau Hapus File ?</a></span>
                  <?php
            }else{
            ?>
                  <span class="upload_LAMPIRAN_BAP">
                  <input type="file" class="stext upload" jenis="LAMPIRAN_BAP" allowed="rar-zip" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN_BAP" title="File lampiran BAP" name="userfile" onchange="do_upload($(this)); return false;"/>
                  &nbsp;Tipe File : *.rar, *.zip</span><span class="file_LAMPIRAN_BAP"></span>
                  <?php
            }
            ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Pemeriksaan !-->
        
        <div id="F02MM_rutin" <?php if($sel_tujuan != "Rutin"){ echo 'style="display:none;"'; }?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Penilaian Aspek dan Detail</h2>
              <h2 class="small">1. Profil Sarana</h2>
              <table class="form_tabel" group="1. Profil Sarana">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point1suba" y="tersedia papan nama yang mencantumkan nama PBF di depan lokasi kantor dan gudang PBF" t="Tidak tersedia papan nama yang mencantumkan nama PBF di depan lokasi kantor dan gudang PBF">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia papan nama yang mencantumkan nama PBF di depan lokasi kantor dan gudang PBF?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[0]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point1subb" y="Mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBF, Farmakope Indonesia) terbaru." t="Tidak mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBF, Farmakope Indonesia) terbaru.">
                  <td class="td_no">b.&nbsp;</td>
                  <td  class="td_aspek">Apakah mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBF, Farmakope Indonesia) terbaru?</td>
                  <td  class="td_kriteria">Tingkat Kekritisan (m)</td>
                  <td class="td_kriteria"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[1]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point1subc" y="PBF menerapakan sistem mutu terkait CDOB." t="PBF tidak menerapakan sistem mutu terkait CDOB.">
                  <td class="td_no">c.&nbsp;</td>
                  <td  class="td_aspek">Apakah PBF telah menerapkan sistem mutu terkait CDOB?</td>
                  <td class="td_kriteria">Tingkat Kekritisan (M)</td>
                  <td class="td_kriteria"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[2]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">2. ORGANISASI</h2>
              <table class="form_tabel" group="2. Organisasi">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point2suba" y="Struktur organisasi mencakup kedudukan penanggung jawab" t="Struktur organisasi tidak mencakup kedudukan penanggung jawab">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah struktur organisasi mencakup kedudukan penanggung jawab?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[3]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point2subb" y="Penanggung jawab PBF sesuai dengan ketentuan perundang-undangan." t="Penanggung jawab PBF tidak sesuai dengan ketentuan perundang-undangan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah penanggung jawab sesuai dengan ketentuan peraturan perundang-undangan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[4]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point2subc" y="Penanggung jawab bekerja full time di PBF." t="Penanggung jawab tidak bekerja full time di PBF.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah penanggung jawab bekerja full time di PBF? (sebutkan jadwal kehadiran di keterangan ).</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[5]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point2subd" y="Memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan." t="Tidak memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta tidak dievaluasi efektifitasnya dan didokumentasikan.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah ada program pelatihan sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[6]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point2sube" y="Semua atau sebagian personil pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya." t="Semua atau sebagian personil tidak pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah personil pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[7]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">3. Bangunan dan Peralatan</h2>
              <table class="form_tabel" group="3. Bangunan dan Peralatan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point3suba" y="Lokasi sesuai dengan Izin PBF." t="Lokasi tidak sesuai dengan Izin PBF.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah lokasi sesuai dengan Izin PBF?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[8]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subb" y="Perubahan denah bangunan telah mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ." t="Perubahan denah bangunan tidak mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah perubahan denah bangunan telah mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[9]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subc" y="Kebersihan dan kerapian bangunan dijaga serta dipelihara." t="Kebersihan dan kerapian bangunan tidak dijaga dan tidak dipelihara.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah kebersihan dan kerapian bangunan dijaga serta dipelihara?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[10]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subd" y="Ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk." t="Ruang penyimpanan tidak dilengkapi dengan alat pencatat suhu yang terkalibrasi serta tidak dilakukan monitoring sesuai dengan persyaratan masing-masing produk.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[11]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3sube" y="Luas ruang penyimpanan dan penerangan memadai." t="Luas ruang penyimpanan dan penerangan tidak memadai.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah luas ruang penyimpanan dan penerangan memadai?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[12]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subf" y="Tersedia program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi." t="Tidak tersedia program dan peralatan pengendalian hama dan tikus (pest control)">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah ada program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[13]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subg" y="Tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai." t="Tidak tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[14]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="pointt3subh" y="Tersedia peralatan yang memadai untuk memindahkan barang." t="Tidak tersedia peralatan yang memadai untuk memindahkan barang.">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia peralatan yang memadai untuk memindahkan barang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[15]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">4. Pengadaaan</h2>
              <table class="form_tabel" group="4. Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point4suba" y="Pengadaan dari sumber yang sah." t="Terdapat pengadaan dari sumber yang tidak sah.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengadaan dari sumber yang syah?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[16]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subb" y="Dilakukan kualifikasi pemasok." t="Tidak dilakukan kualifikasi pemasok.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan kualifikasi pemasok?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[17]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subc" y="Memiliki surat pesanan (manual maupun elektronik)" t="Tidak memiliki surat pesanan (manual maupun elektronik)">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah ada surat pesanan? (manual maupun elektronik)</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[18]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subd" y="Surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas, nomor SIK dan distempel perusahaan (untuk manual) atau penanggung jawab memiliki otoritas dalam melakukan pesanan melalui elektronik." t="Surat pesanan tidak ditandatangani oleh penanggung jawab, tidak mencantumkan nama jelas, nomor SIK dan tidak distempel perusahaan (untuk manual) atau penanggung jawab tidak memiliki otoritas dalam melakukan pesanan melalui elektronik.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas dan nomor SIK dan distempel perusahaan (untuk manual) atau penanggung jawab memiliki otoritas dalam melakukan pesanan melalui elektronik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[19]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4sube" y="Surat pesanan mencantumkan nomor urut dan tidak mampu telusur baik secara manual maupun elektronik." t="Surat pesanan tidak mencantumkan nomor urut dan tidak mampu telusur baik secara manual maupun elektronik.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah surat pesanan mencantumkan nomor urut dan mampu telusur baik secara manual maupun elektronik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[20]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subf" y="Salinan surat pesanan, faktur atau surat jalan dari pemasok disatukan." t="Salinan surat pesanan, faktur atau surat jalan dari pemasok tidak disatukan.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah salinan surat pesanan, faktur atau surat jalan dari pemasok disatukan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[21]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">5. Penerimaan dan Penyimpanan</h2>
              <table class="form_tabel" group="5. Penerimaan dan Penyimpanan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point5suba" y="Penanggung jawab atau tenaga kefarmasian yang diberikan kuasa oleh penanggung jawab menandatangani faktur pengadaan atau SPB pada saat barang diterima." t="Penanggung jawab atau tenaga kefarmasian yang diberikan kuasa oleh penanggung jawab tidak menandatangani faktur pengadaan atau SPB pada saat barang diterima.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah penanggung jawab atau tenaga kefarmasian yang diberikan kuasa oleh penanggung jawab menandatangani faktur pengadaan atau SPB pada saat barang diterima? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[22]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subb" y="Setiap penerimaan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan." t="Setiap penerimaan obat tidak dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[23]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subc" y="Setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)." t="Setiap penerimaan obat tidak dicatat pada kartu stok (secara manual atau elektronik).">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[24]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subd" y="Pengisian kartu stok sesuai dengan ketentuan CDOB." t="Pengisian kartu stok tidak sesuai dengan ketentuan CDOB.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah pengisian kartu stok sesuai dengan ketentuan CDOB?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[25]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5sube" y="Mempunyai sistem yang menjamin first in and first out / first exp first out." t="Tidak mempunyai sistem yang menjamin first in and first out / first exp first out.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai sistem yang menjamin first in and first out / first exp first out ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[26]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subf" y="Semua obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?" t="Semua atau sebagian obat disimpan pada kondisi yang tidak sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[27]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subg" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[28]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subh" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik" t="Jumlah dalam kartu stok tidak sesuai dengan jumlah fisik">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[29]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">6. Penyaluran</h2>
              <table class="form_tabel" group="6. Personalia">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point6suba" y="Terdapat penyaluran obat kepada sarana yang mempunyai kewenangan sesuai dengan ketentuan peraturan perundang-undangan dan dapat dibuktikan kebenaran penyalurannya." t="Terdapat penyaluran obat kepada sarana yang mempunyai kewenangan sesuai dengan ketentuan peraturan perundang-undangan dan tidak dapat dibuktikan kebenaran penyalurannya.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah obat disalurkan kepada sarana yang mempunyai kewenangan sesuai dengan ketentuan peraturan perundang-undangan dan dapat dibuktikan kebenaran penyalurannya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[30]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subb" y="Dilakukan kualifikasi pelanggan." t="Tidak dilakukan kualifikasi pelanggan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan kualifikasi pelanggan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[31]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subc" y="Seluruh atau sebagian penyaluran obat berdasarkan surat pesanan yang ditandatangani apoteker pengelola apotek, apoteker penanggung jawab, atau tenaga teknis kefarmasian penanggung jawab untuk toko obat dengan mencantumkan nomor SIPA, SIKA, atau SIKTTK." t="Seluruh atau sebagian penyaluran obat tidak berdasarkan surat pesanan yang ditandatangani apoteker pengelola apotek, apoteker penanggung jawab, atau tenaga teknis kefarmasian penanggung jawab untuk toko obat dengan mencantumkan nomor SIPA, SIKA, atau SIKTTK.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penyaluran obat berdasarkan surat pesanan yang ditandatangani apoteker pengelola apotek, apoteker penanggung jawab, atau tenaga teknis kefarmasian penanggung jawab untuk toko obat dengan mencantumkan nomor SIPA, SIKA, atau SIKTTK?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[32]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subd" y="Dilakukan skrining oleh penanggung jawab terhadap pesanan yang diterima untuk dapat dilayani berdasarkan analisis risiko" t="Tidak dilakukan skrining oleh penanggung jawab terhadap pesanan yang diterima untuk dapat dilayani berdasarkan analisis risiko">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan skrining oleh penanggung jawab terhadap pesanan yang diterima untuk dapat dilayani berdasarkan analisis risiko?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[33]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subc" y="Semua atau sebagian obat yang dikirimkan dilakukan pengontrolan dan tidak disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta tidak ditandatangani oleh Penanggung Jawab." t="Semua atau sebagian obat yang dikirimkan tidak dilakukan pengontrolan dan tidak disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta tidak ditandatangani oleh Penanggung Jawab.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang dikirimkan dilakukan pengontrolan dan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[34]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subd" y="Dokumen penyaluran yang meliputi surat pesanan dari pelanggan, faktur atau SPB disatukan dan tidak mampu telusur." t="Dokumen penyaluran yang meliputi surat pesanan dari pelanggan, faktur atau SPB tidak disatukan dan tidak mampu telusur.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah dokumen penyaluran yang meliputi surat pesanan dari pelanggan, faktur atau SPB disatukan dan mampu telusur?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[35]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subg" y="Pengiriman yang menggunakan pihak ketiga (jasa pengiriman) berdasarkan kontrak." t="Pengiriman yang menggunakan pihak ketiga (jasa pengiriman) tidak berdasarkan kontrak.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah pengiriman yang menggunakan pihak ketiga (jasa pengiriman) berdasarkan kontrak?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[36]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subh" y="Semua atau sebagian tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), tidak diberi tanda tangan, nama terang dan No. SIKA/SIPA/SIKTTK Penanggung Jawab sarana/petugas teknis kefarmasian." t="Semua atau sebagian tanda terima faktur atau surat penyerahan barang tidak dibubuhi stempel sarana penerima (sesuai surat pesanan), tidak diberi tanda tangan, nama terang dan No. SIKA/SIPA/SIKTTK Penanggung Jawab sarana/petugas teknis kefarmasian.">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah semua tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIKA/SIPA/SIKTTK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[37]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subi" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar." t="Terdapat obat yang tidak disalurkan adalah obat-obat yang terdaftar.">
                  <td class="td_no">i.&nbsp;</td>
                  <td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[38]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">7. Penarikan Kembali Obat (recall)</h2>
              <table class="form_tabel" group="7. Penarikan Kembali Obat (recall)">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point7suba" y="Recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas" t="Recall tidak dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[39]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point7subb" y="Sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas." t="Sistem dokumentasi tidak mendukung pelaksanaan recall secara efektif, cepat dan tuntas.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[40]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point7subc" y="Produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang." t="Produk recall tidak dicatat dalam Buku Penerimaan Pengembalian Barang, tidak diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[41]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point7subd" y="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM." t="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran tidak dilaporkan kepada Badan POM.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[42]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">8. Penanganan Produk Ilegal</h2>
              <table class="form_tabel" group="8. Penanganan Produk Ilegal">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point8suba" y="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk dijual." t="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat tidak diamankan terpisah dari obat lain, tidak terkunci dan tidak diberi penandaan tidak untuk dijual.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk dijual? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[43]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point8subb" y="PBF menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu." t="PBF tidak menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah PBF menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[44]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">9. Penanganan Produk Kembalian dan Kadaluarsa</h2>
              <table class="form_tabel" group="9. Penanganan Produk Kembalian dan Kadaluarsa">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point9suba" y="Ada persyaratan untuk obat kembalian yang dapat diterima." t="Tidak ada persyaratan untuk obat kembalian yang dapat diterima.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah ada persyaratan untuk obat kembalian yang dapat diterima?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[45]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point9subb" y="Jumlah dan identitas obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian." t="Jumlah dan identitas obat yang dikembalikan tidak sesuai dengan bukti penyaluran dan pengembalian.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dan identitas obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[46]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point9subc" y="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci." t="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan tidak dikarantina dan terkunci">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[47]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">10. Pengembalian Obat Ke Sumber Ke Pengadaaan</h2>
              <table class="form_tabel" group="10. Pengembalian Obat Ke Sumber Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point10suba" y="Pengembalian obat kepada pemasok menggunakan Surat Penyerahan Barang dan tidak didokumentasikan." t="Pengembalian obat kepada pemasok tidak menggunakan Surat Penyerahan Barang dan tidak didokumentasikan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengembalian obat kepada pemasok menggunakan Surat Penyerahan Barang dan didokumentasikan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[48]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">11. Pemusnahan</h2>
              <table class="form_tabel" group="11. Pemusnahan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point11suba" y="Dilakukan pemusnahan atau pengembalian ke pemasok untuk obat yang rusak, kedaluwarsa atau tidak layak jual." t="Tidak dilakukan pemusnahan atau pengembalian ke pemasok untuk obat yang rusak, kedaluwarsa atau tidak layak jual.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pemusnahan atau pengembalian ke pemasok untuk obat yang rusak, kedaluwarsa atau tidak layak jual?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[49]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point11subb" y="Pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi." t="Pelaksanaan pemusnahan tidak dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[50]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">12. Inspeksi Diri</h2>
              <table class="form_tabel" group="12. Inspeksi Diri">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point12suba" y="Terdapat Tim Inspeksi Diri yang ditunjuk oleh pimpinan distributor." t="Tidak terdapat Tim Inspeksi Diri yang ditunjuk oleh pimpinan distributor.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah terdapat Tim Inspeksi Diri yang ditunjuk oleh pimpinan distributor ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[51]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point12subb" y="Catatan mengenai pelaksanaan inspeksi diri terdokumentasi dan dilaporkan kepada pimpinan." t="Catatan mengenai pelaksanaan inspeksi diri tidak terdokumentasi dan tidak dilaporkan kepada pimpinan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td  class="td_aspek">Apakah catatan mengenai pelaksanaan inspeksi diri terdokumentasi dan dilaporkan kepada pimpinan ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[52]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point12subc" y="Terdapat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal." t="Tidak terdapat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah dibuat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[53]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point12subd" y="Dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan." t="Tidak dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan.">
                  <td class="td_no">d.&nbsp;</td>
                  <td  class="td_aspek">Apakah dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[54]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">13. Lain - Lain</h2>
              <table class="form_tabel" group="13. Lain - Lain">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point13" y="Dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM)." t="Tidak dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM).">
                  <td class="td_no">&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM)?</td>
                  <td class="td_kriteria">Tingkat Kekritisan (M)</td>
                  <td class="td_kriteria"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[55]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                  </tr>
                
              </table>
              <h2 class="small">14. Penyluar Vaksin / Cold Chain Product</h2>
              <h2 class="small">Personalia</h2>
              <table class="form_tabel" group="Personali">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14suba" y="Petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya dan tidak terdokumentasi." t="Petugas yang menangani vaksin/CCP tidak mendapatkan pelatihan sesuai tanggung jawabnya dan tidak terdokumentasi.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya dan terdokumentasi?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[56]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">Bangunan dan Tempat Penyimpanan Vaksin / CCP</h2>
              <table class="form_tabel" group="Bangunan dan Tempat Penyimpanan Vaksin / CCP">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                  </tr>
                
                <tr id="point14subsuba" y="Tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk." t="Tidak tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk?(minimal chiller)</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[57]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point14subsubb" y="Dilakukan kualifikasi  terhadap tempat penyimpanan khusus untuk vaksin/CCP bila terjadi perubahan kondisi atau dilakukan kualifikasi kinerja pada kondisi operasional minimal  satu tahun sekali atau berdasarkan analisis risiko." t="Tidak dilakukan kualifikasi  terhadap tempat penyimpanan khusus untuk vaksin/CCP bila terjadi perubahan kondisi atau dilakukan kualifikasi kinerja pada kondisi operasional minimal  satu tahun sekali atau berdasarkan analisis risiko.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan kualifikasi  terhadap tempat penyimpanan khusus untuk vaksin/CCP bila terjadi perubahan kondisi atau dilakukan kualifikasi kinerja pada kondisi operasional minimal  satu tahun sekali atau berdasarkan analisis risiko?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[58]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point14subsubc" y="Dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya." t="Tidak dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[59]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="pointsubsubd" y="Tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)" t="Tempat penyimpanan tidak dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)?">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[60]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point14subsube" y="Tempat penyimpanan dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan." t="Tempat penyimpanan tidak dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[61]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point14subsubg" y="Mempunyai generator otomatis yang berfungsi dengan baik atau mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam." t="Tidak mempunyai generator otomatis yang berfungsi dengan baik atau tidak mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai generator otomatis yang berfungsi dengan baik? Atau Apakah mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[62]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="pointsubsubh"  y="Terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan)." t="Tidak terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan).">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[63]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">Penyaluran Vaksin / CCP</h2>
              <table class="form_tabel" group="Penyaluran Vaksi / CCP">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14subseria" y="Penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga dapat menjaga suhu selama pengiriman" t="Penyaluran vaksin/CCP tidak menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga dapat menjaga suhu selama pengiriman">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga dapat menjaga suhu selama pengiriman?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[64]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
              <table id="form_tabel">
                <tr>
                  <td class="td_left">&nbsp;</td>
                  <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[HASIL_TEMUAN_LAIN]" title="Hasil temuan lainnya yang tidak tercantum dalam aspek penilaian"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?$sess['HASIL_TEMUAN_LAIN']:'';?></textarea></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- Akhir Penilaian !--> 
        </div>
        <div id="F02MM_kasus" <?php if($sel_tujuan != "Kasus"){ echo 'style="display:none;"'; }?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KASUS</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">FORM KASUS</h2>
              <h2 class="small">A. PROFIL SARANA DAN ORGANISASI</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_A]" id="F02MM_kasus_pointa" title="Profil sarana dan organisasi"><?php echo array_key_exists('KASUS_POINT_A', $sess)?$sess['KASUS_POINT_A']:'';?></textarea>
              <h2 class="small">B. PERSONALIA</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_B]" id="F02MM_kasus_pointb" title="Personalia"><?php echo array_key_exists('KASUS_POINT_B', $sess)?$sess['KASUS_POINT_B']:'';?></textarea>
              <h2 class="small">C. GUDANG DAN PERLENGKAPAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_C]" id="F02MM_kasus_pointc" title="Gudang dan Perlengkapak"><?php echo array_key_exists('KASUS_POINT_C', $sess)?$sess['KASUS_POINT_C']:'';?></textarea>
              <h2 class="small">D. PENGADAAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_D]" id="F02MM_kasus_pointd" title="Pengadaan"><?php echo array_key_exists('KASUS_POINT_D', $sess)?$sess['KASUS_POINT_D']:'';?></textarea>
              <h2 class="small">E. PENYIMPANAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_E]" id="F02MM_kasus_pointe" title="Penyimpanan"><?php echo array_key_exists('KASUS_POINT_E', $sess)?$sess['KASUS_POINT_E']:'';?></textarea>
              <h2 class="small">F. PENDISTRIBUSIAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_F]" id="F02MM_kasus_pointf" title="Pendistribusian"><?php echo array_key_exists('KASUS_POINT_F', $sess)?$sess['KASUS_POINT_F']:'';?></textarea>
              <h2 class="small">G. DOKUMENTASI</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_G]" id="F02MM_kasus_pointg" title="Dokumentasi"><?php echo array_key_exists('KASUS_POINT_G', $sess)?$sess['KASUS_POINT_G']:'';?></textarea>
              <h2 class="small">H. LAIN-LAIN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_H]" id="F02MM_kasus_pointh" title="Lain - Lain"><?php echo array_key_exists('KASUS_POINT_H', $sess)?$sess['KASUS_POINT_H']:'';?></textarea>
            </div>
          </div>
          <!-- Akhir Kasus!--> 
        </div>
        <div id="F02MM_temuan_produk" <?php echo $sel_tujuan == "Mapping" ? 'style="display:none;"' : ''; ?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <input type="hidden" value="0" id="flag">
              <table id="tb_temuan" class="form_temuan">
                <tr>
                  <td class="temuan_left">Nama Produk</td>
                  <td class="temuan_right"><input type="text" class="stext" id="nm_produk" title="Nama Produk" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/1" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Kategori</td>
                  <td class="temuan_right"><?php echo form_dropdown('kategori',$kategori_temuan,'','class="stext multiselect" id="kategori" multiple title="Kategori Temuan. Jika lebih dari satu, Klik + Ctrl untuk memilih"'); ?></td>
                </tr>
                <tr>
                  <td class="temuan_left">Pabrik</td>
                  <td class="temuan_right"><input type="text" class="stext" id="pabrik" title="Pabrik pembuat produk" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Negara Asal</td>
                  <td class="temuan_right"><input type="text" class="stext" id="asl" title="Asal Negara Produk" url="<?php echo site_url(); ?>/autocompletes/autocomplete/negara"/></td>
                </tr>
                <tr>
                  <td class="temuan_left">Kemasan</td>
                  <td class="temuan_right"><input type="text" class="stext" id="kemasan" title="Kemasan Produk" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">NIE</td>
                  <td class="temuan_right"><input type="text" class="stext" id="nie" title="Nomor Izin Edar Produk" /></td>
                </tr>
                <tr>
                  <td class="temuan_left">No. Lot/Bets</td>
                  <td class="temuan_right"><input type="text" class="stext" id="bets" title="No. Lot / Bets Produk" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Tanggal Expire</td>
                  <td class="temuan_right"><input type="text" class="sdate" id="tglexp" title="Tanggal Expire Produk" />
                    &nbsp;<small>Jika kosong, isi dengan tanda - (strip)</small></td>
                </tr>
                <tr>
                  <td class="temuan_left">Jumlah</td>
                  <td class="temuan_right"><input type="text" class="sdate" id="jumlah" title="Jumlah Temuan Produk" onkeyup="numericOnly($(this))" />
                    &nbsp;<?php echo form_dropdown('satuan',$kemasan,'','class="sel_penyimpangan" title="Kemasan" id="satuan"'); ?></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Tindakan Terhadap Produk</td>
                  <td class="temuan_right"><?php echo form_dropdown('tproduk',$tindakan_produk,'','class="stext multiselect" multiple title="Tindakan Terhadap Produk. Jika lebih dari satu, Klik + Ctrl untuk memilih" id="tproduk"'); ?></td>
                </tr>
                <tr>
                  <td class="temuan_left">Nama Sarana</td>
                  <td class="temuan_right"><input type="text" class="stext" id="nmsarana" title="Nama Sarana" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Alamat Sarana</td>
                  <td class="temuan_right"><textarea class="stext" id="alsarana" title="Alamat Sarana"></textarea></td>
                </tr>
                <tr>
                  <td class="temuan_left">Pemilik</td>
                  <td class="temuan_right"><input type="text" class="stext" id="pemilik" title="Pemilik Sarana" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Keterangan</td>
                  <td class="temuan_right"><textarea class="stext" id="keterangan" title="Keterangan"></textarea></td>
                </tr>
                <tr>
                  <td class="temuan_left">Harga Satuan</td>
                  <td class="temuan_right"><input type="text" class="sdate" id="harga" title="Harga Satuan" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">&nbsp;</td>
                  <td class="temuan_right">&nbsp;</td>
                </tr>
              </table>
              <div class="btn"><span><a href="#" onclick="add_temuan(); return false;">Tambah Temuan</a></span></div>
              <div style="height:5px;"></div>
              <table width="100%" id="tb_distribusi" cellpadding="0" cellspacing="0" class="listtemuan">
                <thead>
                  <tr>
                    <th>Detil Produk</th>
                    <th>Detil Perusahaan</th>
                    <th>Temuan</th>
                    <th>Tindakan</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody id="tbody_distribusi">
                  <?php
                      if(!$temuan_produk==''){
                          if($sess['JUMLAH_TEMUAN'] != 0){
                              for($i=0; $i<count($temuan_produk); $i++){
                                  ?>
                  <tr id="baris'<?php echo $i; ?>'">
                    <td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="<?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?>">
                      Nama Produk : <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>
                      Nama Pabrik : <?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[NAMA_PABRIK][]" value="<?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?>">
                      <br>
                      Negara Asal : <?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[NEGARA_ASAL][]" value="<?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?>">
                      <br>
                      Kemasan : <?php echo $temuan_produk[$i]['KEMASAN']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="<?php echo $temuan_produk[$i]['KEMASAN']; ?>">
                      <br>
                      NIE : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="<?php echo $temuan_produk[$i]['NIE']; ?>">
                      <br>
                      No. Lot / Bets : <?php echo $temuan_produk[$i]['NO_BATCH']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[NO_BATCH][]" value="<?php echo $temuan_produk[$i]['NO_BATCH']; ?>">
                      <br>
                      Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[TANGGAL_EXPIRE][]" value="<?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?>"></td>
                    <td>Produsen : <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="<?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?>">
                      <br>
                      Pendaftar  : <?php echo $temuan_produk[$i]['PEMILIK']; ?><br>
                      Alamat : <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="<?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?>">
                      <input type="hidden" name="TEMUAN_PRODUK[PEMILIK][]" value="<?php echo $temuan_produk[$i]['PEMILIK']; ?>"></td>
                    <td>Kategori Temuan : <?php echo $temuan_produk[$i]['KATEGORI']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[KATEGORI][]" value="<?php echo $temuan_produk[$i]['KATEGORI']; ?>">
                      <br>
                      Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[JUMLAH_TEMUAN][]" value="<?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>"></td>
                    <td><?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[TINDAKAN_PRODUK][]" value="<?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?>"></td>
                    <td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[KETERANGAN_SUMBER][]" value="<?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?>">
                      &nbsp;<span style="float:right;"><a href="#" onclick="$('#baris<?php echo $i ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td>
                  </tr>
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
          </div>
        </div>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">HASIL PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Hasil Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Hasil Kesimpulan</td>
                <td class="right"><?php echo form_dropdown($this->newsession->userdata('SESS_BBPOM_ID') == '92' ?  'PEMERIKSAAN[HASIL_PUSAT]' : 'PEMERIKSAAN[HASIL]',$hasil, $this->newsession->userdata('SESS_BBPOM_ID') == '92' ?  $sess['HASIL_PUSAT'] : $sess['HASIL'], 'id="hasil" onChange="setHasil($(this), \'tr#td_pelanggaran\', \'tr#td_hasil\');" class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td>
              </tr>
              <tr id="td_pelanggaran">
                <td class="td_left">Kesimpulan Detil Pelanggaran</td>
                <td class="right">m&nbsp;
                  <input type="text" class="scode" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_MINOR]" id="F02MM_jumlahminor" readonly value="<?php echo array_key_exists('MINOR', $sess)?$sess['MINOR']:''; ?>" title="Jumlah Minor" />
                  &nbsp;&nbsp;M&nbsp;
                  <input type="text" class="scode" id="F02MM_jumlahmajor" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_MAJOR]" readonly  value="<?php echo array_key_exists('MAJOR', $sess)?$sess['MAJOR']:''; ?>" title="Jumlah Major" />
                  &nbsp;&nbsp;C&nbsp;
                  <input type="text" class="scode" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_CRITICAL]" id="F02MM_jumlahcritical" readonly value="<?php echo array_key_exists('CRITICAL', $sess)?$sess['CRITICAL']:''; ?>" title="Jumlah Kritikal" />
                  &nbsp;&nbsp;Ca&nbsp;
                  <input type="text" class="scode" id="F02MM_jumlahca" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_CRITICAL_ABSOLUTE]" readonly value="<?php echo array_key_exists('CRITICAL_ABSOLUT', $sess)?$sess['CRITICAL_ABSOLUT']:''; ?>" title="Jumlah Kritikal Absolut" /></td>
              </tr>
              <tr id="td_hasil">
                <td class="td_left">Hasil Temuan</td>
                <td class="right"><textarea id="F02MM_catatan" name="PEMERIKSAAN_DISTRIBUSI[HASIL_TEMUAN]" class="stext catatan" title="Hasil Temuan"><?php echo array_key_exists('HASIL_TEMUAN', $sess)?$sess['HASIL_TEMUAN']:'';?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Catatan Hasil Pemeriksaan</td>
                <td class="right"><textarea name="PEMERIKSAAN_DISTRIBUSI[CATATAN_HASIL_PEMERIKSAAN]" class="stext catatan" title="Catatan Hasil Pemeriksaan"><?php echo array_key_exists('CATATAN_HASIL_PEMERIKSAAN', $sess)?$sess['CATATAN_HASIL_PEMERIKSAAN']:'';?></textarea></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Hasil !-->
        <div id="F02MM_TL" <?php echo $sel_tujuan == "Mapping" ? 'style="display:none;"' : ''; ?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <?php if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){ ?>
              <h2 class="small garis">Tindak Lanjut</h2>
              <table class="form_tabel">
                <tr id="td_tlbalai">
                  <td class="td_left">Saran Tindak Lanjut</td>
                  <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[TINDAK_LANJUT_BALAI][]', $cb_tindakan, is_array($tindak_lanjut_balai)?$tindak_lanjut_balai:'', 'id="tl_balai" class="stext multiselect" style="height:95px;" multiple title="Saran Tindak Lanjut Balai. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td>
                </tr>
                <tr class="1" urut="1">
                  <td class="td_left">Detil Tindak Lanjut</td>
                  <td class="td_right"><textarea name="PEMERIKSAAN_DISTRIBUSI[DETAIL_TINDAK_LANJUT_BALAI]" class="stext chk" title="Detail Saran Tindak Lanjut Balai"><?php echo $sess['DETAIL_TINDAK_LANJUT_BALAI']; ?></textarea></td>
                </tr>
              </table>
              <?php }else if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){ ?>
              <h2 class="small garis">Tindak Lanjut</h2>
              <table class="form_tabel">
                <tr id="td_tlpusat">
                  <td class="td_left">Tindak Lanjut</td>
                  <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[TINDAK_LANJUT_PUSAT][]', $cb_tindakan, is_array($tindak_lanjut_pusat)?$tindak_lanjut_pusat:'', 'id="tl_pusat" class="stext multiselect" style="height:95px;"  multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td>
                </tr>
                <tr class="1" urut="1">
                  <td class="td_left">Detil Tindak Lanjut</td>
                  <td class="td_right"><textarea name="PEMERIKSAAN_DISTRIBUSI[DETIL_TINDAK_LANJUT_PUSAT]" class="stext chk" title="Detail Saran Tindak Lanjut Pusat"><?php echo  $sess['DETIL_TINDAK_LANJUT_PUSAT']; ?></textarea></td>
                </tr>
              </table>
              <?php
        }
        ?>
            </div>
          </div>
        </div>
        <?php
    if(!array_key_exists('PERIKSA_ID', $sess)){
    ?>
        <div id="F02MM_kk_lain">
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN KLASIFIKASI KOMODITI LAIN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Temuan Klasifikasi Komoditi Lain</h2>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Jenis Temuan</td>
                  <td class="td_right"><?php echo form_dropdown('cb_konfirm', $this->config->item('konfirmasi'), '', 'id="cb_konfirm" class="stext" title="Pilih salah satu jenis temuan" onchange="sel_konfirmasi($(this));"'); ?></td>
                </tr>
                <tr id="tr_jenis_sarana" style="display:none;">
                  <td class="td_left">Jenis Sarana</td>
                  <td class="td_right"><?php echo form_dropdown('jns', $jenis_sarana, '', 'id="jns" class="stext" url="'.site_url().'/get/pemeriksaan/set_klasifikasi_sarana/" onchange="get_klasifikasi($(this));" title="Pilih salah satu jenis sarana"', $disinput); ?></td>
                </tr>
                <tr id="tr_jenis_klasifikasi" style="display:none;">
                  <td class="td_left">Jenis Klasifikasi</td>
                  <td class="td_right"><?php echo form_dropdown('kk', $klasifikasi_kategori, '', 'id="kk" class="stext" title="Pilih salah satu jenis klasifikasi"'); ?></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- Akhir Temuan Pemeriksaan !--> 
        </div>
        <?php
    }
    if($stat=="20102" || $stat=="20103" || $stat=="20113" || $stat=="20112" || $stat=="60020"){ ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Verifikasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Proses Pemeriksaan</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[STATUS]',$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td>
              </tr>
            </table>
            <div style="padding-top:5px;">
              <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan</a></h2>
              <div id="detail_log"></div>
            </div>
          </div>
        </div>
        <!-- Akhir Verifikasi !-->
        <?php
    }
    ?>
      </div>
    </div>
    <div id="clear_fix"></div>
    <div><a href="#" class="button save" onclick="fpost('#f02mm_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a>&nbsp;<a href="#" class="button download" url="<?php echo site_url(); ?>/post/pemeriksaan/set_preview_distribusi/" onclick="prev_checklist($(this), '#f02mm_'); return false;"><span><span class="icon"></span>&nbsp; Preview Hasil Temuan &nbsp;</span></a></div>
    <div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
  </form>
</div>
<div class="prev"></div>
<script type="text/javascript">
$(document).ready(function(){
  create_ck("textarea.chk", 505);
  $("#nm_produk").autocomplete($("#nm_produk").attr('url'), {width: 244, selectFirst: false});
  $("#nm_produk").result(function(event, data, formatted){
    if(data){
      $(this).val(data[1]);
      $("#nie").val(data[2]);
      $("#nmsarana").val(data[3]);
      $("#kemasan").val(data[4]);
      $("#alsarana").val(data[5]);
      $("#pemilik").val(data[6]);
      $("#pabrik").val(data[7]);
      $("#asl").val(data[8]);
      $("#flag").val('1');
    }
  });
  $("#detail_petugas").html("Loading ...");
  $("#detail_petugas").load($("#detail_petugas").attr("url"));
  $("#F02MM_tujuanperiksa").change(function(){
    var val = $(this).val();
    if(val == "Rutin"){
      $("#hasil").html('<option value="" selected="selected"></option><option value="MK">Hasil Memenuhi Ketentuan</option><option value="TMK">Tidak Memenuhi Ketentuan</option><option value="TDP">Tidak Dapat Di Periksa</option><option value="TTP">Tutup</option>');
      $("#tr-mapping").hide();
      $("#F02MM_rutin").show();
      $("#F02MM_kasus").hide();
      $("#F02MM_TL").show();
      $("#F02MM_kk_lain").show();
      $("#F02MM_temuan_produk").show();
      $("#fileToUpload_LAMPIRAN_MAPPING").removeAttr("rel");
      $("#td_pelanggaran").show();
      $("#td_hasil").show();
	  $("#hasil").removeAttr("readonly");
      <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){ ?>
      $("#tl_pusat").attr("rel","required");
        <?php }else{ ?>
      $("#tl_balai").attr("rel","required");
      <?php } ?>
    }else if(val == "Kasus"){     
      $("#hasil").html('<option value="" selected="selected"></option><option value="MK">Hasil Memenuhi Ketentuan</option><option value="TMK">Tidak Memenuhi Ketentuan</option><option value="TDP">Tidak Dapat Di Periksa</option><option value="TTP">Tutup</option>');
      $("#tr-mapping").hide();
      $("#F02MM_rutin").hide();
      $("#F02MM_kasus").show();
      $("#F02MM_TL").show();
      $("#F02MM_kk_lain").show();
      $("#F02MM_temuan_produk").show();
      $("#fileToUpload_LAMPIRAN_MAPPING").removeAttr("rel");
      $("#td_pelanggaran").hide();
      $("#td_hasil").hide();
	  $("#hasil").removeAttr("readonly");
      <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){ ?>
      $("#tl_pusat").attr("rel","required");
        <?php }else{ ?>
      $("#tl_balai").attr("rel","required");
      <?php } ?>
    }else if(val == "Mapping"){
      $("#hasil").html('<option value="MK" selected="selected">Hasil Memenuhi Ketentuan</option>');
      $("#tr-mapping").show();
      $("#F02MM_rutin").hide();
      $("#F02MM_kasus").hide();
      $("#F02MM_TL").hide();
      $("#F02MM_kk_lain").hide();
      $("#F02MM_temuan_produk").hide();
      $("#fileToUpload_LAMPIRAN_MAPPING").attr("rel","required");
      $("#td_pelanggaran").hide();
      $("#td_hasil").hide();
      <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){ ?>
      $("#tl_pusat").removeAttr("rel");
        <?php }else{ ?>
      $("#tl_balai").removeAttr("rel");
      <?php } ?>
    }
  });
  
  <?php
  if($sess['PERIKSA_ID'] == ""){
    ?>
    var m = 0; var M = 0; var C = 0; var Ca = 0; var temuan = new Array(); $("#F02MM_kasus").css("style:display","none");
    <?php
  }else{
    ?>
    var m = <?php echo $sess['MINOR']; ?>;
    var M = <?php echo $sess['MAJOR']; ?>;
    var C = <?php echo $sess['CRITICAL']; ?>;
    var Ca = <?php echo $sess['CRITICAL_ABSOLUT']; ?>;    
    var hasil_temuan = "<?php echo $sess['HASIL_TEMUAN']; ?>";
    var temuan = new Array();
    temuan = hasil_temuan.split("___");
    <?php   
    if($sess['TUJUAN_PEMERIKSAAN'] == "Kasus"){
      ?>
      $("#F02MM_rutin").css("style:display","none");
      $("#F02MM_kasus").show();
      <?php
    }else if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin"){
      ?>
      $("#F02MM_rutin").show();
      $("#F02MM_kasus").css("style:display","none");
      <?php
    }
  }
  ?>
  $("select.sel_penyimpangan").change(function() {
    var val = $(this).val();
    var tb = $(this).closest("table").attr("id");
    var group_table = $(this).closest("table").attr("group");
    var row = $(this).closest("table tr").attr("id");
    var point = $("#" + row + " td:nth-child(1)").text();
    var tidak = $(this).closest("table tr").attr("t");
    var tingkat = $(this).attr("tingkat");
    if (tingkat == "m") {
        if (val == "T") {
            m++;
        } else if (val == "Y") {
            if (TingkatKritis(temuan, tidak)) {
                m--;
            }
        } else if (val == "N") {
            if (TingkatKritis(temuan, tidak)) {
                m--;
            }
        }
        if (m < 0) return m = 0;
    } else if (tingkat == "M") {
        if (val == "T") {
            M++;
        } else if (val == "Y") {
            if (TingkatKritis(temuan, tidak)) {
                M--;
            }
        } else if (val == "N") {
            if (TingkatKritis(temuan, tidak)) {
                M--;
            }
        }
        if (M < 0) return M = 0;
    } else if (tingkat == "C") {
        if (val == "T") {
            C++;
        } else if (val == "Y") {
            if (TingkatKritis(temuan, tidak)) {
                C--;
            }
        } else if (val == "N") {
            if (TingkatKritis(temuan, tidak)) {
                C--;
            }
        }
        if (C < 0) return C = 0;
    } else if (tingkat == "Ca") {
        if (val == "T") {
            Ca++;
        } else if (val == "Y") {
            if (TingkatKritis(temuan, tidak)) {
                Ca--;
            }
        } else if (val == "N") {
            if (TingkatKritis(temuan, tidak)) {
                Ca--;
            }
        }
        if (Ca < 0) return Ca = 0;
    }
    if (val == "T") {
        temuan.push(tidak);
    } else if (val == "Y" || val == "N") {
        ArrExist(temuan, tidak);
    }
    $("#F02MM_jumlahminor").val(parseInt(m));
    $("#F02MM_jumlahmajor").val(parseInt(M));
    $("#F02MM_jumlahcritical").val(parseInt(C));
    $("#F02MM_jumlahca").val(parseInt(Ca));
    $("#F02MM_catatan").val(temuan.join("___"));
	if(parseInt(m) > 0 && parseInt(M) == 0 && parseInt(C) == 0 && parseInt(Ca) == 0)
	{
		$("#hasil").val("MK");
		$("#hasil").attr("readonly", true);
	}
	else if(parseInt(m) > 0 || parseInt(M) > 0 || parseInt(C) > 0 || parseInt(Ca) > 0)
	{
		$("#hasil").val("TMK");
		$("#hasil").attr("readonly", true);
	}
	else if(parseInt(m) == 0 && parseInt(M) == 0 && parseInt(C) == 0 && parseInt(Ca) == 0)
	{
		$("#hasil").val("");
		$("#hasil").removeAttr("readonly");
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
      }
    });
    return false;
  });
});

function setHasil(elHasil, tdPelanggaran, tdHasil){
  var val = $(elHasil).val();
  if(val == "TMK"){
    $(tdPelanggaran).show();
    $(tdHasil).show();
    <?php
    if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){
      ?>
      $("#tl_pusat").attr("rel","required");
      $("tr#td_tlbalai,tr#td_tlpusat").show();
      <?php
    }else{
      ?>
      $("#tl_balai").attr("rel","required");
      $("tr#td_tlbalai").show();
      <?php
    }
    ?>
  }else{
    $(tdPelanggaran).hide();
    $(tdHasil).hide();
    <?php
    if($this->newsession->userdata('SESS_BBPOM_ID') == "92"){
      ?>
      $("#tl_pusat").removeAttr("rel","required");
      $("tr#td_tlbalai,tr#td_tlpusat").hide();
      <?php
    }else{
      ?>
      $("#tl_balai").removeAttr("rel","required");
      $("tr#td_tlbalai").hide();
      <?php
    }
    ?>
    $("#F02MM_jumlahminor, #F02MM_jumlahmajor, #F02MM_jumlahcritical, #F02MM_jumlahca, #F02MM_catatan").val(''); 
    $("#F02MM_rutin select.sel_penyimpangan").get(0).selectedIndex = 0;
    temuan = Array();
  }
  return false;
}

function do_upload(element){
  var jenis = $(element).attr("jenis");
  var allowed = $(element).attr("allowed");
  $.ajaxFileUpload({
    url: $(element).attr("url")+'/'+jenis+'/'+allowed,
    secureuri: false,
    fileElementId: $(element).attr("id"),
    dataType: "json",
    success: function(data){
      var arrdata = data.msg.split("#");
      if(typeof(data.error) != "undefined"){
        if(data.error != ""){
          jAlert(data.error, "SIPT Versi 1.0 ");
        }else{
          $(".upload_"+arrdata[2]+"").hide();
          $("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
          $(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_DISTRIBUSI["+arrdata[2]+"]\" value="+arrdata[0]+">");
        }
      }
    },
    error: function (data, status, e){
      jAlert(e, "SIPT Versi 1.0 Beta");
    }
  });
}

</script> 
