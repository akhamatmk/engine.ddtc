<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['sitemap\.xml'] = "sitemap/sitemap";

//$route['peraturan-pajak'] = 'peraturan_pajak';

$route['peraturan-pajak'] = 'peraturan_pajak';
$route['peraturan-pajak/index'] = 'peraturan_pajak/index';
$route['peraturan-pajak/index/(:num)'] = 'peraturan_pajak/index/$1';
$route['peraturan-pajak/read/(:any)'] = 'peraturan_pajak/read/$1';
$route['peraturan-pajak/download/(:any)/(:num)'] = 'peraturan_pajak/download/$1/$1';
//$route['peraturan-pajak/downloadnoc/(:any)'] = 'peraturan_pajak/downloadnoc/$1';
$route['peraturan-pajak/topsearch'] = 'peraturan_pajak/topsearch';
$route['peraturan-pajak/search'] = 'peraturan_pajak/search';
$route['peraturan-pajak/search/(:any)'] = 'peraturan_pajak/search/$1';
$route['peraturan-pajak/search/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3/$4';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3/$4/$5';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3/$4/$5/$6';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3/$4/$5/$6/$7';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3/$4/$5/$6/$7/$8';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['peraturan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] = 'peraturan_pajak/search/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';
$route['peraturan-pajak/search_all'] = 'peraturan_pajak/search_all';
$route['peraturan-pajak/search_all/(:any)'] = 'peraturan_pajak/search_all/$1';
$route['peraturan-pajak/search_all/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4/$5';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4/$5/$6';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4/$5/$6/$7';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4/$5/$6/$7/$8';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['peraturan-pajak/search_all/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] = 'peraturan_pajak/search_all/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';

$route['peraturan-pajak/do_search'] = 'peraturan_pajak/do_search';
$route['peraturan-pajak/get_riwayat'] = 'peraturan_pajak/get_riwayat';

$route['putusan-pengadilan-pajak/index'] = 'putusan_pengadilan_pajak/index';
$route['putusan-pengadilan-pajak/index/(:num)'] = 'putusan_pengadilan_pajak/index/$1';
$route['putusan-pengadilan-pajak/read/(:any)'] = 'putusan_pengadilan_pajak/read/$1';
$route['putusan-pengadilan-pajak/search'] = 'putusan_pengadilan_pajak/search';
$route['putusan-pengadilan-pajak/search/(:any)'] = 'putusan_pengadilan_pajak/search/$1';
$route['putusan-pengadilan-pajak/search/(:any)/(:any)'] = 'putusan_pengadilan_pajak/search/$1/$2';
$route['putusan-pengadilan-pajak/search/(:any)/(:any)/(:any)'] = 'putusan_pengadilan_pajak/search/$1/$2/$3';
$route['putusan-pengadilan-pajak/search/(:any)/(:any)/(:any)/(:any)'] = 'putusan_pengadilan_pajak/search/$1/$2/$3/$4';
$route['putusan-pengadilan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'putusan_pengadilan_pajak/search/$1/$2/$3/$4/$5';
$route['putusan-pengadilan-pajak/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] = 'putusan_pengadilan_pajak/search/$1/$2/$3/$4/$5/$6';

$route['putusan-pengadilan-pajak'] = 'putusan_pengadilan_pajak';
$route['putusan-pengadilan-pajak/do_search'] = 'putusan_pengadilan_pajak/do_search';

$route['putusan-mahkamah-agung/index'] = 'putusan_mahkamah_agung/index';
$route['putusan-mahkamah-agung/index/(:num)'] = 'putusan_mahkamah_agung/index/$1';
$route['putusan-mahkamah-agung/read/(:any)'] = 'putusan_mahkamah_agung/read/$1';
$route['putusan-mahkamah-agung/search'] = 'putusan_mahkamah_agung/search';
$route['putusan-mahkamah-agung/search/(:any)'] = 'putusan_mahkamah_agung/search/$1';
$route['putusan-mahkamah-agung/search/(:any)/(:any)'] = 'putusan_mahkamah_agung/search/$1/$2';
$route['putusan-mahkamah-agung/search/(:any)/(:any)/(:any)'] = 'putusan_mahkamah_agung/search/$1/$2/$3';
$route['putusan-mahkamah-agung/search/(:any)/(:any)/(:any)/(:any)'] = 'putusan_mahkamah_agung/search/$1/$2/$3/$4';
$route['putusan-mahkamah-agung/search/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'putusan_mahkamah_agung/search/$1/$2/$3/$4/$5';
$route['putusan-mahkamah-agung/search/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] = 'putusan_mahkamah_agung/search/$1/$2/$3/$4/$5/$6';

$route['putusan-mahkamah-agung'] = 'putusan_mahkamah_agung';
$route['putusan-mahkamah-agung/do_search'] = 'putusan_mahkamah_agung/do_search';

$route['info/(:any)'] = 'page/view/$1';
