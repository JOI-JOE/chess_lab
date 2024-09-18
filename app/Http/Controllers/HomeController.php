<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

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
    public function detail($id)
    {
        $data = Book::with('category')->latest()->find($id);
        return $data;
    }
}
