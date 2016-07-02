<?php 
$SESS_TGL = $this->session->userdata('SURAT');
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
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" /><input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td></tr>
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
				<div class="id_grup"></div>
                <div class="kesimpulan_grup"></div>
                <table id="pointa" class="form_tabel" group="GRUP A" isgroup="pointa">
                    <tr id="a1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Kerja sama dengan pemeriksa</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan_a,is_array($aspek_penilaian)?$aspek_penilaian[0]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" id="F02PG_group_pointa" onchange="hasil(\'#pointa\', $(this));"'); ?>&nbsp;<span id="val_pointa"></span><input type="hidden" id="hasil_pointa" value="0" /></td></tr>
                </table>
    
                <h2 class="small">GRUP B : Sanitasi</h2>
                <table id="pointb" class="form_tabel" group="GRUP B" isgroup="pointb">
                    <tr id="b1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Kebersihan</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[1]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointb\', $(this));"'); ?></td></tr>
                    <tr id="b2">
                      <td class="atas">2.</td>
                      <td class="atas">Tempat sampah</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[2]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointb\', $(this));"'); ?></td>
                  </tr>
                    <tr id="b3">
                      <td class="atas">3. </td>
                      <td class="atas">Toilet</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[3]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointb\', $(this));"'); ?></td>
                  </tr>
                    <tr id="b4" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup B</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointb" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[0]:""; ?>"/>&nbsp;<span id="val_pointb"></span><input type="hidden" id="hasil_pointb" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP C : Infestasi </h2>
                <table id="pointc" class="form_tabel" group="GRUP C" isgroup="pointc">
                    <tr id="c1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Binatang pengerat</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[4]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointc\', $(this));"'); ?></td></tr>
                    <tr id="c2">
                      <td class="atas">2.</td>
                      <td class="atas">Serangga</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[5]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointc\', $(this));"'); ?></td>
                  </tr>
                    <tr id="c3" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup C</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointc" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[1]:""; ?>"/>&nbsp;<span id="val_pointc"></span><input type="hidden" id="hasil_pointc" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP D : Bangunan / Ruangan</h2>
                <table id="pointd" class="form_tabel" group="GRUP D" isgroup="pointd">
                    <tr id="d1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Konstruksi</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[6]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointd\', $(this));"'); ?></td></tr>
                    <tr id="d2">
                      <td class="atas">2.</td>
                      <td class="atas">Pencegahan binatang pengerat</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[7]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointd\', $(this));"'); ?></td>
                      </tr>
                    <tr id="d3">
                      <td class="atas">3.</td>
                      <td class="atas">Pencegahan serangga</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[8]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointd\', $(this));"'); ?></td>
                      </tr>
                    <tr id="d4">
                      <td class="atas">4.</td>
                      <td class="atas">Pemeliharaan</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[9]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointd\', $(this));"'); ?></td>
                    </tr>
                    <tr id="d4">
                      <td class="atas">5.</td>
                      <td class="atas">Keteraturan</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[10]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointd\', $(this));"'); ?></td>
                      </tr>
                    <tr id="d5" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup D</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointd" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[2]:""; ?>"/>&nbsp;<span id="val_pointd"></span><input type="hidden" id="hasil_pointd" value="0" /></td>
                      </tr>
                </table>
    
                <h2 class="small">GRUP E : Perlengkapan Peragaan</h2>
                <table id="pointe" class="form_tabel" group="GRUP E" isgroup="pointe">
                    <tr id="e1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Tata letak produk</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[11]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointe\', $(this));"'); ?></td></tr>
                    <tr id="e2">
                      <td class="atas">2.</td>
                      <td class="atas">Lemari penyimpanan</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[12]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointe\', $(this));"'); ?></td>
                  </tr>
                    <tr id="e3">
                      <td class="atas">3.</td>
                      <td class="atas">Lemari pendingin</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[13]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointe\', $(this));"'); ?></td>
                  </tr>
                    <tr id="e4">
                      <td class="atas">4.</td>
                      <td class="atas">Kontrol lemari pendingin</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[14]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointe\', $(this));"'); ?></td>
                  </tr>
                    <tr id="e5" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup E</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointe" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[3]:""; ?>"/>&nbsp;<span id="val_pointe"></span><input type="hidden" id="hasil_pointe" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP F : Gudang Biasa</h2>
                <table id="pointf" class="form_tabel" group="GRUP F" isgroup="pointf">
                    <tr id="f1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Keteraturan</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[15]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointf\', $(this));"'); ?></td></tr>
                    <tr id="f2">
                      <td class="atas">2.</td>
                      <td class="atas">Pencegahan binatang pengerat</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[16]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointf\', $(this));"'); ?></td>
                  </tr>
                    <tr id="f3">
                      <td class="atas">3.</td>
                      <td class="atas">Pencegahan serangga</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[17]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointf\', $(this));"'); ?></td>
                  </tr>
                    <tr id="f4">
                      <td class="atas">4.</td>
                      <td class="atas">Ventilasi</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[18]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointf\', $(this));"'); ?></td>
                  </tr>
                    <tr id="f5" class="kesimpulan_grup"> 
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup F</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointf" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[4]:""; ?>"/>&nbsp;<span id="val_pointf"></span><input type="hidden" id="hasil_pointf" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP G : Gudang Dingin</h2>
                <table id="pointg" class="form_tabel" group="GRUP G" isgroup="pointg">
                    <tr id="g1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Keteraturan</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[19]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointg\', $(this));"'); ?></td></tr>
                    <tr id="g2">
                      <td class="atas">2.</td>
                      <td class="atas">Kontrol suhu</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[20]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan"'); ?></td>
                  </tr>
                    <tr id="g3">
                      <td class="atas">3.</td>
                      <td class="atas">Pencegahan binatang pengerat</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[21]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointg\', $(this));"'); ?></td>
                  </tr>
                    <tr id="g4">
                      <td class="atas">4.</td>
                      <td class="atas">Pencegahan serangga</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[22]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointg\', $(this));"'); ?></td>
                  </tr>
                    <tr id="g5" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup G</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointg" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[5]:""; ?>"/>&nbsp;<span id="val_pointg"></span><input type="hidden" id="hasil_pointg" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP H : Perlengkapan Administrasi</h2>
                <table id="pointh" class="form_tabel" group="GRUP H" isgroup="pointh">
                    <tr id="h1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Keluar masuk barang</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[23]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointh\', $(this));"'); ?></td></tr>
                    <tr id="h2">
                      <td class="atas">2.</td>
                      <td class="atas">Faktur Pembelian</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[24]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointh\', $(this));"'); ?></td>
                  </tr>
                    <tr id="h3">
                      <td class="atas">3.</td>
                      <td class="atas">Faktur Penjualan</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[25]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointh\', $(this));"'); ?></td>
                  </tr>
                    <tr id="h4" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup H</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointh" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[6]:""; ?>"/>&nbsp;<span id="val_pointh"></span><input type="hidden" id="hasil_pointh" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP I : Pengawasan Penanganan</h2>
                <table id="pointi" class="form_tabel" group="GRUP I" isgroup="pointi">
                    <tr id="i1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Penggunaan insektisida / rodentisida</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[26]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointi\', $(this));"'); ?></td></tr>
                    <tr id="i2">
                      <td class="atas">2.</td>
                      <td class="atas">Mutu barang masuk</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[27]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointi\', $(this));"'); ?></td>
                  </tr>
                    <tr id="i3">
                      <td class="atas">3.</td>
                      <td class="atas">Makanan rusak</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[28]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointi\', $(this));"'); ?></td>
                  </tr>
                    <tr id="i4" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup I</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointi" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[7]:""; ?>"/>&nbsp;<span id="val_pointi"></span><input type="hidden" id="hasil_pointi" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP J : Ketentuan Khusus</h2>
                <table id="pointj" class="form_tabel" group="GRUP J" isgroup="pointj">
                    <tr id="j1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Lokasi</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[29]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointj\', $(this));"'); ?></td></tr>
                    <tr id="j2">
                      <td class="atas">2.</td>
                      <td class="atas">Izin minuman keras</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[30]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointj\', $(this));"'); ?></td>
                  </tr>
                    <tr id="j3">
                      <td class="atas">3.</td>
                      <td class="atas">Tanda peringatan khusus</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[31]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointj\', $(this));"'); ?></td>
                  </tr>
                    <tr id="j4" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup J</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointj" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[8]:""; ?>"/>&nbsp;<span id="val_pointj"></span><input type="hidden" id="hasil_pointj" value="0" /></td>
                  </tr>
                </table>
    
                <h2 class="small">GRUP K : Produk yang TMS</h2>
                <table id="pointk" class="form_tabel" group="GRUP K" isgroup="pointk">
                    <tr id="k1"><td class="atas" width="12">1.</td>
                    <td class="atas" width="403">Bahan tambahan</td>
                    <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[32]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td></tr>
                    <tr id="k2">
                      <td class="atas">2.</td>
                      <td class="atas">Makanan rusak</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[33]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k3">
                      <td class="atas">3.</td>
                      <td class="atas">Kedaluwarsa</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[34]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k4">
                      <td class="atas">4.</td>
                      <td class="atas">Label menyimpang</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[35]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k5">
                      <td class="atas">5.</td>
                      <td class="atas">Tanda khusus</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[36]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k6">
                      <td class="atas">6.</td>
                      <td class="atas">Minuman keras TIE</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[37]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k7">
                      <td class="atas">7.</td>
                      <td class="atas">Makanan tidak terdaftar</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[38]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k8">
                      <td class="atas">8.</td>
                      <td class="atas">Lain-lain : sebutkan</td>
                      <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]',$pilihan,is_array($aspek_penilaian)?$aspek_penilaian[39]:'','class="sel_penyimpangan" rel="required" title="Pilih salah satu pilihan" onchange="hasil(\'#pointk\', $(this));"'); ?></td>
                  </tr>
                    <tr id="k9" class="kesimpulan_grup">
                      <td class="atas">&nbsp;</td>
                      <td class="atas">Kesimpulan Grup K</td>
                      <td class="atas"><input type="text" class="scode" title="Kesimpulan Grup" id="F02PG_group_pointk" name="PEMERIKSAAN_PANGAN[KESIMPULAN_GRUP][]" readonly="readonly" rel="required" value="<?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[9]:""; ?>"/>&nbsp;<span id="val_pointk"></span><input type="hidden" id="hasil_pointk" value="0" /></td>
                  </tr>
                </table>   
                
                <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
                <table id="form_tabel">
                  <tr><td class="td_left">&nbsp;</td><td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[HASIL_TEMUAN_LAIN]" title="Hasil temuan lainnya yang tidak tercantum dalam aspek penilaian"><?php echo array_key_exists('HASIL_TEMUAN_LAIN', $sess)?$sess['HASIL_TEMUAN_LAIN']:""; ?></textarea></td></tr>
                </table>
                
				</div>
        </div><!-- Akhir Informasi Penilaian !-->
		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Hasil</td><td class="td_right"><input type="text" class="sdate" readonly="readonly" name="PEMERIKSAAN[HASIL]" id="F02PG_hasil" value="<?php echo array_key_exists('HASIL', $sess)?$sess['HASIL']:""; ?>" title="Hasil pemeriksaan" rel="required" /><span id="hsl"></span></td></tr>
                <tr>
                  <td class="td_left">Saran</td><td class="td_right"><textarea class="stext chk" id="F02PG_rekomendasi" name="PEMERIKSAAN_PANGAN[REKOMENDASI]" title="Saran atau rekomendasi"><?php echo array_key_exists('REKOMENDASI', $sess)?$sess['REKOMENDASI']:""; ?></textarea></td></tr>
                <tr><td class="td_left">Kesimpulan</td><td class="td_right"><textarea class="stext chk" id="F02PG_kesimpulan" name="PEMERIKSAAN_PANGAN[KESIMPULAN]" title="Kesimpulan"><?php echo array_key_exists('KESIMPULAN', $sess)?$sess['KESIMPULAN']:""; ?></textarea></td></tr>
                </table>
				</div>
        </div><!-- Akhir Informasi Kesimpulan !-->
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TINDAKAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Tindakan Balai</h2>
                <table class="form_tabel">
                <tr>
                  <td class="td_left">Tindak Lanjut</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[TINDAKAN][]',$tindakan_balai,is_array($sel_tindakan)?$sel_tindakan:'','class="stext multiselect" multiple title="Tindak lanjut balai. Jika lebih dari satu, tekan klik + Ctrl"'); ?></td></tr>
                    <tr><td class="td_left">CAPA</td><td class="td_right"><textarea name="PEMERIKSAAN_PANGAN[CAPA]" class="stext chk" title="C A P A"><?php echo array_key_exists('CAPA', $sess)?$sess['CAPA']:''; ?></textarea></td></tr>
                    </table>
                </div>
        </div><!-- Akhir Kesimpulan !-->
        
		<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
                <input type="hidden" value="0" id="flag">
                <table id="F02PG_tbtms" class="form_tabel">
                <tr>
                  <td width="130">Nama produk</td>
                  <td class="isi"><input type="text" class="stext" id="F02PG_nama_produk" name="F02PG_nama_produk" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/3" title="Nama produk" /></td><td width="30">&nbsp;</td>
                  <td width="130"> Produsen/Importir</td>
                  <td class="atas"><input type="text" id="F02PG_produsen_importir" name="F02PG_produsen_importir" class="stext" title="Produsen / importir" /></td>
                </tr>
                <tr>
                  <td class="atas">Registrasi Produk</td>
                  <td class="atas"><select class="stext" name="F02PG_reg_produk" id="F02PG_reg_produk" title="Registrasi produk"><option value="MD">MD</option><option value="ML">ML</option><option value="P-IRT">P-IRT</option><option value="SP">SP</option><option value="Tidak Terdaftar">Tidak Terdaftar</option></select></td>
                  <td>&nbsp;</td>
                  <td class="atas">Nomor Registrasi</td>
                  <td class="atas"><input type="text" name="F02PG_no_registrasi" id="F02PG_no_registrasi" class="stext" title="Nomor Registrasi" /></td>
                </tr>
                <tr>
                  <td width="130" class="atas">Jumlah Kemasan Terkecil</td>
                  <td class="atas"><input type="text" id="F02PG_jumlah_kemasan" class="scode" name="F02PG_jumlah_kemasan" title="Jumlah kemasan terkecil" onkeyup="numericOnly($(this))" />&nbsp;<select name="F02PG_satuan" id="F02PG_satuan" class="sel_penyimpangan" title="Satuan kemasan"><option value="Buah/Pieces">Buah/Pieces</option><option value="Sachet">Sachet</option><option value="Bungkus">Bungkus</option><option value="Botol">Botol</option><option value="Kaleng">Kaleng</option><option value="Karton">Karton</option><option value="Cup">Cup</option><option value="Lainnya">Lainnya</option></select>&nbsp;<input type="text" class="sdate" id="F02PG_satuan_lain" style="display:none;" value="-" title="Satuan lainnya"/></td><td width="30">&nbsp;</td>
                  <td width="130" class="atas">Kategori Temuan</td>
                  <td class="atas"><select name="F02PG_kategori_temuan" id="F02PG_kategori_temuan" class="stext" title="Kategori temuan"><option value="TIE">TIE (Tanpa Izin Edar)</option><option value="Rusak">Rusak</option><option value="ED (Expire Date / Kedaluwarsa)">ED (Expire Date / Kedaluwarsa)</option><option value="TMK Label">TMK Label</option><option value="Lain-Lain">Lain-lain</option></select></td>
                </tr>
                <tr id="kategori_lain" style="display:none;">
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas"><input type="text" id="F02PG_kategori_temuan_lain" class="stext" title="Kategori temuan lainnya" value="-" /></td>
                </tr>
                <tr>
                <td class="atas">Perkiraan harga total</td>
                <td class="atas"><input type="text" id="F02PG_harga" class="sdate" name="F02PG_harga" title="Perkiraan harga total" onkeyup="numericOnly($(this))" /></td>
                <td>&nbsp;</td>
                <td class="atas">&nbsp;</td>
                <td class="atas"></td>
                </tr>
                </table>
               
                <div style="height:5px;"></div>
                <div class="btn"><span><a href="#" id="F02PG_add_temuan">Tambah Temuan</a></span></div>
                <div style="height:5px;"></div>
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
                                    <tr id="<?php echo $temuan_produk[$i]['SERI']; ?>"><td><?php echo $temuan_produk[$i]['PRODUSEN']; ?><input type="hidden" name="TEMUAN_PRODUK[PRODUSEN][]" value="<?php echo $temuan_produk[$i]['PRODUSEN']; ?>"></td><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="<?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?>"></td><td>Registrasi Produk : <?php echo $temuan_produk[$i]['REGISTRASI']; ?><input type="hidden" name="TEMUAN_PRODUK[REGISTRASI][]" value="<?php echo $temuan_produk[$i]['REGISTRASI'];?>"><br>Nomor Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?><input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="<?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?>"><br>Jumlah Kemasan Terkecil : <?php echo $temuan_produk[$i]['KEMASAN'];?><input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="<?php echo $temuan_produk[$i]['KEMASAN'];?>"><br>Satuan : <?php echo $temuan_produk[$i]['SATUAN'];?><input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="<?php echo $temuan_produk[$i]['SATUAN'];?>"><br>Perkiraan Harga Total : <?php echo $temuan_produk[$i]['HARGA'];?><input type="hidden" name="TEMUAN_PRODUK[HARGA][]" value="<?php echo $temuan_produk[$i]['HARGA'];?>"></td><td><?php echo $temuan_produk[$i]['KATEGORI'];?><input type="hidden" value="<?php echo $temuan_produk[$i]['KATEGORI'];?>" name="TEMUAN_PRODUK[KATEGORI][]"><span style="float:right;"><a href="#" class="del_temuan"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Batalkan atau hapus temuan produk" /></a></span></td></tr>
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
        </div><!-- Akhir Informasi Temuan Produk !-->

        <?php
		if(!array_key_exists('PERIKSA_ID', $sess)){
		?>
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN KLASIFIKASI KOMODITI LAIN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Klasifikasi Komoditi Lain</h2>
                <table class="form_tabel">
                	<tr><td class="td_left">Jenis Temuan</td><td class="td_right"><?php echo form_dropdown('cb_konfirm', $this->config->item('konfirmasi'), '', 'id="cb_konfirm" class="stext" title="Pilih salah satu jenis temuan" onchange="sel_konfirmasi($(this));"'); ?></td></tr>
                    <tr id="tr_jenis_sarana" style="display:none;"><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('jns', $jenis_sarana, '', 'id="jns" class="stext" url="'.site_url().'/get/pemeriksaan/set_klasifikasi_sarana/" onchange="get_klasifikasi($(this));" title="Pilih salah satu jenis sarana"', $disinput); ?></td></tr>
                    <tr id="tr_jenis_klasifikasi" style="display:none;"><td class="td_left">Jenis Klasifikasi</td><td class="td_right"><?php echo form_dropdown('kk', $klasifikasi_kategori, '', 'id="kk" class="stext" title="Pilih salah satu jenis klasifikasi"'); ?></td>
                    </tr>
                </table>
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        <?php
		}if($stat=="20102" || $stat=="20103" || $stat=="20113" || $stat=="20112" || $stat=="60020"){ ?>
		<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Verifikasi Pemeriksaan</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Proses Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[STATUS]',$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td></tr>
                    <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td></tr>
                </table>
                
                <div style="padding-top:5px;">
                      <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan</a></h2>
                      <div id="detail_log"></div>
                </div> 
                
                </div>
        </div><!-- Akhir Verifikasi !-->        
        <?php
		}
		?>

    </div>
</div>

<div id="clear_fix"></div>
<div><a href="#" class="button save" onclick="fpost('#f02pg_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
<div id="clear_fix"></div><div id="hasilnya"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
	 <?php if($sess['PERIKSA_ID'] != ""){ ?>
		  $("table[isgroup]").each(function(n,i){ var ids = $(this).attr("id");
			  var jrows = $("#"+ids+" tr").not(".kesimpulan_grup").length;
			  var isi_edit = 0, tmp_isi = 0, tb_edit = 0, nil_edit = 0, kgroup_edit = 0; 
			  var akhir_edit, group_edit;
			  $("#"+ids+" tr .sel_penyimpangan").each(function(){
				  if($(this).val() == "T"){
					  tb_edit++;
				  }
				  if($(this).val() == "B"){
					  nil_edit = 3;
				  }else if($(this).val() == "C"){
					  nil_edit = 2;
				  }else if($(this).val() == "K"){
					  nil_edit = 1;
				  }else if($(this).val() == "T"){
					  nil_edit = 0;
				  }
				  isi_edit += nil_edit;
				  if(tb_edit > 0){
					  if(tb_edit == jrows){
						  kgroup_edit = 0;
						  akhir_edit = "T";
					  }else{
						  kgroup_edit = parseFloat(isi_edit) / (parseFloat(jrows) - tb_edit);
					  }
				  }else{
					  kgroup_edit = parseFloat(isi_edit) / parseFloat(jrows);
				  }
				  if(kgroup_edit <= 0){
					  akhir_edit = "T";
				  }if(kgroup_edit > 0.1 && kgroup_edit <= 1.49){
					  akhir_edit = "K";
				  }else if(kgroup_edit >= 1.5 && kgroup_edit <= 2.49){
					  akhir_edit = "C";
				  }else if(kgroup_edit >= 2.5){
					  akhir_edit = "B";
				  }
			  });
			  $("span#val_"+ids).html(parseFloat(kgroup_edit.toFixed(2)));
			  $("#hasil_"+ids).val(parseFloat(kgroup_edit.toFixed(2)));
		  });
		  <?php
	  }
	  ?>
	
	  create_ck("textarea.chk",505);
	  $("#detail_jenis").html('Loading..');
	  $("#detail_jenis").load($("#detail_jenis").attr("url"));
	  $("#detail_petugas").html("Loading ...");
	  $("#detail_petugas").load($("#detail_petugas").attr("url"));
	  $("#F02PG_nama_produk").autocomplete($("#F02PG_nama_produk").attr('url'), {width: 244, selectFirst: false});
	  $("#F02PG_nama_produk").result(function(event, data, formatted){
		  if(data){
			  $(this).val(data[1]);
			  $("#F02PG_no_registrasi").val(data[2]);
			  $("#F02PG_produsen_importir").val(data[5]);
			  $("#flag").val('1');
		  }
	  });

	$("#F02PG_satuan").change(function(){if($(this).val() == "Lainnya"){ $("#F02PG_satuan_lain").show(); }else{ $("#F02PG_satuan_lain").hide(); } });
	$("#F02PG_kategori_temuan").change(function(){
		if($("#F02PG_kategori_temuan").val() == "Lain-Lain"){
			$("#kategori_lain").show();
		}else{
			$("#kategori_lain").hide();
		}
	});
	
	$("#F02PG_add_temuan").click(function(){
		if(!beforeSubmit("#F02PG_tbtms")){
			return false;
		}else{
			var satuan;
			if($("#F02PG_satuan").val() != "Lainnya"){
				satuan = $("#F02PG_satuan option:selected").text();
			}else{
				satuan = $("#F02PG_satuan_lain").val();
			}
			var temuan;
			if($("#F02PG_kategori_temuan").val() != "Lain-Lain"){
				temuan = $("#F02PG_kategori_temuan option:selected").text();
			}else{
				temuan = $("#F02PG_kategori_temuan_lain").val();
			}
			var id = $('#F02PG_bod_pangan tr').length;
			$("#F02PG_bod_pangan").append('<tr id="'+(id+1)+'"><td>'+$("#F02PG_produsen_importir").val()+'<input type="hidden" name="TEMUAN_PRODUK[PRODUSEN][]" value="'+$("#F02PG_produsen_importir").val()+'"></td><td>'+$("#F02PG_nama_produk").val()+'<input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="'+$("#F02PG_nama_produk").val()+'"></td><td>Registrasi Produk : '+$("#F02PG_reg_produk option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[REGISTRASI][]" value="'+$("#F02PG_reg_produk").val()+'"><br>Nomor Registrasi : '+$("#F02PG_no_registrasi").val()+'<input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="'+$("#F02PG_no_registrasi").val()+'"><br>Jumlah Kemasan Terkecil : '+$("#F02PG_jumlah_kemasan").val()+'<input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="'+$("#F02PG_jumlah_kemasan").val()+'"><br>Satuan : '+satuan+'<input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="'+$("#F02PG_satuan").val()+'"><br>Perkiraan Harga Total : '+$("#F02PG_harga").val()+'<input type="hidden" name="TEMUAN_PRODUK[HARGA][]" value="'+$("#F02PG_harga").val()+'"></td><td>'+temuan+'<input type="hidden" value="'+temuan+'" name="TEMUAN_PRODUK[KATEGORI][]" id="F02PG_kategori_temuan_tipe"><input type="hidden" name="TEMUAN_PRODUK[FLAG][]" value="'+$("#flag").val()+'"><span style="float:right;"><a href="#" class="del_temuan"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Batalkan atau hapus temuan produk" /></a></span></td></tr>');
			clearForm("#F02PG_tbtms");
			$("#F02PG_satuan_lain").val('-');
			$("#F02PG_kategori_temuan_lain").val('-');
			$("#flag").val('0');
			return false;
		}
	});
	$(".del_temuan").live("click", function(){id = $(this).closest("table tr").attr("id"); $("table #"+id).remove();return false;});
});


function hasil(divtabel, sel_element){
	var jaspek = 0, kgroup = 0, jml_tb = 0, kakhir = 0;
	var tabel = $(sel_element).closest("table").attr("id");
	var jrow = $(divtabel+" tr").not(".kesimpulan_grup").length;
	var row = $(sel_element).closest("table tr").attr("id");
	var tb = $(divtabel+" tr select.sel_penyimpangan option:selected[value='T']").length; 
	$(divtabel+" .sel_penyimpangan option:selected").each(function(){
		var nilai = 0;
		if($(this).val() == "B"){
			nilai = 3;
		}else if($(this).val() == "C"){
			nilai = 2;
		}else if($(this).val() == "K"){
			nilai = 1;
		}else if($(this).val() == "T"){
			nilai = 0;
		}
		jaspek += nilai;
		if(tb > 0){
			if(tb == jrow){
				kgroup = 0;
				kahir = "T";
			}else{
				kgroup = parseFloat(jaspek) / (parseFloat(jrow) - tb);
			}
		}else{
			kgroup = parseFloat(jaspek) / parseFloat(jrow);
		}
		if(kgroup <= 0){
			kakhir = "T";
		}if(kgroup > 0.1 && kgroup <= 1.49){
			kakhir = "K";
		}else if(kgroup >= 1.5 && kgroup <= 2.49){
			kakhir = "C";
		}else if(kgroup > 2.5){
			kakhir = "B";
		}
	});
	if(tabel == "pointk" || tabel == "pointi"){
		var jmlik = $("#"+tabel+ " select.sel_penyimpangan option:selected[value='K']").length; 
		if(jmlik > 0){
			$("#F02PG_group_"+tabel).val("K");
			$("#F02PG_hasil").val("KURANG");
		}else{
			$("#F02PG_group_"+tabel).val(kakhir);
		}
	}else{
		if(tabel == "pointa"){
			$("#pointa").parent().children().children().val(kakhir);
		}else{
			$("#F02PG_group_"+tabel).val(kakhir);
		}
	}
	if(row == "g1"){
		var value = $("#"+row+" td:nth-child(3)").children().val();
		if(value == "T"){
			$("#F02PG_group_pointg").val("T");
		}else if(value == ""){
			$("#F02PG_group_pointg").val(kahir);
		}
	}else if(row == "h1"){
		var value = $("#"+row+" td:nth-child(3)").children().val();
		if(value == "T"){
			$("#F02PG_group_pointh").val("T");
			$("#"+tabel + " select.sel_penyimpangan").val("T");
		}else{
			$("#F02PG_group_pointh").val(kakhir);
		}
	}
	$("span#val_"+tabel).html(parseFloat(kgroup.toFixed(2)));
	$("#hasil_"+tabel).val(parseFloat(kgroup.toFixed(2)));
	set_hasil();
	return false;
}

function set_hasil(){
	var jum_k = 0, jum_c = 0, hasil = 0, tmp_notbgroup = 0, tmp_tbgroup = 0;
	var in_group = new Array($("#F02PG_group_pointa").val(),$("#F02PG_group_pointb").val(),$("#F02PG_group_pointc").val(),$("#F02PG_group_pointd").val(),$("#F02PG_group_pointe").val(),$("#F02PG_group_pointf").val(),$("#F02PG_group_pointg").val(),$("#F02PG_group_pointh").val(),$("#F02PG_group_pointi").val(),$("#F02PG_group_pointj").val(),$("#F02PG_group_pointk").val());
	var not_tb = new Array($("#hasil_pointa").val(),$("#hasil_pointb").val(),$("#hasil_pointc").val(),$("#hasil_pointd").val(),$("#hasil_pointe").val(),$("#hasil_pointf").val(),$("#hasil_pointg").val(),$("#hasil_pointh").val(),$("#hasil_pointi").val(),$("#hasil_pointj").val(),$("#hasil_pointk").val());
	for(var i = 0; i < in_group.length; ++i){
		if(in_group[i] == "K"){
			jum_k++;
		}else if(in_group[i] == "C"){
			jum_c++;
		}
	}
	
	for(var z = 0; z < not_tb.length; ++z){
		if(not_tb[z] != 0){
			tmp_notbgroup += parseInt(not_tb[z]);
		}else{
			tmp_tbgroup++;
		}
	}
	hasil = parseFloat(Math.floor(parseInt(tmp_notbgroup))) / (11 - tmp_tbgroup);
	if($("#F02PG_group_pointc").val() == "B" && $("#F02PG_group_pointe").val() == "B" && $("#F02PG_group_pointi").val() == "B" && $("#F02PG_group_pointj").val() == "B" && $("#F02PG_group_pointk").val() == "B" && jum_k == 0){
		$("#F02PG_hasil").val("BAIK");
	}else if($("#F02PG_group_pointc").val() == "B" && $("#F02PG_group_pointi").val() == "B" && $("#F02PG_group_pointj").val() == "B" && $("#F02PG_group_pointk").val() == "B" && (jum_c > 0 || jum_k > 0)){
		$("#F02PG_hasil").val("CUKUP");
	}else if($("#F02PG_group_pointi").val() == "K" || $("#F02PG_group_pointk").val() == "K"){
		$("#F02PG_hasil").val("KURANG")
	}else{
		if(hasil <= 1.49){
			$("#F02PG_hasil").val("KURANG");
		}else if(hasil >= 1.5 && hasil <= 2.49){
			$("#F02PG_hasil").val("CUKUP");
		}else if(hasil >= 2.5){
			$("#F02PG_hasil").val("BAIK");
		}
	}	
}
</script>