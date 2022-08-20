<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
            'title' => 'power lost',
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
        $this->get(route('select.issue', 9))->assertStatus(200);
    }

    public function test_issuse_delete() {
        $this->delete(route('delete.issue', 5))->assertStatus(200);
    }

    public function test_comment_delete() {
        $this->delete(route('delete.comment', 6))->assertStatus(200);
    }
}
