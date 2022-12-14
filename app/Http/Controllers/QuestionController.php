<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Video;
use App\Models\Document;
use App\Models\Question;
use App\Models\QuestionEssay;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:teacher|permission:questions.index|questions.create|questions.edit|questions.delete']);
    }

    public function index()
    {
        $questions = Question::where('created_by', Auth()->id())->latest()->when(request()->q, function ($questions) {
            $questions = $questions->where('pertanyaan', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $subject = new Subject();
        $video = new Video();
        $audio = new Audio();
        $document = new Document();
        $image = new Image();
        $user = new User();

        return view('questions.index', compact('questions', 'video', 'audio', 'document', 'image', 'user', 'subject'));
    }

    public function create()
    {
        $subjects = Subject::latest()->get();
        $videos = Video::latest()->get();
        $audios = Audio::latest()->get();
        $images = Image::latest()->get();
        $documents = Document::latest()->get();
        return view('questions.create', compact('subjects', 'videos', 'audios', 'images', 'documents'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject_id'  => 'required',
            'pertanyaan'  => 'required',
            'option_A'    => 'required',
            'option_B'    => 'required',
            'answer'      => 'required',
        ]);

        $question = Question::create([
            'subject_id'    => $request->input('subject_id'),
            'pertanyaan'    => $request->input('pertanyaan'),
            'option_A'      => $request->input('option_A'),
            'option_B'      => $request->input('option_B'),
            'option_C'      => $request->input('option_C'),
            'option_D'      => $request->input('option_D'),
            'option_E'      => $request->input('option_E'),
            'video_id'      => $request->input('video_id'),
            'audio_id'      => $request->input('audio_id'),
            'image_id'      => $request->input('image_id'),
            'document_id'   => $request->input('document_id'),
            'answer'        => $request->input('answer'),
            'penjelasan'   => $request->input('penjelasan'),
            'created_by'    => Auth()->id()
        ]);


        if ($question) {
            //redirect dengan pesan sukses
            return redirect()->route('questions.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('questions.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Question $question)
    {
        $videos = Video::latest()->get();
        $audios = Audio::latest()->get();
        $images = Image::latest()->get();
        $subjects = Subject::latest()->get();
        $documents = Document::latest()->get();
        return view('questions.edit', compact('question', 'videos', 'audios', 'images', 'documents', 'subjects'));
    }

    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'subject_id'  => 'required',
            'pertanyaan'  => 'required',
            'option_A'    => 'required',
            'option_B'    => 'required',
            'answer'      => 'required',
        ]);

        $question = Question::findOrFail($question->id);

        $question->update([
            'subject_id'    => $request->input('subject_id'),
            'pertanyaan'    => $request->input('pertanyaan'),
            'option_A'      => $request->input('option_A'),
            'option_B'      => $request->input('option_B'),
            'option_C'      => $request->input('option_C'),
            'option_D'      => $request->input('option_D'),
            'option_E'      => $request->input('option_E'),
            'video_id'      => $request->input('video_id'),
            'audio_id'      => $request->input('audio_id'),
            'image_id'      => $request->input('image_id'),
            'document_id'   => $request->input('document_id'),
            'answer'        => $request->input('answer'),
            'penjelasan'   => $request->input('penjelasan'),
            'created_by'    => Auth()->id()
        ]);

        if ($question) {
            //redirect dengan pesan sukses
            return redirect()->route('questions.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('questions.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();


        if ($question) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}