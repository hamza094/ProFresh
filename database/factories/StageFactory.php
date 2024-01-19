<?php

namespace Database\Factories;

use App\Models\Stage;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class StageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Stage::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      return [
            'name'=>'Begining',
                                'user_id'=>User::factory(),

        ];
    }

    public function define()
    {
      return $this->state(function (array $attributes) {
         return [
            'name' => 'Defining',
                                'user_id'=>User::factory(),

        ];
    });
   }

   public function design()
   {
     return $this->state(function (array $attributes) {
        return [
           'name' => 'Designing',
                               'user_id'=>User::factory(),

       ];
   });
  }

  public function develop()
  {
    return $this->state(function (array $attributes) {
       return [
          'name' => 'Developing',
                              'user_id'=>User::factory(),

      ];
  });
 }

 public function execution()
 {
   return $this->state(function (array $attributes) {
      return [
         'name' => 'Execution',
                             'user_id'=>User::factory(),

     ];
 });
}

}
