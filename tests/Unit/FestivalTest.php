<?php

namespace Tests\Unit;

use Tests\TestCase;

class FestivalTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index_page()
    {
        $this->assertTrue(true);
    }

    public function test_create_festival_with_ajax() {
        $this->withoutExceptionHandling();
        $response = $this->withHeader('X-Requested-With', 'XMLHttpRequest')
        ->post('festivals', [
            'name' => 'Dhamaka Offer',
            'start_at' => now(),
            'end_at' => date('Y-m-d H:i:s', strtotime('+10 days', strtotime(date('Y-m-d H:i:s')))),
        ]);
        $response->assertStatus(200);
    }
    
    public function test_create_festival_without_ajax() {
        $this->withoutExceptionHandling();
        $response = $this->followingRedirects()->post('festivals', [
            'name' => 'Dhamaka Offer',
            'start_at' => now(),
            'end_at' => date('Y-m-d H:i:s', strtotime('+10 days', strtotime(date('Y-m-d H:i:s')))),
        ]);
        //$response->assertRedirect($uri);
        //$response->assertLocation(route('festivals.create'));
        $response->assertStatus(200);
        //$response->assertTrue(true);
    }

    public function test_show_festival_without_ajax() {
        $this->withoutExceptionHandling();
        $response = $this->followingRedirects()->get('festivals/1');
        $response->assertStatus(200);
    }

    public function test_update_festival_without_ajax() {
        $this->withoutExceptionHandling();
        $response = $this->followingRedirects()->put('festivals/25', [
            'name' => 'Dhamaka Offer updated',
            'start_at' => now(),
            'end_at' => date('Y-m-d H:i:s', strtotime('+10 days', strtotime(date('Y-m-d H:i:s')))),
        ]);
        $response->assertStatus(200);
    }

    public function test_delete_festival_without_ajax() {
        $this->withoutExceptionHandling();
        $response = $this->followingRedirects()->delete('festivals/25');
        $response->assertStatus(200);
    }
}
