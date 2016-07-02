<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulpetugas" class="judul"></div>
<div class="content">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><b><?php echo $header; ?></b></div>
        <div class="collapse">
                <div class="accCntnt">
                <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpetugas">
                <input type="hidden" name="surat" value="<?php echo $SURAT_ID; ?>" />
                <input type="hidden" name="user" value="<?php echo $sess['USER_ID']; ?>" />
                <input type="hidden" name="url" value="<?php echo $url; ?>" />
                <input type="hidden" id="bpomid" value="<?php echo $bpomid; ?>" />
                <table class="form_tabel">
                	<tr><td class="td_left">Nama Petugas</td><td class="td_right"><input type="text" id="nama" value="<?php echo $sess['NAMA_USER']; ?>" class="stext" rel="required" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Isi dengan nama petugas yang akan ditambahkan atau di edit" />&nbsp;<input type="hidden" name="SURAT[USER_ID]" id="user_id" value="<?php echo $sess['USER_ID']; ?>"/></td></tr>
                </table>
                <div style="height:5px;"></div><div><a href="#" class="button save" onclick="fpost('#fpetugas','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="kembali(); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
                </form>

                <div style="height:5px;"></div>
                <?php echo $tabel; ?>
                </div>
		</div>
    	
    </div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#nama").autocomplete($("#nama").attr("url")+$("#bpomid").val(), {width: 244, selectFirst: false}); 
		$("#nama").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2])
				$("#user_id").val(data[1]);
			}
		});        
    });
</script>