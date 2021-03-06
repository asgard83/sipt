<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input, select, textarea').focus(function(){
			$(this).css('background-color','#FFF');
			$(this).css('border','1px solid #dddddd');
		});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});		<?php #if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
		$("#propinsi").change(function(){ 
			var propinsi = $(this).val(); 
			$.get($(this).attr('url')+ propinsi, function(hasil){
				$("#kota").html(hasil);
			});
		});		
		<?php #} ?>
$(".addmaklon").live("click", function(){
			var panjang = $("ul#list_maklon").length;
			$("ul#list_maklon").append('<li style="padding-bottom:3px;" id="'+(panjang+1)+'"><div style="padding-bottom:3px;"><input type="text" name="SARANA[NAMA_MAKLON][]" class="stext" title="Nama Maklon" style="width:220px;" />&nbsp;<a href="#" class="delmaklon"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus atau batalkan maklon" /></a></div><div style="padding-bottom:3px;"><textarea class="stext" name="SARANA[ALAMAT_MAKLON][]" title="Alamat Maklon"></textarea></div></li>');
			$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
			return false;
		});
		$(".delmaklon").live("click", function(){
			var id = $(this).closest("ul#list_maklon li").attr("id");
			$("ul#list_maklon li#"+id).remove();
			return false;
		});
		$("#bahan_tambahan").autocomplete($("#bahan_tambahan").attr("url"), {width: 449, selectFirst: false, multiple: true, matchContains: true});
	});
</script>

<h2 class="small">Jenis Sarana : <?php echo $nama_jenis_sarana; ?></h2>
<?php
if($ispreview){
	?>
    <table class="form_tabel detil">
        <tr><td class="td_left">Nama Pemilik / Pimpinan</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
        <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo join("<br>", $alamat_1); ?></td></tr>
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo $sess['NAMA_PROP']; ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo $sess['NAMA_KOTA']; ?></td></tr>
        <tr><td class="td_left">Alamat Unit Pengolahan</td><td class="td_right"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo join("<br>", $alamat_2); ?></td></tr>
        <tr><td class="td_left">Maklon</td><td class="td_right">
        <?php
        if(is_array($sess)){
            $jml_maklon = count(explode("#", $sess['NAMA_MAKLON']));
            $nama_maklon = explode("#", $sess['NAMA_MAKLON']);
            $alamat_maklon = explode("#", $sess['ALAMAT_MAKLON']);
            ?>
            <ul style="list-style:none; margin:0px; padding:0px;" id="list_maklon"><li style="padding-bottom:3px;"><div style="padding-bottom:3px;"><?php echo str_replace("0|",'',$nama_maklon[0]); ?>&nbsp;</div><div style="padding-bottom:3px;"><?php echo str_replace("0|",'',$alamat_maklon[0]); ?></div></li>
            <?php
            for($i=1;$i<$jml_maklon; $i++){
                ?>
                <li style="padding-bottom:3px;"><div style="padding-bottom:3px;"><?php echo str_replace($i."|",'',$nama_maklon[$i]); ?></div><div style="padding-bottom:3px;"><?php echo str_replace($i."|",'',$alamat_maklon[$i]); ?></div></li>
                <?php
            }
            ?>
            </ul>
            <?php
        }
        ?>
        </td></tr>
        <tr><td class="td_left">Ijin Perusahaan</td><td class="td_right"><?php echo $sess['IZIN_PERUSAHAAN']; ?></td></tr>
        <tr><td class="td_left">Jenis Perusahaan</td><td class="td_right"><?php echo $sess['JENIS_PERUSAHAAN']; ?></td></tr>
        <tr><td class="td_left">Jumlah Karyawan</td><td class="td_right"><?php echo $sess['JUMLAH_KARYAWAN']; ?></td></tr>
        <tr><td class="td_left">Nama Pangan / Makanan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $nama_pangan = explode(";", $sess['NAMA_PANGAN']); echo "<li>".join("</li><li>", $nama_pangan)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Tahun Unit Pengolahan Didirikan</td><td class="td_right"><?php echo $sess['TAHUN_DIDIRIKAN']; ?></td></tr>
        <tr><td class="td_left">Mulai Operasi</td><td class="td_right"><?php echo $sess['TAHUN_OPERASI']; ?></td></tr>
        <tr><td class="td_left">Kapasitas Unit Pengolahan</td><td class="td_right"><?php echo $sess['KAPASITAS_PENGOLAHAN']; ?>&nbsp;ton / hari</td></tr>
        <tr><td class="td_left">Produksi Rata-rata Per Hari</td><td class="td_right"><?php echo $sess['PRODUKSI_PER_HARI']; ?>&nbsp;ton / hari</td></tr>
        <tr><td class="td_left">Jenis Pangan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $jenis_pangan = explode(";", $sess['JENIS_PANGAN']); echo "<li>".join("</li><li>", $jenis_pangan)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Merk Produk</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $merk = explode(";", $sess['MERK_PRODUK']); echo "<li>".join("</li><li>", $merk)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Karyawan Tetap Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_TETAP_PRIA_OLAH']; ?> Orang&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_TETAP_WANITA_OLAH']; ?> Orang</td></tr>
        <tr><td class="td_left">Karyawan Tetap Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_TETAP_PRIA_ADM']; ?> Orang&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_TETAP_WANITA_ADM']; ?> Orang</td></tr>
        <tr><td class="td_left">Karyawan Harian Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_HARIAN_PRIA_OLAH']; ?> Orang&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_HARIAN_WANITA_OLAH']; ?> Orang</td></tr>
        <tr><td class="td_left">Karyawan Harian Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_HARIAN_PRIA_ADM']; ?> Orang&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_HARIAN_WANITA_ADM']; ?> Orang</td></tr>
        <tr><td class="td_left">Karyawan Borongan Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_PRIA_OLAH']; ?> Orang&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_WANITA_OLAH']; ?> Orang</td></tr>
        <tr><td class="td_left">Karyawan Borongan Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_PRIA_ADM']; ?> Orang&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_WANITA_ADM']; ?> Orang</td></tr>
        <tr><td class="td_left">Penanggung Jawab Pabrik</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_PABRIK']; ?></td></tr>
        <tr><td class="td_left">Penanggung Jawab Produksi</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_PRODUKSI']; ?></td></tr>
        <tr><td class="td_left">Penanggung Jawab Mutu</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_MUTU']; ?></td></tr>
        <tr><td class="td_left">Penanggung Jawab Sanitasi</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_SANITASI']; ?></td></tr>
        <tr><td class="atas isi" colspan="2">Bahan Baku Hasil dari Perusahaan Sendiri</td></tr>
        <?php
        if(is_array($sess)){
            $anak_perusahaan = explode("#", $sess['ANAK_PERUSAHAAN']);
			$jml_anak = explode(";" ,str_replace('NAMA|','',$anak_perusahaan[0]));
			$anak_satu = explode(";" ,str_replace('NAMA|','',$anak_perusahaan[0]));
			$jenis_satu = explode(";" ,str_replace('JENIS|','',$anak_perusahaan[1]));
			$alamat_satu = explode(";" ,str_replace('ALAMAT|','',$anak_perusahaan[2]));
			for($i=0;$i<count($jml_anak); $i++){
				?>
        <tr><td class="td_left">Nama Perusahaan</td><td class="td_right"><?php echo $anak_satu[$i]; ?></td></tr>
        <tr><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><?php echo $jenis_satu[$i]; ?></td></tr>
        <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $alamat_satu[$i]; ?></td></tr>
                <?php
			}
        }
        ?>
        <tr><td class="atas isi" colspan="2">Bahan Baku Hasil Pembelian dari Perusahan Lain</td></tr>
        <?php
        if(is_array($sess)){
            $perusahaan_lain = explode("#", $sess['PERUSAHAAN_LAIN']);
			$jmpl = explode(";" ,str_replace('NAMA|','',$perusahaan_lain[0]));
			$anak_jmpl = explode(";" ,str_replace('NAMA|','',$perusahaan_lain[0]));
			$jenis_jmpl = explode(";" ,str_replace('JENIS|','',$perusahaan_lain[1]));
			$alamat_jmpl = explode(";" ,str_replace('ALAMAT|','',$perusahaan_lain[2]));
			for($i=0;$i<count($jmpl); $i++){
				?>
        <tr><td class="td_left">Nama Perusahaan</td><td class="td_right"><?php echo $anak_jmpl[$i]; ?></td></tr>
        <tr><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><?php echo $jenis_jmpl[$i]; ?></td></tr>
        <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $alamat_jmpl[$i]; ?></td></tr>
                <?php
			}
        }
        ?>
        <tr><td class="atas isi" colspan="2">Bahan Baku Hasil Pembelian dari Supplier / Pemasok</td></tr>
        <?php
        if(is_array($sess)){
            $supplier = explode("#", $sess['SUPPLIER']);
			$jmspl = explode(";" ,str_replace('NAMA|','',$supplier[0]));
			$anak_smpl = explode(";" ,str_replace('NAMA|','',$supplier[0]));
			$jenis_smpl = explode(";" ,str_replace('JENIS|','',$supplier[1]));
			$alamat_smpl = explode(";" ,str_replace('ALAMAT|','',$supplier[2]));
			for($i=0;$i<count($jmspl); $i++){
				?>
        <tr><td class="td_left">Nama Perusahaan</td><td class="td_right"><?php echo $anak_smpl[$i]; ?></td></tr>
        <tr><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><?php echo $jenis_smpl[$i]; ?></td></tr>
        <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo $alamat_smpl[$i]; ?></td></tr>
                <?php
			}
        }
        ?>
        <tr><td colspan="2" class="atas isi">Es berasal dari (jika proses produksi menggunakan es)</td></tr>
        <tr><td class="td_left">Produksi sendiri dengan kapasitas</td><td class="td_right"><?php echo $sess['KAPASITAS_ES']; ?>&nbsp;ton/hari</td></tr>
        <tr><td class="td_left">Pembelian dari</td><td class="td_right"><?php echo $sess['PEMBELIAN_ES']; ?></td></tr>
        <tr><td class="td_left">Bentuk Es</td><td class="td_right"><?php $bentuk_es = explode(";", $sess['BENTUK_ES']); echo join("<br>", $bentuk_es); ?></td></tr>
        <tr><td class="td_left">Kebutuhan Es rata-rata per hari</td><td class="td_right"><?php echo $sess['KEBUTUHAN_ES']; ?></td></tr>
        <tr><td colspan="2" class="atas isi">Suplai air berasal dari</td></tr>
        <tr><td class="td_left">Air tanah yang diproduksi/dibor sendiri</td><td class="td_right">Kapasitas&nbsp;<?php echo $sess['KAPASITAS_AIR_TANAH']; ?>&nbsp;m<sup>3</sup>/hari</td></tr>
        <tr><td class="td_lefet">Perlakuan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tanah = explode(";", $sess['PERLAKUAN_AIR_TANAH']); echo "<li>".join("</li><li>", $tanah)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Air ledeng (dari Perusahaan Air Minum)</td><td class="td_right">Kapasitas&nbsp;<?php echo $sess['KAPASITAS_AIR_LEDENG']; ?>&nbsp;m<sup>3</sup>/hari</td></tr>
        <tr><td class="td_lefet">Perlakuan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $ledeng = explode(";", $sess['PERLAKUAN_AIR_LEDENG']); echo "<li>".join("</li><li>", $ledeng)."</li>"; ?></ul></td></tr>
        <tr><td class="td_left">Bahan Tambahan Yang Digunakan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $bahan_tambahan = explode(";", $sess['BAHAN_TAMBAHAN']); echo "<li>".join("</li><li>", $bahan_tambahan)."</li>"; ?></ul></td></tr>
        <?php
        if(is_array($sess)){
            $pengawetan = explode("#", $sess['PENGAWETAN']);
        }
        ?>
        <tr><td class="td_left">Sistem Pengawetan Pembekuan</td><td class="td_right"><?php echo str_replace('PEMBEKUAN|','',$pengawetan[0]); ?></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pendinginan</td><td class="td_right"><?php echo str_replace('PENDINGIN|','',$pengawetan[1]); ?></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pengalengan</td><td class="td_right"><?php echo str_replace('PENGALENGAN|','',$pengawetan[2]); ?></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pengeringan</td><td class="td_right"><?php echo str_replace('PENGERINGAN|','',$pengawetan[3]); ?></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pengolahan lain</td><td class="td_right"><?php echo str_replace('PENGOLAHAN_LAIN|','',$pengawetan[4]); ?></td></tr>
    </table>
    <?php
}else{
	?>
    <table class="form_tabel detil">
        <tr><td class="td_left">Nama Pemilik / Pimpinan</td><td class="td_right"><input name="SARANA[NAMA_PIMPINAN]" class="stext" value="<?php echo $sess['NAMA_PIMPINAN']; ?>" title="Nama Pimpinan / Pemilik" /></td></tr>
        <tr><td class="td_left">Alamat Kantor</td><td class="td_right"><textarea name="SARANA[ALAMAT_1]" class="stext" title="Alamat Kantor. Jika mempunyai alamat lebih dari satu, pisahkan dengan tanda ; (titik koma)" rel="required"><?php echo $sess['ALAMAT_1'] ?></textarea></td></tr>
        <tr><td class="td_left">Alamat Unit Pengolahan</td><td class="td_right"><textarea name="SARANA[ALAMAT_2]" class="stext" title="Alamat Unit Pengolahan. Jika mempunyai alamat lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo $sess['ALAMAT_2']; ?></textarea></td></tr>                
        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo form_dropdown('SARANA[PROPINSI]',$propinsi,$sel_propinsi,'id="propinsi" class="stext" rel="required" title="Nama Propinsi asal sarana" url="'.site_url().'/autocompletes/autocomplete/set_kota/"'); ?></td></tr>
        <tr><td class="td_left">Kota / Kabupaten</td><td class="td_right"><?php echo form_dropdown('SARANA[KOTA]',$kota,$sel_kota,'class="stext" id="kota" rel="required" title="Nama Kota asal sarana"'); ?></td></tr>

        <tr><td class="td_left">Maklon</td><td class="td_right">
        <?php
        if(is_array($sess)){
            $jml_maklon = count(explode("#", $sess['NAMA_MAKLON']));
            $nama_maklon = explode("#", $sess['NAMA_MAKLON']);
            $alamat_maklon = explode("#", $sess['ALAMAT_MAKLON']);
            ?>
            <ul style="list-style:none; margin:0px; padding:0px;" id="list_maklon"><li style="padding-bottom:3px;"><div style="padding-bottom:3px;"><input type="text" name="SARANA[NAMA_MAKLON][]" class="stext" title="Nama Maklon" style="width:220px;" value="<?php echo str_replace("0|",'',$nama_maklon[0]); ?>" />&nbsp;<a href="#" class="addmaklon"><img src="<?php echo base_url(); ?>images/add.png" align="top" style="border:none" title="Tambah maklon (jika mempunyai maklon lebih dari satu)" /></a></div><div style="padding-bottom:3px;"><textarea class="stext" name="SARANA[ALAMAT_MAKLON][]" title="Alamat Maklon"><?php echo str_replace("0|",'',$alamat_maklon[0]); ?></textarea></div></li>
            <?php
            for($i=1;$i<$jml_maklon; $i++){
                ?>
                <li style="padding-bottom:3px;" id="<?php echo $i; ?>"><div style="padding-bottom:3px;"><input type="text" name="SARANA[NAMA_MAKLON][]" class="stext" title="Nama Maklon" style="width:220px;" value="<?php echo str_replace($i."|",'',$nama_maklon[$i]); ?>" />&nbsp;<a href="#" class="delmaklon"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus atau batalkan maklon" /></a></div><div style="padding-bottom:3px;"><textarea class="stext" name="SARANA[ALAMAT_MAKLON][]" title="Alamat Maklon"><?php echo str_replace($i."|",'',$alamat_maklon[$i]); ?></textarea></div></li>
                <?php
            }
            ?>
            </ul>
            <?php
        }else{
            ?>
            <ul style="list-style:none; margin:0px; padding:0px;" id="list_maklon"><li style="padding-bottom:3px;"><div style="padding-bottom:3px;"><input type="text" name="SARANA[NAMA_MAKLON][NAMA]" class="stext" title="Nama Maklon" style="width:220px;" />&nbsp;<a href="#" class="addmaklon"><img src="<?php echo base_url(); ?>images/add.png" align="top" style="border:none" title="Tambah maklon (jika mempunyai maklon lebih dari satu)" /></a></div><div style="padding-bottom:3px;"><textarea class="stext" name="SARANA[ALAMAT_MAKLON][ALAMAT]" title="Alamat Maklon"></textarea></div></li></ul>
            <?php
        }
        ?>
        </td></tr>
        <tr><td class="td_left">Ijin Perusahaan</td><td class="td_right"><input type="text" class="stext" name="SARANA[IZIN_PERUSAHAAN]" value="<?php echo $sess['IZIN_PERUSAHAAN']; ?>" title="No. Ijin Perusahaan" /></td></tr>
        <tr><td class="td_left">Jenis Perusahaan</td><td class="td_right"><input type="text" class="stext" name="SARANA[JENIS_PERUSAHAAN]" value="<?php echo $sess['JENIS_PERUSAHAAN']; ?>" title="Jenis Perusahaan" /></td></tr>
        <tr><td class="td_left">Golongan Pabrik</td><td class="td_right"><input type="text" class="stext" name="SARANA[GOLONGAN_PABRIK]" value="<?php echo $sess['GOLONGAN_PABRIK']; ?>" title="Golongan Pabrik" /></td></tr>
        <tr><td class="td_left">Jumlah Karyawan</td><td class="td_right"><input type="text" class="stext sdate" name="SARANA[JUMLAH_KARYAWAN]" value="<?php echo $sess['JUMLAH_KARYAWAN']; ?>" id="JUMLAH_KARYAWAN" onkeyup="numericOnly($(this))" title="Jumlah Karyawan" />&nbsp;Orang</td></tr>
        <tr><td class="td_left">Nama Pangan / Makanan</td><td class="td_right"><textarea class="stext" name="SARANA[NAMA_PANGAN]" title="Nama pangan / makanan. Jika mempunyai lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo $sess['NAMA_PANGAN']; ?></textarea></td></tr>
        <tr><td class="td_left">Nomor Registrasi</td><td class="td_right"><textarea class="stext" name="SARANA[NOMOR_REGISTRASI]" title="Nomor Registrasi. Jika mempunyai lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo $sess['NOMOR_REGISTRASI']; ?></textarea></td></tr>

        <tr><td class="td_left">Tahun Unit Pengolahan Didirikan</td><td class="td_right"><input type="text" class="stext sdate" maxlength="4" name="SARANA[TAHUN_DIDIRIKAN]" value="<?php echo $sess['TAHUN_DIDIRIKAN']; ?>" title="Tahun unit pengolahan didirikan. Contoh : 2000" /></td></tr>
        <tr><td class="td_left">Mulai Operasi</td><td class="td_right"><input type="text" class="stext sdate" maxlength="4" name="SARANA[TAHUN_OPERASI]" value="<?php echo $sess['TAHUN_OPERASI']; ?>" title="Tahun didirikan. Contoh : 2000" /></td></tr>
        <tr><td class="td_left">Kapasitas Unit Pengolahan</td><td class="td_right"><input type="text" class="stext sdate" name="SARANA[KAPASITAS_PENGOLAHAN]" value="<?php echo $sess['KAPASITAS_PENGOLAHAN']; ?>" id="KAPASITAS_PENGOLAHAN" onkeyup="numericOnly($(this))" title="Kapasitas unit pengolahan dalam ton / hari" />&nbsp;ton / hari</td></tr>
        <tr><td class="td_left">Produksi Rata-rata Per Hari</td><td class="td_right"><input type="text" class="stext sdate" name="SARANA[PRODUKSI_PER_HARI]" id="PRODUKSI_PER_HARI" onkeyup="numericOnly($(this))" value="<?php echo $sess['PRODUKSI_PER_HARI']; ?>" title="Produksi rata-rata per hari dalam ton / hari" />&nbsp;ton / hari</td></tr>
        <tr><td class="td_left">Jenis Pangan</td><td class="td_right"><textarea name="SARANA[JENIS_PANGAN]" class="stext" title="Jenis Pangan. Jika mempunyai jenis pangan lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo $sess['JENIS_PANGAN']; ?></textarea></td></tr>
        <tr><td class="td_left">Merk Produk</td><td class="td_right"><textarea name="SARANA[MERK_PRODUK]" class="stext" title="Merk Produk. Jika mempunyai merk produk lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo $sess['MERK_PRODUK']; ?></textarea></td></tr>
        <tr><td class="td_left">Karyawan Tetap Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<input name="SARANA[KARYAWAN_TETAP_PRIA_OLAH]" id="KARYAWAN_TETAP_PRIA_OLAH" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan tetap pengolahan (pria)" value="<?php echo $sess['KARYAWAN_TETAP_PRIA_OLAH']; ?>" />&nbsp;&bull;&nbsp;Wanita&nbsp;<input name="SARANA[KARYAWAN_TETAP_WANITA_OLAH]" class="stext sdate" title="Karyawan tetap pengolahan (wanita)" value="<?php echo $sess['KARYAWAN_TETAP_WANITA_OLAH']; ?>" id="KARYAWAN_TETAP_OLAH_WANITA" onkeyup="numericOnly($(this))" /></td></tr>
        <tr><td class="td_left">Karyawan Tetap Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<input name="SARANA[KARYAWAN_TETAP_PRIA_ADM]" id="KARYAWAN_TETAP_PRIA_ADM" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan tetap administrasi (pria)" value="<?php echo $sess['KARYAWAN_TETAP_PRIA_ADM']; ?>" />&nbsp;&bull;&nbsp;Wanita&nbsp;<input name="SARANA[KARYAWAN_TETAP_WANITA_ADM]" id="KARYAWAN_TETAP_WANITA_ADM" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan tetap administrasi (wanita)" value="<?php echo $sess['KARYAWAN_TETAP_WANITA_ADM']; ?>" /></td></tr>
        <tr><td class="td_left">Karyawan Harian Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<input name="SARANA[KARYAWAN_HARIAN_PRIA_OLAH]" id="KARYAWAN_HARIAN_PRIA_OLAH" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan harian pengolahan (pria)" value="<?php echo $sess['KARYAWAN_HARIAN_PRIA_OLAH']; ?>" />&nbsp;&bull;&nbsp;Wanita&nbsp;<input name="SARANA[KARYAWAN_HARIAN_WANITA_OLAH]" id="KARYAWAN_HARIAN_WANITA_OLAH" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan harian pengolahan (wanita)" value="<?php echo $sess['KARYAWAN_HARIAN_WANITA_OLAH']; ?>" /></td></tr>
        <tr><td class="td_left">Karyawan Harian Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<input name="SARANA[KARYAWAN_HARIAN_PRIA_ADM]" id="KARYAWAN_HARIAN_PRIA_ADM" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan harian administrasi (pria)" value="<?php echo $sess['KARYAWAN_HARIAN_PRIA_ADM']; ?>" />&nbsp;&bull;&nbsp;Wanita&nbsp;<input name="SARANA[KARYAWAN_HARIAN_WANITA_ADM]" id="KARYAWAN_HARIAN_WANITA_ADM" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan harian administrasi (wanita)" value="<?php echo $sess['KARYAWAN_HARIAN_WANITA_ADM']; ?>" /></td></tr>
        <tr><td class="td_left">Karyawan Borongan Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<input name="SARANA[KARYAWAN_BORONGAN_PRIA_OLAH]" id="KARYAWAN_BORONGAN_PRIA_OLAH" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan borongan pengolahan (pria)" value="<?php echo $sess['KARYAWAN_BORONGAN_PRIA_OLAH']; ?>" />&nbsp;&bull;&nbsp;Wanita&nbsp;<input name="SARANA[KARYAWAN_BORONGAN_WANITA_OLAH]" id="KARYAWAN_BORONGAN_WANITA_OLAH" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan borongan pengolahan (wanita)" value="<?php echo $sess['KARYAWAN_BORONGAN_WANITA_OLAH']; ?>" /></td></tr>
        <tr><td class="td_left">Karyawan Borongan Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<input name="SARANA[KARYAWAN_BORONGAN_PRIA_ADM]" id="KARYAWAN_BORONGAN_PRIA_ADM" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan borongan administrasi (pria)" value="<?php echo $sess['KARYAWAN_BORONGAN_PRIA_ADM']; ?>" />&nbsp;&bull;&nbsp;Wanita&nbsp;<input name="SARANA[KARYAWAN_BORONGAN_WANITA_ADM]" id="KARYAWAN_BORONGAN_WANITA_ADM" onkeyup="numericOnly($(this))" class="stext sdate" title="Karyawan borongan administrasi (wanita)" value="<?php echo $sess['KARYAWAN_BORONGAN_WANITA_ADM']; ?>" /></td></tr>
        <tr><td class="td_left">Penanggung Jawab Pabrik</td><td class="td_right"><input name="SARANA[PENANGGUNG_JAWAB_PABRIK]" type="text" class="stext" title="Nama Penanggung Jawab Pabrik. Jika tidak ada cukup dengan tanda (-)" value="<?php echo $sess['PENANGGUNG_JAWAB_PABRIK']; ?>" /></td></tr>
        <tr><td class="td_left">Penanggung Jawab Produksi</td><td class="td_right"><input name="SARANA[PENANGGUNG_JAWAB_PRODUKSI]" type="text" class="stext" title="Nama Penanggung Jawab Produksi. Jika tidak ada cukup dengan tanda (-)" value="<?php echo $sess['PENANGGUNG_JAWAB_PRODUKSI']; ?>" /></td></tr>
        <tr><td class="td_left">Penanggung Jawab Mutu</td><td class="td_right"><input name="SARANA[PENANGGUNG_JAWAB_MUTU]" type="text" class="stext" title="Nama Penanggung Jawab Mutu. Jika tidak ada cukup dengan tanda (-)" value="<?php echo $sess['PENANGGUNG_JAWAB_MUTU']; ?>" /></td></tr>
        <tr><td class="td_left">Penanggung Jawab Sanitasi</td><td class="td_right"><input name="SARANA[PENANGGUNG_JAWAB_SANITASI]" type="text" class="stext" title="Nama Penanggung Jawab Sanitasi. Jika tidak ada cukup dengan tanda (-)" value="<?php echo $sess['PENANGGUNG_JAWAB_SANITASI']; ?>" /></td></tr>
        <?php
        if(is_array($sess)){
            $anak_perusahaan = explode("#", $sess['ANAK_PERUSAHAAN']);
        }
        ?>
        <tr><td class="atas isi" colspan="2">Bahan Baku Hasil dari Perusahaan Sendiri</td></tr>
        <tr><td class="td_left">Nama Perusahaan</td><td class="td_right"><textarea name="SARANA[ANAK_PERUSAHAAN][NAMA]" class="stext" title="Hasil pemanenan dari perusahaan sendiri/anak perusahaan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('NAMA|', '', $anak_perusahaan[0]); ?></textarea></td></tr>
        <tr><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><textarea name="SARANA[ANAK_PERUSAHAAN][JENIS]" class="stext" title="Jenis / Species bahan baku. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('JENIS|', '', $anak_perusahaan[1]); ?></textarea></td></tr>
        <tr><td class="td_left">Alamat</td><td class="td_right"><textarea name="SARANA[ANAK_PERUSAHAAN][ALAMAT]" class="stext" title="Alamat anak perusahaan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('ALAMAT|', '', $anak_perusahaan[2]); ?></textarea></td></tr>
        <?php
        if(is_array($sess)){
            $perusahaan_lain = explode("#", $sess['PERUSAHAAN_LAIN']);
        }
        ?>
        <tr><td class="atas isi" colspan="2">Bahan Baku Hasil Pembelian dari Perusahan Lain</td></tr>
        <tr><td class="td_left">Nama Perusahaan</td><td class="td_right"><textarea name="SARANA[PERUSAHAAN_LAIN][NAMA]" class="stext" title="Hasil pemanenan dari perusahaan sendiri/anak perusahaan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('NAMA|', '', $perusahaan_lain[0]); ?></textarea></td></tr>
        <tr><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><textarea name="SARANA[PERUSAHAAN_LAIN][JENIS]" class="stext" title="Jenis / Species bahan baku. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('JENIS|', '', $perusahaan_lain[1]); ?></textarea></td></tr>
        <tr><td class="td_left">Alamat</td><td class="td_right"><textarea name="SARANA[PERUSAHAAN_LAIN][ALAMAT]" class="stext" title="Alamat anak perusahaan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('ALAMAT|', '', $perusahaan_lain[2]); ?></textarea></td></tr>
        <?php
        if(is_array($sess)){
            $supplier = explode("#", $sess['SUPPLIER']);
        }
        ?>
        <tr><td class="atas isi" colspan="2">Bahan Baku Hasil Pembelian dari Supplier / Pemasok</td></tr>
        <tr><td class="td_left">Nama Perusahaan</td><td class="td_right"><textarea name="SARANA[SUPPLIER][NAMA]" class="stext" title="Hasil pemanenan dari perusahaan sendiri/anak perusahaan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('NAMA|', '', $supplier[0]); ?></textarea></td></tr>
        <tr><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><textarea name="SARANA[SUPPLIER][JENIS]" class="stext" title="Jenis / Species bahan baku. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('JENIS|', '', $supplier[1]); ?></textarea></td></tr>
        <tr><td class="td_left">Alamat</td><td class="td_right"><textarea name="SARANA[SUPPLIER][ALAMAT]" class="stext" title="Alamat anak perusahaan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)"><?php echo str_replace('ALAMAT|', '', $supplier[2]); ?></textarea></td></tr>
        <tr><td colspan="2" class="atas isi">Es berasal dari (jika proses produksi menggunakan es)</td></tr>
        <tr><td class="td_left">Produksi sendiri dengan kapasitas</td><td class="td_right"><input type="text" name="SARANA[KAPASITAS_ES]" id="KAPASITAS_ES" onkeyup="numericOnly($(this))" value="<?php echo $sess['KAPASITAS_ES']; ?>" class="stext sdate" title="Kapasitas produksi sendiri es dalam / hari" />&nbsp;ton/hari</td></tr>
        <tr><td class="td_left">Pembelian dari</td><td class="td_right"><input type="text" name="SARANA[PEMBELIAN_ES]" value="<?php echo $sess['PEMBELIAN_ES']; ?>" class="stext" title="Pembelian Es (bukan dari produksi sendiri)" /></td></tr>
        <tr><td class="td_left">Bentuk Es</td><td class="td_right"><input type="text" class="stext" name="SARANA[BENTUK_ES]" value="<?php echo $sess['BENTUK_ES']; ?>" title="Bentuk Es (balok, tube dan lain-lain). Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)" /></td></tr>
        <tr><td class="td_left">Kebutuhan Es rata-rata per hari</td><td class="td_right"><input type="text" class="stext sdate" name="SARANA[KEBUTUHAN_ES]" id="KEBUTUHAN_ES" onkeyup="numericOnly($(this))" value="<?php echo $sess['KEBUTUHAN_ES']; ?>" title="Kebutuhan es rata-rata per hari (jika ada)" /></td></tr>
        <tr><td colspan="2" class="atas isi">Suplai air berasal dari</td></tr>
        <tr><td class="td_left">Air tanah yang diproduksi/dibor sendiri</td><td class="td_right">Kapasitas&nbsp;<input type="text" name="SARANA[KAPASITAS_AIR_TANAH]" value="<?php echo $sess['KAPASITAS_AIR_TANAH']; ?>" id="KAPASITAS_AIR_TANAH" onkeyup="numericOnly($(this))" class="stext sdate" title="Kapasitas air tanah yang di produksi sendiri" />&nbsp;m<sup>3</sup>/hari</td></tr>
        <tr><td class="td_lefet">Perlakuan</td><td class="td_right"><textarea class="stext" name="SARANA[PERLAKUAN_AIR_TANAH]" title="Perlakuan terhadap Air tanah (pengendapan, penyaringan makro, penyaringan gradual/mikro, sterilisasi, khlorin, UV, ozon, dll). Jika lebih dari satu pisahkan dengan tanda ; (titik koma) "><?php echo $sess['PERLAKUAN_AIR_TANAH']; ?></textarea></td></tr>
        <tr><td class="td_left">Air ledeng (dari Perusahaan Air Minum)</td><td class="td_right">Kapasitas&nbsp;<input type="text" name="SARANA[KAPASITAS_AIR_LEDENG]" id="KAPASITAS_AIR_LEDENG" onkeyup="numericOnly($(this))" value="<?php echo $sess['KAPASITAS_AIR_LEDENG']; ?>" class="stext sdate" title="Kapasitas air dari Perusahaan Air Minum" />&nbsp;m<sup>3</sup>/hari</td></tr>
        <tr><td class="td_lefet">Perlakuan</td><td class="td_right"><textarea class="stext" name="SARANA[PERLAKUAN_AIR_LEDENG]" title="Perlakuan terhadap Air tanah (pengendapan, penyaringan makro, penyaringan gradual/mikro, sterilisasi, khlorin, UV, ozon, dll). Jika lebih dari satu pisahkan dengan tanda ; (titik koma) "><?php echo $sess['PERLAKUAN_AIR_LEDENG']; ?></textarea></td></tr>
        <tr><td class="td_left">Bahan Tambahan Yang Digunakan</td><td class="td_right"><textarea class="stext" id="bahan_tambahan" name="SARANA[BAHAN_TAMBAHAN]" title="Bahan tambahan yang digunakan. Jika lebih dari satu, pisahkan dengan tanda ; (titik koma)" url="<?php echo site_url(); ?>/autocompletes/autocomplete/bahan_tambahan"><?php echo $sess['BAHAN_TAMBAHAN']; ?></textarea></td></tr>
        <?php
        if(is_array($sess)){
            $pengawetan = explode("#", $sess['PENGAWETAN']);
        }
        ?>
        <tr><td class="td_left">Sistem Pengawetan Pembekuan</td><td class="td_right"><input type="text" name="SARANA[PENGAWETAN][PEMBEKUAN]" class="stext" value="<?php echo str_replace('PEMBEKUAN|','',$pengawetan[0]); ?>" title="Sistem pengawetan pembekuan. Jika tidak ada, cukup diberi tanda (-)" /></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pendinginan</td><td class="td_right"><input type="text" name="SARANA[PENGAWETAN][PENDINGIN]" value="<?php echo str_replace('PENDINGIN|','',$pengawetan[1]); ?>" class="stext" title="Sistem pengawetan pendinginan. Jika tidak ada, cukup diberi tanda (-)" /></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pengalengan</td><td class="td_right"><input type="text" name="SARANA[PENGAWETAN][PENGALENGAN]" value="<?php echo str_replace('PENGALENGAN|','',$pengawetan[2]); ?>" class="stext" title="Sistem pengawetan pengalengan. Jika tidak ada, cukup diberi tanda (-)"  /></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pengeringan</td><td class="td_right"><input type="text" name="SARANA[PENGAWETAN][PENGERINGAN]" value="<?php echo str_replace('PENGERINGAN|','',$pengawetan[3]); ?>" class="stext" title="Sistem pengawetan pengeringan. Jika tidak ada, cukup diberi tanda (-)" /></td></tr>
        <tr><td class="td_left">Sistem Pengawetan Pengolahan lain</td><td class="td_right"><input type="text"  name="SARANA[PENGAWETAN][PENGOLAHAN_LAIN]" value="<?php echo str_replace('PENGOLAHAN_LAIN|','',$pengawetan[4]); ?>" class="stext" title="Sistem pengawetan pengolahan lain. Jika tidak ada, cukup diberi tanda (-)" /></td></tr>
    </table>
    <?php
}
?>
