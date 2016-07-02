<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f02ll_" id="f02ll_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">INFORMASI SARANA</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama PBBBF</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td>
              </tr>
              <tr>
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
            <h2 class="small">Informasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Pemeriksaan</td>
                <td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:''; ?></td>
              <tr id="tr-mapping" <?php echo $sess['TUJUAN_PEMERIKSAAN'] == "Mapping" ? '' : 'style="display:none;"'; ?>>
                <td class="td_left">Lampiran File Mapping</td>
                <td class="td_right"><?php if(trim($sess['LAMPIRAN_MAPPING']) != ""){?>
                  <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN_MAPPING']; ?>">View</a>
                  <?php } ?></td>
              </tr>
              <?php
						if($sess['TUJUAN_PEMERIKSAAN'] == "Mapping" && $sess['CREATE_BY'] == $this->newsession->userdata('SESS_USER_ID')){
							?>
              <tr>
                <td class="td_left" colspan="2"><b>Jika file lampiran mapping tidak bisa didownload atau gagal upload, silahkan klik <a href="javascript:void(0);" class="reupload" url="<?php echo site_url(); ?>/get/pemeriksaan/reupload_mapping/<?php echo $sess['PERIKSA_ID']; ?>/<?php echo $sess['JENIS_SARANA_ID']; ?>">disini</a> untuk melakukan upload ulang</b></td>
              </tr>
              <?php
						}
						?>
            </table>
            <h2 class="small">Informasi Petugas Pemeriksa</h2>
            <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
          </div>
        </div>
        <!-- Akhir Pemeriksaan !-->
        
        <div id="F02LL_rutin" <?php if($sess['TUJUAN_PEMERIKSAAN'] != "Rutin"){ echo 'style="display:none;"'; }?>>
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
                <tr id="point1suba" y="Tersedia papan nama yang mencantumkan nama PBF di depan lokasi kantor dan gudang PBF" t="Tidak tersedia papan nama yang mencantumkan nama PBF di depan lokasi kantor dan gudang PBF">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia papan nama yang mencantumkan nama PBF di depan lokasi kantor dan gudang PBF?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td>
                </tr>
                <tr id="point1subb" y="Mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBBBF, Farmakope Indonesia) terbaru." t="Tidak mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBBBF, Farmakope Indonesia) terbaru.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBBBF, Farmakope Indonesia) terbaru?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[1]; ?></td>
                </tr>
                <tr id="point1subc" y="PBF menerapakan sistem mutu terkait CDOB." t="PBF tidak menerapakan sistem mutu terkait CDOB.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah PBF telah menerapkan sistem mutu terkait CDOB?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[2]; ?></td>
                </tr>
              </table>
              <h2 class="small">2. Organisasi</h2>
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
                  <td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
                </tr>
                <tr id="point2subb" y="Penanggung jawab PBF sesuai dengan ketentuan perundang-undangan." t="Penanggung jawab PBF tidak sesuai dengan ketentuan perundang-undangan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah penanggung jawab sesuai dengan ketentuan peraturan perundang-undangan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
                </tr>
                <tr id="point2subc" y="Penanggung jawab bekerja full time di PBBBF." t="Penanggung jawab tidak bekerja full time di PBBBF.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah penanggung jawab bekerja full time di PBBBF? (sebutkan jadwal kehadiran di keterangan ).</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
                </tr>
                <tr id="point2subd" y="Memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan." t="Tidak memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta tidak dievaluasi efektifitasnya dan didokumentasikan.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah ada program pelatihan sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
                </tr>
                <tr id="point2sube" y="Semua atau sebagian personil pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya." t="Semua atau sebagian personil tidak pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah personil pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
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
                <tr id="point3suba" y="Lokasi sesuai dengan Izin PBBBF." t="Lokasi tidak sesuai dengan Izin PBBBF.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah lokasi sesuai dengan Izin PBBBF?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
                </tr>
                <tr id="point3subb" y="Perubahan denah bangunan telah mendapatkan persetujuan Dinas Kesehatan Provinsi setempat " t="Perubahan denah bangunan tidak mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah  perubahan denah bangunan telah mendapatkan persetujuan Dinas Kesehatan Provinsi  setempat ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
                </tr>
                <tr id="point3subc" y="Kebersihan dan kerapian bangunan dijaga serta dipelihara." t="Kebersihan dan kerapian bangunan tidak dijaga dan tidak dipelihara.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah kebersihan dan kerapian bangunan dijaga serta dipelihara?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
                </tr>
                <tr id="point3subd" y="Ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk." t="Ruang penyimpanan tidak dilengkapi dengan alat pencatat suhu yang terkalibrasi serta tidak dilakukan monitoring sesuai dengan persyaratan masing-masing produk.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
                </tr>
                <tr id="point3sube" y="Luas ruang penyimpanan dan penerangan memadai." t="Luas ruang penyimpanan dan penerangan tidak memadai.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah luas ruang penyimpanan dan penerangan memadai?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
                </tr>
                <tr id="point3subf" y="Mempunyai sistem pengendalian hama (pest control) dan tidak terdokumentasi." t="Tidak mempunyai sistem pengendalian hama (pest control) dan tidak terdokumentasi.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai sistem pengendalian hama (pest control) dan terdokumentasi? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
                </tr>
                <tr id="point3subg" y="Tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai." t="Tidak tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
                </tr>
                <tr id="pointt3subh" y="Tersedia peralatan yang memadai untuk memindahkan barang." t="Tidak tersedia peralatan yang memadai untuk memindahkan barang.">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia peralatan yang memadai untuk memindahkan barang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
                </tr>
                <tr id="pointt3subi" y="Mempunyai laboratorium." t="Tidak mempunyai laboratorium.">
                  <td class="td_no">i.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai laboratorium?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
                </tr>
              </table>
              <h2 class="small">4. Pengadaan</h2>
              <table class="form_tabel" group="4. Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point4suba" y="Pengadaan dari sumber yang sah." t="Terdapat pengadaan dari sumber yang tidak sah.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengadaan dari sumber yang sah?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
                </tr>
                <tr id="point4subb" y="Dilakukan kualifikasi pemasok." t="Tidak dilakukan kualifikasi pemasok.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan kualifikasi pemasok?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
                </tr>
                <tr id="point4subc" y="Memiliki surat pesanan (manual maupun elektronik)" t="Tidak memiliki surat pesanan (manual maupun elektronik)">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah ada surat pesanan? (manual maupun elektronik)</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
                </tr>
                <tr id="point4subd" y="Surat pesanan ditandatangani oleh penanggung jawab, tidak mencantumkan nama jelas, nomor SIK dan tidak distempel perusahaan (untuk manual) atau penanggung jawab tidak memiliki otoritas dalam melakukan pesanan melalui elektronik." t="Surat pesanan tidak ditandatangani oleh penanggung jawab, tidak mencantumkan nama jelas, nomor SIK dan tidak distempel perusahaan (untuk manual) atau penanggung jawab tidak memiliki otoritas dalam melakukan pesanan melalui elektronik.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas dan nomor SIK dan distempel perusahaan (untuk manual) atau penanggung jawab memiliki otoritas dalam melakukan pesanan melalui elektronik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
                </tr>
                <tr id="point4sube" y="Surat pesanan mencantumkan nomor urut dan tidak mampu telusur baik secara manual maupun elektronik." t="Surat pesanan tidak mencantumkan nomor urut dan tidak mampu telusur baik secara manual maupun elektronik.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah surat pesanan mencantumkan nomor urut dan mampu telusur baik secara manual maupun elektronik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
                </tr>
                <tr id="point4subf" y="Salinan surat pesanan, faktur atau surat jalan dari pemasok disatukan." t="Salinan surat pesanan, faktur atau surat jalan dari pemasok tidak disatukan.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah salinan surat pesanan, faktur atau surat jalan dari pemasok disatukan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
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
                <tr id="point5suba" y="Importasi bahan obat dilengkapi dengan  Surat Keterangan Impor (SKI) atau surat pemasukan mekanisme jalur khusus (SAS)" t="Importasi bahan obat tidak dilengkapi dengan  Surat Keterangan Impor (SKI) atau surat pemasukan mekanisme jalur khusus (SAS)">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah dalam melakukan importasi bahan obat dilengkapi dengan  Surat Keterangan Impor (SKI) atau surat pemasukan mekanisme jalur khusus (SAS)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
                </tr>
                <tr id="point5subb" y="Bahan obat yang dibeli dilengkapi dengan CoA." t="Bahan obat yang dibeli tidak dilengkapi dengan CoA.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek"> Apakah bahan obat yang dibeli dilengkapi dengan CoA?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
                </tr>
                <tr id="point5subc" y="Penanggung jawab atau tenaga kefarmasian yang diberikan kuasa oleh penanggung jawab menandatangani faktur pengadaan atau SPB pada saat barang diterima." t="Penanggung jawab atau tenaga kefarmasian yang diberikan kuasa oleh penanggung jawab tidak menandatangani faktur pengadaan atau SPB pada saat barang diterima.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah penanggung jawab atau tenaga kefarmasian yang diberikan kuasa oleh penanggung jawab menandatangani faktur pengadaan atau SPB pada saat barang diterima? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
                </tr>
                <tr id="point5subd" y="Setiap penerimaan bahan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan." t="Setiap penerimaan bahan obat tidak dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan bahan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
                </tr>
                <tr id="point5sube" y="Setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)." t="Setiap penerimaan obat tidak dicatat pada kartu stok (secara manual atau elektronik).">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[27]; ?></td>
                </tr>
                <tr id="point5subf" y="Pengisian kartu stok sesuai dengan ketentuan CDOB." t="Pengisian kartu stok tidak sesuai dengan ketentuan CDOB.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah pengisian kartu stok sesuai dengan ketentuan CDOB?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[28]; ?></td>
                </tr>
                <tr id="point5subg" y="Mempunyai sistem yang menjamin first in and first out / first exp first out." t="Tidak mempunyai sistem yang menjamin first in and first out / first exp first out.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai sistem yang menjamin first in and first out / first exp first out ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[29]; ?></td>
                </tr>
                <tr id="point5subh" y="Semua obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?" t="Semua atau sebagian obat disimpan pada kondisi yang tidak sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[30]; ?></td>
                </tr>
                <tr id="point5subi" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                  <td class="td_no">i.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[31]; ?></td>
                </tr>
                <tr id="point5subj" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik" t="Jumlah dalam kartu stok tidak sesuai dengan jumlah fisik">
                  <td class="td_no">j.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[32]; ?></td>
                </tr>
                <tr id="point5subk" y="Bahan obat golongan betalaktam, sefalosporin, sitostatika, ARV, hormon disimpan pada ruang terpisah." t="Bahan obat golongan betalaktam, sefalosporin, sitostatika, ARV, hormon tidak disimpan pada ruang terpisah.">
                  <td class="td_no">k.&nbsp;</td>
                  <td class="td_aspek">Apakah  bahan obat golongan betalaktam, sefalosporin, sitostatika, ARV, hormon disimpan pada ruang terpisah?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[33]; ?></td>
                </tr>
              </table>
              <h2 class="small">6. Penyaluran</h2>
              <table class="form_tabel" group="6. Penyaluran">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point6suba" y="Terdapat penyaluran bahan obat kepada sarana yang mempunyai kewenangan sesuai dengan ketentuan peraturan perundang-undangan dan dapat dibuktikan kebenaran penyalurannya." t="Terdapat penyaluran bahan obat kepada sarana yang mempunyai kewenangan sesuai dengan ketentuan peraturan perundang-undangan dan tidak dapat dibuktikan kebenaran penyalurannya.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah bahan obat disalurkan kepada sarana yang mempunyai kewenangan sesuai dengan ketentuan peraturan perundang-undangan dan dapat dibuktikan kebenaran penyalurannya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[34]; ?></td>
                </tr>
                <tr id="point6subb" y="Dilakukan kualifikasi pelanggan." t="Tidak dilakukan kualifikasi pelanggan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan kualifikasi pelanggan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[35]; ?></td>
                </tr>
                <tr id="point6subc" y="Seluruh atau sebagian penyaluran obat berdasarkan surat pesanan yang ditandatangani apoteker pengelola apotek, apoteker penanggung jawab dengan mencantumkan nomor SIPA atau SIKA." t="Seluruh atau sebagian penyaluran obat tidak berdasarkan surat pesanan yang ditandatangani apoteker pengelola apotek, apoteker penanggung jawab dengan mencantumkan nomor SIPA atau SIKA.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penyaluran bahan obat berdasarkan surat pesanan yang ditandatangani apoteker pengelola apotek, apoteker penanggung jawab dengan mencantumkan nomor SIPA atau SIKA?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[36]; ?></td>
                </tr>
                <tr id="point6subd" y="Dilakukan skrining oleh penanggung jawab terhadap pesanan yang diterima untuk dapat dilayani berdasarkan analisis risiko" t="Tidak dilakukan skrining oleh penanggung jawab terhadap pesanan yang diterima untuk dapat dilayani berdasarkan analisis risiko">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan skrining oleh penanggung jawab terhadap pesanan yang diterima untuk dapat dilayani berdasarkan analisis risiko?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[37]; ?></td>
                </tr>
                <tr id="point6sube" y="Obat yang dikirimkan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab." t="Obat yang dikirimkan tidak disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta tidak ditandatangani oleh Penanggung Jawab.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah bahan obat yang dikirimkan dilakukan pengontrolan dan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[38]; ?></td>
                </tr>
                <tr id="point6subf" y="Dokumen penyaluran yang meliputi surat pesanan dari pelanggan, faktur atau SPB tidak disatukan dan mampu telusur." t="Dokumen penyaluran yang meliputi surat pesanan dari pelanggan, faktur atau SPB tidak disatukan dan tidak mampu telusur.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah dokumen penyaluran yang meliputi surat pesanan dari pelanggan, faktur atau SPB disatukan dan mampu telusur?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[39]; ?></td>
                </tr>
                <tr id="point6subg" y="Pengiriman yang menggunakan pihak ketiga (jasa pengiriman) berdasarkan kontrak." t="Pengiriman yang menggunakan pihak ketiga (jasa pengiriman) tidak berdasarkan kontrak.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah pengiriman yang menggunakan pihak ketiga (jasa pengiriman) berdasarkan kontrak?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[40]; ?></td>
                </tr>
                <tr id="point6subh" y="Semua atau sebagian tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), tidak diberi tanda tangan, nama terang dan No. SIKA/SIPA/SIKTTK Penanggung Jawab sarana/petugas teknis kefarmasian." t="Semua atau sebagian tanda terima faktur atau surat penyerahan barang tidak dibubuhi stempel sarana penerima (sesuai surat pesanan), tidak diberi tanda tangan, nama terang dan No. SIKA/SIPA/SIKTTK Penanggung Jawab sarana/petugas teknis kefarmasian.">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah semua tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIKA/SIPA/SIKTTK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[41]; ?></td>
                </tr>
                <tr id="point6subi" y="Bahan aktif obat yang di salurkan memenuhi standar mutu farmasi (pharmaceutical grade)." t="Bahan aktif obat yang di salurkan tidak memenuhi standar mutu farmasi (pharmaceutical grade).">
                  <td class="td_no">i.&nbsp;</td>
                  <td class="td_aspek">Apakah bahan aktif obat yang di salurkan adalah yang memenuhi standar mutu farmasi (pharmaceutical grade)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[42]; ?></td>
                </tr>
                <tr id="point6subj" y="Bahan obat yang disalurkan dilengkapi CoA dari produsen dan dari PBF (jika PBF melakukan pengemasan ulang)" t="Bahan obat yang disalurkan tidak dilengkapi CoA dari produsen dan dari PBF (jika PBF melakukan pengemasan ulang)">
                  <td class="td_no">j.&nbsp;</td>
                  <td class="td_aspek">Apakah bahan obat yang disalurkan dilengkapi CoA dari produsen dan dari PBF (jika PBF melakukan pengemasan ulang)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[43]; ?></td>
                </tr>
              </table>
              <h2 class="small">7. Penarikan Kembali Obat (Recall)</h2>
              <table class="form_tabel" group="7. Penarikan Kembali Obat (Recall)">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point7suba" y="Recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali, dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan." t="Recall tidak dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dan tidak dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[44]; ?></td>
                </tr>
                <tr id="point7subb" y="Sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas." t="Sistem dokumentasi tidak mendukung pelaksanaan recall secara efektif, cepat dan tuntas.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[45]; ?></td>
                </tr>
                <tr id="point7subc" y="Produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang." t="Produk recall tidak dicatat dalam Buku Penerimaan Pengembalian Barang, tidak diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[46]; ?></td>
                </tr>
                <tr id="point7subd" y="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM." t="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran tidak dilaporkan kepada Badan POM.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[47]; ?></td>
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
                  <td class="td_kritis"><?php echo $aspek_penilaian[48]; ?></td>
                </tr>
                <tr id="point8subb" y="PBF menghubungi produsen bahan obat dan melaporkan ke Badan POM jika ditemukan bahan obat palsu/diduga palsu." t="PBF tidak menghubungi produsen bahan obat dan melaporkan ke Badan POM jika ditemukan bahan obat palsu/diduga palsu.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah PBF menghubungi produsen bahan obat dan melaporkan ke Badan POM jika ditemukan bahan obat palsu/diduga palsu?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[49]; ?></td>
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
                  <td class="td_kritis"><?php echo $aspek_penilaian[50]; ?></td>
                </tr>
                <tr id="point9subb" y="Jumlah dan identitas bahan obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian." t="Jumlah dan identitas bahan obat yang dikembalikan tidak sesuai dengan bukti penyaluran dan pengembalian.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dan identitas bahan obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[51]; ?></td>
                </tr>
                <tr id="point9subc" y="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci." t="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan tidak dikarantina dan terkunci">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[52]; ?></td>
                </tr>
              </table>
              <h2 class="small">10. Pengembalian Obat Ke Sumber Pengadaan</h2>
              <table class="form_tabel" group="10. Pengembalian Obat Ke Sumber Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point10suba" y="Pengembalian bahan obat kepada pemasok menggunakan Surat Penyerahan Barang dan tidak didokumentasikan." t="Pengembalian bahan obat kepada pemasok tidak menggunakan Surat Penyerahan Barang dan tidak didokumentasikan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengembalian bahan obat kepada pemasok menggunakan Surat Penyerahan Barang dan didokumentasikan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[53]; ?></td>
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
                <tr id="point11suba" y="Dilakukan pemusnahan atau pengembalian ke pemasok untuk bahan obat yang rusak, kedaluwarsa atau tidak layak jual." t="Tidak dilakukan pemusnahan atau pengembalian ke pemasok untuk bahan obat yang rusak, kedaluwarsa atau tidak layak jual.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pemusnahan atau pengembalian ke pemasok untuk bahan obat yang rusak, kedaluwarsa atau tidak layak jual?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[54]; ?></td>
                </tr>
                <tr id="point11subb" y="Pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi." t="Pelaksanaan pemusnahan tidak dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[55]; ?></td>
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
                  <td class="td_kritis"><?php echo $aspek_penilaian[56]; ?></td>
                </tr>
                <tr id="point12subb" y="Catatan mengenai pelaksanaan inspeksi diri terdokumentasi dan dilaporkan kepada pimpinan." t="Catatan mengenai pelaksanaan inspeksi diri tidak terdokumentasi dan tidak dilaporkan kepada pimpinan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah catatan mengenai pelaksanaan inspeksi diri terdokumentasi dan dilaporkan kepada pimpinan ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[57]; ?></td>
                </tr>
                <tr id="point12subc" y="Terdapat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal." t="Tidak terdapat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah dibuat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[58]; ?></td>
                </tr>
                <tr id="point12subd" y="Dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan." t="Tidak dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[59]; ?></td>
                </tr>
              </table>
              <h2 class="small">13. Lain-lain</h2>
              <table class="form_tabel" group="13. Lain-lain">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point13" y="Dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM)." t="Tidak dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM).">
                  <td class="td_no">&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[60]; ?></td>
                </tr>
              </table>
              <h2 class="small">14. Pedagang Besar Bahan Baku Farmasi</h2>
              <h2 class="small" style="margin-left:20px;">Dokumentasi</h2>
              <table class="form_tabel" group="14. Pedagang Besar Bahan Baku Farmasi">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14seri1a" y="Tersedia persetujuan dari industri farmasi sumber bahan obat untuk dilakukan pengemasan dan pelabelan ulang" t="Tidak tersedia persetujuan dari industri farmasi sumber bahan obat untuk dilakukan pengemasan dan pelabelan ulang">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia persetujuan dari industri farmasi sumber bahan obat untuk dilakukan pengemasan dan pelabelan ulang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[61]; ?></td>
                </tr>
                <tr id="point14seri1b" y="Bangunan dan fasilitas untuk pengemasan dan pelabelan ulang memenuhi persyaratan CPOB" t="Bangunan dan fasilitas untuk pengemasan dan pelabelan ulang tidak memenuhi persyaratan CPOB">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah bangunan dan fasilitas untuk pengemasan dan pelabelan ulang memenuhi persyaratan CPOB?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[62]; ?></td>
                </tr>
                <tr id="point14seri1c" y="Dilakukan pengujian yang menjamin mutu bahan obat yang dikemas ulang." t="Tidak dilakukan pengujian yang menjamin mutu bahan obat yang dikemas ulang.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pengujian yang menjamin mutu bahan obat yang dikemas ulang? </td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[63]; ?></td>
                </tr>
                <tr id="point14seri1d" y="Bahan kemas primer yang digunakan mempunyai spesifikasi yang sama atau lebih baik daripada kemasan aslinya." t="Bahan kemas primer yang digunakan mempunyai spesifikasi yang tidak sama atau tidak lebih baik daripada kemasan aslinya.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah bahan kemas primer yang digunakan mempunyai spesifikasi yang sama atau lebih baik daripada kemasan aslinya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[64]; ?></td>
                </tr>
                <tr id="point14seri1e" y="Mempunyai protap repacking." t="Tidak mempunyai protap repacking">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai protap repacking?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[65]; ?></td>
                </tr>
                <tr id="point14seri1f" y="Mempunyai protap sampling." t="Tidak mempunyai protap pengujian.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai protap sampling?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[66]; ?></td>
                </tr>
                <tr id="point14seri1g" y="Mempunyai protap pengujian." t="Tidak mempunyai protap pengujian.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai protap pengujian?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[67]; ?></td>
                </tr>
                <tr id="point14seri1h" y="Mempunyai protap sanitasi ruangan." t="Tidak mempunyai protap sanitasi ruangan.">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai protap sanitasi ruangan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[68]; ?></td>
                </tr>
                <tr id="point14seri1i" y="Mempunyai protap hygiene petugas repacking bahan baku farmasi." t="Tidak mempunyai protap hygiene petugas repacking bahan baku farmasi.">
                  <td class="td_no">i.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai protap hygiene petugas repacking bahan baku farmasi?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[69]; ?></td>
                </tr>
                <tr id="point14seri1j" y="Tidak mempunyai protap pemeliharaan peralatan dalam rangka repacking" t="Tidak mempunyai protap pemeliharaan peralatan dalam rangka repacking">
                  <td class="td_no">j.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai protap pemeliharaan peralatan dalam rangka repacking?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[70]; ?></td>
                </tr>
              </table>
              <h2 class="small" style="margin-left:20px;">Personalia</h2>
              <table class="form_tabel" group="Personalia">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14seri2a" y="Operator mendapat pelatihan khusus tentang teknik repacking tiap langkah proses, termasuk cara menggunakan pakaian kerja untuk melakukan kegiatan di ruang repacking (khusus PBBBF yang melakukan repacking?)" t="Operator belum mendapat pelatihan khusus tentang teknik repacking tiap langkah proses, termasuk cara menggunakan pakaian kerja untuk melakukan kegiatan di ruang repacking (khusus PBBBF yang melakukan repacking)">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah operator mendapat pelatihan khusus tentang teknik repacking tiap langkah proses, termasuk cara menggunakan pakaian kerja untuk melakukan kegiatan di ruang repacking? (khusus PBBBF yang melakukan repacking?)</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[71]; ?></td>
                </tr>
              </table>
              <h2 class="small" style="margin-left:20px;">Program Hygiene Petugas Repacking Bahan Baku Farmasi (Khusus PBBBF yang Melakukan Packing)</h2>
              <table class="form_tabel" group="Program Hygiene Petugas Repacking Bahan Baku Farmasi (Khusus PBBBF yang Melakukan Packing">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14seri3a" y="Personil yang masuk ke dalam area repacking memakai pakaian kerja sesuai dengan CPOB" t="Personil yang masuk ke dalam area repacking tidak memakai pakaian kerja sesuai dengan CPOB">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah personil yang masuk ke dalam area repacking memakai pakaian kerja sesuai dengan CPOB?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[72]; ?></td>
                </tr>
                <tr id="point14seri3b" y="Dilakukan pemeriksaan kesehatan secara berkala." t="Tidak dilakukan pemeriksaan kesehatan secara berkala.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pemeriksaan kesehatan secara berkala?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[73]; ?></td>
                </tr>
              </table>
              <h2 class="small" style="margin-left:20px;">Bangunan dan Peralatan</h2>
              <table class="form_tabel" group="Bangunan dan Peralatan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14seri4a" y="Ruang repacking untuk bahan obat golongan  betalaktam, sefalosporin, sitostatika, ARV, hormon terpisah dengan bahan obat lainnya sesuai dengan ketentuan CPOB untuk mencegah kontaminasi/kontaminasi silang" t="Ruang repacking untuk bahan obat golongan  betalaktam, sefalosporin, sitostatika, ARV, hormon terpisah dengan bahan obat lainnya tidak sesuai dengan ketentuan CPOB untuk mencegah kontaminasi/kontaminasi silang">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah ruang repacking untuk bahan obat golongan  betalaktam, sefalosporin, sitostatika, ARV, hormon terpisah dengan bahan obat lainnya sesuai dengan ketentuan CPOB untuk mencegah kontaminasi/kontaminasi silang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[74]; ?></td>
                </tr>
              </table>
              <h2 class="small" style="margin-left:20px;">Pengadaan, Penyimpanan dan Penyaluran</h2>
              <table class="form_tabel" group="Pengadaan, Penyimpanan dan Penyaluran">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point14seri5a" y="Mempunyai sistem karantina untuk bahan obat yang telah dilakukan pengemasan ulang." t="Tidak mempunyai sistem karantina untuk bahan obat yang telah dilakukan pengemasan ulang.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai sistem karantina untuk bahan obat yang telah dilakukan pengemasan ulang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[75]; ?></td>
                </tr>
                <tr id="point14seri5b" y="Mempunyai metoda analisa yang tervalidasi untuk setiap bahan obat." t="Tidak mempunyai metoda analisa yang tervalidasi untuk setiap bahan obat.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai metoda analisa yang tervalidasi untuk setiap bahan obat?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[76]; ?></td>
                </tr>
              </table>
              <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
              <table id="form_tabel">
                <tr>
                  <td class="td_left">&nbsp;</td>
                  <td class="td_right"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])):'';?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div id="F02MM_kasus"  <?php if($sess['TUJUAN_PEMERIKSAAN'] != "Kasus"){ echo 'style="display:none;"'; }?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KASUS</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">FORM KASUS</h2>
              <h2 class="small">A. PROFIL SARANA DAN ORGANISASI</h2>
              <?php echo array_key_exists('KASUS_POINT_A', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_A'])):'';?>
              <h2 class="small">B. PERSONALIA</h2>
              <?php echo array_key_exists('KASUS_POINT_B', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_B'])):'';?>
              <h2 class="small">C. GUDANG DAN PERLENGKAPAN</h2>
              <?php echo array_key_exists('KASUS_POINT_C', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_C'])):'';?>
              <h2 class="small">D. PENGADAAN</h2>
              <?php echo array_key_exists('KASUS_POINT_D', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_D'])):'';?>
              <h2 class="small">E. PENYIMPANAN</h2>
              <?php echo array_key_exists('KASUS_POINT_E', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_E'])):'';?>
              <h2 class="small">F. PENDISTRIBUSIAN</h2>
              <?php echo array_key_exists('KASUS_POINT_F', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_F'])):'';?>
              <h2 class="small">G. DOKUMENTASI</h2>
              <?php echo array_key_exists('KASUS_POINT_G', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_G'])):'';?>
              <h2 class="small">H. LAIN-LAIN</h2>
              <?php echo array_key_exists('KASUS_POINT_H', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_H'])):'';?> </div>
          </div>
          <!-- Akhir Kasus!--> 
        </div>
        <div <?php echo $sess['TUJUAN_PEMERIKSAAN'] == "Mapping" ? 'style="display:none;"' : ''; ?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
          <div class="collapse">
            <div class="accCntnt">
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
                    <td>Nama Produk : <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>
                      Nama Pabrik : <?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?><br>
                      Negara Asal : <?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?><br>
                      Kemasan : <?php echo $temuan_produk[$i]['KEMASAN']; ?><br>
                      NIE : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>
                      No. Lot / Bets : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>
                      Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><br>
                      Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><br>
                      Harga Total : <?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?></td>
                    <td>Produsen : <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br>
                      Pendaftar : <?php echo $temuan_produk[$i]['PEMILIK']; ?><br />
                      Alamat : <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td>
                    <td>Kategori Temuan : <?php echo $temuan_produk[$i]['KATEGORI']; ?><br>
                      Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td>
                    <td><?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td>
                    <td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td>
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
                <td class="right"><?php echo array_key_exists('UR_HASIL', $sess)?$sess['UR_HASIL']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kesimpulan Detil Pelanggaran</td>
                <td class="right"><ul style="list-style-type:decimal; padding-left:20px;">
                    <li>Jumlah Pelanggaran Minor : <b><?php echo array_key_exists('MINOR', $sess)?$sess['MINOR']:''; ?></b></li>
                    <li>Jumlah Pelanggaran Major : <b><?php echo array_key_exists('MAJOR', $sess)?$sess['MAJOR']:''; ?></b></li>
                    <li>Jumlah Pelanggaran Critical : <b><?php echo array_key_exists('CRITICAL', $sess)?$sess['CRITICAL']:''; ?></b></li>
                    <li>Jumlah Pelanggaran Critical Absolut : <b><?php echo array_key_exists('CRITICAL_ABSOLUT', $sess)?$sess['CRITICAL_ABSOLUT']:''; ?></b></li>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Hasil Temuan</td>
                <td class="right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
                    <?php $temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $temuan)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Catatan Hasil Pemeriksaan</td>
                <td class="right"><?php echo array_key_exists('CATATAN_HASIL_PEMERIKSAAN', $sess)?$sess['CATATAN_HASIL_PEMERIKSAAN']:'';?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Hasil !-->
        
        <div <?php echo $sess['TUJUAN_PEMERIKSAAN'] == "Mapping" ? 'style="display:none;"' : ''; ?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <?php 
					  if($BBPOM_ID != "92"){
						  ?>
              <h2 class="small garis">Tindak Lanjut Balai</h2>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Saran Tindak Lanjut</td>
                  <td class="td_right"><?php if(strlen($sess['TINDAK_LANJUT_BALAI']) > 0) { ?>
                    <ul style="list-style-type:decimal; padding-left:20px; margin:0;">
                      <?php $tl_balai= explode("#", $sess['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?>
                    </ul>
                    <?php }else{ echo "-"; } ?></td>
                </tr>
                <tr class="1" urut="1">
                  <td class="td_left">Detil Tindak Lanjut</td>
                  <td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETAIL_TINDAK_LANJUT_BALAI'])); ?></td>
                </tr>
              </table>
              <?php
                      }?>
              <?php
					  if($isEditTLPusat){
						  $rel = $sess['HASIL'] == "TMK" ?  'rel="required"': "";
						  ?>
              <h2 class="small garis">Tindak Lanjut Pusat</h2>
              <table class="form_tabel">
                <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "92" && $BBPOM_ID != "92"){?>
                <tr>
                  <td class="td_left">Hasil Kesimpulan</td>
                  <td class="right"><?php echo  form_dropdown($obj_hasil, $hasil,$sess['HASIL_PUSAT'] != "" ? $sess['HASIL_PUSAT'] : '', 'id="hasil_pusat" class="stext" title="Hasil Kesimpulan" class="stext" title="Hasil Kesimpulan"'); ?></td>
                </tr>
                <?php } ?>
                <tr id="tr_pusat">
                  <td class="td_left">Tindak Lanjut Pusat</td>
                  <td class="td_right"><?php echo form_dropdown($obj_distribusi.'[TINDAK_LANJUT_PUSAT][]', $cb_tindakan, is_array($tindak_lanjut_pusat)?$tindak_lanjut_pusat:'', 'id="tindakan" class="stext multiselect" style="height:95px" '.$rel.' multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td>
                </tr>
                <tr class="1" urut="1">
                  <td class="td_left">Detil Tindak Lanjut Pusat</td>
                  <td class="td_right"><textarea name="<?php echo $obj_distribusi; ?>[DETIL_TINDAK_LANJUT_PUSAT]" class="stext chk" title="Detail Saran Tindak Lanjut Pusat"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></textarea></td>
                </tr>
              </table>
              <?php
					  }else{
						  ?>
              <h2 class="small garis">Tindak Lanjut Pusat</h2>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Tindak Lanjut Pusat</td>
                  <td class="td_right"><?php if(strlen($sess['TINDAK_LANJUT_PUSAT']) > 0) { ?>
                    <ul style="list-style-type:decimal; padding-left:20px; margin:0;">
                      <?php $tl_pusat= explode("#", $sess['TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $tl_pusat)."</li>"; ?>
                    </ul>
                    <?php }else{ echo "-"; } ?></td>
                </tr>
                <tr class="1" urut="1">
                  <td class="td_left">Detil Tindak Lanjut Pusat</td>
                  <td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></td>
                </tr>
              </table>
              <?php
					  }
					  ?>
            </div>
          </div>
        </div>
        <?php
			  if($isPerbaikan){
			  ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PERBAIKAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Perbaikan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Perbaikan</td>
                <td class="td_right"><input type="text" name="PERBAIKAN[TANGGAL_PERBAIKAN]" id="F02MM_tgperbaikan" class="sdate" title="Tanggal Perbaikan" /></td>
              </tr>
              <tr>
                <td class="td_left">Detail Perbaikan</td>
                <td class="td_right"><textarea class="stext catatan" name="PERBAIKAN[DETAIL_PERBAIKAN]" id="F02MM_perbaikan" title="Detail Perbaikan"></textarea></td>
              </tr>
              <tr>
                <td class="td_left">File Perbaikan</td>
                <td class="td_right"><span class="upload_PERBAIKAN">
                  <input type="file" class="stext upload" jenis="PERBAIKAN" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_PERBAIKAN" name="userfile" onchange="do_upload($(this)); return false;"/>
                  &nbsp;File tipe : *.doc, *.docx, *.xls, *.xlsx, *.rar, *.zip, *.pdf</span><span class="file_PERBAIKAN"></span></td>
              </tr>
            </table>
            <?php if($sess['JML_PERBAIKAN'] != "0"){?>
            <div style="padding-top:5px;">
              <h2 class="small"><a href="#" url="<?php echo $histori_perbaikan; ?>" onclick="expand_detail($(this), 'detil_perbaikan'); return false;" id="daftar_perbaikan">Daftar Perbaikan (<?php echo $sess['JML_PERBAIKAN']; ?>)</a></h2>
              <div id="detil_perbaikan"></div>
            </div>
            <?php } ?>
          </div>
        </div>
        <!-- Akhir Perbaikan !-->
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
              <tr>
                <td class="td_left">Proses Pemeriksaan</td>
                <td class="td_right"><?php echo form_dropdown($obj_status,$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td>
              </tr>
            </table>
            <?php } ?>
            <div style="padding-top:5px;">
              <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan (<?php echo $sess['JML_PROSES']; ?>)</a></h2>
              <div id="detail_log"></div>
            </div>
          </div>
        </div>
        <!-- Akhir Verifikasi !--> 
      </div>
    </div>
    <div id="clear_fix"></div>
    <div>
      <?php if($isverifikasi){ ?>
      <a href="#" class="button check" onclick="fpost('#f02ll_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
      <?php } ?>
      <a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a>&nbsp;</div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
    <input type="hidden" name="redir" value="<?php echo $redir; ?>" />
    <div id="clear_fix"></div>
  </form>
</div>
<div id="reupload-pbf"></div>
<script type="text/javascript">
	$(document).ready(function(){
		  var obj;
		  create_ck("textarea.chk",505)
		  $("#detail_petugas").html("Loading ...");
		  $("#detail_petugas").load($("#detail_petugas").attr("url"));
		  $("#F02MM_tgpusat, #F02MM_tgperbaikan").datepicker();
		  $(".del_tl").live("click", function(){ var id = $(this).closest("ul#list_tl li").attr("id"); $("ul#list_tl li#"+id).remove(); return false; });	
		  $(".add_tl").live("click", function(){ 
		  <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){ ?> obj = 'DETIL_TINDAK_LANJUT_PUSAT'; <?php }else{ ?> obj = 'DETAIL_TINDAK_LANJUT_BALAI'; <?php }?>
		  var panjang = $("ul#list_tl").length; $("ul#list_tl").append('<li style="padding-bottom:3px;" id="'+(panjang+1)+'"><div style="padding-bottom:3px;"><textarea name="<?php echo $obj_distribusi; ?>['+obj+'][]" class="stext catatan" title="Detail Saran Tindak Lanjut Balai."></textarea>&nbsp;<a href="#" class="del_tl"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus atau batalkan tindak lanjut" /></a></div></li>'); $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false}); return false; });
		  $(".del_upload").live("click", function(){ var jenis = $(this).attr("jns"); $.ajax({ type: "GET", url: $(this).attr("url"), data: $(this).serialize(), success: function(data){ var arrdata = data.split("#"); $(".upload_"+jenis+"").show(); $("#fileToUpload_"+jenis+"").val(''); $(".file_"+jenis+"").html(""); } }); return false; });
		  $("#hasil_pusat").change(function(){var isi = $(this).val(); if(isi == "TMK"){ $("tr#tr_pusat").show(); }else{ $("tr#tr_pusat").hide(); $("#tindakan").get(0).selectedIndex = 0; } return false; });
		  $(".reupload").click(function(){
				$.get($(this).attr("url"), function(data){
					$("#reupload-pbf").html(data); 
					$("#reupload-pbf").dialog({ 
						title: 'Upload ulang file lampiran mapping - Sarana PBF', 
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
					$(".upload_"+arrdata[2]+"").hide();
					$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PERBAIKAN[FILE_"+arrdata[2]+"]\" value="+arrdata[0]+">");
				}
			}
		},
		error: function (data, status, e){
			jAlert(e, "SIPT Versi 1.0 Beta");
		}
	});
}
</script> 
