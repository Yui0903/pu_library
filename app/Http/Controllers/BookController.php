<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = DB::table('books')
            ->join('students', 'books.sid', '=', 'students.id')
            ->select('books.*', 'students.name as username')
            ->get();
        //->paginator(6);
        //
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'sid' => 'required',
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'ISBN' => 'required',
            'price' => 'required',
            'ready' => 'required',
            'pub_date' => 'required',
            'photo' => 'required|image|max:2048'
        ]);
        //
        // * 讀取 upload file
        $image = $request->file('photo');
        // * 存檔 image
        $new_name = 'book_' . now()->format('YmdHis') . rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        // * 更新對應欄位
        $book = new Book([
            'sid' => $request->get('sid'),
            //'sid' => Auth::user()->id,
            //
            'title' => $request->get('title'),
            'author' => $request->get('author'),
            'publisher' => $request->get('publisher'),
            'ISBN' => $request->get('ISBN'),
            'price' => $request->get('price'),
            'pub_date' => $request->get('pub_date'),
            'photo_path' => $new_name,
            'ready' => $request->get('ready')
        ]);
        //
        try {
            $book->save();
            return redirect('/books')->with('success', '推薦圖書資料已成功儲存!');
        } catch (\Exception $ex) {
            return redirect('/books')->with('fail', '錯誤: ' . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
