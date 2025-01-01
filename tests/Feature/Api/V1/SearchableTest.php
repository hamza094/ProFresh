<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Arr;
use ReflectionObject;
use App\Services\Api\V1\InvitationService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use App\Traits\ProjectSetup;

class SearchableTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;
    /**
     * A search feature test example.
     *
     * @return void
     */

     /** User Searchable*/

    /** @test */
    /*public function it_can_search_user_model_search_aspect()
    {    
      $search = new Search();
      $search->registerModel(User::class, 'name');
      $results = $search->perform('doe');

      $this->assertCount(1, $results->aspect('users'));     
      $this->assertNotEmpty($results->groupByType('users'));   
    }*/

      
    public function it_returns_an_empty_collection_when_no_query_is_provided()
    {
        $request = new Request();

        $service=new InvitationService();

        $result=$service->usersSearch($request);

        $this->assertTrue($result->isEmpty());
    }

     public function it_searches_for_users_by_name_or_email()
    {
        $user=User::first();

        $query = $user->name;
        $request = new Request(['query' => $query]);

        $service=new InvitationService();
        $result=$service->memberSearch($request);

        $this->assertCount(1, $result);
    }

    /** @test */
    public function testSearchReturnsFilteredUsers(): void
    {
        $matchingUsers = User::factory(5)->create(['name' => 'Test User']);

        User::factory(3)->create(['name' => 'Other User']);

        $searchTerm = 'Test';
        $request = new Request(['query' => $searchTerm]);

        // Act
        $response = $this->withoutExceptionHandling()->getJson(route('users.search', [
            'query' => $searchTerm,
        ]));
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                    '*' => ['uuid', 'name', 'email'],
                
            ])
            ->assertJsonCount(5); // Ensure only the matching users are returned*/

    }


}
