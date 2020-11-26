<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'DashboardController@index')->name('home');

/* Login section */
Route::get('/login', 'Auth\CustomLoginController@index')->name('login');
Route::get('/403', 'Auth\CustomLoginController@not_allowed')->name('unauthorized');
Route::post('/login', 'Auth\CustomLoginController@login_proses');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

  Route::prefix('mst')->group(function () {

    Route::prefix('skpd')->group(function () {
      Route::get('/', 'Mst\SkpdController@index');
      Route::get('/delete/{id}', 'Mst\SkpdController@destroy');
      Route::get('/datatables', 'Mst\SkpdController@list_datatables_api');
      Route::get('/get_skpd_by_id', 'Mst\SkpdController@get_skpd_by_id');
      Route::get('/get_skpd_by_id_wilayah', 'Mst\SkpdController@get_skpd_by_id_wilayah');
      /* Post section */
      Route::post('/add', 'Mst\SkpdController@store');
      Route::post('/edit/{id}', 'Mst\SkpdController@update');
    });

    Route::prefix('kegiatan')->group(function () {
      Route::get('/', 'Mst\KegiatanController@index');
      Route::get('/add', 'Mst\KegiatanController@create');
      Route::get('/edit/{id}', 'Mst\KegiatanController@edit');
      Route::get('/delete/{id}', 'Mst\KegiatanController@destroy');
      Route::get('/datatables', 'Mst\KegiatanController@list_datatables_api');
      Route::get('/get_kegiatan', 'Mst\KegiatanController@get_kegiatan');
      Route::get('/get_kegiatan_by_id', 'Mst\KegiatanController@get_kegiatan_by_id');
      /* Post section */
      Route::post('/add', 'Mst\KegiatanController@store');
      Route::post('/edit/{id}', 'Mst\KegiatanController@update');
    });

    Route::prefix('sasaran')->group(function () {
      Route::get('/', 'Mst\SasaranController@index');
      Route::get('/add', 'Mst\SasaranController@create');
      Route::get('/edit/{id}', 'Mst\SasaranController@edit');
      Route::get('/delete/{id}', 'Mst\SasaranController@destroy');
      Route::get('/datatables', 'Mst\SasaranController@list_datatables_api');
      Route::get('/get_sasaran_by_id', 'Mst\SasaranController@get_kegiatan_by_id');
      Route::get('/get_sasaran_by_id_program_kerja', 'Mst\SasaranController@get_sasaran_by_id_program_kerja');
      Route::get('/get_sasaran_by_id_skpd', 'Mst\SasaranController@get_kegiatan_by_id_skpd');
      /* Post section */
      Route::post('/add', 'Mst\SasaranController@store');
      Route::post('/edit/{id}', 'Mst\SasaranController@update');
    });

    Route::prefix('periode')->group(function () {
      Route::get('/', 'Mst\PeriodeController@index');
      Route::get('/add', 'Mst\PeriodeController@create');
      Route::get('/edit/{id}', 'Mst\PeriodeController@edit');
      Route::get('/delete/{id}', 'Mst\PeriodeController@destroy');
      Route::get('/datatables', 'Mst\PeriodeController@list_datatables_api');
      /* Post section */
      Route::post('/add', 'Mst\PeriodeController@store');
      Route::post('/edit/{id}', 'Mst\PeriodeController@update');
    });


    Route::prefix('pegawai')->group(function () {
      Route::get('/', 'Mst\PegawaiController@index');
      Route::get('/add', 'Mst\PegawaiController@create');
      Route::get('/edit/{id}', 'Mst\PegawaiController@edit');
      Route::get('/delete/{id}', 'Mst\PegawaiController@destroy');
      Route::get('/datatables', 'Mst\PegawaiController@list_datatables_api');
      Route::get('/get_pegawai_by_id/{id}', 'Mst\PegawaiController@get_pegawai_by_id');

      Route::get('/inspektur', 'Mst\PegawaiController@inspektur');
      /* Post section */
      Route::post('/add', 'Mst\PegawaiController@store');
      Route::post('/edit/{id}', 'Mst\PegawaiController@update');

      Route::post('/inspektur', 'Mst\PegawaiController@update_inspektur');

      Route::post("/get_inspektur_pembantu_by_wilayah", "Mst\PegawaiController@get_inspektur_pembantu_by_wilayah");
      Route::post("/get_pengendali_teknis_by_wilayah", "Mst\PegawaiController@get_pengendali_teknis_by_wilayah");
      Route::post("/get_ketua_tim_by_wilayah", "Mst\PegawaiController@get_ketua_tim_by_wilayah");
      Route::post("/get_anggota_by_wilayah", "Mst\PegawaiController@get_anggota_by_wilayah");
    });

    Route::prefix('struktur')->group(function () {
      Route::get('/', 'Mst\StrukturController@index');
      Route::get('/add', 'Mst\StrukturController@create');
      Route::get('/edit/{id}', 'Mst\StrukturController@edit');
      Route::get('/delete/{id}', 'Mst\StrukturController@destroy');
      Route::get('/datatables', 'Mst\StrukturController@list_datatables_api');

      /* Post section */
      Route::post('/add', 'Mst\StrukturController@store');
      Route::post('/edit/{id}', 'Mst\StrukturController@update');
    });

    Route::prefix('wilayah')->group(function () {
      Route::get('/', 'Mst\WilayahController@index');
      Route::get('/add', 'Mst\WilayahController@create');
      Route::get('/edit/{id}', 'Mst\WilayahController@edit');
      Route::get('/delete/{id}', 'Mst\WilayahController@destroy');
      Route::get('/datatables', 'Mst\WilayahController@list_datatables_api');
      Route::get('/get_wilayah_by_id', 'Mst\WilayahController@get_wilayah_by_id');
      /* Post section */
      Route::post('/add', 'Mst\WilayahController@store');
      Route::post('/edit/{id}', 'Mst\WilayahController@update');
    });

    Route::prefix('jabatan')->group(function () {
      Route::get('/', 'Mst\JabatanController@index');
      Route::get('/add', 'Mst\JabatanController@create');
      Route::get('/edit/{id}', 'Mst\JabatanController@edit');
      Route::get('/delete/{id}', 'Mst\JabatanController@destroy');
      Route::get('/datatables', 'Mst\JabatanController@list_datatables_api');
      /* Post section */
      Route::post('/add', 'Mst\JabatanController@store');
      Route::post('/edit/{id}', 'Mst\JabatanController@update');
    });

    Route::prefix('peran')->group(function () {
      Route::get('/', 'Mst\PeranController@index');
      Route::get('/add', 'Mst\PeranController@create');
      Route::get('/edit/{id}', 'Mst\PeranController@edit');
      Route::get('/delete/{id}', 'Mst\PeranController@destroy');
      Route::get('/datatables', 'Mst\PeranController@list_datatables_api');
      Route::get('/get_peran_by_jabatan/{id}', 'Mst\PeranController@get_peran_by_jabatan');
      /* Post section */
      Route::post('/add', 'Mst\PeranController@store');
      Route::post('/edit/{id}', 'Mst\PeranController@update');
    });

    Route::prefix('program_kerja')->group(function () {
      Route::get('/', 'Mst\ProgramKerjaController@index');
      Route::get('/add', 'Mst\ProgramKerjaController@create');
      Route::get('/edit/{id}', 'Mst\ProgramKerjaController@edit');
      Route::get('/delete/{id}', 'Mst\ProgramKerjaController@destroy');
      Route::get('/datatables', 'Mst\ProgramKerjaController@list_datatables_api');
      Route::get('/get_program_kerja_by_id', 'Mst\ProgramKerjaController@get_program_kerja_by_id');
      /* Post section */
      Route::post('/add', 'Mst\ProgramKerjaController@store');
      Route::post('/edit/{id}', 'Mst\ProgramKerjaController@update');
    });


    Route::prefix('inspektur_pembantu')->group(function () {
      Route::get('/form/{id_wilayah?}', 'Mst\InspekturPembantuController@create');
      Route::post('/form/{id_wilayah?}', 'Mst\InspekturPembantuController@store');
      Route::post("/get_inspektur_pembantu_by_wilayah", "Mst\InspekturPembantuController@get_inspektur_pembantu_by_wilayah");
    });

    Route::prefix('dasar_surat')->group(function () {
      Route::get('/', 'Mst\DasarSuratController@create');
      Route::post('/', 'Mst\DasarSuratController@store');
    });

    Route::prefix('kode_temuan')->group(function () {
      Route::post("/get_kode_temuan_by_level", "Mst\KodeTemuanController@get_kode_temuan_by_level");
      Route::post("/check_last_update", "Mst\KodeTemuanController@check_last_update");
    });
  });


  Route::prefix('pkpt')->group(function () {

    Route::prefix('surat_perintah')->group(function () {
      Route::get('/', 'Pkpt\SuratPerintahController@index');
      Route::get('/add/{type}', 'Pkpt\SuratPerintahController@create');
      Route::get('/edit/{id}', 'Pkpt\SuratPerintahController@edit');
      Route::get('/delete/{id}', 'Pkpt\SuratPerintahController@destroy');
      Route::get('/approve/{id}', 'Pkpt\SuratPerintahController@approve');
      Route::get('/datatables/{type?}', 'Pkpt\SuratPerintahController@list_datatables_api');
      Route::get('/datatables_approve/{type?}', 'Pkpt\SuratPerintahController@list_datatables_approve_api');
      Route::get('/datatables_penomeran_api/{is_avail?}', 'Pkpt\SuratPerintahController@list_datatables_penomeran_api');


      Route::get('/nomer', 'Pkpt\SuratPerintahController@penomeran_surat');

      Route::get('/info/{id}', 'Pkpt\SuratPerintahController@info');
      Route::get('/kalendar', 'Pkpt\SuratPerintahController@kalendar');
      /* Post section */
      Route::post('/add/{type}', 'Pkpt\SuratPerintahController@store');
      Route::post('/edit/{id}', 'Pkpt\SuratPerintahController@update');
      Route::post('/check_jadwal', 'Pkpt\SuratPerintahController@check_jadwal');
      Route::post('/check_jadwal_by_id_kegiatan', 'Pkpt\SuratPerintahController@check_jadwal_by_id_kegiatan');

      Route::post('/rubah_nomer', 'Pkpt\SuratPerintahController@rubah_nomer');
      Route::post('/get_event_sp', 'Pkpt\SuratPerintahController@get_event_sp');
    });
  });

  // Route::prefix('laporan')->group(function () {

  //   Route::prefix('lhp')->group(function () {
  //     Route::get('/', 'Laporan\LhpController@index');
  //     Route::get('/add/{type}', 'Laporan\LhpController@create');
  //     Route::get('/edit/{id}', 'Laporan\LhpController@edit');
  //     Route::get('/delete/{id}', 'Laporan\LhpController@destroy');
  //     Route::get('/approve/{id}', 'Laporan\LhpController@approve');
  //     Route::get('/datatables/{type?}', 'Laporan\LhpController@list_datatables_api');

  //     Route::get('/info/{id}', 'Laporan\LhpController@info');
  //     Route::get('/kalendar', 'Laporan\LhpController@kalendar');
  //     /* Post section */
  //     Route::post('/add/{type}', 'Laporan\LhpController@store');
  //     Route::post('/edit/{id}', 'Laporan\LhpController@update');
  //     Route::post('/check_jadwal', 'Laporan\LhpController@check_jadwal');
  //   });
  // });

  Route::prefix('pemeriksaan')->group(function(){
    Route::prefix('sasaran-tujuan')->group(function () {
      Route::get('/', 'Pemeriksaan\SasaranTujuanController@index');
      Route::get('/datatables', 'Pemeriksaan\SasaranTujuanController@list_datatables_api');
      Route::get('/edit/{id}', 'Pemeriksaan\SasaranTujuanController@edit');
      Route::get('/detail/{id}', 'Pemeriksaan\SasaranTujuanController@detail');

      Route::post('/edit/{id}', 'Pemeriksaan\SasaranTujuanController@update');
    });

    Route::prefix('program-kerja-audit')->group(function () {
      Route::get('/', 'Pemeriksaan\ProgramKerjaAuditController@index');
      Route::get('/datatables', 'Pemeriksaan\ProgramKerjaAuditController@list_datatables_api');
      Route::get('/edit/{id}', 'Pemeriksaan\ProgramKerjaAuditController@edit');

      
      Route::post('/edit/{id}', 'Pemeriksaan\ProgramKerjaAuditController@update');
    });

    Route::prefix('audit')->group(function () {
      Route::get('/', 'Pemeriksaan\AuditController@index');
      Route::get('/datatables', 'Pemeriksaan\AuditController@list_datatables_api');
      Route::get('/edit/{id}', 'Pemeriksaan\AuditController@edit');

      Route::post("/upload_bukti_kertas_kerja/{id_sp}", "Pemeriksaan\AuditController@upload_bukti_kertas_kerja");
      Route::post('/edit/{id}', 'Pemeriksaan\AuditController@update');
    });

    Route::get('/dalnis/buat-sasaran', 'Pemeriksaan\BuatSasaran@index');
    Route::get('/dalnis/detail-penentuan', 'Pemeriksaan\DetailPenentuan@index');
    Route::get('/dalnis/detail-sp', 'Pemeriksaan\DetailSP@index');
    Route::get('/ketua/program-kerja-audit', 'Pemeriksaan\PkaController@index');
    Route::get('/ketua/buat-program', 'Pemeriksaan\BuatProgram@index');
    Route::get('/audit/audit', 'Pemeriksaan\AuditController@index');
    Route::get('/audit/buat-kertaskerja', 'Pemeriksaan\BuatKertasKerja@index');
    Route::get('/audit/buat-kertaskerja-utama', 'Pemeriksaan\BuatKertasKerjaUtama@index');

    Route::get('/irban/draft-nhp', 'Pemeriksaan\DraftNHP@index');
    Route::get('/irban/lhp-tinjut', 'Pemeriksaan\LhpTinjut@index');
    Route::get('/irban/review-lhp', 'Pemeriksaan\ReviewLHP@index');


  });

  Route::prefix('angka-kredit')->group(function(){
    Route::get('/tim-penilai/penilaian-angka-kredit', 'AngkaKredit\PenilaianAngkaKredit@index');
    Route::get('/tim-penilai/penilaian-angka-review', 'AngkaKredit\PenilaianAngkaReview@index');
    Route::get('/tim-penilai/penilaian-angka-catatan', 'AngkaKredit\PenilaianAngkaCatatan@index');

  });

  Route::prefix('acl')->group(function () {
    Route::prefix('role')->group(function () {
      Route::get('/', 'ACL\RoleController@index');
      Route::get('/add', 'ACL\RoleController@create');
      Route::get('/edit/{id}', 'ACL\RoleController@edit');
      Route::get('/delete/{id}', 'ACL\RoleController@destroy');
      Route::get('/datatables', 'ACL\RoleController@list_datatables_api');
      /* Post section */
      Route::post('/add', 'ACL\RoleController@store');
      Route::post('/edit/{id}', 'ACL\RoleController@update');
    });

    Route::prefix('menu')->group(function () {
      Route::get('/', 'ACL\MenuController@index');
      Route::get('/add', 'ACL\MenuController@create');
      Route::get('/edit/{id}', 'ACL\MenuController@edit');
      Route::get('/delete/{id}', 'ACL\MenuController@destroy');
      Route::get('/datatables', 'ACL\MenuController@list_datatables_api');
      /* Post section */
      Route::post('/add', 'ACL\MenuController@store');
      Route::post('/edit/{id}', 'ACL\MenuController@update');
    });

    Route::prefix('permission')->group(function () {
      Route::get('/{role?}', 'ACL\PermissionController@index');
      Route::post('/{role?}', 'ACL\PermissionController@store');
    });

    Route::prefix('user')->group(function () {
      Route::get('/', 'ACL\UserController@index');
      Route::get('/add', 'ACL\UserController@create');
      Route::get('/edit/{id}', 'ACL\UserController@edit');
      Route::get('/delete/{id}', 'ACL\UserController@destroy');
      Route::get('/datatables', 'ACL\UserController@list_datatables_api');
      /* Post section */
      Route::post('/add', 'ACL\UserController@store');
      Route::post('/edit/{id}', 'ACL\UserController@update');
    });
  });

  Route::prefix('dev')->group(function () {
    Route::prefix('config')->group(function () {
      Route::get('/', 'Dev\ConfigController@index');
      Route::get('/add', 'Dev\ConfigController@create');
      Route::get('/edit/{id}', 'Dev\ConfigController@edit');
      Route::get('/delete/{id}', 'Dev\ConfigController@destroy');
      Route::get('/datatables', 'Dev\ConfigController@list_datatables_api');
      /* Post section */
      Route::post('/add', 'Dev\ConfigController@store');
      Route::post('/edit/{id}', 'Dev\ConfigController@update');
    });
  });


  Route::prefix('rka')->group(function () {
      Route::get('/', 'RKA\RKAController@index');
      Route::get('/detail/{id}', 'RKA\RKAController@detail');

      Route::get('/datatables', 'RKA\RKAController@list_datatables_api');
  });

  Route::prefix('upload_kode_rekening')->group(function () {
    Route::get('/', 'Mst\KodeRekeningController@add_temp');
    Route::get('/verify_temp/{id}', 'Mst\KodeRekeningController@verify_temp_form');
    /* Post section */
    Route::post('/', 'Mst\KodeRekeningController@store_temp');
    Route::post('/verify_temp/{id}', 'Mst\KodeRekeningController@verify_temp');
  });

  Route::prefix('upload_rka')->group(function () {
    Route::get('/', 'Mst\RkaUploadController@add_temp');
    Route::get('/verify_temp/{id}', 'Mst\RkaUploadController@verify_temp_form');
    /* Post section */
    Route::post('/', 'Mst\RkaUploadController@store_temp');
    Route::post('/verify_temp/{id}', 'Mst\RkaUploadController@verify_temp');
  });



});
