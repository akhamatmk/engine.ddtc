<!-- KOLOM TENGAH -->
<div class="middle-column-title">Dokumen Favorit</div>

<form method="post" action="<?php echo site_url(); ?>user/favourite/add_folder" id="form-folder" runat="server">
  <div class="setting-box container-fluid">
    <div class="col-md-8">
      <div class="setting-welcome"><strong>Tambah Folder</strong></div>
      <div class="setting-label">Nama Folder</div>
      <input type="text" class="setting-input" name="folder_name" value="">
      <div class="clearfix"></div>
    </div>
  </div>
  <button class="setting-button" type="submit" id="btn-folder">Simpan</button>
  <div id="msg-folder"></div>
</form>

<div class="setting-history">

  <hr>

  <div class="folder-list">

    <?php
      if(count($folder) < 1)
      {
        echo '<p>Tidak ada folder.</p>';
      }
      else
      {
        foreach($folder as $row)
        {
    ?>
          <div class="setting-items">
            <div class="setting-docname">
              <div class="dropdown dropdown-inline">
                <a id="dLabel_<?php echo $row['folder_id']; ?>" title="Pindahkan ke Folder" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> 
                </a>

                <ul class="dropdown-menu" aria-labelledby="dLabel_<?php echo $row['folder_id']; ?>">
                  <li><a href="<?php echo site_url(); ?>user/favourite/delete_folder/<?php echo $row['folder_id']; ?>" onclick="return confirm('Anda yakin ingin menghapus folder ini?')">Hapus</a></li>
                  <li><a href="<?php echo site_url(); ?>user/favourite/folder/<?php echo $row['folder_id']; ?>/<?php echo $row['folder_url']; ?>">Ganti</a></li>
                </ul>
              </div>
              <a href="<?php echo site_url(); ?>user/favourite/folder/<?php echo $row['folder_id']; ?>/<?php echo $row['folder_url']; ?>"><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> <strong><?php echo $row['folder_name']; ?></strong></a>
            </div>
            <div class="setting-docnumber"><?php echo count_document_in_folder($row['folder_id']); ?> Dokumen</div>
          </div>
    <?php
        }
      }
    ?>

  </div>

  <hr>

  <?php
    if(count($favourite) > 0)
    {
  ?>

  <div class="file-list">
    <?php
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
          <a href="<?php echo site_url('peraturan-pajak/read/'.$favourite['permalink']); ?>" data-toggle="modal" data-target=".doc-modal" id="<?php echo $favourite['id']; ?>" data-idmodal="<?php echo $favourite['id']; ?>" data-remote="false" class="modalcaller">
          <?php echo $favourite['jenis_dokumen_lengkap']; ?></a>
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
          <a href="<?php echo site_url('p3b/read/'.$favourite['p3b_url']); ?>" data-toggle="modal" data-target=".doc-modal-p3b"  data-remote="false" class="modalcaller-p3b" data-id="<?php echo $favourite['p3b_id']; ?>" id="<?php echo $favourite['p3b_id']; ?>">
          Perjanjian Penghindaran Pajak Berganda</a>
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
          <a href="<?php echo site_url('putusan-pengadilan-pajak/read/'.$favourite['permalink']); ?>" data-toggle="modal" data-target=".doc-modal-pp" data-remote="false"  class="modalcaller-pp" data-id="<?php echo $favourite['id']; ?>" id="<?php echo $favourite['id']; ?>">Putusan Pengadilan Pajak</a>
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
          <a href="<?php echo site_url('putusan-mahkamah-agung/read/'.$favourite['ma_url']); ?>" data-toggle="modal" data-target=".doc-modal-ma" data-remote="false" class="modalcaller-ma" data-id="<?php echo $favourite['ma_id']; ?>" id="<?php echo $favourite['ma_id']; ?>">Putusan Mahkamah Agung</a>
        </div>
        <div class="setting-docnumber"><?php echo $favourite['ma_number']; ?></div>
        <!--<div class="setting-docdelete"><a href="#" title="hapus" class="delete-favourite"><span class="glyphicon glyphicon-remove-sign"></span></a></div>-->
      </div>
      <?php
      }
      ?>

      <?php
      }
      ?>
  </div>

  <hr>

  <?php
    }
  ?>

</div>