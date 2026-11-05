<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth';
$route['404_override']       = '';
$route['translate_uri_dashes'] = FALSE;

$route['Hlogin\.php']         = 'Legacy/login';
$route['Hregristulang\.php']  = 'Legacy/register';
$route['beranda\.php']        = 'Legacy/dashboard';
$route['laporan\.php']        = 'Legacy/laporan_form';
$route['detail_laporan\.php'] = 'Legacy/detail_laporan';
$route['chat\.php']           = 'Legacy/chat';
$route['Profile\.php']        = 'Legacy/profil';
$route['pengaturan\.php']     = 'Legacy/pengaturan';
$route['ganti_sandi\.php']    = 'Legacy/ganti_sandi';
$route['lupa_password\.php']  = 'Legacy/lupa_password';
$route['logout\.php']         = 'Legacy/logout';
