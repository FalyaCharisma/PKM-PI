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
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:materi.index|materi.create|materi.edit|materi.delete|materi.tentor|materi.showMateri|materi.showlist|pdf']);
    }

    public function index()
    {
        $materis = Materi::latest()->when(request()->q, function ($materis) {
            $materis = $materis->where('judul', 'like', '%' . request()->q . '%');
        })->paginate(5);

        $mataPelajaran = mataPelajaran::latest()->when(request()->q, function ($mataPelajaran) {
            $mataPelajaran = $mataPelajaran->where('mata_pelajaran', 'like', '%' . request()->q . '%');
        })->paginate(5);

        $kelass = Kelas::latest()->when(request()->q, function ($kelass) {
            $kelass = $kelass->where('nama_kelas', 'like', '%' . request()->q . '%');
        })->paginate(5);

        $user = new User();
        // $kelass = new Kelas();
        // $user = new User();
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
                'document'     => 'mimes:doc,docx,pdf,pptx,xlsx|max:30000',
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
        $name = $materi->link;
        if ($request->hasFile('document')) {
            $this->validate($request, [
                'kelas'  => 'required',
                'mapel'  => 'required',
                'judul'  => 'required',
                'isi'    => 'required',
                'document'     => 'mimes:doc,docx,pdf,pptx,xlsx|max:30000',
            ]);

            $name = $request->file('document')->getClientOriginalName();

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

        $materi->update([
            'kelas'           => $request->input('kelas'),
            'mapel'           => $request->input('mapel'),
            'judul'           => $request->input('judul'),
            'isi'             => $request->input('isi'),
            'user_id'         => Auth()->id(),
            'link'            => $name,
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

    public function listMateri($kelas, $mapel)
    {
        $materis = Materi::where('kelas', $kelas)->where('mapel', $mapel)->get();

        return view('materi.listMateri', compact('materis'));
    }

    public function showPdf($id)
    {
        $materis = Materi::findOrFail($id);
        return view('materi.showPdf', compact('materis'));
        // $path = storage_path('materis/' . $materis->link);
        // return Response::make(file_get_contents($path), 200, [
        //     'content-type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="' . $materis->link . '"'
        // ]);
    }
    public function downloadPdf($path)
    {
        // return response()->download('/storage/public/materis/', $path, [], 'inline');
        return Storage::download($path);
    }

    public function getMapel_byKelas($id)
    {
        $materis = DB::table('materi')
            ->where('kelas', $id)
            ->groupBy('mapel')
            ->paginate(5);


        return view('materi.listKelas', compact('materis'));
    }
}