<?php

namespace App\Classes;

use App\Helper\Common;
use App\Models\Poem;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class HomeClass
{

    private $comment,$poem;

    public function __construct(Poem $poem,Comment $comment)
    {
        $this->comment = $comment;
        $this->poem = $poem;
    }

    public function index() {

    }

    /**
     * Get lists of all comments and likes on poems
    */
    public function getCount(){
        try {

            $email_id = Common::AuthID();
            $data = [];

            $getTotalProject = $this->poem->getTotalProject($email_id);
            $getCompleteProject = $this->poem->getCompleteProject($email_id);

            $getTotalTask = $this->comment->getTotalTask($email_id);
            $getCompleteTask = $this->comment->getCompleteTask($email_id);

            $data["totalProject"] = $getTotalProject;
            $data["totalTask"] = $getTotalTask;
            $data["completeProject"] = $getCompleteProject;
            $data["completeTask"] = $getCompleteTask;

            if (isset($data) && !empty($data)){
                return response()->json(["status"=>true,"message"=>"dashboard count get success","data"=>$data])->setStatusCode(200);
            }
            return response()->json(["status"=>false,"message"=>"error while get dashboard data"])->setStatusCode(400);
        }catch (\Exception $ex){
            Log::info("DashboardClass Error",["getCount"=>$ex->getMessage(),"line"=>$ex->getLine()]);
            return response()->json(["status"=>false,"message"=>"internal server Error"])->setStatusCode(500);
        }
    }
}
