<?php


namespace Tests\Feature\Clients;


use App\Clients\EngagementCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEngagementCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_engagement_code_can_be_created()
    {
        $this->withoutExceptionHandling();
        $engagement_code = [
            'code' => 'test_code',
            'description' => 'test description'
        ];

        $response = $this->asManager()->postJson("/admin/engagement-codes", $engagement_code);
        $response->assertStatus(201);

        $this->assertDatabaseHas('engagement_codes', $engagement_code);
    }

    /**
     *@test
     */
    public function only_a_manager_can_create_an_engagement_code()
    {
        $engagement_code = [
            'code' => 'test_code',
            'description' => 'test description'
        ];

        $response = $this->asStaff()->postJson("/admin/engagement-codes", $engagement_code);
        $response->assertStatus(403);

        $this->assertCount(0, EngagementCode::all());
    }

    /**
     *@test
     */
    public function the_code_is_required()
    {
        $response = $this->asManager()->postJson("/admin/engagement-codes", [
            'code' => '',
            'description' => 'test description'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('code');
    }

    /**
     *@test
     */
    public function the_description_is_required()
    {
        $response = $this->asManager()->postJson("/admin/engagement-codes", [
            'code' => 'test_code',
            'description' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('description');
    }
}