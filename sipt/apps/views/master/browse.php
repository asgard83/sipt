<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" /><link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" /><link type="text/css" href="<?php echo base_url();?>css/newtable.css" rel="stylesheet" /><link type="text/css" href="<?php echo base_url();?>css/jquery.alerts.css" rel="stylesheet" /><script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/jquery.poshytip.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/jquery.autocomplete.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/newtable.js"></script>
<script>
	$(document).ready(function(e) {
        $("#proses_sarana").click(function(){
			var chk = $(".tb_chk:checked").length;
			if(chk==0){
				jAlert('Maaf, Data belum dipilih.', 'SIPT Versi 1.0');
				return false;
			}
			if(chk > 1){
				jAlert('Maaf, Data yang bisa diproses hanya 1 (satu).', 'SIPT Versi 1.0');
				return false;
			}
			var ref_data = $(".tb_chk:checked").val().split(".");
			if(ref_data.length > 2){
				var nama_sarana = new Array();
				for(var i=1; i < ref_data.length; i++){
					nama_sarana.push(ref_data[i]);
				}
				nama_sarana.join("");
				window.opener.document.fpemeriksaan_.saranaid_.value = nama_sarana;
			}else{
				window.opener.document.fpemeriksaan_.saranaid_.value = ref_data[1];
			}
			window.opener.document.fpemeriksaan_.saranaidval_.value = ref_data[0];
			window.close(); return false;
		});
		
		$("#capture_prioritas").click(function(){
			var chk = $(".tb_chk:checked").length;
			if(chk==0){
				jAlert('Maaf, Data belum dipilih.', 'SIPT Versi 1.0');
				return false;
			}
			if(chk > 1){
				jAlert('Maaf, Data yang bisa diproses hanya 1 (satu).', 'SIPT Versi 1.0');
				return false;
			}
			var ids = $(".tb_chk:checked").val();
			if(ids){
				$.get('<?php echo site_url(); ?>/get/pengujian/get_prioritas/' + ids, function(hasil){
					if(hasil){
						var arrhasil = hasil.split('|');
						window.opener.document.fspk.parameter.value = arrhasil[0];
						window.opener.document.fspk.metode.value = (arrhasil[1] == '' ? '-' : arrhasil[1]);
						window.opener.document.fspk.pustaka.value = (arrhasil[2] == '' ? '-' : arrhasil[2]);
						window.opener.document.fspk.syarat.value = (arrhasil[3] == '' ? '-' : arrhasil[3]);
						window.opener.document.fspk.rlingkup.value = (arrhasil[4] == '' ? '-' : arrhasil[4]);
						window.opener.document.fspk.biduji.value = arrhasil[5];
						window.opener.document.fspk.golongan.value = arrhasil[6];
						window.opener.document.fspk.srlid.value = arrhasil[7];
						window.opener.document.fspk.kategori_pu.value = arrhasil[8];
						window.opener.document.fspk.simulan.value = arrhasil[9];
						window.close(); 
					}
				});
			}else{
				return false;
			}
		});
    });
</script>
<body>
<div class="content">
<?php echo $tabel; ?>
<?php if($button){ ?>
<div style="padding-bottom:5px; padding-top:5px;"><button type="submit" class="btn primary" id="<?php echo $id; ?>" title="Klik disini untuk melanjutkan proses pemilihan sarana" >Pilih</button></div>
<?php } ?>
</div>
</body>
</head>
</html>