<?php

namespace Tests\Feature;

use App\PetType;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PetOwnerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /**
     * This test will check all possible scenarios.
     *
     * @return void
     */
    public function testCompleteFlow()
    {
        /**
         * List all pet_owner, empty at first.
         */
        $this->get('/api/pet_owner/list')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_list',
                    'data'    => [],
                ]
            );

        $newPetOwner = [
            'name'       => 'Cris',
            'last_name'  => 'Lop',
            'birth_date' => '1989-09-29',
        ];

        /**
         * Create the first one.
         */
        $this->post('/api/pet_owner/create', $newPetOwner)
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_created',
                    'data'    => [
                        'id' => 1,
                    ],
                ]
            );

        $newPetOwner['id'] = 1;

        /**
         * Check it is created correctly.
         */
        $this->get('/api/pet_owner/list')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_list',
                    'data'    => [
                        $newPetOwner,
                    ],
                ]
            );

        $fixedPetOwner = [
            'name'       => 'Cristian',
            'last_name'  => 'Lopez',
            'birth_date' => '1988-09-29',
        ];

        /**
         * Lets update the fields bad filled.
         */
        $this->put('/api/pet_owner/' . $newPetOwner['id'] . '/modify', $fixedPetOwner);

        $fixedPetOwner['id'] = $newPetOwner['id'];

        $this->get('/api/pet_owner/list')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_list',
                    'data'    => [
                        $fixedPetOwner,
                    ],
                ]
            );

        /**
         * Get the empty list of pets.
         */
        $this->get('/api/pet_owner/' . $newPetOwner['id'] . '/list_pets')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_pets_list',
                    'data'    => [],
                ]
            );

        $newPets = [
            [
                'name'         => 'India',
                'gender'       => 'f',
                'pet_type_id'  => PetType::CAT,
                'pet_owner_id' => $fixedPetOwner['id'],
                'birth_date'   => '1989-09-29',
            ],
            [
                'name'         => 'Mara',
                'gender'       => 'f',
                'pet_type_id'  => PetType::DOG,
                'pet_owner_id' => $fixedPetOwner['id'],
                'birth_date'   => '1989-09-29',
            ],
        ];

        /**
         * Create the first pet.
         */
        $this->post('/api/pet/create', $newPets[0])
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_created',
                    'data'    => [
                        'id' => 1,
                    ],
                ]
            );

        $newPets[0]['id'] = 1;

        /**
         * Check the pet was correctly added.
         */
        $this->get('/api/pet_owner/' . $newPetOwner['id'] . '/list_pets')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_pets_list',
                    'data'    => [
                        $newPets[0],
                    ],
                ]
            );

        /**
         * Create the second one.
         */
        $this->post('/api/pet/create', $newPets[1])
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_created',
                    'data'    => [
                        'id' => 2,
                    ],
                ]
            );

        $newPets[1]['id'] = 2;

        /**
         * Check both of the created pets are listed.
         */
        $this->get('/api/pet_owner/' . $newPetOwner['id'] . '/list_pets')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_pets_list',
                    'data'    => [
                        $newPets[0],
                        $newPets[1],
                    ],
                ]
            );

        /**
         * Delete one of them.
         */
        $this->delete('/api/pet/' . $newPets[0]['id'] . '/delete')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_deleted',
                ]
            );

        /**
         * Check the list hast only one of the two pet created.
         */
        $this->get('/api/pet_owner/' . $newPetOwner['id'] . '/list_pets')
            ->assertStatus(200)
            ->assertJson(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_pets_list',
                    'data'    => [
                        $newPets[1],
                    ],
                ]
            );
    }
}
