<?php

namespace App\Repository\Pegawai;

use App\Repository\BaseModel;

class Pegawai extends BaseModel
{
  protected $table = "pgw_pegawai";

  public function pangkat_golongan()
  {
    return $this->belongsTo('App\Repository\Pegawai\PangkatGolongan', 'id_pangkat_golongan');
  }

  public function jabatan()
  {
    return $this->belongsTo('App\Repository\Pegawai\Jabatan', 'id_jabatan');
  }
}
