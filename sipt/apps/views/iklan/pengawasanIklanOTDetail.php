<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN OBAT TRADISIONAL <?php echo $subJudul; ?></div>
<?php
$bulan_iklan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$bulan_iklan_val = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
$tahun_iklan = array(range(date("Y"), 2007));
$totalThn = array_sum(array_map("count", $tahun_iklan));
$UP = explode('#', $sess['URAIAN_PELANGGARAN']);
$tayangMedia = explode(" ", $sess['JAM_TAYANG']);
$edisiUraian = explode("^", $sess['EDISI']);
$edisiMedia = explode(" ", $edisiUraian[0]);
$pemusnahan = explode("^", $sess['PEMUSNAHAN']);
$sess['FILE_MUSNAH'] = $pemusnahan[2];
?>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_010">
  <div class="adCntnr">
   <div class="acco2">
    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGAWASAN IKLAN  </a></div>
    <div class="collapse">
     <div class="accCntnt">
      <table class="form_tabel">
       <tr class="urut<?php echo $i; ?>" hidden="true">
        <td class="atas">Unit / Balai Besar / Balai</td>
        <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
       </tr>
      </table>
      <br />
      <div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
      <div style="height:15px;"></div>
      <table class="form_tabel">
       <tr><td class="td_left">Tanggal Pengawasan</td><td class="td_right">
         <input type="hidden" class="sdate" name="IKLAN[TANGGALSURAT]" id="tglXX<?php echo $i; ?>" title="Tanggal Surat" value="<?php
         if ($this->session->userdata('TANGGAL') != "-" && !$sess['TGL_SURAT']) {
          echo $this->session->userdata('TANGGAL');
         } else if ($sess['TGL_SURAT'] != NULL) {
          echo $sess['TGL_SURAT'];
         }
         else
          echo $sess['TANGGAL_MULAI'];
         ?>"/>
         <input type="text" class="sdate" name="IKLAN[TANGGALAWAL]" id="tglAwalPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('A')" rel='required' value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
         <input type="text" class="sdate" name="IKLAN[TANGGALAKHIR]" id="tglAkhirPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('B')" rel='required' value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
       </tr>
      </table>
     </div>
    </div><!-- Akhir Pemeriksaan !-->
    <div style="height:5px;"></div>
    <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI OBAT TRADISIONAL - IKLAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table>
        <tr>
         <td>
          <table>
           <tbody id="tb_OT">
            <?php
            $jmldata = 0;
            $data = $sess2;
            $jmldata = count($data);
            if ($jmldata == 0) {
             $jmldata = 1;
             $data[] = "";
            }
            $i = 0;
            do {
             $A = explode("_", $sess2[$i]['JENIS_PRODUK']);
             ?>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nama Obat Tradisional</td>
              <td>
               <input type="text" size="40" name="PRODUK[NAMA][]" class="namaOT" id="namaOT" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama OT" rel="required" value="<?php echo $sess2[$i]['NAMA_PRODUK']; ?>" />&nbsp;
               <?php
               if ($i == 0) {
                ?>
                <a href="javascript:void(0)" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah OT" /></a>
                <?php
               } else {
                ?>
                <a href="javascript:void(0)" class="min" onclick="$('.urut<?php echo $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus OT" /></a>
                <?php
               }
               ?></td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Bentuk Sediaan</td>
              <td><input type="text" size="40" name="PRODUK[BENTUKSEDIAAN][]" id="bentukSediaan" title="Bentuk Sediaan" value="<?php echo $sess2[$i]['BENTUK_SEDIAAN']; ?>" />
              </td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nama Pemilik Izin Edar</td>
              <td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE" title="Pemilik Izin Edar" value="<?php echo $sess2[$i]['NAMA_PEMILIK_IZIN_EDAR']; ?>" />
              </td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nomor Izin Edar</td>
              <td><input type="text" size="40" name="PRODUK[NOMORIZINEDAR][]" id="NIE" title="Nomor Izin Edar" value="<?php echo $sess2[$i]['NOMOR_IZIN_EDAR']; ?>" />
              </td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td>Kategori Produk</td><td>
               <span class="kategoriNormal<?php echo $i; ?>"><?php echo form_dropdown('PRODUK[JENIS][]', $jenisProduk, $sess2[$i]['JENIS_PRODUK'], 'title="Golongan OT" rel="required" class="chkKategoriProdukCls" id="chkKategoriProduk' . $i . '" terakhir="' . $i . '"') ?></span><span class="kategoriLain<?php echo $i; ?>" hidden>&nbsp;&nbsp;<input type="text" size="40" name="PRODUK[GOLONGAN][]" class="kategoriLain<?php echo $i; ?>" title="Golongan lain -lain" value="<?php echo $sess2[$i]['GOLONGAN_PRODUK']; ?>" /></span>
              </td>
             </tr>
             <?php
             if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
              ?>
              <tr class="urut<?php echo $i; ?>">
               <td width="150">Evaluasi Premarket</td>
               <td><?php echo form_dropdown('PRODUK[MERK_PRODUK][]', array("" => "", 0 => "Iklan sudah dipre-review", 1 => "Iklan belum dipre-review"), $sess2[$i]['MERK_PRODUK'], 'title="Evaluasi Premarket" id="chkEvaluasi" rel="required" terakhir="' . $i . '"') ?>
               </td>
              </tr>
              <?php
             }
             $i++;
            } while ($i < $jmldata)
            ?>
           </tbody>
          </table>
         </td></tr>
       </table>
      </div>
     </div>
    </div>
    <div style="height:5px;"></div>

    <!-- DIV Detail-->
    <div>
     <!--1-->
     <div class="expand" id="expand1"><a title="expand/collapse" href="#" style="display: block;">IDENTITAS MEDIA PENAYANGAN IKLAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel_detail">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Jenis Iklan</td>
         <td></td>
         <td colspan="2" class="td_left"><select name="IKLAN[JENISIKLAN]" onChange="mediaIklan2();" id="iklan_media" class="sjenis sl_iklan_media" title="Jenis Iklan" rel="required">
           <option value=""></option>
           <option value="Cetak">Cetak</option>
           <option value="Elektronik">Elektronik</option>
           <option value="Luar Ruang">Luar Ruang</option></select></td>
        </tr>
        <tr class="iklanObatReq iorMedia">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Media</td>
         <td></td>
         <td colspan="2" class="td_left elektronikChoosed" hidden>
          <select class="stext mediaIklanEdit" id="eChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
           <option value=""></option>
           <option value="TV">TV</option>
           <option value="Radio">Radio</option>
           <option value="Internet">Internet</option>
           <option value="Iklan Baris">Iklan Baris</option>
           <option value="Bioskop">Bioskop</option>
           <option value="Megatron">Megatron</option>
           <option value="Lainnya">Media Teknologi Informasi Lainnya</option></select></td>
         <td colspan="2" class="td_left lRChoosed" hidden>
          <select class="stext mediaIklanEdit" id="lrChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
           <option value=""></option>
           <option value="Billboard">Billboard</option>
           <option value="Neon Box">Lampu Hias / Neon Box</option>
           <option value="Papan Nama">Papan Nama</option>
           <option value="Spanduk">Spanduk</option>
           <option value="Balon Udara">Balon Udara</option>
           <option value="Transit Ad (Iklan pada sarana transportasi)">Transit Ad (Iklan pada sarana transportasi)</option>
           <option value="Hanging Mobil">Hanging Mobil</option>
           <option value="Iklan Dinding">Iklan Dinding</option>
           <option value="Gimmick">Gimmick</option>
           <option value="Backdrop">Backdrop</option>
           <option value="Baliho">Baliho</option></select></td>
         <td colspan="2" class="td_left cetakChoosed">
          <select class="stext mediaIklanEdit" id="cChoosed" name="IKLAN[MEDIA][]" onChange="mediaIklan(this);" title="Media Iklan">
           <option value=""></option>
           <option value="Surat Kabar">Surat Kabar</option>
           <option value="Majalah">Majalah</option>
           <option value="Tabloid">Tabloid</option>
           <option value="Buletin">Buletin</option>
           <option value="Poster / Selebaran">Poster / Selebaran</option>
           <option value="Leaflet / Brosur">Leaflet / Brosur</option>
           <option value="Stiker">Stiker</option>
           <option value="Banner">Banner</option>
           <option value="Booklet / Katalog">Booklet / Katalog</option>
           <option value="Pamflet">Pamflet</option>
           <option value="Halaman Kuning">Halaman Kuning</option>
           <option value="Kalender ">Kalender</option>
           <option value="lainnya">Media Cetak Lainnya</option></select></td>
        </tr>
        <tr class="td_left" id="namaMedia" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><span id ="namaMedia1"></span></td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left_checklist"><input type="text" id="namaMediaIklan" class="stext namaMedia" title="Nama Media" url="<?php echo site_url(); ?>/autocompletes/autocomplete/nama_media/" value="<?php echo $sess['NAMA_MEDIA']; ?>" /><input type="hidden" id="idMediaIklan"  value="<?php echo $sess['ID_MEDIA']; ?>" /></td>
        </tr>
        <tr class="td_left promoBased" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Judul Kegiatan</td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left_checklist"><input type="text" class="stext" id="judulKegiatan" name="IKLAN[JUDUL]" title="Judul Kegiatan" value="<?php echo $sess['JUDUL_KEGIATAN']; ?>" /></td>
        </tr>
        <tr id="tglTerbit">
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Tanggal Penerbitan / Tanggal Penayangan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="sdate" name="IKLAN[TANGGAL]" id="tglTugas" title="Tanggal Penerbitan / Tanggal Penayangan" onchange="comp('C')" value="<?php echo $sess['TANGGAL']; ?>"/>&nbsp;&nbsp;
        </tr>
        <tr id="edisiTime" hidden>
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Edisi Media Iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2">
          <span><select class="edisiTayang edisiCetak" title="Tahun" name="IKLAN[EDISI1]" style="height: 21px"><option value=""></option><?php
            for ($i = 0; $i < $totalThn; $i++) {
             ?><option value="<?php echo $tahun_iklan[0][$i]; ?>"><?php echo $tahun_iklan[0][$i]; ?></option><?php } ?></select>&nbsp;&nbsp;<select class="edisiTayang edisiCetak" title="Bulan" name="IKLAN[EDISI2]" style="height: 21px"><option value=""></option><?php
            for ($i = 0; $i < 12; $i++) {
             ?><option value="<?php echo $bulan_iklan[$i]; ?>"><?php echo $bulan_iklan[$i]; ?></option><?php } ?></select></span>&nbsp;&nbsp;
          <input type="text" name="IKLAN[EDISI3]" title="Edisi" class="stext edisiTayang edisiCetak" value="<?php echo $edisiUraian[1] ?>"/>
         </td>
        </tr>
        <tr id="tayangTime" hidden>
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Jam Tayang Media Iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2">
          <span><select class="edisiTayang edisiTV" title="Jam" name="IKLAN[TAYANG1]"><option value=""></option><?php
            for ($i = 1; $i <= 24; $i++) {
             ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select> : <select class="edisiTayang edisiTV" title="Jam" name="IKLAN[TAYANG2]"><option value=""></option><?php
            for ($i = 1; $i < 60; $i++) {
             ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;hh : mm</span>
         </td>
        </tr>
        <tr class="cetakTertentu">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Nama Lokasi Pengambilan Iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input name="IKLAN[LOKASI]" type="text" class="stext" id="namaLokasi" title="Nama Lokasi" value="<?php echo $sess['NAMA_LOKASI_IKLAN']; ?>"/>
        </tr>
        <tr class="cetakTertentu">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Alamat Lokasi Pengawasan Iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><textarea class="stext cetakTertentu" id="alamatLokasi" title="Alamat Lokasi Pengambilan Iklan" name="IKLAN[ALAMAT]"><?php echo $sess['ALAMAT_LOKASI_IKLAN']; ?></textarea></td>
        </tr>
        <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?>
         <tr class="ifElektronik">
          <td class="td_left_checklist"></td>
          <td class="td_left_header_checklist" style="vertical-align: top;">Provinsi</td>
          <td></td>
          <td style="width: 10%;" colspan="2" class="td_left_checklist"><?php echo form_dropdown('KOTA', $provinsi, $provinsiVal, 'style="width:158px" id="provkotAlamat" class="stext" rel="required" title="Nama Provinsi Pengambilan Iklan"'); ?></td>
         </tr>
        <?php } ?>
        <tr class="ifElektronik">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Kota / Kabupaten</td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left_checklist"><?php echo form_dropdown('IKLAN[KOTA]', $kabupaten, $kabupatenVal, 'style="width:158px" id="kabkotAlamat" class="stext" title="Nama Kota Pengambilan Iklan"'); ?></td>
        </tr>
       </table>
      </div>
     </div>
     <div style="height:5px;" id="expand2b"></div>

     <!--4-->
     <div class="expand" id="expand4"><a title="expand/collapse" href="#" style="display: block;">NARASI / KLAIM IKLAN</a></div>
     <div class="collapse">
      <div class="accCntnt" id="expand4a">
       <table class="form_tabel_detail">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Narasi / Klaim Iklan</td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left_checklist"><textarea style="width: 98%; height: 75px;" class="stext" title="Narasi / Klaim Iklan" name="IKLANOT[NARASI]" rel="required"><?php echo $sess['NARASI']; ?></textarea></td>
        </tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>

     <!--5-->
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel_detail">
        <tr class="hashStar">
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian0" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="0"/>&nbsp;Iklan produk tanpa izin edar (TIE)</td><input type="hidden" class="uPelanggaran" id="uraian0" name="UPELANGGARAN[0]" title="Uraian Pelanggaran" value="<?php echo $UP[0]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian1" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="1" />&nbsp;Testimoni</td><input type="hidden" class="uPelanggaran" id="uraian1" name="UPELANGGARAN[1]" title="Uraian Pelanggaran" value="<?php echo $UP[1]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian2" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="2" />&nbsp;Menawarkan hadiah/ garansi/ gratis</td><input type="hidden" class="uPelanggaran" id="uraian2" name="UPELANGGARAN[2]" title="Uraian Pelanggaran" value="<?php echo $UP[2]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian3" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="3" />&nbsp;Berlebihan</td><input type="hidden" class="uPelanggaran" id="uraian3" name="UPELANGGARAN[3]" title="Uraian Pelanggaran" value="<?php echo $UP[3]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian4" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="4" />&nbsp;Mengiklankan produk yang perlu diagnosa dan penanganan dokter (kanker, diabetes, liver, TBC, dll)</td><input type="hidden" class="uPelanggaran" id="uraian4" name="UPELANGGARAN[4]" title="Uraian Pelanggaran" value="<?php echo $UP[4]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian5" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="5" />&nbsp;Gambar tidak etis</td><input type="hidden" class="uPelanggaran" id="uraian5" name="UPELANGGARAN[5]" title="Uraian Pelanggaran" value="<?php echo $UP[5]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian6" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="6" />&nbsp;Diperankan oleh tenaga kesehatan/ setting atribut profesi kesehatan/ tokoh agama/ guru/ tokoh masyarakat/ pejabat publik</td><input type="hidden" class="uPelanggaran" id="uraian6" name="UPELANGGARAN[6]" title="Uraian Pelanggaran" value="<?php echo $UP[6]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian7" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="7" />&nbsp;Iklan dengan pemeran anak-anak dan keputusan diambil oleh anak-anak</td><input type="hidden" class="uPelanggaran" id="uraian7" name="UPELANGGARAN[7]" title="Uraian Pelanggaran" value="<?php echo $UP[7]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian8" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="8" />&nbsp;Mencantumkan grafik hasil penelitian tanpa data pendukung yang kuat</td><input type="hidden" class="uPelanggaran" id="uraian8" name="UPELANGGARAN[8]" title="Uraian Pelanggaran" value="<?php echo $UP[8]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian9" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="9" />&nbsp;Iklan produk hanya dalam bahasa asing yang tidak dipahami secara umum</td><input type="hidden" class="uPelanggaran" id="uraian9" name="UPELANGGARAN[9]" title="Uraian Pelanggaran" value="<?php echo $UP[9]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian10" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="10" />&nbsp;Mencantumkan gambar organ tubuh bagian dalam</td><input type="hidden" class="uPelanggaran" id="uraian10" name="UPELANGGARAN[10]" title="Uraian Pelanggaran" value="<?php echo $UP[10]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian11" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="11" />&nbsp;Mencantumkan gambar simplisia yang tidak terdapat dalam komposisi</td><input type="hidden" class="uPelanggaran" id="uraian11" name="UPELANGGARAN[11]" title="Uraian Pelanggaran" value="<?php echo $UP[11]; ?>">
        </tr>
        <tr class="hashStar">
         <td class="td_left_checklist">&nbsp;</td>
         <td class="td_left_header_checklist" style="vertical-align: top;" colspan="4"><input class="uraianPelanggaran" type="checkbox" name="uraian12" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" val="12" />&nbsp;Tidak mencantumkan spot peringatan</td><input type="hidden" class="uPelanggaran" id="uraian12" name="UPELANGGARAN[12]" title="Uraian Pelanggaran" value="<?php echo $UP[12]; ?>">
        </tr>
       </table>
      </div>
     </div>
     <div style="height:5px;" id="expand6b"></div>

     <!--7-->
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel_detail">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist"><b>Hasil Penilaian</b></td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="6">
          <input type="text" id="kesimpulanHasilPenilaian" readonly size="25" title="Hasil Kesimpulan" value="<?php
          if ($sess['HASIL'] == 'TMK')
           echo 'Tidak Memenuhi Ketentuan';
          else
           echo 'Memenuhi Ketentuan';
          ?>" />
          <input type="hidden" id="kesimpulanHasilPenilaianVal" name="IKLAN[HASIL]" value="<?php
          if (trim($sess['HASIL']) == "")
           echo "MK";
          else
           echo $sess['HASIL'];
          ?>" /></td>
        </tr>
        <?php
        //Balai
        if (!in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
         ?>
         <tr class="TDKB" hidden><td class="td_left_checklist"></td><td class="td_left">Tindak Lanjut Balai</td><td></td><td class="td_right"><?php echo form_dropdown('IKLAN[TL_BALAI]', $cb_tindakan_balai, $sess['TL_BALAI'], 'class="stext" id="tDKBalai" title="Tindak Lanjut Balai"'); ?></td></tr>
         <tr class="tDKBalaiRow" hidden><td class="td_left_checklist"></td><td class="td_left"></td><td></td><td class="td_right"><input type="text" class="tDKBalaiRow" id="jmlMusnah" title="Jumlah" placeholder = "Jumlah" maxlength="5" size="5" value="<?php echo $pemusnahan[0] ?>"/>&nbsp;<input type="text" class="tDKBalaiRow" id="satuanMusnah" title="Satuan" placeholder = "Satuan" size="10" value="<?php echo $pemusnahan[1] ?>"/>&nbsp;
           <?php
           if ((array_key_exists('FILE_MUSNAH', $sess) && trim($sess['FILE_MUSNAH']) != "")) {
            ?><input type="hidden" id = "fileMusnah" value="<?php echo $sess['FILE_IKLAN_MUSNAH']; ?>">
            <span id="file_FILE_MUSNAH"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" id = "del_upload1" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'iklan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH']; ?>" jns="FILE_MUSNAH">Edit atau Hapus File ?</a></span>
            <span class="upload_FILE_MUSNAH" hidden><input type="file" class="uploadMusnahBalai tDKBalaiRow" jenis="FILE_MUSNAH" allowed="doc-docx-pdf-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_010/2_010'; ?>" id="fileToUpload_FILE_MUSNAH" name="userfile" onchange="do_upload($(this));
             return false;" title="Lampiran Berita Acara" />
             &nbsp;Tipe File : *.doc .docx .pdf .rar</span><span class="file_FILE_MUSNAH"></span>
            <?php
           } else {
            ?>
            <span class="upload_FILE_MUSNAH"><input type="file" class="uploadMusnahBalai tDKBalaiRow" jenis="FILE_MUSNAH" allowed="doc-docx-pdf-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_010/2_010'; ?>" id="fileToUpload_FILE_MUSNAH" name="userfile" onchange="do_upload($(this));
             return false;" title="Lampiran Berita Acara"/>
             &nbsp;Tipe File : *.doc .docx .pdf .rar</span><span class="file_FILE_MUSNAH"></span>
            <?php
           }
           ?></td></tr>
          <?php
         }
         //Pusat
         if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
          if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
           ?>
          <tr><td class="td_left_checklist"></td><td class="td_left">Verifikasi Pusat</td><td></td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
          <tr class="vTMK" hidden><td class="td_left_checklist"></td><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td></td><td class="td_right" style="background-color: white;"><span id="nonCetak" hidden><?php echo form_dropdown('', $cb_tindakan, $sess['TL_PUSAT'], 'class="stext vTMK vTMKSub nonCetak" title="Tindak Lanjut Pusat"'); ?></span><span id="ygCetak" hidden><?php echo form_dropdown('', $cb_tindakan2, $sess['TL_PUSAT'], 'class="stext vTMK vTMKSub ygCetak" title="Tindak Lanjut Pusat"'); ?></span></td></tr>
          <tr class="vTMK2" hidden><td class="td_left_checklist"></td><td class="td_left"></td><td></td><td class="td_right"><input type="text" class="vTMK2" id="jmlMusnahPusat" title="Jumlah" placeholder = "Jumlah" maxlength="4" size="5" value="<?php echo $pemusnahanPusat[0] ?>"/>&nbsp;<input type="text" class="vTMK2" id="satuanMusnahPusat" title="Satuan" placeholder = "Satuan" size="10" value="<?php echo $pemusnahanPusat[1] ?>"/></td></tr>
          <tr class="vTMK2" hidden><td class="td_left_checklist"></td><td class="td_left"></td><td></td><td class="td_right">
            <?php
            if ((array_key_exists('FILE_MUSNAH_PUSAT', $sess) && trim($sess['FILE_MUSNAH_PUSAT']) != "")) {
             ?><input type="hidden" id = "fileMusnahPusat" value="<?php echo $sess['FILE_IKLAN_MUSNAH_PUSAT']; ?>">
             <span id="file_FILE_MUSNAH_PUSAT"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH_PUSAT']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" id="del_upload2" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'iklan_010/2_010'; ?>/<?php echo $sess['FILE_MUSNAH_PUSAT']; ?>" jns="FILE_MUSNAH_PUSAT">Edit atau Hapus File ?</a></span>
             <span class="upload_FILE_MUSNAH_PUSAT" hidden><input type="file" class="uploadMusnahPusat" jenis="FILE_MUSNAH_PUSAT" allowed="doc-docx-pdf-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_010/2_010'; ?>"  id="fileToUpload_FILE_MUSNAH_PUSAT" name="userfile" onchange="do_upload($(this));
              return false;" />
              &nbsp;Tipe File : *.doc .docx .pdf .rar</span><span class="file_FILE_MUSNAH_PUSAT"></span>
             <?php
            } else {
             ?>
             <span class="upload_FILE_MUSNAH_PUSAT"><input type="file" class="uploadMusnahPusat" jenis="FILE_MUSNAH_PUSAT" allowed="doc-docx-pdf-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_010/2_010'; ?>"  id="fileToUpload_FILE_MUSNAH_PUSAT" name="userfile" onchange="do_upload($(this));
              return false;" />
              &nbsp;Tipe File : *.doc .docx .pdf .rar</span><span class="file_FILE_MUSNAH_PUSAT"></span>
             <?php
            }
            ?></td></tr>
          <tr class="diData" hidden><td class="td_left_checklist"></td><td class="td_left" style="background-color: white;">&nbsp;</td><td></td><td class="td_right" style="background-color: white;"><input type="text" title="Didata" class="stext diData" id="diData" value="<?php echo $sess["DETAIL_PUSAT"]; ?>" /></td></tr>
          <tr class="vJustifikasi" hidden><td class="td_left_checklist"></td><td class="td_left" style="background-color: white;">Justifikasi</td><td></td><td class="td_right" style="background-color: white;"><textarea name="JUSTIFIKASI" title="Justifikasi Pusat" class="stext chkJustifikasi" id="XXX" style="height: 140px"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></textarea></td></tr><?php
         } else {
          if ($sess['HASIL_PUSAT'] == "TMK") {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
               if ($sess['HASIL_PUSAT'] == 'MK')
                echo 'Memenuhi Ketentuan';
               else
                echo 'Tidak Memenuhi Ketentuan';
               ?></i></b></td></tr>
           <?php
          }
         }
        }
        ?>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>

     <!--8-->
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel_detail">
        <tr>
         <td class="td_left_checklist" colspan="5" style="margin-right: 200px">
          <?php
          if (array_key_exists('FILE_IKLAN', $sess) && trim($sess['FILE_IKLAN']) != "") {
           ?><input type="hidden" name="IKLAN_OT[FILE_IKLAN]" value="<?php echo $sess['FILE_IKLAN']; ?>">
           <span id="file_FILE_IKLAN"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_010'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'iklan_010'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" jns="FILE_IKLAN">Edit atau Hapus File ?</a></span>
           <span class="upload_FILE_IKLAN" hidden><input type="file" class="upload_FILE_IKLAN" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_010'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran" value="<?php echo $sess['FILE_IKLAN']; ?>" />
            &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_IKLAN"></span>
           <?php
          } else {
           ?>
           <span class="upload_FILE_IKLAN"><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_010'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran" />
            &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_IKLAN"></span>
           <?php
          }
          ?>
         </td>
        </tr>
       </table>
      </div>
     </div>

     <?php if ($formEdit === 'check') { ?>
      <div style="height:5px;"></div>
      <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PENGAWASAN</a></div>
      <div class="collapse">
       <div class="accCntnt">
        <h2 class="small garis">Verifikasi Pengawasan</h2>
        <table class="form_tabel">
         <tr><td class="td_left">Proses Pengawasan</td><td class="td_right"><?php echo form_dropdown($objStatus, $status, '', 'class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required" name', $disverifikasi); ?></td></tr>
         <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="CATATAN" class="stext" rel="required" title="Catatan"></textarea></td></tr></table>
       </div>
      </div>
     </div>
    <?php } ?>

    <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanIklan_010', '', '');">
      <span><span class="icon"></span>&nbsp; <?php echo $labelSimpan; ?> </span></a>&nbsp;
     <a href="javascript:void(0)" class="button back" onclick="goBack()" >
      <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
    <br />
    <br />
    <div id="form_tabel_detail" hidden="true" class="popup">
    </div>
   </div>
  </div>
  <input type="hidden" name="IKLAN_ID[]" value="<?php echo $sess['IKLAN_ID']; ?>" />
  <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
  <input type="hidden" name="KLASIFIKASIIKLAN" value="<?php echo $klasifikasi; ?>" />
  <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
  <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
 </form>
</div>
</div>
<script type="text/javascript">
          function goBack()
          {
           window.history.back()
          }
          function mediaIklan2(X) {
           $("#eChoosed").val('');
           $("#lrChoosed").val('');
           $("#cChoosed").val('');
           clear();
           showHide();
           cekLampiran();
          }
          function cekLampiran() {
//    var kesimpulan = $('#kesimpulanHasilPenilaian').val(), jenis = $('#iklan_media').val();
//    if ((kesimpulan === 'Tidak Memenuhi Ketentuan' && jenis === 'Cetak') || kesimpulan === 'Tidak Memenuhi Ketentuan' && jenis === 'Luar Ruang') {
           var val = $("#iklan_media").val();
           if (val == "Elektronik")
            $('.upload').attr('rel', '');
           else
            $('.upload').attr('rel', 'required');
////    } else {
//      $('.upload').attr('rel', ' ');
//      $(".upload").css("background-color", "#FFF");
//      $(".upload").css("border", "");
//    }
          }
          function showHide2(X) {
           var param = "";
           var media1 = ["TV", "Radio", "Iklan Baris", "Bioskop", "Megatron", "Lainnya"];
           var media2 = ["Majalah", "Tabloid", "Buletin", "Halaman Kuning"];
//                      var media3 = ["Majalah", "Tabloid", "Buletin", "Surat Kabar", "TV", "Radio", "Internet", "Iklan Baris"];
           var media3 = ["Majalah", "Tabloid", "Surat Kabar", "TV", "Radio", "Internet", "Buletin", "Iklan Baris"];
           var mediaifTertentu = ["Majalah", "Tabloid", "Buletin", "Surat Kabar"];
           var luarRuang = ["Billboard", "Neon Box", "Papan Nama", "Spanduk", "Balon Udara", "Transit Ad", "Hanging Mobil", "Iklan Dinding", "Gimmick", "Backdrop", "Baliho"];
           var elektronik = ["TV", "Radio", "Iklan Baris", "Bioskop", "Lainnya", "Internet"];
           if (typeof X === "object")
            param = $(X).val();
           else
            param = X;
           if ($.inArray(param, media1) > -1) {
            $("#tayangTime").show("");
            $("#edisiTime").hide("");
            $(".edisiCetak").attr("rel", "");
            $(".edisiTV").attr("rel", "required");
           } else if ($.inArray(param, media2) > -1) {
            $("#tayangTime").hide("");
            $("#edisiTime").show("");
            $(".edisiCetak").attr("rel", "required");
            $(".edisiTV").attr("rel", "");
           } else {
            $("#tayangTime").hide("");
            $("#edisiTime").hide("");
            $(".edisiCetak").attr("rel", "");
            $(".edisiTV").attr("rel", "");
           }
           if ($.inArray(param, media3) > -1) {
            $("#namaMedia").show("");
            $(".namaMedia").attr("rel", "required");
           } else {
            $("#namaMedia").hide("");
            $(".namaMedia").attr("rel", " ");
           }
           if ($.inArray(param, mediaifTertentu) < 0) {
            $("#tglTerbit").hide();
            $("#tglTugas").attr("rel", "");
           } else {
            $("#tglTerbit").show();
            $("#tglTugas").attr("rel", "required");
           }
           if (param === "Megatron") {
            $("#kabkotAlamat").attr("rel", "required");
            $("#provkotAlamat").attr("rel", "required");
            $(".cetakTertentu").attr("rel", "required");
           }
           else if ($.inArray(param, mediaifTertentu) < 0 && $.inArray(param, luarRuang) < 0 && $.inArray(param, elektronik) < 0) {
            $("#kabkotAlamat").attr("rel", "required");
            $("#provkotAlamat").attr("rel", "required");
            $(".cetakTertentu").attr("rel", "required");
           }
           else if ($.inArray(param, luarRuang) > -1) {
            $("#kabkotAlamat").attr("rel", "required");
            $("#provkotAlamat").attr("rel", "required");
            $(".cetakTertentu").attr("rel", "required");
           } else {
            $("#provkotAlamat").attr("rel", "");
            $("#kabkotAlamat").attr("rel", "");
            $(".cetakTertentu").attr("rel", "");
            $(".cetakTertentu").css('background-color', '#FFFFFF');
            $("#provkotAlamat").css('background-color', '#FFFFFF');
            $("#provkotAlamat").css('border', '1px solid #dcdcdc');
            $("#kabkotAlamat").css('background-color', '#FFFFFF');
            $("#kabkotAlamat").css('border', '1px solid #dcdcdc');
           }
           if (param === "Internet") {
            document.getElementById("namaMedia1").innerHTML = "Alamat Situs";
           } else {
            document.getElementById("namaMedia1").innerHTML = "Nama Media";
            $("#namaMediaIklan").attr("title", "Nama Media");
           }
//    $("#namaMediaIklan").unautocomplete();
           $("#namaMediaIklan").autocomplete($("#namaMediaIklan").attr("url") + param, {width: 244, selectFirst: false});
           $(".ac_results").remove();
           $("#namaMediaIklan").attr("name", "IKLAN[NAMA]");
          }
          function mediaIklan(X) {
           clear();
           showHide2(X);
          }
          function clear() {
           $("#namaMediaIklan").val("");
           $("#idMediaIklan").val("");
           $("#idMediaIklan").attr("name", "");
           $("#judulKegiatan").val("");
           $("#tglTugas").val("");
           $(".edisiTayang").val("");
           $("#namaLokasi").val("");
           $("#alamatLokasi").val("");
          }
          function showHide() {
           var kelompokIklan = $("#iklan_kelompok").val();
           var golonganOT = $('#golonganOT').val();
           var jenisIklan = $("#iklan_media").val();
           if (jenisIklan === "Cetak") {
            $(".elektronikChoosed").hide();
            $(".lRChoosed").hide();
            $(".cetakChoosed").fadeIn("slow");
            $("#cChoosed").attr("rel", "required");
            $("#lrChoosed").attr("rel", " ");
            $("#eChoosed").attr("rel", " ");
           }
           else if (jenisIklan === "Elektronik") {
            $(".lRChoosed").hide();
            $(".cetakChoosed").hide();
            $(".cetakChoosed").val();
            $('#expand4').fadeIn("slow");
            $('#expand4a').fadeIn("slow");
            $('#expand4b').fadeIn("slow");
            $('#deskripsiIklan').attr("rel", "required");
            $(".elektronikChoosed").fadeIn("slow");
            $("#cChoosed").attr("rel", " ");
            $("#lrChoosed").attr("rel", " ");
            $("#eChoosed").attr("rel", "required");
           }
           else if (jenisIklan === "Luar Ruang") {
            $(".elektronikChoosed").hide();
            $(".cetakChoosed").hide();
            $('#expand4').fadeIn("slow");
            $('#expand4a').fadeIn("slow");
            $('#expand4b').fadeIn("slow");
            $(".lRChoosed").show();
            $("#cChoosed").attr("rel", " ");
            $("#lrChoosed").attr("rel", "required");
            $("#eChoosed").attr("rel", " ");
           }
          }
          function do_upload(element) {
           var jenis = $(element).attr("jenis");
           var allowed = $(element).attr("allowed");
           jLoadingOpen('Upload File', 'SIPT Versi 1.0');
           $.ajaxFileUpload({
            url: $(element).attr("url") + '/' + jenis + '/' + allowed,
            secureuri: false,
            fileElementId: $(element).attr("id"),
            dataType: "json",
            success: function(data) {
             var arrdata = data.msg.split("#");
             if (typeof (data.error) != "undefined") {
              if (data.error != "") {
               jAlert(data.error, "SIPT Versi 1.0 Beta");
              } else {
               if (arrdata[2] == "FILE_IKLAN") {
                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                $(".upload_" + arrdata[2] + "").hide();
                $("#file_" + arrdata[2] + "").hide();
                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_OT[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
               } else if (arrdata[2] == "FILE_MUSNAH") {
                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                $(".upload_" + arrdata[2] + "").hide();
                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" id=\"del_upload1\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"MUSNAH[]\" value=" + arrdata[0] + ">");
               } else if (arrdata[2] == "FILE_MUSNAH_PUSAT") {
                $("#fileToUpload_" + arrdata[2] + "").removeAttr("rel");
                $(".upload_" + arrdata[2] + "").hide();
                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload2\" id=\"del_upload2\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"MUSNAHPUSAT[]\" value=" + arrdata[0] + ">");
                $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "");
               }
              }
             }
             jLoadingClose();
            },
            error: function(data, status, e) {
             jAlert(e, "SIPT Versi 1.0 Beta");
            }
           });
          }
          function comp(A) {
           var tgl1 = "#tglXX", tgl2 = "#tglAwalPengawasan", tgl3 = "#tglAkhirPengawasan", tgl4 = "#tglTugas", tgl5 = "#tglSuratTL";
           if (A === "A") {
            if ($("#tglXX") !== "")
             compare(tgl1, tgl2);
            if ($("#tglAkhirPengawasan").val() !== "")
             compare(tgl2, tgl3);
           }
           else if (A === "B") {
            if ($("#tglXX") !== "")
             compare(tgl1, tgl3);
            if ($("#tglAwalPengawasan").val() !== "")
             compare(tgl2, tgl3);
           }
           else if (A === "C") {
            compare2(tgl4, tgl3, tgl4, "Harap dipastikan untuk Tanggal Terbit Media : \n  Harus lebih kecil dari Tanggal Akhir Pemeriksaan");
           }
           else if (A === "D") {
            compare2(tgl2, tgl5, tgl5, "Harap dipastikan untuk Tanggal Surat : \n  Harus lebih besar dari Tanggal Awal Pemeriksaan");
           }
          }
          function compare2(objstart, objend, focuz, alertz) {
           var date_str = $(objstart).val();
           var date_end = $(objend).val();
           date_str = new Date(date_str.split('/')[2], date_str.split('/')[1], date_str.split('/')[0]);
           date_end = new Date(date_end.split('/')[2], date_end.split('/')[1], date_end.split('/')[0]);
           if (date_end.getTime() < date_str.getTime()) {
            jAlert(alertz, "SIPT Versi 1.0");
            $(focuz).val('');
            $(focuz).focus();
            return false;
           }
          }
          function cekAll() {
           var rE, Re2;
           $('.uraianPelanggaran').each(function() {
            if ($('.uraianPelanggaran:checked').length > 0) {
             Re2 = true;
            }
           });
           $('.uPelanggaran').each(function() {
            if ($(this).val() !== '' && Re2 === true) {
             rE = true;
            } else if ($(this).val() === '' && Re2 === true) {
             rE = true;
            }
           });
           return rE;
          }
          function checkListTxt(XXX) {
           var X = "input:checkbox[name='" + XXX + "']";
           var i = 0;
           $('.uraianPelanggaran').each(function() {
            if ($('.uraianPelanggaran:checked').length > 1) {
             i++;
            }
           });
           if (i > 0) {
            jAlert("Maaf, uraian pelanggaran yang dapat dipilih hanya satu");
            $(X).attr("checked", false);
            return false;
           }
           if ($(X).is(":checked")) {
            $('#' + XXX).val($(X).attr("val"));
           } else {
            $('#' + XXX).val("");
           }
           mkTmk();
           verifikasiPusat($(".verifikasiPusat"));
           verifikasiTL($(".vTMKSub"));
          }
          function checkList(obj) {
           var XXX = obj.attr("name"), xxx = obj.val(), X = "input:radio[name='" + XXX + "']", XX = xxx.split('_');
           if ($(X).is(":checked")) {
            uraianTidakLengkap();
            mkTmk();
            verifikasiPusat($(".verifikasiPusat"));
            verifikasiTL($(".vTMKSub"));
           }
          }
          function mkTmk() {
           var X = cekAll();
           if (X === true) {
            $("#kesimpulanHasilPenilaian").val("Tidak Memenuhi Ketentuan");
            $("#kesimpulanHasilPenilaianVal").val("TMK");
            $(".TDKB").show("");
            $("#tDKBalai").attr("rel", "required");
           } else if (X !== true) {
            $("#kesimpulanHasilPenilaian").val("Memenuhi Ketentuan");
            $("#kesimpulanHasilPenilaianVal").val("MK");
            $(".TDKB").hide("");
            $(".tDKBalaiRow").hide();
            $(".tDKBalaiRow").attr("rel", "");
            $("#tDKBalai").val("");
            $("#tDKBalai").attr("rel", "");
            $("#jmlMusnah").attr("name", "");
            $("#satuanMusnah").attr("name", "");
            $("#fileMusnah").attr("name", "");
            musnahkan();
           }
           cekLampiran();
          }
          function verifikasiPusat(X) {
           if ($(X).val() === "MK") {
            $(".vTMK").hide();
            $(".vTMK").attr("rel", " ");
            $(".vTMK").val("");
            $(".vTMK2").hide("slow");
            $(".vTMK2").val("");
            $(".vTMK2").attr("rel", "");
            $(".vTMK2a").val("");
            $(".diData").hide();
            $(".diData").attr("rel", "");
            $("#diData").attr("name", "");
            $("#diData").val("");
           }
           else if ($(X).val() === "TMK") {
            $("#ygCetak").hide();
            $("#nonCetak").hide();
            $(".vTMK").show();
            if ($("#iklan_media").val() === "Cetak") {
             $("#ygCetak").show();
             $(".ygCetak").attr("rel", "required");
             $(".ygCetak").attr("name", "IKLAN[TL_PUSAT]");
             $(".nonCetak").attr("rel", "");
             $(".nonCetak").attr("name", "");
            }
            else {
             $("#nonCetak").show();
             $(".nonCetak").attr("rel", "required");
             $(".nonCetak").attr("name", "IKLAN[TL_PUSAT]");
             $(".ygCetak").attr("rel", "");
             $(".ygCetak").attr("name", "");
            }
           }
           else {
            $(".vTMK").hide();
            $(".vTMK").hide();
            $(".vTMK").attr("rel", " ");
            $(".vTMK").val("");
            $(".vTMK2").hide("slow");
            $(".vTMK2").val("");
            $(".vTMK2").attr("rel", "");
            $(".vTMK2a").val("");
            $(".diData").hide();
            $(".diData").attr("rel", "");
            $("#diData").attr("name", "");
            $("#diData").val("");
           }
           if ($(X).val() != '') {
            if ($(X).val() != $("#kesimpulanHasilPenilaianVal").val()) {
             $(".vJustifikasi").show("slow");
             $(".chkJustifikasi").attr("rel", "required");
            } else if ($(X).val() == $("#kesimpulanHasilPenilaianVal").val()) {
             $(".vJustifikasi").hide("slow");
             $(".chkJustifikasi").attr("rel", "");
             $("#jmlMusnahPusat").attr("name", "");
             $("#satuanMusnahPusat").attr("name", "");
             $("#fileMusnahPusat").attr("name", "");
            }
           } else {
            $(".vJustifikasi").hide("slow");
            $(".chkJustifikasi").attr("rel", "");
           }
          }
          function verifikasiTL(X) {
           if ($(X).val() == '5') {
            $(".vTMK2").show("slow");
            $(".vTMK2").attr("rel", "required");
            $("#fileToUpload_FILE_MUSNAH").attr("rel", "required");
            $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "required");
            $("#jmlMusnahPusat").attr("name", "MUSNAHPUSAT[]");
            $("#satuanMusnahPusat").attr("name", "MUSNAHPUSAT[]");
            $("#fileMusnahPusat").attr("name", "MUSNAHPUSAT[]");
            $(".diData").hide();
            $(".diData").attr("rel", "");
            $("#diData").attr("name", "");
            $("#diData").val("");
           } else if ($(X).val() == '6') {
            $(".vTMK2").hide();
            $(".vTMK2").attr("rel", "");
            $("#fileToUpload_FILE_MUSNAH").attr("rel", "");
            $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "");
            $(".vTMK2").val("");
            $(".vTMK2a").val("");
            $("#jmlMusnahPusat").attr("name", "");
            $("#satuanMusnahPusat").attr("name", "");
            $("#fileMusnahPusat").attr("name", "");
            $(".diData").show("slow");
            $(".diData").attr("rel", "required");
            $("#diData").attr("name", "IKLAN[DETAIL_PUSAT]");
           } else {
            $(".vTMK2").hide();
            $(".vTMK2").attr("rel", "");
            $("#fileToUpload_FILE_MUSNAH").attr("rel", "");
            $("#fileToUpload_FILE_MUSNAH_PUSAT").attr("rel", "");
            $(".vTMK2").val("");
            $(".vTMK2a").val("");
            $("#jmlMusnahPusat").attr("name", "");
            $("#satuanMusnahPusat").attr("name", "");
            $("#fileMusnahPusat").attr("name", "");
            $(".diData").hide();
            $(".diData").attr("rel", "");
            $("#diData").attr("name", "");
            $("#diData").val("");
           }
          }
          function musnahkan() {
           $("#jmlMusnah").val("");
           $("#satuanMusnah").val("");
           $("#fileMusnah").val("");
           musnahkanFile("#del_upload1");
          }
          function musnahkan2() {
           $("#jmlMusnahPusat").val("");
           $("#satuanMusnahPusat").val("");
           $("#fileMusnahPusat").val("");
           musnahkanFile("#del_upload2");
          }
          function musnahkanFile(id) {
           var jenis = $(id).attr("jns");
           $.ajax({
            type: "GET",
            url: $(id).attr("url"),
            data: $(id).serialize(),
            success: function(data) {
             var arrdata = data.split("#");
             $(".upload_" + jenis + "").show();
             $("#fileToUpload_" + jenis + "").val('');
             $(".file_" + jenis + "").html("");
             $("#file_" + jenis + "").hide("");
             if (jenis !== "FILE_LAMPIRAN_IKLAN")
              $("#fileToUpload_" + jenis + "").attr("rel", "");
            }
           });
           return false;
          }
          function kategoriObat(obj) {
           var val = $(obj).val(), nom = $(obj).attr('terakhir');
           if (val === "100") {
            $(".kategoriLain" + nom).show();
           } else {
            $(".kategoriLain" + nom).hide();
            $(".kategoriLain" + nom).val("");
           }
          }
          $(document).ready(function() {
           $("textarea.chkJustifikasi").redactor({
            buttons: ['bold', 'italic', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'alignleft', 'aligncenter', 'alignright', 'justify'],
            removeStyles: false,
            cleanUp: true,
            autoformat: true
           });
//                      load data edit
<?php if (array_key_exists('IKLAN_ID', $sess)) { ?>
            $("#iklan_kelompok option[value='<?php echo $sess["KELOMPOK_IKLAN"]; ?>']").attr("selected", "selected");
            $("#iklan_media option[value='<?php echo $sess["JENIS_IKLAN"]; ?>']").attr("selected", "selected");
            $(".mediaIklanEdit option[value='<?php echo $sess["MEDIA"]; ?>']").attr("selected", "selected");
            $("#referensiSiami option[value='<?php echo $sess["VERIFIKASI_SIAMI"]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[EDISI1]'] option[value='<?php echo $edisiMedia[0]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[EDISI2]'] option[value='<?php echo $edisiMedia[1]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[TAYANG1]'] option[value='<?php echo $tayangMedia[0]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[TAYANG2]'] option[value='<?php echo $tayangMedia[1]; ?>']").attr("selected", "selected");
            $(".chkKategoriProdukCls").each(function() {
             kategoriObat($(this));
            });
            if ("<?php echo $sess['TL_BALAI']; ?>" === '2') {
             $(".tDKBalaiRow").show();
             $(".tDKBalaiRow").attr("rel", "required");
             $("#jmlMusnah").attr("name", "MUSNAH[]");
             $("#satuanMusnah").attr("name", "MUSNAH[]");
             $("#fileMusnah").attr("name", "MUSNAH[]");
            }
            if ("<?php echo trim($UP[0]); ?>" !== "") {
             $("input:checkbox[name='uraian0']").attr('checked', 'checked');
             checkListTxt('uraian0');
            }
            else if ("<?php echo trim($UP[1]); ?>" !== "") {
             $("input:checkbox[name='uraian1']").attr('checked', 'checked');
             checkListTxt('uraian1');
            }
            else if ("<?php echo trim($UP[2]); ?>" !== "") {
             $("input:checkbox[name='uraian2']").attr('checked', 'checked');
             checkListTxt('uraian2');
            }
            else if ("<?php echo trim($UP[3]); ?>" !== "") {
             $("input:checkbox[name='uraian3']").attr('checked', 'checked');
             checkListTxt('uraian3');
            }
            else if ("<?php echo trim($UP[4]); ?>" !== "") {
             $("input:checkbox[name='uraian4']").attr('checked', 'checked');
             checkListTxt('uraian4');
            }
            else if ("<?php echo trim($UP[5]); ?>" !== "") {
             $("input:checkbox[name='uraian5']").attr('checked', 'checked');
             checkListTxt('uraian5');
            }
            else if ("<?php echo trim($UP[6]); ?>" !== "") {
             $("input:checkbox[name='uraian6']").attr('checked', 'checked');
             checkListTxt('uraian6');
            }
            else if ("<?php echo trim($UP[7]); ?>" !== "") {
             $("input:checkbox[name='uraian7']").attr('checked', 'checked');
             checkListTxt('uraian7');
            }
            else if ("<?php echo trim($UP[8]); ?>" !== "") {
             $("input:checkbox[name='uraian8']").attr('checked', 'checked');
             checkListTxt('uraian8');
            }
            else if ("<?php echo trim($UP[9]); ?>" !== "") {
             $("input:checkbox[name='uraian9']").attr('checked', 'checked');
             checkListTxt('uraian9');
            }
            else if ("<?php echo trim($UP[10]); ?>" !== "") {
             $("input:checkbox[name='uraian10']").attr('checked', 'checked');
             checkListTxt('uraian10');
            }
            else if ("<?php echo trim($UP[11]); ?>" !== "") {
             $("input:checkbox[name='uraian11']").attr('checked', 'checked');
             checkListTxt('uraian11');
            }
            else if ("<?php echo trim($UP[12]); ?>" !== "") {
             $("input:checkbox[name='uraian12']").attr('checked', 'checked');
             checkListTxt('uraian12');
            }
            else if ("<?php echo trim($UP[13]); ?>" !== "") {
             $("input:checkbox[name='uraian13']").attr('checked', 'checked');
             checkListTxt('uraian13');
            }
            if ("<?php echo $provinsiVal; ?>" !== " " && "<?php echo $provinsiVal; ?>" !== "") {
             var kunci = $("#provkotAlamat").val();
             $.get("<?php echo site_url(); ?>/get/iklan_penandaan/set_provinsi/" + kunci, function(hasil) {
              hasil = hasil.replace(" ", "");
              if (hasil != "") {
               $("#kabkotAlamat").html(hasil);
               $("#kabkotAlamat").val("<?php echo $kabupatenVal; ?>");
              }
             });
            }
 <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") {
  ?>
             verifikasiPusat($(".verifikasiPusat"));
             verifikasiTL($(".vTMKSub"));
             $("#jmlMusnahPusat").attr("name", "MUSNAHPUSAT[]");
             $("#satuanMusnahPusat").attr("name", "MUSNAHPUSAT[]");
             $("#fileMusnahPusat").attr("name", "MUSNAHPUSAT[]");
 <?php } ?>
            showHide();
            showHide2('<?php echo $sess['MEDIA']; ?>');
<?php } ?>
           //                      akhir load data edit
           $("input.namaOT").autocomplete($("input.namaOT").attr("url") + 'ot', {width: 244, selectFirst: false});
           $("input.namaOT").result(function(event, data, formatted) {
            if (data) {
             $(this).val(data[1]);
             $("#namaPemilikNIE").val(data[3]);
             $("#bentukSediaan").val(data[9]);
             $("#NIE").val(data[2]);
            }
           });
           $("#namaMediaIklan").result(function(event, data, formatted) {
            if (data) {
             $("#namaMediaIklan").attr("name", "");
             $("#idMediaIklan").attr("name", "IKLAN[NAMA]");
             $("#namaMediaIklan").val(data[1]);
             $("#idMediaIklan").val(data[2]);
            }
           });
           $('.addnomor').click(function() {
            var nom = $(this).attr('terakhir'), idtr = $(this).attr('periksa'), cls = idtr + nom, chkNum = parseInt(nom) + 1;
            $('#chkKategoriProduk' + nom).attr('terakhir' + nom);
            var apd = "";
<?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) { ?>
             apd = '<tr class= "' + cls + '"><td>&nbsp;</td></tr><tr class= "' + cls + '"><td width="150">Nama OT</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaOT' + cls + '" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/" title="Nama OT" rel="required">&nbsp;&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus OT" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Bentuk Sediaan</td><td><input type="text" size="40" name="PRODUK[BENTUKSEDIAAN][]" id="bentukSediaan' + cls + '" title="Bentuk Sediaan" readonly/></td></tr><tr class= "' + cls + '"><td width="150">Nama Pemilik Izin Edar</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="Pemilik Izin Edar" readonly/></td></tr><tr class= "' + cls + '"><td width="150">Nomor Izin Edar</td><td><input type="text" size="40" name="PRODUK[NOMORIZINEDAR][]" id="NIE' + cls + '" title="Nomor Izin Edar" readonly/></td></tr><tr class= "' + cls + '"><td>Kategori Produk</td><td><span class="kategoriNormal' + nom + '"><select name="PRODUK[JENIS][]" title="Golongan OT" rel="required" class="chkKategoriProdukCls" id="chkKategoriProduk' + chkNum + '" terakhir="' + nom + '"><option value="" selected="selected"></option><option value="001">Golongan daya tahan tubuh</option><option value="002">Golongan demam</option><option value="003">Golongan galian singset</option><option value="004">Golongan habis bersalin</option><option value="005">Golongan haid teratur</option><option value="006">Golongan jamu ulu hati</option><option value="007">Golongan jerawat</option><option value="008">Golongan masuk angin</option><option value="009">Golongan panas dalam</option><option value="010">Golongan parem</option><option value="011">Golongan pegel linu</option><option value="012">Golongan pelancar ASI</option><option value="013">Golongan pencahar/melancarkan BAB</option><option value="014">Golongan sariawan/obat kumur</option><option value="015">Golongan sehat pria</option><option value="016">Golongan sehat wanita</option><option value="017">Golongan wasir</option><option value="100">Golongan lain-lain</option></select></span><span class="kategoriLain' + nom + '" hidden>&nbsp;&nbsp;<input type="text" size="40" name="PRODUK[GOLONGAN][]" class="kategoriLain"' + nom + ' title="Golongan lain - lain" /></span></td></tr><tr class= "' + cls + '"><td>Evaluasi Premarket</td><td><select name="PRODUK[MERK_PRODUK][]" title="Evaluasi Premarket" rel="required" id="chkEvaluasi' + cls + '"><option value="" selected></option><option value="0">Iklan sudah dipre-review</option><option value="1">Iklan belum dipre-review</option></select></td></tr>';
<?php } else { ?>
             apd = '<tr class= "' + cls + '"><td>&nbsp;</td></tr><tr class= "' + cls + '"><td width="150">Nama OT</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaOT' + cls + '" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/" title="Nama OT" rel="required">&nbsp;&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus OT" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Bentuk Sediaan</td><td><input type="text" size="40" name="PRODUK[BENTUKSEDIAAN][]" id="bentukSediaan' + cls + '" title="Bentuk Sediaan" readonly/></td></tr><tr class= "' + cls + '"><td width="150">Nama Pemilik Izin Edar</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="Pemilik Izin Edar" readonly/></td></tr><tr class= "' + cls + '"><td width="150">Nomor Izin Edar</td><td><input type="text" size="40" name="PRODUK[NOMORIZINEDAR][]" id="NIE' + cls + '" title="Nomor Izin Edar" readonly/></td></tr><tr class= "' + cls + '"><td>Kategori Produk</td><td><span class="kategoriNormal' + nom + '"><select name="PRODUK[JENIS][]" title="Golongan OT" rel="required" class="chkKategoriProdukCls" id="chkKategoriProduk' + chkNum + '" terakhir="' + nom + '"><option value="" selected="selected"></option><option value="001">Golongan daya tahan tubuh</option><option value="002">Golongan demam</option><option value="003">Golongan galian singset</option><option value="004">Golongan habis bersalin</option><option value="005">Golongan haid teratur</option><option value="006">Golongan jamu ulu hati</option><option value="007">Golongan jerawat</option><option value="008">Golongan masuk angin</option><option value="009">Golongan panas dalam</option><option value="010">Golongan parem</option><option value="011">Golongan pegel linu</option><option value="012">Golongan pelancar ASI</option><option value="013">Golongan pencahar/melancarkan BAB</option><option value="014">Golongan sariawan/obat kumur</option><option value="015">Golongan sehat pria</option><option value="016">Golongan sehat wanita</option><option value="017">Golongan wasir</option><option value="100">Golongan lain-lain</option></select></span><span class="kategoriLain' + nom + '" hidden>&nbsp;&nbsp;<input type="text" size="40" name="PRODUK[GOLONGAN][]" class="kategoriLain"' + nom + ' title="Golongan lain - lain" /></span></td></tr>';
<?php } ?>
            $("#tb_OT").append(apd);
            $(this).attr('terakhir', parseInt(nom) + 1);
            $("input.namaOT" + cls).autocomplete($("input.namaOT").attr("url") + 'ot', {width: 244, selectFirst: false});
            $("#minCls" + cls).click(function() {
             $("#uraianPenilaian1").val('');
             $(".infoTambahan").attr('checked', false);
             $('.' + cls).remove();
            });
            $("input.namaOT" + cls).result(function(event, data, formatted) {
             if (data) {
              var golonganOT = data[2].substring(2, 1);
              $(this).val(data[1]);
              $("#namaPemilikNIE" + cls).val(data[3]);
              $("#bentukSediaan" + cls).val(data[9]);
              $("#NIE" + cls).val(data[2]);
              $("#mbbpomid" + cls).val(data[2]);
              $("input.op").autocomplete($("input.op").attr("url") + $("#bbpomid" + cls).val(), {width: 244, selectFirst: false});
             }
            });
            $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter', showTimeout: 1, alignTo: 'target', alignX: 'right', alignY: 'center', offsetX: 5, allowTipHover: false, fade: false, slide: false});
            $("#chkKategoriProduk" + chkNum).change(function() {
             kategoriObat($(this));
            });
           });
           $(".uraianPelanggaran").click(function() {
            checkListTxt($(this).attr("name"));
           });
           $(".uPelanggaran").change(function() {
            mkTmk();
           });
           $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter', showTimeout: 1, alignTo: 'target', alignX: 'right', alignY: 'center', offsetX: 5, allowTipHover: false, fade: false, slide: false});
           $('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
           $("#iklan_kelompok").change(function() {
            $('#uraianTidakLengkap').val('');
            clear();
            showHide();
           });
           $('#cChoosed').change(function() {
            showHide();
           });
           $('#eChoosed').change(function() {
            showHide();
           });
           $('#lRChoosed').change(function() {
            showHide();
           });
           $("#detail_petugas").html("Loading ...");
           $("#detail_petugas").load($("#detail_petugas").attr("url"));
           $(".del_upload").live("click", function() {
            var jenis = $(this).attr("jns");
            $.ajax({
             type: "GET",
             url: $(this).attr("url"),
             data: $(this).serialize(),
             success: function(data) {
              var arrdata = data.split("#");
              $(".upload_" + jenis + "").show();
              $(".upload_" + jenis + "").attr("rel", "required");
              $("#fileToUpload_" + jenis + "").val('');
              $(".file_" + jenis + "").html("");
              $("#file_" + jenis + "").hide("");
              cekLampiran();
              if (jenis !== "FILE_IKLAN")
               $("#fileToUpload_" + jenis + "").attr("rel", "");
             }
            });
            return false;
           });
           $(".verifikasiPusat").change(function() {
            verifikasiPusat($(this));
           });
           $(".vTMKSub").change(function() {
            verifikasiTL($(this));
           });
           $("#tDKBalai").change(function() {
            if ($(this).val() === '2') {
             $(".tDKBalaiRow").show();
             $(".tDKBalaiRow").attr("rel", "required");
             $("#jmlMusnah").attr("name", "MUSNAH[]");
             $("#satuanMusnah").attr("name", "MUSNAH[]");
             $("#fileMusnah").attr("name", "MUSNAH[]");
            }
            else {
             $(".tDKBalaiRow").hide();
             $(".tDKBalaiRow").attr("rel", "");
             $("#jmlMusnah").attr("name", "");
             $("#satuanMusnah").attr("name", "");
             $("#fileMusnah").attr("name", "");
             musnahkan();
            }
           });
           $("#provkotAlamat").change(function() {
            var kunci = $(this).val();
            $.get('<?php echo site_url(); ?>/get/iklan_penandaan/set_provinsi/' + kunci, function(hasil) {
             hasil = hasil.replace(' ', '');
             if (hasil != "") {
              $('#kabkotAlamat').html(hasil);
             }
            });
           });
           $("#chkKategoriProduk0").change(function() {
            kategoriObat($(this));
           });
          });</script>