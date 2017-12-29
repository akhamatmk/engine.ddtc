<div class="middle-column-title">Putusan Pengadilan Pajak</div>


<form class="p3-form" action="<?php echo site_url(); ?>putusan-pengadilan-pajak/do_search" method="post" id="form-search-pp">
  <div class="form-putusan-pengadilan">
    <div class="p3-title">Cari Putusan Pengadilan</div>

    <div>
      <p><a href="#" style="color: #F77B04; text-decoration: blink; font-size: 1.2em;" class="info" data-toggle="modal" data-target="#modalInfoPp"><span class="glyphicon glyphicon-info-sign"></span> <blink>Panduan Pencarian</blink></a></p>
    </div>
    
    <div class="col-md-4 inputs">
      <input type="text" class="form-control" placeholder="Masukkan Kata Kunci" name="search_key" value="<?php echo $pp_key; ?>">
    </div>
    <div class="col-md-3 inputs">
      <input type="text" class="form-control" placeholder="Masukkan Nomor Putusan" name="search_number" value="<?php echo $pp_number; ?>">
    </div>
    <div class="col-md-3 inputs">
      <select class="form-control" name="search_jenis_pp">
        <option value="semua-jenis-putusan-pengadilan-pajak">Semua Jenis Putusan</option>
      <?php
        $arr_jp = array();
        $last = "";
        foreach($jenis_pp as $row)
        {
          $jenis_pajak = $row['jenis_pajak'];

          //$jenis_pajak = strip_tags(htmlspecialchars_decode($jenis_pajak));

          $jenis_pajak = str_replace('&lt;p&gt;', '', $jenis_pajak);
          $jenis_pajak = str_replace('&lt;/p&gt;', '', $jenis_pajak);

          $jenis_pajak = str_replace('&ltp&gt', '', $jenis_pajak);
          $jenis_pajak = str_replace('&lt/p&gt', '', $jenis_pajak);

          $jenis_pajak = str_replace('&lt;strong&gt;', '', $jenis_pajak);
          $jenis_pajak = str_replace('&lt;/strong&gt;', '', $jenis_pajak);

          $jenis_pajak = str_replace('&ltstrong&gt', '', $jenis_pajak);
          $jenis_pajak = str_replace('&lt/strong&gt', '', $jenis_pajak);

          $jenis_pajak = str_replace('&nbsp;', '', $jenis_pajak);
          $jenis_pajak = str_replace('&nbsp', '', $jenis_pajak);

          $jenis_pajak = str_replace(';', '', $jenis_pajak);
          $jenis_pajak = str_replace(':', '', $jenis_pajak);

          $jenis_pajak = str_replace('  ', ' ', $jenis_pajak);

          $jenis_pajak = trim($jenis_pajak);
          $jenis_pajak = trim($jenis_pajak);
          $jenis_pajak = trim($jenis_pajak);

          $jenis_pajak_url = url_title($jenis_pajak, '-', TRUE);

          if(!in_array($jenis_pajak, $arr_jp) && $jenis_pajak != '')
          {
            $arr_jp[] = $jenis_pajak;
      ?>
        <option value="<?php echo $jenis_pajak_url; ?>" <?php echo ($jenis_pajak_url === $this->uri->segment(5)) ? 'selected' : ''; ?>><?php echo $jenis_pajak; ?></option>
      <?php
          }

          $last = $jenis_pajak;
        }
      ?>
      </select>
    </div>
    <div class="col-md-2 inputs">
      <select class="form-control" name="search_tahun">
        <option value="all">Semua Tahun</option>
      <?php
        foreach($tahun_pp as $row)
        {
      ?>
        <option value="<?php echo $row['tahun_keputusan']; ?>" <?php echo ($row['tahun_keputusan'] === $this->uri->segment(6)) ? 'selected' : ''; ?>><?php echo $row['tahun_keputusan']; ?></option>
      <?php
        }
      ?>
      </select>
    </div>
    <div class="p3-metode-search">
      <strong>Metode </strong> 
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode1" value="kalimat" <?php echo ($this->uri->segment(7) == 'kalimat') ? 'checked="checked"' : ''; ?><?php echo (!$this->uri->segment(7)) ? 'checked="checked"' : ''; ?>> Kalimat
      </label>
      <!--<label class="radio-inline">
        <input type="radio" name="search_method" id="metode2" value="dan" <?php echo ($this->uri->segment(7) == 'dan') ? 'checked="checked"' : ''; ?>> Dan
      </label>-->
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode3" value="atau" <?php echo ($this->uri->segment(7) == 'atau') ? 'checked="checked"' : ''; ?>> Atau
      </label>
    </div>
  </div>
  <button class="p3-btn-search" id="btn-search-pp">Cari Dokumen</button>
  <div id="msg-search-pp"></div>
</form>

<?php
  $jenis_pajak = $result['jenis_pajak'];
  
  $jenis_pajak = str_replace('&lt;p&gt;', '', $jenis_pajak);
  $jenis_pajak = str_replace('&lt;/p&gt;', '', $jenis_pajak);

  $jenis_pajak = str_replace('&ltp&gt', '', $jenis_pajak);
  $jenis_pajak = str_replace('&lt/p&gt', '', $jenis_pajak);

  $jenis_pajak = str_replace('&lt;strong&gt;', '', $jenis_pajak);
  $jenis_pajak = str_replace('&lt;/strong&gt;', '', $jenis_pajak);

  $jenis_pajak = str_replace('&ltstrong&gt', '', $jenis_pajak);
  $jenis_pajak = str_replace('&lt/strong&gt', '', $jenis_pajak);

  $jenis_pajak = str_replace('&nbsp;', '', $jenis_pajak);
  $jenis_pajak = str_replace('&nbsp', '', $jenis_pajak);

  $jenis_pajak = str_replace(';', '', $jenis_pajak);
  $jenis_pajak = str_replace(':', '', $jenis_pajak);

  $jenis_pajak = str_replace('  ', ' ', $jenis_pajak);

  $jenis_pajak = trim($jenis_pajak);
  $jenis_pajak = trim($jenis_pajak);
  $jenis_pajak = trim($jenis_pajak);
?>
<div class="p3-search-item">
  <div class="p3-category"><?php echo $jenis_pajak; ?></div>
  <div class="search-result-item-meta"><?php echo format_tanggal_indonesia($result['created'], 'long'); ?> | View: <?php echo $result['view'];?></div>
  <div class="p3-title">
    <a href="<?php echo site_url('putusan-pengadilan-pajak/read/'.$result['permalink']); ?>" data-toggle="modal" data-target=".doc-modal-pp" data-remote="false"  class="modalcaller-pp" data-id="<?php echo $result['id']; ?>" id="<?php echo $result['id']; ?>">
      <?php echo $result['name'];?>
    </a>
  </div>
  <div class="p3-desc">
<?php
  /*$pokok_sengketa = $result['pokok_sengketa'];
  $pokok_sengketa = strip_tags(html_entity_decode($pokok_sengketa));
  $pokok_sengketa = str_replace(';', '', $pokok_sengketa);
  //$pokok_sengketa = str_replace(':', '', $pokok_sengketa);
  $pokok_sengketa = trim($pokok_sengketa);

  echo $pokok_sengketa;*/

  $isi_putusan = $result['isi_putusan'];
  $isi_putusan = strip_tags(html_entity_decode($isi_putusan));

  echo character_limiter($isi_putusan, 500); 
?>
  </div>
</div>