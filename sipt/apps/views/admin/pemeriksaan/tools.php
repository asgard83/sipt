<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div id="judulpmnsarana" class="judul"></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><b>Tools Pemeriksaan Sarana</b></div>
      <div class="collapse">
        <div class="accCntnt">
          <div id="tabs">
            <ul>
              <li><a href="#tabs-1">Mutasi Operator Pemeriksaan</a></li>
              <?php
			  if($this->newsession->userdata('SESS_USER_ID') == '102155'){
			  ?>
              <li><a href="#tabs-2">Timeline Pemeriksaan Sarana</a></li>
              <li><a href="#tabs-3">Rekap Data Pemeriksaan</a></li>
              <?php
			  }
			  ?>
            </ul>
            <!-- Mutasi !-->
            <div id="tabs-1">
              <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
                <p>Tools ini digunakan untuk perpindahan atau mutasi operator pemeriksaan sarana yang pindah tugas dari satu balai ke balai yang lain.</p>
                <p>Silahkan masukan NIP atau nama petugas pada form berikut ini :</p>
              </div>
              <div style="height:5px;">&nbsp;</div>
              <form id="fmutasi" action="<?php echo site_url(); ?>/utility/tools/mutasi_act/mutasi-sarana/save" name="fmutasi">
                <table class="form_tabel">
                  <tr>
                    <td class="td_left atas isi">NIP / Nama Petugas</td>
                    <td class="td_right"><input type="text" class="stext" name="nama" id="nama" title="Masukan NIP atau pegawai yang akan mutasi atau pindah" url="<?php echo site_url(); ?>/utility/tools/get_nama" />
                      <input type="hidden" name="nip" id="nip" />
                      &nbsp;&nbsp;<span id="span-chk" style="display:none;">
                      <input type="checkbox" id="chk_nip" />
                      &nbsp;Ganti Petugas</span></td>
                  </tr>
                </table>
                <div style="height:5px;">&nbsp;</div>
                <div id="show-nama" style="display:none;">
                  <table class="form_tabel">
                    <tr>
                      <td class="td_left">Asal Balai</td>
                      <td class="td_right atas isi" id="balai"></td>
                    </tr>
                    <tr>
                      <td class="td_left">Total data yang sudah di entri</td>
                      <td class="td_right atas isi" id="jml"></td>
                    </tr>
                    <tr>
                      <td class="td_left">Didisposisikan ke Petugas Baru</td>
                      <td class="td_right atas isi"><input type="text" class="stext" title="Petugas yang ditunjuk untuk mengganti petugas di atas" id="newnama" name="newnama" url="<?php echo site_url(); ?>/utility/tools/get_nama" />
                        <input type="hidden" name="newnip" id="newnip" /></td>
                    </tr>
                  </table>
                  <input type="hidden" name="bbpomid" id="bbpomid" />
                </div>
              </form>
              <div><a href="#" class="button reload" onclick="fpost('#fmutasi','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a></div>
            </div>
            <?php
			if($this->newsession->userdata('SESS_USER_ID') == '102155'){
			?>
            <div id="tabs-2">
              <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
                <p>Tools ini digunakan untuk time line pemeriksaan sarana</p>
                <p style="padding-top:5px;"><input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
                &nbsp;Mulai Mapping Data, Interval&nbsp;&nbsp;
                <input type="text" class="sdate" name="intreset" id="intreset" value="1" title="Interval timer"></p>
                <div style="height:2px;">&nbsp;</div>
                <div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
                <div style="height:2px;">&nbsp;</div>
                <ul id="isi" style="list-style:none; padding:0px; margin-left:5px;">
                </ul>
              </div>
            </div>
            <div id="tabs-3">
              <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
                <p>Tools ini digunakan untuk melakukan rekap data sarana</p>
                <p style="padding-top:5px;"><input type="checkbox" name="chk_start" id="chk_start" onChange="fstart();">
                &nbsp;Mulai Mapping Data, Interval&nbsp;&nbsp;
                <input type="text" class="sdate" name="intreset" id="intreset" value="1" title="Interval timer"></p>
                <div style="height:2px;">&nbsp;</div>
                <div id="timer_reset" style="padding-top:5px; padding-bottom:5px;"></div>
                <div style="height:2px;">&nbsp;</div>
                <ul id="isi" style="list-style:none; padding:0px; margin-left:5px;">
                </ul>
              </div>
            </div>
          <?php
			}
			?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
	var stratreset = false;
	var ids = '<?= $periksaid; ?>';
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
			var url = '<?= site_url();?>/utility/tools/get_timelinesarana/' + arrid[idx];
			var percent = 0;
			$.get(url, function(data){
				arrdata = data.split('#'); 
				if(arrdata[0].trim()=='OK'){
					percent = parseFloat((idx) / arrid.length) * 100;
					$("ul#isi").html(arrdata[1]);
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
	$(document).ready(function(e){
		$("#nama").autocomplete($("#nama").attr('url'), {width: 244, selectFirst: false});
		$("#nama").result(function(event, data, formatted){
			if(data){
				$(this).val(data[1]);
				$("#nip").val(data[2]);
				$.get(isUrl  + 'index.php/utility/tools/get_createpemeriksaan/' + data[2], function(hasil){
					if(hasil){
						var arrdata = hasil.split('#');
						$("#show-nama").fadeIn(500);
						$("#balai").html(arrdata[0]);
						$("#jml").html(arrdata[1]);
						$("#bbpomid").val(arrdata[2]);
						$("#span-chk").fadeIn(500);
						$("#chk_nip").attr("checked",true);
						$("#newnama").autocomplete($("#newnama").attr('url') + '/' + arrdata[2], {width: 244, selectFirst: false});
						$("#newnama").result(function(event, dt, formatted){
							if(dt){
								$(this).val(dt[1]);
								$("#newnip").val(dt[2]);
							}
						});
						$("#chk_nip").change(function(){
							if(!$(this).is(':checked')){
								$("#show-nama").fadeOut(500);
								$("#nama").val('');
								$("#nip").val('');
								$("#newnama").val('');
								$("#newnip").val('');
								$("#span-chk").fadeOut(500);
								$("#chk_nip").removeAttr("checked");
								$("#balai").html('');
								$("#jml").html('');
								$("#bbpom-id").val('');
							}
						});
					}
				});
			}
		});
	});
</script>