<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Sasaran;
use App\Kegiatan;
use App\Skpd;

date_default_timezone_set('Asia/Jakarta');

class SasaranController extends Controller
{
    public function index()
    {
      $opd = Skpd::where("is_deleted", 0)->get();
      $kegiatan = Kegiatan::where("is_deleted", 0)->get(); 
      return view('mst.sasaran-list', [
        'opd' => $opd,
        'kegiatan' => $kegiatan,
      ]);
    }

    public function create()
    {
      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();
      return view('mst.sasaran-form',[
        'parent' => $parent
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => 'required',
        'opd' => 'required',
        'dari' => 'required',
        'sampai' => 'required'
      ],[
        'nama.required' => 'Nama Sasaran harus diisi!',
        'nama.unique' => 'Nama Sasaran sudah ada!',
        'opd.required' => 'Perangkat Daerah harus diisi!',
        'dari.required' => 'Dari harus diisi!',
        'sampai.required' => 'Sampai harus diisi!',
      ]);

      $dari = explode('-', $request->input('dari'));
      $dari = $dari[2].'-'.$dari[1].'-'.$dari[0];
      $sampai = explode('-', $request->input('sampai'));
      $sampai = $sampai[2].'-'.$sampai[1].'-'.$sampai[0];

      $use = [
        'input' => $request->input(),
        'dari' => $dari,
        'sampai' => $sampai
      ];

      DB::transaction(function() use ($use) {
        $t = new Kegiatan;
        $t->nama = $use['input']['nama'];
        $t->id_skpd = $use['input']['opd'];
        $t->dari = $use['dari'].' 00:00:00';
        $t->sampai = $use['sampai'].' 00:00:00';
        $t->created_at = date('Y-m-d H:i:s');
        $t->created_by = Auth::id();
        $t->save();

        foreach($use['input']['sasaran'] AS $i => $v){
          $t2 = new Sasaran;
          $t2->nama = $v;
          $t2->id_kegiatan = $t->id;
          $t2->save();
        }
      });


      $request->session()->flash('success', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/sasaran');
    }

    public function edit($id)
    {
      $data = Sasaran::find($id);

      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();

      return view('mst.sasaran-form', [
        'data' => $data,
        'parent' => $parent
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => 'required',
        'opd' => 'required',
        'dari' => 'required',
        'sampai' => 'required'
      ],[
        'nama.required' => 'Nama Sasaran harus diisi!',
        'nama.unique' => 'Nama Sasaran sudah ada!',
        'opd.required' => 'Perangkat Daerah harus diisi!',
        'dari.required' => 'Dari harus diisi!',
        'sampai.required' => 'Sampai harus diisi!',
      ]);

      $dari = explode('-', $request->input('dari'));
      $dari = $dari[2].'-'.$dari[1].'-'.$dari[0];
      $sampai = explode('-', $request->input('sampai'));
      $sampai = $sampai[2].'-'.$sampai[1].'-'.$sampai[0];

      $use = [
        'input' => $request->input(),
        'id' => $id, // id_kegiatan
        'dari' => $dari,
        'sampai' => $sampai
      ];

      DB::transaction(function() use ($use) {

        $t = Kegiatan::findOrFail($use['id']);
        $t->nama = $use['input']['nama'];
        $t->id_skpd = $use['input']['opd'];
        $t->dari = $use['dari'].' 00:00:00';
        $t->sampai = $use['sampai'].' 00:00:00';
        $t->updated_at = date('Y-m-d H:i:s');
        $t->updated_by = Auth::id();
        $t->save();

        DB::table('mst_sasaran')
        ->where('id_kegiatan', $use['id'])
        ->update(['is_deleted' => 1]);

        foreach($use['input']['sasaran'] AS $i => $v){
          $t2 = new Sasaran;
          $t2->nama = $v;
          $t2->id_kegiatan = $t->id;
          $t2->save();
        }
      });

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/sasaran');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();

      DB::transaction(function() use ($id) {
        $t = Kegiatan::findOrFail($id);
        $t->deleted_at = date('Y-m-d H:i:s');
        $t->deleted_by = Auth::id();
        $t->is_deleted = 1;
        $t->save();

        DB::table('mst_sasaran')
        ->where('id_kegiatan', $id)
        ->update(['is_deleted' => 1]);
      });

      $request->session()->flash('success', "Data berhasil Dihapus!");
      return redirect('/mst/sasaran');
    }

    public function list_datatables_api()
    {
      $data = DB::table("mst_kegiatan AS k")
      ->select(DB::raw("k.id, k.nama AS kegiatan, skpd.name AS skpd, k.dari, k.sampai"))
      ->join("mst_skpd AS skpd", "skpd.id", "=", "k.id_skpd")
      ->where("k.is_deleted", 0)
      ->orderBy('k.id', 'ASC');
      return Datatables::of($data)->make(true);
    }

    public function get_kegiatan_by_id(Request $request)
    {
      $data = Kegiatan::find($request->input('id'));
      return response()->json($data);
    }

    public function get_sasaran_by_id_kegiatan(Request $request)
    {
      $data = Sasaran::where('id_kegiatan', $request->input('id'))
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

      return response()->json($data);
    }
}
