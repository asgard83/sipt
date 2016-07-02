<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<script type="text/javascript">
$(document).ready(function(){
	$("#tabs-gola").tabs();

	$("#F01KOa_add_sediaan").click(function(){
		var panjang = $("#F01KOa_list_sediaan li").length;
		$("ul#F01KOa_list_sediaan").append('<li id="no'+(panjang+1)+'" style="padding-bottom:3px;"><input type="text" name="F01KOa_sediaan[]" class="stext" rel="required" />&nbsp;<input type="button" name="F01KOa_del_sediaan" id="F01KOa_del_sediaan" onclick="del_element_div(\'ul#F01KOa_list_sediaan li#no'+(panjang+1)+'\', \'ul#F01KOa_list_sediaan\');" value=" x " title="Klik disini untuk menghapus dari daftar sediaan yang diusulkan" /></li>');
		return false;
	});
	
	$("#F01KOa_add_pabrik").click(function(){
		var panjang = $("#F01KOa_list_pabrik li").length;
		$("ul#F01KOa_list_pabrik").append('<li id="no'+(panjang+1)+'" style="padding-bottom:3px;"><textarea name="F01KOa_alamat_pabrik[]" id="F01KOa_alamat_pabrik" class="stext" rel="required"></textarea>&nbsp;<input type="button" name="F01KOa_del_pabrik" id="F01KOa_del_pabrik" onclick="del_element_div(\'ul#F01KOa_list_pabrik li#no'+(panjang+1)+'\', \'ul#F01KOa_list_pabrik\');" value=" x " title="Klik disini untuk menghapus alamat pabrik" /></li>');
		return false;
	});
	
	$("#F01KOa_add_mesin").click(function(){
		var panjang = $("#F01KOa_tboalat_produksi tr").length;
		$("#F01KOa_tboalat_produksi").append('<tr id="'+(panjang+1)+'"><td class="atas"><input type="text" name="F01KOa_jenis_mesin[]" class="stext" rel="required" /></td><td class="atas"><input type="text" name="F01KOa_fungsi_mesin" class="stext" rel="required" /></td><td class="atas"><input type="text" class="scode" rel="required" name="F01KOa_jumlah_mesin" /></td><td class="atas"><textarea class="stext" name="F10KOa_spesifikasi_mesin" rel="required" style="width:220px;"></textarea>&nbsp;<input type="button" name="F01KOa_del_mesin" value=" x " id="F01KOa_del_mesin" title="Klik disini untuk menghapus daftar peralatan produksi" style="float:right;" onclick="del_element_div(\'#F01KOa_tboalat_produksi tr#'+(panjang+1)+'\', \'#F01KOa_tbalat_produksi\');" /></td></tr>');
		return false;
	});

	$("#F01KOa_add_alat").click(function(){
		var panjang = $("#F01KOa_tboalat_laboratorium tr").length;
		$("#F01KOa_tboalat_laboratorium").append('<tr id="'+(panjang+1)+'"><td class="atas"><input type="text" name="F01KOa_nama_alat[]" class="stext" rel="required" /></td><td><input type="text" class="stext" name="F01KOa_merk_alat[]" rel="required" /></td><td><input type="text" name="F01KOa_type_alat[]" class="w100" rel="required" /></td><td><input type="text" name="F01KOa_kapasitas_alat[]" class="w100" rel="required" /></td><td><input type="text" class="scode" name="F01KOa_jumlah_alat[]" rel="required" />&nbsp;<input type="button" name="F01KOa_del_laboratorium" value=" x " id="F01KOa_del_laboratorium" title="Klik disini untuk menghapus daftar peralatan laboratorium" style="float:right;" onclick="del_element_div(\'#F01KOa_tboalat_laboratorium tr#'+(panjang+1)+'\', \'#F01KOa_tbalat_laboratorium\');" /></td></tr>');
		return false;
	});

		
});
	
</script>
<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f01KO_gola" id="f01KO_gola" method="post" action="<?php echo $act; ?>" autocomplete="off">
<div class="section">
      <ul class="tabs">
          <li class="current">DATA PERUSAHAAN</li>
          <li>DAFTAR PERLATAN PRODUKSI</li>
          <li>DAFTAR PERALATAN LABORATORIUM</li>
          <li>ASPEK PERIKSA</li>
      </ul>
      
      <div class="box visible">
   		<h2>DATA PERUSAHAAN</h2>
            <table id="F01KOa_tbperusahaan">
            	<tr><td class="atas isi" width="210">Nama Perusahaan</td><td width="30"></td><td><?php echo $namasarana_; ?></td></tr>
                <tr><td class="atas isi">Status</td><td></td><td><select name="F01KOa_status" id="F01KOa_status" class="stext"><option value="01">PMA</option><option value="02">PMDN</option><option value="03">Swasta Nasional</option></select></td></tr>
                <tr><td class="atas isi">Alamat (Kantor)</td><td></td><td><?php echo $alamat_; ?></td></tr>
                <tr id="F01KOa_tr_alamat_pabrik"><td class="atas isi">Alamat (Pabrik)</td><td></td><td>
                <ul id="F01KOa_list_pabrik" style="margin:0; padding:0; list-style:none;">
                	<li id="1" style="padding-bottom:3px;"><textarea name="F01KOa_alamat_pabrik[]" id="F01KOa_alamat_pabrik" class="stext" rel="required"></textarea>&nbsp;<input type="button" name="F01KOa_add_pabrik" id="F01KOa_add_pabrik" value="+" title="Klik disini untuk menambah alamat pabrik" /></li>
                </ul>
                </td></tr>
                <tr><td class="atas isi">Nama Pimpinan</td><td></td><td>Pimpinan </td></tr>
                <tr><td class="atas isi">Nama Penanggung Jawab</td><td></td><td><?php echo $penanggungjawab_; ?></td></tr>
                <tr><td class="atas isi">Penanggung Jawab Teknis</td><td></td><td></td></tr>
                <tr><td class="atas isi">Nama</td><td></td><td><input type="text" name="F01KOa_npjteknis" id="F01KOa_npjteknis" class="stext" rel="required" /></td></tr>
                <tr><td class="atas isi">Pendidikan</td><td></td><td><input type="text" name="F01KOa_ppjteknis" id="F01KOa_ppjteknis" class="stext" rel="required" /></td></tr>
                <tr><td class="atas isi">STRA</td><td></td><td><input type="text" name="F01KOa_srta" id="F01KOa_srta" class="stext" rel="required" /></td></tr>
                <tr><td class="atas isi">Bentuk sediaan yang diusulkan</td><td></td><td class="atas">
                <ul id="F01KOa_list_sediaan" style="margin:0; padding:0; list-style:none;">
                	<li id="1" style="padding-bottom:3px;"><input type="text" name="F01KOa_sediaan[]" class="stext" rel="required" />&nbsp;<input type="button" name="F01KOa_add_sediaan" id="F01KOa_add_sediaan" value="+" title="Klik disini untuk menambah daftar sediaan yang diusulkan" /></li>
                </ul>
                </td></tr>
                <tr>
                  <td class="atas isi">Petugas</td>
                  <td></td>
                  <td class="atas"><?php echo form_dropdown('F01KOa_petugas[]', $petugas, $selpetugas, 'class="stext multiple" rel="required" multiple="multiple"');?></td>
                </tr>
            </table>
      </div><!-- Akhir Data Perusahaan !-->
      
      <div class="box">
      		<h2>DAFTAR PERALATAN PRODUKSI</h2>
            <table id="F01KOa_tbalat_produksi" class="listtemuan">
            	<thead><tr><th>Jenis Mesin</th><th>Fungsi / Kegunaan Mesin</th><th>Jumlah</th><th>Spesifikasi</th></tr></thead>
                <tbody id="F01KOa_tboalat_produksi"><tr><td class="atas"><input type="text" name="F01KOa_jenis_mesin[]" class="stext" rel="required" /></td><td class="atas"><input type="text" name="F01KOa_fungsi_mesin" class="stext" rel="required" /></td><td class="atas"><input type="text" class="scode" rel="required" name="F01KOa_jumlah_mesin" /></td><td class="atas"><textarea class="stext" name="F10KOa_spesifikasi_mesin" rel="required" style="width:220px;"></textarea>&nbsp;<input type="button" name="F01KOa_add_mesin" value="+" id="F01KOa_add_mesin" title="Klik disini untuk menambah daftar peralatan produksi" style="float:right;" /></td></tr></tbody>
            </table>
      </div><!-- Akhir Daftar Peralatan Produksi !-->

      <div class="box">
      		<h2>DAFTAR PERALATAN LABORATORIUM</h2>
            <table id="F01KOa_tbalat_laboratorium" class="listtemuan">
            	<thead><tr><th>Nama Alat</th><th>Merk</th><th>Type</th><th>Kapasitas</th><th>Jumlah</th></tr></thead>
                <tbody id="F01KOa_tboalat_laboratorium"><tr><td class="atas"><input type="text" name="F01KOa_nama_alat[]" class="stext" rel="required" /></td><td><input type="text" class="stext" name="F01KOa_merk_alat[]" rel="required" /></td><td><input type="text" name="F01KOa_type_alat[]" class="w100" rel="required" /></td><td><input type="text" name="F01KOa_kapasitas_alat[]" class="w100" rel="required" /></td><td><input type="text" class="scode" name="F01KOa_jumlah_alat[]" rel="required" />&nbsp;<input type="button" name="F01KOa_add_alat" id="F01KOa_add_alat" value="+" title="Klik disini untuk menambah daftar peralatan laboratorium" /></td></tr></tbody>
            </table>
      </div><!-- Akhir Daftar Peralatan Laboratorium !-->

      <div class="box">
      		<h2>ASPEK PERIKSA</h2>
            <div id="tabs-gola">
            	<ul>
                	<li><a href="#gola-point-1">Point 1</a></li>
                    <li><a href="#gola-point-2">Point 2</a></li>
                	<li><a href="#gola-point-3">Point 3</a></li>
                    <li><a href="#gola-point-4">Point 4</a></li>
                	<li><a href="#gola-point-5">Point 5</a></li>
                    <li><a href="#gola-point-6">Point 6</a></li>
                	<li><a href="#gola-point-7">Point 7</a></li>
                    <li><a href="#gola-point-8">Point 8</a></li>
                	<li><a href="#gola-point-9">Point 9</a></li>
                    <li><a href="#gola-point-10">Point 10</a></li>
                </ul>
                
              <div id="gola-point-1">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin1" width="100%">
                    <tr>
                      <td class="atas isi" width="30">I.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Kepemimpinan, Organisasi dan SDM</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Kepemimpinan Tim  Manajemen</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Visi  dan Misi Perusahaan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Komitmen  kepada Mutu Produk</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Organisasi</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Struktur  Organisasi Perusahaan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Uraian  Tugas dan Tanggungjawab Manajer Supervisor</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">3.</td>
                      <td class="atas">Uraian  Tugas dan Tanggungjawab untuk Operator dan Analis</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td class="atas isi">Personalia,  Kesehatan dan Pelatihan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Kualifikasi  karyawan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia program pemeriksaan kesehatan </td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Fasilitas kerja (pakaian kerja, alas kaki)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Higiene perorangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">5.</td>
                      <td class="atas">Larangan  makan/minum, mengunyah, merokok dan meludah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia  format rencana dan jadwal pelatihan CPKB</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                </table>
                </div>
                
              <div id="gola-point-2">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin2" width="100%">
                    <tr>
                      <td class="atas isi" width="30">II.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Gambaran  Umum Sarana Bangunan dan Fasilitas Penunjang</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Sarana Bangunan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Desain  tata ruang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Kualifikasi  Material Bangunan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">3.</td>
                      <td class="atas">Lokasi  pabrik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">4.</td>
                      <td class="atas">Situasi  lingkungan pabrik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">5.</td>
                      <td class="atas">Lantai</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">6.</td>
                      <td class="atas">Langit-langit</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">7.</td>
                      <td class="atas">Dinding</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">8.</td>
                      <td class="atas">Pintu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Ventilasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">10.</td>
                      <td class="atas">Penerangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Fasilitas Penunjang</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Kesesuaian  desain tata ruang dengan persetujuan denah bangunan industri kosmetik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Sarana  penyedia air bersih</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Sarana  penyediaan air produksi dengan kualitas air minum</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">4.</td>
                      <td class="atas">Sistem  perpipaan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Penyediaan  gas alam/LPG/N2</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Penyediaan  udara bertekanan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">7.</td>
                      <td class="atas">Fasilitas  tempat makan dan minum</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">8.</td>
                      <td class="atas">Fasilitas  toilet dan wastafel</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Sistem  Air Handling Unit</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">10.</td>
                      <td class="atas">Sarana  Pembuangan Limbah Cair</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">11.</td>
                      <td class="atas">Locker  Karyawan Ruang Produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">12.</td>
                      <td class="atas">Locker  Karyawan Ruang Non Produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

              <div id="gola-point-3">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin3" width="100%">
                    <tr>
                      <td class="atas isi" width="30">III.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Gudang  Bahan Baku dan Pengemas</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Tenaga Kerja</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  pakaian kerja dan alas kaki untuk karyawan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  masker, sarung tangan, sepatu pengaman, pelindung kepala/helm untuk karyawan  gudang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Bangunan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Area  Karantina</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Area  penyimpanan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Area  penimbangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">4.</td>
                      <td class="atas">Gudang  Bahan Baku Khusus</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Pengamanan  Bahaya Kebakaran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">6.</td>
                      <td class="atas">Program Pest Control</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td class="atas isi">Peralatan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Timbangan  dan Alat Ukur</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Program  kalibrasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td class="atas isi">Sanitasi  dan Higiene</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tempat  cuci tangan (wastafel)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tempat  Sampah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">E.</td>
                      <td class="atas isi">Catatan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  format catatan persediaan bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  format catatan  persediaan bahan pengemas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia  format catatan  penerimaan bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F.</td>
                      <td class="atas isi">Label</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  format label identitas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  form label tanda pelulusan atau penolakan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">G.</td>
                      <td class="atas isi">Pengawasan Mutu</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia format pengambilan contoh bahan baku untuk pengujian mutu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format pengambilan contoh bahan pengemas primer untuk pengujian mutu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia metoda Pengambilan Contoh</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

              <div id="gola-point-4">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin4" width="100%">
                    <tr>
                      <td class="atas isi" width="30">IV.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Pengolahan</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Tenaga Kerja</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  pakaian kerja, penutup rambut, masker, sarung tangan dan alas kaki untuk  karyawan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  peraturan mencuci tangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Kualifikasi karyawan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Bangunan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Pengamanan  terhadap pencemaran silang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Kesesuaian  luas ruang kerja dengan kenyamanan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Lalu  lintas proses produksi dan manusia</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Kondisi  gudang  sementara </td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Lampu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Colokan  listrik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">7.</td>
                      <td class="atas">Konstruksi  mengandung kayu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">8.</td>
                      <td class="atas">Alat  untuk mencegah masuknya serangga dari ventilasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Alat  pengatur suhu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">10.</td>
                      <td class="atas">Pengolahan  produk yang mudah terbakar</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">11.</td>
                      <td class="atas">Motor  peralatan  dan Instalasi listrik dan keamanannya</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td class="atas isi">Peralatan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Kelengkapan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Permukaan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Bagian dari peralatan  tidak menahan sisa produk atau larutan pencuci</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia  format label status kebersihan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">5.</td>
                      <td class="atas">Pipa saluran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia form catatan  pemeliharaan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">7.</td>
                      <td class="atas">Alat timbang dan ukur  yang terkalibrasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td class="atas isi">Sanitasi  dan Higiene</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Air bersih</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Sarana membersihkan diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Kamar kecil/toilet</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Letak kamar kecil/toilet</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tempat cuci tangan  (wastafel)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia  peraturan mencuci tangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">7.</td>
                      <td class="atas">Letak kamar kecil/toilet  dengan daerah pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">8.</td>
                      <td class="atas">Kamar ganti</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Tempat sampah di dalam  ruang pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">10.</td>
                      <td class="atas">Tempat sampah di luar  ruang pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">11.</td>
                      <td class="atas">Tersedia format  catatan sanitasi peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">12.</td>
                      <td class="atas">Tersedia format  catatan pembersihan ruang pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">E.</td>

                      <td class="atas isi">Proses Pembuatan Secara Umum</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia format  catatan pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format  catatan produksi batch</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia format  penyimpangan kegiatan pengolahan dari prosedur tertulis yang telah ditentukan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia format  pencegahan kekeliruan pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia format  identitas produk antara dan produk ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia format kartu  produkantara atau produk ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">7.</td>
                      <td class="atas">Tersedia  label karantina produk antara dan atau produk ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">8.</td>
                      <td class="atas">Tersedia format identitas  penimbangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">9.</td>
                      <td class="atas">Pengecekan penimbangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">10.</td>
                      <td class="atas">Pengawasan kegiatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F.</td>
                      <td colspan="4" class="atas isi">Produksi Masing-masing Sediaan</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F1.</td>
                      <td class="atas isi">Perlengkapan Produksi Cairan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran  (mixer)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Alat/mesin pengisian  (filling machine)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F2.</td>
                      <td colspan="4" class="atas isi">Perlengkapan Produksi Sediaan Setengah Padat</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran  adonan setengah padat</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Alat/mesin pengisian ke  dalam wadah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F3.</td>
                      <td colspan="4" class="atas isi">Perlengkapan Produksi Sediaan Padat</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Alat/mesin cetak</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Oven pengeringan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">4.</td>
                      <td class="atas">Alat/mesin pengisian ke  dalam wadah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F4.</td>
                      <td colspan="4" class="atas isi">Perlengkapan Produksi Sediaan Lipstik</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran  adonan lipstik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Alat/mesin cetak lipstik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Mesin Freezer</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">4.</td>
                      <td class="atas">Proses pengkilapan  lipstik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">5.</td>
                      <td class="atas">Alat/mesin pengisian ke  dalam wadah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F5.</td>
                      <td colspan="4" class="atas isi">Perlengkapan Produksi Sediaan Serbuk</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran  serbuk</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Mesin penghisap debu  (Dust collector)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Alat/mesin pengisian ke  dalam wadah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F6.</td>
                      <td colspan="4" class="atas isi">Perlengkapan Produksi Sediaan Cream, Gel, Salep, dan Pasta</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran  cream, gel, salep, dan pasta</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Alat/mesin pemanas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Alat/mesin pengisian ke  dalam wadah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F7.</td>
                      <td class="atas isi">Perlengkapan Produksi Sediaan Aerosol</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Alat/mesin pencampuran  cairan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Alat/mesin pengisian  cairan ke dalam wadah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Mesin crimper</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">4.</td>
                      <td class="atas">Proses pengisian  propelan (gas)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Penempatan mesin dalam  ruang produksi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>
                
              <div id="gola-point-5">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin5" width="100%">
                    <tr>
                      <td class="atas isi" width="30">V.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Area Pengemasan</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Tenaga Kerja</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  pakaian kerja, penutup rambut, masker, sarung tangan dan alas kaki untuk  karyawan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Bangunan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Area karantina</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Area penyimpanan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td class="atas isi">Peralatan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">1.</td>
                      <td class="atas">Kelengkapan  peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  format label satus kebersihan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">3.</td>
                      <td class="atas">Permukaan  peralatan tidak bereaksi dengan produk ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">4.</td>
                      <td class="atas">Permukaan  peralatan tidak mengabsorbsi produk ruahan </td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">5.</td>
                      <td class="atas">Permukaan  peralatan tidak melepaskan serpihan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Peralatan  mudah dibongkar dan dipasang kembali</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">7.</td>
                      <td class="atas">Tersedia  prosedur pembersihan alat</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">8.</td>
                      <td class="atas">Tidak  ada bagian pada alat yang menahan sisa produk atau larutan pencuci</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Keamanan  motor peralatan dan instalasi listrik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">10.</td>
                      <td class="atas">Pipa  saluran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">11.</td>
                      <td class="atas">Penandaan  pada pipa</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">12.</td>
                      <td class="atas">Alat  yang terkalibrasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td class="atas isi">Sanitasi  dan Higiene</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Air bersih</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Fasilitas  membersihkan diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">3.</td>
                      <td class="atas">Letak  fasilitas membersihkan diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">4.</td>
                      <td class="atas">Kamar  kecil/toilet</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">5.</td>
                      <td class="atas">Letak  kamar kecil/toilet</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Letak  kamar kecil/toilet dengan daerah pengemasan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">7.</td>
                      <td class="atas">Tempat  cuci tangan (Wastafel)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">8.</td>
                      <td class="atas">Tersedia  peraturan harus mencuci tangan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">9.</td>
                      <td class="atas">Kamar  ganti</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">10.</td>
                      <td class="atas">Tempat  sampah di dalam Ruang Pengemasan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">11.</td>
                      <td class="atas">Tempat  sampah di luar Ruang Pengemasan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">E.</td>

                      <td class="atas isi">Pengemasan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  format catatan penerimaan dan identifikasi produk  ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia  format catatan  untuk penerimaan dan identifikasi bahan kemasan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia  format catatan  untuk penerimaan dan identifikasi penandaannya</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia  format untuk  pengawasan kegiatan pengawasan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia  format rekonsiliasi  produk ruahan dan bahan pengemas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

              <div id="gola-point-6">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin6" width="100%">
                    <tr>
                      <td class="atas isi" width="30">VI.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Gudang Produk Jadi</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Tenaga Kerja</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia  pakaian kerja, alas kaki, sepatu pengaman, pelindung kepala/helm untuk karyawan  gudang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Bangunan</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Area karantina</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Area penyimpanan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Pengamanan  bahaya kebakaran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia  program <em>pest control</em></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td class="atas isi">Sanitasi dan Higiene</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tempat  cuci tangan (Wastafel)</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">m</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tempat sampah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td class="atas isi">Kartu Produk Jadi</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia form kartu produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

              <div id="gola-point-7">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin7" width="100%">
                    <tr>
                      <td class="atas isi" width="30">VII.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Pengawasan Mutu</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td width="20" class="atas">1.</td>
                      <td width="300" class="atas">Peralatan laboratorium</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format catatan pengambilan  contoh</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia format catatan dan laporan  pengujian bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia format catatan dan laporan  pengujian bahan pengemas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia format catatan dan laporan  pengujian produk antara dan ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia format catatan dan laporan  pengujian produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">7.</td>
                      <td class="atas">Ruang laboratorium kimia yang terpisah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">8.</td>
                      <td class="atas">Ruang laboratorium instrumen yang terpisah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Ruang laboratorium mikrobiologi yang terpisah</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">10.</td>
                      <td class="atas">Tersedia format catatan untuk  penanganan produk kembalian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">11.</td>
                      <td class="atas">Tersedia format catatan untuk  penanganan keluhan konsumen</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">12.</td>
                      <td class="atas">Tersedia format pengembalian produk  dan keputusan bagian pengawasanmutu</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">13.</td>
                      <td class="atas">Tersedia format catatan untuk  penanganan penarikan produk dari peredaran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">14.</td>
                      <td class="atas">Tersedia format catatan untuk  penanganan contoh pertinggal</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">15.</td>
                      <td class="atas">Tersedia format catatan untuk  kalibrasi alat</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">16.</td>
                      <td class="atas">Tersedia format catatan untuk validasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">17.</td>
                      <td class="atas">Tersedia format catatan unuk penilaian  pemasok</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">18.</td>
                      <td class="atas">Tersedia format catatan untuk  pemeriksaan stabilitas dan penetapan batas waktu penggunaan produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">19.</td>
                      <td class="atas">Tersedia format catatan pengujian mutu  yang dilaksanakan pihak lain</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">20.</td>
                      <td class="atas">Sertifikat hasil pengujian mutu </td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">21.</td>
                      <td class="atas">Tersedia prosedur pemeriksaan dan uji ulang  persediaan bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">22.</td>
                      <td class="atas">Tersedia format label identitas dan label status</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">23.</td>
                      <td class="atas">Tersedia format catatan distribusi  produk</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">C</td>
                      <td class="atas">24.</td>
                      <td class="atas">Sarana yang sesuai dan aman untuk pembuangan limbah  serta bahan sisa yang akan dibuang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

                <div id="gola-point-8">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin8" width="100%">
                    <tr>
                      <td class="atas isi" width="30">VIII.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Pengawasan Mutu</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td width="20" class="atas">1.</td>
                      <td width="300" class="atas">Tersedia format tim  inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format jadwal pelaksanaan  inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia format daftar kegiatan yang dilaksanakan  pada inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia format catatan inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia format laporan inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia format catatan pelaksanaan  tindak lanjut inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

              <div id="gola-point-9">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin9" width="100%">
                    <tr>
                      <td class="atas isi" width="30">IX.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Dokumentasi</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td width="20" class="atas isi">A.</td>
                      <td width="300" class="atas isi">Dokumentasi Spesifikasi</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia format spesifikasi bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia format spesifikasi bahan  pengemas primer</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia format spesifikasi bahan  pengemas sekunder</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia format spesifikasi produk  antara dan atau ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia format spesifikasi produk  jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">B.</td>
                      <td class="atas isi">Dokumentasi Produksi</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia draft dokumentasi prosedur kerja baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia draft prosedur kerja baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia draft prosedur penerimaan dan identifikasi  produk ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk penerimaan  dan identifikasi bahan pengemas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk penerimaan  dan identifikasi penandaannya</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">C.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Pengawasan Mutu</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia draft prosedur pengambilan contoh</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia draft metoda pengujian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia draft prosedur dan metoda pengambilan  contoh bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia draft prosedur dan metoda pengambilan  contoh bahan pengemas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia draft prosedur dan metoda pengambilan  contoh produk antara dan ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia draft prosedur dan metoda pengambilan  contoh produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">7.</td>
                      <td class="atas">Tersedia draft prosedur pemeriksaan dan metoda  pengujian bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">8.</td>
                      <td class="atas">pemeriksaan dan metoda pengujian bahan pengemas</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Tersedia draft prosedur pemeriksaan dan metoda  pengujian produk antara dan ruahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">10.</td>
                      <td class="atas">Tersedia draft prosedur pemeriksaan dan metoda  pengujian produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">11.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk penanganan  produk kembalian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">12.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk penanganan  keluhan konsumen</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">13.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk penanganan  penarikan kosmetika dari perdaran</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">14.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk penanganan  contoh pertinggal</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">15.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk kalibrasi  alat</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">16.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk validasi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">17.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk nilai pemasok</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">18.</td>
                      <td class="atas">Tersedia draft prosedur tertulis untuk pemeriksaan  stabilitas dan penetapan batas waktu penggunaan produk jadi</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">19.</td>
                      <td class="atas">Tersedia draft prosedur pengujian mutu yang  dilaksanakan pihak lain</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">D.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Dalam Pemeliharaan, Pembersihan dan Pengendalian Ruangan  Serta Peralatan</td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia draft prosedur tetap pemakaian alat dan  pengamanan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia draft prosedur pemeliharaan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia draft prosedur pembersihan peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia draft prosedur pembersihan dan sanitasi ruang pengolahan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia draft prosedur pembasmian hama</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">6.</td>
                      <td class="atas">Tersedia draft prosedur pemantauan jasad renik</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">7.</td>
                      <td class="atas">Tersedia draft prosedur sanitasi bangunan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">8.</td>
                      <td class="atas">Tersedia draft prosedur sanitasi peralatan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">9.</td>
                      <td class="atas">Tersedia draft prosedur sanitasi gudang</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">E.</td>

                      <td colspan="4" class="atas isi">Dokumentasi Dalam Penanganan Keluhan, Kosmetika yang Ditarik, Kosmetika  Kembalian, Pemusnahan Bahan Baku dan Kosmetika</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia draft prosedur penanganan keluhan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia draft prosedur penarikan kosmetika</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia draft prosedur penanganan kosmetika  kembalian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia draft prosedur pemusnahan bahan baku</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">5.</td>
                      <td class="atas">Tersedia draft prosedur pemusnahan kosmetika</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">F.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Inspeksi Diri</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia draft prosedur inspeksi diri</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">&nbsp;</td>
                      <td class="atas isi">G.</td>
                      <td colspan="4" class="atas isi">Dokumentasi Pelatihan CPKB Bagi Tenaga Kerja</td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">1.</td>
                      <td class="atas">Tersedia pedoman pelatihan CPKB</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas"><p>Tersedia format evaluasi  pelatihan CPKB</p></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

              <div id="gola-point-10">
                <table id="F01KO_head" width="100%">
                    <tr><td class="atas isi" width="30">No.</td><td class="atas isi" width="100">Tingkat Kekeritisan</td><td class="atas isi" width="325">Uraian</td><td class="atas isi" width="50">Ada</td>
                    <td class="atas isi" width="50">Tidak</td><td class="atas isi">Keterangan</td></tr>
                </table>
    
                <table id="F01KO_head_poin10" width="100%">
                    <tr>
                      <td class="atas isi" width="30">X.</td>
                      <td class="atas isi" width="100">&nbsp;</td>
                      <td colspan="2" class="atas isi">Pengawasan Mutu</td>
                    <td class="atas isi" width="50">&nbsp;</td><td class="atas isi" width="50">&nbsp;</td><td class="atas isi">&nbsp;</td></tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td width="20" class="atas">1.</td>
                      <td width="300" class="atas">Tersedia draft prosedur penanganan keluhan</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                  </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">2.</td>
                      <td class="atas">Tersedia draft prosedur penarikan produk</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">3.</td>
                      <td class="atas">Tersedia draft prosedur penanganan produk kembalian</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                    <tr>
                      <td class="atas">&nbsp;</td>
                      <td class="atas">M</td>
                      <td class="atas">4.</td>
                      <td class="atas">Tersedia draft prosedur pemusnahan produk</td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_true" id="F01KO_gola_true" /></td>
                      <td class="atas"><input type="checkbox" name="F01KO_gola_false" id="F01KO_gola_false" /></td>
                      <td class="atas"><textarea name="F01KO_gola_ket" id="F01KO_gola_ket" class="stext small"></textarea></td>
                    </tr>
                </table>
                </div>

            </div>            
      </div><!-- Akhir Aspek Periksa !-->
      
      
</div>      


<div><input type="submit" id="btncancel" value="" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;" /><input type="submit" id="btnsave" value="" onclick="fpost('#f01KO_gola','',''); return false" /></div>
<div id="clear_fix"></div>
</form>
</div>
