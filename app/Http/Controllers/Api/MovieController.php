<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::query()->paginate(8);
        return response()->json([
            'success' => true,
            'message' => 'Movie list',
            'data'    => $movies
        ]);
    }

    // chi tiet san pham
    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        try {
            $movie = Movie::query()->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => "Movie form is $id",
                'data'    => $movie
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'false' => false,
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $movie = Movie::query()->findOrFail($id);
            $movie->delete();
            return response()->json([
                'success' => true,
                'message' => 'Delete successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Delete false',
            ]);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => ['required'],
            'intro' => ['required'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'release_date' => ['required'],
            'genre_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'message errors',
                'errors' => $validator->errors()
            ]);
        }

        try {
            $data['poster'] = $this->uploadFile($request, 'poster');

            $movie = Movie::query()->create($data);
            return response()->json([
                'success' => true,
                'message' => 'add new successfully',
                'data' => $movie
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => ['required'],
            'intro' => ['required'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'release_date' => ['required'],
            'genre_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'message errors',
                'errors' => $validator->errors()
            ]);
        }

        try {
            // Lấy dữ liệu
            $moive = Movie::query()->findOrFail($id);
            // Kiểm tra xem tra có cập nhật ảnh ko?
            if ($request->hasFile('poster')) {
                $data['poster'] = $this->uploadFile($request, 'poster');
            } else {
                $data['poster'] = $moive->poster;
            }

            $moive->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Update successfully',
                'data' => $moive
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function uploadFile(Request $request, $filename)
    {
        if ($request->hasFile($filename)) {
            return $request->file($filename)->store('poster');
        }
        return '';
    }
}
