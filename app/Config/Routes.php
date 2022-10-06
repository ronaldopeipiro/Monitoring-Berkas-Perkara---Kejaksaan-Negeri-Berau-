<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('/sign-in', 'Authorize::sign_in', ['filter' => 'auth_not_login']);
$routes->post('/auth-login', 'Authorize::auth', ['filter' => 'auth_not_login']);

$routes->get('/lupa-password', 'Authorize::lupa_password', ['filter' => 'auth_not_login']);
$routes->post('/send-email-reset-password', 'Authorize::send_email_lupa_password', ['filter' => 'auth_not_login']);

$routes->get('/reset-password/(:any)', 'Authorize::reset_password/$1', ['filter' => 'auth_not_login']);
$routes->post('/reset-password-akun', 'Authorize::reset_password_akun', ['filter' => 'auth_not_login']);

$routes->get('/logout-user', 'Authorize::logout', ['filter' => 'auth_login']);

$routes->get('/', 'Dashboard::index', ['filter' => 'auth_login']);

$routes->get('/berkas-perkara', 'BerkasPerkara::index', ['filter' => 'auth_login']);
$routes->post('/berkas-perkara/add', 'BerkasPerkara::add', ['filter' => 'auth_login']);
$routes->post('/berkas-perkara/edit', 'BerkasPerkara::edit', ['filter' => 'auth_login']);
$routes->post('/berkas-perkara/delete', 'BerkasPerkara::delete', ['filter' => 'auth_login']);

$routes->get('/data-master/jaksa', 'Jaksa::index', ['filter' => 'auth_login']);
$routes->post('/data-master/jaksa/add', 'Jaksa::add', ['filter' => 'auth_login']);
$routes->post('/data-master/jaksa/edit', 'Jaksa::edit', ['filter' => 'auth_login']);
$routes->post('/data-master/jaksa/delete', 'Jaksa::delete', ['filter' => 'auth_login']);

$routes->get('/data-master/instansi', 'Instansi::index', ['filter' => 'auth_login']);
$routes->post('/data-master/instansi/add', 'Instansi::add', ['filter' => 'auth_login']);
$routes->post('/data-master/instansi/edit', 'Instansi::edit', ['filter' => 'auth_login']);
$routes->post('/data-master/instansi/delete', 'Instansi::delete', ['filter' => 'auth_login']);

$routes->get('/pengaturan', 'Pengaturan::index', ['filter' => 'auth_login']);
$routes->post('/pengaturan/ubah-data-akun', 'Pengaturan::ubah_data_akun', ['filter' => 'auth_login']);
$routes->post('/pengaturan/ubah-foto-profil', 'Pengaturan::ubah_foto_profil', ['filter' => 'auth_login']);
$routes->post('/pengaturan/ubah-password', 'Pengaturan::ubah_password', ['filter' => 'auth_login']);

$routes->get('/panduan-aplikasi', 'Guide::panduan', ['filter' => 'auth_login']);
$routes->get('/tentang-aplikasi', 'Guide::tentang', ['filter' => 'auth_login']);

$routes->get('/logout', 'Auth::logout', ['filter' => 'auth_login']);

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
