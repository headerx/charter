<?php

namespace Database\Factories;

use App\Models\LinkType;
use Illuminate\Database\Eloquent\Factories\Factory;
use LinkTargetTypes;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => LinkType::InternalLink->value,
            'url' => $this->faker->url,
            'title' => $this->faker->sentence,
            'label' => $this->faker->word,
            'target' => LinkTargetTypes::Self->value,
        ];
    }

    public function blank()
    {
        return $this->state(function(){
            return [
                'target' => LinkTargetTypes::Blank->value,
            ];
        });
    }

    public function self()
    {
        return $this->state(function(){
            return [
                'target' => LinkTargetTypes::Self->value,
            ];
        });
    }

    public function parent()
    {
        return $this->state(function(){
            return [
                'target' => LinkTargetTypes::Parent->value,
            ];
        });
    }

    public function top()
    {
        return $this->state(function(){
            return [
                'target' => LinkTargetTypes::Top->value,
            ];
        });
    }

}
