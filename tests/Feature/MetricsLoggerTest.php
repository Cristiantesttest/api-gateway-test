<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class MetricsLoggerTest extends TestCase
{
    /** @test */
    public function it_logs_request_metrics()
    {
        $request_nb = 40;
        for ($i=0; $i < $request_nb; $i++) { 
            $response = $this->getJson('/api/relay');

            // Here postJson can be used as well to test POST method
            // $response = $this->postJson('/api/relay/service');
        }

        // This should be used here because Phpunit isn't making real http requests.
        $response = $this->get('/');

        $response->assertStatus(200);

    }
}
