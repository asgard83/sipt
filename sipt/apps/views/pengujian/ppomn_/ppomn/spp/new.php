<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH PENGUJIAN</a></div>
      <div class="accCntnt">
        <?php
					$jml = count($arr);
					if($jml > 0){
					?>
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
              <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Kerja" name="SPP[TANGGAL]" rel="required" /></td>
              <td>&nbsp;</td>
              <td class="td_left">&nbsp;</td>
              <td class="td_right">&nbsp;</td>
            </tr>
          </table>
          <h2 class="small garis">Daftar Sampel</h2>
          <div style="height:5px;"></div>
          <div>
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
              <tbody>
                <?php 
                       $no = 1;
					   for($i=0; $i<$jml; $i++){
						   
						   ?>
                <tr id="<?php echo $arr[$i]['UJI_ID']; ?>">
                  <td><input type="checkbox" class="chk_sampel" value="<?php echo $arr[$i]['UJI_ID']; ?>" /></td>
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
                       ?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="7"> <div>Nama Penguji : </div>
                    <div>
                      <input type="text" class="stext penguji" title="Ketikan nama penguji, kemudian pilih salah satu penguji dan tekan enter." id="ac_penguji"  url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/2/<?php echo $nospu; ?>" />
                      <input type="hidden" id="penguji" />
                      &nbsp;<a href="#" class="button" onclick="get_sampel(); return false;"><span><span class="icon"></span>&nbsp; Tambah Penguji &nbsp;</span></a></div></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div style="height:5px;">&nbsp;</div>
          <h2 class="small garis">Daftar Penguji Sampel</h2>
          <table class="listtemuan" width="100%" id="draft-sampel">
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
            <tbody>
            </tbody>
          </table>
          <input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
          <input type="hidden" name="spuid" value="<?php echo $spuid; ?>" />
        </form>
      </div>
      <!-- Akhir Informasi SPU!--> 
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button check" onclick="fpost('#fspp','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <?php
        }else{
            ?>
  </div>
</div>
<div><b>Tidak Ada Data Sampel</b></div>
<div style="height:5px;">&nbsp;</div>
<div style="padding-left:5px;"><a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<?php
        }
        ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var checked = false;
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