<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(2,true),
            'status_id' => 1,
            'worker_id' => $this->faker->numberBetween(13,62),
        ];
    }
    
    public function stateMethod($project_id){
        
        return $this->state(
            [
                'project_id' => $project_id
            ]
        );
    }
}
