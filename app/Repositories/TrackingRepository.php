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

   public static function postComment($request){
    $comment = Comment::create([
        'issue_id' => $request->issue_id,
        'body' => $request->body,
    ]);
        $id = $comment->id;
        if($images = $request->file('images')) {
            foreach($images as $image) {
                $name = $image->getClientOriginalName();
                $path = $image->storeAs('uploads', $name, 'public');
                $imageextension = $image->getClientOriginalExtension();
                $imagesize = $image->getSize();

                $create = Image::create([
                    'name' => $name,
                    'path' => '/storage/'.$path,
                    'imagable_type' => "comments",
                    'imagable_id'=> $id,
                    'size' => $imagesize,
                    'extension' => $imageextension,
                ]);
            }
        }
   }

   public static function getIssues() {
    
    $issues = DB::table('issues')
            ->join('issue_categories', 'issues.id', '=', 'issue_categories.issue_id')
            ->join('issue_subcategories', 'issues.id', '=', 'issue_categories.issue_id')
            ->join('categories', 'categories.id', '=', 'issue_categories.category_id')
            ->join('subcategories', 'subcategories.id', '=', 'issue_subcategories.subcategory_id')
            ->select('issues.*', 'categories.name as category_name', 'subcategories.name as sub_category_name')
            ->get();

    return $issues;
   }

   public static function getIssue($id) {
    $issues = DB::table('issues')
        ->leftjoin('issue_categories', 'issues.id', '=', 'issue_categories.issue_id')
        ->leftjoin('issue_subcategories', 'issues.id', '=', 'issue_categories.issue_id')
        ->leftjoin('categories', 'categories.id', '=', 'issue_categories.category_id')
        ->leftjoin('subcategories', 'subcategories.id', '=', 'issue_subcategories.subcategory_id')
        ->select('issues.*', 'categories.name as category_name', 'subcategories.name as sub_category_name')      
        ->where('issues.id','=', $id)
        ->get();

        $issue_images = DB::table('images')
            ->select('images.imagable_type', 'images.imagable_id', 'images.path')
            ->where('imagable_id', '=', $id)
            ->where('imagable_type', '=', "issues")
            ->get();

        $comments = DB::table('comments')
            ->select('comments.id','comments.body')
            ->where('issue_id','=', $id)
            ->get();
        
        $comment_images = DB::table('images')
            ->leftjoin('comments', 'images.imagable_id', '=', 'comments.id')
            ->select('images.imagable_type', 'images.imagable_id', 'images.path')
            ->where('issue_id', '=', $id)
            ->where('imagable_type', '=', "comments")
            ->get();

    return response()->json([
        "issues_table" => $issues,
        "issue_images" => $issue_images,
        "comments_table" => $comments,
        "comment_images" => $comment_images
        
    ]);
   }

   public static function deleteIssue($id) {
    $issues = DB::table('issues')
        ->leftjoin('issue_categories', 'issues.id', '=', 'issue_categories.issue_id')
        ->leftjoin('issue_subcategories', 'issues.id', '=', 'issue_categories.issue_id')
        ->leftjoin('categories', 'categories.id', '=', 'issue_categories.category_id')
        ->leftjoin('subcategories', 'subcategories.id', '=', 'issue_subcategories.subcategory_id')
        ->leftjoin('comments', 'issues.id', '=', 'comments.issue_id')
        ->select('issues.*', 'issue_categories.*','comments.*', 'issue_subcategories.*')
        ->where('issues.id','=', $id)
        ->delete();

        $issue_images = DB::table('images')
        ->select('images.*')
        ->where('imagable_id', '=', $id)
        ->where('imagable_type', '=', "issues")
        ->delete();

        $comment_images = DB::table('images')
        ->leftjoin('comments', 'images.imagable_id', '=', 'comments.id')
        ->select('images.*')
        ->where('issue_id', '=', $id)
        ->where('imagable_type', '=', "comments")
        ->delete();

    }

    public static function removeComment($id) {

        $comments = DB::table('comments')
        ->select('comments.*')
        ->where('id','=', $id)
        ->delete();

        $comment_images = DB::table('images')
        ->select('images.*')
        ->where('imagable_id', '=', $id)
        ->where('imagable_type', '=', "comments")
        ->delete();
    }

}


?>