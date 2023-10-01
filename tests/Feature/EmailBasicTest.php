<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailBasicTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example_email_was_sent(): void
    {
        Mail::fake();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
