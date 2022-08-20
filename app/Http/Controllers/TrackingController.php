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
}
