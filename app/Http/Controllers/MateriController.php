<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\mataPelajaran;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Siswa;
use App\Models\Tentor;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:student|teacher|materi.index|materi.showMateri|materi.showlist']);
    }

    public function index()
    {
        $materis = Materi::latest()->when(request()->q, function ($materis) {
            $materis = $materis->where('judul', 'like', '%' . request()->q . '%');
        })->paginate(10);
        $mataPelajaran = mataPelajaran::latest()->get();
        $kelass = new Kelas();
        $user = new User();
        return view('materi.index', compact('materis', 'mataPelajaran', 'kelass', 'user'));
    }

    public function create()
    {
        $mataPelajaran = mataPelajaran::latest()->get();
        $kelass = Kelas::latest()->get();
        $user = Auth::user();

        return view('materi.create', compact('mataPelajaran', 'kelass', 'user'));
    }

    public function store(Request $request)
    {

        $name = '';
        if ($request->hasFile('document')) {
            $name = $request->document->getClientOriginalName();
            $this->validate($request, [
                'kelas'  => 'required',
                'mapel'  => 'required',
                'judul'  => 'required',
                'isi'    => 'required',
                'document'     => 'mimes:doc,docx,pdf,pptx,xlsx',
            ]);
            //upload document
            $document = $request->file('document');
            $document->storeAs('public/materis', $name);
        } else {
            $this->validate($request, [
                'kelas'  => 'required',
                'mapel'  => 'required',
                'judul'  => 'required',
                'isi'    => 'required',
            ]);
        }

        $materi = Materi::create([
            'kelas'           => $request->input('kelas'),
            'mapel'           => $request->input('mapel'),
            'judul'           => $request->input('judul'),
            'isi'             => $request->input('isi'),
            'user_id'         => Auth()->id(),
            'link'            => $name,
        ]);


        if ($materi) {
            //redirect dengan pesan sukses
            return redirect()->route('materi.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('materi.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Materi $materi)
    {
        $mataPelajaran = mataPelajaran::latest()->get();
        $kelass = Kelas::latest()->get();
        $user = User::latest()->get();

        return view('materi.edit', compact('materi', 'mataPelajaran', 'kelass', 'user'));
    }

    public function update(Request $request, Materi $materi)
    {
        $this->validate($request, [
            'kelas'  => 'required',
            'mapel'  => 'required',
            'judul'  => 'required',
            'isi'    => 'required',
            'document'     => 'mimes:doc,docx,pdf,pptx,xlsx',
        ]);

        $document = $request->file('document');
        $document->storeAs('public/materis', $document->getClientOriginalName());

        $materi->update([
            'kelas'           => $request->input('kelas'),
            'mapel'           => $request->input('mapel'),
            'judul'           => $request->input('judul'),
            'isi'             => $request->input('isi'),
            'user_id'         => Auth()->id(),
            'link'            => $document->getClientOriginalName(),
        ]);

        if ($materi) {
            //redirect dengan pesan sukses
            return redirect()->route('materi.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('materi.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();


        if ($materi) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }


    public function showMateri($id)
    {
        $user = Auth::user($id);
        $materis = Materi::findOrFail($id);

        return view('materi.showMateri', compact('user', 'materis'));
    }

    public function listMateri($id)
    {
        $mataPelajaran = mataPelajaran::findOrFail($id);
        // $materis = Materi::get();
        $materis = Materi::where('mapel', $mataPelajaran->mata_pelajaran)->get();

        return view('materi.listMateri', compact('mataPelajaran', 'materis'));
    }
}