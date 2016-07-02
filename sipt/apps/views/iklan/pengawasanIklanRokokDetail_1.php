<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<link type="text/css" href="<?php echo base_url(); ?>css/iklanPenandaan.css" rel="stylesheet" media="screen"/>
<div id="judulpmnikl" class="judul"></div>
<div class="headersarana">PENGAWASAN IKLAN ROKOK </div>
<?php
$bulan_iklan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tahun_iklan = array(range(date("Y"), 2007));
$totalThn = array_sum(array_map("count", $tahun_iklan));
$UP = explode('^', $sess['URAIAN_PELANGGARAN']);
$tayangMedia = explode(" ", $sess['JAM_TAYANG']);
$hasilKesimpulanOpt = explode("^", $sess['TL_PUSAT']);
$hasilKesimpulanOpt2 = explode("^", $sess['DETAIL_PUSAT']);
$kelompokIklan = array("" => "", "Iklan" => "Iklan", "Sponsor" => "Sponsor", "Layanan Masyarakat" => "Layanan Masyarakat");
$edisiUraian = explode("^", $sess['EDISI']);
$edisiMedia = explode(" ", $edisiUraian[0]);
$kegiatan = explode("^", $sess['JUDUL_KEGIATAN']);
$penilaianAll = explode("#", $sess["PENILAIAN"]);
if ($sess["JENIS"] == "CT") {
 foreach ($penilaianAll as $value) {
  $penCT[] = explode("_", $value);
 }
 $penilaianCT = $penilaianAll;
}
if ($sess["JENIS"] == "RD") {
 foreach ($penilaianAll as $value) {
  $penRD[] = explode("_", $value);
 }
 $penilaianRD = $penilaianAll;
}
if ($sess["JENIS"] == "TV") {
 foreach ($penilaianAll as $value) {
  $penTV[] = explode("_", $value);
 }
 $penilaianTV = $penilaianAll;
}
if ($sess["JENIS"] == "TI") {
 foreach ($penilaianAll as $value) {
  $penTI[] = explode("_", $value);
 }
 $penilaianTI = $penilaianAll;
}
if ($sess["JENIS"] == "LR") {
 foreach ($penilaianAll as $value) {
  $penLR[] = explode("_", $value);
 }
 $penilaianLR = $penilaianAll;
}
?>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpengawasanIklan_007">
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
       <tr><td class="td_left">Jenis Iklan</td>
        <td class="td_right"><?php echo form_dropdown('IKLANNAPZA[KELOMPOK]', $kelompokIklan, $sess['KELOMPOK_IKLAN'], 'title="Kelompok Iklan" class="stext" rel="required"') ?></td>
       </tr>
      </table>
     </div>
    </div><!-- Akhir Pemeriksaan !-->
    <div style="height:5px;"></div>
    <div class="acco2"><div class="expand"><a title="expand/collapse" href="#" style="display: block;">IDENTITAS ROKOK - IKLAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table>
        <tr>
         <td>
          <table>
           <tbody id="tb_napza">
            <?php
            $jmldata = 0;
            $nomor = array();
            $jmldata = count($nomor);
            if ($jmldata == 0) {
             $jmldata = 1;
             $nomor[] = "";
            }
            $i = 0;
            do {
             ?>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nama / Merk Rokok</td>
              <td>
               <input type="text" size="40" name="PRODUK[NAMA][]" class="namaNapza" id="namaNapza" title="Nama / Merk Rokok" rel="required" value="<?php echo $sess2[$i]['NAMA_PRODUK']; ?>"/>&nbsp;
               <?php
               if ($i == 0) {
                ?>
                <a href="javascript:void(0)" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Rokok" /></a>
                <?php
               } else {
                ?>
                <a href="javascript:void(0)" class="min" onclick="$('.urut<?php echo $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus Rokok" /></a>
                <?php
               }
               ?></td>
             </tr>
             <tr class="urut<?php echo $i; ?>">
              <td width="150">Nama Produsen</td>
              <td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE" title="Nama Produsen" value="<?php echo $sess2[$i]['NAMA_PEMILIK_IZIN_EDAR']; ?>" rel="required" />
              </td>
             </tr>
             <tr>
              <td class="td_left">Bentuk Kemasan Produk Tembakau</td><td class="td_right"><?php echo form_dropdown("PRODUK[JENIS][]", $jenisKmsn, $sess2[$i]['JENIS_PRODUK'], "id='bentukKemasan' rel='required' class='stext' title='Bentuk Kemasan Produk Tembakau' ") ?></td>
              <td colspan="2"></td>
             </tr>
             <?php
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
       <table class="form_tabel">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Media</td>
         <td></td>
         <td colspan="2" class="td_left"><select name="IKLAN[JENISIKLAN]" onChange="mediaIklan2(this);" id="iklan_media" class="stext sl_iklan_media" title="Jenis Iklan" rel="required">
           <option value=""></option>
           <option value="Cetak">Cetak</option>
           <option value="Penyiaran">Penyiaran</option>
           <option value="Luar Ruang">Luar Ruang</option>
           <option value="Media Teknologi Informasi Lainnya">Media Teknologi Informasi Lainnya</option></select></td>
        </tr>
        <tr class="iklanObatReq iorMedia">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Jenis Media</td>
         <td></td>
         <td colspan="2" class="td_left lainnyaChoosed" hidden>
          <input type="text" class="stext mediaIklanEdit" id="lnChoosed" name="IKLAN[MEDIA][]" title="Media Iklan" /></td>
         <td colspan="2" class="td_left penyiaranChoosed" hidden>
          <select class="stext mediaIklanEdit" id="pChoosed" onChange="mediaIklan(this);" name="IKLAN[MEDIA][]" title="Media Iklan">
           <option value=""></option>
           <option value="TV">TV</option>
           <option value="Radio">Radio</option></select></td>
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
        <tr class="td_left">
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Bunyi Iklan</td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left"><input type="text" name="IKLAN[JUDUL][]" class="stext namaMedia" rel="required" title="Bunyi Iklan" value="<?php echo $kegiatan[0] ?>" /></td>
        </tr>
        <tr class="td_left" id="namaMedia" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;"><span id ="namaMedia1"></span></td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left"><input type="text" id="namaMediaIklan" class="stext namaMedia" title="Nama Media" url="<?php echo site_url(); ?>/autocompletes/autocomplete/nama_media/" value="<?php echo $sess['NAMA_MEDIA']; ?>" /><input type="hidden" id="idMediaIklan"  value="<?php echo $sess['ID_MEDIA']; ?>" /></td>
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
        <tr class="cetakChoosed">
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Nama Penerbit</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="stext cetakChoosed" name="IKLAN[JUDUL][]" id="" title="Nama Penerbit" onchange="comp('C')" value="<?php echo $kegiatan[1] ?>"/>&nbsp;&nbsp;
        </tr>
        <tr class="cetakChoosed">
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Nama Penanggung Jawab</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="stext cetakChoosed" name="IKLAN[JUDUL][]" id="" title="Nama Penanggung Jawab" onchange="comp('C')"  value="<?php echo $kegiatan[2] ?>"/>&nbsp;&nbsp;
        </tr>
        <tr class="penyiaranChoosed">
         <td class="td_left_checklist" style="vertical-align: top;"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Nama Acara</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input type="text" class="stext penyiaranChoosed" name="IKLAN[JUDUL][]" id="" title="Nama Penanggung Jawab" onchange="comp('C')" value="<?php echo $kegiatan[3] ?>"/>&nbsp;&nbsp;
        </tr>
        <tr class="cetakTertentu" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Nama Lokasi Pengambilan Iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><input name="IKLAN[LOKASI]" type="text" class="stext" id="namaLokasi" title="Alamat" value="<?php echo $sess['NAMA_LOKASI_IKLAN']; ?>"/>
        </tr>
        <tr class="cetakTertentu" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist" style="vertical-align: top;">Alamat Lokasi Pengawasan Iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left" colspan="2"><textarea class="stext cetakTertentu" id="alamatLokasi" title="Alamat Lokasi Pengambilan Iklan" name="IKLAN[ALAMAT]"><?php echo $sess['ALAMAT_LOKASI_IKLAN']; ?></textarea></td>
        </tr>
        <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?>
         <tr class="ifElektronik">
          <td class="td_left_checklist"></td>
          <td class="td_left" style="vertical-align: top;">Provinsi</td>
          <td></td>
          <td style="width: 10%;" colspan="2" class="td_left"><?php echo form_dropdown('KOTA', $provinsi, $provinsiVal, 'style="width:158px" id="provkotAlamat" class="stext" rel="required" title="Nama Provinsi Pengambilan Iklan"'); ?></td>
         </tr>
        <?php } ?>
        <tr class="cetakTertentu" hidden>
         <td class="td_left_checklist"></td>
         <td class="td_left" style="vertical-align: top;">Kota / Kabupaten</td>
         <td></td>
         <td style="width: 10%;" colspan="2" class="td_left"><?php echo form_dropdown('IKLAN[KOTA]', $kabupaten, $kabupatenVal, 'style="width:158px" id="kabkotAlamat" class="stext" title="Nama Kota Pengambilan Iklan"'); ?></td>
        </tr>
       </table>
      </div>
     </div>
     <div style="height:5px;" id="expand2b"></div>

     <!--5-->
     <div class="expand" id="expand5"><a title="expand/collapse" href="#" style="display: block;">PENILAIAN</a></div>
     <div class="collapse">
      <div id="medianyaKosong">Silahkan pilih media : Identitas Media Penayangan Iklan => Media / Jenis Media</div>
      <!--Radio-->
      <div class="accCntnt"  id="penilaianRadio" hidden>
       <table class="form_tabel">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;"></td>
         <td style="background-color: white;"></td>
         <td style="background-color: white;" class="td_left">
          <input type="radio" id="r1" disabled="true">
          <label for="r1" style="width: 54px; height: 10px;">Ya</label>
          <span style="margin-left: 5px;"></span>
          <input type="radio" id="r2" disabled="true">
          <label for="r2" style="width: 54px; height: 10px;">Tidak</label>
         </td>
        </tr>
        <!--Romawi 2-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "radio_romawi2a" type="radio" id="radio_aromawi2A1" name="RADIO[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penRD[0][0] == "+") echo "checked"; ?>>
          <label for="radio_aromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "radio_romawi2a" type="radio" id="radio_aromawi2A2" name="RADIO[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penRD[0][0] == "-") echo "checked"; ?>>
          <label for="radio_aromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[1]" style="display: none" value="<?php echo $penilaianRD[0]; ?>">
         </td>
        </tr>
        <tr class="radio_romawi2a subPenilaianRadio" hidden>
         <td></td>
         <td><b>Jenis Gambar dan tulisan</b></td>
         <td>&nbsp;</td>
        </tr>
        <tr class="radio_romawi2a subPenilaianRadio" hidden>
         <td></td>
         <td style="vertical-align: top">1. Jenis audio (suara) :</td>
         <td></td>
         <td class="td_left">
          <input type="text" size="23" class="radio_romawi2Val subPenilaianRadio" name="RADIO[2]" id="RADIO[2]"  placeholder="Gambar" value="<?php echo $penilaianRD[1]; ?>"><br/>
          <input type="text" size="23" class="radio_romawi2Val subPenilaianRadio" name="RADIO[3]" id="RADIO[3]" placeholder="Suara" value="<?php echo $penilaianRD[2]; ?>" style="margin-top: 5px;">
         </td>
        </tr>
        <tr class="radio_romawi2a subPenilaianRadio rowIklan" hidden>
         <td></td>
         <td>Suara sesuai Gambar 1 : ”Merokok sebabkan kanker mulut”</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="RADIO[ROMAWI2][4]" value="RD_GT1" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[3][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT radio_romawi2aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[4]" style="display: none" <?php if (trim($penilaianRD[3]) != "") echo "value='" . $penilaianRD[3] . "'" ?> />
         </td>
        </tr>
        <tr class="radio_romawi2a subPenilaianRadio rowIklan" hidden>
         <td></td>
         <td>Suara sesuai Gambar 3 : ”Merokok Sebabkan Kanker Tenggorokan”</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="RADIO[ROMAWI2][5]" value="RD_GT3" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[4][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT radio_romawi2aVal subPenilaianRadio subPenilaianRadioGTVal" name="RADIO[5]" style="display: none" <?php if (trim($penilaianRD[4]) != "") echo "value='" . $penilaianRD[4] . "'" ?> />
         </td>
        </tr>
        <tr class="radio_romawi2a subPenilaianRadio rowIklan" hidden>
         <td></td>
         <td>Suara sesuai Gambar 5 : ”Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis”</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="RADIO[ROMAWI2][6]" value="RD_GT5" class="uraianPenilaian subPenilaianRadioGT" <?php if ($penRD[5][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT radio_romawi2aVal subPenilaian subPenilaianRadioGTVal" name="RADIO[6]" style="display: none" <?php if (trim($penilaianRD[5]) != "") echo "value='" . $penilaianRD[5] . "'" ?> />
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Suara sesuai Gambar terdengar jelas</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_cromawi2A1" name="RADIO[7]" value="+_Suara sesuai Gambar terdengar jelas" <?php if ($penRD[6][0] == "+") echo "checked"; ?>>
          <label for="radio_cromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_cromawi2A2" name="RADIO[7]" value="-_Suara sesuai Gambar terdengar jelas" <?php if ($penRD[6][0] == "-") echo "checked"; ?>>
          <label for="radio_cromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[7]" style="display: none" value="<?php echo $penilaianRD[6]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "radio_romawi2d" type="radio" id="romawi_dromawi2A1" name="RADIO[8]" value="-_Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan" <?php if ($penRD[7][0] == "+") echo "checked"; ?>>
          <label for="romawi_dromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "radio_romawi2d" type="radio" id="romawi_dromawi2A2" name="RADIO[8]" value="+_Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan" <?php if ($penRD[7][0] == "-") echo "checked"; ?>>
          <label for="romawi_dromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[8]" style="display: none" value="<?php echo $penilaianRD[7]; ?>">
         </td>
        </tr>
        <tr class="radio_romawi2d subPenilaianRadio" hidden>
         <td></td>
         <td>Jika Tidak 10%, tuliskan durasi peringatan kesehatan: </td>
         <td></td>
         <td class="td_left">
          <input type="text" class="radio_romawi2Val subPenilaianRadio radio_romawi2d" size="9" name="RADIO[9]"  id="RADIO[8]" value="<?php echo $penilaianRD[8]; ?>" />&nbsp;&nbsp;&nbsp;Detik
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Pada bagian awal mengucapkan kalimat “PERINGATAN” dengan jelas</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_eromawi2A1" name="RADIO[10]" value='+_Pada bagian awal mengucapkan kalimat "PERINGATAN" dengan jelas' <?php if ($penRD[9][0] == "+") echo "checked"; ?>>
          <label for="radio_eromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_eromawi2A2" name="RADIO[10]" value='+_Pada bagian awal mengucapkan kalimat "PERINGATAN" dengan jelas' <?php if ($penRD[9][0] == "-") echo "checked"; ?>>
          <label for="radio_eromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[10]" style="display: none" value="<?php echo $penilaianRD[9]; ?>">
         </td>
        </tr>
        <!--Romawi 3-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN MATERI IKLAN  SELAIN PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Menyiarkan penandaan/tulisan 18+ dalam iklan rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_aromawi3A1" name="RADIO[11]" value="+_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penRD[10][0] == "+") echo "checked"; ?>>
          <label for="radio_aromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_aromawi3A2" name="RADIO[11]" value="-_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penRD[10][0] == "-") echo "checked"; ?>>
          <label for="radio_aromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[11]" style="display: none" value="<?php echo $penilaianRD[10]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_bromawi3A1" name="RADIO[12]" value="+_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penRD[11][0] == "+") echo "checked"; ?>>
          <label for="radio_bromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_bromawi3A2" name="RADIO[12]" value="-_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penRD[11][0] == "+") echo "checked"; ?>>
          <label for="radio_bromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[12]" style="display: none" value="<?php echo $penRD[11][1]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Tidak mencantumkan nama produk yang bersangkutan adalah rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_cromawi3A1" name="RADIO[13]" value="+_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penRD[12][0] == "+") echo "checked"; ?>>
          <label for="radio_cromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_cromawi3A2" name="RADIO[13]" value="-_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penRD[12][0] == "-") echo "checked"; ?>>
          <label for="radio_cromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[13]" style="display: none" value="<?php echo $penilaianRD[12]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_dromawi3A1" name="RADIO[14]" value="+_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penRD[13][0] == "+") echo "checked"; ?>>
          <label for="radio_dromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_dromawi3A2" name="RADIO[14]" value="-_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penRD[13][0] == "-") echo "checked"; ?>>
          <label for="radio_dromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[14]" style="display: none" value="<?php echo $penilaianRD[13]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Tidak menggunakan kata atau kalimat yang menyesatkan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_eromawi3A1" name="RADIO[15]" value="+_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penRD[14][0] == "+") echo "checked"; ?>>
          <label for="radio_eromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_eromawi3A2" name="RADIO[15]" value="-_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penRD[14][0] == "-") echo "checked"; ?>>
          <label for="radio_eromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[15]" style="display: none" value="<?php echo $penilaianRD[14]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f.  Tidak merangsang atau menyarankan orang untuk merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_fromawi3A1" name="RADIO[16]" value="+_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penRD[15][0] == "+") echo "checked"; ?>>
          <label for="radio_fromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_fromawi3A2" name="RADIO[16]" value="-_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penRD[15][0] == "-") echo "checked"; ?>>
          <label for="radio_fromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[16]" style="display: none" value="<?php echo $penilaianRD[15]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">g. Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_gromawi3A1" name="RADIO[17]" value="+_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penRD[16][0] == "+") echo "checked"; ?>>
          <label for="radio_gromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_gromawi3A2" name="RADIO[17]" value="-_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penRD[16][0] == "-") echo "checked"; ?>>
          <label for="radio_gromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[17]" style="display: none" value="<?php echo $penilaianRD[16]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">h. Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_hromawi3A1" name="RADIO[18]" value="+_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penRD[17][0] == "+") echo "checked"; ?>>
          <label for="radio_hromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_hromawi3A2" name="RADIO[18]" value="-_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penRD[17][0] == "-") echo "checked"; ?>>
          <label for="radio_hromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[18]" style="display: none" value="<?php echo $penilaianRD[17]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">i.  Tidak menggunakan tokoh kartun sebagai model iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_iromawi3A1" name="RADIO[19]" value="+_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penRD[18][0] == "+") echo "checked"; ?>>
          <label for="radio_iromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_iromawi3A2" name="RADIO[19]" value="-_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penRD[18][0] == "-") echo "checked"; ?>>
          <label for="radio_iromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[19]" style="display: none" value="<?php echo $penilaianRD[18]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">j.  Tidak bertentangan dengan norma yang berlaku dalam masyarakat</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_jromawi3A1" name="RADIO[20]" value="+_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penRD[19][0] == "+") echo "checked"; ?>>
          <label for="radio_jromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_jromawi3A2" name="RADIO[20]" value="-_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penRD[19][0] == "-") echo "checked"; ?>>
          <label for="radio_jromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[20]" style="display: none" value="<?php echo $penilaianRD[19]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">k. Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="radio_kromawi3A1" name="RADIO[21]" value="+_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penRD[20][0] == "+") echo "checked"; ?>>
          <label for="radio_kromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="radio_kromawi3A2" name="RADIO[21]" value="-_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penRD[20][0] == "-") echo "checked"; ?>>
          <label for="radio_kromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianRadio" name="RADIO[21]" style="display: none" value="<?php echo $penilaianRD[20]; ?>">
         </td>
        </tr>
        <!--Romawi 4-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>HASIL PENGAWASAN</b></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan  Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="RADIO[22]" class="penilaianRadio" title="Pengawasan  Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianRD[21] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianRD[21] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="RADIO[23]" class="penilaianRadio" title="Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianRD[22] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianRD[22] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <!--Romawi 5-->
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist"><b>KESIMPULAN</b></td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="RADIO[24]" class="penilaianRadio" title="Kesimpulan"><option value=""></option><option value="MK" <?php if ($penilaianRD[23] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianRD[23] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
       </table>
      </div>
      <!--Cetak-->
      <div class="accCntnt"  id="penilaianCetak" hidden>
       <table class="form_tabel">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;"></td>
         <td style="background-color: white;"></td>
         <td style="background-color: white;" class="td_left">
          <input type="radio" id="r1" disabled="true">
          <label for="r1" style="width: 54px; height: 10px;">Ya</label>
          <span style="margin-left: 5px;"></span>
          <input type="radio" id="r2" disabled="true">
          <label for="r2" style="width: 54px; height: 10px;">Tidak</label>
         </td>
        </tr>
        <!--Romawi 2-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "cetak_romawi2a" type="radio" id="cetak_aromawi2A1" name="CETAK[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penCT[0][0] == "+") echo "checked"; ?>>
          <label for="cetak_aromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "cetak_romawi2a" type="radio" id="cetak_aromawi2A2" name="CETAK[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penCT[0][0] == "-") echo "checked"; ?>>
          <label for="cetak_aromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[1]" style="display: none" value="<?php echo $penilaianCT[0]; ?>">
         </td>
        </tr>
        <tr class="cetak_romawi2a subPenilaianCetak" hidden>
         <td></td>
         <td><b>Jenis Gambar dan tulisan</b></td>
         <td colspan="2">&nbsp;</td>
        </tr>
        <tr class="cetak_romawi2a subPenilaianCetak rowIklan" hidden>
         <td></td>
         <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="CETAK[2]" value="CT_GT1" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[1][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT cetak_romawi2aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[2]" style="display: none" <?php if (trim($penilaianCT[1]) != "") echo "value='" . $penilaianCT[1] . "'" ?> />
         </td>
        </tr>
        <tr class="cetak_romawi2a subPenilaianCetak rowIklan" hidden>
         <td></td>
         <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="CETAK[3]" value="CT_GT3" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[2][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT cetak_romawi2aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[3]" style="display: none" <?php if (trim($penilaianCT[2]) != "") echo "value='" . $penilaianCT[2] . "'" ?> />
         </td>
        </tr>
        <tr class="cetak_romawi2a subPenilaianCetak rowIklan" hidden>
         <td></td>
         <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="CETAK[4]" value="CT_GT5" class="uraianPenilaian subPenilaianCetakGT" <?php if ($penCT[3][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT cetak_romawi2aVal subPenilaianCetak subPenilaianCetakGTVal" name="CETAK[4]" style="display: none"  <?php if (trim($penilaianCT[3]) != "") echo "value='" . $penilaianCT[3] . "'" ?> >
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Gambar jelas dan mencolok sesuai dengan ketentuan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_cromawi2A1" name="CETAK[5]" value="+_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penCT[4][0] == "+") echo "checked"; ?>>
          <label for="cetak_cromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_cromawi2A2" name="CETAK[5]" value="-_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penCT[4][0] == "-") echo "checked"; ?>>
          <label for="cetak_cromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[5]" style="display: none" value="<?php echo $penilaianCT[4]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Luas Peringatan Kesehatan : minimal 15% dari total luas iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "cetak_romawi2d" type="radio" id="cetak_dromawi2A1" name="CETAK[6]" value="+_Luas Peringatan Kesehatan : minimal 15% dari total luas iklan" <?php if ($penCT[5][0] == "+") echo "checked"; ?>>
          <label for="cetak_dromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "cetak_romawi2d" type="radio" id="cetak_dromawi2A2" name="CETAK[6]" value="-_Luas Peringatan Kesehatan : minimal 15% dari total luas iklan" <?php if ($penCT[5][0] == "-") echo "checked"; ?>>
          <label for="cetak_dromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[6]" style="display: none" value="<?php echo $penilaianCT[5]; ?>">
         </td>
        </tr>
        <tr class="cetak_romawi2d subPenilaianCetak" hidden>
         <td></td>
         <td>Jika tidak 15%, tuliskan luas peringatan kesehatan: </td>
         <td></td>
         <td class="td_left">
          <input type="text" class="cetak_romawi2d cetak_romawi2Val subPenilaianCetak" size="9" name="CETAK[7]"  id="CETAK[6]"  value="<?php echo $penilaianCT[6]; ?>">&nbsp;&nbsp;&nbsp;
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_eromawi2A1" name="CETAK[8]" value='+_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan' <?php if ($penCT[7][0] == "+") echo "checked"; ?>>
          <label for="cetak_eromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_eromawi2A2" name="CETAK[8]" value='-_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan' <?php if ($penCT[7][0] == "-") echo "checked"; ?>>
          <label for="cetak_eromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[8]" style="display: none" value="<?php echo $penilaianCT[7]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_earomawi2A1" name="CETAK[9]" value='+_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penCT[8][0] == "+") echo "checked"; ?>>
          <label for="cetak_earomawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_earomawi2A2" name="CETAK[9]" value='-_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penCT[8][0] == "-") echo "checked"; ?>>
          <label for="cetak_earomawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[9]" style="display: none" value="<?php echo $penilaianCT[8]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f. Gambar peringatan kesehatan diletakkan dalam frame putih</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_ebromawi2A1" name="CETAK[10]" value='+_Gambar peringatan kesehatan diletakkan dalam frame putih' <?php if ($penCT[9][0] == "+") echo "checked"; ?>>
          <label for="cetak_ebromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_ebromawi2A2" name="CETAK[10]" value='-_Gambar peringatan kesehatan diletakkan dalam frame putih' <?php if ($penCT[9][0] == "-") echo "checked"; ?>>
          <label for="cetak_ebromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[10]" style="display: none" value="<?php echo $penilaianCT[9]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">g. Penempatan gambar terletak di pojok kanan bawah atau bagian tengah iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_ecromawi2A1" name="CETAK[11]" value='+_Penempatan gambar terletak di pojok kanan bawah atau bagian tengah iklan' <?php if ($penCT[10][0] == "+") echo "checked"; ?>>
          <label for="cetak_ecromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_ecromawi2A2" name="CETAK[11]" value='-_Penempatan gambar terletak di pojok kanan bawah atau bagian tengah iklan' <?php if ($penCT[10][0] == "-") echo "checked"; ?>>
          <label for="cetak_ecromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[11]" style="display: none" value="<?php echo $penilaianCT[10]; ?>">
         </td>
        </tr>
        <!--Romawi 3-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN MATERI IKLAN  SELAIN PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Menyiarkan penandaan/tulisan 18+ dalam iklan rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_aromawi3A1" name="CETAK[12]" value="+_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penCT[11][0] == "+") echo "checked"; ?>>
          <label for="cetak_aromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_aromawi3A2" name="CETAK[12]" value="-_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penCT[11][0] == "-") echo "checked"; ?>>
          <label for="cetak_aromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[12]" style="display: none" value="<?php echo $penilaianCT[11]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_bromawi3A1" name="CETAK[13]" value="+_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penCT[12][0] == "+") echo "checked"; ?>>
          <label for="cetak_bromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_bromawi3A2" name="CETAK[13]" value="-_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penCT[12][0] == "-") echo "checked"; ?>>
          <label for="cetak_bromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[13]" style="display: none" value="<?php echo $penilaianCT[12]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Tidak mencantumkan nama produk yang bersangkutan adalah rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_cromawi3A1" name="CETAK[14]" value="+_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penCT[13][0] == "+") echo "checked"; ?>>
          <label for="cetak_cromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_cromawi3A2" name="CETAK[14]" value="-_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penCT[13][0] == "-") echo "checked"; ?>>
          <label for="cetak_cromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[14]" style="display: none" value="<?php echo $penilaianCT[13]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_dromawi3A1" name="CETAK[15]" value="+_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penCT[14][0] == "+") echo "checked"; ?>>
          <label for="cetak_dromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_dromawi3A2" name="CETAK[15]" value="-_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penCT[14][0] == "-") echo "checked"; ?>>
          <label for="cetak_dromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[15]" style="display: none" value="<?php echo $penilaianCT[14]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Tidak menggunakan kata atau kalimat yang menyesatkan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_eromawi3A1" name="CETAK[16]" value="+_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penCT[15][0] == "+") echo "checked"; ?>>
          <label for="cetak_eromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_eromawi3A2" name="CETAK[16]" value="-_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penCT[15][0] == "-") echo "checked"; ?>>
          <label for="cetak_eromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[16]" style="display: none" value="<?php echo $penilaianCT[15]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f.  Tidak merangsang atau menyarankan orang untuk merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_fromawi3A1" name="CETAK[17]" value="+_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penCT[16][0] == "+") echo "checked"; ?>>
          <label for="cetak_fromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_fromawi3A2" name="CETAK[17]" value="-_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penCT[16][0] == "-") echo "checked"; ?>>
          <label for="cetak_fromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[17]" style="display: none" value="<?php echo $penilaianCT[16]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">g. Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_gromawi3A1" name="CETAK[18]" value="+_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penCT[17][0] == "+") echo "checked"; ?>>
          <label for="cetak_gromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_gromawi3A2" name="CETAK[18]" value="-_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penCT[17][0] == "-") echo "checked"; ?>>
          <label for="cetak_gromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[18]" style="display: none" value="<?php echo $penilaianCT[17]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">h. Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_hromawi3A1" name="CETAK[19]" value="+_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penCT[18][0] == "+") echo "checked"; ?>>
          <label for="cetak_hromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_hromawi3A2" name="CETAK[19]" value="-_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penCT[18][0] == "-") echo "checked"; ?>>
          <label for="cetak_hromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[19]" style="display: none" value="<?php echo $penilaianCT[18]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">i.  Tidak menggunakan tokoh kartun sebagai model iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_iromawi3A1" name="CETAK[20]" value="+_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penCT[19][0] == "+") echo "checked"; ?>>
          <label for="cetak_iromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_iromawi3A2" name="CETAK[20]" value="-_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penCT[19][0] == "-") echo "checked"; ?>>
          <label for="cetak_iromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[20]" style="display: none" value="<?php echo $penilaianCT[19]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">j.  Tidak bertentangan dengan norma yang berlaku dalam masyarakat</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_jromawi3A1" name="CETAK[21]" value="+_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penCT[20][0] == "+") echo "checked"; ?>>
          <label for="cetak_jromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_jromawi3A2" name="CETAK[21]" value="-_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penCT[20][0] == "-") echo "checked"; ?>>
          <label for="cetak_jromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[21]" style="display: none" value="<?php echo $penilaianCT[20]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">k. Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_kromawi3A1" name="CETAK[22]" value="+_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penCT[21][0] == "+") echo "checked"; ?>>
          <label for="cetak_kromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_kromawi3A2" name="CETAK[22]" value="-_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penCT[21][0] == "-") echo "checked"; ?>>
          <label for="cetak_kromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[22]" style="display: none" value="<?php echo $penilaianCT[21]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">l. Iklan tidak diletakkan di sampul depan dan/atau belakang media cetak, atau halaman depan surat kabar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_lromawi3A1" name="CETAK[23]" value="+_Iklan tidak diletakkan di sampul depan dan/atau belakang media cetak, atau halaman depan surat kabar" <?php if ($penCT[22][0] == "+") echo "checked"; ?>>
          <label for="cetak_lromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_lromawi3A2" name="CETAK[23]" value="-_Iklan tidak diletakkan di sampul depan dan/atau belakang media cetak, atau halaman depan surat kabar" <?php if ($penCT[22][0] == "-") echo "checked"; ?>>
          <label for="cetak_lromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[23]" style="display: none" value="<?php echo $penilaianCT[22]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">m. Iklan tidak diletakkan berdekatan dengan iklan makanan dan minuman</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_mromawi3A1" name="CETAK[24]" value="+_Iklan tidak diletakkan berdekatan dengan iklan makanan dan minuman" <?php if ($penCT[23][0] == "+") echo "checked"; ?>>
          <label for="cetak_mromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_mromawi3A2" name="CETAK[24]" value="-_Iklan tidak diletakkan berdekatan dengan iklan makanan dan minuman" <?php if ($penCT[23][0] == "-") echo "checked"; ?>>
          <label for="cetak_mromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[24]" style="display: none" value="<?php echo $penilaianCT[23]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">n. Luas kolom iklan tidak memenuhi seluruh halaman</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_nromawi3A1" name="CETAK[25]" value="+_Luas kolom iklan tidak memenuhi seluruh halaman" <?php if ($penCT[24][0] == "+") echo "checked"; ?>>
          <label for="cetak_nromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_nromawi3A2" name="CETAK[25]" value="-_Luas kolom iklan tidak memenuhi seluruh halaman" <?php if ($penCT[24][0] == "-") echo "checked"; ?>>
          <label for="cetak_nromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[25]" style="display: none" value="<?php echo $penilaianCT[24]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">o. Iklan tidak dimuat di media cetak untuk anak, remaja dan perempuan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="cetak_oromawi3A1" name="CETAK[26]" value="+_Iklan tidak dimuat di media cetak untuk anak, remaja dan perempuan" <?php if ($penCT[25][0] == "+") echo "checked"; ?>>
          <label for="cetak_oromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="cetak_oromawi3A2" name="CETAK[26]" value="-_Iklan tidak dimuat di media cetak untuk anak, remaja dan perempuan" <?php if ($penCT[25][0] == "-") echo "checked"; ?>>
          <label for="cetak_oromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianCetak" name="CETAK[26]" style="display: none" value="<?php echo $penilaianCT[25]; ?>">
         </td>
        </tr>
        <!--Romawi 4-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>HASIL PENGAWASAN</b></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan  Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="CETAK[27]" class="penilaianCetak" title="Pengawasan  Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianCT[26] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianCT[26] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="CETAK[28]" class="penilaianCetak" title="Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianCT[27] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianCT[27] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <!--Romawi 5-->
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist"><b>KESIMPULAN</b></td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="CETAK[29]" class="penilaianCetak" title="Kesimpulan"><option value=""></option><option value="MK" <?php if ($penilaianCT[27] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianCT[27] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
       </table>
      </div>
      <!--Luar ruang-->
      <div class="accCntnt"  id="penilaianLuarRuang" hidden>
       <table class="form_tabel">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;"></td>
         <td style="background-color: white;"></td>
         <td style="background-color: white;" class="td_left">
          <input type="radio" id="r1" disabled="true">
          <label for="r1" style="width: 54px; height: 10px;">Ya</label>
          <span style="margin-left: 5px;"></span>
          <input type="radio" id="r2" disabled="true">
          <label for="r2" style="width: 54px; height: 10px;">Tidak</label>
         </td>
        </tr>
        <!--Romawi 2-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "luarRuang_romawi2a" type="radio" id="luarRuang_aromawi2A1" name="LUARRUANG[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penLR[0][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_aromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "luarRuang_romawi2a" type="radio" id="luarRuang_aromawi2A2" name="LUARRUANG[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penLR[0][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_aromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[1]" style="display: none" value="<?php echo $penilaianLR[0]; ?>">
         </td>
        </tr>
        <tr class="luarRuang_romawi2a subPenilaianLuarRuang" hidden>
         <td></td>
         <td><b>Jenis Gambar dan tulisan</b></td>
         <td>&nbsp;</td>
        </tr>
        <tr class="luarRuang_romawi2a subPenilaianLuarRuang rowIklan" hidden>
         <td></td>
         <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="LUARRUANG[2]" value="LR_GT1" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[1][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT luarRuang_romawi2aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[2]" style="display: none" <?php if (trim($penilaianLR[1]) != "") echo "value='" . $penilaianLR[1] . "'" ?> />
         </td>
        </tr>
        <tr class="luarRuang_romawi2a subPenilaianLuarRuang rowIklan" hidden>
         <td></td>
         <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="LUARRUANG[3]" value="LR_GT3" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[2][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT luarRuang_romawi2aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[3]" style="display: none" <?php if (trim($penilaianLR[2]) != "") echo "value='" . $penilaianLR[2] . "'" ?> />
         </td
        </tr>
        <tr class="luarRuang_romawi2a subPenilaianLuarRuang rowIklan" hidden>
         <td></td>
         <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="LUARRUANG[4]" value="LR_GT5" class="uraianPenilaian subPenilaianLuarRuangGT" <?php if ($penLR[3][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT luarRuang_romawi2aVal subPenilaianLuarRuang subPenilaianLuarRuangGTVal" name="LUARRUANG[4]" style="display: none" <?php if (trim($penilaianLR[3]) != "") echo "value='" . $penilaianLR[3] . "'" ?> />
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Gambar jelas dan mencolok sesuai dengan ketentuan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_cromawi2A1" name="LUARRUANG[5]" value="+_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penLR[4][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_cromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_cromawi2A2" name="LUARRUANG[5]" value="-_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penLR[4][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_cromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[5]" style="display: none" value="<?php echo $penilaianLR[4]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Luas Peringatan Kesehatan : minimal 15% dari total luas iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "luarRuang_romawi2d" type="radio" id="luarRuang_dromawi2A1" name="LUARRUANG[6]" value="-_Luas Peringatan Kesehatan : minimal 15% dari total luas iklan" <?php if ($penLR[5][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_dromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "luarRuang_romawi2d" type="radio" id="luarRuang_dromawi2A2" name="LUARRUANG[6]" value="+_Luas Peringatan Kesehatan : minimal 15% dari total luas iklan" <?php if ($penLR[5][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_dromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[6]" style="display: none" value="<?php echo $penilaianLR[5]; ?>">
         </td>
        </tr>
        <tr class="luarRuang_romawi2d subPenilaianLuarRuang" hidden>
         <td></td>
         <td>Jika tidak 15%, tuliskan luas peringatan kesehatan: </td>
         <td></td>
         <td class="td_left">
          <input type="text" class="luarRuang_romawi2Val subPenilaianLuarRuang luarRuang_romawi2d" size="9" name="LUARRUANG[7]"  id="LUARRUANG[6]"   value="<?php echo $penilaianLR[6]; ?>">&nbsp;&nbsp;&nbsp;
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_eromawi2A1" name="LUARRUANG[8]" value='+_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan' <?php if ($penLR[7][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_eromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_eromawi2A2" name="LUARRUANG[8]" value='-_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan' <?php if ($penLR[7][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_eromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[8]" style="display: none"  value="<?php echo $penilaianLR[7]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_fromawi2A1" name="LUARRUANG[9]" value='+_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penLR[8][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_fromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_fromawi2A2" name="LUARRUANG[9]" value='-_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penLR[8][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_fromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[9]" style="display: none" value="<?php echo $penilaianLR[8]; ?>">
         </td>
        </tr>
        <!--Romawi 3-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN MATERI IKLAN  SELAIN PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan penandaan/tulisan 18+ dalam iklan rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_aromawi3A1" name="LUARRUANG[10]" value="+_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penLR[9][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_aromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_aromawi3A2" name="LUARRUANG[10]" value="-_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penLR[9][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_aromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[10]" style="display: none" value="<?php echo $penilaianLR[9]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_bromawi3A1" name="LUARRUANG[11]" value="+_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penLR[10][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_bromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_bromawi3A2" name="LUARRUANG[11]" value="-_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penLR[10][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_bromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[11]" style="display: none" value="<?php echo $penilaianLR[10]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Tidak mencantumkan nama produk yang bersangkutan adalah rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_cromawi3A1" name="LUARRUANG[12]" value="+_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penLR[11][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_cromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_cromawi3A2" name="LUARRUANG[12]" value="-_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penLR[11][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_cromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[12]" style="display: none" value="<?php echo $penilaianLR[11]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_dromawi3A1" name="LUARRUANG[13]" value="+_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penLR[12][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_dromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_dromawi3A2" name="LUARRUANG[13]" value="-_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penLR[12][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_dromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[13]" style="display: none" value="<?php echo $penilaianLR[12]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Tidak menggunakan kata atau kalimat yang menyesatkan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_eromawi3A1" name="LUARRUANG[14]" value="+_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penLR[13][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_eromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_eromawi3A2" name="LUARRUANG[14]" value="-_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penLR[13][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_eromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[14]" style="display: none" value="<?php echo $penilaianLR[13]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f.  Tidak merangsang atau menyarankan orang untuk merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_fromawi3A1" name="LUARRUANG[15]" value="+_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penLR[14][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_fromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_fromawi3A2" name="LUARRUANG[15]" value="-_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penLR[14][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_fromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[15]" style="display: none" value="<?php echo $penilaianLR[14]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">g. Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_gromawi3A1" name="LUARRUANG[16]" value="+_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penLR[15][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_gromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_gromawi3A2" name="LUARRUANG[16]" value="-_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penLR[15][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_gromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[16]" style="display: none" value="<?php echo $penilaianLR[15]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">h. Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_hromawi3A1" name="LUARRUANG[17]" value="+_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penLR[16][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_hromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_hromawi3A2" name="LUARRUANG[17]" value="-_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penLR[16][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_hromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[17]" style="display: none" value="<?php echo $penilaianLR[16]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">i.  Tidak menggunakan tokoh kartun sebagai model iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_iromawi3A1" name="LUARRUANG[18]" value="+_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penLR[17][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_iromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_iromawi3A2" name="LUARRUANG[18]" value="-_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penLR[17][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_iromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[18]" style="display: none" value="<?php echo $penilaianLR[17]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">j.  Tidak bertentangan dengan norma yang berlaku dalam masyarakat</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_jromawi3A1" name="LUARRUANG[19]" value="+_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penLR[18][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_jromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_jromawi3A2" name="LUARRUANG[19]" value="-_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penLR[18][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_jromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[19]" style="display: none" value="<?php echo $penilaianLR[18]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">k. Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_kromawi3A1" name="LUARRUANG[20]" value="+_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penLR[19][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_kromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_kromawi3A2" name="LUARRUANG[20]" value="-_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penLR[19][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_kromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[20]" style="display: none" value="<?php echo $penilaianLR[19]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">l. Diletakkan di Kawasan Tanpa Rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_lromawi3A1" name="LUARRUANG[21]" value="+_Diletakkan di Kawasan Tanpa Rokok" <?php if ($penLR[20][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_lromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_lromawi3A2" name="LUARRUANG[21]" value="-_Diletakkan di Kawasan Tanpa Rokok" <?php if ($penLR[20][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_lromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[21]" style="display: none" value="<?php echo $penilaianLR[20]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">m. Diletakkan di jalan utama atau protokol</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_mromawi3A1" name="LUARRUANG[22]" value="+_Diletakkan di jalan utama atau protokol" <?php if ($penLR[21][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_mromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_mromawi3A2" name="LUARRUANG[22]" value="-_Diletakkan di jalan utama atau protokol" <?php if ($penLR[21][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_mromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[22]" style="display: none" value="<?php echo $penilaianLR[21]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">n. Peletakan iklan dengan memotong jalan atau melintang</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_nromawi3A1" name="LUARRUANG[23]" value="+_Peletakan iklan dengan memotong jalan atau melintang" <?php if ($penLR[22][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_nromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_nromawi3A2" name="LUARRUANG[23]" value="-_Peletakan iklan dengan memotong jalan atau melintang" <?php if ($penLR[22][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_nromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[23]" style="display: none" value="<?php echo $penilaianLR[22]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">o. Melebihi ukuran 72 m2 (tujuh puluh dua meter persegi)</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="luarRuang_oromawi3A1" name="LUARRUANG[24]" value="+_Melebihi ukuran 72 m2 (tujuh puluh dua meter persegi)" <?php if ($penLR[23][0] == "+") echo "checked"; ?>>
          <label for="luarRuang_oromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="luarRuang_oromawi3A2" name="LUARRUANG[24]" value="-_Melebihi ukuran 72 m2 (tujuh puluh dua meter persegi)" <?php if ($penLR[23][0] == "-") echo "checked"; ?>>
          <label for="luarRuang_oromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianLuarRuang" name="LUARRUANG[24]" style="display: none" value="<?php echo $penilaianLR[23]; ?>">
         </td>
        </tr>
        <!--Romawi 4-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>HASIL PENGAWASAN</b></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan  Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="LUARRUANG[25]" class="penilaianLuarRuang" title="Pengawasan  Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianLR[24] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianLR[24] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="LUARRUANG[26]" class="penilaianLuarRuang" title="Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianLR[25] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianLR[25] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <!--Romawi 5-->
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist"><b>KESIMPULAN</b></td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="LUARRUANG[27]" class="penilaianLuarRuang" title="Kesimpulan"><option value=""></option><option value="MK" <?php if ($penilaianLR[26] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianLR[26] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
       </table>
      </div>
      <!--TV-->
      <div class="accCntnt"  id="penilaianTV" hidden>
       <table class="form_tabel">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;"></td>
         <td style="background-color: white;"></td>
         <td style="background-color: white;" class="td_left">
          <input type="radio" id="r1" disabled="true">
          <label for="r1" style="width: 54px; height: 10px;">Ya</label>
          <span style="margin-left: 5px;"></span>
          <input type="radio" id="r2" disabled="true">
          <label for="r2" style="width: 54px; height: 10px;">Tidak</label>
         </td>
        </tr>
        <!--Romawi 2-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "tv_romawi2a" type="radio" id="tv_aromawi2A1" name="TV[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTV[0][0] == "+") echo "checked"; ?>>
          <label for="tv_aromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "tv_romawi2a" type="radio" id="tv_aromawi2A2" name="TV[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTV[0][0] == "-") echo "checked"; ?>>
          <label for="tv_aromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[1]" style="display: none">
         </td>
        </tr>
        <tr class="tv_romawi2a" hidden>
         <td></td>
         <td><b>Jenis Gambar dan tulisan</b></td>
         <td>&nbsp;</td>
        </tr>
        <tr class="tv_romawi2a subPenilaianTV rowIklan" hidden>
         <td></td>
         <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TV[2]" value="TV_GT1" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[1][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT tv_romawi2aVal subPenilaianTV subPenilaianTVGTVal" name="TV[2]" style="display: none" value="<?php echo $penilaianTV[1]; ?>">
         </td>
        </tr>
        <tr class="tv_romawi2a subPenilaianTV rowIklan" hidden>
         <td></td>
         <td> Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TV[3]" value="TV_GT3" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[2][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT tv_romawi2aVal subPenilaianTV subPenilaianTVGTVal" name="TV[3]" style="display: none" value="<?php echo $penilaianTV[2]; ?>">
         </td>
        </tr>
        <tr class="tv_romawi2a subPenilaianTV rowIklan" hidden>
         <td></td>
         <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TV[4]" value="TV_GT5" class="uraianPenilaian subPenilaianTVGT" <?php if ($penTV[3][0] != "") echo "checked"; ?> />
          <input type="text" class="infoT tv_romawi2aVal subPenilaianTV subPenilaianTVGTVal" name="TV[4]" style="display: none" value="<?php echo $penilaianTV[3]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Gambar jelas dan mencolok sesuai dengan ketentuan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_cromawi2A1" name="TV[5]" value="+_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penTV[4][0] == "+") echo "checked"; ?>>
          <label for="tv_cromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_cromawi2A2" name="TV[5]" value="-_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penTV[4][0] == "-") echo "checked"; ?>>
          <label for="tv_cromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[5]" style="display: none" value="<?php echo $penilaianTV[4]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "tv_romawi2d" type="radio" id="tv_dromawi2A1" name="TV[6]" value="-_Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan" <?php if ($penTV[5][0] == "+") echo "checked"; ?>>
          <label for="tv_dromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "tv_romawi2d" type="radio" id="tv_dromawi2A2" name="TV[6]" value="+_Durasi Peringatan Kesehatan : minimal 10% dari total durasi iklan" <?php if ($penTV[5][0] == "-") echo "checked"; ?>>
          <label for="tv_dromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[6]" style="display: none" value="<?php echo $penilaianTV[5]; ?>">
         </td>
        </tr>
        <tr class="tv_romawi2d subPenilaianTV" hidden>
         <td></td>
         <td>Jika Tidak 10%, tuliskan durasi peringatan kesehatan: </td>
         <td></td>
         <td class="td_left">
          <input type="text" class="tv_romawi2Val subPenilaianTV tv_romawi2d" size="9" name="TV[7]"  id="TV[6]"  value="<?php echo $penilaianTV[5]; ?>">&nbsp;&nbsp;&nbsp;Detik
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_daromawi2A1" name="TV[8]" value='+_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan' <?php if ($penTV[7][0] == "+") echo "checked"; ?>>
          <label for="tv_daromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_daromawi2A2" name="TV[8]" value='-_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam dengan ukuran huruf 10 (sepuluh) atau proporsional dengan kemasan' <?php if ($penTV[7][0] == "-") echo "checked"; ?>>
          <label for="tv_daromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[8]" style="display: none" value="<?php echo $penilaianTV[7]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_dbromawi2A1" name="TV[9]" value='+_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penTV[8][0] == "+") echo "checked"; ?>>
          <label for="tv_dbromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_dbromawi2A2" name="TV[9]" value='-_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penTV[8][0] == "-") echo "checked"; ?>>
          <label for="tv_dbromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[9]" style="display: none" value="<?php echo $penilaianTV[8]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f. Fullscreen 1 gambar untuk setiap 1 spot iklan di akhir tayangan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_dcromawi2A1" name="TV[10]" value='+_Fullscreen 1 gambar untuk setiap 1 spot iklan di akhir tayangan' <?php if ($penTV[9][0] == "+") echo "checked"; ?>>
          <label for="tv_dcromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_dcromawi2A2" name="TV[10]" value='-_Fullscreen 1 gambar untuk setiap 1 spot iklan di akhir tayangan' <?php if ($penTV[9][0] == "-") echo "checked"; ?>>
          <label for="tv_dcromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[10]" style="display: none" value="<?php echo $penilaianTV[9]; ?>">
         </td>
        </tr>
        <!--Romawi 3-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN MATERI IKLAN  SELAIN PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan penandaan/tulisan 18+ dalam iklan rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_aromawi3A1" name="TV[11]" value="+_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penTV[10][0] == "+") echo "checked"; ?>>
          <label for="tv_aromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_aromawi3A2" name="TV[11]" value="-_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penTV[10][0] == "-") echo "checked"; ?>>
          <label for="tv_aromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[11]" style="display: none" value="<?php echo $penilaianTV[10]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_bromawi3A1" name="TV[12]" value="+_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penTV[11][0] == "+") echo "checked"; ?>>
          <label for="tv_bromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_bromawi3A2" name="TV[12]" value="-_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penTV[11][0] == "-") echo "checked"; ?>>
          <label for="tv_bromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[12]" style="display: none" value="<?php echo $penilaianTV[11]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Tidak mencantumkan nama produk yang bersangkutan adalah rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_cromawi3A1" name="TV[13]" value="+_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penTV[12][0] == "+") echo "checked"; ?>>
          <label for="tv_cromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_cromawi3A2" name="TV[13]" value="-_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penTV[12][0] == "-") echo "checked"; ?>>
          <label for="tv_cromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[13]" style="display: none" value="<?php echo $penilaianTV[12]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_dromawi3A1" name="TV[14]" value="+_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penTV[13][0] == "+") echo "checked"; ?>>
          <label for="tv_dromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_dromawi3A2" name="TV[14]" value="-_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penTV[13][0] == "-") echo "checked"; ?>>
          <label for="tv_dromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[14]" style="display: none" value="<?php echo $penilaianTV[13]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Tidak menggunakan kata atau kalimat yang menyesatkan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_eromawi3A1" name="TV[15]" value="+_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penTV[14][0] == "+") echo "checked"; ?>>
          <label for="tv_eromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_eromawi3A2" name="TV[15]" value="-_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penTV[14][0] == "-") echo "checked"; ?>>
          <label for="tv_eromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[15]" style="display: none" value="<?php echo $penilaianTV[14]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f.  Tidak merangsang atau menyarankan orang untuk merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_fromawi3A1" name="TV[16]" value="+_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penTV[15][0] == "+") echo "checked"; ?>>
          <label for="tv_fromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_fromawi3A2" name="TV[16]" value="-_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penTV[15][0] == "-") echo "checked"; ?>>
          <label for="tv_fromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[16]" style="display: none" value="<?php echo $penilaianTV[15]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">g. Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_gromawi3A1" name="TV[17]" value="+_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penTV[16][0] == "+") echo "checked"; ?>>
          <label for="tv_gromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_gromawi3A2" name="TV[17]" value="-_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penTV[16][0] == "-") echo "checked"; ?>>
          <label for="tv_gromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[17]" style="display: none" value="<?php echo $penilaianTV[16]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">h. Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_hromawi3A1" name="TV[18]" value="+_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penTV[17][0] == "+") echo "checked"; ?>>
          <label for="tv_hromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_hromawi3A2" name="TV[18]" value="-_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penTV[17][0] == "-") echo "checked"; ?>>
          <label for="tv_hromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[18]" style="display: none" value="<?php echo $penilaianTV[17]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">i.  Tidak menggunakan tokoh kartun sebagai model iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_iromawi3A1" name="TV[19]" value="+_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penTV[18][0] == "+") echo "checked"; ?>>
          <label for="tv_iromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_iromawi3A2" name="TV[19]" value="-_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penTV[18][0] == "-") echo "checked"; ?>>
          <label for="tv_iromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[19]" style="display: none" value="<?php echo $penilaianTV[18]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">j.  Tidak bertentangan dengan norma yang berlaku dalam masyarakat</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_jromawi3A1" name="TV[20]" value="+_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penTV[19][0] == "+") echo "checked"; ?>>
          <label for="tv_jromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_jromawi3A2" name="TV[20]" value="-_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penTV[19][0] == "-") echo "checked"; ?>>
          <label for="tv_jromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[20]" style="display: none" value="<?php echo $penilaianTV[19]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">k. Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="tv_kromawi3A1" name="TV[21]" value="+_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penTV[20][0] == "+") echo "checked"; ?>>
          <label for="tv_kromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="tv_kromawi3A2" name="TV[21]" value="-_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penTV[20][0] == "-") echo "checked"; ?>>
          <label for="tv_kromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTV" name="TV[21]" style="display: none" value="<?php echo $penilaianTV[20]; ?>">
         </td>
        </tr>
        <!--Romawi 4-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>HASIL PENGAWASAN</b></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan  Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="TV[22]" class="penilaianTV" title="Pengawasan  Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianTV[21] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianTV[21] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="TV[23]" class="penilaianTV" title="Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianTV[22] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianTV[22] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <!--Romawi 5-->
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist"><b>KESIMPULAN</b></td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="TV[24]" class="penilaianTV" title="Kesimpulan"><option value=""></option><option value="MK" <?php if ($penilaianTV[23] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianTV[23] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
       </table>
      </div>
      <!--TI-->
      <div class="accCntnt"  id="penilaianTI" hidden>
       <table class="form_tabel">
        <tr>
         <td style="width: 2%;"></td>
         <td style="width: 50%;"></td>
         <td style="width: 13%;"></td>
         <td style="width: 35%; font-size: 14px; padding-left: 250px; padding-right: 250px; padding-bottom: 5px; padding-top: 5px;"></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;"></td>
         <td style="background-color: white;"></td>
         <td style="background-color: white;" class="td_left">
          <input type="radio" id="r1" disabled="true">
          <label for="r1" style="width: 54px; height: 10px;">Ya</label>
          <span style="margin-left: 5px;"></span>
          <input type="radio" id="r2" disabled="true">
          <label for="r2" style="width: 54px; height: 10px;">Tidak</label>
         </td>
        </tr>
        <!--Romawi 2-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN  PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" param = "ti_romawi2a" type="radio" id="ti_aromawi2A1" name="TI[1]" value="+_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTI[0][0] == "+") echo "checked"; ?>>
          <label for="ti_aromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" param = "ti_romawi2a" type="radio" id="ti_aromawi2A2" name="TI[1]" value="-_Mencantumkan peringatan kesehatan berbentuk gambar dan tulisan" <?php if ($penTI[0][0] == "-") echo "checked"; ?>>
          <label for="ti_aromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[1]" style="display: none" value="<?php echo $penilaianTI[0]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2a subPenilaianTI" hidden>
         <td></td>
         <td><b>Jenis Gambar dan tulisan</b></td>
         <td>&nbsp;</td>
        </tr>
        <tr class="ti_romawi2a subPenilaianTI rowIklan" hidden>
         <td></td>
         <td style="vertical-align: top">Gambar 1 : Gambar kanker mulut <br />Tulisan 1 : Merokok sebabkan kanker mulut</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TI[ROMAWI2][2]" value="TI_GT1" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[1][0] != "") echo "checked"; ?>/>
          <input type="text" class="infoT ti_romawi2aVal subPenilaianTI subPenilaianTIGTVal" name="TI[2]" style="display: none" value="<?php echo $penilaianTI[1]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2a subPenilaianTI rowIklan" hidden>
         <td></td>
         <td>Gambar 2 : Gambar orang merokok dengan asap yang membentuk tengkorak <br />Tulisan 2 : Merokok Membunuhmu</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TI[ROMAWI2][3]" value="TI_GT2" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[2][0] != "") echo "checked"; ?>/>
          <input type="text" class="infoT ti_romawi2aVal subPenilaianTI subPenilaianTIGTVal" name="TI[3]" style="display: none" value="<?php echo $penilaianTI[2]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2a subPenilaianTI rowIklan" hidden>
         <td></td>
         <td>Gambar 3 : Gambar kanker tenggorokan <br />Tulisan 3 : Merokok Sebabkan Kanker Tenggorokan</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TI[ROMAWI2][4]" value="TI_GT3" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[3][0] != "") echo "checked"; ?>/>
          <input type="text" class="infoT ti_romawi2aVal subPenilaianTI subPenilaianTIGTVal" name="TI[4]" style="display: none" value="<?php echo $penilaianTI[3]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2a subPenilaianTI rowIklan" hidden>
         <td></td>
         <td>Gambar 4 : Gambar orang merokok dengan anak didekatnya<br />Tulisan 4 : Merokok Dekat Anak Berbahaya Bagi Mereka</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TI[ROMAWI2][5]" value="TI_GT4" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[4][0] != "") echo "checked"; ?>/>
          <input type="text" class="infoT ti_romawi2aVal subPenilaianTI subPenilaianTIGTVal" name="TI[5]" style="display: none" value="<?php echo $penilaianTI[4]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2a subPenilaianTI rowIklan" hidden>
         <td></td>
         <td>Gambar 5 : Gambar paru-paru yang menghitam karena kanker <br />Tulisan 5 : Merokok Sebabkan Kanker Paru-paru dan Bronkitis Kronis</td>
         <td></td>
         <td class="td_left">
          <input type="checkbox" name="TI[ROMAWI2][6]" value="TI_GT5" class="uraianPenilaian subPenilaianTIGT" <?php if ($penTI[5][0] != "") echo "checked"; ?>/>
          <input type="text" class="infoT ti_romawi2aVal subPenilaianTI subPenilaianTIGT subPenilaianTIGTVal" name="TI[6]" style="display: none" value="<?php echo $penilaianTI[5]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Gambar jelas dan mencolok sesuai dengan ketentuan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_cromawi2A1" name="TI[7]" value="+_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penTI[6][0] == "+") echo "checked"; ?>>
          <label for="ti_cromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_cromawi2A2" name="TI[7]" value="-_Gambar jelas dan mencolok sesuai dengan ketentuan" <?php if ($penTI[6][0] == "-") echo "checked"; ?>>
          <label for="ti_cromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[7]" style="display: none" value="<?php echo $penilaianTI[6]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Proporsi Peringatan Kesehatan : </td>
         <td></td>
         <td style="width: 10%;" class="td_left"><select class="penilaianTI stext" style="width: 160px;" title="Jenis Gambar" name="TI[8]" onChange = "statisGerak(this);"><option value=""></option><option value="Statis" <?php if ($penilaianTI[7] == "Statis") echo "selected"; ?>>Gambar Statis</option><option value="Gerak" <?php if ($penilaianTV[7] == "Gerak") echo "selected"; ?>>Gambar Gerak</option></select>
         </td>
        </tr>
        <tr class="X rowStatis subPenilaianTI rowIklan" hidden>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Untuk  iklan berupa gambar statis/diam : 15% dari total luas iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian XCHK" param="ti_romawi2dStatis" type="radio" id="ti_cromawi2A1Statis" name="TI[9]" value="-_Untuk  iklan berupa gambar statis/diam : 15% dari total luas iklan" <?php if ($penTI[8][0] == "+") echo "checked"; ?>>
          <label for="ti_cromawi2A1Statis" param="ti_romawi2dStatis" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian XCHK" param="ti_romawi2dStatis" type="radio" id="ti_cromawi2A2Statis" name="TI[9]" value="+_Untuk  iklan berupa gambar statis/diam : 15% dari total luas iklan" <?php if ($penTI[8][0] == "+") echo "checked"; ?>>
          <label for="ti_cromawi2A2Statis" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTIStatis X subPenilaianTI" name="TI[9]" style="display: none" value="<?php echo $penilaianTI[8]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2dStatis X subPenilaianTI" hidden>
         <td></td>
         <td>Jika tidak 15%, tuliskan luas peringatan kesehatan: </td>
         <td></td>
         <td class="td_left">
          <input type="text" class="ti_romawi2Val X subPenilaianTI ti_romawi2dStatis" size="9" name="TI[10]"  id="TI[9]"  value="<?php echo $penilaianTI[9]; ?>">&nbsp;&nbsp;&nbsp;%
         </td>
        </tr>
        <tr class="X rowGerak subPenilaianTI rowIklan" hidden>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Untuk iklan berupa gambar bergerak/tayangan: minimal 10% dari total durasi iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian XCHK" param="ti_romawi2dGerak" type="radio" id="ti_cromawi2A1Gerak" name="TI[11]" value="-_Untuk iklan berupa gambar bergerak/tayangan: minimal 10% dari total durasi iklan" <?php if ($penTI[10][0] == "+") echo "checked"; ?>>
          <label for="ti_cromawi2A1Gerak" param="ti_romawi2dGerak" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian XCHK" param="ti_romawi2dGerak" type="radio" id="ti_cromawi2A2Gerak" name="TI[11]" value="+_Untuk iklan berupa gambar bergerak/tayangan: minimal 10% dari total durasi iklan" <?php if ($penTI[10][0] == "-") echo "checked"; ?>>
          <label for="ti_cromawi2A2Gerak" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTIGerak X subPenilaianTI" name="TI[11]" style="display: none" value="<?php echo $penilaianTI[10]; ?>">
         </td>
        </tr>
        <tr class="ti_romawi2dGerak X subPenilaianTI" hidden>
         <td></td>
         <td>Jika Tidak 10%, tuliskan durasi peringatan kesehatan: </td>
         <td></td>
         <td class="td_left">
          <input type="text" class="ti_romawi2Val X subPenilaianTI ti_romawi2dGerak" size="9" name="TI[12]"  id="TI[11]"  value="<?php echo $penilaianTI[11]; ?>">&nbsp;&nbsp;&nbsp;Detik
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_eromawi2A1" name="TI[13]" value='+_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam' <?php if ($penTI[12][0] == "+") echo "checked"; ?>>
          <label for="ti_eromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_eromawi2A2" name="TI[13]" value='-_Pada bagian atas gambar terdapat tulisan “PERINGATAN” dengan menggunakan jenis huruf arial bold berwarna putih dengan dasar hitam' <?php if ($penTI[12][0] == "-") echo "checked"; ?>>
          <label for="ti_eromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[13]" style="display: none" value="<?php echo $penilaianTI[12]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e.  Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_fromawi2A1" name="TI[14]" value='+_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penTI[13][0] == "+") echo "checked"; ?>>
          <label for="ti_fromawi2A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_fromawi2A2" name="TI[14]" value='-_Di bagian bawah gambar dicantumkan tulisan berwarna putih dengan dasar hitam sesuai dengan makna gambar, dicetak dengan jelas dan mencolok' <?php if ($penTI[13][0] == "-") echo "checked"; ?>>
          <label for="ti_fromawi2A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[14]" style="display: none" value="<?php echo $penilaianTI[13]; ?>">
         </td>
        </tr>
        <!--Romawi 3-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>PENGAWASAN MATERI IKLAN  SELAIN PENCANTUMAN PERINGATAN KESEHATAN BERGAMBAR</b></td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">a. Mencamtumkan penandaan/tulisan 18+ dalam iklan rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_aromawi3A1" name="TI[15]" value="+_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penTI[14][0] == "+") echo "checked"; ?>>
          <label for="ti_aromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_aromawi3A2" name="TI[15]" value="-_Menyiarkan penandaan/tulisan 18+ dalam iklan rokok" <?php if ($penTI[14][0] == "-") echo "checked"; ?>>
          <label for="ti_aromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[15]" style="display: none" value="<?php echo $penilaianTI[14]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">b. Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_bromawi3A1" name="TI[16]" value="+_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penTI[15][0] == "+") echo "checked"; ?>>
          <label for="ti_bromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_bromawi3A2" name="TI[16]" value="-_Tidak memperagakan, menggunakan, dan/atau menampilkan wujud atau bentuk rokok atau sebutan lain yang dapat diasosiasikan dengan merek rokok" <?php if ($penTI[15][0] == "-") echo "checked"; ?>>
          <label for="ti_bromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[16]" style="display: none" value="<?php echo $penilaianTI[15]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">c. Tidak mencantumkan nama produk yang bersangkutan adalah rokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_cromawi3A1" name="TI[17]" value="+_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penTI[16][0] == "+") echo "checked"; ?>>
          <label for="ti_cromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_cromawi3A2" name="TI[17]" value="-_Tidak mencantumkan nama produk yang bersangkutan adalah rokok" <?php if ($penTI[16][0] == "-") echo "checked"; ?>>
          <label for="ti_cromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[17]" style="display: none" value="<?php echo $penilaianTI[16]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">d. Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_dromawi3A1" name="TI[18]" value="+_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penTI[17][0] == "+") echo "checked"; ?>>
          <label for="ti_dromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_dromawi3A2" name="TI[18]" value="-_Tidak menggambarkan atau menyarankan bahwa merokok memberikan manfaat bagi kesehatan" <?php if ($penTI[17][0] == "-") echo "checked"; ?>>
          <label for="ti_dromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[18]" style="display: none" value="<?php echo $penilaianTI[17]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">e. Tidak menggunakan kata atau kalimat yang menyesatkan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_eromawi3A1" name="TI[19]" value="+_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penTI[18][0] == "+") echo "checked"; ?>>
          <label for="ti_eromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_eromawi3A2" name="TI[19]" value="-_Tidak menggunakan kata atau kalimat yang menyesatkan" <?php if ($penTI[18][0] == "-") echo "checked"; ?>>
          <label for="ti_eromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[19]" style="display: none" value="<?php echo $penilaianTI[18]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">f.  Tidak merangsang atau menyarankan orang untuk merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_fromawi3A1" name="TI[20]" value="+_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penTI[19][0] == "+") echo "checked"; ?>>
          <label for="ti_fromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_fromawi3A2" name="TI[20]" value="-_Tidak merangsang atau menyarankan orang untuk merokok" <?php if ($penTI[19][0] == "-") echo "checked"; ?>>
          <label for="ti_fromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[20]" style="display: none" value="<?php echo $penilaianTI[19]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">g. Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_gromawi3A1" name="TI[21]" value="+_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penTI[20][0] == "+") echo "checked"; ?>>
          <label for="ti_gromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_gromawi3A2" name="TI[21]" value="-_Tidak menampilkan anak, remaja, dan/atau wanita hamil dalam bentuk gambar dan/atau tulisan" <?php if ($penTI[20][0] == "-") echo "checked"; ?>>
          <label for="ti_gromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[21]" style="display: none" value="<?php echo $penilaianTI[20]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">h. Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_hromawi3A1" name="TI[22]" value="+_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penTI[21][0] == "+") echo "checked"; ?>>
          <label for="ti_hromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_hromawi3A2" name="TI[22]" value="-_Tidak ditujukan terhadap anak, remaja, dan/atau wanita hamil" <?php if ($penTI[21][0] == "-") echo "checked"; ?>>
          <label for="ti_hromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[22]" style="display: none" value="<?php echo $penilaianTI[21]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">i.  Tidak menggunakan tokoh kartun sebagai model iklan</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_iromawi3A1" name="TI[23]" value="+_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penTI[22][0] == "+") echo "checked"; ?>>
          <label for="ti_iromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_iromawi3A2" name="TI[23]" value="-_Tidak menggunakan tokoh kartun sebagai model iklan" <?php if ($penTI[22][0] == "-") echo "checked"; ?>>
          <label for="ti_iromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[23]" style="display: none" value="<?php echo $penilaianTI[22]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">j.  Tidak bertentangan dengan norma yang berlaku dalam masyarakat</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_jromawi3A1" name="TI[24]" value="+_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penTI[23][0] == "+") echo "checked"; ?>>
          <label for="ti_jromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_jromawi3A2" name="TI[24]" value="-_Tidak bertentangan dengan norma yang berlaku dalam masyarakat" <?php if ($penTI[23][0] == "-") echo "checked"; ?>>
          <label for="ti_jromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[24]" style="display: none" value="<?php echo $penilaianTI[23]; ?>">
         </td>
        </tr>
        <tr class="rowIklan">
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">k. Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <input class="uraianPenilaian" type="radio" id="ti_kromawi3A1" name="TI[25]" value="+_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penTI[24][0] == "+") echo "checked"; ?>>
          <label for="ti_kromawi3A1" style="width: 54px; height: 10px;" title="Ya"></label>
          <span style="margin-left: 5px;"></span>
          <input class="uraianPenilaian" type="radio" id="ti_kromawi3A2" name="TI[25]" value="-_Menyiarkan dalam bentuk gambar atau foto, menampakkan orang sedang merokok, memperlihatkan batang rokok, asap rokok, bungkus rokok atau yang berhubungan dengan rokok serta segala bentuk informasi rokok yang berhubungan dengan kegiatan komersial/iklan atau membuat orang ingin merokok" <?php if ($penTI[24][0] == "-") echo "checked"; ?>>
          <label for="ti_kromawi3A2" style="width: 54px; height: 10px; background-color: #9d0101" title="Tidak"></label>
          <input type="text" class="infoT penilaianTI" name="TI[25]" style="display: none" value="<?php echo $penilaianTI[24]; ?>">
         </td>
        </tr>
        <!--Romawi 4-->
        <tr>
         <td class="td_left_checklist" style="background-color: white;"></td>
         <td class="td_left_header_checklist" style="background-color: white;" colspan="3"><b>HASIL PENGAWASAN</b></td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan  Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="TI[26]" class="penilaianTI stext" title="Pengawasan  Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianTV[25] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianTV[25] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <tr>
         <td class="td_left_checklist" style="vertical-align: top"></td>
         <td class="td_left_header_checklist" style="vertical-align: top">-  Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar</td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="TI[27]" class="penilaianTI stext" title="Pengawasan Materi Iklan  Selain Pencantuman Peringatan Kesehatan Bergambar"><option value=""></option><option value="MK" <?php if ($penilaianTV[26] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianTV[26] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
        <!--Romawi 5-->
        <tr>
         <td class="td_left_checklist"></td>
         <td class="td_left_header_checklist"><b>KESIMPULAN</b></td>
         <td></td>
         <td style="width: 10%;" class="td_left">
          <select name="TI[28]" class="penilaianTI stext" title="Kesimpulan"><option value=""></option><option value="MK" <?php if ($penilaianTV[27] == "MK") echo "selected"; ?>>Memenuhi Ketentuan</option><option value="TMK" <?php if ($penilaianTV[27] == "TMK") echo "selected"; ?>>Tidak Memenuhi Ketentuan</option></select>
         </td>
        </tr>
       </table>
      </div>
     </div>
     <div style="height:5px;" id="expand6b"></div>

     <!--8-->
     <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAMPIRAN</a></div>
     <div class="collapse">
      <div class="accCntnt">
       <table class="form_tabel_detail">
        <tr>
         <td class="td_left_checklist" colspan="5" style="margin-right: 200px">
          <?php
          if (array_key_exists('FILE_IKLAN', $sess) && trim($sess['FILE_IKLAN']) != "") {
           ?><input type="hidden" name="IKLAN_NAPZA[FILE_IKLAN]" value="<?php echo $sess['FILE_IKLAN']; ?>">
           <span id="file_FILE_IKLAN"><a href="<?php echo base_url(); ?>files/<?php echo 'iklan_007'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload_s/<?php echo 'iklan_007'; ?>/<?php echo $sess['FILE_IKLAN']; ?>" jns="FILE_IKLAN">Edit atau Hapus File ?</a></span>
           <span class="upload_FILE_IKLAN" hidden><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_007'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran Berita Acara" />
            &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx</span><span class="file_FILE_IKLAN"></span>
           <?php
          } else {
           ?>
           <span class="upload_FILE_IKLAN"><input type="file" class="upload" jenis="FILE_IKLAN" allowed="jpg-jpeg-pdf-doc-docx" url="<?php echo site_url(); ?>/utility/uploads/get_upload_s/<?php echo 'iklan_007'; ?>" id="fileToUpload_FILE_IKLAN" name="userfile" onchange="do_upload($(this));
            return false;" title="Lampiran Berita Acara" />
            &nbsp;Tipe File : *.jpg .jpeg .pdf .doc .docx</span><span class="file_FILE_IKLAN"></span>
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

    <div style="padding:10px;"></div><div><a href="javascript:void(0)" id="btnSave" class="button <?php echo $icon; ?>" onclick="fpost('#fpengawasanIklan_007', '', '');">
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
 </form>
</div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" />
<script type="text/javascript">
          function goBack()
          {
           window.history.back()
          }
          function mediaIklan2(X) {
           $("#pChoosed").val('');
           $("#lrChoosed").val('');
           $("#lnChoosed").val('');
           $("#cChoosed").val('');
           clear();
           showHide();
           cekLampiran();
           jenisPenilaian($(X));
          }
          function jenisPenilaian(X) {
           var iklanMedia = $("#iklan_media").val();
           if (iklanMedia != "")
            $("#medianyaKosong").hide();
           else
            $("#medianyaKosong").show();
           $(".subPenilaianCetak").attr("rel", "");
           $(".subPenilaianLuarRuang").attr("rel", "");
           $(".subPenilaianRadio").attr("rel", "");
           $(".subPenilaianTV").attr("rel", "");
           $(".subPenilaianTI").attr("rel", "");
           if ($(X).val() == "Radio") {
            $("#penilaianCetak").hide();
            $(".penilaianCetak").attr("rel", "");
            $("#penilaianLuarRuang").hide();
            $(".penilaianLuarRuang").attr("rel", "");
            $("#penilaianRadio").show();
            $(".penilaianRadio").attr("rel", "required");
            $("#penilaianTV").hide();
            $(".penilaianTV").attr("rel", "");
            $("#penilaianTI").hide();
            $(".penilaianTI").attr("rel", "");
           }
           else if ($(X).val() == "Cetak") {
            $("#penilaianCetak").show();
            $(".penilaianCetak").attr("rel", "required");
            $("#penilaianLuarRuang").hide();
            $(".penilaianLuarRuang").attr("rel", "");
            $("#penilaianRadio").hide();
            $(".penilaianRadio").attr("rel", "");
            $("#penilaianTV").hide();
            $(".penilaianTV").attr("rel", "");
            $("#penilaianTI").hide();
            $(".penilaianTI").attr("rel", "");
           }
           else if ($(X).val() == "Luar Ruang") {
            $("#penilaianCetak").hide();
            $(".penilaianCetak").attr("rel", "");
            $("#penilaianLuarRuang").show();
            $(".penilaianLuarRuang").attr("rel", "required");
            $("#penilaianRadio").hide();
            $(".penilaianRadio").attr("rel", "");
            $("#penilaianTV").hide();
            $(".penilaianTV").attr("rel", "");
            $("#penilaianTI").hide();
            $(".penilaianTI").attr("rel", "");
           }
           else if ($(X).val() == "TV") {
            $("#penilaianCetak").hide();
            $(".penilaianCetak").attr("rel", "");
            $("#penilaianLuarRuang").hide();
            $(".penilaianLuarRuang").attr("rel", "");
            $("#penilaianRadio").hide();
            $(".penilaianRadio").attr("rel", "");
            $("#penilaianTV").show();
            $(".penilaianTV").attr("rel", "required");
            $("#penilaianTI").hide();
            $(".penilaianTI").attr("rel", "");
           }
           else if ($(X).val() == "Media Teknologi Informasi Lainnya") {
            $("#penilaianCetak").hide();
            $(".penilaianCetak").attr("rel", "");
            $("#penilaianLuarRuang").hide();
            $(".penilaianLuarRuang").attr("rel", "");
            $("#penilaianRadio").hide();
            $(".penilaianRadio").attr("rel", "");
            $("#penilaianTV").hide();
            $(".penilaianTV").attr("rel", "");
            $("#penilaianTI").show();
            $(".penilaianTI").attr("rel", "required");
            $("#tayangTime").show("");
            $("#edisiTime").hide("");
            $(".edisiCetak").attr("rel", "");
            $(".edisiTV").attr("rel", "required");
            $("#namaMedia").show("");
            $(".namaMedia").attr("rel", "required");
            document.getElementById("namaMedia1").innerHTML = "Alamat Situs";
           }
          }
          function cekLampiran() {
           var val = $("#iklan_media").val();
           if (val == "Elektronik")
            $('.upload').attr('rel', '');
           else
            $('.upload').attr('rel', 'required');
//    var kesimpulan = $('#kesimpulanHasilPenilaian').val(), jenis = $('#iklan_media').val();
//    if ((kesimpulan === 'Tidak Memenuhi Ketentuan' && jenis === 'Cetak') || kesimpulan === 'Tidak Memenuhi Ketentuan' && jenis === 'Luar Ruang') {
//      $('.upload').attr('rel', 'required');
//    } else {
//      $('.upload').attr('rel', ' ');
//      $(".upload").css("background-color", "#FFF");
//      $(".upload").css("border", "");
//    }
          }
          function showHide2(X) {
           var param = "";
           var media1 = ["TV", "Radio", "Iklan Baris", "Bioskop", "Megatron", "Lainnya"];
           var media2 = ["Majalah", "Tabloid", "Buletin", "Halaman Kuning"];
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
//    if (param === "Megatron") {
//      $("#kabkotAlamat").attr("rel", "required");
//      $("#provkotAlamat").attr("rel", "required");
//      $(".cetakTertentu").attr("rel", "required");
//    }
//    else if ($.inArray(param, mediaifTertentu) < 0 && $.inArray(param, luarRuang) < 0 && $.inArray(param, elektronik) < 0) {
//      $("#kabkotAlamat").attr("rel", "required");
//      $("#provkotAlamat").attr("rel", "required");
//      $(".cetakTertentu").attr("rel", "required");
//    }
//    else if ($.inArray(param, luarRuang) > -1) {
//      $("#kabkotAlamat").attr("rel", "required");
//      $("#provkotAlamat").attr("rel", "required");
//      $(".cetakTertentu").attr("rel", "required");
//    } else {
//      $("#provkotAlamat").attr("rel", "");
//      $("#kabkotAlamat").attr("rel", "");
//      $(".cetakTertentu").attr("rel", "");
//      $(".cetakTertentu").css('background-color', '#FFFFFF');
//      $("#provkotAlamat").css('background-color', '#FFFFFF');
//      $("#provkotAlamat").css('border', '1px solid #dcdcdc');
//      $("#kabkotAlamat").css('background-color', '#FFFFFF');
//      $("#kabkotAlamat").css('border', '1px solid #dcdcdc');
//    }
           if (param === "Internet") {
            document.getElementById("namaMedia1").innerHTML = "Alamat Situs";
           } else {
            document.getElementById("namaMedia1").innerHTML = "Nama Media";
           }
           $("#namaMediaIklan").unautocomplete();
           $("#namaMediaIklan").autocomplete($("#namaMediaIklan").attr("url") + param, {width: 244, selectFirst: false});
           $(".ac_results").remove();
           $("#namaMediaIklan").attr("name", "IKLAN[NAMA]");
          }
          function mediaIklan(X) {
           clear();
           showHide2(X);
           jenisPenilaian($(X));
          }
          function clear() {
           $(".uraianPenilaian").attr("checked", false);
           $("#namaMedia").val("");
           $("#namaMediaIklan").val("");
           $("#idMediaIklan").val("");
           $("#idMediaIklan").attr("name", "");
           $("#tglTugas").val('');
           $(".edisiTayang").val('');
           $("#namaLokasi").val('');
           $("#alamatLokasi").val('');
           $(".penilaianRadio").val("");
           $(".penilaianCetak").val("");
           $(".penilaianTV").val("");
           $(".penilaianTI").val("");
           $(".penilaianLuarRuang").val("");
           $(".subPenilaianRadio").val("");
           $(".subPenilaianCetak").val("");
           $(".subPenilaianTV").val("");
           $(".subPenilaianTI").val("");
           $(".subPenilaianLuarRuang").val("");
           $(".subPenilaianRadio").hide();
           $(".subPenilaianCetak").hide();
           $(".subPenilaianTV").hide();
           $(".subPenilaianTI").hide();
           $(".subPenilaianLuarRuang").hide();
          }
          function showHide() {
           var jenisIklan = $("#iklan_media").val();
           var x;
           if (jenisIklan === "Cetak") {
            $(".penyiaranChoosed").hide();
            $(".lRChoosed").hide();
            $(".cetakChoosed").show();
            $(".lainnyaChoosed").hide();
//      $(".penyiaranChoosed").attr("rel", "");
//      $(".cetakChoosed").attr("rel", "required");
            $('#expand4').fadeIn("slow");
            $('#expand4a').fadeIn("slow");
            $('#expand4b').fadeIn("slow");
            $("#cChoosed").attr("rel", "required");
            $("#lrChoosed").attr("rel", " ");
            $("#pChoosed").attr("rel", " ");
            x = 1;
           }
           else if (jenisIklan === "Penyiaran") {
            $(".lRChoosed").hide();
            $(".cetakChoosed").hide();
            $(".lainnyaChoosed").hide();
            $(".penyiaranChoosed").show();
//      $(".penyiaranChoosed").attr("rel", "required");
//      $(".cetakChoosed").attr("rel", "");
            $('#expand4').fadeIn("slow");
            $('#expand4a').fadeIn("slow");
            $('#expand4b').fadeIn("slow");
            $('#deskripsiIklan').attr("rel", "required");
            $("#cChoosed").attr("rel", "");
            $("#lrChoosed").attr("rel", "");
            $("#lnChoosed").attr("rel", "");
            $("#pChoosed").attr("rel", "required");
            x = 1;
           }
           else if (jenisIklan === "Luar Ruang") {
            $(".penyiaranChoosed").hide();
            $(".cetakChoosed").hide();
            $(".lainnyaChoosed").hide();
            $(".penyiaranChoosed").attr("rel", "");
            $(".cetakChoosed").attr("rel", "");
            $('#expand4').fadeIn("slow");
            $('#expand4a').fadeIn("slow");
            $('#expand4b').fadeIn("slow");
            $(".lRChoosed").show();
            $("#cChoosed").attr("rel", "");
            $("#lrChoosed").attr("rel", "required");
            $("#lnChoosed").attr("rel", "");
            $("#pChoosed").attr("rel", "");
            x = 0;
           }
           else if (jenisIklan === "Media Teknologi Informasi Lainnya") {
            $(".penyiaranChoosed").hide();
            $(".cetakChoosed").hide();
            $(".lRChoosed").hide();
            $(".penyiaranChoosed").attr("rel", "");
            $(".cetakChoosed").attr("rel", "");
            $('#expand4').fadeIn("slow");
            $('#expand4a').fadeIn("slow");
            $('#expand4b').fadeIn("slow");
            $(".lainnyaChoosed").show();
            $("#cChoosed").attr("rel", "");
            $("#lrChoosed").attr("rel", "");
            $("#lnChoosed").attr("rel", "required");
            $("#pChoosed").attr("rel", "");
            $("#tglTerbit").hide();
            $("#tglTugas").attr("rel", "");
            x = 1;
           }
           if (x == 1) {
            $(".cetakTertentu").hide("");
            $("#provkotAlamat").attr("");
            $("#kabkotAlamat").attr("rel", "");
            $(".cetakTertentu").attr("rel", "");
            $(".cetakTertentu").css('background-color', '#FFFFFF');
            $("#provkotAlamat").css('background-color', '#FFFFFF');
            $("#provkotAlamat").css('border', '1px solid #dcdcdc');
            $("#kabkotAlamat").css('background-color', '#FFFFFF');
            $("#kabkotAlamat").css('border', '1px solid #dcdcdc');
           } else if (x == 0) {
            $(".cetakTertentu").show("");
            $("#provkotAlamat").attr("rel", "required");
            $("#kabkotAlamat").attr("rel", "required");
            $(".cetakTertentu").attr("rel", "required");
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
                $(".file_" + arrdata[2] + "").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/" + arrdata[3] + "/" + arrdata[0] + "\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload_s/" + arrdata[3] + "/" + arrdata[0] + "\" jns=" + arrdata[2] + ">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"IKLAN_NAPZA[" + arrdata[2] + "]\" value=" + arrdata[0] + ">");
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
           var A = $(XXX).val().split('_');
           var B = "A";
           var param = $(XXX).attr('param');
           var name = $(XXX).attr("name");
           if (name === "CETAK[6]")
            B = "B";
           if (A[0] === '+' && B === "A") {
            $('.' + param).show();
            $('.' + param + "Val").attr("rel", "required");
            $("[id='" + name + "']").attr("rel", "required");
           }
           else if (A[0] === '-' && B === "B") {
            $('.' + param).show();
            $('.' + param + "Val").attr("rel", "required");
            $("[id='" + name + "']").attr("rel", "required");
           } else {
            $('.' + param).hide();
            $('.' + param + "Val").attr("rel", "");
            $("[id='" + name + "']").val("");
            $("[id='" + name + "']").attr("rel", "");
            $("[id='" + name + "']").css("background-color", "#FFF");
            $("[id='" + name + "']").css("border", "");
           }
//      mkTmk();
          }
          function checkList(obj) {
           var XXX = obj.attr("name"), xxx = obj.val(), X = "input:radio[name='" + XXX + "']", XX = xxx.split('_'), cls = obj.attr("class");
           if ($(X).is(":checked")) {
            uraianTidakLengkap();
            if (cls === 'infoTambahan') {
             uraianPenilaian1();
            }
           }
          }
          function checklistSub(clazz) {
           var i = 0;
           $('.' + clazz).each(function() {
            if ($(this).is(":checked")) {
             $('.' + clazz).closest("tr").css('border-left', '0px solid #F00');
             $('.' + clazz).closest("tr").css('border-right', '0px solid #F00');
             i++;
            }
            else
             i - 1;
           });
           if (i != 0) {
            $('.' + clazz + 'Val').attr("rel", "");
           }
           else
            $('.' + clazz + 'Val').attr("rel", "required");
          }
          function verifikasiPusat(X) {
           if ($(X).val() === "MK") {
            $(".vMK").show();
            $(".vMK").attr("rel", "required");
            $(".vMKa").attr("rel", "required");
            $(".vMKa").attr("name", "IKLAN[TL_PUSAT][]");
            $(".vTMK").hide();
            $(".vTMK").attr("rel", " ");
            $(".vTMK").val("");
            $(".vTMKa").val("");
            $(".vTMKa").attr("rel", " ");
            $(".vTMKa").attr("name", " ");
            $(".vTMK2").hide("slow");
            $(".vTMK2").val("");
            $(".vTMK2").attr("rel", "");
            $(".vTMK2a").val("");
           }
           else if ($(X).val() === "TMK") {
            $(".vMK").hide();
            $(".vMK").attr("rel", " ");
            $(".vMK").val("");
            $(".vMKa").attr("rel", " ");
            $(".vMKa").attr("name", " ");
            $(".vMKa").val("");
            $(".vTMK").show();
            $(".vTMK").attr("rel", "required");
            $(".vTMKa").attr("rel", "required");
            $(".vTMKa").attr("name", "IKLAN[TL_PUSAT][]");
           }
           else {
            $(".vMK").hide();
            $(".vMK").attr("rel", " ");
            $(".vMK").val("");
            $(".vMKa").attr("rel", " ");
            $(".vMKa").attr("name", " ");
            $(".vMKa").val("");
            $(".vMK").hide();
            $(".vTMK").hide();
            $(".vTMK").hide();
            $(".vTMK").attr("rel", " ");
            $(".vTMK").val("");
            $(".vTMKa").val("");
            $(".vTMKa").attr("rel", " ");
            $(".vTMKa").attr("name", " ");
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
          function statisGerak(obj) {
           $(".X").hide();
           $(".X").val("");
           $(".XCHK").attr("checked", false);
           $(".X").attr("rel", "");
           $(".row" + $(obj).val()).show();
           $(".penilaianTI" + $(obj).val()).attr("rel", "required");
          }
          function loadPenilaianReq(X) {
<?php for ($i = 0; $i <= count($penilaianAll); $i++) { ?>
            if ($("[name='" + X + "[<?php echo $i ?>]']").is("input:radio") || $("[name='" + X + "[<?php echo $i ?>]']").is("input:checkbox"))
             checkListTxt($("[name='" + X + "[<?php echo $i ?>]']"));
<?php } ?>
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
            if ("<?php echo $this->newsession->userdata("SESS_BBPOM_ID") ?>" === "92") {
             verifikasiPusat($(".verifikasiPusat"));
             verifikasiTL($("#vTMKSub"));
            }
            if ('<?php echo $sess["JENIS"] ?>' === "CT") {
             jenisPenilaian("#iklan_media");
             loadPenilaianReq("CETAK");
            }
            else if ('<?php echo $sess["JENIS"] ?>' === "LR") {
             jenisPenilaian("#iklan_media");
             loadPenilaianReq("LR");
            }
            else if ('<?php echo $sess["JENIS"] ?>' === "TI") {
             jenisPenilaian("#iklan_media");
             loadPenilaianReq("TI");
            }
            else if ('<?php echo $sess["JENIS"] ?>' === "RD") {
             jenisPenilaian(".mediaIklanEdit");
             loadPenilaianReq("RADIO");
            }
            else if ('<?php echo $sess["JENIS"] ?>' === "TV") {
             jenisPenilaian(".mediaIklanEdit");
             loadPenilaianReq("TV");
            }
            showHide();
            showHide2('<?php echo $sess['MEDIA']; ?>');
<?php } ?>
           //                      akhir load data edit
           $('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
           $("#iklan_kelompok").change(function() {
            clear();
            showHide();
           });
           $('#cChoosed').change(function() {
            showHide();
           });
           $('#pChoosed').change(function() {
            showHide();
           });
           $('#lRChoosed').change(function() {
            showHide();
           });
           $('#kesimpulanHasilPenilaian').change(function() {
            cekLampiran();
           });
           $(".uraianPenilaian").click(function() {
            var name = $(this).attr("name");
            var selected = $("[name='" + name + "']:checked").val();
            $("input[type='text'][name='" + name + "']").val(selected);
            $(this).closest("tr").css('border-left', '0px solid #F00');
            $(this).closest("tr").css('border-right', '0px solid #F00');
            checkListTxt($(this));
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
            $("#tb_napza").append('<tr class= "' + cls + '"><td>&nbsp;</td><tr class= "' + cls + '"><td width="150">Nama / Merk Rokok</td><td><input type="text" size="40" name="PRODUK[NAMA][]" class="namaNapza" id="namaNapza' + cls + '" title="Nama / Merk Rokok" rel="required"/>&nbsp;<a href="javascript:void(0)" class="min" id="minCls' + cls + '" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Rokok" /></a><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td width="150">Nama Produsen</td><td><input type="text" size="40" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="namaPemilikNIE' + cls + '" title="NamaProdusen" rel="required" /></td></tr><tr class= "' + cls + '"><td width="150">Bentuk Kemasan Produk Tembakau</td><td><select class="stext" title="Bentuk Kemasan Produk Tembakau" name="PRODUK[NAMAPEMILIKIZINEDAR][]" id="bentukKemasan' + cls + '" rel = "required"><option value=""></option><option value="BLL">Bentuk lainnya</option><option value="KPP">Kotak persegi panjang</option><option value="KSL">Kotak dengan sisi lebar yang sama</option><option value="SLN">Silinder</option></select></td></tr>');
            $(this).attr('terakhir', parseInt(nom) + 1);
            $("input.Rokok" + cls).autocomplete($("input.namaNapza").attr("url") + 'kos', {width: 244, selectFirst: false});
            $("#minCls" + cls).click(function() {
             $('.' + cls).remove();
            });
            $("input.namaNapza" + cls).result(function(event, data, formatted) {
             if (data) {
              var golonganNapza = data[2].substring(2, 1);
              $(this).val(data[1]);
              $("#namaPemilikNIE" + cls).val(data[3]);
              $("#bentukSediaan" + cls).val(data[9]);
              if (data[13] !== "-" && data[13] !== "")
               $("#merkDagang" + cls).val(data[13]);
              else
               $("#merkDagang" + cls).val("-");
              $("#NIE" + cls).val(data[2]);
              var jenis = data[12].split('-'), val = [];
              for (var i = 0; i < jenis.length; i++)
               val.push(jenis[i]);
              val = "" + val;
              $("#jenis_napza" + cls).val(val.replace(/,/g, ", "));
              $("#mbbpomid" + cls).val(data[2]);
              $("input.op").autocomplete($("input.op").attr("url") + $("#bbpomid" + cls).val(), {width: 244, selectFirst: false});
             }
            });
            $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter', showTimeout: 1, alignTo: 'target', alignX: 'right', alignY: 'center', offsetX: 5, allowTipHover: false, fade: false, slide: false});
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
              $("#fileToUpload_" + jenis + "").val('');
              $(".file_" + jenis + "").html("");
              $("#file_" + jenis + "").hide();
              cekLampiran();
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
           $("#lnChoosed").keyup(function() {
            var val = $(this).val();
            var val2 = val.charAt(0).toUpperCase();
            val = val.slice(1);
            $(this).val(val2 + val);
           });
           $(".subPenilaianTVGT").click(function() {
            checklistSub('subPenilaianTVGT');
           });
           $(".subPenilaianTIGT").click(function() {
            checklistSub('subPenilaianTIGT');
           });
           $(".subPenilaianRadioGT").click(function() {
            checklistSub('subPenilaianRadioGT');
           });
           $(".subPenilaianCetakGT").click(function() {
            checklistSub('subPenilaianCetakGT');
           });
           $(".subPenilaianLuarRuangGT").click(function() {
            checklistSub('subPenilaianLuarRuangGT');
           });

          });
</script>