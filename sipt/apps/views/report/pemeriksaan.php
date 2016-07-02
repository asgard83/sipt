<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnsarana" class="judul"></div>
<div class="content">

<div id="accordion" style="border-top:1px solid #cfcece;">
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Laporan Pemeriksaan Sarana</a></li>
        <li><a href="#tabs-2">Laporan Temuan Produk</a></li>
		<li><a href="#tabs-3">Rekapitulasi Pemeriksaan</a></li>
        <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00") { ?>
        <li><a href="#tabs-4">Rekapitulasi Pemeriksaan Komoditi</a></li>
        <li><a href="#tabs-5">Rekapitulasi Status Dokumen</a></li>
        <?php } ?>
	</ul>
	<div id="tabs-1">
            <form action="<?php echo $act_rpt; ?>" autocomplete="off" method="post" id="rptpemeriksaan">
                <h2 class="small garis">Laporan Pemeriksaan Sarana</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('JENIS', $jenis_sarana, '', 'class="stext" url="'.site_url().'/pemeriksaan/pemeriksaan/klasifikasi/" title="Pilih salah satu jenis sarana" rel="required"', $disinput); ?><input type="hidden" name="TIPE" value="0" /></td></tr>
					<?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
                    <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
                    <?php } ?>
                    <tr><td class="td_left">Klasifikasi</td><td class="td_right"><?php echo form_dropdown('KK_ID',$klasifikasi,'','class="stext" id="kk" title="Pilih Klasifikasi Komoditi"'); ?></td></tr>
                    <tr><td class="td_left">Periode Pemeriksaan Awal</td><td class="td_right"><input type="text" class="sdate" name="AWAL" id="waktuperiksa_" title="Periode Pemeriksaan Awal" /></td></tr>
                    <tr><td class="td_left">Periode Pemeriksaan Akhir</td><td class="td_right"><input type="text" class="sdate" name="AKHIR" id="waktu_akhir" title="Periode Pemeriksaan Akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" /></td></tr>
					<tr><td class="td_left">Temuan</td><td class="td_right"><input type="text" class="stext" name="TEMUAN" title="Temuan Sarana" /></td></tr>
                    <tr id="row_kategori"><td class="td_left">Kategori Temuan</td><td class="td_right"><input type="text" class="stext" name="KATEGORI" title="Kategori Temuan" /></td></tr>
                    <tr><td class="td_left" id="td_tl">Tindak Lanjut</td><td class="td_right"><input type="text" class="stext" name="TINDAKAN" title="Tindak Lanjut" /></td></tr>
                    <tr><td class="td_left">Hasil</td><td class="td_right"><?php echo form_dropdown('HASIL',$hasil,'','class="stext" title="Hasil Pemeriksaan Sarana"'); ?></td></tr>
                </table>
                <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rptpemeriksaan'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
            </form>			
	</div>
    
	<div id="tabs-2">
            <form action="<?php echo $act_produk; ?>" autocomplete="off" method="post" id="rkpproduk">
                <h2 class="small garis">Laporan Temuan Produk</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Periode Pemeriksaan</td><td class="td_right"><input type="text" class="sdate" name="PRODUK_AWAL" id="produkawal" title="Periode Pemeriksaan Awal" />  sampai dengan  <input type="text" class="sdate" name="PRODUK_AKHIR" id="produkakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#produkawal', '#produkakhir'); return false;" /></td></tr>
                    <tr><td class="td_left">Komoditi Produk</td><td class="td_right"><?php echo form_dropdown('PRODUK_KLASIFIKASI',$klasifikasi,'','class="stext" id="klas" title="Pilih Klasifikasi Komoditi" rel="required"'); ?></td></tr>
                    <tr><td class="td_left">Nama Produk</td><td class="td_right"><input type="text" class="stext" name="PRODUK_NAMAPRODUK" title="Nama Produk" /></td></tr>
                    <tr><td class="td_left">Nomor Registrasi Produk</td><td class="td_right"><input type="text" class="stext" name="PRODUK_NOREGISTRASI" title="Nomor Registrasi Produk" /></td></tr>
                    <tr><td class="td_left">Klasifikasi Produk</td><td class="td_right"><input type="text" class="stext" name="PRODUK_KLASIFIKASIPRODUK" title="Klasifikasi Produk (Lokal, Impor, Lisensi)" /></td></tr>
                    <tr><td class="td_left">Kategori Temuan</td><td class="td_right"><input type="text" class="stext" name="PRODUK_KATEGORI" title="Kategori Temuan Produk (TIE, ED, BKO, Obat Keras)" /></td></tr>
                    <tr><td class="td_left">Jenis Pelanggaran</td><td class="td_right"><input type="text" class="stext" name="PRODUK_JENISPELANGGARAN" title="Jenis Pelanggaran" /></td></tr>
                    <tr><td class="td_left" id="td_tl">Tindak Lanjut Terhadap Produk</td><td class="td_right"><input type="text" class="stext" name="PRODUK_TINDAKAN" title="Tindak Lanjut Terhadap Produk" /></td></tr>
                    <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
                    <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('PRODUK_BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
                    <?php } ?>
                </table>
                <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rkpproduk'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
            </form>
    </div>			
    
	<div id="tabs-3">
            <form action="<?php echo $act_rkp; ?>" autocomplete="off" method="post" id="rkppemeriksaan">
                <h2 class="small garis">Rekapitulasi Pemeriksaan Sarana</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('JENIS',$jenis_sarana,'','class="stext" title="Pilih Jenis Sarana"',$disinput); ?></td></tr>
                    <tr><td class="td_left">Periode Pemeriksaan Awal</td><td class="td_right"><input type="text" class="sdate" name="AWAL" id="rekapawal" title="Periode Pemeriksaan Awal" /></td></tr>
                    <tr><td class="td_left">Periode Pemeriksaan Akhir</td><td class="td_right"><input type="text" class="sdate" name="AKHIR" id="rekapakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#rekapawal', '#rekapakhir'); return false;" /></td></tr>
                    <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
                    <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
                    <?php } ?>
                </table>
                <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rkppemeriksaan'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
            </form>
    </div>
    <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){ ?>
	<div id="tabs-4">
            <form action="<?php echo $act_komoditi; ?>" autocomplete="off" method="post" id="rkpkomoditi">
                <h2 class="small garis">Rekapitulasi Pemeriksaaan Komoditi</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Periode Pemeriksaan Awal</td><td class="td_right"><input type="text" class="sdate" name="KOMODITI_AWAL" id="komoditiawal" title="Periode Pemeriksaan Awal" /></td></tr>
                    <tr><td class="td_left">Periode Pemeriksaan Akhir</td><td class="td_right"><input type="text" class="sdate" name="KOMODITI_AKHIR" id="komoditiakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#komoditiawal', '#komoditiakhir'); return false;" /></td></tr>
                    <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
                    <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
                    <?php } ?>
                </table>
                <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rkpkomoditi'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
            </form>
    </div>			

	<div id="tabs-5">
            <form action="<?php echo $act_status; ?>" autocomplete="off" method="post" id="rkpstatus">
                <h2 class="small garis">Rekapitulasi Status Dokumen</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Periode Pemeriksaan Awal</td><td class="td_right"><input type="text" class="sdate" name="STATUS_AWAL" id="statusawal" title="Periode Pemeriksaan Awal" /></td></tr>
                    <tr><td class="td_left">Periode Pemeriksaan Akhir</td><td class="td_right"><input type="text" class="sdate" name="STATUS_AKHIR" id="statusakhir" title="Periode Pemeriksaan Akhir" onchange="compare('#statusawal', '#statusakhir'); return false;" /></td></tr>
                    <?php if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
                    <tr><td class="td_left">Balai Besar / Balai POM</td><td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td></tr>
                    <?php } ?>
                </table>
                <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rkpstatus'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
            </form>
    </div>			

    <?php } ?>
    			
</div>

</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#rekapawal, #rekapakhir, #komoditiawal, #komoditiakhir, #statusawal, #statusakhir, #produkawal, #produkakhir').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$("#row_namaproduk, #row_nomorregistrasi, #row_jenispelanggaran, #row_temuan, #row_klasifikasi, #row_tl, #row_kategori, #row_hasil").css("display", "none");       
		$("#tipe").change(function(){
			var val = $(this).val();
			if(val == "0"){
				$("#row_temuan, #row_tl, #row_hasil").show();
				$("#row_kategori, #row_namaproduk, #row_jenispelanggaran, #row_nomorregistrasi, #row_klasifikasi").hide();
				$("#td_tl").html('Tindakan Terhadap Sarana');
			}else if(val == "1"){
				$("#row_temuan, #row_hasil").hide();
				$("#row_namaproduk, #row_jenispelanggaran, #row_tl, #row_kategori, #row_nomorregistrasi, #row_klasifikasi").show();
				$("#td_tl").html('Tindakan Terhadap Produk');
			}else{
				$("#row_namaproduk, #row_jenispelanggaran, #row_temuan, #row_tl, #row_kategori, #row_hasil, #row_nomorregistrasi, #row_klasifikasi").hide();
				$("#td_tl").html('Tindakan');
			}
		});
    });
</script>