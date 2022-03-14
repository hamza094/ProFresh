<?php

namespace Database\Factories;

use App\Models\Stage;

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
        ];
    }

    public function define()
    {
      return $this->state(function (array $attributes) {
         return [
            'name' => 'Defining',
        ];
    });
   }

   public function design()
   {
     return $this->state(function (array $attributes) {
        return [
           'name' => 'Designing',
       ];
   });
  }

  public function develop()
  {
    return $this->state(function (array $attributes) {
       return [
          'name' => 'Developing',
      ];
  });
 }

 public function execution()
 {
   return $this->state(function (array $attributes) {
      return [
         'name' => 'Execution',
     ];
 });
}

}
