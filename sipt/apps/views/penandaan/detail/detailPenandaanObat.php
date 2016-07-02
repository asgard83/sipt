<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed'); error_reporting(E_ERROR);
$d1 = explode('*', $sess['BUNGKUS_LUAR']);
$d2 = explode('*', $sess['ETIKET']);
$d3 = explode('*', $sess['AMPUL_VIAL10ML']);
$d4 = explode('*', $sess['AMPUL_VIAL9ML']);
$d5 = explode('*', $sess['BROSUR']);
$d6 = explode('*', $sess['AMPLOP']);
$d7 = explode('*', $sess['BLISTER']);
$detail1 = explode('#', $d1[1]);
$detail2 = explode('#', $d2[1]);
$detail3 = explode('#', $d3[1]);
$detail4 = explode('#', $d4[1]);
$detail5 = explode('#', $d5[1]);
$detail6 = explode('#', $d6[1]);
$detail7 = explode('#', $d7[1]);
$url = site_url() . '/penandaan/penandaanController/prosesPreview/' . $sess['PENANDAAN_ID'] . '/' . $sess['STATUS'] . '/001';
?>
<link type="text/css" href="<?php echo base_url(); ?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
    <tr><td colspan="2"><h2 class="small">Detil Pengawasan : <?php echo $judul; ?></h2></td></tr>
    <tr><td width="200">Tanggal Pemeriksaan</td><td><?php echo $sess['TANGGAL_MULAI']; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $sess['TANGGAL_AKHIR']; ?></td></tr>
    <tr><td>&nbsp;</td></tr>
   <!-- <tr><td><h2 class="small garis">MK / TMK : </h2></td><td style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf; width: 20%">&nbsp;&nbsp;&nbsp;&nbsp;Hasil Sistem</td><td style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf; width: 20%">Hasil Pusat</td><td style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf;">Justifikasi</td></tr>
    <tr><td>Bungkus Luar</td><td> : &nbsp;<?php
    if (end($detail1) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail1) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d1[3])) {
        if ($d1[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d1[7])) {
        echo $d1[7];
    }
    else
        echo "-"
        ?></td></tr>
    <tr><td>Amplop / Catch Cover / Sachet</td><td> : &nbsp;<?php
    if (end($detail6) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail6) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d6[3])) {
        if ($d6[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d6[7])) {
        echo $d6[7];
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d2[7])) {
        echo $d2[7];
    }
    else
        echo "-"
        ?></td></tr>
    <tr><td>Etiket</td><td> : &nbsp;<?php
    if (end($detail2) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail2) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d2[3])) {
        if ($d2[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d2[7])) {
        echo $d2[7];
    }
    else
        echo "-"
        ?></td></tr>
    <tr><td>Strip / Blister</td><td> : &nbsp;<?php
    if (end($detail7) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail7) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d7[3])) {
        if ($d7[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d7[7])) {
        echo $d7[7];
    }
    else
        echo "-"
        ?></td></tr>
    <tr><td>Ampul Vial >= 10 ML</td><td> : &nbsp;<?php
    if (end($detail3) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail3) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d3[3])) {
        if ($d3[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d3[7])) {
        echo $d3[7];
    }
    else
        echo "-"
        ?></td></tr>
    <tr><td>Ampul Vial < 10 ML</td><td> : &nbsp;<?php
    if (end($detail4) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail4) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d4[3])) {
        if ($d4[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d4[7])) {
        echo $d4[7];
    }
    else
        echo "-"
        ?></td></tr>
    <tr><td>Brosur</td><td> : &nbsp;<?php
    if (end($detail5) == "MK")
        echo "Memenuhi Ketentuan"; else if (end($detail5) == "TMK")
        echo "Tidak Memenuhi Ketentuan";
    else
        echo '-';
    ?></td><td><?php
    if (!empty($d5[3])) {
        if ($d5[3] == "TMK")
            echo "Tidak Memenuhi Ketentuan";
        else
            echo "Memenuhi Ketentuan";
    }
    else
        echo "-"
        ?></td><td><?php
    if (!empty($d5[7])) {
        echo $d5[7];
    }
    else
        echo "-"
        ?></td></tr>-->
    <tr><td><h2 class="small garis">MK / TMK : </h2></td><td style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf; width: 20%">&nbsp;&nbsp;&nbsp;&nbsp;Hasil</td><td style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf;">Justifikasi</td></tr>
    <tr><td>Bungkus Luar</td><td> : &nbsp;<?php
            if (empty($d1[3])) {
                if (end($detail1) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail1) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            } else if (!empty($d1[3])) {
                if ($d1[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d1[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d1[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
    <tr><td>Amplop / Catch Cover / Sachet</td><td> : &nbsp;<?php
            if (empty($d6[3])) {
                if (end($detail6) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail6) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            } if (!empty($d6[3])) {
                if ($d6[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d6[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d6[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
    <tr><td>Etiket</td><td> : &nbsp;<?php
            if (empty($d2[3])) {
                if (end($detail2) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail2) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            } if (!empty($d2[3])) {
                if ($d2[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d2[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d2[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
    <tr><td>Strip / Blister</td><td> : &nbsp;<?php
            if (empty($d7[3])) {
                if (end($detail7) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail7) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            } if (!empty($d7[3])) {
                if ($d7[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d7[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d7[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
    <tr><td>Ampul Vial >= 10 ML</td><td> : &nbsp;<?php
            if (empty($d3[3])) {
                if (end($detail3) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail3) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            }
            if (!empty($d3[3])) {
                if ($d3[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d3[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d3[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
    <tr><td>Ampul Vial < 10 ML</td><td> : &nbsp;<?php
            if (empty($d4[3])) {
                if (end($detail4) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail4) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            }
            if (!empty($d4[3])) {
                if ($d4[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d4[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d4[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
    <tr><td>Brosur</td><td> : &nbsp;<?php
            if (empty($d5[3])) {
                if (end($detail5) == "MK")
                    echo "Memenuhi Ketentuan"; else if (end($detail5) == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo '-';
            }if (!empty($d5[3])) {
                if ($d5[3] == "TMK")
                    echo "Tidak Memenuhi Ketentuan";
                else
                    echo "Memenuhi Ketentuan";
            }
            ?></td><td><?php
            if (!empty($d5[7])) {
                echo preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $d5[7]) . "\n";
            }
            else
                echo "-"
                ?></td></tr>
</table>
<br /><br />
<h2 class="small">Detil Petugas Pengawasan</h2>
<div id="detail_petugas" url="<?php echo $histori_petugas; ?>"></div>
<?php if ($yesBtn == "YES") { ?><div style="margin-top:10px; margin-bottom:10px;"><a href="#" class="button comment" url="<?php echo $act; ?>" onclick="batal($(this));
          return false;"><span><span class="icon"></span>&nbsp; <?php echo $tombol; ?> &nbsp;</span></a></div><?php } ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#detail_petugas").html('Loading..');
        $("#detail_petugas").load($("#detail_petugas").attr("url"));
    });
</script>