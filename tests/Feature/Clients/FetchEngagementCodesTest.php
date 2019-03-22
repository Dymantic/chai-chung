<?php


namespace Tests\Feature\Clients;


use App\Clients\EngagementCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchEngagementCodesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_all_engagement_codes_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $codes = factory(EngagementCode::class, 10)->create();

        $response = $this->asManager()->getJson("/admin/engagement-codes");
        $response->assertStatus(200);

        $fecthed_codes = $response->decodeResponseJson();

        $this->assertCount(10, $fecthed_codes);
        $this->assertEquals($codes->map->toArray()->all(), $fecthed_codes);
    }
}