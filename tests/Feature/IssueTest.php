<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Issue;
use App\Models\Comment;

class IssueTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_issue_create()
    {
        $formData = [
            'title' => 'power',
            'body' => 'emergency power cut',
            'uuid' => 'abc123',
            'slug' => 'sdcdsas',
            'category_id' => 1,
            'subcategory_id' => 1
        ];

        $this->json('POST', route('create.issue'), $formData)
            ->assertStatus(200);
    }

    public function test_comment_create()
    {
        $formData = [
            'issue_id' => 6,
            'body' => 'the service is not good',
        ];

        $this->json('POST', route('create.comment'), $formData)
            ->assertStatus(200);
    }

     public function test_category_create()
        {
            $formData = [
                'name' => 'Solar',
                'description' => 'battries draining',
            ];

            $this->json('POST', route('create.category'), $formData)
                ->assertStatus(200);
        }

    public function test_subcategory_create()
        {
            $formData = [
                'name' => 'Solar panel with hot water',
                "category_id" => 2,
                'description' => 'battries draning for hot water system',
            ];

            $this->json('POST', route('create.subcateory'), $formData)
                ->assertStatus(200);
        }

    public function test_issues_get() 
    {
        $this->get(route('list.issues'))->assertStatus(200);
    }

    public function test_issue_get() 
    {
        $issue = Issue::max('id');
        $this->get(route('select.issue', $issue))->assertStatus(200);
    }

    public function test_issuse_delete() {
        $issue = Issue::max('id');
        $this->delete(route('delete.issue', $issue))->assertStatus(200);
    }

    public function test_comment_delete() {
        $comment = Comment::max('id');
        $this->delete(route('delete.comment', $comment))->assertStatus(200);
    }
}
