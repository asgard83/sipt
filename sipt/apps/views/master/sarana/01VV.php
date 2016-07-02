<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input, select, textarea').focus(function(){
			$(this).css('background-color','#FFF');
			$(this).css('border','1px solid #dddddd');
		});
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});		<?php #if($this->newsession->userdata('SESS_BBPOM_ID') == "00" || in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit'))){ ?>
		$("#propinsi").change(function(){ 
			var propinsi = $(this).val(); 
			$.get($(this).attr('url')+ propinsi, function(hasil){
				$("#kota").html(hasil);
			});
		});		
		<?php #} ?>
});
</script>

<h2 class="small">Jenis Sarana : <?php echo $nama_jenis_sarana; ?></h2>
<?php
if($ispreview){
	?>
<table class="form_tabel detil">
  <tr>
    <td class="td_left">Alamat</td>
    <td class="td_right"><?php $alamat = explode(";", $sess['ALAMAT_1']); echo join("<br>", $alamat); ?></td>
  </tr>
  <tr>
    <td class="td_left">Telpon</td>
    <td class="td_right"><?php echo $sess['TELEPON']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Email</td>
    <td class="td_right"><?php echo $sess['EMAIL']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Propinsi</td>
    <td class="td_right"><?php echo $sess['NAMA_PROP']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Kota / Kabupaten</td>
    <td class="td_right"><?php echo $sess['NAMA_KOTA']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Nama Pemilik / Pimpinan</td>
    <td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Nomor Izin</td>
    <td class="td_right"><?php echo $sess['NOMOR_IZIN']; ?></td>
  </tr>
  <tr>
    <td class="td_left">Jumlah Karyawan</td>
    <td class="td_right"><?php echo $sess['JUMLAH_KARYAWAN']; ?>&nbsp;Orang</td>
  </tr>
  <tr>
    <td class="td_left">Umur Bangunan</td>
    <td class="td_right"><?php echo $sess['UMUR_BANGUNAN']; ?>&nbsp;Tahun</td>
  </tr>
</table>
<?php
}else{
	?>
<table class="form_tabel detil">
  <tr>
    <td class="td_left">Alamat</td>
    <td class="td_right"><textarea class="stext" name="SARANA[ALAMAT_1]" title="Alamat Sarana. Jika mempunyai lebih dari satu, pisahkan dengan tanda ; (titik koma)" rel="required"><?php echo $sess['ALAMAT_1']; ?></textarea></td>
  </tr>
  <tr>
    <td class="td_left">Propinsi</td>
    <td class="td_right"><?php echo form_dropdown('SARANA[PROPINSI]',$propinsi,$sel_propinsi,'id="propinsi" class="stext" rel="required" title="Nama Propinsi asal sarana" url="'.site_url().'/autocompletes/autocomplete/set_kota/"'); ?></td>
  </tr>
  <tr>
    <td class="td_left">Kota / Kabupaten</td>
    <td class="td_right"><?php echo form_dropdown('SARANA[KOTA]',$kota,$sel_kota,'class="stext" id="kota" rel="required" title="Nama Kota asal sarana"'); ?></td>
  </tr>
  <tr>
    <td class="td_left">Telpon</td>
    <td class="td_right"><input type="text" class="stext" title="No. Telpon sarana" name="SARANA[TELEPON]" value="<?php echo $sess['TELEPON']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_left">Email</td>
    <td class="td_right"><input type="text" class="stext" rel="required" title="Email Sarana" name="SARANA[EMAIL]" value="<?php echo $sess['EMAIL']; ?>" /></td>
  </tr>
  <tr>
    <td class="td_left">Nama Pemilik / Pimpinan</td>
    <td class="td_right"><input type="text" class="stext" name="SARANA[NAMA_PIMPINAN]" value="<?php echo $sess['NAMA_PIMPINAN']; ?>" title="Nama Pemilik Sarana / Pimpinan" /></td>
  </tr>
  <tr>
    <td class="td_left">Nomor Izin</td>
    <td class="td_right"><input type="text" class="stext" name="SARANA[NOMOR_IZIN]" value="<?php echo $sess['NOMOR_IZIN']; ?>" title="Nomor Izin Sarana" /></td>
  </tr>
  <tr>
    <td class="td_left">Jumlah Karyawan</td>
    <td class="td_right"><input type="text" class="stext sdate" name="SARANA[JUMLAH_KARYAWAN]" value="<?php echo $sess['JUMLAH_KARYAWAN']; ?>" title="Jumlah Karyawan" />
      &nbsp;Orang</td>
  </tr>
  <tr>
    <td class="td_left">Umur Bangunan</td>
    <td class="td_right"><input type="text" class="stext sdate" name="SARANA[UMUR_BANGUNAN]" value="<?php echo $sess['UMUR_BANGUNAN']; ?>" title="Umur Bangunan" />
      &nbsp;Tahun</td>
  </tr>
</table>
<h2 class="small">Jenis Pangan</h2>
<table id="tb-input-jenis-pangan" class="form_tabel">
  <tr>
    <td class="td_left">Jenis Pangan</td>
    <td class="td_right"><?php echo form_dropdown('',$jenis_pangan_new,'','id="jenis_pangan_new" class="stext" wajib="yes" title="Jenis Pangan" url="'.site_url().'/autocompletes/autocomplete/set_jenis_pangan/"'); ?></td>
  </tr>
  <tr id="tr-jenis-pangan" style="display:none;">
    <td class="td_left">&nbsp;</td>
    <td class="td_right"><?php echo form_dropdown('','','','id="jenis_pangan_new_2" class="stext" title="Jenis Pangan"'); ?></td>
  </tr>
  <tr>
    <td class="td_left">No. PIRT</td>
    <td class="td_right"><input type="text" id="no_pirt" class="stext" wajib="yes" title="No. PIRT" maxlength="15" onkeyup="numericOnly($(this));" onblur="numericOnly($(this));" onmouseup="numericOnly($(this));" /></td>
  </tr>
  <tr>
    <td class="td_left">Status</td>
    <td class="td_right"><select id="status_pirt" wajib="yes" class="stext" title="Status No. PIRT (Berlaku / Tidak Berlaku)">
        <option value="">Status</option>
        <option value="1">Berlaku</option>
        <option value="0">Tidak Berlaku</option>
      </select></td>
  </tr>
</table>
<div style="margin-top:5px;"><a href="#" class="button check add-jenis-pangan" data-target="#tb-input-jenis-pangan" ><span><span class="icon"></span>&nbsp; Tambah Jenis Pangan &nbsp;</span></a></div>

<div style="height:5px;">&nbsp;</div>
<table class="listtemuan" width="100%">
  <thead>
    <tr>
      <th width="400">Jenis Pangan</th>
      <th width="150">No. PIRT</th>
      <th width="250">Status</th>
      <th width="50">Aksi</th>
    </tr>
  </thead>
  <tbody id="tbodypirt">
    <?php
  $jml = count($t_jenis_pangan);
  if($jml > 0){
	  for($i = 0; $i < $jml; $i++){
		  ?>
    <tr id="<?php echo $t_jenis_pangan[$i]['SARANA_ID']; ?>-<?php echo $t_jenis_pangan[$i]['SERI']; ?>">
      <td><?php echo $t_jenis_pangan[$i]['JENIS_PANGAN']; ?><input type="hidden" name="PIRT[JENIS_PANGAN][]" value="<?php echo $t_jenis_pangan[$i]['JENIS_PANGAN']; ?>"><input type="hidden" name="PIRT[KODE][]" value="<?php echo $t_jenis_pangan[$i]['KODE']; ?>"></td>
      <td><?php echo $t_jenis_pangan[$i]['NO_PIRT']; ?><input type="hidden" name="PIRT[NO_PIRT][]" value="<?php echo $t_jenis_pangan[$i]['NO_PIRT']; ?>"></td>
      <td><?php echo $t_jenis_pangan[$i]['UR_STATUS']; ?><input type="hidden" name="PIRT[STATUS][]" value="<?php echo $t_jenis_pangan[$i]['STATUS']; ?>"></td>
      <td><a href="javascript:void(0);" class="hapuspirt" data-url = "<?php echo site_url(); ?>/get/pemeriksaan/del_pirt/<?php echo $t_jenis_pangan[$i]['SARANA_ID']; ?>-<?php echo $t_jenis_pangan[$i]['SERI']; ?>">Hapus</a></td>
    </tr>
    <?php
	  }
  }
  ?>
  </tbody>
</table>
<script>
	$(document).ready(function(e){
		$(".hapuspirt").click(function(){
            var $this = $(this);
			var $tr = $this.parent().parent();
			var $url = $this.attr("data-url");
			jConfirm('Apakah anda yakin akan menghapus data jenis pangan terpilih?', 'SIPT Versi 1.0', function(ojan){
				if(ojan==true){
					$.get($url, function($hasil){
						if($hasil.search("MSG")>=0){
							jAlert($hasil[2],'SIPT Versi 1.0');
							$tr.remove();
						}
					});
				}else{
					return false;
				}
			});
			return false;
        });
		$(".add-jenis-pangan").click(function(){
			var $this = $(this);
            var wajib = 0
			$('input:visible, select:visible, textarea:visible', $this.attr("data-target")).each(function(){
				if($(this).attr('wajib')){
					if($(this).attr('wajib')=="yes" && ($(this).val()=="" || $(this).val()==null)){
						$(this).css('border-color','#b94a48');
						wajib++;
					}
				}
			});
			if(wajib > 0){
				jAlert('Ada' + wajib + ' kolom yang harus diisi');
				return false;
			}else{
				var $jenis_pangan = $("#jenis_pangan_new_2");
				var $no_pirt = $("#no_pirt");
				var $status_pirt = $("#status_pirt");
				var $html  = '<tr id="'+$jenis_pangan.val()+'">';
					$html += '<td>'+$("#jenis_pangan_new_2 option:selected").text()+'<input type="hidden" name="PIRT[JENIS_PANGAN][]" value="'+$("#jenis_pangan_new_2 option:selected").text()+'"><input type="hidden" name="PIRT[KODE][]" value="'+$jenis_pangan.val()+'"></td>';
					$html += '<td>'+$no_pirt.val()+'<input type="hidden" name="PIRT[NO_PIRT][]" value="'+$no_pirt.val()+'"></td>';
					$html += '<td>'+$("#status_pirt option:selected").text()+'<input type="hidden" name="PIRT[STATUS][]" value="'+$status_pirt.val()+'"></td>';
					$html += '<td><a href="javascript:void(0);" class="removepirt">Hapus</a></td>';
					$html += '</tr>';
				$("tbody#tbodypirt").append($html);	
					setTimeout(function(){
						$(':input', $this.attr("data-target")).each(function(){
						var type = this.type;
						var tag = this.tagName.toLowerCase();
						if (type == 'text' || type == 'password' || tag == 'textarea')
						this.value = "";
						else if (type == 'checkbox' || type == 'radio')
						this.checked = false;
						else if (tag == 'select')
						this.selectedIndex = 0;
					});
				}, 100);
				$(".removepirt").click(function(){
                    var $this = $(this);
					var $trnya = $this.parent().parent();
					jConfirm('Apakah anda yakin akan menghapus data jenis pangan terpilih?', 'SIPT Versi 1.0', function(ojan){
						if(ojan==true){
							$trnya.remove();
						}else{
							return false;
						}
					});
					return false;
                });
				return false;
			}
        });
        $("#jenis_pangan_new").change(function(e){
            var $this = $(this);
			$.get($this.attr("url") + $this.val(), function(data){
				if(data){
					$("#jenis_pangan_new_2").html(data);
					$("tr#tr-jenis-pangan").css("display","");
					$("#jenis_pangan_new_2").attr("wajib","yes");
				}
			});
        });
    });
</script>
<?php
}
?>
