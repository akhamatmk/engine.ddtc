<!-- KOLOM TENGAH -->
<div class="middle-column-title">Pengaturan</div>
<div class="setting-welcome">Selamat Datang <strong><?php echo $this->session->userdata('user_name'); ?></strong></div>

<form method="post" action="<?php echo site_url(); ?>user/do_settings" id="form-settings" runat="server" enctype="multipart/form-data">
  <div class="setting-box container-fluid">
    <div class="col-md-8">
      <div class="setting-welcome"><strong>Akun</strong></div>
      <div class="setting-label">Nama</div>
      <input type="text" class="setting-input" name="setting_name" placeholder="Nama kamu" value="<?php echo $this->session->userdata('user_name'); ?>">
      <div class="setting-label">Email</div>
      <input type="email" class="setting-input" name="setting_email" placeholder="Alamat email" value="<?php echo $this->session->userdata('user_email'); ?>" disabled="disabled">
      <div class="setting-label">Kata Sandi</div>
      <input type="password" class="setting-input" name="setting_password" placeholder="Kata sandi">
      <div class="setting-label">Ulang Kata Sandi</div>
      <input type="password" class="setting-input" name="setting_repassword" placeholder="Ulangi kata sandi">
      <div class="clearfix"></div>
    </div>
    <div class="col-md-4 setting-profile">
      <div class="setting-photo">
        <!--<img src="<?php echo site_url(); ?>assets/upload/images/<?php echo $this->session->userdata('user_image'); ?>" id="image_upload_preview" width="104px" height="104px" class="img-circle">-->
        <img src="<?php echo site_url('timthumb.php?src='.site_url('assets/upload/images/'.$this->session->userdata('user_image').'&w=104&h=104')); ?>" id="image_upload_preview" width="104px" height="104px" class="img-circle">
        <div id="image_upload_preview_bg" class="img-circle"></div>
        <br>
        <!--<a id="setting-ubahfoto" href="">Ubah Foto</a>-->
        <label class="fileContainer">
          Pilih Foto
          <input id="setting-editfoto" type="file" name="setting_image" accept="image/*">
        </label>
        <small style="display:block; font-size: 10px;">[ Max 1 MB ]</small>
      </div>
    </div>
  </div>
  <button class="setting-button" type="submit" id="btn-settings">Simpan</button>
  <div id="msg-settings"></div>
</form>

<div class="setting-history">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#lastseen" role="tab" data-toggle="tab">Terakhir Dilihat</a></li>
    <li><a href="<?php echo site_url(); ?>user/favourite">Favorit</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
   
    <div role="tabpanel" class="tab-pane fade in active" id="lastseen">

      <?php
      foreach($lastseen as $row)
      {
        $lastseen = get_data_peraturan_pajak($row['lastseen_id']);

        $id = $lastseen['id'];
        $permalink = $lastseen['permalink'];
        $jenis_dokumen_lengkap = $lastseen['jenis_dokumen_lengkap'];
        $nomordokumen = $lastseen['nomordokumen'];
      ?>
      <div class="setting-items">
        <div class="setting-docname">
        <a href="<?php echo site_url('peraturan-pajak/read/'.$permalink); ?>" data-toggle="modal" data-target=".doc-modal" id="<?php echo $id; ?>" data-idmodal="<?php echo $id; ?>" data-remote="false" class="modalcaller"><?php echo $jenis_dokumen_lengkap; ?></a>
        </div>
        <div class="setting-docnumber"><?php echo $nomordokumen; ?></div>
        <!--<div class="setting-docdelete"><a href="" title="hapus" class="delete-lastseen"><span class="glyphicon glyphicon-remove-sign"></span></a></div>-->
      </div>
      <?php
      }
      ?>
        
      <!--<nav class="setting-paging">
        <ul class="pagination">
          <li>
            <a href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li>
            <a href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>-->             

    </div>
  </div>

</div>