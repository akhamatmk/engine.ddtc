<?php

function count_document_in_folder($folder_id)
{
    $CI =& get_instance();

    $CI->load->model('favourite_model');   

    return $CI->favourite_model->count_document_by_folder($folder_id);
}

function get_http_response_code($url) 
{
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function get_p3b_data($p3b_id)
{
    $CI =& get_instance();

    $CI->load->model('p3b_model');

    return $CI->p3b_model->get($p3b_id);
}

function to_romawi($int)
{
    if($int == 1) $r = 'I';
    if($int == 2) $r = 'II';
    if($int == 3) $r = 'III';
    if($int == 4) $r = 'IV';
    if($int == 5) $r = 'V';
    if($int == 6) $r = 'VI';
    if($int == 7) $r = 'VII';
    if($int == 8) $r = 'VIII';
    if($int == 9) $r = 'IX';
    if($int == 10) $r = 'X';

    return $r;
}

function get_data_peraturan_pajak($id)
{
	$CI =& get_instance();

	$CI->load->model('regulasi_pajak_model');

	return $CI->regulasi_pajak_model->get($id);
}

function get_data_dokumen($type, $id)
{
	$CI =& get_instance();

	if($type == 1)
	{
		$CI->load->model('regulasi_pajak_model');

		return $CI->regulasi_pajak_model->get($id);
	}

    if($type == 2)
    {
        $CI->load->model('p3b_model');

        return $CI->p3b_model->get($id);
    }

    if($type == 3)
    {
        $CI->load->model('putusan_pengadilan_model');

        return $CI->putusan_pengadilan_model->get($id);
    }

    if($type == 4)
    {
        $CI->load->model('putusan_ma_model');

        return $CI->putusan_ma_model->get($id);
    }
}

function get_linklist($id_o)
{
	$CI =& get_instance();

	$CI->db->select('linklist', 'publish');
	$CI->db->where('id_o', $id_o);
	$result = $CI->db->get('peraturan_pajak')->row_array();

	return $result['linklist'];
}

function print_linklist($link) 
{
	$CI =& get_instance();

    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul class="tools-list-items">';
        foreach ($links as $rel) 
        {
            if ($rel <> '') 
            {
                $CI->db->where('id_o', $rel);
                $CI->db->where('publish', 1);
                $result = $CI->db->get('regulasi_pajak')->result_array();

                if(count($result) > 0) 
                {
                	foreach($result as $row)
                	{
                		$related .='<li><a id="'.$row['id'].'" class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$row['permalink']).'" target="_blank">' . $row['jenis_dokumen_lengkap'] . ' Nomor : '. $row['nomordokumen'] .'</a></li>';
                	}
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function print_linklist_rp($link) 
{
    $CI =& get_instance();

    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul class="tools-list-items">';
        foreach ($links as $rel) 
        {
            if ($rel <> '') 
            {
                $CI->db->where('id', $rel);
                $CI->db->where('publish', 1);
                $result = $CI->db->get('regulasi_pajak')->result_array();

                if(count($result) > 0) 
                {
                    foreach($result as $row)
                    {
                        $related .='<li><a id="'.$row['id'].'" class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$row['permalink']).'" target="_blank">' . $row['jenis_dokumen_lengkap'] . ' Nomor : '. $row['nomordokumen'] .'</a></li>';
                    }
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function get_history($id_o)
{
	$CI =& get_instance();

	$CI->db->select('historylist', 'publish');
	$CI->db->where('id_o', $id_o);
	$result = $CI->db->get('peraturan_pajak')->row_array();

	return $result['historylist'];
}

function print_history($link) 
{
	$CI =& get_instance();

    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul class="tools-list-items">';
        foreach ($links as $rel) 
        {
        	//echo $rel;

            if ($rel <> '') 
            {
                $CI->db->where('id_o', $rel);
                $CI->db->where('publish', 1);
                $result = $CI->db->get('regulasi_pajak')->result_array();

                if(count($result) > 0) 
                {
                	foreach($result as $row)
                	{
                		$related .='<li><a id="'.$row['id'].'" class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$row['permalink']).'" target="_blank">' . $row['jenis_dokumen_lengkap'] . ' Nomor : '. $row['nomordokumen'] .'</a></li>';
                	}
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function print_history_rp($link) 
{
    $CI =& get_instance();

    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul class="tools-list-items">';
        foreach ($links as $rel) 
        {
            //echo $rel;

            if ($rel <> '') 
            {
                $CI->db->where('id', $rel);
                $CI->db->where('publish', 1);
                $result = $CI->db->get('regulasi_pajak')->result_array();

                if(count($result) > 0) 
                {
                    foreach($result as $row)
                    {
                        $related .='<li><a id="'.$row['id'].'" class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$row['permalink']).'" target="_blank">' . $row['jenis_dokumen_lengkap'] . ' Nomor : '. $row['nomordokumen'] .'</a></li>';
                    }
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function get_status($id_o)
{
    $CI =& get_instance();

    $CI->db->select('statuslist', 'publish');
    $CI->db->where('id_o', $id_o);
    $result = $CI->db->get('peraturan_pajak')->row_array();

    return $result['statuslist'];
}

function print_status($link) 
{
    $CI =& get_instance();

    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul class="tools-list-items">';
        foreach ($links as $rel) 
        {
            //echo $rel;

            if ($rel <> '') 
            {
                $CI->db->where('id_o', $rel);
                $CI->db->where('publish', 1);
                $result = $CI->db->get('regulasi_pajak')->result_array();

                if(count($result) > 0) 
                {
                    foreach($result as $row)
                    {
                        $related .='<li><a id="'.$row['id'].'" class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$row['permalink']).'" target="_blank">' . $row['jenis_dokumen_lengkap'] . ' Nomor : '. $row['nomordokumen'] .'</a></li>';
                    }
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function print_status_rp($link) 
{
    $CI =& get_instance();

    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul class="tools-list-items">';
        foreach ($links as $rel) 
        {
            //echo $rel;

            if ($rel <> '') 
            {
                $CI->db->where('id', $rel);
                $CI->db->where('publish', 1);
                $result = $CI->db->get('regulasi_pajak')->result_array();

                if(count($result) > 0) 
                {
                    foreach($result as $row)
                    {
                        $related .='<li><a id="'.$row['id'].'" class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$row['permalink']).'" target="_blank">' . $row['jenis_dokumen_lengkap'] . ' Nomor : '. $row['nomordokumen'] .'</a></li>';
                    }
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function get_search_select($table, $key, $column, $order) 
{
    global $wpdb;
    $sql = 'SELECT ' . $column . ' FROM ' . $table . ' ORDER BY ' . $column . ' ' . $order . ' LIMIT 1';
	//echo $sql;
    $data = $wpdb->get_row($sql);
	//print_r($data);
    $date = $data->$column;
    $display = date($format, strtotime($date));
    return $display;
}

function get_date_search_form($table, $column, $order, $format) 
{
    global $wpdb;
    $sql = 'SELECT ' . $column . ' FROM ' . $table . ' ORDER BY ' . $column . ' ' . $order . ' LIMIT 1';
	//echo $sql;
    $data = $wpdb->get_row($sql);
	//print_r($data);
    $date = $data->$column;
    $display = date($format, strtotime($date));
    return $display;
}

function form_select_option($a, $z, $selected, $bulan = FALSE, $display = "") 
{
	//$array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
	//'September', 'Oktober', 'November', 'Desember');
    $array_bulan = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
    for ($i = $a; $i <= $z; $i++) 
    {
        $selec = ($i == $selected) ? 'selected' : '';
        if ($bulan == TRUE) 
        {
            $display .='<option value="' . $i . '" ' . $selec . '>' . $array_bulan[$i] . '</option>';
        } 
        else 
        {
            $display .='<option value="' . $i . '" ' . $selec . '>' . $i . '</option>';
        }
    }
    return $display;
}

function format_tanggal_indonesia($date = null, $tipe = null) 
{
	//buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
    $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
	//buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    //$array_bulan = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $array_bulan_pendek = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
    
    if (($date == null ) || ($date == '0000-00-00' )) 
    {
		//jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
        $hari = $array_hari[date('N')];
        $tanggal = date('j');
        $bulan = $array_bulan[date('n')];
        $tahun = date('Y');

        return '';
    } 
    else 
    {
		//jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
        $date = strtotime($date);
        $hari = $array_hari[date('N', $date)];
        $tanggal = date('j', $date);
        $bulan = $array_bulan[date('n', $date)];
        $tahun = date('Y', $date);
    }

    switch ($tipe) 
    {
        case 'day_long':
            $formatTanggal = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;
            break;
        case 'long':
            $formatTanggal = $tanggal . " " . $bulan . " " . $tahun;
            break;
        case 'short':
            $formatTanggal = $tanggal . " " . $array_bulan_pendek[date('n', $date)] . " " . $tahun;
            break;
        case 'short2':
            $formatTanggal = date('d', $date) . "." . date('m', $date) . "." . $tahun;
            break;
        case 'day':
            $formatTanggal = $hari;
            break;

        default:
            $formatTanggal = $tanggal . " " . $bulan . " " . $tahun;
            break;
    }

    return $formatTanggal;
}

function tax_treaty_search_form($archive = NULL) 
{
    $display = '';
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_tax_treaty';
    $link_archive = site_url('tax-treaty?archive=1');
    $sql = 'SELECT DISTINCT negara FROM ' . $table_name . ' ORDER BY negara ASC';
    $datas = $wpdb->get_results($sql);
    $display .='<div id="peraturan_search">
                <form id="search_p" method="get"  action="' . site_url() . '/tax-treaty" class="filter">
                    <p>Search</p>
                    <div class="field topik fieldselect">
                            <label for="id_topik">Choose Country</label>
                            <div class="fieldinput">
                                    <select name="negara" id="negara" >';
    foreach ($datas as $data) 
    {
        $display .= '<option value="' . $data->negara . '">' . $data->negara . '</option>';
    }
    $display .='
                                    </select>
                            </div>
                    </div>
                    <input type="hidden" name="cari" value="1">
                    <input type="hidden" name="archive" value="' . $archive . '">                        
                    <input type="submit" class="submit" value="Search" name="submit" />
                    <a href="' . $link_archive . '" title="Archive Treaty" class="submit">Tax Treaty Archive</a>
                    <div class="clear"></div>
                    <div class="clear"></div>
                    
                    
                </form>
                </div> ';
    return $display;
}

function tax_treaty_search_form_ext($archive = NULL) 
{
    $display = '';
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_tax_treaty';
    $link_archive = site_url('tax-treaty-compare?archive=1');
    $sql = 'SELECT DISTINCT negara FROM ' . $table_name . ' ORDER BY negara ASC';
    $datas = $wpdb->get_results($sql);
    $display .='<div id="peraturan_search">
                <form id="search_p" method="get" action="' . site_url() . '/tax-treaty-compare" class="filter filtertreaty">
                    <p>Search by Country</p>
					<div class="field fieldradio fieldfilled choosecountry">
						<label for="negarasaja">Single Country</label>
						<div class="fieldinput fieldradioarea">
							<input id="negarasaja" class="radio" type="radio" checked="checked" name="modecari" value="negarasaja"></input>
						</div>
					</div>
					<div class="field fieldradio choosecountry">
						<label for="bandingkannegara">Compare Countries</label>
						<div class="fieldinput fieldradioarea">
							<input id="bandingkannegara" class="radio" type="radio" name="modecari" value="bandingkannegara"></input>
						</div>
					</div>
					<div class="clear"></div>
					<div class="field topik fieldselect">
						<label for="pilihnegara1">Choose Country</label>
						<div class="fieldinput">
							<select name="pilihnegara1" id="pilihnegara1" class="pilihnegara" ><option value="" disabled></option>';
    foreach ($datas as $data) 
    {
        $display .= '<option value="' . $data->negara . '">' . $data->negara . '</option>';
    }
    $display .='
							</select>
							<div class="selectarrow"></div>
						</div>
					</div>
					<div class="altcountry">
						<span class="label">compared to</span>
						<div class="field topik fieldselect">
							<label for="pilihnegara2">Choose Country</label>
							<div class="fieldinput">
								<select name="pilihnegara2" id="pilihnegara2" class="pilihnegara" disabled><option value="" disabled></option>';
    foreach ($datas as $data) 
    {
        $display .= '<option value="' . $data->negara . '">' . $data->negara . '</option>';
    }
    $display .='
								</select>
								<div class="selectarrow"></div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="altcountry">
						<span class="label" style="margin-bottom:10px;">Choose Article:</span>
						<div class="clear"></div>
						<div class="field fieldradio fieldfilled">
							<label for="semuapasal">All Article</label>
							<div class="fieldinput fieldradioarea">
								<input id="semuapasal" class="radio" type="radio" checked="checked" name="modepasal" value="semuapasal" disabled></input>
							</div>
						</div>
						<div class="giveorder" tipe="nomorpasal"></div>
						<div class="field fieldradio">
							<label for="articlerange">Article Range</label>
							<div class="fieldinput fieldradioarea">
								<input id="articlerange" class="radio" type="radio" name="modepasal" value="articlerange" disabled></input>
							</div>
						</div>
						<div class="giveorder disabled" tipe="nomorpasal">
							<div class="field tanngal">
								<div class="fieldinput">
									<select id="pasalawal" name="pasalawal" disabled="disabled">';
    for ($x = 1; $x <= 30; $x++) 
    {
        $display .= '<option value="' . $x . '">' . $x . '</option>';
    }
    $display .='
									</select>
								</div>
							</div>
							<span class="label">to</span>
							<div class="field tanngal">
								<div class="fieldinput">
									<select id="pasalakhir" name="pasalakhir" disabled="disabled">';
    for ($y = 1; $y <= 30; $y++) 
    {
        $display .= '<option value="' . $y . '">' . $y . '</option>';
    }
    $display .='
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div class="field fieldradio">
							<label for="specificarticle">Specific Article</label>
							<div class="fieldinput fieldradioarea">
								<input id="specificarticle" class="radio" type="radio" name="modepasal" value="specificarticle" disabled></input>
							</div>
						</div>
						<div class="giveorder disabled" tipe="nomorpasal">
							<div class="field tanngal">
								<div class="fieldinput">
									<select id="pasalkhusus" name="pasalkhusus" disabled="disabled">';
    for ($y = 1; $y <= 30; $y++) 
    {
        $display .= '<option value="' . $y . '">' . $y . '</option>';
    }
    $display .='
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<input type="submit" class="submit" value="Search" name="submit" />
					<a href="' . $link_archive . '" title="Archive Treaty" class="submit">Tax Treaty Archive</a>
                </form>
                </div> ';
    return $display;
}

function peraturan_views_add($id, $views) 
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_peraturan_pajak';
    $wpdb->update($table_name, array('view' => $views), array('id' => $id));
}

function peraturan_search_form() 
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_peraturan_pajak';
    $d_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'j');
    $m_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'n');
    $y_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'Y');
    $d_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'j');
    $m_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'n');
    //$y_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'Y');
	$y_z = date('Y');
    $display = '
		<div id="peraturan_search">
            <form id="search_p" method="get"  action="' . site_url() . '/regulations" class="filter">
				<p>Search</p>
				<div class="field topik fieldselect">
					<label for="id_topik">Choose Topics</label>
					<div class="fieldinput">
						<select name="id_topik" id="id_topik" >
							<option value="">All</option>                            
							<option value="kup">KUP</option> 
							<option value="pph">PPh</option> 
							<option value="ppn">PPN</option> 
							<option value="pbb">PBB</option> 
							<option value="bphtb">BPHTB</option> 
							<option value="bm">Bea Meterai</option> 
							<option value="lainnya">Lainnya</option> 
						</select>
					</div>
				</div>
				<div class="field dokumen fieldselect">
					<label for="id_jenis">Choose Documents Type</label>
					<div class="fieldinput">
						<select name="id_jenis" id="id_jenis">
							<option value="">ALL</option>
							<option value="1000">Undang-Undang</option><option value="2000">Perpu</option><option value="3000">Peraturan Pemerintah</option><option value="3900">Peraturan Presiden</option><option value="4000">Keputusan Presiden</option><option value="4100">Instruksi Presiden</option><option value="5000">Keputusan Bersama Menteri</option><option value="5050">Peraturan Menteri Keuangan</option><option value="5100">Keputusan Menteri Keuangan</option><option value="5140">Peraturan Bersama Menteri</option><option value="5150">Peraturan Menteri Perdagangan</option><option value="5160">Keputusan Menteri Perdagangan</option><option value="5190">Peraturan Menteri Dalam Negeri</option><option value="5200">Keputusan Menteri Dalam Negeri</option><option value="5300">Keputusan Menteri Perindustrian</option><option value="5400">Keputusan Menteri Tenaga Kerja</option><option value="5600">Instruksi Menteri Keuangan</option><option value="5650">Surat Edaran Menteri Keuangan</option><option value="5700">Surat Menteri Keuangan</option><option value="5950">Peraturan Bersama Dirjen</option><option value="6000">Keputusan Bersama Dirjen</option><option value="6050">Peraturan Dirjen Pajak</option><option value="6100">Keputusan Dirjen Pajak</option><option value="6150">Peraturan Dirjen Bea dan Cukai</option><option value="6200">Keputusan Dirjen Bea dan Cukai</option><option value="6210">Peraturan Dirjen Perbendaharaan</option><option value="6220">Keputusan Dirjen Perbendaharaan</option><option value="6230">Peraturan Dirjen Perdagangan Luar Negeri</option><option value="6500">Instruksi Dirjen Pajak</option><option value="7000">Surat Edaran Bersama Dirjen</option><option value="7100">Surat Edaran Dirjen Pajak</option><option value="7200">Surat Edaran Dirjen Bea dan Cukai</option><option value="7300">Surat Edaran Dirjen Anggaran</option><option value="7350">Surat Edaran Dirjen Perbendaharaan</option><option value="7400">Surat Edaran Sekretaris Dirjen Pajak</option><option value="8000">Surat Dirjen Pajak</option><option value="8010">Surat Dirjen Bea dan Cukai</option><option value="8100">Surat Dirjen Anggaran</option><option value="8110">Surat Dirjen Perbendaharaan</option><option value="8150">Surat Sekretaris Dirjen Pajak</option><option value="8160">Surat Direktur Teknis Kepabeanan</option><option value="8170">Surat Direktur</option><option value="8200">Surat Kawat</option><option value="8300">Pengumuman</option><option value="9000">Peraturan Daerah</option><option value="9500">Peraturan Lainnya</option>
						</select>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldradio">
					<label for="p_tgl">Date</label>
					<div class="fieldinput fieldradioarea">
						<input id="p_tgl" name="p_tgl" value="tanggal" type="radio" class="radio">
					</div>
				</div>
				<div class="giveorder disabled" tipe="time">
					<div class="datewrap">
						<div class="field tanggal">
							<div class="fieldinput">
								<select name="tgltgl_awal" id="tgltgl_awal">';
    $display .=form_select_option(1, 31, $d_a);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field bulan">
							<div class="fieldinput">
								<select name="tglbln_awal" id="tglbln_awal">';
    $display .=form_select_option(1, 12, $m_a, TRUE);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field tahun">
							<div class="fieldinput">
								<select name="tglthn_awal" id="tglthn_awal">';
    $display .=form_select_option($y_a, $y_z, $y_a);
    $display .='							
								</select>
							</div>
						</div>
					</div>
					<span class="label">to</span>
					<div class="datewrap">
						<div class="field tanggal">
							<div class="fieldinput">
								<select name="tgltgl_akhir" id="tgltgl_akhir">';
    $display .=form_select_option(1, 31, $d_z);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field bulan">
							<div class="fieldinput">
								<select name="tglbln_akhir" id="tglbln_akhir">';
    $display .=form_select_option(1, 12, $m_z, TRUE);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field tahun">
							<div class="fieldinput">
								<select name="tglthn_akhir" id="tglthn_akhir">';
    $display .=form_select_option($y_a, $y_z, $y_z);
    $display .='							
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldradio fieldfilled">
					<label for="p_thn">Year</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" id="p_thn" name="p_tgl" value="tahun" checked="checked"/>
					</div>
				</div>
				<div class="giveorder" tipe="time">
					<div class="field tahun">
						<div class="fieldinput">
							<select name="tahun_f" id="tahun">
								<option value="">ALL</option>
								<option value="2015">2015</option>
								<option value="2014">2014</option>
								<option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
								<option value="1997">1997</option>
								<option value="1996">1996</option>
								<option value="1995">1995</option>
								<option value="1994">1994</option>
								<option value="1993">1993</option>
								<option value="1992">1992</option>
								<option value="1991">1991</option>
								<option value="1990">1990</option>
								<option value="1989">1989</option>
								<option value="1988">1988</option>
								<option value="1987">1987</option>
								<option value="1986">1986</option>
								<option value="1985">1985</option>
								<option value="1984">1984</option>
								<option value="1983">1983</option>
							</select>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<span class="label">Number</span>
				<div class="field fieldtext nomor">
					<div class="fieldinput">
						<input type="text" class="text" value="" name="nomor" id="nomor"/>
					</div>
				</div>
				<div class="field fieldradio">
					<div class="fieldinput fieldradioarea">
						<input type="checkbox" class="checkbox" value="nomorantara" id="p_no" name="p_no"/>
					</div>
				</div>
				<span class="label">to</span>
				<div class="giveorder" tipe="rangenumber">
					<div class="field fieldtext nomor">
						<div class="fieldinput">
							<input type="text" class="text" value="" name="nomor_end" id="nomor_end" />
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldtext keyword">
					<label for="keyword" class="trans">Keyword</label>
					<div class="fieldinput">
						<input type="text" class="text" value="" id="keyword" name="str" />
					</div>
				</div>
				<div class="fieldgroupwrap">
					<span class="label">Method</span>
					<div class="field fieldradio fieldfilled">
						<label for="match">Match</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="match" name="q_do" id="match" checked="checked"/>
						</div>
					</div>
					<div class="field fieldradio">
						<label for="and">And</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="and" name="q_do" id="and" />
						</div>
					</div>
					<div class="field fieldradio">
						<label for="or">Or</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="or" name="q_do" id="or" />
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<span class="label">Search in:</span>
				<div class="field fieldradio">
					<label for="perihal">About</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" value="perihal" name="dest" id="perihal" />
					</div>
				</div>
				<div class="field fieldradio fieldfilled">
					<label for="isi">Contents</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" value="body" name="dest" id="isi" checked="checked"/>
					</div>
				</div>
				<div class="clear"></div>
				<div class="clear"></div>
				<input type="hidden" name="cari" value="1">
				<input type="submit" class="submit" value="Search" name="submit" />
				<a href="" title="Bantuan" class="submit">Help</a>
            </form>
        </div>        
        ';
    return $display;
}

function regulation_search_form() 
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_regulation';
    $d_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'j');
    $m_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'n');
    $y_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'Y');
    $d_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'j');
    $m_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'n');
    $y_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'Y');
	$y_z = date('Y');
    $display = '
		<div id="peraturan_search">
            <form id="search_p" method="get"  action="' . site_url() . '/regulations" class="filter">
				<p>Search</p>
				<div class="field topik fieldselect">
					<label for="id_topik">Choose Topics</label>
					<div class="fieldinput">
						<select name="id_topik" id="id_topik" >
							<option value="">All</option>                            
							<option value="kup">KUP</option> 
							<option value="pph">PPh</option> 
							<option value="ppn">PPN</option> 
							<option value="pbb">PBB</option> 
							<option value="bphtb">BPHTB</option> 
							<option value="bm">Bea Meterai</option> 
							<option value="lainnya">Lainnya</option> 
						</select>
					</div>
				</div>
				<div class="field dokumen fieldselect">
					<label for="id_jenis">Choose Documents Type</label>
					<div class="fieldinput">
						<select name="id_jenis" id="id_jenis">
<option value="">All</option>
';
    $sql = "SELECT idk, kelompok FROM tf_peraturan_kelompok WHERE status='1' ORDER BY noid ASC";
    $datas = $wpdb->get_results($sql);
    foreach ($datas as $data) {
        $display .= '<option value="' . $data->idk . '">' . $data->kelompok . '</option>';
    }
    $display.='</select>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldradio">
					<label for="p_tgl">Date</label>
					<div class="fieldinput fieldradioarea">
						<input id="p_tgl" name="p_tgl" value="tanggal" type="radio" class="radio">
					</div>
				</div>
				<div class="giveorder disabled" tipe="time">
					<div class="datewrap">
						<div class="field tanggal">
							<div class="fieldinput">
								<select name="tgltgl_awal" id="tgltgl_awal">';
    $display .=form_select_option(1, 31, $d_a);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field bulan">
							<div class="fieldinput">
								<select name="tglbln_awal" id="tglbln_awal">';
    $display .=form_select_option(1, 12, $m_a, TRUE);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field tahun">
							<div class="fieldinput">
								<select name="tglthn_awal" id="tglthn_awal">';
    $display .=form_select_option($y_a, $y_z, $y_a);
    $display .='							
								</select>
							</div>
						</div>
					</div>
					<span class="label">to</span>
					<div class="datewrap">
						<div class="field tanggal">
							<div class="fieldinput">
								<select name="tgltgl_akhir" id="tgltgl_akhir">';
    $display .=form_select_option(1, 31, $d_z);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field bulan">
							<div class="fieldinput">
								<select name="tglbln_akhir" id="tglbln_akhir">';
    $display .=form_select_option(1, 12, $m_z, TRUE);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field tahun">
							<div class="fieldinput">
								<select name="tglthn_akhir" id="tglthn_akhir">';
    $display .=form_select_option($y_a, $y_z, $y_z);
    $display .='							
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldradio fieldfilled">
					<label for="p_thn">Year</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" id="p_thn" name="p_tgl" value="tahun" checked="checked"/>
					</div>
				</div>
				<div class="giveorder" tipe="time">
					<div class="field tahun">
						<div class="fieldinput">
							<select name="tahun_f" id="tahun">
								<option value="">ALL</option>
								<option value="2015">2015</option>
								<option value="2014">2014</option>
								<option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
								<option value="1997">1997</option>
								<option value="1996">1996</option>
								<option value="1995">1995</option>
								<option value="1994">1994</option>
								<option value="1993">1993</option>
								<option value="1992">1992</option>
								<option value="1991">1991</option>
								<option value="1990">1990</option>
								<option value="1989">1989</option>
								<option value="1988">1988</option>
								<option value="1987">1987</option>
								<option value="1986">1986</option>
								<option value="1985">1985</option>
								<option value="1984">1984</option>
								<option value="1983">1983</option>
								<option value="1981">1981</option>
								<option value="1979">1979</option>
								<option value="1978">1978</option>
								<option value="1976">1976</option>
								<option value="1971">1971</option>
								<option value="1970">1970</option>
								<option value="1969">1969</option>
								<option value="1968">1968</option>
								<option value="1967">1967</option>
								<option value="1964">1964</option>
								<option value="1953">1953</option>
								<option value="1952">1952</option>
								<option value="1951">1951</option>
								<option value="1950">1950</option>
							</select>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<span class="label">Number</span>
				<div class="field fieldtext nomor">
					<div class="fieldinput">
						<input type="text" class="text" value="" name="nomor" id="nomor"/>
					</div>
				</div>
				<div class="field fieldradio">
					<div class="fieldinput fieldradioarea">
						<input type="checkbox" class="checkbox" value="nomorantara" id="p_no" name="p_no"/>
					</div>
				</div>
				<span class="label">to</span>
				<div class="giveorder" tipe="rangenumber">
					<div class="field fieldtext nomor">
						<div class="fieldinput">
							<input type="text" class="text" value="" name="nomor_end" id="nomor_end" />
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldtext keyword">
					<label for="keyword" class="trans">Keyword</label>
					<div class="fieldinput">
						<input type="text" class="text" value="" id="keyword" name="str" />
					</div>
				</div>
				<div class="fieldgroupwrap">
					<span class="label">Method</span>
					<div class="field fieldradio fieldfilled">
						<label for="match">Match</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="match" name="q_do" id="match" checked="checked"/>
						</div>
					</div>
					<div class="field fieldradio">
						<label for="and">And</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="and" name="q_do" id="and" />
						</div>
					</div>
					<div class="field fieldradio">
						<label for="or">Or</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="or" name="q_do" id="or" />
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<span class="label">Search in:</span>
				<div class="field fieldradio">
					<label for="perihal">About</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" value="perihal" name="dest" id="perihal" />
					</div>
				</div>
				<div class="field fieldradio fieldfilled">
					<label for="isi">Contents</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" value="body_final" name="dest" id="isi" checked="checked"/>
					</div>
				</div>
				<div class="clear"></div>
				<div class="clear"></div>
				<input type="hidden" name="cari" value="1">
				<input type="submit" class="submit" value="Search" name="submit" />
				<a href="" title="Bantuan" class="submit">Help</a>
            </form>
        </div>        
        ';
    return $display;
}

function tulis_link($link) 
{
    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul>';
        foreach ($links as $rel) 
        {
            if ($rel <> '') 
            {
                $params_link = array('where' => 'id_o= "' . $rel . '"');
                $pods_link = pods('peraturan_pajak', $params_link);
                $related .='<li><a href="' . $pods_link->field('permalink') . '">' . $pods_link->field('perihal') . '</a>
                    <br>' . $pods_link->field('jenis_dokumen_lengkap') . ' - <b>' . $pods_link->field('nomordokumen') . '</b>, tanggal ' . format_tanggal_indonesia($pods_link->field('tanggal')) . '</li>';
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function format_body($link, $body) 
{
    $links = explode(";", $link);
    if (count($links) > 0) 
    {
        foreach ($links as $rel) 
        {
            $params_link = array('where' => 'id_o = "' . $rel . '"');
            $pods_link = pods('peraturan_pajak', $params_link);
            $link_asli = $pods_link->field('nomordokumen');
            $link_asli = str_replace('TAHUN', 'Tahun', $link_asli);
            $link_replace = '<strong><u><a href="' . $pods_link->field('permalink') . '">' . $link_asli . '</a></u></strong>  ';
            $body = str_ireplace($link_asli, $link_replace, $body);
        } //end of foreach        
    }

    return $body;
}

//function peraturan_init() {
//    wp_enqueue_script('peraturan', get_template_directory_uri() . '/js/peraturan.js', false, 'version', false);
//}
//
//add_action('init', 'peraturan');
function regulation_tulis_link($id_reg) 
{
    global $wpdb;
    $links = $wpdb->get_results("SELECT a.ID FROM tf_peraturan_kaitan a, wp212_pods_regulation b WHERE a.ID =  b.id_tf AND a.ID2 ='" . $id_reg . "'");
	//echo count($links);
    if (count($links) > 0) 
    {
        $related = '<ul>';
        foreach ($links as $rel) 
        {
            if ($rel->ID <> '') 
            {
                $params_link = array('where' => 'id_tf= "' . $rel->ID . '"');
                $pods_link = pods('regulation', $params_link);
                $related .='<li><a href="' . $pods_link->field('permalink') . '">' . $pods_link->field('perihal') . '</a>
                    <br>' . $pods_link->field('jenis_dokumen_lengkap') . ' - <b>' . $pods_link->field('nomordokumen') . '</b>, tanggal ' . format_tanggal_indonesia($pods_link->field('tanggal')) . '</li>';
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function regulation_format_body($id_reg, $body) {
    global $wpdb;
    $links = $wpdb->get_results("SELECT a.ID FROM tf_peraturan_kaitan a, wp212_pods_regulation b WHERE a.ID =  b.id_tf AND a.ID2 ='" . $id_reg . "'");
    echo count($links);
    if (count($links) > 0) 
    {
        foreach ($links as $rel) 
        {
            $params_link = array('where' => 'id_tf = "' . $rel->ID . '"');
            $pods_link = pods('regulation', $params_link);
            $link_asli = $pods_link->field('nomordokumen');
            $link_asli = str_replace('TAHUN', 'Tahun', $link_asli);
            $link_replace = '<strong><u><a href="' . $pods_link->field('permalink') . '">' . $link_asli . '</a></u></strong>  ';
            $body = str_ireplace($link_asli, $link_replace, $body);
        } //end of foreach        
    }

    return $body;
}

function regulation_sync_get_link($pods, $column, $id_o) 
{
    $params_link = array('where' => 'id_o = "' . $id_o . '"');
    $pods_link = pods($pods, $params_link);
    $value = $pods_link->field($column);
    return $value;
}

function regulation_sync_tulis_link($link) 
{
    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul>';
        foreach ($links as $rel) 
        {
            if ($rel <> '') 
            {
                $params_link = array('where' => 'id_tb= "' . $rel . '"');
                $pods_link = pods('regulation', $params_link);
                $related .='<li><a href="' . $pods_link->field('permalink') . '">' . $pods_link->field('perihal') . '</a>
                    <br>' . $pods_link->field('jenis_dokumen_lengkap') . ' - <b>' . $pods_link->field('nomordokumen') . '</b>, tanggal ' . format_tanggal_indonesia($pods_link->field('tanggal')) . '</li>';
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function regulation_sync_format_body($link, $body) 
{
    $links = explode(";", $link);
    if (count($links) > 0) 
    {
        foreach ($links as $rel) 
        {
            $params_link = array('where' => 'id_tb = "' . $rel . '"');
            $pods_link = pods('regulation', $params_link);
            $link_asli = $pods_link->field('nomordokumen');
            $link_asli = str_replace('TAHUN', 'Tahun', $link_asli);
            $link_replace = '<strong><u><a href="' . $pods_link->field('permalink') . '">' . $link_asli . '</a></u></strong>  ';
            $body = str_ireplace($link_asli, $link_replace, $body);
        } //end of foreach        
    }

    return $body;
}

function regulation_views_add($id, $views) 
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_regulation';
    $wpdb->update($table_name, array('view' => $views), array('id' => $id));
}

function regulasi_views_add($id, $views) 
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_regulasi';
    $wpdb->update($table_name, array('view' => $views), array('id' => $id));
}

function regulasi_search_form() 
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pods_regulasi';
    $d_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'j');
    $m_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'n');
    $y_a = get_date_search_form($table_name, 'tanggal', 'ASC', 'Y');
    $d_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'j');
    $m_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'n');
    $y_z = get_date_search_form($table_name, 'tanggal', 'DESC', 'Y');
    $display = '
		<div id="peraturan_search">
            <form id="search_p" method="get"  action="' . site_url() . '/regulations" class="filter">
				<p>Search</p>
				<div class="field topik fieldselect">
					<label for="id_topik">Choose Topics</label>
					<div class="fieldinput">
						<select name="id_topik" id="id_topik" >
							<option value="">All</option>                            
							<option value="kup">KUP</option> 
							<option value="pph">PPh</option> 
							<option value="ppn">PPN</option> 
							<option value="pbb">PBB</option> 
							<option value="bphtb">BPHTB</option> 
							<option value="bm">Bea Meterai</option> 
							<option value="lainnya">Lainnya</option> 
						</select>
					</div>
				</div>
				<div class="field dokumen fieldselect">
					<label for="id_jenis">Choose Documents Type</label>
					<div class="fieldinput">
						<select name="id_jenis" id="id_jenis">
<option value="">All</option>
';
    $sql = "SELECT idk, kelompok FROM tf_peraturan_kelompok WHERE status='1' ORDER BY noid ASC";
    $datas = $wpdb->get_results($sql);
    foreach ($datas as $data) {
        $display .= '<option value="' . $data->idk . '">' . $data->kelompok . '</option>';
    }
    $display.='</select>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldradio">
					<label for="p_tgl">Date</label>
					<div class="fieldinput fieldradioarea">
						<input id="p_tgl" name="p_tgl" value="tanggal" type="radio" class="radio">
					</div>
				</div>
				<div class="giveorder disabled" tipe="time">
					<div class="datewrap">
						<div class="field tanggal">
							<div class="fieldinput">
								<select name="tgltgl_awal" id="tgltgl_awal">';
    $display .=form_select_option(1, 31, $d_a);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field bulan">
							<div class="fieldinput">
								<select name="tglbln_awal" id="tglbln_awal">';
    $display .=form_select_option(1, 12, $m_a, TRUE);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field tahun">
							<div class="fieldinput">
								<select name="tglthn_awal" id="tglthn_awal">';
    $display .=form_select_option($y_a, $y_z, $y_a);
    $display .='							
								</select>
							</div>
						</div>
					</div>
					<span class="label">to</span>
					<div class="datewrap">
						<div class="field tanggal">
							<div class="fieldinput">
								<select name="tgltgl_akhir" id="tgltgl_akhir">';
    $display .=form_select_option(1, 31, $d_z);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field bulan">
							<div class="fieldinput">
								<select name="tglbln_akhir" id="tglbln_akhir">';
    $display .=form_select_option(1, 12, $m_z, TRUE);
    $display .='							
								</select>
							</div>
						</div>
						<div class="field tahun">
							<div class="fieldinput">
								<select name="tglthn_akhir" id="tglthn_akhir">';
    $display .=form_select_option($y_a, $y_z, $y_z);
    $display .='							
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldradio fieldfilled">
					<label for="p_thn">Year</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" id="p_thn" name="p_tgl" value="tahun" checked="checked"/>
					</div>
				</div>
				<div class="giveorder" tipe="time">
					<div class="field tahun">
						<div class="fieldinput">
							<select name="tahun_f" id="tahun">
								<option value="">ALL</option>
								<option value="2014">2014</option>
								<option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
								<option value="1997">1997</option>
								<option value="1996">1996</option>
								<option value="1995">1995</option>
								<option value="1994">1994</option>
								<option value="1993">1993</option>
								<option value="1992">1992</option>
								<option value="1991">1991</option>
								<option value="1990">1990</option>
								<option value="1989">1989</option>
								<option value="1988">1988</option>
								<option value="1987">1987</option>
								<option value="1986">1986</option>
								<option value="1985">1985</option>
								<option value="1984">1984</option>
								<option value="1983">1983</option>
								<option value="1981">1981</option>
								<option value="1979">1979</option>
								<option value="1978">1978</option>
								<option value="1976">1976</option>
								<option value="1971">1971</option>
								<option value="1970">1970</option>
								<option value="1969">1969</option>
								<option value="1968">1968</option>
								<option value="1967">1967</option>
								<option value="1964">1964</option>
								<option value="1953">1953</option>
								<option value="1952">1952</option>
								<option value="1951">1951</option>
								<option value="1950">1950</option>
							</select>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<span class="label">Number</span>
				<div class="field fieldtext nomor">
					<div class="fieldinput">
						<input type="text" class="text" value="" name="nomor" id="nomor"/>
					</div>
				</div>
				<div class="field fieldradio">
					<div class="fieldinput fieldradioarea">
						<input type="checkbox" class="checkbox" value="nomorantara" id="p_no" name="p_no"/>
					</div>
				</div>
				<span class="label">to</span>
				<div class="giveorder" tipe="rangenumber">
					<div class="field fieldtext nomor">
						<div class="fieldinput">
							<input type="text" class="text" value="" name="nomor_end" id="nomor_end" />
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="field fieldtext keyword">
					<label for="keyword" class="trans">Keyword</label>
					<div class="fieldinput">
						<input type="text" class="text" value="" id="keyword" name="str" />
					</div>
				</div>
				<div class="fieldgroupwrap">
					<span class="label">Method</span>
					<div class="field fieldradio fieldfilled">
						<label for="match">Match</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="match" name="q_do" id="match" checked="checked"/>
						</div>
					</div>
					<div class="field fieldradio">
						<label for="and">And</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="and" name="q_do" id="and" />
						</div>
					</div>
					<div class="field fieldradio">
						<label for="or">Or</label>
						<div class="fieldinput fieldradioarea">
							<input type="radio" class="radio" value="or" name="q_do" id="or" />
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<span class="label">Search in:</span>
				<div class="field fieldradio">
					<label for="perihal">About</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" value="perihal" name="dest" id="perihal" />
					</div>
				</div>
				<div class="field fieldradio fieldfilled">
					<label for="isi">Contents</label>
					<div class="fieldinput fieldradioarea">
						<input type="radio" class="radio" value="body_final" name="dest" id="isi" checked="checked"/>
					</div>
				</div>
				<div class="clear"></div>
				<div class="clear"></div>
				<input type="hidden" name="cari" value="1">
				<input type="submit" class="submit" value="Search" name="submit" />
				<a href="" title="Bantuan" class="submit">Help</a>
            </form>
        </div>        
        ';
    return $display;
}

function regulasi_ortax_get_link($table, $field, $id_o)
{
    $CI =& get_instance();

    $CI->db->where('id_o', $id_o);

    $result = $CI->db->get($table)->row_array();

    return $result[$field];
}

function regulasi_ortax_tulis_link($link) 
{
    $links = explode(";", $link);
    count($links);
    if (count($links) > 0) 
    {
        $related = '<ul>';
        foreach ($links as $rel) 
        {
            if ($rel <> '') 
            {
                $params_link = array('where' => 'id_o= "' . $rel . '"');
                $pods_link = pods('regulasi', $params_link);
                $total_found = $pods_link->total_found();
                if ($total_found > 0) 
                {
                    $related .='<li><a href="' . $pods_link->field('permalink') . '">' . $pods_link->field('perihal') . '</a>
                    <br>' . $pods_link->field('jenis_dokumen_lengkap') . ' - <b>' . $pods_link->field('nomordokumen') . '</b>, tanggal ' . format_tanggal_indonesia($pods_link->field('tanggal')) . '</li>';
                }
            }
        } //end of foreach
        $related .='<ul>';
    }
    return $related;
}

function regulasi_ortax_format_body_rp($link, $body) 
{
    $links = explode(";", $link);
    if (count($links) > 0) 
    {
        foreach ($links as $rel) 
        {
            $CI =& get_instance();

            $CI->db->where('id', $rel);
            $CI->db->where('publish', 1);
            $result = $CI->db->get('regulasi_pajak')->row_array();

            $link_asli = $result['nomordokumen'];
            $link_asli = str_replace('TAHUN', 'Tahun', $link_asli);
            $link_replace = '<strong><u><a id="'.$result['id'].'"class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$result['permalink']).'" target="_blank">' . $link_asli . '</a></u></strong>';

            $body = str_ireplace($link_asli, $link_replace, $body);
        }
    }

    return $body;
}

function regulasi_ortax_format_body($link, $body) 
{
    $links = explode(";", $link);
    if (count($links) > 0) 
    {
        foreach ($links as $rel) 
        {
            $CI =& get_instance();

            $CI->db->where('id_o', $rel);
            $CI->db->where('publish', 1);
            $result = $CI->db->get('regulasi_pajak')->row_array();

            $link_asli = $result['nomordokumen'];
            $link_asli = str_replace('TAHUN', 'Tahun', $link_asli);
            $link_replace = '<strong><u><a id="'.$result['id'].'"class="modalcaller-newtab" href="'.site_url('peraturan-pajak/read/'.$result['permalink']).'" target="_blank">' . $link_asli . '</a></u></strong>';

            $body = str_ireplace($link_asli, $link_replace, $body);
        }
    }

    return $body;
}

function regulasi_tulis_link_podrel_peraturan($links) 
{
    if (!empty($links)) 
    {
        $related = '<ul>';
        foreach ($links as $rel) 
        {
            $id = $rel['id'];
            $permalink = site_url(trailingslashit('regulations') . $rel['permalink']);
            $related .='<li><a href="' . $permalink . '">' . $rel['perihal'] . '</a>
                    <br>' . $rel['jenis_dokumen_lengkap'] . ' - <b>' . $rel['nomordokumen'] . '</b>, tanggal ' . format_tanggal_indonesia($rel['tanggal']) . '</li>';
        }
        $related .='<ul>';
    }
    return $related;
}

function regulasi_format_body_podrel_peraturan($links, $body) 
{
    if (!empty($links)) 
    {
        foreach ($links as $rel) 
        {
            $id = $rel['id'];
            $link_asli = $rel['nomordokumen'];
            $link_asli = str_replace('TAHUN', 'Tahun', $link_asli);
            $permalink = site_url(trailingslashit('regulations') . $rel['permalink']);
            $link_replace = '<strong><u><a href="' . $permalink . '">' . $rel['nomordokumen'] . '</a></u></strong>  ';
            $body = str_ireplace($link_asli, $link_replace, $body);
        }
    }
    return $body;
}

?>