<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewRepository
{
    /**
     * Return a review with it id
     *
     * @param $id
     * @return \stdClass|null
     */
    public function find($id)
    {
        return DB::table('reviews')->where('id', $id)->first();
    }

    /**
     * Return a list of reviews of a movie
     *
     * @param $movieId
     * @return mixed
     */
    public function findByMovie($movieId)
    {
        return DB::table('reviews')->where('movie_id', $movieId)->get();
    }

    /**
     * Return a list of reviews of a user
     * Can be filtered by movie
     *
     * @param $userId
     * @param null $movieId
     * @return array
     */
    public function findByUser($userId, $movieId = null)
    {
        $reviews = DB::table('reviews')->where('user_id', $userId);

        if(!empty($movieId))
        {
            $reviews->where('movie_id', $movieId);
        }

        return $reviews->get();
    }

    /**
     * Create a review
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        return DB::table('reviews')->insert([
            'user_id' => $data['user_id'],
            'movie_id' => $data['movie_id'],
            'status' => $data['status'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Update an existing review
     *
     * @param array $data
     * @param $id
     * @return int
     */
    public function update(array $data, $id)
    {
        return DB::table('reviews')
            ->where('id', $id)
            ->update(['status' => $data['status'], 'updated_at' => Carbon::now()]);
    }

    /**
     * Return true if a user has already reviewed a movie
     *
     * @param $userId
     * @param $movieId
     * @return bool
     */
    public function exist($userId, $movieId)
    {
        return !is_null(DB::table('reviews')
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->first());
    }
}