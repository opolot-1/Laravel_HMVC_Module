<?php

namespace Modules\Questions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Questions\Entities\Question;
use Illuminate\Support\Facades\Validator;


class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Question::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required|max:191',
            'description'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errrors'=>$validator->messages(),
            ]);
        } else {
            $question = new Question;
        $question->title = $request->input('title');
        $question->description = $request->input('description');
        $question->save();
        return response()->json([
            'status'=>200,
            'message'=>'Question Added Successfully',
        ]);
        }
        
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title'=>'required|max:191',
            'description'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errrors'=>$validator->messages(),
            ]);
        } else {
            $question = Question::find($id);
            if ($question) {
                //$question = new Question;
                $question->title = $request->input('title');
                $question->description = $request->input('description');
                $question->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Question Updated Added Successfully',
                ]);
            } else {
                return response()->json([
                    'status'=>200,
                    'message'=>'No Question ID found',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json(['message' => 'Deleted successfully'],
         200);
    }
}
