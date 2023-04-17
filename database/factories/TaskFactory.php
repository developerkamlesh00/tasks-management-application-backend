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
        $assigned=$this->faker->dateTimeBetween('-3 months','now');
        $status=$this->faker->numberBetween(1,4);
        $completed=NULL;
        if($status==4){
            $completed=$this->faker->dateTimeBetween($assigned,'now');
        }
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2,true),
            'assigned_at'=>$assigned,
            'estimated_deadline'=>$this->faker->dateTimeBetween($assigned,'2 weeks'),
            'completed_at'=>$completed,
            'status_id' => $status,
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
