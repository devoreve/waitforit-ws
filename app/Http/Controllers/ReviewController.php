<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getByMovie($id)
    {
        $movieReviews = DB::table('reviews')
            ->where('movie_id', $id)
            ->get();

        return response()->json([
            'results' => $movieReviews
        ]);
    }

    public function getByUser(Request $request)
    {
        $userReviews = DB::table('reviews')->where('user_id', Auth::user()->id);

        if($request->has('movie_id'))
            $userReviews->where('movie_id', $request->get('movie_id'));

        return response()->json(['results' => $userReviews->get()]);
    }

    public function create(Request $request)
    {
        $review = DB::table('reviews')
            ->where('user_id', Auth::user()->id)
            ->where('movie_id', $request->get('movie_id'))
            ->first();

        if(is_null($review))
        {
            $result = DB::table('reviews')->insert([
                'user_id' => Auth::user()->id,
                'movie_id' => $request->get('movie_id'),
                'status' => $request->get('status'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return response()->json(['success' => $result]);
        }
        else
        {
            return response()->json(['success' => false, 'error' => 'A review already exists for this movie']);
        }
    }

    public function update($id, Request $request)
    {
        $review = DB::table('reviews')
            ->where('user_id', Auth::user()->id)
            ->where('movie_id', $request->get('movie_id'))
            ->first();

        if(!is_null($review))
        {
            DB::table('reviews')
                ->where('id', $id)
                ->update(['status' => $request->get('status'), 'updated_at' => Carbon::now()]);

            return response()->json(['success' => true]);
        }
    }
}