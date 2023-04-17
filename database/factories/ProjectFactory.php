<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    protected $model = Project::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $assigned= now();
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2,true),
            'organization_id' => 2,
            'manager_id' => $this->faker->numberBetween(3,12),
            'assigned_at' => $assigned,
            'estimated_deadline' => $this->faker->dateTimeBetween($assigned ,'2 weeks'),
            'tasks_completed' => $this->faker->numberBetween(10,30),
        ];

    }
    public function stateMethod($total_tasks){
        return $this->state(
            [
                'total_tasks' => $total_tasks
            ]
        );
    }
}
