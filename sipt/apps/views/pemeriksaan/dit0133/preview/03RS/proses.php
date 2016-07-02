<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f03RS_" id="f03RS_" method="post" action="<?php echo $act; ?>" autocomplete="off">

<div class="adCntnr">
    <div class="acco2">
    	
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Informasi Sarana</h2>
                <table class="form_tabel">
                    <tr>
                      <td class="td_left">Nama Puskesmas</td>
                      <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:''; ?></td></tr>
                    <tr>
                      <td class="td_left">Alamat </td>
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
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td></tr>
                  <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo array_key_exists('TUJUAN_PEMERIKSAAN', $sess)?$sess['TUJUAN_PEMERIKSAAN']:''; ?></td>
                </table>
				</div>
		</div><!-- Akhir Pemeriksaan !-->

        <div id="F03RS_rutin" <?php if($sess['TUJUAN_PEMERIKSAAN'] != "Rutin"){ echo 'style="display:none;"'; }?>>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Penilaian Aspek dan Detail</h2>
                <h2 class="small">1. Profil Sarana</h2>
                    <table class="form_tabel" group="1. Profil Sarana">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point1suba" y="Selama jam buka puskesmas terdapat tenaga teknis kefarmasian." t="Selama jam buka puskesmas tidak terdapat tenaga teknis kefarmasian.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah selama jam buka puskesmas terdapat tenaga teknis kefarmasian?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td>
                        </tr>
                        <tr id="point1subb" y="Memiliki buku standar dan peraturan perundang-undangan (FI, UU Psikotropika, UU Narkotika, UU Kesehatan, Perundang-undangan di bidang obat) terbaru." t="Tidak memiliki buku standar dan peraturan perundang-undangan (FI, UU Psikotropika, UU Narkotika, UU Kesehatan, Perundang-undangan di bidang obat) terbaru.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah memiliki buku standar dan peraturan perundang-undangan (FI, UU Psikotropika, UU Narkotika, UU Kesehatan, Perundang-undangan di bidang obat) terbaru?</td>
                            <td class="td_kritis">Tingkat Kekritisan (m)</td><td class="td_kritis"><?php echo $aspek_penilaian[1]; ?></td>
                        </tr>
                    </table>
                    <h2 class="small">2. Bangunan dan Peralatan</h2>
                    <table class="form_tabel" group="2. Bangunan dan Peralatan">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point2suba" y="Mempunyai ruang penyimpanan yang memadai sesuai dengan kriteria penyimpanan obat." t="Tidak mempunyai ruang penyimpanan yang memadai sesuai dengan kriteria penyimpanan obat.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah mempunyai ruang penyimpanan yang memadai sesuai dengan kriteria penyimpanan obat?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[2]; ?></td>
                        </tr>
                        <tr id="point2subb" y="Kebersihan dan kerapian bangunan dijaga serta dipelihara." t="Kebersihan dan kerapian bangunan tidak dijaga serta dipelihara.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah kebersihan dan kerapian bangunan dijaga serta dipelihara?</td>
                            <td class="td_kritis">Tingkat Kekritisan (m)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
                        </tr>
                        <tr id="point2subc" y="Ventilasi dan penerangan di ruangan memadai." t="Ventilasi dan penerangan di ruangan kurang memadai.">
                            <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah ventilasi dan penerangan di ruangan memadai? </td>
                            <td class="td_kritis">Tingkat Kekritisan (m)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
                        </tr>
                        <tr id="point2subd" y="Terdapat perlengkapan untuk sanitasi dan higinie." t="Tidak terdapat perlengkapan untuk sanitasi dan higinie.">
                            <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah terdapat perlengkapan untuk sanitasi dan higinie?</td>
                            <td class="td_kritis">Tingkat Kekritisan (m)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
                        </tr>
                        
                        <tr id="point2sube" y="Mempunyai tempat khusus penyimpanan narkotika & psikotropika sesuai ketentuan." t="Tidak mempunyai tempat khusus penyimpanan narkotika & psikotropika sesuai ketentuan.">
                            <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah mempunyai tempat khusus penyimpanan narkotika &amp; psikotropika sesuai ketentuan?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
                        </tr>
                        <tr id="point2subf" y="Penyimpanan obat menggunakan pallet." t="Penyimpanan obat tidak menggunakan pallet.">
                            <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah penyimpanan obat menggunakan pallet?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
                        </tr>
                        <tr id="point2subg" y="Memiliki ruang peracikan." t="Tidak memiliki ruang peracikan.">
                            <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah memiliki ruang peracikan?</td>
                            <td class="td_kritis">Tingkat Kekritisan (m)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
                        </tr>
                        <tr id="point2subh" y="Memiliki timbangan." t="Tidak memiliki timbangan.">
                            <td class="td_no">h.&nbsp;</td><td class="td_aspek">Apakah memiliki timbangan?</td>
                            <td class="td_kritis">Tingkat Kekritisan (m)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
                        </tr>
                        <tr id="point2subi" y="Dilengkapi dengan alat pemadam kebakaran." t="Tidak dilengkapi dengan alat pemadam kebakaran.">
                            <td class="td_no">i.&nbsp;</td><td class="td_aspek">Apakah dilengkapi dengan alat pemadam kebakaran?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
                        </tr>
                    </table>
                    <h2 class="small">3. Pengadaan</h2>
                    <table class="form_tabel" group="3. Penandaan">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point3suba" y="Selain dari Gudang Farmasi Kabupaten/Kota pengadaan berasal dari sumber resmi." t="Selain dari Gudang Farmasi Kabupaten/Kota pengadaan berasal dari sumber tidak resmi.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah selain dari Gudang Farmasi Kabupaten/Kota pengadaan berasal dari sumber resmi?</td><td class="td_kritis">Tingkat Kekritisan (C)</td><td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
                        </tr>
                        <tr id="point2subb" y="Surat pesanan/LPLPO ditandatangani oleh Penanggungjawab, mencantumkan nama jelas dan nomor SIK/SP dan distempel puskesmas." t="Surat pesanan/LPLPO tidak ditandatangani oleh Penanggungjawab, mencantumkan nama jelas dan nomor SIK/SP dan distempel puskesmas.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah surat pesanan/LPLPO ditandatangani oleh Penanggungjawab, mencantumkan nama jelas dan nomor SIK/SP dan distempel puskesmas?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
                        </tr>
                        <tr id="point3subc" y="Surat pesanan/LPLPO diarsipkan berdasarkan nomor urut dan tanggal pemesanan." t="Surat pesanan/LPLPO tidak diarsipkan berdasarkan nomor urut dan tanggal pemesanan.">
                            <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah surat pesanan/LPLPO diarsipkan berdasarkan nomor urut dan tanggal pemesanan?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
                        </tr>
                        <tr id="point3subd" y="Faktur/Surat Penyerahan Barang (SPB), diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi." t="Faktur/Surat Penyerahan Barang (SPB) tidak diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi.">
                            <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah faktur/Surat Penyerahan Barang (SPB), diarsipkan berdasarkan tanggal penerimaan oleh penanggung jawab dan atau bagian administrasi?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
                        </tr>
                    </table>
                    <h2 class="small">4. Penerimaan dan Penyimpanan</h2>
                    <table class="form_tabel" group="4. Penerimaan dan Penyimpanan">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point4suba" y="Tenaga teknis kefarmasian menandatangani faktur/surat penyerahan barang pengadaan pada saat barang diterima." t="Setiap penerimaan barang tidak dicatat pada kartu stok dan catatan penerimaan. (manual atau elektronik)">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah tenaga teknis kefarmasian menandatangani faktur/surat penyerahan barang pengadaan pada saat barang diterima?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
                        </tr>
                        <tr id="point4subb" y="Setiap penerimaan barang dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik" t="Setiap penerimaan barang tidak dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dilakukan pemeriksaan dan penelitian terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
                        </tr>
                        <tr id="point4subc" y="Setiap penerimaan barang dicatat pada kartu stok dan catatan penerimaan (manual atau elektronik)" t="Semua atau sebagian penerimaan barang tidak dicatat pada kartu stok dan catatan penerimaan (manual atau elektronik)">
                            <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dicatat pada kartu stok dan catatan penerimaan? (manual atau elektronik)</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
                        </tr>
                        <tr id="point4subd" y="Pengisian kartu stok dan catatan penerimaan sesuai dengan ketentuan CDOB (manual atau elektronik)" t="Pengisian kartu stok dan catatan penerimaan tidak sesuai dengan ketentuan CDOB (manual atau elektronik)">
                            <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah pengisian kartu stok dan catatan penerimaan sesuai dengan ketentuan CDOB? (manual atau elektronik)</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
                        </tr>
                        
                        <tr id="point4sube" t="Pengeluaran obat tidak berdasarkan sistem first in first out / first exp first out." y="Pengeluaran obat berdasarkan sistem first in first out / first exp first out.">
                            <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah pengeluaran obat berdasarkan sistem first in first out / first exp first out ? </td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
                        </tr>
                        <tr id="point4subf" y="Obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya." t="Obat tidak disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta tidak terpisah dari komoditi lainnya.">
                            <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
                        </tr>
                        <tr id="point4subg" y="Vaksin/CCP disimpan pada tempat yang sesuai dengan persyaratan penandaan, dilengkapi termometer dan dilakukan pencatatan monitoring suhu minimal dua kali sehari." t="Vaksin/CCP disimpan pada tempat yang tidak sesuai dengan persyaratan penandaan, tidak dilengkapi termometer dan tidak dilakukan pencatatan monitoring suhu minimal dua kali sehari.">
                            <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah Vaksin/CCP disimpan pada tempat yang sesuai dengan persyaratan penandaan, dilengkapi termometer dan dilakukan pencatatan monitoring suhu minimal dua kali sehari?</td>
                            <td class="td_kritis">Tingkat Kekritisan (C)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
                        </tr>
                        <tr id="point4subh" y="Penyimpanan vaksin dilengkapi dengan  generator otomatis yang berfungsi dengan baik atau mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam." t="Penyimpanan vaksin tidak dilengkapi dengan generator otomatis yang berfungsi dengan baik atau tidak mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam.">
                            <td class="td_no">h.&nbsp;</td><td class="td_aspek">Apakah penyimpanan vaksin dilengkapi dengan generator otomatis yang berfungsi dengan baik? Atau Apakah mempunyai petugas  yang dapat menjamin generator yang tidak otomatis berfungsi dengan baik selama 24 jam?</td>
                            <td class="td_kritis">Tingkat Kekritisan (C)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
                        </tr>
                        <tr id="point4subi" y="Obat yang kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                            <td class="td_no">i.&nbsp;</td><td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
                        </tr>
                        <tr id="point4subj" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik." t="Jumlah dalam kartu stok tidak sesuai dengan jumlah fisik.">
                          <td class="td_no">j.</td>
                          <td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
                      </tr>
                    </table>
                    <h2 class="small">5. Penyaluran</h2>
                    <table class="form_tabel" group="5. Penyaluran">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point5suba" y="Setiap penyaluran obat berdasarkan resep dari dalam puskesmas tersebut." t="Semua atau sebagian penyaluran obat tidak berdasarkan resep dari dalam puskesmas tersebut.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah setiap penyaluran obat berdasarkan resep dari dalam puskesmas tersebut?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
                        </tr>
                        <tr id="point5subb" y="Resep diarsipkan berdasarkan nomor urut dan tanggal pengeluaran." t="Resep tidak diarsipkan berdasarkan nomor urut dan tanggal pengeluaran.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah resep diarsipkan berdasarkan nomor urut dan tanggal pengeluaran? </td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
                        </tr>
                        <tr id="point5subc" y="Obat yang disalurkan dikontrol oleh tenaga teknis kefarmasian." t="Obat yang disalurkan tidak dikontrol oleh tenaga teknis kefarmasian.">
                            <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah obat yang disalurkan dikontrol oleh tenaga teknis kefarmasian? </td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[27]; ?></td>
                        </tr>
                        <tr id="point5subd" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar" t="Obat-obat yang disalurkan adalah obat-obat yang tidak terdaftar">
                            <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
                            <td class="td_kritis">Tingkat Kekritisan (C)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[28]; ?></td>
                        </tr>
                    </table>
                    <h2 class="small">6. Penanganan Produk Kembalian dan Kadaluarsa</h2>
                    <table class="form_tabel" group="6. Penanganan Produk Kembalian dan Kadaluarsa">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point6suba" y="Setelah menerima informasi recall dari distributor, puskesmas segera menghentikan penjualan dan mengembalikan ke distributor." t="Setelah menerima informasi recall dari distributor, puskesmas tidak segera menghentikan penjualan dan mengembalikan ke distributor.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah setelah menerima informasi recall dari sumber pengadaan, puskesmas segera menghentikan penjualan dan mengembalikan ke sumber pengadaan? </td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[29]; ?></td>
                        </tr>
                        <tr id="point6subb" y="Pengembalian obat ke distributor disertai dengan faktur pembelian." t="Pengembalian obat ke distributor tidak disertai dengan faktur pembelian. ">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah pengembalian obat ke sumber pengadaan disertai dengan faktur pembelian/Surat Penyerahan Barang?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[30]; ?></td>
                        </tr>
                        <tr id="point6subc" y="Obat yang telah kadaluarsa disimpan terpisah dengan obat layak pakai." t="Obat yang telah kadaluarsa tidak disimpan terpisah dengan obat layak pakai.">
                            <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah obat yang telah kadaluarsa disimpan terpisah dengan obat layak pakai?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[31]; ?></td>
                        </tr>
                    </table>
                    <h2 class="small">7. Pemusnahan</h2>
                    <table class="form_tabel" group="7. Pemusnahan">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                        <tr id="point7suba" y="Pemusnahan obat dilaksanakan sesuai dengan ketentuan." t="Pemusnahan obat tidak dilaksanakan sesuai dengan ketentuan.">
                            <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah pemusnahan obat dilaksanakan sesuai dengan ketentuan?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[32]; ?></td>
                        </tr>
                        <tr id="point7subb" y="Perencanaan dan pelaksanaan pemusnahan dilaporkan kepada instansi pemerintah yang berwenang dengan melampirkan Berita Acara Pelaksanaan Pemusnahan." t="Perencanaan dan pelaksanaan pemusnahan tidak dilaporkan kepada instansi pemerintah yang berwenang dengan melampirkan Berita Acara Pelaksanaan Pemusnahan.">
                            <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah perencanaan dan pelaksanaan pemusnahan dilaporkan kepada Dinas Kesehatan Kabupaten/Kota? </td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[33]; ?></td>
                        </tr>
                        <tr id="point7subc" y="Untuk tiap pemusnahan obat dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang." t="Semua atau sebagian pemusnahan obat tidak dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari instansi pemerintah yang berwenang.">
                            <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah untuk tiap pemusnahan obat dibuatkan Berita Acara Pelaksanaan Pemusnahan yang ditandatangani oleh pelaksana pemusnahan dan saksi dari Balai Besar/Balai POM atau Dinas Kesehatan Kabupaten/Kota?</td>
                            <td class="td_kritis">Tingkat Kekritisan (M)</td>
                            <td class="td_kritis"><?php echo $aspek_penilaian[34]; ?></td>
                        </tr>
                    </table>
                    <h2 class="small">8. Lain - Lain</h2>
                  <table class="form_tabel" group="8. Lain-lain">
                    <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
                      <tr id="point8" y="Dilakukan pelaporan narkotika dan psikotropika setiap bulan ke instansi pemerintah yang berwenang." t="Tidak dilakukan pelaporan narkotika dan psikotropika setiap bulan ke instansi pemerintah yang berwenang.">
                          <td class="td_no">&nbsp;</td><td class="td_aspek">Apakah dilakukan pelaporan narkotika dan psikotropika setiap bulan ke Dinas Kesehatan Kabupaten/Kota? </td>
                          <td class="td_kritis">Tingkat Kekritisan (M)</td>
                          <td class="td_kritis"><?php echo $aspek_penilaian[35]; ?></td>
                      </tr>
                  </table>
                <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
                <table id="form_tabel">
                      	<tr><td class="td_left">&nbsp;</td><td class="td_right"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])):'';?></td></tr>
                </table>
				</div>
        </div>
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
                      <?php echo array_key_exists('KASUS_POINT_H', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_H'])):'';?>
                 </div>
          </div><!-- Akhir Kasus!-->
          </div>

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
              </ul></td></tr>
              <tr><td class="td_left">Hasil Temuan</td><td class="right">
              <ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $temuan)."</li>"; ?></ul></td></tr>
              <tr><td class="td_left">Catatan Hasil Pemeriksaan</td><td class="right"><?php echo array_key_exists('CATATAN_HASIL_PEMERIKSAAN', $sess)?$sess['CATATAN_HASIL_PEMERIKSAAN']:'';?></td></tr>
          </table>
          </div>
          </div><!-- Akhir Hasil !-->
        
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
                          <tr class="1" urut="1"><td class="td_left">Detil Tindak Lanjut Pusat</td><td class="td_right"><textarea name="<?php echo $obj_distribusi; ?>[DETIL_TINDAK_LANJUT_PUSAT]" class="stext chk" title="Detail Saran Tindak Lanjut Pusat"><?php echo $sess['DETIL_TINDAK_LANJUT_PUSAT']; ?></textarea></td></tr>
                          
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
<div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f03RS_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<div id="clear_fix"></div>
<input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
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
