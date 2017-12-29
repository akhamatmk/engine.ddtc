<!-- KOLOM TENGAH -->
<div class="middle-column-title">Dokumen Favorit</div>

<form method="post" action="<?php echo site_url(); ?>user/favourite/edit_folder/<?php echo $cfolder['folder_id']?>" id="form-folder" runat="server">
  <div class="setting-box container-fluid">
    <div class="col-md-8">
      <div class="setting-welcome"><strong>Ganti Nama Folder</strong></div>
      <div class="setting-label">Nama Folder</div>
      <input type="text" class="setting-input" name="folder_name" value="<?php echo $cfolder['folder_name']?>">
      <div class="clearfix"></div>
    </div>
  </div>
  <button class="setting-button" type="submit" id="btn-folder">Simpan</button>
  <div id="msg-folder"></div>
</form>

<hr>

<h4><a href="<?php echo site_url(); ?>user/favourite"><span class=" glyphicon glyphicon-level-up" aria-hidden="true"></span></a> / <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>  <?php echo $cfolder['folder_name']; ?></h4>

<div class="setting-history">

  <hr>

  <div class="file-list">
    <?php
      if(count($favourite) < 1)
      {
        echo '<p>Tidak ada dokumen.</p>';
      }
      else
      {
      foreach($favourite as $row)
      {
        $favourite_id = $row['favourite_id'];
        $favourite = get_data_dokumen($row['favourite_type'], $row['favourite_document_id']);
      ?>

      <?php
      if($row['favourite_type'] == 1)
      {
      ?>
      <div class="setting-items">
        <div class="setting-docname">
          <div class="dropdown dropdown-inline">
            <a id="dLabel_<?php echo $favourite['id']; ?>" title="Pindahkan ke Folder" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> 
            </a>

            <ul class="dropdown-menu" aria-labelledby="dLabel_<?php echo $favourite['id']; ?>">
            <?php
              if(count($folder) < 1)
              {
                echo '<li><a href="#">Tidak ada folder.</a></li>';
              }
              else
              {
                foreach($folder as $f)
                {
            ?>
                  <li><a href="<?php echo site_url(); ?>user/favourite/move/<?php echo $favourite_id; ?>/<?php echo $f['folder_id']; ?>"><?php echo $f['folder_name']; ?></a></li>
            <?php
                }
              }
            ?>
            </ul>
          </div>
          <a href="" data-toggle="modal" data-target=".doc-modal" id="<?php echo $favourite['id']; ?>" data-idmodal="<?php echo $favourite['id']; ?>" class="modalcaller"><?php echo $favourite['jenis_dokumen_lengkap']; ?></a>
        </div>
        <div class="setting-docnumber"><?php echo $favourite['nomordokumen']; ?></div>
        <!--<div class="setting-docdelete"><a href="#" title="hapus" class="delete-favourite"><span class="glyphicon glyphicon-remove-sign"></span></a></div>-->
      </div>
      <?php
      }
      ?>

      <?php
      if($row['favourite_type'] == 2)
      {
      ?>
      <div class="setting-items">
        <div class="setting-docname">
          <div class="dropdown dropdown-inline">
            <a id="dLabel_<?php echo $favourite['p3b_id']; ?>" title="Pindahkan ke Folder" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> 
            </a>

            <ul class="dropdown-menu" aria-labelledby="dLabel_<?php echo $favourite['p3b_id']; ?>">
            <?php
              if(count($folder) < 1)
              {
                echo '<li><a href="#">Tidak ada folder.</a></li>';
              }
              else
              {
                foreach($folder as $f)
                {
            ?>
                  <li><a href="<?php echo site_url(); ?>user/favourite/move/<?php echo $favourite_id; ?>/<?php echo $f['folder_id']; ?>"><?php echo $f['folder_name']; ?></a></li>
            <?php
                }
              }
            ?>
            </ul>
          </div>
          <a href="" data-toggle="modal" data-target=".doc-modal-p3b" data-id="<?php echo $favourite['p3b_id']; ?>" data-idmodal="<?php echo $favourite['p3b_id']; ?>" class="modalcaller-p3b">Perjanjian Penghindaran Pajak Berganda</a>
        </div>
        <div class="setting-docnumber"><?php echo $favourite['p3b_country']; ?></div>
        <!--<div class="setting-docdelete"><a href="#" title="hapus" class="delete-favourite"><span class="glyphicon glyphicon-remove-sign"></span></a></div>-->
      </div>
      <?php
      }
      ?>

      <?php
      //PP
      if($row['favourite_type'] == 3)
      {
      ?>
      <div class="setting-items">
        <div class="setting-docname">
          <div class="dropdown dropdown-inline">
            <a id="dLabel_<?php echo $favourite['id']; ?>" title="Pindahkan ke Folder" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> 
            </a>

            <ul class="dropdown-menu" aria-labelledby="dLabel_<?php echo $favourite['id']; ?>">
            <?php
              if(count($folder) < 1)
              {
                echo '<li><a href="#">Tidak ada folder.</a></li>';
              }
              else
              {
                foreach($folder as $f)
                {
            ?>
                  <li><a href="<?php echo site_url(); ?>user/favourite/move/<?php echo $favourite_id; ?>/<?php echo $f['folder_id']; ?>"><?php echo $f['folder_name']; ?></a></li>
            <?php
                }
              }
            ?>
            </ul>
          </div>
          <a href="" data-toggle="modal" data-target=".doc-modal-pp" class="modalcaller-pp" data-id="<?php echo $favourite['id']; ?>">Putusan Pengadilan Pajak</a>
        </div>
        <div class="setting-docnumber"><?php echo $favourite['name']; ?></div>
        <!--<div class="setting-docdelete"><a href="#" title="hapus" class="delete-favourite"><span class="glyphicon glyphicon-remove-sign"></span></a></div>-->
      </div>
      <?php
      }
      ?>

      <?php
      //MA
      if($row['favourite_type'] == 4)
      {
      ?>
      <div class="setting-items">
        <div class="setting-docname">
          <div class="dropdown dropdown-inline">
            <a id="dLabel_<?php echo $favourite['ma_id']; ?>" title="Pindahkan ke Folder" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> 
            </a>

            <ul class="dropdown-menu" aria-labelledby="dLabel_<?php echo $favourite['ma_id']; ?>">
            <?php
              if(count($folder) < 1)
              {
                echo '<li><a href="#">Tidak ada folder.</a></li>';
              }
              else
              {
                foreach($folder as $f)
                {
            ?>
                  <li><a href="<?php echo site_url(); ?>user/favourite/move/<?php echo $favourite_id; ?>/<?php echo $f['folder_id']; ?>"><?php echo $f['folder_name']; ?></a></li>
            <?php
                }
              }
            ?>
            </ul>
          </div>
          <a href="" data-toggle="modal" data-target=".doc-modal-ma" class="modalcaller-ma" data-id="<?php echo $favourite['ma_id']; ?>">Putusan Mahkamah Agung</a>
        </div>
        <div class="setting-docnumber"><?php echo $favourite['ma_number']; ?></div>
        <!--<div class="setting-docdelete"><a href="#" title="hapus" class="delete-favourite"><span class="glyphicon glyphicon-remove-sign"></span></a></div>-->
      </div>
      <?php
      }
      ?>

      <?php
      }
      }
      ?>
  </div>

  <hr>

</div>