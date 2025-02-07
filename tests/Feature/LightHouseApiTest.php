<?php

use Illuminate\Support\Facades\Http;


test('test_lighthouse_api_check_with_valid_url', function(){

    $response = $this->postJson('/api/lighthouse', [
        'url' => 'https://google.com',
        'strategy' => 'DESKTOP',
    ]);

    $response->assertStatus(200);
});
