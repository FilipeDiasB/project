<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'name' => $this->faker->name(),
//            'email' => $this->faker->unique()->safeEmail(),
//            'email_verified_at' => now(),
//            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//            'remember_token' => Str::random(10),
            'name' => 'FilipeDias',
            'email' => 'filipedias157@gmail.com',
            'password' => bcrypt('teste'),
            'genre' => 'male',
            'document' => '18737575734',
            'document_secondary' => '4071975-ES',
            'document_secondary_complement' => 'SSP/ES',
            'date_of_birth' => '12/07/2000',
            'place_of_birth' => 'Aimores',
            'civil_status' => 'married',
            'cover' => '',
            'occupation' => 'DesenvolvedorWeb',
            'income' => '1500',
            'company_work' => 'Aprovalegal',
            'zipcode' => '29090585',
            'street' => 'Rua Arquiteto Décio Thevenard',
            'number' => '70',
            'complement' => 'Apto 409, Bloco 3',
            'neighborhood' => 'Jardim Camburi',
            'state' => 'Espírito Santo',
            'city' => 'Vitória',
            'telephone' => '2799964251',
            'cell' => '27999642519',
            'type_of_communion' => 'Comunhão Universal de Bens',
            'spouse_name' => 'FabianyDanieleto',
            'spouse_genre' => 'female',
            'spouse_document' => '18737575735',
            'spouse_document_secondary' => '4071976-ES',
            'spouse_document_secondary_complement' => 'SSP/ES',
            'spouse_date_of_birth' => '31/10/2001',
            'spouse_place_of_birth' => 'Vitória',
            'spouse_occupation' => 'Nutricionista',
            'spouse_income' => '1500',
            'spouse_company_work' => 'MonteLíbano',
            'lessor' => 'on',
            'lessee' => 'on',
            'admin' => 'on',
            'client' => '',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
