<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Arr;
use ReflectionObject;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;
use Spatie\Searchable\Tests\Models\TestModel;
use Spatie\Searchable\Tests\stubs\CustomNameSearchAspect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class SearchableTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A search feature test example.
     *
     * @return void
     */

     public function setUp() :void
     {
         parent::setUp();
         // create a user
        $user=User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword'),
             'name'=>'jon doe',
         ]);

         Sanctum::actingAs(
             $user,
         );

        User::factory()->create(['name'=>'alex']); 
     }

     /** User Searchable*/

    /** @test */
    public function it_can_search_user_model_search_aspect()
    {    
      $search = new Search();
      $search->registerModel(User::class, 'name');
      $results = $search->perform('doe');

      $this->assertCount(1, $results->aspect('users'));     
      $this->assertNotEmpty($results->groupByType('users'));   
    }

      /** @test */
    public function it_returns_an_empty_collection_when_no_query_is_provided()
    {
        $request = new Request();

        $service=new InvitationService();

        $result=$service->memberSearch($request);

        $this->assertTrue($result->isEmpty());
    }

     /** @test */
     public function it_searches_for_users_by_name_or_email()
    {
        $user=User::first();

        $query = $user->name;
        $request = new Request(['query' => $query]);

        $service=new InvitationService();
        $result=$service->memberSearch($request);

        $this->assertCount(1, $result);
    }

}
