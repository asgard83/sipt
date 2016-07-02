<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
$jml = count($arr);
?>
<link type="text/css" href="<?php echo base_url();?>css/tablesorter.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH PENGUJIAN</a></div>
      <div class="accCntnt">
        <form name="fspp" id="fspp" method="post" action="<?php echo $act; ?>" autocomplete="off">
          <table class="form_tabel">
            <tr>
              <td class="td_left">Nomor Surat Permintaan Uji</td>
              <td class="td_right bold" width="300"><?php echo $dtspk[0]['UR_SPU']; ?></td>
              <td width="10">&nbsp;</td>
              <td class="td_left">Tanggal Surat Permintaan Uji</td>
              <td class="td_right bold"><?php echo $dtspk[0]['TANGGAL_SPU']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Nomor Surat Perintah Kerja</td>
              <td class="td_right bold"><?php echo $dtspk[0]['UR_SPK']; ?></td>
              <td>&nbsp;</td>
              <td class="td_left">Tanggal Surat Perintah Kerja</td>
              <td class="td_right bold"><?php echo $dtspk[0]['TANGGAL_SPK']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Pengirim Surat Perintah Kerja</td>
              <td class="td_right bold"><?php echo $dtspk[0]['NAMA_USER']; ?></td>
              <td>&nbsp;</td>
              <td class="td_left">&nbsp;</td>
              <td class="td_right">&nbsp;</td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Surat Perintah Pengujian</td>
              <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Kerja" id="tanggal_spp" name="SPP[TANGGAL]" rel="required" /></td>
              <td>&nbsp;</td>
              <td class="td_left">&nbsp;</td>
              <td class="td_right">&nbsp;</td>
            </tr>
          </table>
          <h2 class="small garis">Daftar Sampel</h2>
          <div style="height:5px;"></div>
          <div>
            <input type="checkbox" id="chk_revisi" />
            &nbsp;<font style="font-weight:bold; color:#F00;">Jika terjadi kesalahan dalam penentuan parameter uji, silahkan klik checklist di samping kiri untuk melakukan permohonan review ulang parameter uji.</font>
            <div style="height:5px;">&nbsp;</div>
            <table class="form_tabel" id="tb_revisi" style="display:none;">
              <tr>
                <td class="td_left bold">Catatan Revisi</td>
                <td class="td_right"><textarea class="stext catatan" title="Catatan kesalahan penentuan parameter uji" name="CATATAN" id="catatan_revisi"></textarea></td>
              </tr>
              <tr>
                <td class="td_left bold" colspan="2">Kemudian tandai parameter uji yang akan dilakukan review ulang pada daftar sampel di bawah ini</td>
              </tr>
            </table>
            <div style="height:5px;">&nbsp;</div>
          </div>
          <div style="height:5px;"></div>
          <div id="list_pu">
            <table class="listtemuan" width="100%" id="list-sampel">
              <thead>
                <tr>
                  <th width="14"><input type="checkbox" title="Pilih semua data" id="chk_sampel_all" /></th>
                  <th width="80">Kode Sampel</th>
                  <th width="200">Nama Sampel</th>
                  <th width="300">Komoditi</th>
                  <th width="200">Parameter Uji</th>
                  <th width="100">Metode</th>
                  <th width="100">Pustaka</th>
                </tr>
              </thead>
              <tbody id="tbodylist-sampel">
                <?php 
					  if($jml > 0){
                       $no = 1;
					   for($i=0; $i<$jml; $i++){
						   
						   ?>
                <tr id="<?php echo $arr[$i]['UJI_ID']; ?>">
                  <td><input type="checkbox" class="chk_sampel" name="chk_uji[]" value="<?php echo $arr[$i]['UJI_ID']; ?>" /></td>
                  <td><?php echo $arr[$i]['KODE_SAMPEL']; ?></td>
                  <td><?php echo $arr[$i]['NAMA_SAMPEL']; ?></td>
                  <td><?php echo $arr[$i]['KOMODITI']; ?></td>
                  <td><?php echo $arr[$i]['PARAM']; ?></td>
                  <td><?php echo $arr[$i]['METODE']; ?></td>
                  <td><?php echo $arr[$i]['PUSTAKA']; ?></td>
                </tr>
                <?php
						   $no++;
					   }
					  }else{
						  ?>
                          <tr>
                          	<td colspan="7"><b>Detail Parameter Uji Tidak Ditemukan</b></td>
                          </tr>
                          <?php
					  }
                       ?>
              </tbody>
              <tfoot id="div-penguji">
                <tr>
                  <th colspan="7"> <div>Nama Penguji : </div>
                    <div>
                      <input type="text" class="stext penguji" title="Ketikan nama penguji, kemudian pilih salah satu penguji dan tekan enter." id="ac_penguji"  url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/2/<?php echo $spuid; ?>" />
                      <input type="hidden" id="penguji" />
                      &nbsp;<a href="#" class="button" onclick="get_sampel(); return false;"><span><span class="icon"></span>&nbsp; Tambah Penguji &nbsp;</span></a></div></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div style="height:5px;">&nbsp;</div>
          <h2 class="small garis">Daftar Penguji Sampel</h2>
          <table class="listtemuan" width="100%">
            <thead>
              <tr>
                <th width="80">Kode Sampel</th>
                <th width="300">Parameter Uji</th>
                <th width="100">Metode</th>
                <th width="100">Pustaka</th>
                <th width="200">Penguji</th>
                <th width="50">Opsi</th>
              </tr>
            </thead>
            <tbody id="draft-sampel">
            </tbody>
          </table>
          <div style="height:10px;"></div>
          <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_spk/<?php echo $spkid; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log SPK (
            <?= $logspk; ?>
            )</a></h2>
          <div id="detail_log"></div>
          <input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
          <input type="hidden" name="spuid" value="<?php echo $spuid; ?>" />
          <input type="hidden" name="spkid" value="<?php echo $spkid; ?>" />
          <input type="hidden" name="kode_sampel" value="<?php echo $kode_sampel; ?>" />
        </form>
         <div style="height:10px;">&nbsp;</div>
         <div style="padding-left:5px;"><a href="#" class="button reload" style="display:none;" id="btn_revisi" onclick="fpost('#fspp','',''); return false;"><span><span class="icon"></span>&nbsp; Permohonan Review Ulang PU&nbsp;</span></a>&nbsp;<a href="#" class="button check" id="btn_proses" <?php echo $jml > 0 ? '' : 'style="display:none;"'; ?> onclick="fpost('#fspp','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
      </div>
      <!-- Akhir Informasi SPU!--> 
    </div>
  </div>
</div>

		

<script type="text/javascript">
$(document).ready(function(){
	var checked = false;
	//$("#list-sampel").tablesorter(); 
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("input.metode").autocomplete($("input.metode").attr('url') + $("input.metode").attr("kk"), {width: 244, selectFirst: false});
	$("input.metode").result(function(event, data, formatted){
		if(data){
			$(this).val(data[0]);
		}
	});
	$("input.penguji").autocomplete($("input.penguji").attr('url'), {width: 244, selectFirst: false});
	$("input.penguji").result(function(event, data, formatted){
		if(data){
			$("#penguji").val(data[1]);
			$(this).val(data[2]);
		}
	});
	$("#chk_sampel_all").click(function(){
		$("#list-sampel").find(':checkbox').attr('checked', this.checked);
		if(!this.checked){
			$("#list-sampel input:checkbox:not(#chk_sampel_all)").parent().parent().removeClass("selected");
		}else{
			$("#list-sampel input:checkbox:not(#chk_sampel_all)").parent().parent().addClass("selected");
		}
	});
	$(".chk_sampel").click(function(){
		checked = true;
		if(!this.checked){
			$(this).parent().parent().removeClass("selected");
			$("#chk_sampel_all").attr('checked', this.checked);
		}else{
			$(this).parent().parent().addClass("selected");
			if($("#list-sampel input:checkbox.tb_chk:checked").length == $("#list-sampel input:checkbox:not(#chk_sampel_all)").length) $("#chk_sampel_all").attr('checked', this.checked);
		}
	});
	$(".edit").live("click", function(){
		var tr = $(this).closest("tr").attr("id");
		$("#draft-sampel #"+tr).remove();
		$("#list-sampel #"+tr).show();
		return false;
	});
	$("#chk_revisi").change(function(){
		if($(this).attr("checked")){
			$("#fspp").attr("action", "<?php echo site_url().'/post/ppomn/spk_act/spk-tolak'; ?>");
			$("#tb_revisi").fadeIn(500);
			$("#btn_revisi").fadeIn(500);
			$("#btn_proses").fadeOut(500);
			$("#draft-sampel").fadeOut(500);
			$("#tanggal_spp").removeAttr("rel");
			$("#catatan_revisi").attr("rel","required");
			$("#div-penguji").fadeOut(500);
		}else{
			$("#fspp").attr("action", "<?php echo site_url().'/post/ppomn/spk_act/spp-save'; ?>");
			$("#tb_revisi").fadeOut(500);
			$("#btn_revisi").fadeOut(500);
			$("#btn_proses").fadeIn(500);
			$("#draft-sampel").fadeIn(500);
			$("#tanggal_spp").attr("rel","required");
			$("#catatan_revisi").removeAttr("rel");
			$("#div-penguji").fadeIn(500);
		}
	});

	
	
});

function get_sampel(){
	var chk = $("#list-sampel .chk_sampel:checked").length;
	if(chk == 0){
		jAlert('Maaf, Data sampel belum di pilih.', 'SIPT Versi 1.0');
		return false;
	}else{
		if($("#penguji").val() == ""){
			jAlert('Maaf, Anda belum memilih penguji.', 'SIPT Versi 1.0');
			return false;
		}
		$('.chk_sampel').each(function(){
			if($(this).is(':checked')){
				var tr = $(this).closest("tr").attr("id");
				var kode = $("#"+tr+" td:nth-child(2)").text();
				var params = $("#"+tr+" td:nth-child(5)").text();
				var metode = $("#"+tr+" td:nth-child(6)").text();
				var pustaka = $("#"+tr+" td:nth-child(7)").text();
				var ac_penguji = $("#ac_penguji").val();
				var penguji = $("#penguji").val();
				var clone  = '<tr id="'+tr+'">';
					clone += '<td>'+kode+'<input type="hidden" name="SPP_SAMPEL[UJI_ID][]" value="'+tr+'"></td>';
					clone += '<td>'+params+'</td>';
					clone += '<td>'+metode+'</td>';
					clone += '<td>'+pustaka+'</td>';
					clone += '<td>'+ac_penguji+'<input type="hidden" name="SPP_SAMPEL[PENGUJI][]" value="'+penguji+'"></td>';
					clone += '<td><a href="#" class="edit">Edit</a></td>';
				    clone += '</tr>';
				$("#draft-sampel").append(clone);
				$("#list-sampel #"+tr).hide();
			}
		});
		$("#ac_penguji").val('');
		$("#penguji").val('');
		$("#chk_sampel_all").attr('checked', false);
		$(".chk_sampel:checkbox").attr('checked', false);
	}
}

</script> 