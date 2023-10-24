<?php

namespace App\Http\Controllers;

use App\Helper\Common;
use App\Classes\PoemClass;
use App\Http\Requests\StorePoemRequest;
use App\Models\Poem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoemController extends Controller
{
    private $poem;

    public function __construct(PoemClass $poem) {
        $this->poem = $poem;
    }

    /**
     * Access the index page for the users to see all poems
     * @return Application|Factory|View
     */
    public function index() {
        
    }

    /**
    //  * @param StorePoemRequest $request
    //  * @return RedirectResponse
    */
    public function publishPoem(Request $request)
    {

        // validate incoming requests
        // $validated = $request->validated();
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required',
            'genre_id' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'message' => $error])->setStatusCode(400);
        }

        // model data variables
        $title = $request->title;
        $body = $request->body;
        $genre = $request->genre;
        $author = Auth::user()->id;
        return  $this->poem->publishPoem($title,$body,$genre,$author);

    }
   

    /**
     * @param Poem $poem
    */
    public function destroy($id)
    {
        return $this->poem->deletePoem($id);
    }

}
