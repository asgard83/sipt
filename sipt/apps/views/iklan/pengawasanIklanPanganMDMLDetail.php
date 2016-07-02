<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN PANGAN MD / ML</div>
<?php
$bulan_iklan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tahun_iklan = array(range(date("Y"), 2007));
$totalThn = array_sum(array_map("count", $tahun_iklan));
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
$tayangMedia = explode(" ", $sess['JAM_TAYANG']);
$kelompokIklan = array("" => "", "Umum" => "Umum", "Untuk kelompok orang tertentu" => "Untuk kelompok orang tertentu", "Berkaitan dengan proses dan asal serta sifat bahan pangan" => "Berkaitan dengan proses dan asal serta sifat bahan pangan", "Menyertakan undian, sayembara atau hadiah" => "Menyertakan undian, sayembara atau hadiah", "Berkaitan dengan klaim gizi dan klaim kesehatan" => "Berkaitan dengan klaim gizi dan klaim kesehatan", "Minuman beralkohol" => "Minuman beralkohol", "Pangan halal" => "Pangan halal");
$edisiUraian = explode("^", $sess['EDISI']);
$edisiMedia = explode(" ", $edisiUraian[0]);
?>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_013">
  <div class="adCntnr">
   <div class="acco2">
    <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGAWASAN IKLAN</a></div>
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
         if ($this->session->userdata('TANGGAL') != "-") {
          echo $this->session->userdata('TANGGAL');
         }
         ?>"/>
         <input type="text" class="sdate" name="IKLAN[TANGGALAWAL]" id="tglAwalPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('A')" rel='required' value="<?php echo $sess['TANGGAL_MULAI']; ?>"/>&nbsp; sampai dengan&nbsp;
         <input type="text" class="sdate" name="IKLAN[TANGGALAKHIR]" id="tglAkhirPengawasan" title="Tanggal Pengawasan Iklan" onchange="comp('B')" rel='required' value="<?php echo $sess['TANGGAL_AKHIR']; ?>"/></td>
       </tr>
       <tr><td class="td_left">Kelompok Iklan</td><td class="td_right">
         <?php echo form_dropdown('IKLANPANGAN[KELOMPOK]', $kelompokIklan, $sess['KELOMPOK_IKLAN'], 'title="Kelompok Iklan" class="stext" id = "kelompokIklan" rel="required" onChange="sl_jenis_pangan(this);"') ?>
       </tr>
      </table>
     </div>
    </div><!-- Akhir Pemeriksaan !-->
    <div style="height:5px;"></div>
    <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PANGAN - IKLAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table>
        <tr>
         <td>
          <table>
           <tbody id="tb_pangan">
            <?php
            $jmldata = 0;
            $nomor = array();
            $data = $sess2;
            $jmldata = count($data);
            if ($jmldata == 0) {
             $jmldata = 1;
             $idEdit = "";
            } else {
             $idEdit = 0;
            }
            $i = 0;
            do {
             ?>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nama Pangan</td>
              <td>
               <input type="text" size="50" name="PRODUK[NAMA][]" class="namaPangan" id="namaPangan<?php echo $idEdit; ?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Pangan" rel="required" value="<?php echo $sess2[$i]['NAMA_PRODUK']; ?>" urut="<?php echo $idEdit; ?>" />&nbsp;
               <?php
               if ($i == 0) {
                ?>
                <a href="javascript:void(0)" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Pangan" /></a>
                <?php
               } else {
                ?>
                <a href="javascript:void(0)" class="min" onclick="$('.urut<?php echo $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus Pangan" /></a>
                <?php
               }
               ?></td>
             </tr><tr class="urut<?php echo $i; ?>">
              <td width="150">Merk Dagang</td>
              <td><input type="text" size="50" name="PRODUK[MERK_PRODUK][]" id="merkDagang<?php echo $idEdit; ?>" title="Merk Dagang" value="<?php echo $sess2[$i]['MERK_PRODUK']; ?>" />
              </td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nama Pemilik Izin Edar</td>
              <td><input type="text" size="50" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE<?php echo $idEdit; ?>" title="Pemilik Izin Edar" value="<?php echo $sess2[$i]['NAMA_PEMILIK_IZIN_EDAR']; ?>" />
              </td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nomor Izin Edar</td>
              <td><input type="text" size="50" name="PRODUK[NOMORIZINEDAR][]" id="NIE<?php echo $idEdit; ?>" title="Nomor Izin Edar" value="<?php echo $sess2[$i]['NOMOR_IZIN_EDAR']; ?>" />
              </td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Alamat Pemilik Izin Edar</td>
              <td><textarea name="PRODUK[ALAMAT_PEMILIK_IZIN_EDAR][]" style="width: 314px;" id="alamatPemilikNIE<?php echo $idEdit; ?>" title="Alamat Pemilik Izin Edar" rel="required"><?php echo $sess2[$i]['ALAMAT_PEMILIK_IZIN_EDAR']; ?></textarea>
              </td>
             </tr>
             <?php
             $i++;
             $idEdit++;
             if ($i > 0 && $i < $jmldata) {
              ?>
              <tr><td>&nbsp;</td></tr>
              <?php
             }
            } while ($i < $jmldata)
            ?>
           </tbody>
          </table>
         </td>
        </tr>
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
         <td class="td_left_header_checklist" style="vertical-align: top;">Tanggal Penerbitan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="sdate" name="IKLAN[TANGGAL]" id="tglTugas" title="Tanggal Penerbitan Iklan" onchange="comp('C')" value="<?php echo $sess['TANGGAL']; ?>"/>&nbsp;&nbsp;
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
         <td style="width: 10%;" colspan="2" class="td_left_checklist"><textarea style="width: 98%; height: 75px;" class="stext" title="Narasi / Klaim Iklan" name="IKLANPANGAN[NARASI]" rel="required"><?php echo $sess['NARASI']; ?></textarea></td>
        </tr>
       </table>
      </div>
     </div>
     <div style="height:5px;"></div>

     <!--5-->
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">URAIAN PELANGGARAN</a></div>
     <div class="collapse">
      <div class="accCntnt" id="expand5a">
       <table class="form_tabel_detail">
        <tr class="hashStar">
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist"  style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian1" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak memiliki izin edar</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian1" hidden="true"><textarea class="uPelanggaran uraian1" title="Uraian Pelanggaran" id="uraianIzinEdar" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[0]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian2" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Seolah-olah sebagai obat / mengobati</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian2" hidden="true"><textarea class="uPelanggaran uraian2" title="Uraian Pelanggaran" id="uraianKlaimBerlebihan" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[1]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian3" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Peragaan tenaga kesehatan</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian3" hidden="true"><textarea class="uPelanggaran uraian3" title="Uraian Pelanggaran" id="uraianTenagaKesehatan" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[2]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian4" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Rekomendasi laboratorium/tenaga kesehatan</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian4" hidden="true"><textarea class="uPelanggaran uraian4" title="Uraian Pelanggaran" id="uraianRekomendasi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[3]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian5" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak etis / tidak sesuai norma susila</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian5" hidden="true"><textarea class="uPelanggaran uraian5" title="Uraian Pelanggaran" id="uraianTidakEtis" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[4]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian6" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Berlebihan / menyesatkan</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian6" hidden="true"><textarea class="uPelanggaran uraian6" title="Uraian Pelanggaran" id="uraianBerlebihan" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[5]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian7" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak mencantumkan spot (untuk iklan yang wajib mencantumkan spot iklan)</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian7" hidden="true"><textarea class="uPelanggaran uraian7" title="Uraian Pelanggaran" id="uraianSpotIklan" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[6]; ?></textarea></span></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian8" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Iklan yang mempengaruhi fungsi fisiologis dan atau metabolisme tubuh</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian8" hidden="true"><textarea class="uPelanggaran uraian8" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[7]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_1">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian9" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Slogan, ikon atau logo tidak sesuai</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian9" hidden="true"><textarea class="uPelanggaran uraian9" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[8]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_1">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian10" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Testimoni</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian10" hidden="true"><textarea class="uPelanggaran uraian10" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[9]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_2" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian11" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak mencantumkan peringatan / perhatian</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian11" hidden="true"><textarea class="uPelanggaran uraian11" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[10]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_4" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian12" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak menyebutkan keterangan jelas terkait hadiah</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian12" hidden="true"><textarea class="uPelanggaran uraian12" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[11]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_5" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian13" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Tidak sesuai dengan klaim yang disetujui pada label</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian13" hidden="true"><textarea class="uPelanggaran uraian13" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[12]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_6" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian14" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Disiarkan di media massa atau kegiatan tertentu</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian14" hidden="true"><textarea class="uPelanggaran uraian14" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[13]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_6" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian15" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Kadar etanol lebih dari 1% (v/v)</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian15" hidden="true"><textarea class="uPelanggaran uraian15" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[14]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_7" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian16" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Mencantumkan logo dan atau simbol keagamaan yang dianggap suci</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian16" hidden="true"><textarea class="uPelanggaran uraian16" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[15]; ?></textarea></span></td>
        </tr>
        <tr class="kelompok_7" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><input class="uraianPelanggaran" type="checkbox" name="uraian17" style="vertical-align: top; margin-right: 10px" title="Uraian Pelanggaran" />&nbsp;Mengiklankan kata halal</td>
         <td></td>
         <td style="width: 10%;" colspan="6"><span class="uraian17" hidden="true"><textarea class="uPelanggaran uraian17" title="Uraian Pelanggaran" id="uraianMempengaruhi" style="width: 98%; height: 75px;" name="UPELANGGARAN[]"><?php echo $UP[16]; ?></textarea></span></td>
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
        if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))) {
         if ((!$sess['HASIL_PUSAT'] && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))) || $editTL == 'YES') {
          ?>
          <tr><td class="td_left_checklist"></td><td class="td_left">Verifikasi Pusat</td><td></td><td class="td_right"><select class="stext verifikasiPusat" name="<?php echo 'IKLAN[HASIL_PUSAT]' ?>" rel="required" title="MK/TMK"><option></option><option value="MK" <?php if ($sess['HASIL_PUSAT'] == 'MK') echo 'Selected' ?>>Memenuhi Ketentuan</option><option value="TMK"  <?php if ($sess['HASIL_PUSAT'] == 'TMK') echo 'Selected' ?>>Tidak Memenuhi Ketentuan</option></select></td></tr>
          <tr class="vTMK" hidden><td class="td_left_checklist"></td><td class="td_left"style="background-color: white;">Tindak Lanjut</td><td></td><td class="td_right" style="background-color: white;"><?php echo form_dropdown('IKLAN[TL_PUSAT]', $cb_tindakan, $sess['TL_PUSAT'], 'class="stext vTMK" id="vTMKSub" title="Tindak Lanjut Pusat"'); ?></td></tr>
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
           <?php if ($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") { ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
            <?php
           }
          } else {
           ?>
           <tr><td class="td_left">Verifikasi Pusat</td><td class="td_right"><b><i><?php
               if ($sess['HASIL_PUSAT'] == 'MK')
                echo 'Memenuhi Ketentuan';
               else
                echo 'Tidak Memenuhi Ketentuan';
               ?></i></b></td></tr>
           <?php if ($sess['JUSTIFIKASI_PUSAT'] != NULL || $sess['JUSTIFIKASI_PUSAT'] != "") { ?>
            <tr><td class="td_left">Justifikasi Pusat</td><td class="td_right"><?php echo $sess['JUSTIFIKASI_PUSAT']; ?></td></tr>
            <?php
           }
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
           ?><input type="text" name="IKLAN_PANGAN[FILE_IKLAN]" value="<?php echo $sess['FILE_IKLAN']; ?>">
           <span class="file_FILE_IKLAN"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_013/mdml'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_m/<?php echo 'iklan_013/irt'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" jns="FILE_IKLAN">Edit atau Hapus File ?</a></span>
           <span class="upload_FILE_IKLAN" hidden><input type="file" class="upload_FILE_IKLAN" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_013/mdml'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran" value="<?php echo $sess['FILE_IKLAN']; ?>" />
            &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx .rar</span><span class="file_FILE_IKLAN"></span>
           <?php
          } else {
           ?>
           <span class="upload_FILE_IKLAN"><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx-rar" url="<?php echo site_url(); ?>/utility/uploads/get_upload_m/<?php echo 'iklan_013/mdml'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran"/>
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
         <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="CATATAN" class="stext" rel="required" title="Catatan"></textarea></td></tr>
        </table>
       </div>
      </div>
     </div>
<?php } ?>

    <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanIklan_013', '', '');">
      <span><span class="icon"></span>&nbsp; <?php echo $labelSimpan; ?> </span></a>&nbsp;
     <a href="javascript:void(0)" class="button back" onclick="goBack()" >
      <span><span class="icon"></span>&nbsp; Kembali</span></a></div>
    <br />
    <br />
   </div>
  </div>
  <input type="hidden" name="IKLAN_ID[]" value="<?php echo $sess['IKLAN_ID']; ?>" />
  <input type="hidden" name="UPDATE" value="<?php echo $sess['STATUS']; ?>" />
  <input type="hidden" name="KLASIFIKASIIKLAN" value="<?php echo $klasifikasi; ?>" />
  <input type="hidden" name="EDIT" value="<?php echo $editTL; ?>" />
  <input type="hidden" name="TUJUAN" value="<?php echo $tujuan; ?>" />
  <input type="hidden" name="JENIS" value="<?php echo "MD/ML"; ?>" />
 </form>
</div>
</div>
<script type="text/javascript">
          function goBack()
          {
           window.history.back()
          }
          function sl_jenis_pangan(obj, A) {
           var param = $(obj).val();
           var kel = "";
           if (param == "Umum")
            kel = "1";
           else if (param == "Untuk kelompok orang tertentu")
            kel = "2";
           else if (param == "Berkaitan dengan proses dan asal serta sifat bahan pangan")
            kel = "3";
           else if (param == "Menyertakan undian, sayembara atau hadiah")
            kel = "4";
           else if (param == "Berkaitan dengan klaim gizi dan klaim kesehatan")
            kel = "5";
           else if (param == "Minuman beralkohol")
            kel = "6";
           else if (param == "Pangan halal")
            kel = "7";
           if (A != "LOAD")
            resetUraian();
           mkTmk();
           $("#expand5").show();
           $("#expand5a").show();
           $("#expand6b").show();
           $(".kelompok_" + kel).show();
          }
          function resetUraian() {
           $(".kelompok_1").hide();
           $(".kelompok_1").each(function() {
            $(this).find('span').hide();
           });
           $(".kelompok_2").hide();
           $(".kelompok_2").each(function() {
            $(this).find('span').hide();
           });
           $(".kelompok_3").hide();
           $(".kelompok_3").each(function() {
            $(this).find('span').hide();
           });
           $(".kelompok_4").hide();
           $(".kelompok_4").each(function() {
            $(this).find('span').hide();
           });
           $(".kelompok_5").hide();
           $(".kelompok_5").each(function() {
            $(this).find('span').hide();
           });
           $(".kelompok_6").hide();
           $(".kelompok_6").each(function() {
            $(this).find('span').hide();
           });
           $(".kelompok_7").hide();
           $(".kelompok_7").each(function() {
            $(this).find('span').hide();
           });
           $(".uPelanggaran").val("");
           $(".uPelanggaran").attr("rel", "");
           $(".uraianPelanggaran").attr("checked", false);
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
           }
//           $("#namaMediaIklan").unautocomplete();
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
                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_m/" + arrdata[3] + "/" + arrdata[4] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_PANGAN[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
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
           if ($(X).is(":checked")) {
            $('.' + XXX).fadeIn("slow");
            $('.' + XXX).attr('hidden', false);
            $('.' + XXX).attr('rel', 'required');
           } else {
            $('.' + XXX).fadeOut("slow");
            $('.' + XXX).val("");
            $('.' + XXX).attr('hidden', true);
            $('.' + XXX).attr('rel', ' ');
           }
           mkTmk();
           verifikasiPusat($(".verifikasiPusat"));
           verifikasiTL($("#vTMKSub"));
          }
          function mkTmk() {
           var X = cekAll();
           if (X === true) {
            $("#kesimpulanHasilPenilaian").val("Tidak Memenuhi Ketentuan");
            $("#kesimpulanHasilPenilaianVal").val("TMK");
           } else if (X !== true) {
            $("#kesimpulanHasilPenilaian").val("Memenuhi Ketentuan");
            $("#kesimpulanHasilPenilaianVal").val("MK");
           }
           cekLampiran();
          }
          function checkList(obj) {
           var XXX = obj.attr("name"), xxx = obj.val(), X = "input:radio[name='" + XXX + "']", XX = xxx.split('_'), cls = obj.attr("class");
           if ($(X).is(":checked")) {
            uraianTidakLengkap();
            mkTmk();
            if (cls === 'infoTambahan') {
             uraianPenilaian1();
            }
           }
          }
          function verifikasiPusat(X) {
           if ($(X).val() === "MK") {
            $(".vMK").show();
            $(".vMK").attr("rel", "required");
            $(".vTMK").hide();
            $(".vTMK").attr("rel", " ");
            $(".vTMK").val("");
            $(".vTMK2").hide("slow");
            $(".vTMK2").val("");
            $(".vTMK2").attr("rel", "");
            $(".vTMK2a").val("");
           }
           else if ($(X).val() === "TMK") {
            $(".vMK").hide();
            $(".vMK").attr("rel", " ");
            $(".vMK").val("");
            $(".vTMK").show();
            $(".vTMK").attr("rel", "required");
           }
           else {
            $(".vMK").hide();
            $(".vMK").attr("rel", " ");
            $(".vMK").val("");
            $(".vMK").hide();
            $(".vTMK").hide();
            $(".vTMK").hide();
            $(".vTMK").attr("rel", " ");
            $(".vTMK").val("");
            $(".vTMK2").hide("slow");
            $(".vTMK2").val("");
            $(".vTMK2").attr("rel", "");
            $(".vTMK2a").val("");
           }
           if ($(X).val() != '') {
            if ($(X).val() != $("#kesimpulanHasilPenilaianVal").val()) {
             $(".vJustifikasi").show("slow");
             $(".chkJustifikasi").attr("rel", "required");
            } else if ($(X).val() == $("#kesimpulanHasilPenilaianVal").val()) {
             $(".vJustifikasi").hide("slow");
             $(".chkJustifikasi").attr("rel", "");
            }
           } else {
            $(".vJustifikasi").hide("slow");
            $(".chkJustifikasi").attr("rel", "");
           }
          }
          function verifikasiTL(X) {
           if ($(X).val() == 'TL' || $(X).val() == 'STL') {
            $(".vTMK2").show("slow");
            $(".vTMK2").attr("rel", "required");
           } else {
            $(".vTMK2").hide("slow");
            $(".vTMK2").attr("rel", "");
            $(".vTMK2").val("");
            $(".vTMK2a").val("");
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
            $("[name='IKLAN[EDISI1]'] option[value='<?php echo $edisiMedia[0]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[EDISI2]'] option[value='<?php echo $edisiMedia[1]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[TAYANG1]'] option[value='<?php echo $tayangMedia[0]; ?>']").attr("selected", "selected");
            $("[name='IKLAN[TAYANG2]'] option[value='<?php echo $tayangMedia[1]; ?>']").attr("selected", "selected");
            sl_jenis_pangan($("#kelompokIklan"), "LOAD");
            if ("<?php echo trim($UP[0]); ?>" !== "") {
             $("input:checkbox[name='uraian1']").attr('checked', 'checked');
             checkListTxt('uraian1');
            }
            if ("<?php echo trim($UP[1]); ?>" !== "") {
             $("input:checkbox[name='uraian2']").attr('checked', 'checked');
             checkListTxt('uraian2');
            }
            if ("<?php echo trim($UP[2]); ?>" !== "") {
             $("input:checkbox[name='uraian3']").attr('checked', 'checked');
             checkListTxt('uraian3');
            }
            if ("<?php echo trim($UP[3]); ?>" !== "") {
             $("input:checkbox[name='uraian4']").attr('checked', 'checked');
             checkListTxt('uraian4');
            }
            if ("<?php echo trim($UP[4]); ?>" !== "") {
             $("input:checkbox[name='uraian5']").attr('checked', 'checked');
             checkListTxt('uraian5');
            }
            if ("<?php echo trim($UP[5]); ?>" !== "") {
             $("input:checkbox[name='uraian6']").attr('checked', 'checked');
             checkListTxt('uraian6');
            }
            if ("<?php echo trim($UP[6]); ?>" !== "") {
             $("input:checkbox[name='uraian7']").attr('checked', 'checked');
             checkListTxt('uraian7');
            }
            if ("<?php echo trim($UP[7]); ?>" !== "") {
             $("input:checkbox[name='uraian8']").attr('checked', 'checked');
             checkListTxt('uraian8');
            }
            if ("<?php echo trim($UP[8]); ?>" !== "") {
             $("input:checkbox[name='uraian9']").attr('checked', 'checked');
             checkListTxt('uraian9');
            }
            if ("<?php echo trim($UP[9]); ?>" !== "") {
             $("input:checkbox[name='uraian10']").attr('checked', 'checked');
             checkListTxt('uraian10');
            }
            if ("<?php echo trim($UP[10]); ?>" !== "") {
             $("input:checkbox[name='uraian11']").attr('checked', 'checked');
             checkListTxt('uraian11');
            }
            if ("<?php echo trim($UP[11]); ?>" !== "") {
             $("input:checkbox[name='uraian12']").attr('checked', 'checked');
             checkListTxt('uraian12');
            }
            if ("<?php echo trim($UP[12]); ?>" !== "") {
             $("input:checkbox[name='uraian13']").attr('checked', 'checked');
             checkListTxt('uraian13');
            }
            if ("<?php echo trim($UP[13]); ?>" !== "") {
             $("input:checkbox[name='uraian14']").attr('checked', 'checked');
             checkListTxt('uraian14');
            }
            if ("<?php echo trim($UP[14]); ?>" !== "") {
             $("input:checkbox[name='uraian15']").attr('checked', 'checked');
             checkListTxt('uraian15');
            }
            if ("<?php echo trim($UP[15]); ?>" !== "") {
             $("input:checkbox[name='uraian16']").attr('checked', 'checked');
             checkListTxt('uraian16');
            }
            if ("<?php echo trim($UP[16]); ?>" !== "") {
             $("input:checkbox[name='uraian17']").attr('checked', 'checked');
             checkListTxt('uraian17');
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
             verifikasiTL($("#vTMKSub"));
 <?php } ?>
            showHide();
            showHide2('<?php echo $sess['MEDIA']; ?>');
<?php } ?>
           //                      akhir load data edit
           $("input.namaPangan").autocomplete($("input.namaPangan").attr("url") + '3', {width: 244, selectFirst: false});
           $("input.namaPangan").result(function(event, data, formatted) {
//            $("input.namaPangan").unautocomplete();
//            $(".ac_results").remove();
            var cls = $(this).attr('urut');
            if (data) {
             $(this).val(data[1]);
             if (data[13] !== "-" && data[13] !== "")
              $("#merkDagang" + cls).val(data[13]);
             else
              $("#merkDagang" + cls).val("-");
             $("#namaPemilikNIE" + cls).val(data[3]);
             $("#NIE" + cls).val(data[2]);
             $("#mbbpomid" + cls).val(data[2]);
             $("#alamatPemilikNIE" + cls).val(data[5]);
             $("input.op").autocomplete($("input.op").attr("url") + $("#bbpomid" + cls).val(), {width: 244, selectFirst: false});
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
            var nom = $(this).attr('terakhir'), idtr = $(this).attr('periksa'), cls = idtr + nom;
            $("#tb_pangan").append('<tr class= "' + cls + '"><td>&nbsp;</td></tr><tr class= "' + cls + '"><td width="150">Nama Pangan</td><td><input type="text" size="50" name="PRODUK[NAMA][]" class="namaPangan' + cls + '" id="namaPangan" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg_2/" title="Nama Pangan" rel="required" />&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Pangan" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Merk Dagang</td><td><input type="text" size="50" name="PRODUK[MERK_PRODUK][]" id="merkDagang' + cls + '" title="Merk Dagang" /></td></tr><tr class= "' + cls + '"><td width="150">Nama Pemilik Izin Edar</td><td><input type="text" size="50" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="Pemilik Izin Edar" /></td></tr><tr class= "' + cls + '"><td width="150">Nomor Izin Edar</td><td><input type="text" size="50" name="PRODUK[NOMORIZINEDAR][]" id="NIE' + cls + '" title="Nomor Izin Edar" /></td></tr><tr class= "' + cls + '"><td width="150">Alamat Pemilik Izin Edar</td><td><textarea name="PRODUK[ALAMAT_PEMILIK_IZIN_EDAR][]" style="width: 314px;" id="alamatPemilikNIE ' + cls + ' " title="Alamat Pemilik Izin Edar" rel="required"></textarea></td></tr>')
            $("input.namaPangan" + cls).autocomplete($("input.namaPangan").attr("url") + '3', {width: 244, selectFirst: false});
            $("#minCls" + cls).click(function() {
             $('.' + cls).remove();
            });
            $("input.namaPangan" + cls).result(function(event, data, formatted) {
             if (data) {
              $(this).val(data[1]);
              if (data[13] !== "-" && data[13] !== "")
               $("#merkDagang" + cls).val(data[13]);
              else
               $("#merkDagang" + cls).val("-");
              $("#namaPemilikNIE" + cls).val(data[3]);
              $("#NIE" + cls).val(data[2]);
              $("#mbbpomid" + cls).val(data[2]);
              $("#alamatPemilikNIE" + cls).val(data[5]);
              $("input.op").autocomplete($("input.op").attr("url") + $("#bbpomid" + cls).val(), {width: 244, selectFirst: false});
             }
            });
            $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter', showTimeout: 1, alignTo: 'target', alignX: 'right', alignY: 'center', offsetX: 5, allowTipHover: false, fade: false, slide: false});
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
              if (jenis !== "FILE_LAMPIRAN_IKLAN")
               $("#fileToUpload_" + jenis + "").attr("rel", "");
             }
            });
            return false;
           });
           $(".verifikasiPusat").change(function() {
            verifikasiPusat($(this));
           });
           $("#vTMKSub").change(function() {
            verifikasiTL($(this));
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
          });
</script>