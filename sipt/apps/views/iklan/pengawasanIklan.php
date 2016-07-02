<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed'); error_reporting(E_ERROR);
?>
<div id="judulpmnikl" class="judul"></div>
<div class="content">
 <div id="accordion">
  <h2 class="current">Surat Tugas Pengawasan Iklan </h2>
  <form name="fpengawasan_" id="fpengawasanIklan_" method="post" action="<?php echo $act; ?>" autocomplete="off">
   <table>
    <tr>
     <td>
      <table>
       <tbody id="tb_surat">
        <tr class="urut<?php echo $i; ?>">
         <td width="150">Nomor Surat Tugas</td><td><input type="text" class="stext stugas" name="SURAT" id="stugas"  title="Di isi dengan nomor surat tugas pengawasan" placeholder="Apabila Ada Surat Tugas Pengawasan" value="<?php echo $suratTugas ?>"/>&nbsp;&nbsp;
         </td>
        </tr>
        <tr class="urut<?php echo $i; ?>">
         <td>Tanggal Surat Tugas</td><td><input type="text" class="sdate" name="TANGGAL" value="<?php echo $tanggalSurat; ?>" id="tgltugas" title="Tanggal Surat Tugas"/></td>
        </tr>
        <tr class="urut<?php echo $i; ?>">
         <td class="atas">Unit / Balai Besar / Balai</td>
         <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
        </tr>
        <tr class="urut<?php echo $i; ?>">
         <td class="atas">Petugas Pengawasan Iklan</td>
         <td><input type="text" class="stext operator" id="operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas." /></td>
        </tr>
        <tr class="urut<?php echo $i; ?>">
         <td class="atas">&nbsp;</td>
         <td><ul style="list-style:none; margin:0px; padding:0px;" id="urut0"></ul></td>
        </tr>
        <tr class="urut<?php echo $i; ?>">
         <td class="atas">&nbsp;</td>
         <td><ul style="list-style:none; margin:0px; padding:0px;" id="urut1"></ul></td>
        </tr>
        <?php if (trim($suratId) != "") { ?>
         <tr>
          <td class="atas">Jenis Klasifikasi</td><td><?php echo form_dropdown('klasifikasi[]', $klasifikasi, $selKlasifikasi, 'id="klasifikasi_id" class="stext" rel="required" title="Pilih Jenis Klasifikasi" onclick="jAlert(\'Tidak diperkenankan merubah jenis klasifikasi\', \'SIPT Versi 1.0 Beta\');return false;"'); ?></td>
         </tr>
        <?php } else { ?>
         <tr>
          <td class="atas">Jenis Klasifikasi</td><td><?php echo form_dropdown('klasifikasi[]', $klasifikasi, $selKlasifikasi, 'id="klasifikasi_id" class="stext" rel="required" title="Pilih Jenis Klasifikasi"'); ?></td>
         </tr>
        <?php } ?>
        <tr class="pangan" hidden>
         <td>Jenis Pangan</td><td><select name="PANGAN" class="stext pangan" title="Jenis Pangan"><option value=""></option><option value="IRT">Pangan IRT</option><option value="MDML">Pangan MD/ML</option></select></td>
        </tr>
       </tbody>
      </table>
     </td>
     <td width="10">&nbsp;<input type="hidden" name="SURATIDEDIT" value="<?php echo $suratId; ?>"/></td>
     <td class="atas">
      <table>
      </table>
     </td>
    </tr>
   </table>
   <div style="padding-left:5px; padding-bottom:10px;">
    <a href="#" class="button save" onclick="fpost('#fpengawasanIklan_', '', '');
          return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
    <a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this));
          return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
  </form>
 </div>
</div>
<div id="clear_fix"></div>
<script type="text/javascript">
         $(document).ready(function() {
<?php
$jmldata = 0;
$data = $petugas;
$jmldata = count($data);
if ($jmldata == 0) {
 $jmldata = 1;
 $data[] = "";
}
$i = 0;
if ($petugas) {
 do {
  ?>
            $("ul#urut1").append('<li style="padding-bottom:5px;" id="<?php echo 'jml' . $i; ?>"><input type="text" class="stext" value="<?php echo $petugas[$i]; ?>" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut1 li#<?php echo 'jml' . $i; ?>\').remove();" /></a><input type="hidden" name="BBPOM[NAMA][0][]" value="<?php echo $petugas[$i]; ?>">&nbsp;<input type="hidden" name="USER_ID[0][]" value="<?php echo $petugasId[$i]; ?> "></li>');
  <?php
  $i++;
 } while ($i < $jmldata);
}
?>
          $("input.operator").autocomplete($("input.operator").attr("url") + $("#bpomid").val(), {width: 244, selectFirst: false});
          $("input.operator").result(function(event, data, formatted) {
           if (data) {
            $("ul#urut0").append('<li style="padding-bottom:5px;" id="' + data[1] + '"><input type="text" class="stext" value="' + data[2] + '" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1] + '\').remove();" /></a><input type="hidden" name="BBPOM[NAMA][0][]" value="' + data[2] + '">&nbsp;<input type="hidden" name="USER_ID[0][]" value="' + data[1] + '"></li>');
            $(this).val('');
            $(this).focus();
           }
          });
          $("#saranaid_").autocomplete($("#saranaid_").attr("url"), {width: 244, selectFirst: false});
          $("#saranaid_").result(function(event, data, formatted) {
           if (data) {
            $(this).val(data[1]);
            $("#media_").focus();
           }
          });
          $('input.sdate').datepicker({dateFormat: 'dd/mm/yy', regional: 'id'});
          $("#media_").change(function() {
           var kunci = $(this).val();
           $.get('<?php echo site_url(); ?>/get/pemeriksaan/set_klasifikasi_sarana/' + kunci, function(hasil) {
            hasil = hasil.replace(' ', '');
            if (hasil != "") {
             $('#klasifikasi_id').html(hasil);
             if (hasil.search('005') >= 0) {
              $('#klasifikasi_id').attr('multiple', 'multiple');
              $("#klasifikasi_id option[value='']").remove();
             } else {
              $('#klasifikasi_id').attr('multiple', '');
             }
            }
           });
          });
          $("#klasifikasi_id").change(function() {
           if ($(this).val() == "013") {
            $(".pangan").show();
            $(".pangan").attr("rel", "required");
            $(".pangan").attr("name", "PANGAN");
           } else {
            $(".pangan").hide();
            $(".pangan").attr("rel", "");
            $(".pangan").attr("name", "");
           }
          });
         });</script>