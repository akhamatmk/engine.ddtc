<div class="middle-column-title">Perjanjian Penghindaran Pajak Berganda</div>
<div class="middle-column-result">Jumlah Perjanjian Penghindaran Pajak Berganda : <span><?php echo $count; ?> </span>Dokumen P3B
<div class="P3-last-update">Terakhir diperbarui <span><?php echo format_tanggal_indonesia($latest_p3b['p3b_update']); ?></span></div></div>

<div class="input-group treaty-form">
  <div class="form-putusan-pengadilan">
      <div class="p3-title">Cari P3B</div>

    <div>
      <p><a href="#" style="color: #F77B04; text-decoration: blink; font-size: 1.2em;" class="info" data-toggle="modal" data-target="#modalInfoP3b"><span class="glyphicon glyphicon-info-sign"></span> <blink>Panduan Pencarian</blink></a></p>
    </div>
    
  <div class="treaty-form-row">
    <label class="radio-inline">
      <input type="radio" name="treatyradio" id="treaty1" value="option1" checked> Satu Negara
    </label>
  <?php
    if($this->user_auth->is_logged_in())
    {
  ?>
    <label class="radio-inline">
      <input type="radio" name="treatyradio" id="treaty2" value="option2"> Bandingkan Dua Negara
    </label>
  <?php
    }
  ?>
  </div>

  <div class="treaty-form-row row">
    <div class="col-md-4">
      <select id="treaty-country1" class="treaty-select form-control">
          <option value="none">Pilih Negara</option>
        <?php
          foreach($country as $row)
          {
        ?>
          <option value="<?php echo $row['p3b_country']; ?>"><?php echo $row['p3b_country']; ?></option>
        <?php
          }
        ?>
      </select>
    </div>
    <div class="col-md-2 active-compare"><center>dan</center></div>
    <div class="col-md-4">
      <select id="treaty-country2" class="treaty-select form-control active-compare">
          <option value="none">Pilih Negara</option>
        <?php
          foreach($country as $row)
          {
        ?>
          <option value="<?php echo $row['p3b_country']; ?>"><?php echo $row['p3b_country']; ?></option>
        <?php
          }
        ?>
      </select>
    </div>
  </div>

  <div class="active-compare">
    <div class="treaty-form-row"><strong>Bandingkan Pasal</strong></div>

    <div class="treaty-form-row">
      <label class="radio-inline">
        <input type="radio" name="article" id="inlineRadio1" value="all" checked> Semua Pasal
      </label>
      <label class="radio-inline">
        <input type="radio" name="article" id="inlineRadio2" value="cut"> Pasal
        <select class="treaty-select" name="cut_1">
        <?php
        for($i = 1 ; $i <= 30 ; $i++)
        {
        ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php
        }
        ?>
        </select>&nbsp;&nbsp;&nbsp;s/d&nbsp;
        <select class="treaty-select" name="cut_2">
        <?php
        for($i = 1 ; $i <= 30 ; $i++)
        {
        ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php
        }
        ?>
        </select>
      </label>
    </div>

    <div class="treaty-form-row">
      <label class="radio-inline">
        <input type="radio" name="article" id="inlineRadio3" value="one"> Pasal Tertentu &nbsp;
        <select class="treaty-select" name="cut_3">
        <?php
        for($i = 1 ; $i <= 30 ; $i++)
        {
        ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php
        }
        ?>
        </select>
      </label>
    </div>
  </div>
  </div>

  <button class="btn treaty-btn" data-toggle="modal" data-target=".doc-modal-p3b">Cari Dokumen</button>
</div>

<div class="treaty-clearfix"></div>

<?php
foreach($p3b as $row)
{
?>

<div class="treaty-item">
  <div class="col-md-4 treaty-flag"><a href="<?php echo site_url('p3b/read/'.$row['p3b_url']); ?>" data-toggle="modal" data-target=".doc-modal-p3b"  data-remote="false" class="modalcaller-p3b" data-id="<?php echo $row['p3b_id']; ?>" id="<?php echo $row['p3b_id']; ?>"><img class="img-responsive" src="<?php echo site_url(); ?>assets/themes/images/flag/flag-<?php echo strtolower($row['p3b_country']); ?>.png"></a></div>
  <div class="col-md-7">
    <div class="treaty-effective">Effective : <?php echo format_tanggal_indonesia($row['p3b_date_effective']); ?></div>
    <div class="treaty-country"><a href="<?php echo site_url('p3b/read/'.$row['p3b_url']); ?>" data-toggle="modal" data-target=".doc-modal-p3b" data-remote="false" class="modalcaller-p3b" data-id="<?php echo $row['p3b_id']; ?>" id="<?php echo $row['p3b_id']; ?>"><?php echo $row['p3b_country']; ?></a></div>
    <div class="treaty-signed">Signed : <span><?php echo format_tanggal_indonesia($row['p3b_date_signed']); ?></span></div>
  </div>
</div>

<?php
}
?>
<div style="display:block;clear:both;"></div>
<nav class="search-pagination"><?php echo $paging; ?></nav>