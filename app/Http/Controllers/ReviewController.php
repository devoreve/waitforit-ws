<?php

namespace App\Http\Controllers;

use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /** @var ReviewRepository $review */
    private $review;

    public function __construct(ReviewRepository $review)
    {
        $this->middleware('auth', ['except' => ['getByMovie']]);
        $this->review = $review;
    }

    /**
     * Return a list of reviews for a movie
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getByMovie($id)
    {
        return response()->json([
            'results' => $this->review->findByMovie($id)
        ]);
    }

    /**
     * Return a list of reviews of a user
     *
     * @param Request $request Request which may contain the movie id in order to filter by movie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getByUser(Request $request)
    {
        $movieId = $request->has('movie_id') ? $request->get('movie_id') : null;
        $userReviews = $this->review->findByUser(Auth::user()->id, $movieId);

        return response()->json(['results' => $userReviews]);
    }

    /**
     * Create a new review
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $hasReviewed = $this->review->exist(Auth::user()->id, $request->get('movie_id'));

        if(!$hasReviewed)
        {
            $success = $this->review->create(array_merge(['user_id' => Auth::user()->id], $request->only(['movie_id', 'status'])));
            return response()->json(['success' => $success]);
        }
        else
        {
            abort(403, 'A review already exists for this movie');
        }
    }

    /**
     * Update an existing review
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request)
    {
        if($this->review->find($id) === null)
        {
            abort(404);
        }

        $hasReviewed = $this->review->exist(Auth::user()->id, $request->get('movie_id'));

        if($hasReviewed)
        {
            $this->review->update($request->only(['status']), ['id' => $id]);
            return response()->json(['success' => true]);
        }
        else
        {
            abort(403);
        }
    }

    /**
     * Create or update a review, depending on if the review_id is sent in the request
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'movie_id' => 'required|integer',
            'status' => 'required|integer'
        ]);

        $review = $this->review->findWithUserAndMovie(Auth::user()->id, $request->get('movie_id'));

        if($review === null)
        {
            return $this->add($request);
        }
        else
        {
            return $this->edit($review, $request);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function add(Request $request)
    {
        $success = $this->review->create(array_merge(['user_id' => Auth::user()->id], $request->only(['movie_id', 'status'])));
        return response()->json(['success' => $success]);
    }

    /**
     * @param \StdClass $review
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function edit($review, Request $request)
    {
        $this->review->update($request->only(['status']), [
            'user_id' => Auth::user()->id,
            'movie_id' => $review->movie_id
        ]);

        return response()->json(['success' => true]);
    }
}