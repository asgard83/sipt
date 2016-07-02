<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<script type="text/javascript">
$(document).ready(function(){
	$("#tabs-golb").tabs();
	$("#F01KOb_add_sediaan").click(function(){
		var panjang = $("#F01KOb_tbosediaan tr").length;
		$("#F01KOb_tbosediaan").append('<tr id="'+(panjang+1)+'"><td><input type="text" class="stext"name="F01KOb_bentuk[]" rel="required" /></td><td><input type="text" name="F01KOb_sediaan[]" rel="required" class="stext" />&nbsp;<input type="button" id="F01KOb_del_sediaan" value=" x " title="Klik disini untuk menghapus kolom bentuk / sediaan" onclick="del_element_div(\'#F01KOb_tbosediaan tr#'+(panjang+1)+'\', \'#F01KOb_tbosediaan\');" /></td></tr>');
		return false;
	});
		
});
	
</script>
<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f01KO_golb" id="f01KO_golb" method="post" action="<?php echo $act; ?>" autocomplete="off">
<div class="section">
      <ul class="tabs">
          <li class="current">DATA PERUSAHAAN</li>
          <li>GAMBARAN UMUM INDUSTRI KOSMETIK</li>
          <li>PENERAPAN CPKB</li>
      </ul>
      
      <div class="box visible">
   		<h2>DATA PERUSAHAAN</h2>
            <table id="F01KOb_tbperusahaan">
            	<tr><td class="atas isi" width="210">Nama Perusahaan</td><td width="30"></td><td><?php echo $namasarana_; ?></td></tr>
                <tr><td class="atas isi">Status</td><td></td><td><select name="F01KOb_status" id="F01KOb_status" class="stext"><option value="01">PMA</option><option value="02">PMDN</option><option value="03">Swasta Nasional</option></select></td></tr>
                <tr><td class="atas isi">Alamat (Kantor)</td><td></td><td><?php echo $alamat_; ?></td></tr>
                <tr id="F01KOb_tr_alamat_pabrik"><td class="atas isi">Alamat (Pabrik)</td><td></td><td>
                <ul id="F01KOb_list_pabrik" style="margin:0; padding:0; list-style:none;">
                	<li id="1" style="padding-bottom:3px;"><textarea name="F01KOb_alamat_pabrik[]" id="F01KOb_alamat_pabrik" class="stext" rel="required"></textarea>&nbsp;<input type="button" name="F01KOb_add_pabrik" id="F01KOb_add_pabrik" value="+" title="Klik disini untuk menambah alamat pabrik" /></li>
                </ul>
                </td></tr>
                <tr><td class="atas isi">Nama Pimpinan</td><td></td><td>Pimpinan </td></tr>
                <tr><td class="atas isi">Nama Penanggung Jawab</td><td></td><td><?php echo $penanggungjawab_; ?></td></tr>
                <tr><td class="atas isi">Penanggung Jawab Teknis</td><td></td><td></td></tr>
                <tr><td class="atas isi">Nama</td><td></td><td><input type="text" name="F01KOb_npjteknis" id="F01KOb_npjteknis" class="stext" rel="required" /></td></tr>
                <tr><td class="atas isi">Pendidikan</td><td></td><td><input type="text" name="F01KOb_ppjteknis" id="F01KOb_ppjteknis" class="stext" rel="required" /></td></tr>
                <tr><td class="atas isi">STRA</td><td></td><td><input type="text" name="F01KOb_srta" id="F01KOb_srta" class="stext" rel="required" /></td></tr>
                <tr><td class="atas isi">Bentuk sediaan yang diusulkan</td><td></td><td class="atas">
                
                <table class="listtemuan" id="F01KOb_tbsediaan">
                	<thead><tr><th>Bentuk</th><th>Sediaan</th></tr></thead>
                    <tbody id="F01KOb_tbosediaan">
                    <tr><td><input type="text" class="stext"name="F01KOb_bentuk[]" rel="required" /></td><td><input type="text" name="F01KOb_sediaan[]" rel="required" class="stext" />&nbsp;<input type="button" id="F01KOb_add_sediaan" value="+" title="Klik disini untuk menambah kolom bentuk / sediaan baru" /></td></tr>
                    </tbody>
                </table>
                
                </td></tr>
                <tr>
                  <td class="atas isi">Petugas</td>
                  <td></td>
                  <td class="atas"><?php echo form_dropdown('F01KOb_petugas[]', $petugas, $selpetugas, 'class="stext multiple" rel="required" multiple="multiple"');?></td>
                </tr>
            </table>
      </div><!-- Akhir Data Perusahaan !-->
      
      <div class="box">
      		<h2>GAMBARAN UMUM INDUSTRI KOSMETIK</h2>
            <table id="F01KO_head" width="100%">
                <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
            </table>
            <table id="F01KO_head_poin1" width="100%">
                <tr>
                  <td class="atas isi" width="30">I.</td>
                  <td class="atas isi" width="100">&nbsp;</td>
                  <td colspan="5" class="atas isi">Gambaran Umum Sarana  Bangunan dan Fasilitas Penunjang</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td width="20" class="atas isi">A.</td>
                  <td width="300" class="atas isi">Sarana Bangunan</td>
                  <td width="50" class="atas">&nbsp;</td>
                  <td width="50" class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Desain tata ruang sesuai dengan denah yang sudah  disetujui </td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">2.</td>
                  <td class="atas">Ruangan sesuai dengan fungsinya terbuat dari  bahan yang mudah untuk dilakukan pembersihan dan pemeliharaan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">3.</td>
                  <td class="atas">Lingkungan sarana produksi bebas  banjir &amp; polusi, dll.</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">4.</td>
                  <td class="atas">Lantai bersih, tidak  retak dan rata</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">5.</td>
                  <td class="atas">Langit-langit bersih dan  rata</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">6.</td>
                  <td class="atas">Dinding bersih, tidak  retak, kedap air dan rata</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">7.</td>
                  <td class="atas">Pintu dapat ditutup dengan baik dan selalu dalam  keadaan tertutup</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">8.</td>
                  <td class="atas">Ventilasi mencukupi dan dilengkapi dengan alat  pencegah masuknya serangga </td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">9.</td>
                  <td class="atas">Penerangan di dalam  ruangan cukup terang</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">B.</td>
                  <td colspan="4" class="atas isi">Fasilitas Penunjang</td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Tersedia air bersih yang mencukupi kebutuhan  serta ditempatkan di area yang diperlukan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">2.</td>
                  <td class="atas">Menggunakan air produksi dengan  kualitas air minum.</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">3.</td>
                  <td class="atas">Menggunakan pengamanan yang memadai terhadap  penggunaan gas alam/LPG </td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
              </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">4.</td>
                  <td class="atas">Jika menggunakan peralatan udara bertekanan,  tersedia pipa penyalur yang memadai</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">5.</td>
                  <td class="atas">Mempunyai fasilitas tempat istirahat terpisah  dari area pengolahan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">6.</td>
                  <td class="atas">Mempunyai fasilitas toilet dan wastafel yang  memadai</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">7.</td>
                  <td class="atas">Tersedia ruang ganti sebelum memasuki area  pengolahan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">8.</td>
                  <td class="atas">Tersedia tempat sampah dalam jumlah yang cukup  dan tertutup</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas isi">II.</td>
                  <td class="atas">&nbsp;</td>
                  <td colspan="5" class="atas isi">Pengolahan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">A.</td>
                  <td colspan="4" class="atas isi">Penimbangan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Tersedia program  kalibrasi alat timbang*</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">B.</td>
                  <td colspan="4" class="atas isi">Bangunan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Pengolahan dilakukan dengan tata ruang yang  mencegah cemaran silang</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">2.</td>
                  <td class="atas">Luas ruang kerja memungkinkan penempatan  peralatan dan bahan-bahan secara teratur dan rapi</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">3.</td>
                  <td class="atas">Seluruh ventilasi  dilengkapi alat pencegah masuknya serangga (non pengolahan)</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">C.</td>
                  <td colspan="4" class="atas isi">Peralatan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Mempunyai timbangan dan alat ukur dengan jumlah  dan jenis yang sesuai dengan kebutuhan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">D</td>
                  <td colspan="4" class="atas isi">Pengolahan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Tersedia format untuk  pengawasan selama proses*</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">E.</td>
                  <td colspan="4" class="atas isi">Perlengkapan produksi masing-masing sediaan</td>
                </tr>
                <tr>
                  <td class="atas isi">III.</td>
                  <td class="atas">&nbsp;</td>
                  <td colspan="5" class="atas isi">Area Pengemas Sekunder</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">A.</td>
                  <td colspan="4" class="atas isi">Bangunan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Mempunyai area pengemasan dan karantina yang  memadai</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">B.</td>
                  <td colspan="4" class="atas isi">Peralatan</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Peralatan sesuai kebutuhan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">2.</td>
                  <td class="atas">Kalibrasi timbangan dilakukan secara berkala</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas isi">IV.</td>
                  <td class="atas">&nbsp;</td>
                  <td colspan="5" class="atas isi">Gudang Bahan Baku dan Pengemas</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">A.</td>
                  <td colspan="4" class="atas isi">Tenaga Kerja</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Tersedia alat pelindung seperti: masker, sarung tangan, sepatu pengaman,  pelindung kepala/helm*</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">B.</td>
                  <td class="atas isi">Bangunan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Tersedia area karantina, area penyimpanan dan  area reject yang memadai</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">2.</td>
                  <td class="atas">Jika tersedia gudang bahan baku khusus, dilengkapi alat pengatur suhu udara</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">3.</td>
                  <td class="atas">Memiliki pengamanan terhadap bahaya kebakaran</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">C.</td>
                  <td class="atas isi">Penyimpanan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">Tersedia tempat penyimpanan yang memadai ( spt:  rak, palet dll) </td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td colspan="5" class="atas isi">Gudang Produk Jadi</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">A.</td>
                  <td colspan="4" class="atas isi">Tenaga Kerja</td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Tersedia alat pelindung seperti: masker, sarung tangan, sepatu pengaman,  pelindung kepala/helm*</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">B.</td>
                  <td class="atas isi">Bangunan</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">1.</td>
                  <td class="atas">Mempunyai area penyimpanan dan sistem karantina</td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">2.</td>
                  <td class="atas">Memiliki pengaman terhadap bahaya kebakaran  </td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                  <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                  <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                </tr>
            </table>
            
            
      </div><!-- Akhir Gambaran Umum !-->

      <div class="box">
      		<h2>PENERAPAN CPKB</h2>
            <div id="tabs-golb">
            	<ul>
                	<li><a href="#golb_point1">Higiene dan Kesehatan</a></li>
                	<li><a href="#golb_point2">Dokumentasi</a></li>
                </ul>
                
              <div id="golb_point1">
        <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    <table id="F01KO_head_poin2" width="100%">
                    <tr>
                      <td class="atas isi" width="30">I.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="5" class="atas isi">Personalia dan Kesehatan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas">1.</td>
                      <td width="300" class="atas">Tersedia program pemeriksaan  kesehatan secara berkala</td>
                      <td width="50" class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td width="50" class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia pakaian kerja dan perlengkapannya yang sesuai*</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Karyawan tidak menderita penyakit kulit atau  penyakit menular lainnya*</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia peraturan tertulis larangan makan/minum, mengunyah, merokok dan meludah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">II.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Gambaran Umum Sarana  Bangunan dan Fasilitas Penunjang</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Sarana Bangunan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Ruangan sesuai dengan fungsinya terbuat dari  bahan yang mudah untuk dilakukan pembersihan dan pemeliharaan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Lantai bersih, tidak  retak dan rata</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Langit-langit bersih dan  rata, Dinding bersih, tidak  retak, kedap air dan rata</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Fasilitas Penunjang</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Seluruh tempat dalam keadaan bersih dan  terpelihara</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia tempat sampah dalam jumlah yang cukup  dan tertutup</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">III.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Area Pengolahan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Tenaga Kerja</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia pakaian kerja dan perlengkapannya dengan baik*</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia peraturan  tertulis untuk mencuci tangan terlebih dahulu sebelum bekerja di ruang produksi*</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia peraturan  tertulis untuk tidak  menggunakan  perhiasan dan asesories di  ruang/area pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Bangunan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Dilakukan pembersihan  terhadap lantai, dinding, langit-langit, pintu, jendela, dll secara berkala</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td colspan="4" class="atas isi">Peralatan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Permukaan peralatan  (bagian dalam maupun luar) mudah dibersihkan  dan tidak bereaksi, mengadsorpsi dan tidak melepaskan serpihan dari setiap  bagian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td colspan="4" class="atas isi">Higiene Sanitasi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Kamar kecil/toilet tidak  berhubungan langsung dengan daerah pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tempat sampah yang terdapat di ruang pengolahan  dalam jumlah yang cukup dan tertutup serta  dibersihkan setiap hari</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">IV.</td>
                      <td class="atas isi">&nbsp;</td>
                      <td colspan="5" class="atas">Area Pengemas Sekunder</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Bagunan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Area pengemasan dinyatakan bersih dengan  penandaan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Dilakukan pembersihan  terhadap lantai, dinding, langit-langit, pintu, jendela, dll secara berkala</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">V.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Gudang Bahan Baku,  Bahan Pengemas Dan Produk Jadi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Tenaga Kerja</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Disediakan  wastafel di gudang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Bangunan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Dilakukan pembersihan  terhadap lantai, dinding, langit-langit, pintu, jendela, dll secara berkala</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                </table>              
                </div><!-- Akhir div golb_point1 !-->
                
              <div id="golb_point2">
        <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    <table id="F01KO_head_poin3" width="100%">
                    <tr>
                      <td width="30" class="atas isi">I.</td>
                      <td width="100" class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Kepemimpinan  organisasi dan SDM</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Kepemimpinan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td width="300" class="atas">Tersedia visi &amp; misi </td>
                      <td width="50" class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td width="50" class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Komitmen kepada Mutu  Produk*</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Organisasi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Perusahaan mempunyai struktur organisasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia Uraian Tugas dan Tanggungjawab Penanggungjawab </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">II.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas">Pengolahan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Peralatan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia label status kebersihan peralatan </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia catatan  kalibrasi penimbangan yang dilakukan secara berkala</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Higiene dan Sanitasi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia prosedur pembersihan dan sanitasi peralatan.</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  format catatan  pembersihan ruang pengolahan yang lengkap</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td colspan="4" class="atas isi">Pengolahan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia catatan  pengolahan bets.</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td colspan="4" class="atas isi">Pengolahan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia catatan  pengolahan bets.</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia catatan  pemeriksaan selama pengolahan beserta hasil pemeriksaan mutu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia label identitas untuk produk antara  atau produk ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia kartu persediaan produk antara dan atau  ruahan </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia label penimbangan atau pengukuran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia format untuk</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">III.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Area Pengemasan Sekunder</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Peralatan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia label status  peralatan </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  format catatan kalibrasi timbangan yang dilakukan secara berkala</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Pengamasan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  catatan pengawasan selama proses</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  catatan rekonsiliasi terhadap produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td colspan="4" class="atas isi">Pengawasan Mutu</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  catatan pemeriksaan bahan baku, bahan pengemas dan produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  prosedur pengujian terhadap produk jadi ke laboratorium lain yang terakreditasi secara berkala </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia  format catatan dan laporan pemeriksaan produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia  format persetujuan tertulis pada label penandaan bahan baku, bahan pengemas dan  produk jadi yang telah lulus uji</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">V.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Gudang Produk Jadi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Kartu Produk Jadi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia format kartu persediaan produk jadi </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas isi">VI.</td>
                      <td class="atas">&nbsp;</td>
                      <td colspan="5" class="atas isi">Dokumentasi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">A.</td>
                      <td colspan="4" class="atas isi">Dokumen Spesifikasi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia format spesifikasi bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format kartu persediaan produk jadi </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia format spesifikasi produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Produksi</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia format prosedur pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format prosedur pengemasan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Pengawasan Mutu</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia prosedur pengambilan  contoh</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia metoda pemeriksaan  mutu sederhana</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia prosedur  tertulis untuk penanganan penarikan kosmetika dari peredaran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia prosedur  tertulis untuk penanganan contoh pertinggal</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia program  kalibrasi alat</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia prosedur  tertulis untuk pemeriksaan stabilitas dan penetapan batas waktu penggunaan  produk jadi*</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">7.</td>
                      <td class="atas">Prosedur pengujian  mutu yang dilaksanakan pihak lain didokumentasikan* </td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Dalam Pemeliharaan, Pembersihan dan Pengendalian Ruangan Serta Peralatan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia prosedur tetap  pemakaian alat</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia prosedur  pemeliharaan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia prosedur  pembersihan dan sanitasi peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia prosedur  pembersihan dan sanitasi bangunan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">E.</td>
                      <td colspan="4" class="atas isi">Dokumentasi  Dalam Penanganan Keluhan, Kosmetika yang Ditarik, Kosmetika Kembalian,  Pemusnahan Bahan Baku dan Kosmetika</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia prosedur dan  catatan penanganan keluhan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia prosedur dan  catatan penarikan kosmetika</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia prosedur dan  catatan penanganan kosmetika kembalian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia prosedur dan  catatan pemusnahan bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia prosedur dan  catatan pemusnahan produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_true" id="F01KO_golb_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_golb_false" id="F01KO_golb_false" /></td>
                      <td class="atas"><textarea name="F01KO_golb_ket" id="F01KO_golb_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div><!-- Akhir dib golb_point2 !-->
                
                
            </div>
            

      </div><!-- Akhir Penerapan CPKB !-->  
      
</div>      


<div><input type="submit" id="btncancel" value="" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;" /><input type="submit" id="btnsave" value="" onclick="fpost('f01KO_golb','',''); return false" /></div>
<div id="clear_fix"></div>
</form>
</div>
