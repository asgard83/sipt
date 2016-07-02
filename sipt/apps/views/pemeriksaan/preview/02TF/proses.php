<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f02TF_" id="f02TF_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Informasi Sarana</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama GFK</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:'';  ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat </td>
                <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                    <?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Telp.</td>
                <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                    <?php $telp = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telp)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Nama Pimpinan</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:'';  ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Penanggung Jawab</td>
                <td class="td_right"><?php echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:'';  ?></td>
              </tr>
              <tr>
                <td class="td_left">No. SIK</td>
                <td class="td_right"><?php echo array_key_exists('NO_SIK', $sess)?$sess['NO_SIK']:'';  ?></td>
              </tr>
            </table>
            <h2 class="small">Informasi Petugas Pemeriksa</h2>
            <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Pemeriksaan</td>
                <td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:''; ?></td>
            </table>
          </div>
        </div>
        <!--Akhir Informasi Pemeriksaan !-->
        <div id="F02TF_rutin" <?php if($sess['TUJUAN_PEMERIKSAAN'] != "Rutin"){ echo 'style="display:none;"'; }?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Penilaian Aspek dan Detail</h2>
              <h2 class="small">1. Bangunan dan Peralatan</h2>
              <table class="form_tabel" group="1. Bangunan dan Peralatan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point3suba" y="Mempunyai sistem pengendalian hama (pest control) dan tidak terdokumentasi." t="Tidak mempunyai sistem pengendalian hama (pest control) dan tidak terdokumentasi.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai sistem pengendalian hama (pest control) dan terdokumentasi?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td>
                </tr>
                <tr id="point3subb" y="Tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai." t="Tidak tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia palet atau peralatan lain yang menjamin obat tidak bersentuhan langsung dengan lantai?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[1]; ?></td>
                </tr>
                <tr id="point3subc" y="Tersedia peralatan yang memadai untuk memindahkan barang." t="Tidak tersedia peralatan yang memadai untuk memindahkan barang.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia peralatan yang memadai untuk memindahkan barang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[2]; ?></td>
                </tr>
              </table>
              <h2 class="small">2. Pengadaan</h2>
              <table class="form_tabel" group="2. Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point4suba" y="Pengadaan dari sumber yang sah." t="Pengadaan bukan dari sumber yang sah.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengadaan dari sumber yang sah?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
                </tr>
              </table>
              <h2 class="small">3. Penerimaan dan Penyimpanan</h2>
              <table class="form_tabel" group="3. Penerimaan dan Penyimpanan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point5suba" y="Setiap penerimaan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan." t="Setiap penerimaan obat tidak dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi :  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
                </tr>
                <tr id="point5subb" y="Setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)." t="Setiap penerimaan obat tidak dicatat pada kartu stok (secara manual atau elektronik).">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dicatat pada kartu stok (secara manual atau elektronik)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
                </tr>
                <tr id="point5subc" y="Pengisian kartu stok sesuai dengan mencantumkan nomor bets dan kedaluwarsa obat." t="Pengisian kartu stok sesuai dengan tidak mencantumkan nomor bets dan kedaluwarsa obat.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah pengisian kartu stok sesuai dengan mencantumkan nomor bets dan kedaluwarsa obat?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
                </tr>
                <tr id="point5subd" y="Mempunyai sistem yang menjamin first in and first out / first exp first out." t="Tidak mempunyai sistem yang menjamin first in and first out / first exp first out.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai sistem yang menjamin first in and first out / first exp first out ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
                </tr>
                <tr id="point5subf" y="Semua obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?" t="Semua atau sebagian obat tidak disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
                </tr>
                <tr id="point5subf" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
                </tr>
                <tr id="point5subg" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik" t="Jumlah dalam kartu stok tidak sesuai dengan jumlah fisik">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
                </tr>
              </table>
              <h2 class="small">4. Penyaluran</h2>
              <table class="form_tabel" group="4. Penyaluran">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point6suba" y="Semua penyaluran berdasarkan Surat Pesanan/LPLPO  yang ditandatangani oleh penanggung jawab dan distempel." t="Semua atau sebagian penyaluran tidak berdasarkan Surat Pesanan/LPLPO yang ditandatangani oleh penanggung jawab dan distempel.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penyaluran berdasarkan Surat Pesanan/LPLPO yang ditandatangani oleh penanggung jawab dan distempel?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
                </tr>
                <tr id="point6subb" y="Obat yang dikirimkan disertai LPLPO/SPB yang ditandatangani oleh Penanggung Jawab" t="Obat yang dikirimkan tidak disertai LPLPO/SPB yang ditandatangani oleh Penanggung Jawab">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang dikirimkan disertai LPLPO/SPB yang ditandatangani oleh Penanggung Jawab?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
                </tr>
                <tr id="point6subc" y="Dilakukan pengarsipan dokkumen penyaluran (LPLPO/SPB) dan mampu telusur?" t="Tidak dilakukan pengarsipan dokkumen penyaluran (LPLPO/SPB) dan mampu telusur">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pengarsipan dokkumen penyaluran (LPLPO/SPB) dan mampu telusur?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
                </tr>
                <tr id="point6subd" y="Semua tanda terima LPLPO/surat penyerahan barang dibubuhi diberi tanda tangan, nama terang dan No. nomor SIPA/SIKTTK atau SIK tenaga kesehatan lain yang diberikan kewenangan dan distempel puskesmas?" t="Semua tanda terima LPLPO/surat penyerahan barang tidak dibubuhi diberi tanda tangan, nama terang dan No. nomor SIPA/SIKTTK atau SIK tenaga kesehatan lain yang diberikan kewenangan dan distempel puskesmas">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah semua tanda terima LPLPO/surat penyerahan barang dibubuhi diberi tanda tangan, nama terang dan No. nomor SIPA/SIKTTK atau SIK tenaga kesehatan lain yang diberikan kewenangan dan distempel puskesmas?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
                </tr>
                <tr id="point6sube" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar" t="Obat-obat yang disalurkan adalah obat-obat yang tidak terdaftar.">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
                </tr>
              </table>
              <h2 class="small">5. Penarikan Kembali Obat (Recall)</h2>
              <table class="form_tabel" group="5. Penarikan Kembali Obat (Recall)">
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
                  <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
                </tr>
                <tr id="point7subb" y="Sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas." t="Sistem dokumentasi tidak mendukung pelaksanaan recall secara efektif, cepat dan tuntas.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah sistem dokumentasi mendukung pelaksanaan recall secara efektif, cepat dan tuntas ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
                </tr>
                <tr id="point7subc" y="Produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang." t="Produk recall tidak dicatat dalam Buku Penerimaan Pengembalian Barang, tidak diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah produk recall dicatat dalam Buku Penerimaan Pengembalian Barang kemudian diamankan di tempat terpisah dan terkunci sampai obat tersebut dikembalikan sesuai instruksi dari pihak yang berwenang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
                </tr>
                <tr id="point7subd" y="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM." t="Pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran tidak dilaporkan kepada Badan POM.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah pelaksanaan penarikan atau hasil penarikan termasuk permintaan penghentian penyaluran serta Laporan Pengembalian Barang yang Ditarik dari Peredaran dilaporkan kepada Badan POM?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
                </tr>
              </table>
              <h2 class="small">6. Penanganan Produk Ilegal</h2>
              <table class="form_tabel" group="6. Penanganan Produk Ilegal">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point8suba" y="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan." t="Obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat tidak diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah obat palsu/diduga palsu yang ditemukan dalam jaringan distribusi obat diamankan terpisah dari obat lain, terkunci dan diberi penandaan tidak untuk disalurkan? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
                </tr>
                <tr id="point8subb" y="Instalasi Farmasi menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu." t="Instalasi Farmasi tidak menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah instalasi farmasi menghubungi produsen obat dan melaporkan ke Badan POM jika ditemukan obat palsu/diduga palsu?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
                </tr>
              </table>
              <h2 class="small">7. Penanganan Produk Kembalian dan Kadaluarsa</h2>
              <table class="form_tabel" group="7. Penanganan Produk Kembalian dan Kadaluarsa">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point9suba" y="Jumlah dan identitas obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian." t="Jumlah dan identitas obat yang dikembalikan tidak sesuai dengan bukti penyaluran dan pengembalian.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dan identitas obat yang dikembalikan sesuai dengan bukti penyaluran dan pengembalian?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
                </tr>
                <tr id="point9subb" y="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci." t="Obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan tidak dikarantina dan tidak terkunci.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah obat kembalian yang diterima karena tidak memenuhi syarat mutu dan yang mengalami kerusakan penandaan, dikarantina dan terkunci?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
                </tr>
              </table>
              <h2 class="small">8. Pengembalian Obat Ke Sumber Pengadaan</h2>
              <table class="form_tabel" group="8. Pengembalian Obat Ke Sumber Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point10" y="Pengembalian obat kepada sumber pengadaan menggunakan Surat Penyerahan Barang dan didokumentasikan." t="Pengembalian obat kepada sumber pengadaan tidak menggunakan Surat Penyerahan Barang dan tidak didokumentasikan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengembalian obat kepada sumber pengadaan menggunakan Surat Penyerahan Barang dan didokumentasikan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
                </tr>
              </table>
              <h2 class="small">9. Pemusnahan</h2>
              <table class="form_tabel" group="9. Pemusnahan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point11suba" y="Pemusnahan obat dilaksanakan sesuai dengan ketentuan." t="Pemusnahan obat tidak dilaksanakan sesuai dengan ketentuan.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pemusnahan obat dilaksanakan sesuai dengan ketentuan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
                </tr>
                <tr id="point11subb" y="Pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi." t="Pelaksanaan pemusnahan tidak dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah pelaksanaan pemusnahan dilaporkan kepada Badan POM atau Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
                </tr>
              </table>
              <h2 class="small">10. Pengelolaan Vaksin</h2>
              <h2 class="small" style="margin-left:20px;">Personalia</h2>
              <table class="form_tabel" group="Personalia">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point12seri1a" y="Petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya dan tidak terdokumentasi." t="Petugas yang menangani vaksin/CCP tidak mendapatkan pelatihan sesuai tanggung jawabnya dan tidak terdokumentasi.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah petugas yang menangani vaksin/CCP mendapatkan pelatihan sesuai tanggung jawabnya dan terdokumentasi?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[27]; ?></td>
                </tr>
              </table>
              <h2 class="small" style="margin-left:20px;">Bangunan dan Penyimpanan Vaksin / CCP </h2>
              <table class="form_tabel" group="Bangunan dan Penyimpanan Vaksin / CCP">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point12seri2a" y="Tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk." t="Tidak tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah tersedia tempat terpisah untuk penyimpanan produk vaksin/CCP sesuai dengan spesifikasi produk?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[28]; ?></td>
                </tr>
                <tr id="point12serie" y="Tempat penyimpanan vaksin/CCP dilengkapi dengan alat pemantau suhu (termometer) yang terkalibrasi dan tidak dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)" t="Tempat penyimpanan vaksin/CCP tidak dilengkapi dengan alat pemantau suhu (termometer) yang terkalibrasi dan tidak dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah tempat penyimpanan dilengkapi dengan alat pemantau suhu (termometer) yang terkalibrasi dan dilakukan monitoring suhu serta pencatatan secara berkala (minimal sehari tiga kali dengan interval yang memadai)?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[29]; ?></td>
                </tr>
                <tr id="point12seri2c" y="Mempunyai generator otomatis yang berfungsi dengan baik atau mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam." t="Tidak mempunyai generator otomatis yang berfungsi dengan baik atau tidak mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam.">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah mempunyai generator otomatis yang berfungsi dengan baik? Atau Apakah mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[30]; ?></td>
                </tr>
              </table>
              <h2 class="small" style="margin-left:20px;">Penyaluran Vaksin / CCP</h2>
              <table class="form_tabel" group="Penyaluran Vaksin / CCP">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point12seri3a" y="Penyaluran vaksin/CCP menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut." t="Penyaluran vaksin/CCP tidak menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah penyaluran vaksin menggunakan wadah kedap yang dilengkapi ice pack/dry ice sedemikian rupa sehingga mencapai temperatur yang sesuai dengan vaksin tersebut?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo $aspek_penilaian[31]; ?></td>
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
          <!-- Akhir Penilaian !--> 
        </div>
        <div id="F02TF_kasus"  <?php if($sess['TUJUAN_PEMERIKSAAN'] != "Kasus"){ echo 'style="display:none;"'; }?>>
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
                <td class="td_right"><textarea name="<?php echo $obj_distribusi; ?>[DETIL_TINDAK_LANJUT_PUSAT]" class="stext chk" title="Detail Saran Tindak Lanjut Pusat"><?php echo $sess['DETIL_TINDAK_LANJUT_PUSAT']; ?></textarea></td>
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
      <a href="#" class="button check" onclick="fpost('#f02TF_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
      <?php } ?>
      <a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a>&nbsp;</div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
    <input type="hidden" name="redir" value="<?php echo $redir; ?>" />
    <div id="clear_fix"></div>
  </form>
</div>
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
