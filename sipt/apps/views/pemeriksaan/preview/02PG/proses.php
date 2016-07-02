<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f02pg_" id="f02pg_" method="post" action="<?php echo $act; ?>" autocomplete="off"> 
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Informasi Sarana</h2>
                <table class="form_tabel">
                	<tr><td class="td_left">Nama Sarana</td><td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:"-"; ?></td></tr>
                    <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo array_key_exists('ALAMAT_1', $sess)?$sess['ALAMAT_1']:""; ?></td></tr>
                    <tr><td class="td_left">Telepon</td><td class="td_right"><?php echo array_key_exists('TELEPON', $sess)?$sess['TELEPON']:"-"; ?></td></tr>
                    <tr><td class="td_left">Nama Pemilik</td><td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:"-"; ?></td></tr>
                    <tr><td class="td_left">Nomor Izin Usaha</td><td class="td_right"><?php echo $sess['IZIN_PERUSAHAAN']; ?></td></tr>
                    <tr><td class="td_left">Nomor Izin Perdagangan</td><td class="td_right"><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
                    <tr><td class="td_left">Golongan Sarana</td><td class="td_right"><?php echo array_key_exists('GOLONGAN_SARANA', $sess)?$sess['GOLONGAN_SARANA']:"-"; ?></td></tr>
                    <tr><td class="td_left">Jumlah Karyawan</td><td class="td_right"><?php echo array_key_exists('JUMLAH_KARYAWAN', $sess)?$sess['JUMLAH_KARYAWAN']:"-"; ?> &nbsp; Orang</td></tr>
                </table>
                <h2 class="small">Bertindak Sebagai</h2>
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

		<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">ASPEK PENILAIAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Penilaian</h2>
                <h2 class="small">GRUP A : Pimpinan</h2>
                <table id="pointa" class="form_tabel">
                    <tr id="a1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Kerja sama dengan pemeriksa</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[0]:''; ?></td></tr>
                </table>
    
                <h2 class="small">GRUP B : Sanitasi</h2>
                <table id="pointb" class="form_tabel">
                    <tr id="b1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Kebersihan</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[1]:''; ?></td></tr>
                    <tr id="b2">
                      <td class="atas">2.</td>
                      <td class="atas">Tempat sampah</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[2]:''; ?></td>
                  </tr>
                    <tr id="b3">
                      <td class="atas">3. </td>
                      <td class="atas">Toilet</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[3]:''; ?></td>
                  </tr>
                    <tr id="b4">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup B</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[0]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP C : Infestasi </h2>
                <table id="pointc" class="form_tabel">
                    <tr id="c1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Binatang pengerat</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[4]:''; ?></td></tr>
                    <tr id="c2">
                      <td class="atas">2.</td>
                      <td class="atas">Serangga</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[5]:''; ?></td>
                  </tr>
                    <tr id="c3">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup C</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[1]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP D : Bangunan / Ruangan</h2>
                <table id="pointd" class="form_tabel">
                    <tr id="d1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Konstruksi</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[6]:''; ?></td></tr>
                    <tr id="d2">
                      <td class="atas">2.</td>
                      <td class="atas">Pencegahan binatang pengerat</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[7]:''; ?></td>
                      </tr>
                    <tr id="d3">
                      <td class="atas">3.</td>
                      <td class="atas">Pencegahan serangga</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[8]:''; ?></td>
                      </tr>
                    <tr id="d4">
                      <td class="atas">4.</td>
                      <td class="atas">Pemeliharaan</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[9]:''; ?></td>
                    </tr>
                    <tr id="d4">
                      <td class="atas">5.</td>
                      <td class="atas">Keteraturan</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[10]:''; ?></td>
                      </tr>
                    <tr id="d5">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup D</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[2]:''; ?></td>
                      </tr>
                </table>
    
                <h2 class="small">GRUP E : Perlengkapan Peragaan</h2>
                <table id="pointe" class="form_tabel">
                    <tr id="e1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Tata letak produk</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[11]:''; ?></td></tr>
                    <tr id="e2">
                      <td class="atas">2.</td>
                      <td class="atas">Lemari penyimpanan</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[12]:''; ?></td>
                  </tr>
                    <tr id="e3">
                      <td class="atas">3.</td>
                      <td class="atas">Lemari pendingin</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[13]:''; ?></td>
                  </tr>
                    <tr id="e4">
                      <td class="atas">4.</td>
                      <td class="atas">Kontrol lemari pendingin</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[14]:''; ?></td>
                  </tr>
                    <tr id="e5">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup E</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[3]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP F : Gudang Biasa</h2>
                <table id="pointf" class="form_tabel">
                    <tr id="f1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Keteraturan</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[15]:''; ?></td></tr>
                    <tr id="f2">
                      <td class="atas">2.</td>
                      <td class="atas">Pencegahan binatang pengerat</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[16]:''; ?></td>
                  </tr>
                    <tr id="f3">
                      <td class="atas">3.</td>
                      <td class="atas">Pencegahan serangga</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[17]:''; ?></td>
                  </tr>
                    <tr id="f4">
                      <td class="atas">4.</td>
                      <td class="atas">Ventilasi</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[18]:''; ?></td>
                  </tr>
                    <tr id="f5"> 
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup F</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[4]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP G : Gudang Dingin</h2>
                <table id="pointg" class="form_tabel">
                    <tr id="g1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Keteraturan</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[19]:''; ?></td></tr>
                    <tr id="g2">
                      <td class="atas">2.</td>
                      <td class="atas">Kontrol suhu</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[20]:''; ?></td>
                  </tr>
                    <tr id="g3">
                      <td class="atas">3.</td>
                      <td class="atas">Pencegahan binatang pengerat</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[21]:''; ?></td>
                  </tr>
                    <tr id="g4">
                      <td class="atas">4.</td>
                      <td class="atas">Pencegahan serangga</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[22]:''; ?></td>
                  </tr>
                    <tr id="g5">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup G</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[5]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP H : Perlengkapan Administrasi</h2>
                <table id="pointh" class="form_tabel">
                    <tr id="h1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Keluar masuk barang</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[23]:''; ?></td></tr>
                    <tr id="h2">
                      <td class="atas">2.</td>
                      <td class="atas">Faktur Pembelian</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[24]:''; ?></td>
                  </tr>
                    <tr id="h3">
                      <td class="atas">3.</td>
                      <td class="atas">Faktur Penjualan</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[25]:''; ?></td>
                  </tr>
                    <tr id="h4">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup H</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[6]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP I : Pengawasan Penanganan</h2>
                <table id="pointi" class="form_tabel">
                    <tr id="i1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Penggunaan insektisida / rodentisida</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[26]:''; ?></td></tr>
                    <tr id="i2">
                      <td class="atas">2.</td>
                      <td class="atas">Mutu barang masuk</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[27]:''; ?></td>
                  </tr>
                    <tr id="i3">
                      <td class="atas">3.</td>
                      <td class="atas">Makanan rusak</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[28]:''; ?></td>
                  </tr>
                    <tr id="i4">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup I</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[7]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP J : Ketentuan Khusus</h2>
                <table id="pointj" class="form_tabel">
                    <tr id="j1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Lokasi</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[29]:''; ?></td></tr>
                    <tr id="j2">
                      <td class="atas">2.</td>
                      <td class="atas">Izin minuman keras</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[30]:''; ?></td>
                  </tr>
                    <tr id="j3">
                      <td class="atas">3.</td>
                      <td class="atas">Tanda peringatan khusus</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[31]:''; ?></td>
                  </tr>
                    <tr id="j4">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup J</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[8]:''; ?></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP K : Produk yang TMS</h2>
                <table id="pointk" class="form_tabel">
                    <tr id="k1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Bahan tambahan</td>
                    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[32]:''; ?></td></tr>
                    <tr id="k2">
                      <td class="atas">2.</td>
                      <td class="atas">Makanan rusak</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[33]:''; ?></td>
                  </tr>
                    <tr id="k3">
                      <td class="atas">3.</td>
                      <td class="atas">Kedaluwarsa</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[34]:''; ?></td>
                  </tr>
                    <tr id="k4">
                      <td class="atas">4.</td>
                      <td class="atas">Label menyimpang</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[35]:''; ?></td>
                  </tr>
                    <tr id="k5">
                      <td class="atas">5.</td>
                      <td class="atas">Tanda khusus</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[36]:''; ?></td>
                  </tr>
                    <tr id="k6">
                      <td class="atas">6.</td>
                      <td class="atas">Minuman keras TIE</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[37]:''; ?></td>
                  </tr>
                    <tr id="k7">
                      <td class="atas">7.</td>
                      <td class="atas">Makanan tidak terdaftar</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[38]:''; ?></td>
                  </tr>
                    <tr id="k8">
                      <td class="atas">8.</td>
                      <td class="atas">Lain-lain : sebutkan</td>
                      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[39]:''; ?></td>
                  </tr>
                    <tr id="k9">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup K</td>
                      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[9]:''; ?></td>
                  </tr>
                </table>   
                
                <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
                <table id="form_tabel">
                  <tr><td class="td_left">&nbsp;</td><td class="td_right"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])):"-"; ?></td></tr>
                </table>
                
				</div>
        </div><!-- Akhir Informasi Penilaian !-->
		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Hasil</td><td class="td_right"><?php echo $sess['HASIL']; ?></td></tr>
                <tr>
                  <td class="td_left">Saran</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['REKOMENDASI'])); ?></td></tr>
                <tr><td class="td_left">Kesimpulan</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KESIMPULAN'])); ?></td></tr>
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
                      <td class="td_left">Tindak Lanjut</td><td class="td_right"><?php echo form_dropdown($obj_pangan.'[TINDAKAN][]',$tindakan_balai,is_array($sel_tindakan)?$sel_tindakan:'','class="stext multiselect" multiple title="Tindak lanjut balai. Jika lebih dari satu, tekan klik + Ctrl"'); ?></td></tr>
                    <tr><td class="td_left">CAPA</td><td class="td_right"><textarea name="<?php echo $obj_pangan; ?>[CAPA]" class="stext chk" title="C A P A"><?php echo array_key_exists('CAPA', $sess)?$sess['CAPA']:''; ?></textarea></td></tr>
                    </table>
                    <?php
				}else{
					?>
                    <table class="form_tabel">
                    <tr>
                      <td class="td_left">Tindak Lanjut</td><td class="td_right"><?php if(trim($sess["TINDAKAN"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $tindakan = explode("#", $sess['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul><?php } ?></td></tr>
                    <tr><td class="td_left">CAPA</td><td class="td_right"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CAPA'])); ?></td></tr>
                    </table>
                    <?php
				}
				?>
                </div>
        </div><!-- Akhir Kesimpulan !-->
        
		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
                <table width="99%" id="F02PG_tabel_pangan" cellpadding="0" cellspacing="0" class="listtemuan">
                    <thead style="background:#CCC; color:#3c7faf;"><tr>
                    <th>Produsen / Importir</th>
                    <th>Nama Produk</th>
                    <th>Detil Produk</th>
                    <th>Kategori Temuan</th>
                    </tr></thead>
                    <tbody id="F02PG_bod_pangan">
					<?php
					    if(!$temuan_produk==''){
							if($sess['JUMLAH_TEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
                                    <tr><td><?php echo $temuan_produk[$i]['PRODUSEN']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?></td><td>Registrasi Produk : <?php echo $temuan_produk[$i]['REGISTRASI']; ?><br>Nomor Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?><br>Jumlah Kemasan Terkecil : <?php echo $temuan_produk[$i]['KEMASAN'];?><br>Satuan : <?php echo $temuan_produk[$i]['SATUAN'];?><br>Perkiraan Harga Total : <?php echo $temuan_produk[$i]['HARGA'];?></td><td><?php echo $temuan_produk[$i]['KATEGORI'];?></td></tr>
 									<?php
								}
							}else{
								?>
                                <tr><td colspan="4">Tidak ada temuan produk</td></tr>
                                <?php
							}
						}
					  ?>                    
                    </tbody>
                </table>
				</div>
        </div><!-- Akhir Informasi Temuan Produk !-->

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
<div> <?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f02pg_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<div id="clear_fix"></div>
<input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
</form>
</div>

<script type="text/javascript">
var rekomendasi = new Array();
$(document).ready(function(){
	  create_ck("textarea.chk",505)
	  $("#detail_jenis").html('Loading..');
	  $("#detail_jenis").load($("#detail_jenis").attr("url"));
	  $("#detail_petugas").html("Loading ...");
	  $("#detail_petugas").load($("#detail_petugas").attr("url"));
});
</script>
