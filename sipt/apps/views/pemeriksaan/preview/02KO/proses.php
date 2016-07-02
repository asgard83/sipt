<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">

<form name="f02KO_" id="f02KO_" method="post" action="<?php echo $act; ?>" autocomplete="off">

<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <table class="form_tabel">
                <tr><td class="td_left">Nama Sarana Distribusi / Toko</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td></tr>
                <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul></td></tr>
                <tr><td class="td_left">Alamat Gudang</td><td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?></ul></td></tr>
                <tr><td class="td_left">Telepon</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul></td></tr>
                <tr><td class="td_left">Nama Pimpinan</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
                <tr><td class="td_left">Nama Penanggung Jawab</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
                </table>
                <h2 class="small">Izin yang Dimiliki</h2>
                <div id="div_izin" url="<?php echo $url_izin;?>"></div>     
                <div style="height:5px;"></div>               
                <h2 class="small">Informasi Petugas Pemeriksa</h2>
                <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                <div style="height:5px;"></div>
                <h2 class="small">Informasi Pemeriksaan</h2>
                <table class="form_tabel">
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
                <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
                </table>
                </div>
        </div><!-- Akhir Informasi Pemeriksaan !-->
		
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETIL PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small">I. Klasifikasi</h2>
                <table class="form_tabel">
                    <tr><td width="10"></td>
                      <td width="405" class="isi">1.1. Bertindak sebagai</td>
                      <td class="atas"><?php echo $sess['KLASIFIKASI_PEMERIKSAAN']; ?></td>
                      </tr>
                </table>

                <h2 class="small">II. Administrasi</h2>
                <div class="importir" <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Importir Kosmetika"){ echo 'style=""';}else{ echo 'style="display:none;"';}?> >
                <table class="form_tabel">
                    <tr><td width="10"></td>
                      <td colspan="2" class="isi">&bull; Bertindak sebagai importir</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      </tr>
                    <tr id="F02KO_point21a">
                      <td></td>
                      <td width="20" class="atas">a.</td>
                      <td width="385" class="atas">Memiliki  surat penunjukan dari produsen / distributor di luar negeri</td>
                      <td class="atas"><?php echo $aspek_check[0]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[0]; ?></td>
                      </tr>
                    <tr id="F02KO_point21b">
                      <td></td>
                      <td class="atas">b.</td>
                      <td class="atas">Memiliki  Angka Pengenal Importir (API)</td>
                      <td class="atas"><?php echo $aspek_check[1]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[1]; ?></td>
                      </tr>
                    <tr id="F02KO_point21c">
                      <td></td>
                      <td class="atas">c.</td>
                      <td class="atas">Memiliki dokumen persetujuan pendaftaran</td>
                      <td class="atas"><?php echo $aspek_check[2]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[2]; ?></td>
                      </tr>
                    <tr id="F02KO_point21d">
                      <td></td>
                      <td class="atas">d.</td>
                      <td class="atas">Mempunyai  Dokumen Informasi Produk (DIP) </td>
                      <td class="atas"><?php echo $aspek_check[3]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[3]; ?></td>
                      </tr>
                    <tr id="F02KO_point21e">
                      <td></td>
                      <td class="atas">e.</td>
                      <td class="atas">Memiliki  Surat Keterangan Impor (SKI)</td>
                      <td class="atas"><?php echo $aspek_check[4]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[4]; ?></td>
                      </tr>
                    <tr id="F02KO_point21f">
                      <td></td>
                      <td class="atas">f.</td>
                      <td class="atas">Memiliki  faktur pembelian / pesanan</td>
                      <td class="atas"><?php echo $aspek_check[5]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[5]; ?></td>
                      </tr>
                    <tr id="F02KO_point21g">
                      <td></td>
                      <td class="atas">g.</td>
                      <td class="atas">Mengeluarkan  faktur / bon penjualan </td>
                     <td class="atas"><?php echo $aspek_check[6]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[6]; ?></td>
                      </tr>
                    <tr id="F02KO_point21h">
                      <td></td>
                      <td class="atas">h.</td>
                      <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
                      <td class="atas"><?php echo $aspek_check[7]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[7]; ?></td>
                      </tr> 
                   <tr id="F02KO_point21i">
                      <td></td>
                      <td class="atas">i.</td>
                      <td class="atas">Surat Keterangan GMP Produsen luar negeri</td>
                      <td class="atas"><?php echo $aspek_check[8]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[8]; ?></td>
                      </tr>
				   <tr id="F02KO_point21j">
                      <td></td>
                      <td class="atas">j.</td>
                      <td class="atas">Certificate of Free Sale (CFS)</td>
                      <td class="atas"><?php echo $aspek_check[43]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[43]; ?></td>
                      </tr>  
                     </table>
                </div>
                
                <div <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Badan Usaha / Perorangan Sebagai Pemohon Notifikasi Kosmetika" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Penjualan kosmetik melalui media elektronik"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?> class="badan">
                <table class="form_tabel">
                    <tr>
                      <td width="10"></td>
                      <td colspan="4" class="isi">&bull; Bertindak  sebagai Badan  Usaha / Usaha Perorangan Sebagai Pemohon  notifikasi kosmetika</td>
                      </tr>
                    <tr id="F02KO_point22a">
                      <td></td>
                      <td width="20" class="atas">a.</td>
                      <td width="385" class="atas">Memiliki  surat perjanjian kontrak produksi</td>
                      <td class="atas"><?php echo $aspek_check[9]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[9]; ?></td>
                      </tr>
                    <tr id="F02KO_point22b">
                      <td></td>
                      <td class="atas">b.</td>
                      <td class="atas">Memiliki dokumen persetujuan pendaftaran</td>
                      <td class="atas"><?php echo $aspek_check[10]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[10]; ?></td>
                      </tr>
                    <tr id="F02KO_point22c">
                      <td></td>
                      <td class="atas">c.</td>
                      <td class="atas">Mempunyai  Dokumen Informasi Produk (DIP)</td><td class="atas"><?php echo $aspek_check[11]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[11]; ?></td>
                      </tr>
                    <tr id="F02KO_point22d">
                      <td></td>
                      <td class="atas">d.</td>
                      <td class="atas">Memiliki  faktur pembelian / pesanan</td><td class="atas"><?php echo $aspek_check[12]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[12]; ?></td>
                      </tr>
                    <tr id="F02KO_point22e">
                      <td></td>
                      <td class="atas">e.</td>
                      <td class="atas">Mengeluarkan  faktur / bon penjualan </td>
                      <td class="atas"><?php echo $aspek_check[13]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[13]; ?></td>
                      </tr>
                    <tr id="F02KO_point22f">
                      <td></td>
                      <td class="atas">f.</td>
                      <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
                      <td class="atas"><?php echo $aspek_check[14]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[14]; ?></td>
                      </tr>
					  <tr id="F02KO_point22g">
                      <td></td>
                      <td class="atas">g.</td>
                      <td class="atas">Sertifikat CPKB penerima kontrak produksi</td>
                      <td class="atas"><?php echo $aspek_check[15]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[15]; ?></td>
                      </tr>
                </table>
                </div>
                
                <div <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Distribusi" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Distributor" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Agen" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Stokist MLM" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Klinik Kecantikan / Salon / Spa" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Toko Kosmetik / Swalayan / Pengecer" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Lain-lain" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Penjualan kosmetik melalui media elektronik"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?> class="distributor">
                <table class="form_tabel">
                    <tr>
                      <td width="10"></td>
                      <td colspan="2" class="isi">&bull; Bertindak sebagai Distribusi</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      </tr>
                    <tr id="F02KO_point23a">
                      <td></td>
                      <td width="20" class="atas">a.</td>
                      <td width="385" class="atas">Memiliki  izin sarana yang sesuai</td>
                      <td class="atas"><?php echo $aspek_check[16]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[16]; ?></td>
                      </tr>
                    <tr id="F02KO_point23b">
                      <td></td>
                      <td class="atas">b.</td>
                      <td class="atas">Memiliki  faktur pembelian </td>
                      <td class="atas"><?php echo $aspek_check[17]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[17]; ?></td>
                      </tr>
                    <tr id="F02KO_point23c">
                      <td></td>
                      <td class="atas">c.</td>
                      <td class="atas">Mengeluarkan  bon penjualan </td>
                      <td class="atas"><?php echo $aspek_check[18]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[18]; ?></td>
                      </tr>
                    <tr id="F02KO_point23d">
                      <td></td>
                      <td class="atas">d.</td>
                      <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
                      <td class="atas"><?php echo $aspek_check[19]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[19]; ?></td>
                      </tr>
                </table>
                </div>  
                    
                <h2 class="small">III. Penyimpanan</h2>
                <div class="F02KO_gudang">
                <table class="form_tabel">
                    <tr><td width="10"></td>
                      <td colspan="2" class="isi" width="385">3.1. Tempat  penyimpanan</td>
                      <td class="atas">&nbsp;</td>
                      </tr>
                    <tr>
                      <td></td>
                      <td width="20">a.</td>
                      <td width="385">Memiliki gudang</td>
                      <td class="atas"><?php echo $aspek_check[20]; ?></td>
                      </tr>
                </table>
                </div>
                                
                <div class="detail_gudang" <?php if(is_array($aspek_check)){ if($aspek_check[20] == "Ya"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
                <table class="form_tabel">
                    <tr id="F02KO_gudang_detail1">
                      <td width="10"></td>
                      <td width="20">&nbsp;</td>
                      <td width="385">- Memiliki gudang pada alamat yang sama</td>
                      <td class="atas"><?php echo $aspek_check[21]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[20]; ?></td>
                      </tr>
                    <tr id="F02KO_gudang_detail2">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>- Memiliki  gudang pada alamat lain</td>
                      <td class="atas"><?php echo $aspek_check[22]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[21]; ?></td>
                      </tr>
                    <tr id="F02KO_gudang_detail3">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>- Memiliki  gudang yang memenuhi syarat</td>
                      <td class="atas"><?php echo $aspek_check[23]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[22]; ?></td>
                      </tr>
                    <tr id="F02KO_gudang_detail4">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;&nbsp;1.&nbsp;Kebersihan</td>
                      <td class="atas"><?php echo $aspek_check[24]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[23]; ?></td>
                      </tr>
                    <tr id="F02KO_gudang_detail5">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;&nbsp;2.&nbsp;Terhindar  dari binatang pengerat</td>
                      <td class="atas"><?php echo $aspek_check[25]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[24]; ?></td>
                      </tr>
                    <tr id="F02KO_gudang_detail6">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;&nbsp;3.&nbsp;Dilengkapi  pendingin udara untuk produk tertentu </td>
                     <td class="atas"><?php echo $aspek_check[26]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[25]; ?></td>
                      </tr>
                    <tr id="F02KO_gudang_detail7">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;&nbsp;4.&nbsp;Terhindar  dari kebocoran</td>
                      <td class="atas"><?php echo $aspek_check[27]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[26]; ?></td>
                      </tr>
                </table>
                </div>
                
                <div class="F02KO_display_produk">
                <table class="form_tabel">
                    <tr>
                      <td width="10"></td>
                      <td width="20">b.</td>
                      <td width="385">Tempat  display produk</td>
                      <td class="atas"><?php echo $aspek_check[28]; ?></td>
                      </tr>
                </table>
                </div>
                
                <div class="detail_display"<?php if(is_array($aspek_check)){ if($aspek_check[28] == "Ya"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
                <table class="form_tabel">
                    <tr id="F02KO_display_produk_detail1">
                      <td width="10"></td>
                      <td width="20">&nbsp;</td>
                      <td width="385">- Lemari / tempat tertutup</td>
                      <td class="atas"><?php echo $aspek_check[29]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[27]; ?></td>
                      </tr>
                    <tr id="F02KO_display_produk_detail2">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>- Rak</td>
                      <td class="atas"><?php echo $aspek_check[30]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[28]; ?></td>
                      </tr>
                    <tr id="F02KO_display_produk_detail3">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>- Lain-lain</td>
                     <td class="atas"><?php echo $aspek_check[31]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[29]; ?></td>
                      </tr>
                </table>
                </div>
                
                
                <div class="F02KO_display_produk1">
                <table class="form_tabel">
                    <tr>
                      <td width="10"></td>
                      <td width="20">c.</td>
                      <td width="385">Tempat display produk memenuhi syarat</td>
                      <td class="atas"><?php echo $aspek_check[32]; ?></td>
                      </tr>
                </table>
                </div>
                
                <div class="detail_syarat" <?php if(is_array($aspek_check)){ if($aspek_check[32] == "Ya"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
                <table class="form_tabel">
                    <tr id="F02KO_display_produk1_detail1">
                      <td width="10"></td>
                      <td width="20">&nbsp;</td>
                      <td width="385">1. Kebersihan</td>
                      <td class="atas"><?php echo $aspek_check[33]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[30]; ?></td>
                      </tr>
                    <tr id="F02KO_display_produk1_detail2">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>2. Terhindar  dari binatang pengerat</td>
                      <td class="atas"><?php echo $aspek_check[34]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[31]; ?></td>
                      </tr>
                    <tr id="F02KO_display_produk1_detail3">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>3. Dilengkapi  pendingin udara untuk produk tertentu</td>
                      <td class="atas"><?php echo $aspek_check[35]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[32]; ?></td>
                      </tr>
                    <tr id="F02KO_display_produk1_detail4">
                      <td></td>
                      <td>&nbsp;</td>
                      <td>4. Terhindar  dari kebocoran</td>
                      <td class="atas"><?php echo $aspek_check[36]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[33]; ?></td>
                      </tr>
                </table>
                </div>
                
                <div class="F02KO_penyimpanan">
                <table class="form_tabel">
                    <tr>
                      <td></td>
                      <td colspan="2" class="isi">3.2. Cara  penyimpanan/penyusunan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      </tr>
                    <tr id="F02KO_point321">
                      <td width="10"></td>
                      <td width="20" class="atas">a.</td>
                      <td width="385" class="atas">Khusus/  tersendiri</td>
                    <td class="atas"><?php echo $aspek_check[37]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[34]; ?></td>
                      </tr>
                    <tr id="F02KO_point322">
                      <td></td>
                      <td class="atas">b.</td>
                      <td class="atas">Cara  meletakkan produk teratur</td>
                      <td class="atas"><?php echo $aspek_check[38]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[35]; ?></td>
                      </tr>
                    <tr id="F02KO_point323">
                      <td class="atas"></td>
                      <td class="atas">c.</td>
                      <td>Mengikuti sistem FIFO</td>
                      <td class="atas"><?php echo $aspek_check[39]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[36]; ?></td>
                      </tr>
                    <tr id="F02KO_point324">
                      <td></td>
                      <td class="atas">d.</td>
                      <td class="atas">Mengikuti  sistem FEFO</td>
                      <td class="atas"><?php echo $aspek_check[40]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[37]; ?></td>
                      </tr>
                    <tr id="F02KO_point325">
                      <td></td>
                      <td class="atas">e.</td>
                      <td class="atas">Bercampur  dengan produk  lain</td>
                      <td class="atas"><?php echo $aspek_check[41]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[38]; ?></td>
                      </tr>
                    <tr id="F02KO_point326">
                      <td></td>
                      <td class="atas">f.</td>
                      <td class="atas">Bercampur  dengan barang lain</td>
                      <td class="atas"><?php echo $aspek_check[42]; ?></td>
                      <td class="atas"><?php echo $aspek_keterangan[39]; ?></td>
                      </tr>
                </table>
                </div> 
                
                <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
                <table id="form_tabel">
                  <tr><td class="td_left">&nbsp;</td><td class="td_right"><?php echo $sess['HASIL_TEMUAN_LAIN'];?></td></tr>
                </table>
                
                </div>
        </div><!-- Akhir Detil Pemeriksaan !-->
        
        <div class="importir_dip" <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Importir Kosmetika"){ echo 'style=""';}else{ echo 'style="display:none;"';}?>>
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PEMERIKSAAN DIP</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Pemeriksaan DIP</h2>
                <table class="form_tabel">
                	<tr><td>Bagian I : Dokumen Administrasi & Ringkasan Produk</td></tr>
                    <tr><td><?php echo $sess['HASIL_DIP_A']; ?></td></tr>
                    <tr><td>Bagian II : Data Mutu Keamanan dan Bahan Kosmetik</td></tr>
                    <tr><td><?php echo $sess['HASIL_DIP_B']; ?></td></tr>
                    <tr><td>Bagian III : Data Mutu Kosmetik</td></tr>
                    <tr><td><?php echo $sess['HASIL_DIP_C']; ?></td></tr>
                    <tr><td>Bagian IV : Data Keamanan dan Kemanfaatan Kosmetik</td></tr>
                    <tr><td colspan="2"><?php echo $sess['HASIL_DIP_D']; ?></td></tr>
                </table>
                </div>
        </div><!-- Akhir DIP !-->
        </div>


        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
                    <table width="99%" id="F02KO_temuankos" cellpadding="0" cellspacing="0" class="listtemuan">
                        <thead>
                            <tr>
                            <th>Detil Kosmetik</th><th>Klasifikasi</th><th>Nama<br />Perusahaan</th><th>Kategori<br />Temuan</th>
                            <th>Jenis <br /> Pelanggaran</th>
                            <th>Harga Total</th><th>Keterangan<br />(sumber perolehan)</th></tr>
                        </thead>
                        <tbody id="F02KO_temuanbodykos">
					<?php
					    if(!$temuan_produk==''){
							if($sess['JMLTEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
                                    <tr id="baris<?php echo $i; ?>"><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>No. Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Batch : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><br>Netto : <?php echo $temuan_produk[$i]['NETTO']; ?><br>Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>&nbsp;<?php echo $temuan_produk[$i]['SATUAN']; ?></td><td><?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br><?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td><?php echo $temuan_produk[$i]['KATEGORI']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?><br />Tindakan Produk : <?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>
                                    <?php
								}
							}else{
								$temuan_produk = "";
							}
						}
					  ?></tbody>
                    </table>
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        
		<div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN dan TINDAK LANJUT</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan</h2>
                <table id="F02KO_tbhasil" class="form_tabel">
                <?php
				if($isEditTLBalai){//Operator
					?>
                    <tr><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo $sess['HASIL']; ?></td></tr>
                    <tr id="row_catatan" <?php if($sess['HASIL'] == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Catatan<td class="td_right"><?php echo $sess['CATATAN']; ?></td></tr>
                    <tr id="row_tmk" <?php if($sess['HASIL'] == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Detil Hasil Pemeriksaan</td><td class="td_right"><?php if(trim($sess["DETIL_HASIL"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $detil_hasil = explode("#", $sess['DETIL_HASIL']); echo "<li>".join("</li><li>", $detil_hasil)."</li>"; ?></ul><?php } ?></td></tr>
                    <tr id="row_dttmk"><td class="td_left" id="F02OT_tdlabeldetiltmk">Detil Kesimpulan TMK</td><td class="td_right" id="F02OT_tddetiltmk"><?php echo  preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KESIMPULAN_DETIL_TMK'])); ?></td></tr>
                    <?php
				}else{
					?>
                    <tr><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN_DIST_KOS[HASIL]', $hasil, array_key_exists('HASIL', $sess)?$sess['HASIL']:'', 'id="F02KO_hasil" class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td></tr>
                    <tr id="row_catatan" <?php if($sess['HASIL'] == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Catatan<td class="td_right"><textarea class="stext catatan" title="Catatan" name="<?php echo $obj_kos; ?>[CATATAN]"><?php echo $sess['CATATAN']; ?></textarea></td></tr>
                    <tr id="row_tmk" <?php if($sess['HASIL'] == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left">Detil Hasil Pemeriksaan</td><td class="td_right"><span class="F02KO_mk" style="display:none;"></span><span class="F02KO_temuan_kos"><?php echo form_dropdown($obj_kos.'[DETIL_HASIL][]',$detil_hasil,is_array($sel_tmk)?$sel_tmk:'','id="F02KO_detiltmk" class="stext multiselect" multiple title="Detil hasil pemeriksaan. Jika lebih dari satu tekan klik + Ctrl"'); ?></span></td></tr>                    
                    <tr id="row_dttmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>><td class="td_left" id="F02KO_tdlabeldetiltmk">Detil Kesimpulan TMK</td><td class="td_right" id="F02OT_tddetiltmk"><textarea class="stext chk" name="PEMERIKSAAN_DIST_KOS[KESIMPULAN_DETIL_TMK]" id="F02KO_detilkesimpulantmk" title="Detil Kesimpulan TMK"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KESIMPULAN_DETIL_TMK'])); ?></textarea></td></tr>
                
                    <?php
				}
				?>
                </table>
                
                <h2 class="small">Tindak Lanjut</h2>
                <table class="form_tabel">
                <?php
				if($isEditTL){
					?>
                    <tr><td class="td_left">Tindak lanjut Balai</td><td class="td_right"><?php if(trim($sess["TINDAKAN_SARANA"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $tl_balai = explode("#", $sess['TINDAKAN_SARANA']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul><?php } ?></td></tr>
                    <tr><td class="td_left">Saran Tindak Lanjut Balai</td><td class="td_right"><?php echo  preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['SARAN_TL'])); ?></td></tr>
                    <?php
					if(strlen($sess['TINDAKAN_PUSAT'])!=""){
						?>
                        <tr><td class="td_left">Tindak lanjut Pusat</td><td class="td_right"><?php echo $sess['TINDAKAN_PUSAT']; ?></td></tr>
                        <?php
					}else{
						?>
                        <tr><td class="td_left">Tindak lanjut Pusat</td><td class="td_right">-</td></tr>
                        <?php
					}
				}else{
				?>
                <tr><td class="td_left">Tindak lanjut Balai</td><td class="td_right"><?php echo form_dropdown($obj_kos.'[TINDAKAN_SARANA][]',$tindakan_sarana,is_array($sel_tindakan_sarana)?$sel_tindakan_sarana:'','class="stext multiselect" multiple title="Tindak lanjut terhadap sarana. Jika lebih dari satu klik + Ctrl"'); ?></td></tr>
                <tr><td class="td_left">Saran Tindak Lanjut Balai</td><td class="td_right"><textarea class="stext chk" title="Saran Tindak Lanjut" name="<?php echo $obj_kos; ?>[SARAN_TL]"><?php echo  preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['SARAN_TL'])); //$sess['SARAN_TL']; ?></textarea></td></tr>
                <?php } ?>
                </table>
                
                
                <h2 class="small">Hasil Pusat</h2>
                <table class="form_tabel">
                <?php 
				if($this->newsession->userdata('SESS_BBPOM_ID') == "94" && $BBPOM_ID != "94"){
				?>
                <tr>
                  <td class="td_left">Hasil</td><td class="td_right"><?php echo form_dropdown($obj_kos.'[HASIL_PUSAT]',$hasil,$sess['HASIL_PUSAT'],'class="stext" title="Rekomendasi Hasil Pusat"'); ?></td></tr>
				<tr><td class="td_left"> Tindak Lanjut</td><td class="td_right"><?php echo form_dropdown($obj_kos.'[TINDAKAN_PUSAT]',$tindakan_sarana,$sess['TINDAKAN_PUSAT'],'class="stext" title="Rekomendasi Tindak Lanjut Pusat"'); ?></td></tr>
                <tr>
                  <td class="td_left">Catatan</td><td class="td_right"><textarea class="stext chk" title="Catatan rekomendasi pusat" name="<?php echo $obj_kos; ?>[CATATAN_PUSAT]"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN_PUSAT'])); ?></textarea></td></tr>
				<?php }else{ ?>
                <tr><td class="td_left"> Hasil</td><td class="td_right"><?php echo $sess['HASIL_PUSAT']; ?></td></tr>
				<tr><td class="td_left"> Tindak Lanjut</td><td class="td_right"><?php echo $sess['TINDAKAN_PUSAT']; ?></td></tr>
                <tr><td class="td_left">Catatan </td><td class="td_right"><?php echo  preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN_PUSAT'])); ?></td></tr>
                <?php } ?>
                </table>
                 
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        
		<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Verifikasi Pemeriksaan</h2>
                <?php if($isverifikasi) { ?>
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
<div><?php if($isverifikasi) { ?><a href="#" class="button check" onclick="fpost('#f02KO_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" /><input type="hidden" name="redir" value="<?php echo $redir; ?>" />
<div id="clear_fix"></div>
</form>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		create_ck("textarea.chk",505)
		$("#div_izin").html('Loading..');
		$("#div_izin").load($("#div_izin").attr("url"));
		$("#detail_petugas").html("Loading ...");
		$("#detail_petugas").load($("#detail_petugas").attr("url"));
	});
</script>