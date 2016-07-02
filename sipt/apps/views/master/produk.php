<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<?php
if($isPrev){
	?>
    <h2 class="small">Detil Produk</h2>
    <table class="form_tabel detil">
        <tr><td class="td_left">Nama Sarana</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td></tr>
        <tr><td class="td_left">Nama Produk</td><td class="td_right"><?php echo $sess['NAMA_PRODUK']; ?></td></tr>
        <tr><td class="td_left">Nomor Registrasi</td><td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td></tr>
        <tr><td class="td_left">Kemasan</td><td class="td_right"><?php echo $sess['KEMASAN']; ?></td></tr>
        <tr><td class="td_left">Bentuk Sediaan</td><td class="td_right"><?php echo $sess['BENTUK_SEDIAAN']; ?></td></tr>
        <tr><td class="td_left">Indikasi</td><td class="td_right"><?php echo $sess['INDIKASI']; ?></td></tr>
        <tr><td class="td_left">Label</td><td class="td_right"><?php echo $sess['LABEL']; ?></td></tr>
        <tr><td class="td_left">Komposisi</td><td class="td_right"><?php echo $sess['KOMPOSISI']; ?></td></tr>
    </table>
    <?php
}else{
	?>
    <div id="judulmproduk" class="judul"></div>
    <div class="content">
    <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_produk">
    <div class="adCntnr">
        <div class="acco2">
            <div class="expand"><b>Data Produk</b></div>
            <div class="collapse">
                    <div class="accCntnt">
                    <table class="form_tabel">
                        <tr><td class="td_left">Nama Sarana</td><td class="td_right"><input type="text" class="stext" rel="required" name="PRODUK[NAMA_SARANA]" title="Nama sarana yang membuat produk" value="<?php echo $sess['NAMA_SARANA']; ?>" id="sarana"/></td></tr>
                        <tr><td class="td_left">Nama Produk</td><td class="td_right"><input type="text" class="stext" title="Nama Produk" value="<?php echo $sess['NAMA_PRODUK']; ?>" name="PRODUK[NAMA_PRODUK]" id="nama_prod" rel="required" /></td></tr>
                        <tr><td class="td_left">Nomor Registrasi</td><td class="td_right"><input type="text" class="stext" title="Nomor Registrasi Produk" value="<?php echo $sess['NOMOR_REGISTRASI']; ?>" name="PRODUK[NOMOR_REGISTRASI]"/></td></tr>
                        <tr><td class="td_left">Kemasan</td><td class="td_right"><input type="text" class="stext" title="Kemasan Produk" value="<?php echo $sess['KEMASAN']; ?>" name="PRODUK[KEMASAN]" /></td></tr>
                        <tr><td class="td_left">Bentuk Sediaan</td><td class="td_right"><input type="text" class="stext" title="Bentuk Sediaan Produk" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" name="PRODUK[BENTUK_SEDIAAN]" /></td></tr>
                        <tr><td class="td_left">Indikasi</td><td class="td_right"><input type="text" class="stext" title="Indikasi Produk" value="<?php echo $sess['INDIKASI']; ?>" name="PRODUK[INDIKASI]" /></td></tr>
                        <tr><td class="td_left">Label</td><td class="td_right"><input type="text" class="stext" title="Label Produk" value="<?php echo $sess['LABEL']; ?>" name="PRODUK[LABEL]" /></td></tr>
                        <tr><td class="td_left">Komposisi</td><td class="td_right"><textarea class="stext" title="Komposisi Produk : Jika lebih dari satu pisahkan dengan titik koma (;)" name="PRODUK[KOMPOSISI]"><?php echo $sess['KOMPOSISI']; ?></textarea></td></tr>
                        <tr><td class="td_left">Propinsi</td><td class="td_right"><?php echo form_dropdown('PRODUK[PROPINSI]',$propinsi,$sess['PROPINSI'],'class="stext" rel="required" title="Nama Propinsi asal produk"'); ?></td></tr>
                    </table>
                    </div>
            </div>
            <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_produk','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
        </div>
    </div>
    <input type="hidden" name="ID" value="<?php echo $id; ?>" />
    </form>
    </div>
    
<?php
}
?>
