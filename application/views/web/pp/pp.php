<div class="middle-column-title">Putusan Pengadilan Pajak</div>
  <div class="middle-column-result">
    <?php if($type && $type == 'searchresult') { ?>
      Jumlah Putusan Pengadilan Pajak : <span><?php echo $countall; ?></span> Putusan 
    <?php } else { ?>
      Jumlah Putusan Pengadilan Pajak : <span><?php echo $count; ?></span> Putusan 
    <?php } ?>
    <div class="P3-last-update">Terakhir diperbarui <span><?php echo format_tanggal_indonesia($latest_pp['modified']); ?></span></div>
  </div>


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
      <?php if($this->session->userdata('user_email') != 'tukangdezain@gmail.com') { ?>
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdown-left" data-toggle="dropdown" aria-expanded="true" dropdowntype="Jenis Putusan">
          <?php
            $search_jenis_url = $this->uri->segment(5);
            if(!empty($search_jenis_url)) {
              if(strpos($search_jenis_url, '_')) {
                $search_jenis_pp_array = explode('_', $search_jenis_url);

                $count_sd2 = count($search_jenis_pp_array);

                if($count_sd2 == 0)
                {
                  echo '<p>Semua Jenis Putusan</p>';
                }
                else
                {
                  if($search_jenis_url == 'semua-jenis-putusan-pengadilan-pajak')
                  {
                    echo '<p>Semua Jenis Putusan</p>';
                  }
                  else
                  {
                    echo '<p>'.$count_sd2.' jenis putusan dipilih</p>';
                  }
                }
              } else {
                  if($search_jenis_url == 'semua-jenis-putusan-pengadilan-pajak')
                  {
                    echo '<p>Semua Jenis Putusan</p>';
                  }
                  else
                  {
                    echo '<p>1 jenis putusan dipilih</p>';
                  }
                  $search_jenis_pp_array = [$search_jenis_url];
              }
            } else {
              echo '<p>Semua Jenis Putusan</p>';
            }
          ?>
          </button>
          <ul class="dropdown-menu home-menu-kind">
            <?php
              $arr_jp = array();
              $last = "";
              $nojenis = 1;
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

                //$jenis_pajak = str_replace('&nbsp;', '', $jenis_pajak);
                //$jenis_pajak = str_replace('&nbsp', '', $jenis_pajak);

                $jenis_pajak = str_replace(';', '', $jenis_pajak);
                $jenis_pajak = str_replace(':', '', $jenis_pajak);

                $jenis_pajak = str_replace('  ', ' ', $jenis_pajak);

                $jenis_pajak = trim($jenis_pajak);
                $jenis_pajak = trim($jenis_pajak);
                $jenis_pajak = trim($jenis_pajak);

                $jenis_pajak_url = str_replace('&', 'dan', $jenis_pajak);
                $jenis_pajak_url = url_title($jenis_pajak_url, '-', TRUE);

                if(!in_array($jenis_pajak, $arr_jp) && $jenis_pajak != '')
                {
                  $arr_jp[] = $jenis_pajak;
            ?>
              <li>
                <input type="checkbox" id="jenis<?php echo $nojenis; ?>" name="search_jenis_pp_array[]" value="<?php echo $jenis_pajak_url; ?>" <?php echo (in_array($jenis_pajak_url, $search_jenis_pp_array)) ? 'checked' : ''; ?>>
                <label for="jenis<?php echo $nojenis; ?>"><?php echo $jenis_pajak; ?></label>
              </li>
            <?php
                }

                $last = $jenis_pajak;
                $nojenis++;
              }
            ?>
          </ul>
        </div>
      <?php } else { ?>
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

            $jenis_pajak_url = str_replace('&', 'dan', $jenis_pajak);
            $jenis_pajak_url = url_title($jenis_pajak_url, '-', TRUE);

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
      <?php } ?>
    </div>
    <div class="col-md-2 inputs">
      <?php if($this->session->userdata('user_email') != 'tukangdezain@gmail.com') { ?>
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdown-left" data-toggle="dropdown" aria-expanded="true" dropdowntype="Tahun">
          <?php
            $search_tahun_url = $this->uri->segment(6);
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
              foreach($tahun_pp as $row)
              {
            ?>
              <li>
                <input type="checkbox" id="tahun<?php echo $no; ?>" name="search_tahun_array[]" value="<?php echo $row['tahun_keputusan']; ?>" <?php echo (in_array($row['tahun_keputusan'], $search_tahun_array)) ? 'checked' : ''; ?>>
                <label for="tahun<?php echo $no; ?>"><?php echo $row['tahun_keputusan']; ?></label>
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
          <?php foreach($tahun_pp as $row) { ?>
            <option value="<?php echo $row['tahun_keputusan']; ?>" <?php echo ($row['tahun_keputusan'] === $this->uri->segment(6)) ? 'selected' : ''; ?>><?php echo $row['tahun_keputusan']; ?></option>
          <?php } ?>
        </select>
      <?php } ?>
    </div>
    <div class="p3-metode-search">
      <strong>Metode </strong> 
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode1" value="kalimat" <?php echo ($this->uri->segment(7) == 'kalimat') ? 'checked="checked"' : ''; ?><?php echo (!$this->uri->segment(7)) ? 'checked="checked"' : ''; ?>> Kalimat
      </label>
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode2" value="dan" <?php echo ($this->uri->segment(7) == 'dan') ? 'checked="checked"' : ''; ?>> Dan
      </label>
      <label class="radio-inline">
        <input type="radio" name="search_method" id="metode3" value="atau" <?php echo ($this->uri->segment(7) == 'atau') ? 'checked="checked"' : ''; ?>> Atau
      </label>
    </div>
  </div>
  <button class="p3-btn-search" id="btn-search-pp">Cari Dokumen</button>
  <div id="msg-search-pp"></div>
</form>
<?php if($type && $type == 'searchresult') { ?>
  <div class="middle-column-title">Hasil Pencarian</div>
  <div class="middle-column-result"><span><?php echo $count; ?> Dokumen</span> ditemukan</div>
<?php } ?>
<div class="toolbar">
  Urut berdasarkan : 
  <button type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false" data-url="<?php echo $url_year; ?>" id="pp-tahun">Tahun <span class="glyphicon glyphicon-sort"></span></button>
  |
  <button type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-expanded="false" data-url="<?php echo $url_number; ?>" id="pp-nomor">Nomor <span class="glyphicon glyphicon-sort"></span></button>
</div>

<?php
foreach($result as $row)
{
  $jenis_pajak = $row['jenis_pajak'];
  
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
  <div class="search-result-item-meta"><?php echo format_tanggal_indonesia($row['created'], 'long'); ?> | View: <?php echo $row['view'];?></div>
  <div class="p3-title">
    <a href="<?php echo site_url('putusan-pengadilan-pajak/read/'.$row['permalink']); ?>" data-toggle="modal" data-target=".doc-modal-pp" data-remote="false"  class="modalcaller-pp" data-id="<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
      <?php echo $row['name'];?>
    </a>
  </div>
  <div class="p3-desc">
<?php
  /*$pokok_sengketa = $row['pokok_sengketa'];
  $pokok_sengketa = strip_tags(html_entity_decode($pokok_sengketa));
  $pokok_sengketa = str_replace(';', '', $pokok_sengketa);
  //$pokok_sengketa = str_replace(':', '', $pokok_sengketa);
  $pokok_sengketa = trim($pokok_sengketa);

  echo $pokok_sengketa;*/

  $isi_putusan = $row['isi_putusan'];
  $isi_putusan = strip_tags(html_entity_decode($isi_putusan));

  echo character_limiter($isi_putusan, 500); 
?>
  </div>
</div>
<?php
}
?>

<nav class="search-pagination"><?php echo $paging; ?></nav>