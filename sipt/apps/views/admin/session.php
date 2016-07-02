<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion">
	<h2 class="current"><?php echo $caption_header; ?></h2>
	<form id="fsession_" action="<?= $act; ?>" method="post" autocomplete="off">
    <table class="tabelajax">
        <tr class="head">
        	<th>NO</th><th>PENGGUNA</th><th>NAMA PETUGAS</th><th>BADAN / BALAI POM</th><th>JABATAN</th><th>LOGIN TERAKHIR</th><th>LOGOUT TERAKHIR</th><th>IP ADDRESS</th>
        </tr>
		<?php
			$session=array_keys($sess);
			$jml = count($session);
			$no=1;
			for($i=0; $i<$jml;$i++){
				$arrsess = explode('|', $sess[$session[$i]]);
				$j = strlen($arrsess[0]);
				$log = substr($arrsess[0], $j-9, 9);
				if($log=="LOGGED_IN"){
					$xval = explode(";", $sess[$session[$i]]);
					foreach($xval as $a){
						$b = explode('|', $a);
						if($b[0]!="LOGIN_"){
							$c[$b[0]] = str_replace(":","",substr($b[1], 4, $jum-1));
						}else{
							$c[$b[0]] = substr($b[1], 4, $jum-1);
						}
					} 				  
				}
				?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo str_replace('"','',$c['SESS_USER_ID']);?></td>
                    <td><?php echo str_replace('"','',$c['SESS_NAMA_USER']);?></td>
                    <td><?php echo str_replace('"','',$c['SESS_MBBPOM']);?></td>
                    <td><?php echo str_replace('"','',$c['SESS_JABATAN']);?></td>  
                    <td><?php echo str_replace('"','',$c['SESS_LOGIN']);?></td>
                    <td><?php echo str_replace('"','',$c['SESS_LOGOUT']);?></td>
                    <td><?php echo str_replace('"','',$c['SESS_IP']);?></td>
                </tr>
                <?php
                $no++;
			}
		?>
        <tr><th colspan="8" style="height:25px;"></th></tr>	
         </table>
    </form>
</div>
</div>
