<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TrackingRepository;


class TrackingController extends Controller
{
    //
     //create a new category
     public function createCategory(Request $request)
     {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        if($request)
        {

            $category = TrackingRepository::insertCategory($request);
            
            return response()->json([
                'message' => "Category Entered Successfully",
                'data' => $category
            ]);
        }
 
     }
 
 
     //create a new sub-category
     public function createSubcategory(Request $request)
     {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);
        if($request)
        {
            $subcategory = TrackingRepository::insertSubcategory($request);
            
            return response()->json([
                'message' => "Category Entered Successfully",
                'data' => $subcategory
            ]);
        }
     }

        //create issue
    public function createIssue(Request $request)
    {
        
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'uuid' => 'required',
            'slug' => 'required',
        ]);
        
        if ($request) {

            $data = TrackingRepository::postIssue($request);
            return response()->json([
                'message' => "Issue Entered Successfully"
            ]);
        } else {
            return response()->json([
                'message' => "Validation Fails"
            ]);    
        }
        
    }

    //create a comment
    public function createComment(Request $request) 
    {
            $request->validate([
            'issue_id' => 'required',
            'body' => 'required'
        ]);
        if ($request) {

            $data = TrackingRepository::postComment($request);

            return response()->json([
                'message' => "Comment Entered Successfully"
            ]);
        } else {
            return response()->json([
                'message' => "Validation Fails"
            ]);       
        }
    }  

    public function listIssues(){

        $data = TrackingRepository::getIssues();

        return response()->json([
            "data" => $data
        ]);
    }

    public function selectIssue($id) {
    
        $data = TrackingRepository::getIssue($id);

        return response()->json([
            "data" => $data
        ]);
    }
}
