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
                	<tr><td class="td_left">Nama Sarana Produksi</td><td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td></tr>
                    <tr><td class="td_left">Pemilik / Pimpinan</td><td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:""; ?></td></tr>
                    <tr><td class="td_left">Alamat Lokasi Sarana</td><td class="td_right"><?php echo array_key_exists('ALAMAT_1', $sess)?$sess['ALAMAT_1']:""; ?></td></tr>
                    <tr><td class="td_left">Nomor Izin</td><td class="td_right"><?php echo array_key_exists('NOMOR_IZIN', $sess)?$sess['NOMOR_IZIN']:""; ?></td></tr>
                    <tr><td class="td_left">Jumlah Karyawan</td><td class="td_right"><?php echo array_key_exists('JUMLAH_KARYAWAN', $sess)?$sess['JUMLAH_KARYAWAN']:"-"; ?>&nbsp;Orang</td></tr>
                    <tr><td class="td_left">Umur Bangunan</td><td class="td_right"><?php echo array_key_exists('UMUR_BANGUNAN', $sess)?$sess['UMUR_BANGUNAN']:"-"; ?>&nbsp;Tahun</td></tr>
                    <tr><td class="td_left">Status Sarana</td><td class="td_right"><?php 
					if($sess['STATUS_SARANA'] == "1")
					  echo "Aktif";
					else
					  echo "Tidak Aktif / Tidak Berpoduksi";
					?></td></tr>
                </table>                
                <h2 class="small">Jenis Pangan</h2>
                <div id="detail_jenis" url="<?php echo $url_jenis;?>"></div>
                <h2 class="small">Informasi Petugas Pemeriksa</h2>
                <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                <div style="height:5px;"></div>
                <h2 class="small">Informasi Pemeriksaan</h2>
                <table class="form_tabel">
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
                </table>
                <h2 class="small"><a href="#" url="<?php echo $history_periksa; ?>" onclick="expand_detail($(this), 'detail_periksa'); return false;" id="detail_hisotry">Pemeriksaan Sebelumnya</a></h2>
                <div id="detail_periksa"></div>

                </div>
        </div><!-- Akhir Informasi Sarana !-->
        
        <div id="aspek_penilaian" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>   
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">ASPEK PENILAIAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Penilaian</h2>
                <h2 class="small">GRUP A - Lingkungan Produksi</h2>
                <table id="pointa" class="form_tabel">
                    <tr id="a1"><td class="atas" width="12">1.</td><td class="atas" width="403">Semak</td><td class="atas"><?php echo $aspek_penilaian[0]; ?></td></tr>
                    <tr id="a2">
                      <td class="atas">2.</td>
                      <td class="atas">Tempat Sampah</td>
                      <td class="atas"><?php echo $aspek_penilaian[1]; ?></td>
                      </tr>
                    <tr id="a3">
                      <td class="atas">3.</td>
                      <td class="atas">Sampah</td>
                      <td class="atas"><?php echo $aspek_penilaian[2]; ?></td>
                      </tr>
                    <tr id="a4">
                      <td class="atas">4.</td>
                      <td class="atas">Selokan</td>
                      <td class="atas"><?php echo $aspek_penilaian[3]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td><td class="atas" width="403">Kesimpulan Grup A</td><td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[0]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP B - Bangunan dan Fasilitas</h2>
                <table id="pointb" class="form_tabel">
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">B1 Ruang Produksi</td>
                      </tr>
                    <tr id="b1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Konstruksi Lantai</td><td class="atas"><?php echo $aspek_penilaian[4]; ?></td></tr>
                    <tr id="b2">
                      <td class="atas">2.</td>
                      <td class="atas">Kebersihan Lantai</td>
                      <td class="atas"><?php echo $aspek_penilaian[5]; ?></td>
                      </tr>
                    <tr id="b3">
                      <td class="atas">3.</td>
                      <td class="atas">Konstruksi Dinding</td>
                      <td class="atas"><?php echo $aspek_penilaian[6]; ?></td>
                      </tr>
                    <tr id="b4">
                      <td class="atas">4.</td>
                      <td class="atas">Kebersihan Dinding</td>
                      <td class="atas"><?php echo $aspek_penilaian[7]; ?></td>
                      </tr>
                    <tr id="b5">
                      <td class="atas">5.</td>
                      <td class="atas">Konstruksi Langit-langit</td>
                      <td class="atas"><?php echo $aspek_penilaian[8]; ?></td>
                      </tr>
                    <tr id="b6">
                      <td class="atas">6.</td>
                      <td class="atas">Kebersihan Langit-langit</td>
                      <td class="atas"><?php echo $aspek_penilaian[9]; ?></td>
                      </tr>
                    <tr id="b7">
                      <td class="atas">7.</td>
                      <td class="atas">Konstruksi Pintu, Jendela dan Lubang Angin</td>
                      <td class="atas"><?php echo $aspek_penilaian[10]; ?></td>
                      </tr>
                    <tr id="b8">
                      <td class="atas">8.</td>
                      <td class="atas">Kebersihan Pintu, Jendela dan Lubang Angin</td>
                      <td class="atas"><?php echo $aspek_penilaian[11]; ?></td>
                      </tr>
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">B2 Kelengkapan Ruang Produksi</td>
                      </tr>
                    <tr id="b9">
                      <td class="atas">1.</td>
                      <td class="atas">Penerangan</td>
                      <td class="atas"><?php echo $aspek_penilaian[12]; ?></td>
                      </tr>
                    <tr id="b10">
                      <td class="atas">2.</td>
                      <td class="atas">PPPK</td>
                      <td class="atas"><?php echo $aspek_penilaian[13]; ?></td>
                      </tr>
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">B3 Tempat Penyimpanan</td>
                      </tr>
                    <tr id="b11">
                      <td class="atas">1.</td>
                      <td class="atas">Tempat Penyimpanan bahan dan produk</td>
                      <td class="atas"><?php echo $aspek_penilaian[14]; ?></td>
                      </tr>
                    <tr id="b12">
                      <td class="atas">2.</td>
                      <td class="atas">Tempat penyimpanan bahan bukan pangan</td>
                      <td class="atas"><?php echo $aspek_penilaian[15]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td><td class="atas" width="403">Kesimpulan Grup B</td><td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[1]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP C - Peralatan Produksi</h2>
                <table id="pointc" class="form_tabel">
                    <tr id="c1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Konstruksi</td><td class="atas"><?php echo $aspek_penilaian[16]; ?></td></tr>
                    <tr id="c2">
                      <td class="atas">2.</td>
                      <td class="atas">Tata Letak</td>
                      <td class="atas"><?php echo $aspek_penilaian[17]; ?></td>
                      </tr>
                    <tr id="c3">
                      <td class="atas">3.</td>
                      <td class="atas">Kebersihan</td>
                      <td class="atas"><?php echo $aspek_penilaian[18]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup C</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[2]:""; ?></td></tr>
                </table>
    
                
                <h2 class="small">GRUP D - Suplai Air</h2>
                <table id="pointd" class="form_tabel">
                    <tr id="d1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Sumber Air</td><td class="atas"><?php echo $aspek_penilaian[19]; ?></td></tr>
                    <tr id="d2">
                      <td class="atas">2.</td>
                      <td class="atas">Pengguna Air</td>
                      <td class="atas"><?php echo $aspek_penilaian[20]; ?></td>
                      </tr>
                    <tr id="d3">
                      <td class="atas">3.</td>
                      <td class="atas">Air yang Kontak Langsung dengan Pangan</td>
                      <td class="atas"><?php echo $aspek_penilaian[21]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup D</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[3]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP E - Fasilitas dan Kegiatan Higiene dan Sanitasi</h2>
                <table id="pointe" class="form_tabel">
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">E1 Alat Cuci / Pembersih</td>
                      </tr>
                    <tr id="e1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Ketersediaan Alat</td>
                    <td class="atas"><?php echo $aspek_penilaian[22]; ?></td></tr>
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">E2 Fasilitas Higiene Karyawan</td>
                      </tr>
                    <tr id="e2">
                      <td class="atas">1.</td>
                      <td class="atas">Tempat Cuci Tangan</td>
                      <td class="atas"><?php echo $aspek_penilaian[23]; ?></td>
                      </tr>
                    <tr id="e3">
                      <td class="atas">2.</td>
                      <td class="atas">Jamban / Toilet</td>
                      <td class="atas"><?php echo $aspek_penilaian[24]; ?></td>
                      </tr>
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">E3 Kegiatan Higiene dan Sanitasi</td>
                      </tr>
                    <tr id="e4">
                      <td class="atas">1.</td>
                      <td class="atas">Penanggung Jawab</td>
                      <td class="atas"><?php echo $aspek_penilaian[25]; ?></td>
                      </tr>
                    <tr id="e5">
                      <td class="atas">2.</td>
                      <td class="atas">Penggunaan Deterjen dan Desinfektan</td>
                      <td class="atas"><?php echo $aspek_penilaian[26]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup E</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[4]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP F - Pengendalian Hama</h2>
                <table id="pointf" class="form_tabel">
                    <tr id="f1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Hewan Peliharaan</td>
                    <td class="atas"><?php echo $aspek_penilaian[27]; ?></td></tr>
                    <tr id="f2">
                      <td class="atas">2.</td>
                      <td class="atas">Pencegahan Masuknya Hama</td>
                      <td class="atas"><?php echo $aspek_penilaian[28]; ?></td>
                      </tr>
                    <tr id="f3">
                      <td class="atas">3.</td>
                      <td class="atas">Pemberantasan Hama</td>
                      <td class="atas"><?php echo $aspek_penilaian[29]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup F</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[5]:""; ?></td></tr>
                </table>
    
    
                
                <h2 class="small">GRUP G - Kesehatan dan Higiene Karyawan</h2>
                <table id="pointg" class="form_tabel">
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">G1 Kesehatan Karyawan</td>
                      </tr>
                    <tr id="g1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Pemeriksaan Kesehatan</td>
                    <td class="atas"><?php echo $aspek_penilaian[30]; ?></td></tr>
                    <tr id="g2">
                      <td class="atas" width="12">2.</td>
                    <td class="atas" width="403">Kesehatan Karyawan</td>
                    <td class="atas"><?php echo $aspek_penilaian[31]; ?></td></tr>
                
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">G2 Kebersihan Karyawan</td>
                      </tr>
                    <tr id="g3">
                      <td class="atas">1.</td>
                      <td class="atas">Kebersihan Badan</td>
                      <td class="atas"><?php echo $aspek_penilaian[32]; ?></td>
                      </tr>
                    <tr id="g4">
                      <td class="atas">2.</td>
                      <td class="atas">Kebersihan Pakaian / Perlengkapan Kerja</td>
                      <td class="atas"><?php echo $aspek_penilaian[33]; ?></td>
                      </tr>
                    <tr id="g5">
                      <td class="atas">3.</td>
                      <td class="atas">Kebersihan Tangan</td>
                      <td class="atas"><?php echo $aspek_penilaian[34]; ?></td>
                      </tr>
                    <tr id="g6">
                      <td class="atas">4.</td>
                      <td class="atas">Perawatan Luka</td>
                      <td class="atas"><?php echo $aspek_penilaian[35]; ?></td>
                      </tr>
                    <tr id="subjudul">
                      <td colspan="3" class="atas spjudul">G3 Kebiasaan Karyawan</td>
                      </tr>
                    <tr id="g7">
                      <td class="atas">1.</td>
                      <td class="atas">Perilaku Karyawan</td>
                      <td class="atas"><?php echo $aspek_penilaian[36]; ?></td>
                      </tr>
                    <tr id="g8">
                      <td class="atas">2.</td>
                      <td class="atas">Perhiasan dan Asesoris Lainnya</td>
                      <td class="atas"><?php echo $aspek_penilaian[37]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup G</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[6]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP H - Pengendalian Proses</h2>
                <table id="pointh" class="form_tabel">
                    <tr id="h_1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Penetapan Spesifikasi Bahan Baku</td>
                    <td class="atas"><?php echo $aspek_penilaian[38]; ?></td></tr>
                    <tr id="h_2">
                      <td class="atas">2.</td>
                      <td class="atas">Penetapan Komposisi dan Formulasi Bahan</td>
                      <td class="atas"><?php echo $aspek_penilaian[39]; ?></td>
                      </tr>
                    <tr id="h_3">
                      <td class="atas">3.</td>
                      <td class="atas">Penetapan cara Produksi yang Baku</td>
                      <td class="atas"><?php echo $aspek_penilaian[40]; ?></td>
                      </tr>
                    <tr id="h_4">
                      <td class="atas">4. </td>
                      <td class="atas">Penetapan Spesifikasi Kemasan</td>
                      <td class="atas"><?php echo $aspek_penilaian[41]; ?></td>
                      </tr>
                    <tr id="h_5">
                      <td class="atas">5. </td>
                      <td class="atas">Penetapan Tanggal Kadaluarsa dan Kode Produksi</td>
                      <td class="atas"><?php echo $aspek_penilaian[42]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup H</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[7]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP I - Label Pangan</h2>
                <table id="pointi" class="form_tabel">
                    <tr id="i1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Persyaratan Label</td>
                    <td class="atas"><?php echo $aspek_penilaian[43]; ?></td></tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup I</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[8]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP J - PENYIMPANAN</h2>
                <table id="pointj" class="form_tabel">
                    <tr id="j1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Penyimpanan Bahan dan Produk</td>
                    <td class="atas"><?php echo $aspek_penilaian[44]; ?></td></tr>
                    <tr id="j2">
                      <td class="atas">2.</td>
                      <td class="atas">Tata Cara Penyimpanan</td>
                      <td class="atas"><?php echo $aspek_penilaian[45]; ?></td>
                      </tr>
                    <tr id="j3">
                      <td class="atas">3.</td>
                      <td class="atas">Penyimpanan Bahan Berbahaya</td>
                      <td class="atas"><?php echo $aspek_penilaian[46]; ?></td>
                      </tr>
                    <tr id="j4">
                      <td class="atas">4. </td>
                      <td class="atas">Penyimpanan Label dan Kemasan</td>
                      <td class="atas"><?php echo $aspek_penilaian[47]; ?></td>
                      </tr>
                    <tr id="j5">
                      <td class="atas">5. </td>
                      <td class="atas">Penyimpanan Peralatan</td>
                      <td class="atas"><?php echo $aspek_penilaian[48]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup J</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[9]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP K - Manajemen Pengawasan</h2>
                <table id="pointk" class="form_tabel">
                    <tr id="k1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Penanggung Jawab</td>
                    <td class="atas"><?php echo $aspek_penilaian[49]; ?></td></tr>
                    <tr id="k2">
                      <td class="atas">2.</td>
                      <td class="atas">Pengawasan</td>
                      <td class="atas"><?php echo $aspek_penilaian[50]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup K</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[10]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP L - Pencatatan dan Dokumentasi</h2>
                <table id="pointl" class="form_tabel">
                    <tr id="l1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Pencatatan dan Dokumentasi</td>
                    <td class="atas"><?php echo $aspek_penilaian[51]; ?></td></tr>
                    <tr id="l2">
                      <td class="atas">2.</td>
                      <td class="atas">Penyimpanan Catatan dan Dokumentasi</td>
                      <td class="atas"><?php echo $aspek_penilaian[52]; ?></td>
                      </tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup L</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[11]:""; ?></td></tr>
                </table>
                
                <h2 class="small">GRUP M - Pelatihan Karyawan</h2>
                <table id="pointm" class="form_tabel">
                    <tr id="m1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Pengetahuan Karyawan</td>
                    <td class="atas"><?php echo $aspek_penilaian[53]; ?></td></tr>
                </table>
                <table class="form_tabel">
                    <tr><td class="atas" width="12">&nbsp;</td>
                      <td class="atas" width="403">Kesimpulan Grup M</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[12]:""; ?></td></tr>
                </table> 
                
                <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
                <table id="form_tabel">
                  <tr><td class="td_left">&nbsp;</td><td class="td_right"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?$sess['HASIL_TEMUAN_LAIN']:""; ?></td></tr>
                </table>
                     
                </div>
        </div><!-- Akhir Aspek Penilaian !-->
        </div>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Hasil</td><td class="td_right"><?php echo $sess['HASIL']; ?></td></tr>
                <tr>
                  <td class="td_left">Saran</td><td class="td_right"><?php echo $sess['REKOMENDASI']; ?></td></tr>
                <tr><td class="td_left">Kesimpulan</td><td class="td_right"><?php echo $sess['KESIMPULAN']; ?></td></tr>
                </table>
				</div>
        </div><!-- Akhir Informasi Kesimpulan !-->
                
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAKAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Tindakan Balai</h2>
                <?php
				if($isEditTLBalai){
					?>
                    <table class="form_tabel">
                    <tr>
                      <td class="td_left">Tindak Lanjut</td><td class="td_right"><?php echo form_dropdown($obj_pangan.'[TINDAKAN][]',$tindakan,is_array($sel_tindakan)?$sel_tindakan:'','class="stext multiselect" multiple title="Tindak lanjut balai. Jika lebih dari satu, tekan klik + Ctrl"'); ?></td></tr>
                    <tr><td class="td_left">CAPA</td><td class="td_right"><textarea name="<?php echo $obj_pangan; ?>[CAPA]" class="stext chk" title="C A P A"><?php echo array_key_exists('CAPA', $sess)?$sess['CAPA']:''; ?></textarea></td></tr>
                    </table>
                    <?php
				}else{
					?>
                    <table class="form_tabel">
                    <tr>
                      <td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if(count(explode("#",$sess["TINDAKAN"])) > 0){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $tindakan = explode("#", $sess['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul><?php } ?></td></tr>
                    <tr><td class="td_left">CAPA</td><td class="td_right"><?php echo $sess['CAPA']; ?></td></tr>
                    </table>
                    <?php
				}
				?>
                </div>
        </div><!-- Akhir Kesimpulan !-->

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
<div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f01vv_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
<div id="clear_fix"></div>
</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
	  create_ck("textarea.chk",505)
	  $("#detail_petugas").html("Loading ...");
	  $("#detail_petugas").load($("#detail_petugas").attr("url"));				
	  $("#detail_jenis").html("Loading ...");
	  $("#detail_jenis").load($("#detail_jenis").attr("url"));
	});
</script>
