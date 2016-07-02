<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f01vv_" id="f01vv_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Informasi Sarana</h2>
            <table id="tbsarana" class="form_tabel">
              <tr>
                <td class="td_left">Nama Sarana Produksi</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Lokasi Sarana</td>
                <td class="td_right"><?php echo array_key_exists('ALAMAT_1', $sess)?$sess['ALAMAT_1']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pemilik Fasilitas</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Penanggung Jawab</td>
                <td class="td_right"><?php echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:" - "; ?></td>
              </tr>
              <tr>
                <td class="td_left">Status Sarana</td>
                <td class="td_right"><?php echo $sess['UR_STATUS_SARANA']; ?></td>
              </tr>
            </table>
            <h2 class="small">Jenis Pangan</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th width="400">Jenis Pangan</th>
                  <th width="150">No. PIRT</th>
                  <th width="250">Status</th>
                </tr>
              </thead>
              <tbody id="tbodypirt">
                <?php
				$jml = count($jenis_pangan);
				if($jml > 0){
					for($i = 0; $i < $jml; $i++){
						?>
                        <tr>
                          <td><?php echo $jenis_pangan[$i]['JENIS_PANGAN']; ?></td>
                          <td><?php echo $jenis_pangan[$i]['NO_PIRT']; ?></td>
                          <td><?php echo $jenis_pangan[$i]['STATUS']; ?></td>
                        </tr>
						<?php
                        }
                    }
                    ?>
              </tbody>
            </table>
            <h2 class="small">Informasi Petugas Pemeriksa</h2>
            <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Pemeriksaan</td>
                <td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?> &nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo  $sess['TUJUAN_PEMERIKSAAN']; ?></td>
              </tr>
              <tr id="row-catatan" <?php echo array_key_exists('STATUS_SARANA', $sess) ? ($sess['STATUS_SARANA'] <> 0 ? 'style="display:none;"' : '') : 'style="display:none;"'?>>
                <td class="td_left">Catatan</td>
                <td class="td_right"><?php echo $sess['CATATAN']; ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Informasi Sarana !-->
        
        <div id="aspek_penilaian" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">ASPEK PENILAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small">A - LOKASI DAN LINGKUNGAN PRODUKSI</h2>
              <table id="pointa" class="form_tabel" group="GRUP A" isgroup="pointa">
                <tr id="a1">
                  <td class="atas" width="12">1.</td>
                  <td class="atas" width="600">Lokasi dan lingkungan IRTP tidak terawat, kotor dan berdebu</td>
                  <td class="atas"><?php echo $aspek_penilaian[0]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[0] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">B - BANGUNAN DAN FASILITAS</h2>
              <table id="pointb" class="form_tabel" group="GRUP B" isgroup="pointb">
                <tr id="b2">
                  <td class="atas" width="12">2.</td>
                  <td class="atas" width="600">Ruang produksi sempit, sukar dibersihkan dan digunakan untuk memproduksi produk selain pangan</td>
                  <td class="atas"><?php echo $aspek_penilaian[1]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[1] : ""; ?></td>
                </tr>
                <tr id="b3">
                  <td class="atas" width="12">3.</td>
                  <td class="atas" width="600">Lantai, dinding, dan langit-langit, tidak terawat, kotor, berdebu dan atau berlendir</td>
                  <td class="atas"><?php echo $aspek_penilaian[2]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[2] : ""; ?></td>
                </tr>
                <tr id="b4">
                  <td class="atas" width="12">4.</td>
                  <td class="atas" width="600">Ventilasi, pintu, dan jendela tidak terawat, kotor dan berdebu</td>
                  <td class="atas"><?php echo $aspek_penilaian[3]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[3] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">C - PERALATAN PRODUKSI</h2>
              <table id="pointc" class="form_tabel" group="GRUP C" isgroup="pointc">
                <tr id="c5">
                  <td class="atas" width="12">5.</td>
                  <td class="atas" width="600">Permukaan yang kontak langsung dengan pangan berkarat dan kotor</td>
                  <td class="atas"><?php echo $aspek_penilaian[4]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[4] : ""; ?></td>
                </tr>
                <tr id="c6">
                  <td class="atas" width="12">6.</td>
                  <td class="atas" width="600">Peralatan tidak dipelihara, dalam keadaan kotor dan tidak menjamin efektifnya sanitasi</td>
                  <td class="atas"><?php echo $aspek_penilaian[5]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[5] : ""; ?></td>
                </tr>
                <tr id="c7">
                  <td class="atas" width="12">7.</td>
                  <td class="atas" width="600">Alat ukur / timbangan untuk mengukur / menimbang berat bersih / isi bersih tidak tersedia atau tidak teliti.</td>
                  <td class="atas"><?php echo $aspek_penilaian[6]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[6] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">D - SUPLAI AIR ATAU SARANA PENYEDIAAN AIR </h2>
              <table id="pointd" class="form_tabel" group="GRUP D" isgroup="pointd">
                <tr id="d8">
                  <td class="atas" width="12">8.</td>
                  <td class="atas" width="600">Air bersih tidak tersedia dalam jumlah yang cukup untuk memenuhi seluruh kebutuhan produksi</td>
                  <td class="atas"><?php echo $aspek_penilaian[7]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[7] : ""; ?></td>
                </tr>
                <tr id="d9">
                  <td class="atas" width="12">9.</td>
                  <td class="atas" width="600">Air berasal dari suplai yang tidak bersih</td>
                  <td class="atas"><?php echo $aspek_penilaian[8]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[8] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">E - FASILITAS DAN KEGIATAN HIGIENE DAN SANITASI </h2>
              <table id="pointe" class="form_tabel" group="GRUP E" isgroup="pointe">
                <tr id="e10">
                  <td class="atas" width="12">10.</td>
                  <td class="atas" width="600">Sarana untuk pembersihan / pencucian bahan pangan, peralatan, perlengkapan dan bangunan tidak tersedia dan tidak terawat dengan baik.</td>
                  <td class="atas"><?php echo $aspek_penilaian[9]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[9] : ""; ?></td>
                </tr>
                <tr id="e11">
                  <td class="atas" width="12">11.</td>
                  <td class="atas" width="600">Tidak tersedia sarana cuci tangan lengkap dengan sabun dan alat pengering tangan.</td>
                  <td class="atas"><?php echo $aspek_penilaian[10]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[10] : ""; ?></td>
                </tr>
                <tr id="e12">
                  <td class="atas" width="12">12.</td>
                  <td class="atas" width="600">Sarana toilet/jamban kotor tidak terawat dan terbuka ke ruang produksi.</td>
                  <td class="atas"><?php echo $aspek_penilaian[11]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[11] : ""; ?></td>
                </tr>
                <tr id="e13">
                  <td class="atas" width="12">13.</td>
                  <td class="atas" width="600">Tidak tersedia tempat pembuangan sampah tertutup.</td>
                  <td class="atas"><?php echo $aspek_penilaian[12]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[12] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">F - KESEHATAN DAN HIGIENE KARYAWAN </h2>
              <table id="pointf" class="form_tabel" group="GRUP F" isgroup="pointf">
                <tr id="f14">
                  <td class="atas" width="12">14.</td>
                  <td class="atas" width="600">Karyawan di bagian produksi pangan ada yang tidak merawat kebersihan badannya dan atau ada yang sakit</td>
                  <td class="atas"><?php echo $aspek_penilaian[13]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[13] : ""; ?></td>
                </tr>
                <tr id="f15">
                  <td class="atas" width="12">15.</td>
                  <td class="atas" width="600">Karyawan di bagian produksi pangan tidak mengenakan pakaian kerja dan / atau mengenakan perhiasan</td>
                  <td class="atas"><?php echo $aspek_penilaian[14]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[14] : ""; ?></td>
                </tr>
                <tr id="f16">
                  <td class="atas" width="12">16.</td>
                  <td class="atas" width="600">Karyawan tidak mencuci tangan dengan bersih sewaktu memulai mengolah pangan, sesudah menangani bahan mentah, atau bahan/ alat yang kotor, dan sesudah ke luar dari toilet/jamban.</td>
                  <td class="atas"><?php echo $aspek_penilaian[15]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[15] : ""; ?></td>
                </tr>
                <tr id="f17">
                  <td class="atas" width="12">17.</td>
                  <td class="atas" width="600">Karyawan bekerja dengan perilaku yang tidak baik (seperti makan dan minum) yang dapat mengakibatkan pencemaran produk pangan.</td>
                  <td class="atas"><?php echo $aspek_penilaian[16] ;?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[16] : ""; ?></td>
                </tr>
                <tr id="f18">
                  <td class="atas" width="12">18.</td>
                  <td class="atas" width="600">Tidak ada Penanggungjawab higiene karyawan</td>
                  <td class="atas"><?php echo $aspek_penilaian[17]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[17] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">G - PEMELIHARAAN DAN PROGRAM HIGIENE DAN SANITASI </h2>
              <table id="pointg" class="form_tabel" group="GRUP G" isgroup="pointg">
                <tr id="g19">
                  <td class="atas" width="12">19.</td>
                  <td class="atas" width="600">Bahan kimia pencuci tidak ditangani dan digunakan sesuai prosedur, disimpan di dalam wadah tanpa label</td>
                  <td class="atas"><?php echo $aspek_penilaian[18]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[18] : ""; ?></td>
                </tr>
                <tr id="g20">
                  <td class="atas" width="12">20.</td>
                  <td class="atas" width="600">Program higiene dan sanitasi tidak dilakukan secara berkala</td>
                  <td class="atas"><?php echo $aspek_penilaian[19]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[19] : ""; ?></td>
                </tr>
                <tr id="g21">
                  <td class="atas" width="12">21.</td>
                  <td class="atas" width="600"> Hewan peliharaan terlihat berkeliaran di sekitar dan di dalam ruang produksi pangan.</td>
                  <td class="atas"><?php echo $aspek_penilaian[20]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[20] : ""; ?></td>
                </tr>
                <tr id="g22">
                  <td class="atas" width="12">22.</td>
                  <td class="atas" width="600">Sampah di lingkungan dan di ruang produksi tidak segera dibuang.</td>
                  <td class="atas"><?php echo $aspek_penilaian[21]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[21] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">H - PENYIMPANAN </h2>
              <table id="pointh" class="form_tabel" group="GRUP H" isgroup="pointh">
                <tr id="g23">
                  <td class="atas" width="12">23.</td>
                  <td class="atas" width="600">Bahan pangan, bahan pengemas disimpan bersama-sama dengan produk akhir dalam satu ruangan penyimpanan yang kotor, lembab dan gelap dan diletakkan di lantai atau menempel ke dinding.</td>
                  <td class="atas"><?php echo $aspek_penilaian[22]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[22] : ""; ?></td>
                </tr>
                <tr id="g24">
                  <td class="atas" width="12">24.</td>
                  <td class="atas" width="600">Peralatan yang bersih disimpan di tempat yang kotor.</td>
                  <td class="atas"><?php echo $aspek_penilaian[23]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[23] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">I - PENGENDALIAN PROSES </h2>
              <table id="pointi" class="form_tabel" group="GRUP I" isgroup="pointi">
                <tr id="i25">
                  <td class="atas" width="12">25.</td>
                  <td class="atas" width="600">IRTP tidak memiliki catatan; menggunakan bahan baku yang sudah rusak, bahan berbahaya, dan bahan tambahan pangan yang tidak sesuai dengan persyaratan penggunaannya.</td>
                  <td class="atas"><?php echo $aspek_penilaian[24]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[24] : ""; ?></td>
                </tr>
                <tr id="i26">
                  <td class="atas" width="12">26.</td>
                  <td class="atas" width="600">IRTP tidak mempunyai atau tidak mengikuti bagan alir produksi pangan.</td>
                  <td class="atas"><?php echo $aspek_penilaian[25]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[25] : ""; ?></td>
                </tr>
                <tr id="i27">
                  <td class="atas" width="12">27.</td>
                  <td class="atas" width="600">IRTP tidak menggunakan bahan kemasan khusus untuk pangan.</td>
                  <td class="atas"><?php echo $aspek_penilaian[26]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[26] : ""; ?></td>
                </tr>
                <tr id="i28">
                  <td class="atas" width="12">28.</td>
                  <td class="atas" width="600">BTP tidak diberi penandaan dengan benar.</td>
                  <td class="atas"><?php echo $aspek_penilaian[27]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[27] : ""; ?></td>
                </tr>
                <tr id="i29">
                  <td class="atas" width="12">29.</td>
                  <td class="atas" width="600">Alat ukur / timbangan untuk mengukur / menimbang BTP tidak tersedia atau tidak teliti.</td>
                  <td class="atas"><?php echo $aspek_penilaian[28]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[28] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">J - PELABELAN PANGAN </h2>
              <table id="pointj" class="form_tabel" group="GRUP J" isgroup="pointj">
                <tr id="i30">
                  <td class="atas" width="12">30.</td>
                  <td class="atas" width="600">Label pangan tidak mencantumkan nama produk, daftar bahan yang digunakan, berat bersih/isi bersih, nama dan alamat IRTP, masa kedaluwarsa, kode produksi dan nomor P-IRT.</td>
                  <td class="atas"><?php echo $aspek_penilaian[29]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[29] : ""; ?></td>
                </tr>
                <tr id="i31">
                  <td class="atas" width="12">31.</td>
                  <td class="atas" width="600">Label mencantumkan klaim kesehatan atau klaim gizi.</td>
                  <td class="atas"><?php echo $aspek_penilaian[30]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[30] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">K - PENGAWASAN OLEH PENANGGUNG JAWAB </h2>
              <table id="pointk" class="form_tabel" group="GRUP K" isgroup="pointk">
                <tr id="k32">
                  <td class="atas" width="12">32.</td>
                  <td class="atas" width="600">IRTP tidak mempunyai penanggung jawab yang memiliki Sertifikat Penyuluhan Keamanan Pangan (PKP)</td>
                  <td class="atas"><?php echo $aspek_penilaian[31]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[31] : ""; ?></td>
                </tr>
                <tr id="k33">
                  <td class="atas" width="12">33.</td>
                  <td class="atas" width="600">IRTP tidak melakukan pengawasan internal secara rutin, termasuk monitoring dan tindakan koreksi</td>
                  <td class="atas"><?php echo $aspek_penilaian[32]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[32] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">L - PENARIKAN PRODUK </h2>
              <table id="pointl" class="form_tabel" group="GRUP L" isgroup="pointl">
                <tr id="l34">
                  <td class="atas" width="12">34.</td>
                  <td class="atas" width="600">Pemilik IRTP tidak melakukan penarikan produk pangan yang tidak aman</td>
                  <td class="atas"><?php echo $aspek_penilaian[33]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[33] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">M - PENCATATAN DAN DOKUMENTASI </h2>
              <table id="pointm" class="form_tabel" group="GRUP M" isgroup="pointm">
                <tr id="m35">
                  <td class="atas" width="12">35.</td>
                  <td class="atas" width="600">IRTP tidak memiliki dokumen produksi</td>
                  <td class="atas"><?php echo $aspek_penilaian[34]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[34] : ""; ?></td>
                </tr>
                <tr id="m36">
                  <td class="atas" width="12">36.</td>
                  <td class="atas" width="600">Dokumen produksi tidak mutakhir, tidak akurat, tidak tertelusur dan tidak disimpan selama 2 (dua) kali umur simpan produk pangan yang diproduksi.</td>
                  <td class="atas"><?php echo $aspek_penilaian[35]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[35] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">N - PELATIHAN KARYAWAN</h2>
              <table id="pointn" class="form_tabel" group="GRUP N" isgroup="pointn">
                <tr id="n36">
                  <td class="atas" width="12">37.</td>
                  <td class="atas" width="600">IRTP tidak memiliki program pelatihan keamanan pangan untuk karyawan.</td>
                  <td class="atas"><?php echo $aspek_penilaian[36]; ?></td>
                  <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[36] : ""; ?></td>
                </tr>
              </table>
              <h2 class="small">JUMLAH KETIDAK SESUAIAN</h2>
              <table class="form_tabel">
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain KRITIS</td>
                  <td class="atas"><?php echo array_key_exists('JML_KRITIS', $sess)?$sess['JML_KRITIS']:"0"; ?></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain SERIUS</td>
                  <td class="atas"><?php echo $sess['JML_SERIUS']; ?></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain MAYOR</td>
                  <td class="atas"><?php echo $sess['JML_MAJOR']; ?></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain MINOR</td>
                  <td class="atas"><?php echo $sess['JML_MINOR']; ?></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Level IRTP</td>
                  <td class="atas"><?php echo $sess['LEVEL_IRTP']?></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- Akhir Aspek Penilaian !--> 
        </div>
        <div id="div-rincian-laporan" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">RINCIAN LAPORAN KETIDAKSESUAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Rincian Ketidaksesuaian</h2>
              <table class="listtemuan" width="100%">
                <thead>
                  <tr>
                    <th width="500">Ketidaksesuaian</th>
                    <th width="75">Kriteria</th>
                    <th width="300">Timeline</th>
                  </tr>
                </thead>
                <tbody id="draft-penilaian">
                  <?php
				  $jml = count($rincian_ketidaksesuaian);
				  if($jml > 0){
					  for($i = 0; $i < $jml; $i++){
						?>
                  <tr id="<?php echo $rincian_ketidaksesuaian[$i]; ?>">
                    <td width="500"><?php echo $rincian_ketidaksesuaian[$i]; ?></td>
                    <td width="70"><?php echo $rincian_kriteria[$i]; ?></td>
                    <td><?php echo $rincian_timeline[$i]; ?></td>
                  </tr>
                  <?php
                      }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php
		if($histori){
			?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAPORAN TINDAKAN KOREKSI DAN STATUS</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Tindakan Koreksi dan Status</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th width="400">Ketidaksesuaian</th>
                  <th width="75">Kriteria</th>
                  <th width="300">Timeline</th>
                  <th width="100">Tindakan Perbaikan</th>
                  <th width="75">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $jml = count($histori_rekapan);
                    if($jml > 0){
                        for($i = 0; $i < $jml; $i++){
                            ?>
                <tr id="<?php echo $histori_rekapan[$i]['ID']; ?>">
                  <td width="500"><?php echo $histori_rekapan[$i]['KETIDAKSESUAIAN']; ?></td>
                  <td width="70"><?php echo $histori_rekapan[$i]['KRITERIA']; ?></td>
                  <td><?php echo $histori_rekapan[$i]['TIMELINE']; ?></td>
                  <td><?php echo $histori_rekapan[$i]['TINDAKAN_PERBAIKAN']; ?></td>
                  <td><?php echo $histori_rekapan[$i]['STATUS']; ?></td>
                </tr>
                <?php
                        }
                    }
                    ?>
              </tbody>
            </table>
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
      <a href="#" class="button check" onclick="fpost('#f01vv_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
      <?php } ?>
      <a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
    <input type="hidden" name="redir" value="<?php echo $redir; ?>" />
    <div id="clear_fix"></div>
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
	  create_ck("textarea.chk",505)
	  $("#detail_petugas").html("Loading ...");
	  $("#detail_petugas").load($("#detail_petugas").attr("url"));				
	});
</script> 
