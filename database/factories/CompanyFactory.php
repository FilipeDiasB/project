<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'social_name' => 'Eduardo e Emanuelly Pizzaria ME',
            'alias_name' => 'Eduardo e Emanuelly Pizzaria',
            'document_company' => '07.809.099/0995-99',
            'document_company_secondary' => '81456236',
            'zipcode' => '29090585',
            'street' => 'Rua Arquiteto Décio Thevenard',
            'number' => '70',
            'complement' => 'Apto 409, Bloco 3',
            'neighborhood' => 'Jardim Camburi',
            'state' => 'Espírito Santo',
            'city' => 'Vitória',
        ];
    }
}
