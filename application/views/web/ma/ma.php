<div class="middle-column-title">Putusan Mahkamah Agung</div>
  <div class="middle-column-result">
    Jumlah Putusan Mahkamah Agung : <span><?php echo $count; ?></span> Putusan 
    <div class="P3-last-update">Terakhir diperbarui <span><?php echo format_tanggal_indonesia($latest_ma['ma_update']); ?></span></div>
  </div>


<form class="p3-form" action="<?php echo site_url(); ?>putusan-mahkamah-agung/do_search" method="post" id="form-search-ma">
  <div class="form-putusan-pengadilan">
    <div class="p3-title">Cari Putusan Mahkamah Agung</div>

    <div>
      <p><a href="#" style="color: #F77B04; text-decoration: blink; font-size: 1.2em;" class="info" data-toggle="modal" data-target="#modalInfoMa"><span class="glyphicon glyphicon-info-sign"></span> <blink>Panduan Pencarian</blink></a></p>
    </div>

    <div class="col-md-4 inputs">
      <input type="text" class="form-control" placeholder="Nomor" name="search_number" value="<?php echo $ma_number; ?>">
    </div>
    <div class="col-md-6 inputs">
      <input type="text" class="form-control" placeholder="Masukkan Kata Kunci" name="search_key" value="<?php echo $ma_key; ?>">
    </div>    
    <div class="col-md-2 inputs">
      <?php if($this->session->userdata('user_email') != 'tukangdezain@gmail.com') { ?>
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdown-left" data-toggle="dropdown" aria-expanded="true" dropdowntype="Tahun">
          <?php
            $search_tahun_url = $this->uri->segment(5);
            if(!empty($search_tahun_url)) {
              if(strpos($search_tahun_url, '_')) {
                $search_tahun_array = explode('_', $search_tahun_url);

                $count_sd = count($search_tahun_array);

                if($count_sd == 0)
                {
                  echo '<p>Semua Tahun</p>';
                }
                else
                {
                  if($search_tahun_url == '0000')
                  {
                    echo '<p>Semua Tahun</p>';
                  }
                  else
                  {
                    echo '<p>'.$count_sd.' tahun dipilih</p>';
                  }
                }
              } else {
                  if($search_tahun_url == '0000')
                  {
                    echo '<p>Semua Tahun</p>';
                  }
                  else
                  {
                    echo '<p>1 tahun dipilih</p>';
                  }
                  $search_tahun_array = [$search_tahun_url];
              }
            } else {
              echo '<p>Semua Tahun</p>';
            }
          ?>
          </button>
          <ul class="dropdown-menu home-menu-kind">
            <?php
              $no = 1;
              foreach($tahun_ma as $row)
              {
            ?>
              <li>
                <input type="checkbox" id="tahun<?php echo $no; ?>" name="search_tahun_array[]" value="<?php echo $row['ma_year']; ?>" <?php echo (in_array($row['ma_year'], $search_tahun_array)) ? 'checked' : ''; ?>>
                <label for="tahun<?php echo $no; ?>"><?php echo $row['ma_year']; ?></label>
              </li>
            <?php
                $no++;
              }
            ?>
          </ul>
        </div>
      <?php } else { ?>
        <select class="form-control" name="search_tahun">
          <option value="all">Semua Tahun</option>
          <?php foreach($tahun_ma as $row) { ?>
            <option value="<?php echo $row['ma_year']; ?>" <?php echo ($row['ma_year'] === $this->uri->segment(5)) ? 'selected' : ''; ?>><?php echo $row['ma_year']; ?></option>
          <?php } ?>
        </select>
      <?php } ?>
    </div>
    <div class="p3-metode-search">
      <strong>Metode </strong> 
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode1" value="kalimat" <?php echo ($this->uri->segment(6) == 'kalimat') ? 'checked="checked"' : ''; ?><?php echo (!$this->uri->segment(6)) ? 'checked="checked"' : ''; ?>> Kalimat
      </label>
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode2" value="dan" <?php echo ($this->uri->segment(6) == 'dan') ? 'checked="checked"' : ''; ?>> Dan
      </label>
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode3" value="atau" <?php echo ($this->uri->segment(6) == 'atau') ? 'checked="checked"' : ''; ?>> Atau
      </label>
    </div>
  </div>
  <button class="p3-btn-search" id="btn-search-ma">Cari Dokumen</button>
  <div id="msg-search-ma"></div>
</form>

<div class="toolbar">
  Urut berdasarkan : 
  <button type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false" data-url="<?php echo $url_year; ?>" id="pp-tahun">Tahun <span class="glyphicon glyphicon-sort"></span></button>
  |
  <button type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false" data-url="<?php echo $url_number; ?>" id="pp-nomor">Nomor <span class="glyphicon glyphicon-sort"></span></button>
</div>

<?php
foreach($result as $row)
{
?>
<div class="p3-search-item">
  <div class="search-result-item-meta"><?php echo format_tanggal_indonesia($row['ma_create'], 'long'); ?> | View : <?php echo $row['ma_view']; ?><!-- | <a href="">Download PDF</a>--></div>
  <div class="p3-title">
    <a href="<?php echo site_url('putusan-mahkamah-agung/read/'.$row['ma_url']); ?>" data-toggle="modal" data-target=".doc-modal-ma" data-remote="false" class="modalcaller-ma" data-id="<?php echo $row['ma_id']; ?>" id="<?php echo $row['ma_id']; ?>">
      Putusan Mahkamah Agung Nomor: <?php echo $row['ma_number']; ?>
    </a>
  </div>
  <div class="p3-desc">
<?php
  $ma_content = $row['ma_content'];
  $ma_content = strip_tags(html_entity_decode($ma_content));
  $ma_content = str_replace(';', '', $ma_content);
  //$ma_content = str_replace(':', '', $ma_content);
  $ma_content = trim($ma_content);

  echo character_limiter($ma_content, 500);
?>
  </div>
</div>
<?php
}
?>

<nav class="search-pagination"><?php echo $paging; ?></nav>