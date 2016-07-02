<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="form-berita">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b>Berita Update Aplikasi</b></div>
        <div class="collapse">
                <div class="accCntnt">
                    <table class="form_tabel">
                        <tr><td class="td_left">Judul</td><td class="td_right"><textarea class="stext" name="NEWS[JUDUL]" title="Judul Berita"><?php echo $sess['JUDUL']; ?></textarea></td></tr>
                        <tr><td class="td_left">Headline</td><td class="td_right"><textarea class="stext" name="NEWS[HEADLINE]" title="Headline Berita"><?php echo $sess['HEADLINE']; ?></textarea></td></tr>
                        <tr><td class="td_left">Isi Berita</td><td class="td_right"><textarea class="stext chk" name="NEWS[KONTEN]" title="Isi Berita"><?php echo $sess['KONTEN']; ?></textarea></td></tr>
                    </table>
                </div>
		</div>        
        <div style="height:10px"></div>
        <div><a href="#" class="button save" onclick="fpost('#form-berita','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div> 
    </div>
</div>
<?php
if(array_key_exists('NEWS_ID', $sess)){
	?>
    <input type="hidden" name="NEWS_ID" value="<?php echo $sess['NEWS_ID']; ?>" />
    <?
}
?>
</form>
</div>