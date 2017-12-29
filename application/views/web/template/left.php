<!-- KOLOM KIRI -->
<div class="col-md-2 left-bar columns"> 
  <div class="left-menu-title">
    <img src="<?php echo site_url(); ?>assets/themes/images/icon_cari_regulasi.svg">
    Cari <span>Peraturan Pajak</span>            
  </div>

  <form id="form-search" method="post" action="<?php echo site_url() ?>peraturan-pajak/do_search">
    <div class="form-group">
      <label>Kata Kunci</label>
      <input type="text" class="form-control" placeholder="Kata Kunci" name="search_key" value="<?php echo $ls_key; ?>">
    </div>
    <div class="form-group">
      <label>Kategori</label>
      <select class="form-control" name="search_category" >
        <option value="semua-kategori" selected="selected">Semua Kategori</option>
      <?php
        foreach($ls_topik as $row)
        {
      ?>
        <option value="<?php echo $row['topik_url']; ?>" <?php echo ($row['topik_url'] === $this->uri->segment(4)) ? 'selected' : ''; ?>><?php echo $row['topik_name']; ?></option>
      <?php
        }
      ?>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Jenis Dokumen</label>
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdown-left" data-toggle="dropdown" aria-expanded="true">
          <?php
              $search_document_url = $this->uri->segment(5);
              $search_document_array = explode('_', $search_document_url);

              $count_sd = count($search_document_array);

              if($count_sd == 0)
              {
                echo '<p>Semua Dokumen</p>';
              }
              else
              {
                if($search_document_url == 'semua-dokumen')
                {
                  echo '<p>Semua Dokumen</p>';
                }
                else
                {
                  echo '<p>'.$count_sd.' selected</p>';
                }
              }
          ?>
          </button>
          <ul class="dropdown-menu home-menu-kind">
            <?php
              $no = 1;
              foreach($ls_jenis_dokumen as $row)
              {
            ?>
              <li>
                <input type="checkbox" id="ID<?php echo $no; ?>" name="search_document[]" value="<?php echo $row['jenis_dokumen_url']; ?>" <?php echo (in_array($row['jenis_dokumen_url'], $search_document_array)) ? 'checked' : ''; ?>>
                <label for="ID<?php echo $no; ?>"><?php echo $row['jenis_dokumen_name']; ?></label>
              </li>
            <?php
                $no++;
              }
            ?>
          </ul>
        </div>
    </div>
    <div class="radio">
      <div class="menu-title">Tanggal</div>
      <label>
          <input type="radio" class="radio-satu" name="search_tanggal" id="opt-one" value="date" checked>
          <div class="input-append date tanggalfrom" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="<?php echo date('d-m-Y'); ?>">
            <input size="16" id="tanggal-from" type="text" value="<?php echo $ls_tanggal_from; ?>" placeholder="dd-mm-yyyy" name="search_date_from">
          </div>
          -
          <div class="input-append date tanggalto" data-date="<?php echo date('d-m-Y'); ?>" data-date-format="<?php echo date('d-m-Y'); ?>">
            <input size="16" id="tanggal-to" type="text" value="<?php echo $ls_tanggal_to; ?>" placeholder="dd-mm-yyyy" name="search_date_to">
          </div>
      </label>
    </div>
    <div class="radio">
      <div class="menu-title">Tahun</div>
      <label>
        <input type="radio" class="radio-dua" name="search_tanggal"  value="year" id="opt-two">
        <select placeholder="semua" class="date-to" id="tahun" disabled name="search_year">
            <option value="0000" selected="selected">Semua</option>
          <?php
            foreach($ls_tahun as $row)
            {
          ?>
            <option value="<?php echo $row['tahun']; ?>" <?php echo ($row['tahun'] === $this->uri->segment(7)) ? 'selected' : ''; ?>><?php echo $row['tahun']; ?></option>
          <?php
            }
          ?>
        </select>
      </label>

    </div>

    <div class="form-group">
      <div class="menu-title">Nomor</div>
      <input type="text" class="date-from" name="search_number_from" value="<?php echo $ls_nomor_from; ?>"> - 
      <input type="text" class="date-to" name="search_number_to" value="<?php echo $ls_nomor_to; ?>">
    </div>

    <div class="form-group">
      <div class="menu-title">Metode Pencarian Kata</div>
      <label class="radio-inline">
        <input type="radio" name="search_method" id="inlineRadio1" value="kalimat" <?php echo ($this->uri->segment(9) == 'kalimat') ? 'checked="checked"' : ''; ?><?php echo (!$this->uri->segment(9)) ? 'checked="checked"' : ''; ?>> Kalimat
      </label>
      <!--<label class="radio-inline">
        <input type="radio" name="search_method" id="inlineRadio2" value="dan"> Dan
      </label>-->
      <label class="radio-inline">
        <input type="radio" name="search_method" id="inlineRadio3" value="atau" <?php echo ($this->uri->segment(9) == 'atau') ? 'checked="checked"' : ''; ?>> Atau
      </label>
    </div>
    <div class="form-group">
      <label class="checkbox-inline">
        <input type="checkbox" id="inlineCheckbox1" name="search_judul" value="1" <?php echo ($this->uri->segment(10)) ? 'checked' : ''; ?>> Cari Hanya di Perihal
      </label>
    </div>

    <button type="submit" class="btn btn-warning btn-cari" id="btn-search">Cari Dokumen</button>
    <div id="msg-search"></div>
  </form>
</div>