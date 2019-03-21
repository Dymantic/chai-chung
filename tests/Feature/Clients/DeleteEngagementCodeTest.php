<?php


namespace Tests\Feature\Clients;


use App\Clients\EngagementCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEngagementCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_engagement_code_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $engagement_code = factory(EngagementCode::class)->create();

        $response = $this->asManager()->deleteJson("/admin/engagement-codes/{$engagement_code->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('engagement_codes', ['id' => $engagement_code->id]);
    }

    /**
     *@test
     */
    public function an_engagement_code_can_only_be_deleted_by_a_manager()
    {
        $engagement_code = factory(EngagementCode::class)->create();

        $response = $this->asStaff()->deleteJson("/admin/engagement-codes/{$engagement_code->id}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('engagement_codes', ['id' => $engagement_code->id]);
    }
}