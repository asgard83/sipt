<div style="width:100%; padding:5px;">
  <!--<div><b>Roolback Data SPU ke TPS</b></div>
  <div style="padding:5px;">
    <input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
    &nbsp;Start Roolback, Interval&nbsp;&nbsp;
    <input type="text" class="sdate" name="intreset" id="intreset" value="5" title="Interval timer">
    <div style="height:2px;">&nbsp;</div>
    <div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
    <div style="height:2px;">&nbsp;</div>
    <ul id="isi" style="list-style:none; padding:0px; margin-left:5px;">
    </ul>
  </div>
  <hr />
  <div style="height:5px;">&nbsp;</div>-->
  <div><b>Roolback Nomor SPU Ke TPS</b></div>
  <div style="height:5px;">&nbsp;</div>
  <form action="<?php echo site_url(); ?>/utility/tools/set_tps/first" id="ftps" name="ftps" method="post"> 
    <input type="text" class="stext" id="spu_id" name="spu_id" title="Masukan Nomor SPU yang akan di roolback" rel="required" />
    <div style="padding-top:5px; padding-bottom:5px;"><b>Tujuan Roolback</b></div>
    <?php echo form_dropdown('cbspu',$tujuan,'','class="stext" title="Pilih tujuan roolback data spu" rel="required"'); ?>
    <div style="padding-top:5px;"></div>
    <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button reload" id="btn-proses" onclick="save_tps('#ftps'); return false;"><span><span class="icon"></span>&nbsp; Check Data &nbsp;</span></a></div>
    <div style="padding-top:5px;"></div>
    <div id="ret-tps"></div>
  </form>
</div>
<script>
	var stratreset = false;
	var ids = '<?= $spuid; ?>';
	arrid = ids.split('|');
	var idx = 0;
	
	function fstart(){
		if($('#chk_start').attr("checked")){
			$('#chk_start').attr("checked", "checked");
			var bar = $("#intreset").val(),
			loaded = bar;
			var load = function(){
				if(loaded>0) $('#timer_reset').html(loaded + ' ... Mohon tunggu <img src="'+isUrl+'/images/_indicator.gif" alt="loading" align="absmiddle"  />');
				if(loaded==0){
					clearInterval(beginLoad);
					$('#timer_reset').html('');
					stratreset = true;
					set_kode();
				}
				loaded -= 1;
			}
			var beginLoad = setInterval(function(){ load(); }, 5000);
		}else{
			$('#chk_start').removeAttr("checked");
			stratreset = false;
		}
	}
	
	function set_kode(){
		if(stratreset===false) return false;
		if(idx<arrid.length){
			var url = '<?= site_url();?>/utility/tools/get_roolbackspu/' + arrid[idx];
			var percent = 0;
			$.get(url, function(data){
				arrdata = data.split('#'); 
				if(arrdata[0].trim()=='OK'){
					percent = parseFloat((idx) / arrid.length) * 100;
					$("ul#isi").html('<li>'+arrdata[1]+'</li>');
					$('#timer_reset').html('Proses Data ' + idx + ' Dari ' + arrid.length + ' : ' + arrdata[2] + ' ( '+ percent.toFixed(2) +' %)');
				}
				idx++;
				set_kode();
			});
		}else{
			stratreset = false;
			$('#timer_reset').html('Complete');
			$("ul#isi").html('');
		}
		return false;
	}
	
	function save_tps(formid){
		var jumlah = 0; 
		$.each($(formid+" input:visible, select:visible, textarea:visible"), function(){
			if($(this).attr('rel')){
				if($(this).attr('rel')=="required" && ($(this).val()=="" || $(this).val()==null)){
					$(this).css('background-color','#FBE3E4');
					$(this).css('border','1px solid #F00'); 
					jumlah++;
				}
			}
		});
		if(jumlah > 0){
			jAlert('Maaf, ada ' + jumlah + ' kolom yang harus diisi', 'SIPT Versi 1.0');
			return false;
		}else{
			$.ajax({
				type: "POST", 
				url: $(formid).attr('action') + '/ajax', 
				data: $(formid).serialize(),
				error: function(){ 
					jAlert('Maaf, Request halaman tidak ditemukan', 'SIPT Versi 1.0'); 
				}, 
				beforeSend: function(){
					jLoadingOpen('','SIPT Versi 1.0');
				}, 
				complete: function(){ 
					jLoadingClose();
				},
				success: function(data){
					if(data){
						$("#ret-tps").html(data);
					}
				}
			});
		}
	}

</script> 
