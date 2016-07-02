<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<table class="listtemuan" width="100%">
  <thead>
    <tr>
      <th>Komoditi</th>
      <th>Bidang Uji</th>
      <th>Nomor Terakhir</th>
      <th>Reset</th>
      <th width="80"><input type="checkbox" id="chk-all" data-balai = "<?php echo $balai; ?>" data-bidang = "N" data-komoditi = "N" data-url = "<?php echo site_url(); ?>/utility/setting/set_spk/multi/" />&nbsp;Auto Reset</th>
      <th>Update Terakhir</th>
    </tr>
  </thead>
  <tbody id="tbodysampel">
  	<?php
	$jml = count($sess);
	if($jml > 0){
		for($x = 0; $x < $jml; $x++){
			?>
            <tr <?php echo $sess[$x]['BIDANG'] == "K" ? 'style="background-color:#EBF1DE;"' : 'style="background-color:#fcfcfc;"'; ?>>
            	<td><?php echo $sess[$x]['KLASIFIKASI']; ?></td>
            	<td><?php echo $sess[$x]['UR_BIDANG']; ?></td>
            	<td align="center"><?php echo $sess[$x]['NOMOR']; ?></td>
            	<td align="center"><?php echo $sess[$x]['UR_RESET']; ?></td>
            	<td align="center"><input type="checkbox" <?php echo $sess[$x]['AUTO_RESET'] == "0" ? '' : 'checked=\"checked"'; ?>  value="<?php echo $sess[$x]['AUTO_RESET'] == "0" ? '0' : '1'; ?>" class="chk-reset" data-balai = "<?php echo $sess[$x]['BBPOM_ID']; ?>" data-anggaran = "<?php echo $sess[$x]['ANGGARAN']; ?>" data-komoditi = "<?php echo $sess[$x]['KOMODITI']; ?>" data-bidang = "<?php echo $sess[$x]['BIDANG']; ?>" data-url = "<?php echo site_url(); ?>/utility/setting/set_spk/single/" /></td>
            	<td><?php echo $sess[$x]['UPDATED']; ?></td>
            </tr>
            <?php
		}
	}
	?>
  </tbody>
</table>
<script>
	$(document).ready(function(e){
		$("#chk-all").click(function(){
			var $this = $(this);
			if($this.is(":checked")){
				jConfirm('Proses data terpilih sekarang ?', 'SIPT Versi 1.0', function(ojan){
					if(ojan){
						$.get($this.attr("data-url") + $this.attr("data-balai") + '/' + $this.attr("data-bidang") + '/' + $this.attr("data-komoditi") + '/' + $this.val(), function($hasil){
							if($hasil){
								var $arr = $hasil.split("#");
								if($arr[1] == "YES"){
									jAlert($arr[2], 'SIPT Versi 1.0');
								}else{
									jAlert($arr[2], 'SIPT Versi 1.0');
									$this.removeAttr("checked");
								}
							}
						});
						$("#tbodysampel").find(':checkbox').attr('checked', true);
					}else{
						$("#tbodysampel").find(':checkbox').attr('checked', false);
						$this.removeAttr("checked");
					}
				});
			}else{
				$("#tbodysampel").find(':checkbox').attr('checked', false);
			}
		});
        $(".chk-reset").change(function(e){
			var $this = $(this);
			if($(this).is(":checked") && $this.val() == 0){
				jConfirm('Proses data terpilih sekarang ?', 'SIPT Versi 1.0', function(ojan){
					if(ojan==true){
						$.get($this.attr("data-url") + $this.attr("data-balai") + '/' + $this.attr("data-bidang") + '/' + $this.attr("data-komoditi") + '/' + $this.val(), function($hasil){
							if($hasil){
								var $arr = $hasil.split("#");
								if($arr[1] == "YES"){
									jAlert($arr[2], 'SIPT Versi 1.0');
								}else{
									jAlert($arr[2], 'SIPT Versi 1.0');
									$this.removeAttr("checked");
								}
							}
						});
					}else{
						$this.removeAttr("checked");
					}
				});
			}else{
				if($this.val() == 1){
					jConfirm('Proses data terpilih sekarang ?', 'SIPT Versi 1.0', function(ojan){
						if(ojan==true){
							$.get($this.attr("data-url") + $this.attr("data-balai") + '/' + $this.attr("data-bidang") + '/' + $this.attr("data-komoditi") + '/' + $this.val(), function($hasil){
								if($hasil){
									var $arr = $hasil.split("#");
									if($arr[1] == "YES"){
										jAlert($arr[2], 'SIPT Versi 1.0');
									}else{
										jAlert($arr[2], 'SIPT Versi 1.0');
										$this.removeAttr("checked");
									}
								}
							});
						}else{
							$this.removeAttr("checked");
						}
					});
				}else{
					$(this).removeAttr("checked");
				}
			}
			return false;
        });
    });
</script>