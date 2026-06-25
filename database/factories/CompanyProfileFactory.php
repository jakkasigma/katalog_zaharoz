<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'whatsapp' => fake()->optional()->phoneNumber(),
            'address' => fake()->optional()->address(),
            'city' => fake()->optional()->city(),
            'province' => fake()->optional()->state(),
            'postal_code' => fake()->optional()->postcode(),
            'description' => fake()->optional()->paragraph(),
            'logo_path' => null,
            'instagram_url' => fake()->optional()->url(),
            'tiktok_url' => fake()->optional()->url(),
        ];
    }
}
