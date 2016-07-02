<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rptproduk">
      <table class="form_tabel">
        <tr>
          <td class="td_left">Periode Pemeriksaan</td>
          <td class="td_right"><input type="text" class="sdate" name="PRODUK_AWAL" id="produkawal" title="Periode Pemeriksaan Awal" />
            sampai dengan
            <input type="text" class="sdate" name="PRODUK_AKHIR" id="produkakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#produkawal', '#produkakhir'); return false;" /></td>
        </tr>
        <tr>
          <td class="td_left">Komoditi Produk</td>
          <td class="td_right"><?php echo form_dropdown('PRODUK_KLASIFIKASI',$klasifikasi,'','class="stext" id="klas" title="Pilih Klasifikasi Komoditi" rel="required"'); ?></td>
        </tr>
        <tr>
          <td class="td_left">Nama Produk</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_NAMAPRODUK" title="Nama Produk" /></td>
        </tr>
        <tr>
          <td class="td_left">Nomor Registrasi Produk</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_NOREGISTRASI" title="Nomor Registrasi Produk" /></td>
        </tr>
        <tr>
          <td class="td_left">Nomor Bets</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_NO_BATCH" title="Nomor Batch Produk" /></td>
        </tr>
        <tr>
          <td class="td_left">Klasifikasi Produk</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_KLASIFIKASIPRODUK" title="Klasifikasi Produk (Lokal, Impor, Lisensi)" /></td>
        </tr>
        <tr>
          <td class="td_left">Kategori Temuan</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_KATEGORI" title="Kategori Temuan Produk (TIE, ED, BKO, Obat Keras)" /></td>
        </tr>
        <tr>
          <td class="td_left">Jenis Pelanggaran</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_JENISPELANGGARAN" title="Jenis Pelanggaran" /></td>
        </tr>
        <tr>
          <td class="td_left" id="td_tl">Tindak Lanjut Terhadap Produk</td>
          <td class="td_right"><input type="text" class="stext" name="PRODUK_TINDAKAN" title="Tindak Lanjut Terhadap Produk" /></td>
        </tr>
        <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('PRODUK_BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
        <?php } ?>
        <?php if($this->newsession->userdata('SESS_BBPOM_ID') != "00" && !in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
        <tr>
          <td class="td_left">Kabupaten / Kota</td>
          <td class="td_right"><?php echo form_dropdown('KOTA',$kota,'','class="stext" title="Kabupaten / Kota"'); ?></td>
        </tr>
        <?php } ?>
      </table>
      <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rptproduk'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
  </div>
</div>
