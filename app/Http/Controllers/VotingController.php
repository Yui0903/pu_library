<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $votings = DB::table('votings')
            ->join('books', 'votings.bid', '=', 'books.id')
            ->join('students', 'votings.sid', '=', 'students.id')
            ->select('votings.*', 'books.title', 'books.ISBN', 'books.author', 'books.publisher', 'students.name as username')
            ->get();
        //->paginator(6);
        //
        return view('votings.index', compact('votings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return redirect('/books')->with('fail', '無法處理投票');
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
            //'sid' => 'required',
            'bid' => 'required',
        ]);

        $voting = new Voting([
            //'sid' => $request->get('sid'),
            'bid' => $request->get('bid'),
            'voting_date' => now()
        ]);

        try {
            $voting->save();
            return redirect('/votings')->with('success', '投票紀錄已成功儲存');
        } catch (\Exception $ex) {
            return redirect('/books')->with('fail', '錯誤: ' . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return redirect('/books')->with('fail', '無法處理');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return redirect('/books')->with('fail', '無法處理');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voting  $voting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $voting = Voting::find($id);
        if ($voting) {
            $voting->delete();
            //
            return redirect('/votings')->with('success', '票選資料已成功刪除');
        } else {
            return redirect('/votings')->with('fail', 'No matched Voting Data');
        }
    }
}
