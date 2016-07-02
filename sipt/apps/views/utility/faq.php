<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  error_reporting(E_ERROR);?>
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div class="adCntnr">
    <div class="acco2">
        <div class="expand"><b>FAQ Baru</b></div>
        <div class="collapse">
                <div class="accCntnt">
				  <?php 
                  if(!$prev){
                  ?>
                  <form id="form-faq" action="<?php echo $act; ?>" autocomplete="off">
                  <table class="form_tabel">
                      <tr><td class="td_left">Klasifikasi FAQ</td><td><?php echo form_dropdown('FAQ[REF_FAQ]',$ref,$sess['REF_FAQ'],'class="stext" rel="required" title="Klasifikasi FAQ"'); ?></td></tr>
                      <tr><td class="td_left">Subjek Pertanyaan</td><td><textarea name="FAQ[SUBJEK]" class="stext subjek" rel="required" title="Subjek Pertanyaan"><?php echo $sess['SUBJEK']; ?></textarea></td></tr>
                      <tr><td class="td_left">Pertanyaan</td><td><textarea name="FAQ[PERTANYAAN]" class="stext chk"  title="Pertanyaan" rel="required" id="faq_question"><?php echo $sess['PERTANYAAN']; ?></textarea></td></tr>
                      <?php if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){?>
                      <tr><td class="td_left">Jawaban</td><td><textarea name="FAQ[JAWABAN]" class="stext chk" title="Jawaban" id="faq_answer"><?php echo $sess['JAWABAN']; ?></textarea></td></tr>
                      <? } ?>
                      <tr><td class="td_left">Tags (Kata kunci)</td><td class="td_right"><input type="text" class="stext" name="FAQ[KEY_TAGS]" title="Jika lebih dari satu pisahkan dengan koma" value="<?php echo $sess['KEY_TAGS']; ?>" rel="required" /></td></tr>
                  </table>
                  <div style="height:10px"></div>
                  <div><a href="#" class="button save" onclick="fpost('#form-faq','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button back" id="batal" url="<?php echo $back; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div> 
				  <?php
                  if(array_key_exists('FAQ_ID', $sess)){
                      ?>
                      <input type="hidden" name="FAQ_ID" value="<?php echo $sess['FAQ_ID']; ?>" />
                      <?
                  }
                  ?>
                  </form>
                  <?php 
                  }else{
                  ?>
                  <table class="form_tabel">
                      <tr><td class="td_left">Klasifikasi FAQ</td><td><?php echo $sess['URAIAN']; ?></td></tr>
                      <tr><td class="td_left">Subjek Pertanyaan</td><td><?php echo $sess['SUBJEK']; ?></td></tr>
                      <tr><td class="td_left">Pertanyaan</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['PERTANYAAN'])); ?></td></tr>
                      <tr><td class="td_left">Jawaban</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['JAWABAN'])); ?></td></tr>
                      <tr><td class="td_left">Kata kunci</td><td class="td_right"><?php echo $sess['KEY_TAGS']; ?></td></tr>
                  </table>
                  <div style="height:10px"></div>
                  <div><a href="#" class="button back" id="batal" url="<?php echo $back; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div> 
                  <?php 
                  }  
                  ?>                
             </div>
		</div>        
    </div>
</div>
</div>
