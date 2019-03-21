<?php


namespace Tests\Feature\Clients;


use App\Clients\EngagementCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateEngagementCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_description_of_an_engagement_code_can_be_edited()
    {
        $this->withoutExceptionHandling();
        $engagement_code = factory(EngagementCode::class)->create([
            'code' => 'test_code',
            'description' => 'old description'
        ]);

        $response = $this->asManager()->postJson("/admin/engagement-codes/{$engagement_code->id}", [
            'description' => 'new description'
        ]);
        $response->assertStatus(200);

        $this->assertEquals('test_code', $response->decodeResponseJson('code'));
        $this->assertEquals('new description', $response->decodeResponseJson('description'));

        $this->assertDatabaseHas('engagement_codes', [
            'id' => $engagement_code->id,
            'code' => 'test_code',
            'description' => 'new description',
        ]);
    }

    /**
     *@test
     */
    public function an_engagement_code_can_only_be_edited_by_a_manager()
    {
        $engagement_code = factory(EngagementCode::class)->create([
            'code' => 'test_code',
            'description' => 'old description'
        ]);

        $response = $this->asStaff()->postJson("/admin/engagement-codes/{$engagement_code->id}", [
            'description' => 'new description'
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('engagement_codes', [
            'id' => $engagement_code->id,
            'code' => 'test_code',
            'description' => 'old description',
        ]);
    }

    /**
     *@test
     */
    public function the_description_is_required()
    {
        $engagement_code = factory(EngagementCode::class)->create([
            'code' => 'test_code',
            'description' => 'old description'
        ]);

        $response = $this->asManager()->postJson("/admin/engagement-codes/{$engagement_code->id}", [
            'description' => ''
        ]);
        $response->assertStatus(422);

        $this->assertDatabaseHas('engagement_codes', [
            'id' => $engagement_code->id,
            'code' => 'test_code',
            'description' => 'old description',
        ]);
    }
}