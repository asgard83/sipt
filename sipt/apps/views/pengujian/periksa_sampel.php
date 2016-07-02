<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <form name="fpemeriksaan_" id="fpemeriksaan_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN SAMPEL</a></div>
            <div class="collapse">
                <div class="accCntnt">
                    <h2 class="small garis">Data Pemeriksaan Sampel</h2>
                    <table class="form_tabel">
                        <tr><td class="td_left nomor">Nomor Surat Tugas</td><td class="td_right"><input type="text" class="stext" title="Nomor Surat Tugas" name="SURAT[NOMOR]" value="<?php echo $NOMOR; ?>" rel="required" id="nomor_surat" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_surat" /><input type="hidden" name="surat_id" id="surat_id" value="<?php echo $SURAT_ID; ?>" /></td></tr>
                        <tr><td class="td_left surat">Tanggal Surat Tugas</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Tugas" name="SURAT[TANGGAL]" rel="required" id="tanggal_surat" value="<?php echo $TANGGAL; ?>" /></td></tr>
                        <tr><td class="td_left">Anggaran Sampling</td><td class="td_right"><?php echo form_dropdown('SURAT[ANGGARAN]',$anggaran,$ANGGARAN_SAMPLING ? '' : '01','class="stext" rel="required" title="Anggaran Sampling" id="anggaran_sampling"'); ?></td></tr>
                        <tr><td class="td_left">Bulan Anggaran</td><td class="td_right"><?php echo form_dropdown('SURAT[BULAN_ANGGARAN]',$bulan,$BULAN_ANGGARAN ? $BULAN_ANGGARAN : '','class="stext" rel="required" title="Bulan Anggaran" id="bulan"'); ?></td></tr>
                        <?php 
						if($SURAT_ID != ""){
							?>
                            <tr><td class="td_left">Petugas Sampling</td><td class="td_right">
							<?php 
                            $jml = count($PETUGAS);
                            if($jml > 0){
                                foreach($PETUGAS as $p){
                                    echo "<p>&bull; &nbsp;". $p."</p>";
                                }
                            }else{
                                echo "-";
                            }
                            ?>
                            </td></tr>
                            <?php
						}else{
						?>
                        <tr><td class="td_left petugas">Petugas Sampling</td><td class="td_right"><input type="text" class="stext operator" id="operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas." /><ul style="list-style:none; margin:0px; padding:0px;" id="petugas"></ul></td></tr>
                        <tr id="tr_petugas"><td class="td_left">&nbsp;</td><td class="td_right"><ul style="list-style:none; margin:0px; padding:0px;" id="urut0"></ul></td></tr>
                        <?php
						}
						?>
                        <tr><td class="td_left">Asal Sampel</td><td class="td_right"><?php echo form_dropdown('PERIKSA_SAMPLING[ASAL_SAMPLING]',$asal,'','class="stext" title="Asal Sampling" id="asal_sampling" rel="required"'); ?></td></tr>
                        <tr><td class="td_left">Tujuan Sampling</td><td class="td_right"><?php echo form_dropdown('PERIKSA_SAMPLING[TUJUAN_SAMPLING]',$tujuan,'','class="stext" title="Tujuan Sampling" rel="required"'); ?></td></tr>
                         <tr><td class="td_left">Tanggal Sampling</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Awal Sampling" name="PERIKSA_SAMPLING[TANGGAL_AWAL_SAMPLING]" rel="required" />&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<input type="text" class="sdate" title="Tanggal Akhir Sampling" name="PERIKSA_SAMPLING[TANGGAL_AKHIR_SAMPLING]" rel="required" /></td></tr>
                         <tr><td class="td_left">Tempat Sampling</td><td class="td_right"><input type="text" class="stext" name="saranaid_" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" rel="required"/><input type="hidden" name="saranaidval_" id="saranaidval_"/>&nbsp;&nbsp;&nbsp;<a href="#" id="browse" url="<?php echo $browse; ?>" onclick="PopupCenter('#browse'); return false;" judul="Master_Data_Sarana" lebar="900" tinggi="480"><img src="<?php echo base_url(); ?>images/info.png" align="top" title="Tampilkan data sarana" style="border:none;" /></a><div></div></td></tr>   
                    </table>
                </div>
            </div><!-- Akhir Informasi Pemeriksaan Sampel !-->
            <div style="height:5px;">&nbsp;</div>
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGIRIM</a></div>
                <div class="accCntnt">
                    <div class="pihak-3-swasta-pemerintah">
                        <h2 class="small garis">Data Pengirim Sampel</h2>
                        <table class="form_tabel">
                            <tr><td class="td_left">Nama Pengirim</td><td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_rutin" id="nama_pengirim" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" /></td></tr>
                            <tr><td class="td_left">NIP</td><td class="td_right"><input type="text" class="stext" title="NIP" name="nip_rutin" id="nip_rutin" /></td></tr>
                        </table>
                    </div>
                    <div class="pihak-3-polisi" style="display:none;">
                        <h2 class="small garis">Data Pengirim Pihak Ke 3 Kepolisian</h2>
                        <table class="form_tabel" id="dt-pengirim">
                        <!--<tr><td class="td_left">No. Surat Pengantar</td><td class="td_right"><input type="text" class="stext" title="No. Kode Polisi" name="ASAL[NOMOR_PENGANTAR]" /></td></tr>-->
                        
                        <tr><td class="td_left">Nama Pengirim</td><td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_polisi" /></td></tr>
                        <tr><td class="td_left">NIP / NRP</td><td class="td_right"><input type="text" class="stext" title="NIP / NRP" name="nip_polisi" /></td></tr>
                        <tr><td class="td_left">Pangkat</td><td class="td_right"><input type="text" class="stext" title="Pangkat" name="ASAL[PANGKAT]" /></td></tr>
                        <tr><td class="td_left">Alamat Kepolisian</td><td class="td_right"><input type="text" class="stext" title="Alamat Kepolisian" name="ASAL[ALAMAT_KEPOLISIAN]" /></td></tr>
                        <tr><td class="td_left">No. LP</td><td class="td_right"><input type="text" class="stext" title="No. LP" name="ASAL[NO_LP]" /></td></tr>
                        <tr><td class="td_left">Tanggal LP</td><td class="td_right"><input type="text" class="sdate" title="Tanggal LP" name="ASAL[TANGGAL_LP]" /></td></tr>
                        <tr><td class="td_left">No. SPDP</td><td class="td_right"><input type="text" class="stext" title="Surat Pemberitahuan Dimulainya Penyidikan" name="ASAL[NO_SPDP]" /></td></tr>
                        <tr><td class="td_left">Tanggal SPDP</td><td class="td_right"><input type="text" class="sdate" title="Tanggal SPDP" name="ASAL[TANGGAL_SPDP]" /></td></tr>
                        <tr><td class="td_left">Nama Tersangka</td><td class="td_right"><input type="text" class="stext" title="Nama Tersangka, jika lebih dari satu pisahkan dengan titik koma" name="ASAL[NAMA_TERSANGKA]" /></td></tr>
                        <tr><td class="td_left">Kota</td><td class="td_right"><input type="text" class="stext" title="Kota" name="ASAL[KOTA]" /></td></tr>
                        <tr><td class="td_left">Nama Saksi</td><td class="td_right"><input type="text" class="stext" title="Saksi, jika lebih dari satu pisahkan dengan titik koma" name="ASAL[NAMA_SAKSI]" /></td></tr>
                        <tr><td class="td_left">Tanggal Terima</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Terima" name="ASAL[TANGGAL_TERIMA]" /></td></tr>
                        <tr><td class="td_left">Hari Terima</td><td class="td_right"><input type="text" class="stext" title="Hari Terima" name="ASAL[HARI_TERIMA]" /></td></tr>
                        <tr><td class="td_left">Saksi Pengujian</td><td class="td_right"><input type="text" class="stext" title="Saksi Pengujian, jika lebih dari satu pisahkan dengan titik koma" name="ASAL[SAKSI_PENGUJI]" /></td></tr>
                        <tr><td class="td_left">Jumlah Sampel Di Surat Permintaan Uji</td><td class="td_right"><input type="text" class="stext w100" title="jumlah" name="ASAL[JUMLAH_DIUJI]" /></td></tr>
                        <tr><td class="td_left">Catatan</td><td class="td_right"><textarea class="stext" name="ASAL[CATATAN]" title="Catatan atau keterangan"></textarea></td></tr>
                        </table>
                    </div>
                    
                    <div class="biaya-pihak-ke-3" style="display:none;">
                      <table class="form_tabel">
                          <tr><td class="td_left">Biaya</td><td class="td_right"><input type="text" class="stext w100" title="Biaya" name="ASAL[BIAYA]" /></td></tr>                        
                          <tr><td class="td_left">No. Resi Bank</td><td class="td_right"><input type="text" class="stext" title="No. Resi Bank" name="ASAL[NO_RESI_BANK]" /></td></tr>
                          <tr><td class="td_left">Tanggal Resi Bank</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Resi" name="ASAL[TANGGAL_RESI_BANK]" /></td></tr>
                      </table>
                    </div>
                </div>
            <!-- Akhir Informasi Pengirim Sampel!-->
        </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fpemeriksaan_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#saranaid_").autocomplete($("#saranaid_").attr("url"), {width: 244, selectFirst: false}); 
	$("#saranaid_").result(function(event, data, formatted){ 
		if(data){ 
			$(this).val(data[2]);
			$("#saranaidval_").val(data[1]); 
			$("#input.operator").focus();
		} 
	});
	$("input.operator").autocomplete($("input.operator").attr("url")+'<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>', {width: 244, selectFirst: false}); 
	$("input.operator").result(function(event, data, formatted){ 
		if(data){ 
			$("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="USER_ID[]" value="'+data[1]+'"></li>'); 
			$(this).val(''); $(this).focus(); 
		} 
	});
	
	$("#nomor_surat").autocomplete($("#nomor_surat").attr("url"), {width: 244, selectFirst: false}); 
	$("#nomor_surat").result(function(event, data, formatted){ 
		if(data){ 
			$(this).val(data[2]);
			$("#surat_id").val(data[1]); 
			$("#tanggal_surat").val(data[3]);
			$("#anggaran_sampling").val(data[4]);
			$("#bulan").val(data[5]);
			$("#asal_sampling").focus();
			$.get(isUrl + 'index.php/autocompletes/autocomplete/petugas_sampling/' + data[1], function(hasil){
				hasil = $.trim(hasil);
				if(hasil==""){
					return false;
				}
				var str = "";
				var arrcol = hasil.split(';');
				for(i=0;i<arrcol.length;i++){
					var arrdata = arrcol[i].split('|');
					str += '<li style="padding-bottom:5px;" id="'+arrdata[0]+'">'+arrdata[1]+'<input type="hidden" name="USER_ID[]" value="'+arrdata[1]+'"></li>'
				}
				$("#operator").css("display","none");
				$("tr#tr_petugas").css("display","none");
				$("ul#petugas").append(str);
			});
		} 
	});
	
	$("#nama_pengirim").autocomplete($("#nama_pengirim").attr("url")+'<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>', {width: 244, selectFirst: false}); 
	$("#nama_pengirim").result(function(event, data, formatted){ 
		if(data){
			$(this).val(data[2]);
			$("#nip_rutin").val(data[1]);
		} 
	});
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("#anggaran_sampling").change(function(){
		var val = $(this).val();
		if(val == "05"){
			$(".pihak-3-polisi").css("display","");
			$(".pihak-3-swasta-pemerintah").css("display","none");
		}else{
			$(".pihak-3-polisi").css("display","none");
			$(".pihak-3-swasta-pemerintah").css("display","");
		}
		if(val == "05" || val == "06" || val == "07"){
			$(".biaya-pihak-ke-3").css("display","");
			$(".surat").html('Tanggal Surat Pengantar');
			$(".petugas").html('Petugas Penerima Sampel');
			$(".nomor").html('Nomor Surat Pengantar');
		}else{
			$(".biaya-pihak-ke-3").css("display","none");
			$(".surat").html('Tanggal Surat Tugas');
			$(".petugas").html('Petugas Sampling');
			$(".nomor").html('Nomor Surat Tugas');
		}
		return false;
	});
});
</script>            