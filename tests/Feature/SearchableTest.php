<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Arr;
use ReflectionObject;
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
             'password'=>Hash::make('testpassword')
         ]);

         Sanctum::actingAs(
             $user,
         );
     }

     /** User Searchable*/

    /** @test */
     public function it_can_search_user_model_search_aspect()
     {
         User::create(['name'=>'john doe','email'=>'johna_pises@yahoo.com','password'=>'1234']);
         User::create(['name'=>'alex','email'=>'axio_chink@yahoo.com','password'=>'2345']);
         $search = new Search();
         $search->registerModel(User::class, 'name');
         $results = $search->perform('doe');
         $this->assertCount(1, $results);
         $this->assertArrayHasKey('users', $results->groupByType());
         $this->assertCount(1, $results->aspect('users'));
     }

}
