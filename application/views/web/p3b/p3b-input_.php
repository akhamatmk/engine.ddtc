<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  	<title>Input P3B</title>

  	<link href="<?php echo base_url(); ?>assets/themes/css/bootstrap.min.css" rel="stylesheet">
  	<style type="text/css">
  	.nopadding {
	   	padding: 0 !important;
	   	margin: 0 !important;
	}
  	</style>
</head>
	<body>

	<div class="container">
		<h1>Input Data <small>P3B</small></h1>

		<hr>

		<form action="<?php echo site_url(); ?>p3b/data_input" method="post" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-12">
					<label>Country</label>
					<input type="text" class="form-control" name="p3b_country" value="<?php echo set_value('p3b_country'); ?>">
			    </div>
			</div>

			<hr>

			<div class="form-group">
				<div class="col-sm-12">
					<label>Header [ID]</label>
					<textarea class="form-control ckeditor" rows="5" name="p3b_header_id"><?php echo set_value('p3b_header_id'); ?></textarea>
			    </div>
			</div>

			<div class="form-group">
				<div class="col-sm-12">
					<label>Header [EN]</label>
					<textarea class="form-control ckeditor" rows="5" name="p3b_header_en"><?php echo set_value('p3b_header_en'); ?></textarea>
			    </div>
			</div>

			<hr>

		<?php
			$p3b_article_title = array();

			for($i = 0 ; $i < 30 ; $i++)
			{
				if($i+1 == 1) $p3b_article_title_id[$i] = "ORANG DAN BADAN YANG TERCAKUP DALAM PERSETUJUAN INI";
				if($i+1 == 1) $p3b_article_title_en[$i] = "PERSONAL SCOPE";

				if($i+1 == 2) $p3b_article_title_id[$i] = "PAJAK-PAJAK YANG DICAKUP DALAM PERSETUJUAN INI";
				if($i+1 == 2) $p3b_article_title_en[$i] = "TAXES COVERED";

				if($i+1 == 3) $p3b_article_title_id[$i] = "PENGERTIAN-PENGERTIAN UMUM";
				if($i+1 == 3) $p3b_article_title_en[$i] = "GENERAL DEFINITIONS";

				if($i+1 == 4) $p3b_article_title_id[$i] = "PENDUDUK";
				if($i+1 == 4) $p3b_article_title_en[$i] = "RESIDENT";

				if($i+1 == 5) $p3b_article_title_id[$i] = "BENTUK USAHA TETAP";
				if($i+1 == 5) $p3b_article_title_en[$i] = "PERMANENT ESTABLISHMENT";

				if($i+1 == 6) $p3b_article_title_id[$i] = "PENGHASILAN DARI HARTA TAK GERAK";
				if($i+1 == 6) $p3b_article_title_en[$i] = "INCOME FROM IMMOVABLE PROPERTY";

				if($i+1 == 7) $p3b_article_title_id[$i] = "LABA USAHA";
				if($i+1 == 7) $p3b_article_title_en[$i] = "BUSINESS PROFITS";

				if($i+1 == 8) $p3b_article_title_id[$i] = "PENGANGKUTAN LAUT DAN UDARA";
				if($i+1 == 8) $p3b_article_title_en[$i] = "SHIPPING AND AIR TRANSPORT";

				if($i+1 == 9) $p3b_article_title_id[$i] = "PERUSAHAAN-PERUSAHAAN YANG MEMPUNYAI HUBUNGAN ISTIMEWA";
				if($i+1 == 9) $p3b_article_title_en[$i] = "ASSOCIATED ENTERPRISES";

				if($i+1 == 10) $p3b_article_title_id[$i] = "DIVIDEN";
				if($i+1 == 10) $p3b_article_title_en[$i] = "DIVIDENDS";

				if($i+1 == 11) $p3b_article_title_id[$i] = "BUNGA";
				if($i+1 == 11) $p3b_article_title_en[$i] = "INTEREST";

				if($i+1 == 12) $p3b_article_title_id[$i] = "ROYALTI";
				if($i+1 == 12) $p3b_article_title_en[$i] = "ROYALTIES";

				if($i+1 == 13) $p3b_article_title_id[$i] = "KEUNTUNGAN DARI PEMINDAH TANGANAN HARTA";
				if($i+1 == 13) $p3b_article_title_en[$i] = "CAPITAL GAINS";

				if($i+1 == 14) $p3b_article_title_id[$i] = "PEKERJAAN BEBAS";
				if($i+1 == 14) $p3b_article_title_en[$i] = "INDEPENDENT PERSONAL SERVICES";

				if($i+1 == 15) $p3b_article_title_id[$i] = "PEKERJAAN DALAM HUBUNGAN KERJA";
				if($i+1 == 15) $p3b_article_title_en[$i] = "DEPENDENT PERSONAL SERVICES";

				if($i+1 == 16) $p3b_article_title_id[$i] = "IMBALAN PARA DIREKTUR";
				if($i+1 == 16) $p3b_article_title_en[$i] = "DIRECTORS FEES";

				if($i+1 == 17) $p3b_article_title_id[$i] = "SENIMAN DAN OLAHRAGAWAN";
				if($i+1 == 17) $p3b_article_title_en[$i] = "ARTISTES AND ATHLETES";

				if($i+1 == 18) $p3b_article_title_id[$i] = "PENSIUN";
				if($i+1 == 18) $p3b_article_title_en[$i] = "PENSIONS";

				if($i+1 == 19) $p3b_article_title_id[$i] = "JABATAN DALAM PEMERINTAH";
				if($i+1 == 19) $p3b_article_title_en[$i] = "GOVERNMENT SERVICES";

				if($i+1 == 20) $p3b_article_title_id[$i] = "GURU, PENELITI DAN PARA SISWA";
				if($i+1 == 20) $p3b_article_title_en[$i] = "TEACHERS, RESEARCHERS AND STUDENTS";

				if($i+1 == 21) $p3b_article_title_id[$i] = "PENGHASILAN LAINNYA";
				if($i+1 == 21) $p3b_article_title_en[$i] = "OTHER INCOME";

				if($i+1 == 22) $p3b_article_title_id[$i] = "PAJAK ATAS KEKAYAAN";
				if($i+1 == 22) $p3b_article_title_en[$i] = "TAX ON CAPITAL";

				if($i+1 == 23) $p3b_article_title_id[$i] = "PENGHINDARAN PAJAK BERGANDA";
				if($i+1 == 23) $p3b_article_title_en[$i] = "ELIMINATION OF DOUBLE TAXATION";

				if($i+1 == 24) $p3b_article_title_id[$i] = "NON-DISKRIMINASI";
				if($i+1 == 24) $p3b_article_title_en[$i] = "NON-DISCRIMINATION";

				if($i+1 == 25) $p3b_article_title_id[$i] = "TATACARA PERSETUJUAN BERSAMA";
				if($i+1 == 25) $p3b_article_title_en[$i] = "MUTUAL AGREEMENT PROCEDURE";

				if($i+1 == 26) $p3b_article_title_id[$i] = "PERTUKARAN INFORMASI";
				if($i+1 == 26) $p3b_article_title_en[$i] = "EXCHANGE OF INFORMATION";

				if($i+1 == 27) $p3b_article_title_id[$i] = "PEJABAT DIPLOMATIK DAN KONSULER";
				if($i+1 == 27) $p3b_article_title_en[$i] = "DIPLOMATIC AGENTS AND CONSULAR OFFICERS";

				if($i+1 == 28) $p3b_article_title_id[$i] = "KERJASAMA PENARIKAN PAJAK";
				if($i+1 == 28) $p3b_article_title_en[$i] = "ASSISTANCE IN COLLECTION";

				if($i+1 == 29) $p3b_article_title_id[$i] = "MULAI BERLAKU";
				if($i+1 == 29) $p3b_article_title_en[$i] = "ENTRY INTO FORCE";

				if($i+1 == 30) $p3b_article_title_id[$i] = "PENGAKHIRAN";
				if($i+1 == 30) $p3b_article_title_en[$i] = "TERMINATION";
		?>
			<!--pasal-->
			<div class="form-group">
				<input type="hidden" value="<?php echo $i+1; ?>" name="check[]">
				<div class="col-sm-12">
					<label>PASAL <?php echo $i+1; ?> / ARTICLE <?php echo $i+1; ?></label>
			    </div>
				<div class="col-sm-12">
					<label>Chapter</label>
			      	<select class="form-control select-chapter" id="chapter_<?php echo $i+1; ?>" data-id="<?php echo $i+1; ?>" data-chapter="" name="p3b_chapter[]">
					  	<option value="0">NONE</option>
					  	<option value="1">CHAPTER I</option>
					  	<option value="2">CHAPTER II</option>
					  	<option value="3">CHAPTER III</option>
					  	<option value="4">CHAPTER IV</option>
					  	<option value="5">CHAPTER V</option>
					  	<option value="6">CHAPTER VI</option>
					  	<option value="7">CHAPTER VII</option>
					  	<option value="8">CHAPTER VIII</option>
					  	<option value="9">CHAPTER IX</option>
					  	<option value="10">CHAPTER X</option>
					  	<option value="11">CHAPTER XI</option>
					  	<option value="12">CHAPTER XII</option>
					  	<option value="13">CHAPTER XIII</option>
					  	<option value="14">CHAPTER XIV</option>
					  	<option value="15">CHAPTER XV</option>
					</select>
			    </div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Chapter Title [ID]</label>
			      	<input type="text" class="form-control title-chapter-id" id="title_chapter_id_<?php echo $i+1; ?>" data-id="<?php echo $i+1; ?>" data-chapter="" name="p3b_chapter_title_id[]">
			    </div>
				<div class="col-sm-6">
					<label>Chapter Title [EN]</label>
			      	<input type="text" class="form-control title-chapter-en" id="title_chapter_en_<?php echo $i+1; ?>" data-id="<?php echo $i+1; ?>" data-chapter="" name="p3b_chapter_title_en[]">
			    </div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<label>Article Title [ID]*</label>
					<input type="text" class="form-control" name="p3b_article_title_id[]" value="<?php echo $p3b_article_title_id[$i]; ?>" placeholder="Judul Pasal">
			    </div>
			    <div class="col-sm-6">
			    	<label>Article Title [EN]*</label>
					<input type="text" class="form-control" name="p3b_article_title_en[]" value="<?php echo $p3b_article_title_en[$i]; ?>" placeholder="Article Title">
			    </div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<label>Content [ID]*</label>
					<textarea class="form-control ckeditor" rows="5" name="p3b_article_content_id[]" id=""></textarea>
			    </div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<label>Content [EN]*</label>
					<textarea class="form-control ckeditor" rows="5" name="p3b_article_content_en[]" id=""></textarea>
			    </div>
			</div>

			<hr>
			<!--pasal-->
		<?php
			}
		?>

			<div class="form-group">
				<div class="col-sm-12">
					<label>Protocol [ID]</label>
					<textarea class="form-control ckeditor" rows="5" name="p3b_protocol_id"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<label>Protocol [EN]</label>
					<textarea class="form-control ckeditor" rows="5" name="p3b_protocol_en"></textarea>
				</div>
			</div>

			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<br />
		<br />
	</div>

	<script src="<?php echo base_url(); ?>assets/themes/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/input.js"></script>

  	<script src="//cdn.ckeditor.com/4.5.2/standard/ckeditor.js"></script>
    <script>
    	CKEDITOR.replace('ckeditor');
    </script>

	</body>
</html>