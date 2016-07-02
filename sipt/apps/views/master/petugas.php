<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed'); error_reporting(E_ERROR);
if (array_key_exists('SARANA_MEDIA_ID', $sess) && $sess['JENIS_PELAPORAN'] == "02") {
    $bid = substr($sess['SARANA_MEDIA_ID'], 0, 2);
}
?>

<div id="judulpetugas" class="judul"></div>
<div class="content">
  <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="fpetugas">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><b><?php echo $header; ?></b></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nomor Induk Pegawai / NIP</td>
                <td class="td_right"><input type="text" class="stext" name="USER_ID" <?php echo array_key_exists('USER_ID', $sess) ? 'readonly="readonly"' : ''; ?> title="Nomor Induk Pegawai" value="<?php echo $sess['USER_ID']; ?>" rel="required" onblur="noSpace($(this));
        return false;" /></td>
              </tr>
              <tr>
                <td class="td_left">Nama Petugas</td>
                <td class="td_right"><input type="text" class="stext" name="PETUGAS[NAMA_USER]" title="Nama Petugas" value="<?php echo $sess['NAMA_USER']; ?>" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Jabatan</td>
                <td class="td_right"><input type="text" class="stext" name="PETUGAS[JABATAN]" title="Jabatan Petugas" value="<?php echo $sess['JABATAN']; ?>" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Email</td>
                <td class="td_right"><input type="text" class="stext" name="PETUGAS[EMAIL]" title="Email Petugas. Jika lebih dari satu pisahkan dengan titik koma (;)" value="<?php echo $sess['EMAIL']; ?>" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Balai Besar / Balai POM</td>
                <td class="td_right"><?php echo form_dropdown('PETUGAS[BBPOM_ID]', $bbpom, $sess['BBPOM_ID'], 'id="bbpom_id" class="stext" rel="required" title="Balai Besar / Balai POM"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Jenis Pelaporan</td>
                <td class="td_right"><?php echo form_dropdown('ROLE[JENIS_PELAPORAN][]', $jenis, is_array($sel_jenis) ? $sel_jenis : '', 'class="stext" rel="required" multiple title="Jenis Pelaporan" id="jenis_pelaporan"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Bertindak Sebagai</td>
                <td class="td_right"><?php echo form_dropdown('ROLE[ROLE][]', $role, is_array($sel_role) ? $sel_role : '', 'class="stext" rel="required" id="role" style="height:120px;" multiple title="Rule Petugas"'); ?></td>
              </tr>
              <tr id="tr_kategori" <?php echo in_array('01', $sel_jenis) ? 'style=""' : 'style="display:none;"'; ?>>
                <td class="td_left">Klasifikasi Kategori</td>
                <td class="td_right"><?php echo form_dropdown('ROLE[KK_ID][]', $klasifikasi, is_array($sel_klasifikasi) ? $sel_klasifikasi : '', 'class="stext" id="klasifikasi" multiple rel="required" title="Klasifikasi Kategori"'); ?></td>
              </tr>
              <tr id="tr_kategori2" <?php echo in_array('03', $sel_jenis) || in_array('05', $sel_jenis) ? 'style=""' : 'style="display:none;"'; ?>>
                <td class="td_left">Klasifikasi Kategori Iklan Penanandaan</td>
                <td class="td_right"><?php echo form_dropdown('ROLE[KK_ID][]', $klasifikasi2, (in_array('03', $sel_jenis) || in_array('05', $sel_jenis)) ? (is_array($sel_klasifikasi) ? $sel_klasifikasi : '') : '', 'class="stext" id="klasifikasi2" multiple title="Klasifikasi Kategori"'); ?></td>
              </tr>
              <tr id="tr_bidang" <?php echo in_array('02', $sel_jenis) ? 'style=""' : 'style="display:none;"'; ?>>
                <td class="td_left">Bidang Pengujian</td>
                <td class="td_right"><?php
								if(is_array($sel_jenis)){
									
								}else{
								}
								?>
                  <?php echo form_dropdown('BIDANG[]', $bidang, $sel_bidang, 'class="stext" id="bidang" title="Bidang pengujian" style="height:25px;"'); ?></td>
              </tr>
            </table>
          </div>
        </div>
        <div style="padding:10px;"></div>
        <div><a href="#" class="button save" onclick="fpost('#fpetugas', '', '');
        return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this));
        return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>
      </div>
    </div>
  </form>
</div>
<script>
    $(document).ready(function() {
        $("#jenis_pelaporan").change(function() {
            var val = $(this).val().toString();
            var spl = val.split(",");
			var ink = spl.length;
            if ($.inArray("01", spl) >= 0) {
                $("tr#tr_kategori").css("display", "");
                $("#klasifikasi").attr("rel", "required");
            } else if ($.inArray("01", spl) < 0) {
                $("tr#tr_kategori").css("display", "none");
                $("#klasifikasi").attr("rel", "");
//                $("#klasifikasi").val("");
            }
            if ($.inArray("02", spl) >= 0) {
				if(ink > 1){
					jAlert('Mohon pilih salah satu pelaporan pemdik atau pelaporan pengujian');
					//spl.splice("02", );
				}
                if ($("#role").val() != '7' || $("#role").val() != '8') {
                    $("tr#tr_bidang").css("display", "");
                    $("#bidang").attr("rel", "required");
                } else {
                    $("tr#tr_bidang").css("display", "");
                    $("#bidang").removeAttr("rel", "");
                }
            } else if ($.inArray("02", spl) < 0) {
                $("tr#tr_bidang").css("display", "none");
                $("#bidang").attr("rel", "");
                $("#bidang").val("");
            }
            if ($.inArray("03", spl) >= 0 || $.inArray("05", spl) >= 0) {
                $("tr#tr_kategori2").css("display", "");
                $("#klasifikasi2").attr("rel", "required");
            } else if ($.inArray("03", spl) < 0 && $.inArray("05", spl) < 0) {
                $("tr#tr_kategori2").css("display", "none");
                $("#klasifikasi2").attr("rel", "");
//                $("#klasifikasi2").val("");
            }
            return false;
        });
        $("#role").change(function() {
            var val = $(this).val();
            if ((val == "7" || val == "8") && $('#bidang').is(':visible')) {
                $("#bidang").removeAttr("rel", "");
                $("#klasifikasi").attr("rel", "");
            }
            return false;
        });

<?php
if (array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE'))) {
    ?>
            $("#bbpom_id").change(function() {
                var kunci = $(this).val();
                $("#bidang").html('');
                $.get(isUrl + '/index.php/autocompletes/autocomplete/get_tipebidang/' + kunci, function(hasil) {
                    $("#bidang").html(hasil);
                    if (kunci == "99")
                        $("#bidang").height(25);
                    else
                        $("#bidang").height(25);
                });
                return false;
            });
    <?php
}
?>
    });
</script>