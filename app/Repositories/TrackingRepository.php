<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Subcategory;

class TrackingRepository{

    public static function insertCategory($request) {

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return $category;

    }

    public static function insertSubcategory($request) {

        $subcategory = Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description
        ]);
        
        return $subcategory;
    }

}


?>