<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a fake image and save it to the 'company_image' directory
        $image = fake()->image('public/storage/company_image', 100, 100, null, false);
        $imagePath = 'company_image/' . $image;

        return [
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'logo' => $imagePath,
            'website' => fake()->domainName(),
        ];
    }
}
