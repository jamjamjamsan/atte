<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\GenreSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Collection;
class HelloTest extends TestCase
{
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory()->create();
        $request = $this->actingAs($user);
        $response = $this->actingAs(User::all())->get('/');

        $response->assertOk();

        $response = $this->actingAs(User::find(14)->create())->post("/restend");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->post("/workstart");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->post("/workend");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->get("/attendance");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->post("/back");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->post("/next");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->post("/userpage");

        $response->assertOk();

        $response = $this->actingAs(User::factory()->create())->get("/userlist");

        $response->assertOk(404);

        
    }
}








