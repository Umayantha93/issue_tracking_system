<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Issue;
use App\Models\IssueCategory;
use App\Models\IssueSubcategory;
use App\Models\Comment;
use App\Models\Image;
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

    public static function postIssue($request)
   {
    $issue = Issue::create([
        'title' => $request->title,
        'body' => $request->body,
        'uuid' => $request->uuid,
        'slug' => $request->slug,
    ]);

    $issue_category = IssueCategory::create([
        'issue_id' => $issue->id,
        'category_id' => $request->category_id,
    ]);

    $issue_subcategory = IssueSubcategory::create([
        'issue_id' => $issue->id,
        'subcategory_id' => $request->subcategory_id,
    ]);

    $id = $issue->id;
    if($images = $request->file('images')) {
        foreach($images as $image) {
            $name = $image->getClientOriginalName();
            $path = $image->storeAs('uploads', $name, 'public');
            $imageextension = $image->getClientOriginalExtension();
            $imagesize = $image->getSize();

            $create = Image::create([
                'name' => $name,
                'path' => '/storage/'.$path,
                'imagable_type' => "issues",
                'imagable_id'=> $id,
                'size' => $imagesize,
                'extension' => $imageextension,
            ]);
        }
    }
   }


}


?>