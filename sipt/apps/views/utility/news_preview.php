<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b>Berita Update Aplikasi</b></div>
        <div class="collapse">
                <div class="accCntnt">
                    <table class="form_tabel">
                        <tr><td colspan="2" class="atas isi"><?php echo $sess['JUDUL']; ?></td></tr>
                        <tr><td colspan="2"><?php echo $sess['KONTEN']; ?></td></tr>
                    </table>
                </div>
		</div>        
        <div style="height:10px"></div>
    </div>
</div>
</div>