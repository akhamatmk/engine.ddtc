<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      P3B
      <small>View</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/p3b"><i class="fa fa-dashboard"></i> P3B</a></li>
      <li class="active">View</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box box-primary">
          <div class="box-body">
            <div class="row">
              <?php
                $p3b_article_id = "";
                $cur_chapter = 0;
                $empty_id = 0;
                foreach($p3b_article as $row)
                {
                  if($row['p3b_article_chapter'] != 0)
                  {
                    if($row['p3b_article_chapter'] !== $cur_chapter)
                    {
                      $p3b_article_id .= '<p><strong>CHAPTER '.to_romawi($row['p3b_article_chapter']).'</strong><br />';
                      $p3b_article_id .= '<strong>'.$row['p3b_article_chapter_title_id'].'</strong></p>';
                    }

                    $cur_chapter = $row['p3b_article_chapter'];
                  }

                  $p3b_article_id .= '<p><strong>Pasal '.$row['p3b_article_number'].'</strong><br />';
                  $p3b_article_id .= '<strong>'.$row['p3b_article_title_id'].'</strong></p>';
                  $p3b_article_id .= $row['p3b_article_content_id'];

                  if($row['p3b_article_content_id'] == "") $empty_id = 1;
                }

                $p3b_article_en = "";
                $cur_chapter = 0;
                $empty_en = 0;
                foreach($p3b_article as $row)
                {
                  if($row['p3b_article_chapter'] != 0)
                  {
                    if($row['p3b_article_chapter'] !== $cur_chapter)
                    {
                      $p3b_article_en .= '<p><strong>CHAPTER '.to_romawi($row['p3b_article_chapter']).'</strong><br />';
                      $p3b_article_en .= '<strong>'.$row['p3b_article_chapter_title_en'].'</strong></p>';
                    }

                    $cur_chapter = $row['p3b_article_chapter'];
                  }

                  $p3b_article_en .= '<p><strong>Article '.$row['p3b_article_number'].'</strong><br />';
                  $p3b_article_en .= '<strong>'.$row['p3b_article_title_en'].'</strong></p>';
                  $p3b_article_en .= $row['p3b_article_content_en'];

                  if($row['p3b_article_content_en'] == "") $empty_en = 1;
                }
              ?>

              <?php
                if($empty_id == 0 && $empty_en == 0)
                {
              ?>
                <div class="col-xs-6">
                  <h3><?php echo $p3b['p3b_country']; ?></h3>

                  <?php echo $p3b['p3b_header_id']; ?>

                  <?php echo $p3b_article_id; ?>
                </div>
                <div class="col-xs-6">
                  <h3><?php echo $p3b['p3b_country']; ?></h3>

                  <?php echo $p3b['p3b_header_en']; ?>

                  <?php echo $p3b_article_en; ?>
                </div>
              <?php
                }
                if($empty_id == 1 && $empty_en == 0)
                {
              ?>
                <div class="col-xs-12">
                  <h3><?php echo $p3b['p3b_country']; ?></h3>

                  <?php echo $p3b['p3b_header_en']; ?>

                  <?php echo $p3b_article_en; ?>
                </div>
              <?php
                }
                if($empty_id == 0 && $empty_en == 1)
                {
              ?>
                <div class="col-xs-12">
                  <h3><?php echo $p3b['p3b_country']; ?></h3>

                  <?php echo $p3b['p3b_header_id']; ?>

                  <?php echo $p3b_article_id; ?>
                </div>
              <?php
                }
              ?>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->