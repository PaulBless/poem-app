<?php

namespace App\Classes;

use App\Helper\Common;
use App\Models\Poem;
use Illuminate\Support\Facades\Log;

class PoemClass
{
    private $poem;

    public function __construct(Poem $poem)
    {
        $this->poem = $poem;
    }

    public function getPoem()
    {
        try {
            $email = Common::AuthID();
            $data = $this->poem->getPoem($email);

            if (isset($data) && !empty($data)) {
                return response()->json(['status' => true, 'message' => 'Poem get success', 'data' => $data])->setStatusCode(200);
            }

            return response()->json(['status' => false, 'message' => 'error while get Poem'])->setStatusCode(400);
        
        } catch (\Exception $ex) {
            Log::info("TaskClassClass Error", ["getPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return response()->json(['status' => false, 'message' => 'internal server error'])->setStatusCode(500);
        }
    }

    public function publishPoem($title, $body, $genre_id, $author)
    {
        try {
            
            $author = Common::AuthID();
            $addPoem = $this->poem->addPoem( $title, $body, $genre_id, $author);
            
            if ($addPoem) {
                return response()->json(['status' => true, 'message' => 'Poem created successfully'])->setStatusCode(200);
            }

            return response()->json(['status' => false, 'message' => 'error while publishing poem'])->setStatusCode(400);
        
        } catch (\Exception $ex) {
            Log::info("PoemClass Error", ["addPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return response()->json(['status' => false, 'message' => 'internal server error'])->setStatusCode(500);
        }
    }

    public function getSinglePoem($id)
    {
        try {

            $data = $this->poem->getSinglePoem($id);

            if (isset($data) && !empty($data)) {
                return response()->json(['status' => true, 'message' => 'poem get success', 'data' => $data])->setStatusCode(200);
            }

            return response()->json(['status' => false, 'message' => 'error while get poem'])->setStatusCode(400);

        } catch (\Exception $ex) {
            Log::info("TaskClassClass Error", ["getPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return response()->json(['status' => false, 'message' => 'internal server error'])->setStatusCode(500);
        }
    }

    public function updatePoem($id, $name, $budget, $responsible_user, $status, $completion)
    {
        try {
            $updateProduct = $this->poem->updatePoem($id, $name, $budget, $responsible_user, $status, $completion);
            
            if ($updateProduct) {
                return response()->json(['status' => true, 'message' => 'Poem update success'])->setStatusCode(200);
            }

            return response()->json(['status' => false, 'message' => 'error updating poem'])->setStatusCode(400);
        
        } catch (\Exception $ex) {
            Log::info("PoemClass Error", ["addPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return response()->json(['status' => false, 'message' => 'internal server error'])->setStatusCode(500);
        }
    }

    public function deletePoem($id)
    {
        try {
            $data = $this->poem->deletePoem($id);
            if ($data) {
                return response()->json(['status' => true, 'message' => 'Poem delete success'])->setStatusCode(200);
            }
            return response()->json(['status' => false, 'message' => 'error while delete Poem'])->setStatusCode(400);
        } catch (\Exception $ex) {
            Log::info("TaskClassClass Error", ["getPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return response()->json(['status' => false, 'message' => 'internal server error'])->setStatusCode(500);
        }
    }
}
