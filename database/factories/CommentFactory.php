<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'body' => $this->faker->sentence(2),
            'user_id' => $this->faker->numberBetween(1,50)
        ];
        
    }
    public function stateMethod($task_id){
            return $this->state(
                [
                    'task_id' => $task_id
                ]
            );
            
        }
    }

