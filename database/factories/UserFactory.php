<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->firstName;
        $surname = fake()->lastName;

        return [
            'name' => $name,
            'surname' => $surname,
            'patronymic' => fake()->optional()->firstName,
            'login' => fake()->unique()->safeEmail(),
            'avatar' => 'https://picsum.photos/200/200',
            'avatar_thumb' => 'https://picsum.photos/50/50',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => fake()->dateTime(),
            'password' => static::$password ??= Hash::make('password')
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
