<?php 
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
                              <td class="td_left">Nama PBF</td><td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td></tr>
                            <tr>
                              <td class="td_left">Alamat Kantor</td>
                              <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul> </td>
                          </tr>
                            <tr>
                              <td class="td_left">Alamat Gudang</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?></ul></td>
                          </tr>
                            <tr>
                              <td class="td_left">Telp.</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul></td>
                          </tr>
                            <tr>
                              <td class="td_left">Nomor Izin</td><td class="td_right"><?php echo array_key_exists('NOMOR_IZIN', $sess)?$sess['NOMOR_IZIN']:""; ?></td>
                          </tr>
                            <tr>
                              <td class="td_left">Tanggal Izin</td><td class="td_right"><?php echo array_key_exists('TANGGAL_IZIN', $sess)?$sess['TANGGAL_IZIN']:""; ?></td>
                          </tr>
                            <tr>
                              <td class="td_left">Nama Pimpinan</td><td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:""; ?></td>
                          </tr>
                            <tr>
                              <td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><?php echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:""; ?></td>
                          </tr>
                            <tr>
                              <td class="td_left">SIK</td><td class="td_right"><?php echo array_key_exists('SIK', $sess)?$sess['SIK']:""; ?></td>
                          </tr>
                        </table>
                        
                        <h2 class="small">Informasi Pemeriksaan</h2>
                      <table class="form_tabel">
                        <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td></tr>
                        <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:''; ?></td></tr>
                        <tr id="tr-mapping" <?php echo $sess['TUJUAN_PEMERIKSAAN'] == "Mapping" ? '' : 'style="display:none;"'; ?>><td class="td_left">Lampiran File Mapping</td><td class="td_right"><?php if(trim($sess['LAMPIRAN_MAPPING']) != ""){?><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN_MAPPING']; ?>">View</a><?php } ?></td></tr>
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
              </div><!-- Akhir Pemeriksaan !-->
              
              
              <div id="F02MM_rutin" <?php if($sess['TUJUAN_PEMERIKSAAN'] != "Rutin"){ echo 'style="display:none;"'; }?>>
              <div style="height:5px;"></div>
              <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
              <div class="collapse">
                      <div class="accCntnt">
                      <h2 class="small garis">Penilaian Aspek dan Detail</h2>
                      <h2 class="small">1. Profil Sarana</h2>
                      <table class="form_tabel" group="1. Profil Sarana">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point1suba" y="Papan nama PBF mencantumkan nama PBF, No. Ijin dan alamat PBF serta dipasang permanen di depan lokasi kantor dan gudang PBF atau salah satu jika kantor dan lokasi pada lokasi yang sama" t="Papan nama PBF tidak mencantumkan nama PBF, No. Ijin dan alamat PBF dan atau tidak dipasang permanen di depan lokasi kantor dan gudang PBF atau salah satu jika kantor dan lokasi pada lokasi yang sama"><td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah papan nama PBF mencantumkan nama PBF, No. Ijin dan alamat PBF serta dipasang permanen di depan lokasi kantor dan gudang PBF atau salah satu jika kantor dan lokasi pada lokasi yang sama?</td><td class="td_kritis">Tingkat Kekritisan (m)</td><td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td></tr>
                          <tr id="point1subb" y="Mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBF, Farmakope Indonesia) terbaru." t="Tidak mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBF, Farmakope Indonesia) terbaru.">
                              <td class="td_no">b.&nbsp;</td><td  class="td_aspek">Apakah mempunyai Pedoman CDOB dan Peraturan Perundang-undangan di bidang farmasi (UU Kesehatan, Permenkes terkait PBF, Farmakope Indonesia) terbaru?</td>
                              <td  class="td_kriteria">Tingkat Kekritisan (M)</td>
                              <td class="td_kriteria"><?php echo $aspek_penilaian[1]; ?></td>
                              </tr>
                          <tr id="point1subc" y="PBF telah menerapkan sistem mutu (tersedia Protap dari semua aspek CDOB)." t="PBF belum menerapkan sistem mutu (tidak ada Protap dari semua aspek CDOB atau protap belum lengkap).">
                              <td class="td_no">c.&nbsp;</td><td  class="td_aspek">Apakah PBF telah menerapkan sistem mutu (tersedia Protap dari semua aspek CDOB)?</td>
                              <td class="td_kriteria">Tingkat Kekritisan (M)</td>
                              <td class="td_kriteria"><?php echo $aspek_penilaian[2]; ?></td>
                          </tr>
                      </table>
                      
                      <h2 class="small">2. ORGANISASI</h2>
                      <table class="form_tabel" group="2. Organisasi">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point2suba" y="Tersedia struktur organisasi." t="Tidak tersedia struktur organisasi.">
                                  <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah tersedia struktur organisasi?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
                                  </tr>
                              <tr id="point2subb" y="Setiap pegawai sesuai kualifikasi dan memiliki uraian tugas." t="Semua atau sebagian pegawai tidak sesuai kualifikasi dan atau tidak memiliki uraian tugas.">
                                  <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah setiap personil sesuai kualifikasi dan memiliki uraian tugas?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
                                  </tr>
                              <tr id="point2subc" y="Terdapat absensi kehadiran setiap pegawai." t="Tidak terdapat absensi kehadiran setiap pegawai.">
                                  <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah ada absensi kehadiran setiap pegawai ?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
                                  </tr>
                              <tr id="point2subd" y="Memiliki penanggung jawab yang kualifikasinya sesuai dengan ketentuan dan memiliki SIK dan SP." t="Tidak memiliki penanggung jawab yang kualifikasinya sesuai dengan ketentuan dan atau tidak memiliki SIK dan SP.">
                                  <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah ada penanggung jawab yang kualifikasinya sesuai dengan ketentuan dan memiliki SIK dan SP? (sebutkan di keterangan).</td>
                                  <td class="td_kritis">Tingkat Kekritisan (Ca)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
                                  </tr>
                              
                              <tr id="point2sube" y="Penanggung jawab bekerja full time di PBF." t="Penanggung jawab tidak bekerja full time di PBF.">
                                  <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah penanggung jawab bekerja full time di PBF? (sebutkan jadwal kehadiran di keterangan ).</td>
                                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
                                  </tr>
                              <tr id="point2subf" y="Memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan." t="Tidak memiliki program pelatihan untuk pegawai sesuai tugas dan fungsinya serta tidak dievaluasi efektifitasnya dan didokumentasikan.">
                                  <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah ada program pelatihan sesuai tugas dan fungsinya serta dievaluasi efektifitasnya dan didokumentasikan?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
                                  </tr>
                              <tr id="point2subg" y="Pegawai (PJ, bagian gudang, administrasi distribusi obat) pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya." t="Semua atau sebagian pegawai (PJ, bagian gudang, administrasi distribusi obat) tidak pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya.">
                                  <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah personil (PJ, bagian gudang, administrasi distribusi obat) pernah mengikuti pelatihan yang sesuai dengan tanggung jawabnya?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
                                  </tr>
                      </table>
                      
                      <h2 class="small">3. Bangunan dan Peralatan</h2>
                      <table class="form_tabel" group="3. Bangunan dan Peralatan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point3suba" y="Lokasi sesuai dengan Izin PBF." t="Lokasi tidak sesuai dengan Izin PBF.">
                                  <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah lokasi sesuai dengan Izin PBF?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
                                  </tr>
                              <tr id="point3subb" y="Perubahan denah bangunan telah mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ." t="Perubahan denah bangunan tidak mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ">
                                  <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah perubahan denah bangunan telah mendapatkan persetujuan Dinas Kesehatan Provinsi setempat ?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
                                  </tr>
                              <tr id="point3subc" y="Kebersihan dan kerapian bangunan dijaga serta dipelihara." t="Kebersihan dan kerapian bangunan tidak dijaga dan tidak dipelihara.">
                                  <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah kebersihan dan kerapian bangunan dijaga serta dipelihara?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
                                  </tr>
                              <tr id="point3subd" y="Ventilasi di gudang non AC memadai." t="Ventilasi di gudang non AC tidak memadai.">
                                  <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah ventilasi di ruangan non AC memadai ? </td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
                                  </tr>
                              
                              <tr id="point3sube" y="Ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk." t="Ruang penyimpanan tidak dilengkapi dengan alat pencatat suhu yang terkalibrasi serta tidak dilakukan monitoring sesuai dengan persyaratan masing-masing produk.">
                                  <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah ruang penyimpanan dilengkapi dengan alat pencatat suhu yang terkalibrasi serta dilakukan monitoring sesuai dengan persyaratan masing-masing produk?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
                                  </tr>
                              <tr id="point3subf" y="Luas ruang penyimpanan dan penerangan memadai." t="Luas ruang penyimpanan dan penerangan tidak memadai.">
                                  <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah luas ruang penyimpanan dan penerangan memadai?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
                                  </tr>
                              <tr id="point3subg" y="Tersedia program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi." t="Tidak tersedia program dan peralatan pengendalian hama dan tikus (pest control)">
                                  <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah ada program dan peralatan pengendalian hama dan tikus (pest control) serta didokumentasi? </td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
                                  </tr>
                              <tr id="point3subh" y="Tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai." t="Tidak tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai.">
                                <td class="td_no">h.&nbsp;</td>
                                <td class="td_aspek">Apakah tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai?</td>
                                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
                                </tr>
                              <tr id="pointt3subi" y="Tersedia peralatan yang memadai untuk memindahkan barang." t="Tidak tersedia peralatan yang memadai untuk memindahkan barang.">
                                <td class="td_no">i.&nbsp;</td>
                                <td class="td_aspek">Apakah tersedia peralatan yang memadai untuk memindahkan barang?</td>
                                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
                                </tr>
                     </table>
                     
                     <h2 class="small">4. Pengadaaan</h2>
                      <table class="form_tabel" group="4. Pengadaan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                          <tr id="point4suba" y="Pengadaan dari sumber yang sah." t="Terdapat pengadaan dari sumber yang tidak sah.">
                                  <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah pengadaan dari sumber yang syah?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (c)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
                                  </tr>
                              <tr id="point4subb" y="Memiliki surat pesanan (manual maupun elektronik)" t="Tidak memiliki surat pesanan (manual maupun elektronik)">
                                  <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah ada surat pesanan? (manual maupun elektronik)</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
                                  </tr>
                              <tr id="point4subc" y="Surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas, nomor SIK dan distempel perusahaan (untuk manual) atau penanggung jawab memiliki otoritas dalam melakukan pesanan melalui elektronik." t="Surat pesanan tidak ditandatangani oleh penanggung jawab, tidak mencantumkan nama jelas, nomor SIK dan tidak distempel perusahaan (untuk manual) atau penanggung jawab tidak memiliki otoritas dalam melakukan pesanan melalui elektronik.">
                                  <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah surat pesanan ditandatangani oleh penanggung jawab, mencantumkan nama jelas dan nomor SIK dan distempel perusahaan (untuk manual) atau penanggung jawab memiliki otoritas dalam melakukan pesanan melalui elektronik?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
                                  </tr>
                              <tr id="point4subd" y="Surat pesanan manual diarsipkan berdasarkan nomor urut dan tanggal pemesanan atau tersimpan dalam database untuk surat pesanan secara elektronik." t="Surat pesanan manual tidak diarsipkan berdasarkan nomor urut dan tanggal pemesanan atau tidak tersimpan dalam database untuk surat pesanan secara elektronik.">
                                  <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah surat pesanan manual diarsipkan berdasarkan nomor urut dan tanggal pemesanan atau tersimpan dalam database untuk surat pesanan secara elektronik?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
                                  </tr>
                              
                              <tr id="point4sube" y="Faktur atau Surat Penyerahan Barang (SPB) diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi." t="Faktur atau Surat Penyerahan Barang (SPB) tidak diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi.">
                                  <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah faktur atau Surat Penyerahan Barang (SPB), diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi?</td>
                                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                                  <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
                                  </tr>
                      </table>                        
                      <h2 class="small">5. Penerimaan dan Penyimpanan</h2>
                      <table class="form_tabel" group="5. Penerimaan dan Penyimpanan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point5suba" y="Penanggung jawab menandatangani faktur pembelian pada saat barang diterima." t="Penanggung jawab tidak menandatangani faktur pembelian pada saat barang diterima.">
                          <tr><td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah penanggung jawab menandatangani faktur pembelian pada saat barang diterima?</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
                          </tr>
                      <tr id="point5subb" y="Setiap penerimaan barang dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik." t="Setiap penerimaan barang tidak dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik.">
                          <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dilakukan pemeriksaan dan penelitian terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
                          </tr>
                      <tr id="point5subc" y="Setiap penerimaan barang dicatat pada dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang (secara manual atau sistem elektronik)" t="Setiap penerimaan barang tidak dicatat pada dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang (secara manual atau sistem elektronik).">
                          <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dicatat pada dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang (secara manual atau sistem elektronik)?</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
                          </tr>
                      <tr id="point5subd" y="Pengisian dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang sesuai dengan ketentuan CDOB." t="Pengisian dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang tidak sesuai dengan ketentuan CDOB.">
                          <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah pengisian dokumen penerimaan barang/buku pembelian, kartu persediaan barang/kartu gudang dan kartu barang sesuai dengan ketentuan CDOB?</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[27]; ?></td>
                          </tr>
                      
                      <tr id="point5sube" y="Mempunyai sistem yang menjamin first in and first out / first exp first out." t="Tidak mempunyai sistem yang menjamin first in and first out / first exp first out.">
                          <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah mempunyai sistem yang menjamin first in and first out / first exp first out ? </td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[28]; ?></td>
                          </tr>
                      <tr id="point5subf" y="Semua obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?" t="Semua atau sebagian obat disimpan pada kondisi yang tidak sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
                          <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[29]; ?></td>
                          </tr>
                      <tr id="point5subg" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                          <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[30]; ?></td>
                          </tr>
                      <tr id="point5subh" y="Jumlah dalam kartu barang sesuai dengan jumlah fisik di gudang." t="Jumlah dalam kartu barang tidak sesuai dengan jumlah fisik di gudang.">
                        <td class="td_no">h.&nbsp;</td>
                        <td class="td_aspek">Apakah jumlah dalam kartu barang sesuai dengan jumlah fisik di gudang?</td>
                        <td class="td_kritis">Tingkat Kekritisan (M)</td>
                        <td class="td_kritis"><?php echo $aspek_penilaian[31]; ?></td>
                        </tr>
                      </table>                        
                      <h2 class="small">6. Penyaluran</h2>
                      <table class="form_tabel" group="6. Personalia">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point6suba" y="Semua penyaluran berdasarkan Surat Pesanan yang ditandatangani oleh penanggung jawab dan distempel." t="Semua atau sebagian penyaluran tidak berdasarkan Surat Pesanan yang ditandatangani oleh penanggung jawab dan distempel.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah setiap penyaluran berdasarkan Surat Pesanan yang ditandatangani oleh penanggung jawab dan distempel?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[32]; ?></td>
  </tr>
	<tr id="point6subb" y="Penanggung Jawab membubuhkan tanda tangan atau paraf terhadap pesanan yang dapat dilayani (manual) atau dapat menunjukkan sistem pengontrolan secara elektronik. " t="Penanggung Jawab tidak membubuhkan tanda tangan atau paraf terhadap pesanan yang dapat dilayani (manual) atau tidak dapat menunjukkan sistem pengontrolan secara elektronik.">
    	<td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah Penanggung Jawab membubuhkan tanda tangan atau paraf terhadap pesanan yang dapat dilayani (manual) atau dapat menunjukkan sistem pengontrolan secara elektronik? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[33]; ?></td>
  </tr>
	<tr id="point6subc" y="Obat yang dikirimkan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab." t="Obat yang dikirimkan tidak disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta tidak ditandatangani oleh Penanggung Jawab.">
    	<td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah obat yang dikirimkan disertai faktur atau SPB yang sesuai dengan ketentuan pada pedoman CDOB serta ditandatangani oleh Penanggung Jawab?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[34]; ?></td>
  </tr>
	<tr id="point6subd" y="Faktur atau SPB diarsipkan berdasarkan nomor urut dan tanggal pengeluaran." t="Faktur atau SPB tidak diarsipkan berdasarkan nomor urut dan tanggal pengeluaran.">
    	<td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah faktur atau SPB diarsipkan berdasarkan nomor urut dan tanggal pengeluaran? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[35]; ?></td>
  </tr>
    
	<tr id="point6sube" y="Pengiriman melalui jasa pengiriman dicatat dalam buku ekspedisi sesuai dengan faktur penjualan dan dilengkapi dengan bukti tanda terima dari pihak pemesan." t="Pengiriman melalui jasa pengiriman tidak dicatat dalam buku ekspedisi sesuai dengan faktur penjualan dan atau tidak dilengkapi dengan bukti tanda terima dari pihak pemesan.">
    	<td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah pengiriman melalui jasa pengiriman dicatat dalam buku ekspedisi sesuai dengan faktur penjualan dan dilengkapi dengan bukti tanda terima dari pihak pemesan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[36]; ?></td>
  </tr>
	<tr id="point6subf" y="Semua tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan." t="Semua tanda terima faktur atau surat penyerahan barang tidak dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan.">
    	<td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah semua tanda terima faktur atau surat penyerahan barang dibubuhi stempel sarana penerima (sesuai surat pesanan), diberi tanda tangan, nama terang dan No. SIK Penanggung Jawab sarana/petugas teknis kefarmasian yang diberi kewenangan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[37]; ?></td>
  </tr>
	<tr id="point6subg" y="Obat yang disalurkan dikontrol oleh Kepala Gudang atau petugas yang ditunjuk sesuai faktur atau SPB yang diketahui (ditanda tangani atau diparaf) Penanggung Jawab." t="Obat yang disalurkan tidak dikontrol oleh Kepala Gudang atau petugas yang ditunjuk sesuai faktur atau SPB yang diketahui (ditanda tangani atau diparaf) Penanggung Jawab.">
    	<td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah obat yang disalurkan dikontrol oleh Kepala Gudang atau petugas yang ditunjuk sesuai faktur atau SPB yang diketahui (ditanda tangani atau diparaf) Penanggung Jawab ? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[38]; ?></td>
  </tr>
	<tr id="point6subh" y="pembayaran dilakukan oleh pihak pemesan." t="Pembayaran tidak dilakukan oleh pihak pemesan.">
	  <td class="td_no">h.&nbsp;</td>
	  <td class="td_aspek">Apakah pembayaran dilakukan oleh pihak pemesan?</td>
	  <td class="td_kritis">Tingkat Kekritisan (M)</td>
	  <td class="td_kritis"><?php echo $aspek_penilaian[39]; ?></td>
  </tr>
	<tr id="point6subi" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar." t="Terdapat obat yang tidak disalurkan adalah obat-obat yang terdaftar.">
	  <td class="td_no">i.&nbsp;</td>
	  <td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
	  <td class="td_kritis">Tingkat Kekritisan (C)</td>
	  <td class="td_kritis"><?php echo $aspek_penilaian[40]; ?></td>
  </tr>
	<tr id="point6subj" y="Penyaluran obat keras selalu berdasarkan surat pesanan yang ditanda tangani oleh Penanggung Jawab sarana yang berhak." t="Penyaluran obat keras tidak semua berdasarkan surat pesanan yang ditanda tangani oleh Penanggung Jawab sarana yang berhak.">
	  <td class="td_no">j.&nbsp;</td>
	  <td class="td_aspek">Apakah penyaluran obat keras selalu berdasarkan surat pesanan yang ditanda tangani oleh Penanggung Jawab sarana yang berhak?</td>
	  <td class="td_kritis">Tingkat Kekritisan (M)</td>
	  <td class="td_kritis"><?php echo $aspek_penilaian[41]; ?></td>
  </tr>
      </table>
                      <h2 class="small">7. Penarikan Kembali Obat (recall)</h2>
                      <table class="form_tabel" group="7. Penarikan Kembali Obat (recall)">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point7suba" y="Recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali, dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan." t="Recall tidak dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dan tidak dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah recall dilakukan segera setelah diterima permintaan/perintah untuk penarikan kembali dilakukan secara menyeluruh dan tuntas sampai tingkat sarana pelayanan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[42]; ?></td>
  </tr>
	<tr id="point7subb" y="Sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas." t="Sistem dokumentasi tidak mendukung pelaksanaan recall secara efektif, cepat dan tuntas.">
    	<td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas ?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[43]; ?></td>
  </tr>
	<tr id="point7subc" y="Produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang." t="Produk recall tidak dicatat dalam Buku Penerimaan Pengembalian Barang, tidak diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang.">
    	<td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[44]; ?></td>
  </tr>
	<tr id="point7subd" y="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM." t="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran tidak dilaporkan kepada Badan POM.">
    	<td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[45]; ?></td>
  </tr>
      </table>
                      <h2 class="small">8. Penanganan Produk Ilegal</h2>
                      <table class="form_tabel" group="8. Penanganan Produk Ilegal">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point8suba" y="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk dijual." t="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat tidak diamankan terpisah dari obat lain, tidak terkunci dan tidak diberi penandaan tidak untuk dijual.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk dijual? </td>
    	<td class="td_kritis">Tingkat Kekritisan (C)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[46]; ?></td>
  </tr>
	<tr id="point8subb" y="Distributor menghubungi produsen obat melaporkan ke Badan POM atau Balai Besar/Balai POM setempat bila ditemukan obat palsu/diduga palsu." t="Distributor tidak menghubungi produsen obat, tidak melaporkan ke Badan POM atau Balai Besar/Balai POM setempat bila ditemukan obat palsu/diduga palsu.">
    	<td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah distributor menghubungi produsen obat melaporkan ke Badan POM atau Balai Besar/Balai POM setempat bila ditemukan obat palsu/diduga palsu?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[47]; ?></td>
  </tr>
      </table>
                      <h2 class="small">9. Penanganan Produk Kembalian dan Kadaluarsa</h2>
                      <table class="form_tabel" group="9. Penanganan Produk Kembalian dan Kadaluarsa">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point9suba" y="Ada persyaratan untuk obat kembalian yang dapat diterima." t="Tidak ada persyaratan untuk obat kembalian yang dapat diterima.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah ada persyaratan untuk obat kembalian yang dapat diterima?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[48]; ?></td>
  </tr>
	<tr id="point9subb" y="Jumlah dan identifikasi obat kembalian dicatat dalam Buku Penerimaan Pengembalian Barang berdasarkan bukti pengembalian dari sarana yang mengembalikan." t="Jumlah dan identifikasi obat kembalian tidak dicatat dalam Buku Penerimaan Pengembalian Barang berdasarkan bukti pengembalian dari sarana yang mengembalikan.">
    	<td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah jumlah dan identifikasi obat kembalian dicatat dalam Buku Penerimaan Pengembalian Barang berdasarkan bukti pengembalian dari sarana yang mengembalikan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[49]; ?></td>
  </tr>
	<tr id="point9subc" y="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci." t="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan tidak dikarantina dan terkunci">
    	<td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[50]; ?></td>
  </tr>
      </table>

                      <h2 class="small">10. Pengembalian Obat Ke Sumber Ke Pengadaaan</h2>
                      <table class="form_tabel" group="10. Pengembalian Obat Ke Sumber Pengadaan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point10suba" y="Pengembalian obat kepada suplier menggunakan Surat Penyerahan Barang dan didokumentasikan." t="Pengembalian obat kepada suplier tidak menggunakan Surat Penyerahan Barang dan tidak didokumentasikan.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah pengembalian obat kepada produsen menggunakan Surat Penyerahan Barang dan didokumentasikan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[51]; ?></td>
  </tr>
      </table>
                      <h2 class="small">11. Pemusnahan</h2>
                      <table class="form_tabel" group="11. Pemusnahan">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point11suba" y="Pemusnahan obat dilaksanakan sesuai dengan ketentuan." t="Pemusnahan obat tidak dilaksanakan sesuai dengan ketentuan.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah pemusnahan obat dilaksanakan sesuai dengan ketentuan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[52]; ?></td>
  </tr>
	<tr id="point11subb" y="Perencanaan dan pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan." t="Perencanaan dan pelaksanaan pemusnahan tidak dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan.">
    	<td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah perencanaan dan pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan ? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[53]; ?></td>
  </tr>
	<tr id="point11subc" y="Setiap pemusnahan obat dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang" t="Pemusnahan obat tidak dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang">
    	<td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah untuk tiap pemusnahan obat dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[54]; ?></td>
  </tr>
      </table>
                      <h2 class="small">12. Inspeksi Diri</h2>
                      <table class="form_tabel" group="12. Inspeksi Diri">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
	<tr id="point12suba" y="Terdapat Tim Inspeksi Diri yang ditunjuk oleh pimpinan distributor." t="Tidak terdapat Tim Inspeksi Diri yang ditunjuk oleh pimpinan distributor.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah terdapat Tim Inspeksi Diri yang ditunjuk oleh pimpinan distributor ?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[55]; ?></td>
  </tr>
	<tr id="point12subb" y="Catatan mengenai pelaksanaan inspeksi diri terdokumentasi dan dilaporkan kepada pimpinan." t="Catatan mengenai pelaksanaan inspeksi diri tidak terdokumentasi dan tidak dilaporkan kepada pimpinan.">
    	<td class="td_no">b.&nbsp;</td><td  class="td_aspek">Apakah catatan mengenai pelaksanaan inspeksi diri terdokumentasi dan dilaporkan kepada pimpinan ? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[56]; ?></td>
  </tr>
	<tr id="point12subc" y="Terdapat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal." t="Tidak terdapat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal.">
    	<td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah dibuat daftar periksa yang meliputi karyawan, bangunan termasuk fasilitas, peralatan, pengadaan, penyimpanan dan penyaluran dan dokumentasi untuk mendapatkan standar inspeksi diri yang minimal ? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[57]; ?></td>
  </tr>
	<tr id="point12subd" y="Dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan." t="Tidak dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan.">
    	<td class="td_no">d.&nbsp;</td><td  class="td_aspek">Apakah dilakukan evaluasi dan tindak lanjut terhadap hasil inpeksi diri yang diketahui oleh pimpinan?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[58]; ?></td>
  </tr>
                        
      </table>
                      <h2 class="small">13. Lain - Lain</h2>
                      <table class="form_tabel" group="13. Lain - Lain">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
	<tr id="point13" y="Dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM)." t="Tidak dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM).">
    	<td class="td_no">&nbsp;</td>
    	<td class="td_aspek">Apakah dilakukan pelaporan triwulan pengelolaan obat (termasuk tembusan ke Badan POM / BB/BPOM)?</td>
    	<td class="td_kriteria">Tingkat Kekritisan (M)</td>
    	<td class="td_kriteria"><?php echo $aspek_penilaian[59]; ?></td>
    	</tr>
	  </tr>
      </table>
                      <h2 class="small">14. Penyluar Vaksin / Cold Chain Product</h2>
                      <h2 class="small">Personalia</h2>
                      <table class="form_tabel" group="Personali">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point14suba" y="Petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya." t="Petugas yang menangani vaksin/CCP tidak mendapatkan pelatihan sesuai tanggung jawabnya.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[60]; ?></td>
    	</tr>
	<tr id="point14subb" y="Pelatihan yang dilakukan terdokumentasi." t="Pelatihan yang dilakukan tidak terdokumentasi.">
    	<td class="td_no">b.&nbsp;</td>
    	<td  class="td_aspek">Apakah  pelatihan yang dilakukan terdokumentasi ?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[61]; ?></td>
    	</tr>
	  </tr>
      </table>
                      <h2 class="small">Bangunan dan Tempat Penyimpanan Vaksin / CCP</h2>
                      <table class="form_tabel" group="Bangunan dan Tempat Penyimpanan Vaksin / CCP">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
	  </tr>
<tr id="point14subsuba" y="Tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk." t="Tidak tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk.">
    	<td class="td_no">a.&nbsp;</td>
    	<td class="td_aspek">Apakah tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk?(minimal chiller)</td>
    	<td class="td_kritis">Tingkat Kekritisan (C)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[62]; ?></td>
    	</tr>
	<tr id="pointsubsubb" y="Mempunyai freezer untuk penyimpanan ice pack." t="Tidak mempunyai freezer untuk penyimpanan ice pack.">
    	<td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah mempunyai freezer untuk penyimpanan ice pack?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[63]; ?></td>
    	</tr>
	<tr id="point14subsubc" y="Dilakukan validasi terhadap tempat penyimpanan khusus untuk vaksin/CCP secara berkala minimal satu tahun satu kali." t="Tidak dilakukan validasi terhadap tempat penyimpanan khusus untuk vaksin/CCP secara berkala minimal satu tahun satu kali.">
    	<td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah dilakukan validasi terhadap tempat penyimpanan khusus untuk vaksin/CCP secara berkala minimal satu tahun satu kali</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[64]; ?></td>
    	</tr>
	<tr id="point14subsubd" y="Dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya." t="Tidak dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya.">
    	<td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah dilengkapi dengan temperature data logger yang dapat memberi informasi bahwa vaksin tidak pernah mengalami perubahan suhu yang merusak mutunya?</td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[65]; ?></td>
    	</tr>
    
	<tr id="pointsubsube" y="Tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)" t="Tempat penyimpanan tidak dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)?">
    	<td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)?</td>
    	<td class="td_kritis">Tingkat Kekritisan (C)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[66]; ?></td>
    	</tr>
	<tr id="point14subsubf" y="Tempat penyimpanan dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan." t="Tempat penyimpanan tidak dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan.">
    	<td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat yang dapat memberi peringatan suhu kritis dan secara rutin dilakukan pengecekan? </td>
    	<td class="td_kritis">Tingkat Kekritisan (M)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[67]; ?></td>
    	</tr>
	<tr id="point14subsubg" y="Mempunyai generator otomatis yang berfungsi dengan baik atau mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam." t="Tidak mempunyai generator otomatis yang berfungsi dengan baik atau tidak mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam.">
    	<td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah mempunyai generator otomatis yang berfungsi dengan baik? Atau Apakah mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam?</td>
    	<td class="td_kritis">Tingkat Kekritisan (C)</td>
    	<td class="td_kritis"><?php echo $aspek_penilaian[68]; ?></td>
    	</tr>
	<tr id="pointsubsubh"  y="Terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan)." t="Tidak terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan).">
	  <td class="td_no">h.&nbsp;</td>
	  <td class="td_aspek">Apakah terdapat sistem penanganan produk vaksin / CCP apabila tempat penyimpanan mengalami gangguan/kerusakan (contingency plan)?</td>
	  <td class="td_kritis">Tingkat Kekritisan (M)</td>
	  <td class="td_kritis"><?php echo $aspek_penilaian[69]; ?></td>
	  </tr>
	<tr id="point14subsubi" y="Ada sistem tertentu yang dapat menjamin produk vaksin tidak hilang identitas, tidak mencemari dan tercemari produk/zat lain." t="Tidak ada sistem tertentu yang dapat menjamin produk vaksin tidak hilang identitas, tidak mencemari dan tercemari produk/zat lain.">
	  <td class="td_no">i.&nbsp;</td>
	  <td class="td_aspek">Apakah ada sistem tertentu yang dapat menjamin produk vaksin tidak hilang identitas, tidak mencemari dan tercemari produk/zat lain? </td>
	  <td class="td_kritis">Tingkat Kekritisan (M)</td>
	  <td class="td_kritis"><?php echo $aspek_penilaian[70]; ?></td>
	  </tr>
	<tr id="point14subsubj" y="Ada pemisahan dengan tanda khusus terhadap produk vaksin/CCP yang sudah tidak layak jual (rusak, kadaluarsa)." t="Tidak ada pemisahan dengan tanda khusus terhadap produk vaksin/CCP yang sudah tidak layak jual (rusak, kadaluarsa).">
	  <td class="td_no">j.&nbsp;</td>
	  <td class="td_aspek">Apakah ada pemisahan dengan tanda khusus terhadap produk vaksin/CCP yang sudah tidak layak jual (rusak, kadaluarsa)?</td>
	  <td class="td_kritis">Tingkat Kekritisan (M)</td>
	  <td class="td_kritis"><?php echo $aspek_penilaian[71]; ?></td>
	  </tr>
      </table>
       <h2 class="small">Penyaluran Vaksin / CCP</h2>
                      <table class="form_tabel" group="Penyaluran Vaksi / CCP">
                          <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                      <tr id="point14subseria" y="Penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut." t="Penyaluran vaksin/CCP tidak menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut.">
                      <td class="td_no">a.&nbsp;</td>
                      <td class="td_aspek">Apakah penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut?</td>
                      <td class="td_kritis">Tingkat Kekritisan (C)</td>
                      <td class="td_kritis"><?php echo $aspek_penilaian[72]; ?></td>
                      </tr>
                  <tr id="point14subserib" y="Penyaluran vaksin dilengkapi dengan  alat monitor suhu yang menjamin bahwa vaksin tidak pernah mengalami suhu ekstrim." t="Penyaluran vaksin tidak dilengkapi dengan  alat monitor suhu yang menjamin bahwa vaksin tidak pernah mengalami suhu ekstrim.">
                      <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah penyaluran vaksin dilengkapi dengan  alat monitor suhu yang menjamin bahwa vaksin tidak pernah mengalami suhu ekstrim?</td>
                      <td class="td_kritis">Tingkat Kekritisan (M)</td>
                      <td class="td_kritis"><?php echo $aspek_penilaian[73]; ?></td>
                      </tr>
                      </table>
                      
                      <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
                      <table id="form_tabel">					  
                      	<tr><td class="td_left">&nbsp;</td><td class="td_right"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])):'';?></td></tr>
                      </table>
                     </div>
                     
              </div><!-- Akhir Penilaian !-->
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
                      <?php echo array_key_exists('KASUS_POINT_H', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_H'])):'';?>
                     </div>
              </div><!-- Akhir Kasus!-->
              </div>
              
		  <div <?php echo $sess['TUJUAN_PEMERIKSAAN'] == "Mapping" ? 'style="display:none;"' : ''; ?>>
          <div style="height:5px;"></div>          
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
          <div class="collapse">
                  <div class="accCntnt">
                  <table width="100%" id="tb_distribusi" cellpadding="0" cellspacing="0" class="listtemuan">
                  <thead><tr><th>Detil Produk</th><th>Detil Perusahaan</th><th>Temuan</th><th>Tindakan</th><th>Keterangan</th></tr></thead>
                  <tbody id="tbody_distribusi">
				  <?php
                      if(!$temuan_produk==''){
                          if($sess['JUMLAH_TEMUAN'] != 0){
                              for($i=0; $i<count($temuan_produk); $i++){
                                  ?>
                                  <tr id="baris'<?php echo $i; ?>'"><td>Nama Produk : <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>Nama Pabrik : <?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?><br>Negara Asal : <?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?><br>Kemasan : <?php echo $temuan_produk[$i]['KEMASAN']; ?><br>NIE : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Lot / Bets : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><br>Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><br>Harga Total : <?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?></td><td>Produsen : <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br>Pendaftar : <?php echo $temuan_produk[$i]['PEMILIK']; ?><br />Alamat : <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td>Kategori Temuan : <?php echo $temuan_produk[$i]['KATEGORI']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td><td><?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>
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
               	  <tr><td class="td_left">Hasil Kesimpulan</td><td class="right"><?php echo array_key_exists('UR_HASIL', $sess)?$sess['UR_HASIL']:''; ?></td></tr>
                  <tr><td class="td_left">Kesimpulan Detil Pelanggaran</td><td class="right">
                    <ul style="list-style-type:decimal; padding-left:20px;">
                       	<li>Jumlah Pelanggaran Minor : <b><?php echo array_key_exists('MINOR', $sess)?$sess['MINOR']:''; ?></b></li>
                        <li>Jumlah Pelanggaran Major : <b><?php echo array_key_exists('MAJOR', $sess)?$sess['MAJOR']:''; ?></b></li>
                        <li>Jumlah Pelanggaran Critical : <b><?php echo array_key_exists('CRITICAL', $sess)?$sess['CRITICAL']:''; ?></b></li>
                        <li>Jumlah Pelanggaran Critical Absolut : <b><?php echo array_key_exists('CRITICAL_ABSOLUT', $sess)?$sess['CRITICAL_ABSOLUT']:''; ?></b></li>
                  </ul></td></tr>
               	  <tr><td class="td_left">Hasil Temuan</td><td class="right">
                  <ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $temuan)."</li>"; ?></ul></td></tr>
                  <tr><td class="td_left">Catatan Hasil Pemeriksaan</td><td class="right"><?php echo array_key_exists('CATATAN_HASIL_PEMERIKSAAN', $sess)?$sess['CATATAN_HASIL_PEMERIKSAAN']:'';?></td></tr>
              </table>
              </div>
              </div><!-- Akhir Hasil !-->
              
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
                              <tr><td class="td_left">Saran Tindak Lanjut</td><td class="td_right">
                              <?php if(strlen($sess['TINDAK_LANJUT_BALAI']) > 0) { ?>
                              <ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_balai= explode("#", $sess['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul>
                              <?php }else{ echo "-"; } ?></td></tr>
                              <tr class="1" urut="1"><td class="td_left">Detil Tindak Lanjut</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETAIL_TINDAK_LANJUT_BALAI'])); ?></td></tr>
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
                          <tr><td class="td_left">Hasil Kesimpulan</td><td class="right"><?php echo  form_dropdown($obj_hasil, $hasil,$sess['HASIL_PUSAT'] != "" ? $sess['HASIL_PUSAT'] : '', 'id="hasil_pusat" class="stext" title="Hasil Kesimpulan" class="stext" title="Hasil Kesimpulan"'); ?></td></tr>
                          <?php } ?>
                          <tr id="tr_pusat"><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right">
                          <?php echo form_dropdown($obj_distribusi.'[TINDAK_LANJUT_PUSAT][]', $cb_tindakan, is_array($tindak_lanjut_pusat)?$tindak_lanjut_pusat:'', 'id="tindakan" class="stext multiselect" style="height:95px" '.$rel.' multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td></tr>
                          <tr class="1" urut="1"><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><textarea name="<?php echo $obj_distribusi; ?>[DETIL_TINDAK_LANJUT_PUSAT]" class="stext chk" title="Detail Saran Tindak Lanjut Pusat"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></textarea></td></tr>                          
                          </table>
						  <?php
					  }else{
						  ?>
                          <h2 class="small garis">Tindak Lanjut Pusat</h2>
                          <table class="form_tabel">
                          <tr><td class="td_left">Tindak Lanjut Pusat</td><td class="td_right">
                           <?php if(strlen($sess['TINDAK_LANJUT_PUSAT']) > 0) { ?>
                          <ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_pusat= explode("#", $sess['TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $tl_pusat)."</li>"; ?></ul>
                          <?php }else{ echo "-"; } ?></td></tr>
                          <tr class="1" urut="1"><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></td></tr>
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
                        	<tr><td class="td_left">Tanggal Perbaikan</td><td class="td_right"><input type="text" name="PERBAIKAN[TANGGAL_PERBAIKAN]" id="F02MM_tgperbaikan" class="sdate" title="Tanggal Perbaikan" /></td></tr>
                            <tr><td class="td_left">Detail Perbaikan</td><td class="td_right"><textarea class="stext catatan" name="PERBAIKAN[DETAIL_PERBAIKAN]" id="F02MM_perbaikan" title="Detail Perbaikan"></textarea></td></tr>
                            <tr><td class="td_left">File Perbaikan</td><td class="td_right">
                            <span class="upload_PERBAIKAN"><input type="file" class="stext upload" jenis="PERBAIKAN" allowed="xls-xlsx-doc-docx-rar-zip-pdf" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_PERBAIKAN" name="userfile" onchange="do_upload($(this)); return false;"/>&nbsp;File tipe : *.doc, *.docx, *.xls, *.xlsx, *.rar, *.zip, *.pdf</span><span class="file_PERBAIKAN"></span></td></tr>
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
    <div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f02mm_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a>&nbsp;</div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
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
