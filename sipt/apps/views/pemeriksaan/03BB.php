<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f03BB" id="f03BB" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Informasi Sarana</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama Balai Pengobatan</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Kantor</td>
                <td class="td_right"><?php echo array_key_exists('ALAMAT_1', $sess)?$sess['ALAMAT_1']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Telp.</td>
                <td class="td_right"><?php echo array_key_exists('TELEPON', $sess)?$sess['TELEPON']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nomor Izin</td>
                <td class="td_right"><?php echo array_key_exists('NOMOR_IZIN', $sess)?$sess['NOMOR_IZIN']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Izin</td>
                <td class="td_right"><?php echo array_key_exists('TANGGAL_IZIN', $sess)?$sess['TANGGAL_IZIN']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Pengelola Obat</td>
                <td class="td_right"><?php echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Pimpinan</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:''; ?></td>
              </tr>
              <tr>
                <td class="td_left">SIK</td>
                <td class="td_right"><?php echo array_key_exists('NO_SIK', $sess)?$sess['NO_SIK']:''; ?></td>
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
                <td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN_DISTRIBUSI[TUJUAN_PEMERIKSAAN]', $tujuan_periksa, array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:'', 'id="F03BB_tujuanperiksa" class="stext" rel="required" title="Pilih salah satu tujuan pemeriksaan"'); ?></td>
            </table>
          </div>
        </div>
        <!-- Akhir Pemeriksaan !-->
        
        <div id="F03BB_rutin" <?php if($sel_tujuan !=  "Rutin"){ echo 'style="display:none;"'; }?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Penilaian Aspek dan Detail</h2>
              <h2 class="small">1. Pengadaan</h2>
              <table class="form_tabel" group="1. Pengadaan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point3suba" y="Semua atau sebagian pengadaan obat dan bahan obat dari sumber resmi" t="Semua atau sebagian pengadaan obat dan bahan obat tidak dari sumber resmi">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah pengadaan obat dan bahan obat dari sumber resmi?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[0]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subb" y="Semua atau sebagian surat pesanan untuk pengadaan obat/bahan obat ditandatangani oleh penanggung jawab instalasi farmasi/kamar obat, tidak mencantumkan nama jelas dan nomor SIPA dan tidak distempel balai pengobatan/klinik." t="Semua atau sebagian surat pesanan untuk pengadaan obat/bahan obat tidak ditandatangani oleh penanggung jawab instalasi farmasi/kamar obat, tidak mencantumkan nama jelas dan nomor SIPA dan tidak distempel balai pengobatan/klinik.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah surat pesanan untuk pengadaan obat/bahan obat ditandatangani oleh penanggung jawab instalasi farmasi/kamar obat, mencantumkan nama jelas dan nomor SIPA dan distempel balai pengobatan/klinik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[1]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subc" y="Salinan surat pesanan obat dan bahan obat mencantumkan nomor urut dan tidak mampu telusur baik secara manual maupun elektronik" t="Salinan surat pesanan obat dan bahan obat tidak mencantumkan nomor urut dan tidak mampu telusur baik secara manual maupun elektronik">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah salinan surat pesanan obat dan bahan obat mencantumkan nomor urut dan mampu telusur baik secara manual maupun elektronik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[2]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point3subd" y="Faktur atau Surat Penyerahan Barang (SPB) pengadaan obat/bahan obat, diarsipkan dan mampu telusur" t="Faktur atau Surat Penyerahan Barang (SPB) pengadaan obat/bahan obat, tidak diarsipkan dan tidak mampu telusur">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah  faktur atau Surat Penyerahan Barang (SPB) pengadaan obat/bahan obat diarsipkan  dan mampu telusur?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[3]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">2. Penerimaan dan Penyimpanan</h2>
              <table class="form_tabel" group="2. Penerimaan dan Penyimpanan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point4suba" y="Semua atau sebagian faktur pengadaan obat/bahan obat ditandatangani oleh tenaga kefarmasian atau petugas yang ditunjuk pada saat diterima" t="Semua atau sebagian faktur pengadaan obat/bahan obat tidak ditandatangani oleh tenaga kefarmasian atau petugas yang ditunjuk pada saat diterima">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah faktur pengadaan obat/bahan obat di tandatangani oleh tenaga kefarmasian atau petugas yang ditunjuk pada saat diterima?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[4]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subb" y="Setiap penerimaan obat dan bahan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi:  item, jumlah, nomor bets, tanggal kadaluarsa) serta tidak dilakukan pemeriksaan kebenaran/kondisi kemasan." t="Setiap penerimaan obat dan bahan obat tidak dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi:  item, jumlah, nomor bets, tanggal kadaluarsa) serta tidak dilakukan pemeriksaan kebenaran/kondisi kemasan.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dan bahan obat dilakukan pemeriksaan kesesuaian antara fisik dan dokumen (meliputi:  item, jumlah, nomor bets, tanggal kadaluarsa) serta pemeriksaan kebenaran/kondisi kemasan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[5]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subc" y="Setiap penerimaan obat dan bahan obat dicatat pada kartu stok dan/atau catatan penerimaan dan tidak mencantumkan asal barang, jumlah, nomor bets dan kedaluwarsa obat/bahan obat (manual atau elektronik)." t="Setiap penerimaan obat dan bahan obat tidak dicatat pada kartu stok dan/atau catatan penerimaan dan tidak mencantumkan asal barang, jumlah, nomor bets dan kedaluwarsa obat/bahan obat (manual atau elektronik).">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penerimaan obat dan bahan obat dicatat pada kartu stok dan/atau catatan penerimaan yang mencantumkan asal barang, jumlah, nomor bets dan kedaluwarsa obat/bahan obat? (manual atau elektronik)</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[6]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subd" y="Pengeluaran obat berdasarkan sistem first in first out / first exp first out." t="Pengeluaran obat tidak berdasarkan sistem first in first out / first exp first out.">
                  <td class="td_no">d.&nbsp;</td>
                  <td class="td_aspek">Apakah pengeluaran obat berdasarkan sistem first in first out / first exp first out ? </td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[7]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4sube" y="Obat yang disimpan bukan pada wadah asli dari pabrik (m)mencantumkan informasi tentang nama obat,no bets dan tanggal kedaluwarsa pada kemasan?" t="Obat yang disimpan bukan pada wadah asli dari pabrik tidak (m)mencantumkan informasi tentang nama obat,no bets dan tanggal kedaluwarsa pada kemasan?">
                  <td class="td_no">e.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang disimpan bukan pada wadah asli dari pabrik (m)mencantumkan informasi tentang nama obat,no bets dan tanggal kedaluwarsa pada kemasan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[8]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subf" y="Obat dan bahan obat disimpan sesuai dengan persyaratan yang tercantum dalam penandaan." t="Obat dan bahan obat tidak disimpan sesuai dengan persyaratan yang tercantum dalam penandaan.">
                  <td class="td_no">f.&nbsp;</td>
                  <td class="td_aspek">Apakah obat dan bahan obat disimpan sesuai dengan persyaratan yang tercantum dalam penandaan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[9]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subg" y="Vaksin/CCP disimpan pada tempat yang sesuai dengan persyaratan penandaan." t="Vaksin/CCP tidak disimpan pada tempat yang sesuai dengan persyaratan penandaan.">
                  <td class="td_no">g.&nbsp;</td>
                  <td class="td_aspek">Apakah Vaksin/CCP disimpan pada tempat yang sesuai dengan persyaratan penandaan?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[10]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                
                <tr id="point4subh" y="Tempat penyimpanan Vaksin/CCP dilengkapi termometer dan dilakukan pencatatan monitoring suhu minimal dua kali sehari" t="Tempat penyimpanan Vaksin/CCP tidak dilengkapi termometer dan dilakukan pencatatan monitoring suhu minimal dua kali sehari">
                  <td class="td_no">h.&nbsp;</td>
                  <td class="td_aspek">Apakah tempat penyimpanan Vaksin/CCP dilengkapi termometer dan dilakukan pencatatan monitoring suhu minimal dua kali sehari?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[11]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                
                <tr id="point4subi" y="Obat yang kedaluwarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak dipisahkan penyimpanannya dan dicatat" t="Obat yang kedaluwarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak dipisahkan penyimpanannya dan tidak dicatat">
                  <td class="td_no">i.&nbsp;</td>
                  <td class="td_aspek">Apakah obat yang kedaluwarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan dipisahkan penyimpanannya dan dicatat?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[12]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point4subj" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik." t="Obat yang kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                  <td class="td_no">j.&nbsp;</td>
                  <td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[13]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">3. Penyaluran</h2>
              <table class="form_tabel" group="3. Penyaluran">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point5suba" y="Setiap penyaluran obat berdasarkan resep dari dalam balai pengobatan tersebut." t="Semua atau sebagian penyaluran obat tidak berdasarkan resep dari dalam balai pengobatan tersebut.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah setiap penyaluran obat berdasarkan resep dari dalam balai pengobatan tersebut?</td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[14]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subb" y="Dokumentasi penyerahan obat (resep, catatan penjualan obat tanpa resep) dapat tertelusur" t="Dokumentasi penyerahan obat (resep, catatan penjualan obat tanpa resep) tidak dapat tertelusur">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah dokumentasi penyerahan obat (resep, catatan penjualan obat tanpa resep) dapat tertelusur?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[15]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point5subc" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar" t="Obat-obat yang disalurkan adalah obat-obat yang tidak terdaftar">
                  <td class="td_no">c.&nbsp;</td>
                  <td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
                  <td class="td_kritis">Tingkat Kekritisan (C)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[16]:'', 'tingkat="C" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">4. Penanganan Produk Kembalian dan Kadaluarsa</h2>
              <table class="form_tabel" group="4. Penanganan Produk Kembalian dan Kadaluarsa">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point6suba" y="Setelah menerima informasi recall dari distributor, balai pengobatan segera menghentikan penjualan dan mengembalikan ke distributor." t="Setelah menerima informasi recall dari distributor, balai pengobatan tidak segera menghentikan penjualan dan mengembalikan ke distributor.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah setelah menerima informasi recall dari sumber pengadaan, balai pengobatan segera menghentikan penjualan dan mengembalikan ke sumber pengadaan? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[17]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point6subb" y="Pengembalian obat ke distributor disertai dengan faktur pembelian." t="Pengembalian obat ke distributor tidak disertai dengan faktur pembelian.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah pengembalian obat ke sumber pengadaan disertai dengan faktur pembelian/Surat Penyerahan Barang?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[0], is_array($aspek_penilaian)?$aspek_penilaian[18]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
              </table>
              <h2 class="small">5. Pemusnahan</h2>
              <table class="form_tabel" group="5. Pemusnahan">
                <tr>
                  <td class="td_no isi">&nbsp;</td>
                  <td class="td_aspek isi">ASPEK DAN DETAIL</td>
                  <td class="td_kritis isi">TINGKAT KEKRITISAN</td>
                  <td class="td_kriteria isi">YA / TIDAK / NA</td>
                </tr>
                <tr id="point7suba" y="Dilakukan pemusnahan atau pengembalian ke pemasok untuk obat yang rusak, kedaluwarsa atau tidak layak jual?." t="Tidak dilakukan pemusnahan atau pengembalian ke pemasok untuk obat yang rusak, kedaluwarsa atau tidak layak jual?.">
                  <td class="td_no">a.&nbsp;</td>
                  <td class="td_aspek">Apakah dilakukan pemusnahan atau pengembalian ke pemasok untuk obat yang rusak, kedaluwarsa atau tidak layak jual? </td>
                  <td class="td_kritis">Tingkat Kekritisan (M)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[19]:'', 'tingkat="M" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
                </tr>
                <tr id="point7subb" y="Laporan pelaksanaan pemusnahan ditembuskan Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi." t="Laporan pelaksanaan pemusnahan tidak mditembuskan Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi.">
                  <td class="td_no">b.&nbsp;</td>
                  <td class="td_aspek">Apakah laporan pelaksanaan pemusnahan ditembuskan Balai Besar/Balai POM setempat dengan melampirkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi ?</td>
                  <td class="td_kritis">Tingkat Kekritisan (m)</td>
                  <td class="td_kritis"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[ASPEK_PENILAIAN][]', $cb_kritis[1], is_array($aspek_penilaian)?$aspek_penilaian[20]:'', 'tingkat="m" class="sel_penyimpangan" rel="required" title="Pilih salah satu Ya, Tidak atau NA"'); ?></td>
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
        </div>
        <div id="F03BB_kasus" <?php if($sel_tujuan != "Kasus"){ echo 'style="display:none;"'; }?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KASUS</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">FORM KASUS</h2>
              <h2 class="small">A. PROFIL SARANA DAN ORGANISASI</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_A]" id="F03BB_kasus_pointa" title="Profil sarana dan organisasi"><?php echo array_key_exists('KASUS_POINT_A', $sess)?$sess['KASUS_POINT_A']:'';?></textarea>
              <h2 class="small">B. PERSONALIA</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_B]" id="F03BB_kasus_pointb" title="Personalia"><?php echo array_key_exists('KASUS_POINT_B', $sess)?$sess['KASUS_POINT_B']:'';?></textarea>
              <h2 class="small">C. GUDANG DAN PERLENGKAPAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_C]" id="F03BB_kasus_pointc" title="Gudang dan Perlengkapak"><?php echo array_key_exists('KASUS_POINT_C', $sess)?$sess['KASUS_POINT_C']:'';?></textarea>
              <h2 class="small">D. PENGADAAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_D]" id="F03BB_kasus_pointd" title="Pengadaan"><?php echo array_key_exists('KASUS_POINT_D', $sess)?$sess['KASUS_POINT_D']:'';?></textarea>
              <h2 class="small">E. PENYIMPANAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_E]" id="F03BB_kasus_pointe" title="Penyimpanan"><?php echo array_key_exists('KASUS_POINT_E', $sess)?$sess['KASUS_POINT_E']:'';?></textarea>
              <h2 class="small">F. PENDISTRIBUSIAN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_F]" id="F03BB_kasus_pointf" title="Pendistribusian"><?php echo array_key_exists('KASUS_POINT_F', $sess)?$sess['KASUS_POINT_F']:'';?></textarea>
              <h2 class="small">G. DOKUMENTASI</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_G]" id="F03BB_kasus_pointg" title="Dokumentasi"><?php echo array_key_exists('KASUS_POINT_G', $sess)?$sess['KASUS_POINT_G']:'';?></textarea>
              <h2 class="small">H. LAIN-LAIN</h2>
              <textarea class="stext chk" name="PEMERIKSAAN_DISTRIBUSI[KASUS_POINT_H]" id="F03BB_kasus_pointh" title="Lain - Lain"><?php echo array_key_exists('KASUS_POINT_H', $sess)?$sess['KASUS_POINT_H']:'';?></textarea>
            </div>
          </div>
          <!-- Akhir Kasus!--> 
        </div>
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
                  <input type="text" class="scode" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_MINOR]" id="F03BB_jumlahminor" readonly value="<?php echo array_key_exists('MINOR', $sess)?$sess['MINOR']:''; ?>" title="Jumlah Minor" />
                  &nbsp;&nbsp;M&nbsp;
                  <input type="text" class="scode" id="F03BB_jumlahmajor" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_MAJOR]" readonly  value="<?php echo array_key_exists('MAJOR', $sess)?$sess['MAJOR']:''; ?>" title="Jumlah Major" />
                  &nbsp;&nbsp;C&nbsp;
                  <input type="text" class="scode" name="PEMERIKSAAN_DISTRIBUSI[KLASIFIKASI_PELANGGARAN_CRITICAL]" id="F03BB_jumlahcritical" readonly value="<?php echo array_key_exists('CRITICAL', $sess)?$sess['CRITICAL']:''; ?>" title="Jumlah Kritikal" /></td>
              </tr>
              <tr id="td_hasil">
                <td class="td_left">Hasil Temuan</td>
                <td class="right"><textarea id="F03BB_catatan" name="PEMERIKSAAN_DISTRIBUSI[HASIL_TEMUAN]" class="stext catatan" title="Hasil Temuan"><?php echo array_key_exists('HASIL_TEMUAN', $sess)?$sess['HASIL_TEMUAN']:'';?></textarea></td>
              </tr>
              <tr>
                <td class="td_left">Catatan Hasil Pemeriksaan</td>
                <td class="right"><textarea name="PEMERIKSAAN_DISTRIBUSI[CATATAN_HASIL_PEMERIKSAAN]" class="stext catatan" title="Catatan Hasil Pemeriksaan"><?php echo array_key_exists('CATATAN_HASIL_PEMERIKSAAN', $sess)?$sess['CATATAN_HASIL_PEMERIKSAAN']:'';?></textarea></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Hasil !-->
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAK LANJUT</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <?php if($this->newsession->userdata('SESS_BBPOM_ID') != "92"){ ?>
            <h2 class="small garis">Tindak Lanjut</h2>
            <table class="form_tabel">
              <tr id="td_tlbalai">
                <td class="td_left">Saran Tindak Lanjut</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[TINDAK_LANJUT_BALAI][]', $cb_tindakan, is_array($tindak_lanjut_balai)?$tindak_lanjut_balai:'', 'id="tl_balai" class="stext multiselect" style="height:95px;" rel="required" multiple title="Saran Tindak Lanjut Balai. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td>
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
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DISTRIBUSI[TINDAK_LANJUT_PUSAT][]', $cb_tindakan, is_array($tindak_lanjut_pusat)?$tindak_lanjut_pusat:'', 'id="tl_pusat" class="stext multiselect" style="height:95px;" rel="required" multiple title="Saran Tindak Lanjut Pusat. Untuk memilih lebih dari satu, klik + Ctrl"'); ?></td>
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
        <?php
		if(!array_key_exists('PERIKSA_ID', $sess)){
		?>
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
    <div><a href="#" class="button save" onclick="fpost('#f03BB','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a>&nbsp;<a href="#" class="button download" url="<?php echo site_url(); ?>/post/pemeriksaan/set_preview_distribusi/" onclick="prev_checklist($(this), '#f03BB'); return false;" ><span><span class="icon"></span>&nbsp; Preview Hasil Temuan &nbsp;</span></a></div>
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
	create_ck("textarea.chk",505)
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
	<?php
	if($sess['PERIKSA_ID'] == ""){
		?>
		var m = 0; var M = 0; var C = 0; var Ca = 0; var temuan = new Array(); $("#F03BB_kasus").css("style:display","none");
		<?php
	}else{
		?>
		var m = <?php echo $sess['MINOR']; ?>;
		var M = <?php echo $sess['MAJOR']; ?>;
		var C = <?php echo $sess['CRITICAL']; ?>;
		var hasil_temuan = "<?php echo $sess['HASIL_TEMUAN']; ?>";
		var temuan = new Array();
		temuan = hasil_temuan.split("___");
		<?php		
		if($sess['TUJUAN_PEMERIKSAAN'] == "Kasus"){
			?>
			$("#F03BB_rutin").css("style:display","none");
			$("#F03BB_kasus").show();
			<?php
		}else if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin"){
			?>
			$("#F03BB_rutin").show();
			$("#F03BB_kasus").css("style:display","none");
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
    }
    if (val == "T") {
        temuan.push(tidak);
    } else if (val == "Y" || val == "N") {
        ArrExist(temuan, tidak);
    }
    $("#F03BB_jumlahminor").val(parseInt(m));
    $("#F03BB_jumlahmajor").val(parseInt(M));
    $("#F03BB_jumlahcritical").val(parseInt(C));
    $("#F03BB_catatan").val(temuan.join("___"));
	if(parseInt(m) > 0 && parseInt(M) == 0 && parseInt(C) == 0)
	{
		$("#hasil").val("MK");
		$("#hasil").attr("readonly", true);
	}
	else if(parseInt(m) > 0 || parseInt(M) > 0 || parseInt(C) > 0)
	{
		$("#hasil").val("TMK");
		$("#hasil").attr("readonly", true);
	}
	else if(parseInt(m) == 0 && parseInt(M) == 0 && parseInt(C) == 0)
	{
		$("#hasil").val("");
		$("#hasil").removeAttr("readonly");
	}
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
	  $("#F03BB_jumlahminor, #F03BB_jumlahmajor, #F03BB_jumlahcritical, #F03BB_catatan").val(''); 
	  $("#F03BB_rutin select.sel_penyimpangan").get(0).selectedIndex = 0;
	  temuan = Array();
  }
  return false;
}

</script> 
