<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $maxBooks = Book::orderBy('price', 'desc')->take(8)->get();
        $minBooks = Book::orderBy('price', 'asc')->take(8)->get();
        return view('dashboard', compact('maxBooks', 'minBooks'));
    }



    public function list(Request $request)
    {
        $categories = Category::orderBy('id')->get();
        $checked = 0;

        $books = Book::orderBy('id')->get();

        $orderby = $request->input('orderby');
        if (!empty($orderby)) {
            switch ($orderby) {
                case 'menu_order':
                    $books = Book::orderBy('id')->get();
                    break;
                case 'date':
                    $books = Book::orderBy('created_at', 'asc')->get();
                    break;
                default:
                    return redirect()->back()->with('error', 'Invalid orderby value');
            }
        }

        $categoryId = $request->input('select_cate');
        if (!empty($categoryId)) {
            $checked = $categoryId;
            $books = Book::where('category_id', $categoryId)->get();
        }
        return view('list', compact('categories', 'books', 'checked'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->thumbnail = $request->thumbnail;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->publication = $request->publication;
        $book->price = $request->price;
        $book->quantity = $request->quantity;
        $book->category_id = $request->category_id;
        $book->save();
        // $validator = Validator::make($request->all(), [
        //     'tile' => 'required',
        //     'thumbnail' => '',
        //     ''
        // ]);
        return response()->json([
            'status' => true,
            'message' => 'Type added successfully',
        ]);

        // if ($validator->passes()) {
        //     // $type = new Book();
        //     // $type->name = $request->name;
        //     // $type->slug = $request->slug;
        //     // $type->status = $request->status;
        //     // $type->save();

        //     dump($request->all());

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Type added successfully',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'errors' => $validator->errors()
        //     ]);
        // }
    }

    public function detail($id)
    {
        $data = Book::with('category')->latest()->find($id);
        return $data;
    }

    public function edit($id)
    {
        $book = Book::find($id);
        return view('edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        $book->title = $request->title;
        $book->thumbnail = $request->thumbnail;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->publication = $request->publication;
        $book->price = $request->price;
        $book->quantity = $request->quantity;
        $book->category_id = $request->category_id;
        $book->save();
        // $validator = Validator::make($request->all(), [
        //     'tile' => 'required',
        //     'thumbnail' => '',
        //     ''
        // ]);
        return response()->json([
            'status' => true,
            'message' => 'Type added successfully',
        ]);
    }
    public function destroy($id)
    {
        $book = Book::find($id);
        if (empty($book)) {
            return response()->json([
                'status' => false,
                'message' => 'Type not found'
            ]);
        }
        $book->delete();
        return response()->json([
            'status' => true,
            'message' => 'book deleted successfully',
        ]);
    }
}
