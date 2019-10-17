<?php


namespace Tests\Feature\Sessions;


use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchSessionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_a_session()
    {
        $this->withoutExceptionHandling();

        $session= factory(Session::class)->create();
        $staff = factory(User::class)->state('staff')->create();

        $response = $this->actingAs($staff)->getJson("/admin/sessions/{$session->id}");
        $response->assertStatus(200);

        $this->assertEquals($session->presentFor($staff), $response->decodeResponseJson());
    }
}