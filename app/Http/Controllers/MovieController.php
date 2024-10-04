<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id')->get();
        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        $genres = Genre::get();
        return view('movies.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $tmp_file = TemporaryFile::where('folder', $request->poster)->first();

        if ($tmp_file) {
            Storage::copy('images/tmp' . '/' . $tmp_file->folder . '/' . $tmp_file->file, 'images' . '/' .  'movie'  . '/'  . $tmp_file->folder . '/' . $tmp_file->file);

            $movie = new Movie();
            $movie->title = $request->title;
            $movie->poster = $tmp_file->folder . '/' . $tmp_file->file;
            $movie->intro = $request->intro;
            $movie->release_date = $request->release_date;
            $movie->genre_id    = $request->genre_id;
            $movie->save();
            Storage::deleteDirectory('images/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response()->json([
                'status' => true,
                'data' => $request->all()
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => $request->all()
        ]);
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        $genres = Genre::get();
        return view('movies.edit', compact('movie', 'genres'));
    }

    public function show($id)
    {
        $data = Movie::with('genre')->find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if ($movie) {
            $movie->title = $request->title;
            // $movie->poster = $movie->poster;
            $movie->intro = $request->intro;
            $movie->release_date = $request->release_date;
            $movie->genre_id    = $request->genre_id;
            $movie->save();

            $old_image = $movie->poster;

            if ($request->poster) {
                $tmp_file = TemporaryFile::where('folder', $request->poster)->first();
                Storage::copy('images/tmp' . '/' . $tmp_file->folder . '/' . $tmp_file->file, 'images' . '/' .  'movie'  . '/'  . $tmp_file->folder . '/' . $tmp_file->file);
                Storage::delete('images/movie/' . $old_image);
                // Update the movie's poster
                $movie->poster = $tmp_file->folder . '/' . $tmp_file->file;
                $movie->save();

                // Delete the temporary directory and file
                Storage::deleteDirectory('images/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
            Storage::deleteDirectory('images/' . $old_image);


            return response()->json([
                'status' => true,
                'data' => $request->all()
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => $request->all()
        ]);
    }

    public function destroy($id)
    {
        $movie = Movie::find($id);
        if (empty($movie)) {
            return response()->json([
                'status' => false,
                'message' => 'Type not found'
            ]);
        }
        $movie->delete();
        return response()->json([
            'status' => true,
            'message' => 'book deleted successfully',
        ]);
    }


    public function tmpUpload(Request $request)
    {
        if ($request->hasFile('poster')) {
            $image = $request->file('poster');
            $file_name = $image->getClientOriginalName();
            $folder = uniqid(prefix: 'image-', more_entropy: true);
            $image->storeAs('images/tmp/' . $folder, $file_name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name
            ]);
            return $folder;
        }
        return '';
    }


    public function tmpDelete()
    {
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        if ($tmp_file) {
            Storage::deleteDirectory('images/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response('');
        }
    }
}
