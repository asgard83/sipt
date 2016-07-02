<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current"><?php echo $judul; ?></h2>
    <form action="<?php echo $act; ?>" autocomplete="off" method="post" id="rptsampel">
      <table class="form_tabel">
        <tr>
          <td class="td_left">Balai Besar / Balai POM</td>
          <td class="td_right"><?php echo form_dropdown('BBPOM_ID',$bbpom,'','class="stext" title="Pilih Balai Besar / Balai POM"'); ?></td>
        </tr>
        <tr>
          <td class="td_left">Komoditi</td>
          <td class="td_right"><?php echo form_dropdown('KOMODITI',$komoditi,'','class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required" data-prioritas="1"'); ?>&nbsp;<input type="checkbox" id="chkprioritas" checked="checked" />&nbsp;Prioritas Sampling Tahun Berjalan</td>
        </tr>
        <tr id="tr_kategori" style="display:none;"></tr>
        <tr>
          <td class="td_left">Periode Bulan Sampling</td>
          <td class="td_right"><?php echo form_dropdown('BULAN',$bulan,'','class="stext" style="width:100px;" title="Pilih salah satu periode bulan" rel="required"'); ?>&nbsp; &nbsp;Tahun&nbsp;&nbsp;&nbsp;<?php echo form_dropdown('TAHUN',$tahun,date("Y"),'class="stext" style="width:100px;" title="Pilih salah satu tahun sampling" rel="required"'); ?></td>
        </tr>
        <tr>
          <td class="td_left">Tujuan Sampling</td>
          <td class="td_right"><div style="padding-bottom:5px;"> <?php echo form_dropdown('TUJUAN_SAMPLING',$tujuan,'','class="stext" title="Tujuan Sampling" id="tujuan_sampling" url="'.site_url().'/autocompletes/autocomplete/get_tujuan_sampling/"'); ?> </div>
            <div id="div_tujuan" style="display:none;"> <?php echo form_dropdown('SUB_TUJUAN',$sub_tujuan,'','class="stext" title="Tujuan Sampling" id="sub_tujuan"'); ?> </div>
        </tr>
        <tr>
          <td class="td_left">Anggaran Sampling</td>
          <td class="td_right"><?php echo form_dropdown('ANGGARAN_SAMPLING',$anggaran,'','class="stext" title="Pilih salah satu anggaran sampling"'); ?></td>
        </tr>
        <tr>
          <td class="td_left">Asal Sampel</td>
          <td class="td_right"><?php echo form_dropdown('ASAL_SAMPLING',$asal,'','class="stext" title="Pilih salah satu asal pengirim sampel"'); ?></td>
        </tr>
      </table>
      <div style="padding:3px;">&nbsp;</div>
      <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button check" onclick="freport('#rptsampel'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    </form>
  </div>
</div>
<script>
	$(document).ready(function(e){
        $("#tujuan_sampling").change(function(){
			var kunci = $(this).val();
			var komoditi = $("#sel1 option:selected").val();
			if(komoditi == "") return false;
			if(kunci != "01" && kunci != "02"){
				$("#div_tujuan").hide();
				$("#sub_tujuan").html('');
			}else{
				if(komoditi == "10" || komoditi == "11" || komoditi == "12"){
					$("#div_tujuan").show();
					$.get($(this).attr("url") + komoditi + '/' + kunci, function(hasil){
						$("#sub_tujuan").html(hasil);
					});
				}else{
					$("#sub_tujuan").html('');
				}
			}
		});
		$("#chkprioritas").change(function(e){
            var $this = $(this);
			if($this.is(":checked")){
				$("#sel1").attr('data-prioritas','1');	
			}else{
				$("#sel1").attr('data-prioritas','0');	
			}
			$("#sel1").val('');
			if($("#tr_kategori").css("display","")){
				$("#tr_kategori").css("display","none");
				$("#sel2").val('');
			}
			return false;
        });
		
		$("#sel1").change(function(){
            var kunci = $(this).val();
			var prioritas = $(this).attr("data-prioritas");
			var urls = (parseInt(prioritas) == 1 ? '<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci + '/1' : '<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci + '/0');
			$.get(urls, function(hasil){
				var hasil = hasil.replace(' ', '');
				var jum = hasil.length;
				if(jum == 0){
					$("#tr_kategori").css('display','none');
					$("#tr_kategori").html('');
				}else{
					$("#tr_kategori").css('display','');
					$("#tr_kategori").html('<td class="td_left">Kategori sampel</td><td class="td_right"><?php echo str_replace(chr(10),'',form_dropdown('REKAP_KOMODITI',$kategori,'','class="stext komoditi" title="Kategori" id="sel2" ke="2"')); ?></td>');
					$('#sel2').html(hasil);
				}
			});
        });
			
		$("#tujuan_sampling").change(function(){
			var kunci = $(this).val();
			var komoditi = $("#sel1 option:selected").val();
			if(komoditi == ""){
				$("#div_tujuan").hide();
				$("#sub_tujuan").html('');
				$("#sub_tujuan").removeAttr("rel");
				return false;
			}else if(kunci != "01" && kunci != "02"){
				$("#div_tujuan").hide();
				$("#sub_tujuan").html('');
				$("#sub_tujuan").removeAttr("rel");
			}else{
				if(komoditi == "10" || komoditi == "11" || komoditi == "12"){
					$("#div_tujuan").show();
					$("#sub_tujuan").attr("rel", "required");
					$.get($(this).attr("url") + komoditi + '/' + kunci, function(hasil){
						$("#sub_tujuan").html(hasil);
					});
				}
			}
		});
    });
</script>