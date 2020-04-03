<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
use App\Siswa;
use App\Autentikasi;
use App\Pembayaran;
use App\Tagihan;
use App\Kelas;
use Image;
use File;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $siswa = Siswa::paginate(10);
        return view('pages.siswa', compact(['siswa']));
    }

    public function tambah()
    {
        $kelas = Kelas::all();
        return view('pages.tambahsiswa', compact(['kelas']))->with('status','tambah');
    }

    public function detail($slug,$id)
    {
        $auth = Autentikasi::where('siswa_id',$id)->first();        
        $tagihan = Tagihan::where('siswa_id',$id)->where('tipetagihan_id','>=','2')->get();
        $tagihan_spp = Tagihan::where('siswa_id',$id)->where('tipetagihan_id','1')->get();
        $siswa = Siswa::where('slug',$slug)->first();
        $history = Pembayaran::where('siswa_id',$id)->orderBy('id', 'DESC')->get();
        return view('pages.detailsiswa', compact(['siswa','history','tagihan_spp','tagihan','auth']));
    }

    public function store(Request $request, $tipekelas_id)
    {
        // $messages = [
        //     'required' => ':attribute wajib diisi',
        //     'min' => ':attribute harus diisi minimal :min karakter',
        //     'max' => ':attribute harus diisi maksimal :max karakter',
        //     'email' => ':attribute memerlukan "@"'
        // ];

        // $this->validate($request, [
        //     'nis' => 'bail|required|integer',
        //     'nisn' => 'bail|required|integer',
        //     'nama_siswa' => 'bail|required|string|max:255',
        //     'slug' => 'bail|required|string',
        //     'alamat' => 'bail|required|string',
        //     'no_telp' => 'bail|required|string',
        //     'id_kelas' => 'bail|required|integer',
        //     'email' => 'bail|required|email',
        //     'password' => 'required|string',
        // ], $messages);

        $path = "uploaded/images/profil_siswa/";
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        $profil = $request->file('profil');
        $nama_gambar = explode(" ", $request->nama_siswa)[0] . '_Profil_' . Carbon::now()->format('Y_m_d') . '.' . $profil->getClientOriginalExtension(); 
        Image::make(File::get($profil))->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path.$nama_gambar);

        $siswa_id = Siswa::orderBy('id','desc')->first()->id+1;

        $siswa = new Siswa;
        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->slug = Str::slug($request->nama_siswa,'-');
        $siswa->alamat = $request->alamat;
        $siswa->no_telp = $request->no_telp;
        $siswa->kelas_id = $request->id_kelas;
        $siswa->tipekelas_id = $tipekelas_id;
        $siswa->profil = $nama_gambar;
        $siswa->role_id = 1;
        $siswa->save();

        $auth = new Autentikasi;
        $auth->nomor_induk = $request->nis;
        $auth->email = $request->email;
        $auth->password = Hash::make($request->password);
        $auth->role_id = 1;
        $auth->siswa_id = $siswa_id;
        $auth->save();

        $notification = array(
            'title' => 'Berhasil',
            'description' => 'Siswa Berhasil Ditambahkan!',
            'alert-type' => 'success'
        );

        return redirect('data/siswa')->with($notification);
    }

    public function showupdate(Request $request, $slug, $id)
    {
        $auth = Autentikasi::where('siswa_id', $id)->first();
        $siswa = Siswa::where('slug', $slug)->first();
        $kelas = Kelas::all();
        return view('pages.tambahsiswa', compact(['kelas','siswa','auth']))->with('status','update');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->slug = Str::slug($request->nama_siswa,'-');
        $siswa->alamat = $request->alamat;
        $siswa->no_telp = $request->no_telp;
        $siswa->kelas_id = $request->id_kelas;
        $siswa->updated_at = Carbon::now()->format('Y-m-d H:i:s');

        if($request->hasfile('profil')){
            $gambar_lama = public_path("uploaded/images/profil_siswa/" . $siswa->profil);
            \File::delete($gambar_lama);

            $profil = $request->file('profil');
            $nama_gambar = explode(" ", $request->nama_siswa)[0] . '_Profil_' . Carbon::now()->format('Y_m_d') . '.' . $profil->getClientOriginalExtension(); 
            Image::make(File::get($profil))->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploaded/images/profil_siswa/" . $nama_gambar);
            $siswa->profil = $nama_gambar;
        }
        $siswa->update();

        $auth = Autentikasi::where('siswa_id',$id)->first();
        $auth->nomor_induk = $request->nis;
        $auth->email = $request->email;
        if(strlen($request->password)>0)
        {
            $auth->password = Hash::make($request->password);
        }
        $auth->update();

        $notification = array(
            'title' => 'Berhasil',
            'description' => 'Siswa Berhasil Diperbaharui!',
            'alert-type' => 'success'
        );

        return redirect('data/siswa')->with($notification);
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $gambar_lama = public_path("uploaded/images/profil_siswa/" . $siswa->profil);
        if(\File::exists($gambar_lama)){
            \File::delete($gambar_lama);
        }
        $siswa->delete();

        $auth = Autentikasi::where('siswa_id',$id)->first();
        $auth->delete();

        $tagihan = Tagihan::where('siswa_id',$id)->get()->each->delete();

        return redirect()->back();
    }
}
