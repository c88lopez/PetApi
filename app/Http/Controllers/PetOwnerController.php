<?php

namespace App\Http\Controllers;

use App\PetOwner;
use Illuminate\Http\Request;

class PetOwnerController extends Controller
{
    public function list_all()
    {
        return response()->json(
            [
                'status'  => 'success',
                'message' => 'pet_owner_list',
                'data'    => PetOwner::all(),
            ]
        );
    }

    public function list_pets(Request $request)
    {
        try {
            $response = response()->json(
                [
                    'status'  => 'success',
                    'message' => 'pet_owner_pets_list',
                    'data'    => PetOwner::find((int)$request->id)->pets,
                ]
            );
        } catch (\ErrorException $e) {
            $response = response()->json(
                [
                    'status'  => 'error',
                    'message' => 'invalid_pet_owner',
                ]
            );
        }

        return $response;
    }

    public function create(Request $request)
    {
        try {
            $statusCode = 200;

            $this->validate(
                $request
                , [
                    'name'       => 'required',
                    'last_name'  => 'required',
                    'birth_date' => 'required',
                ]
            );

            $responseArray = [
                'status'  => 'success',
                'message' => 'pet_owner_created',
                'data'    => [
                    'id' => (new PetOwner)->create(
                        [
                            'name'       => $request->name,
                            'last_name'  => $request->last_name,
                            'birth_date' => $request->birth_date,
                        ]
                    ),
                ],
            ];
        } catch (\Exception $e) {
            $statusCode = 400;

            $responseArray = [
                'status'  => 'error',
                'message' => 'pet_owner_create_failed',
                'data'    => [
                    'error' => $e->getMessage(),
                ],
            ];
        }

        return response()->json($responseArray, $statusCode);
    }

    public function modify(Request $request, $id)
    {
        try {
            $statusCode = 200;

            $this->validate(
                $request
                , [
                    'name'       => 'required',
                    'last_name'  => 'required',
                    'birth_date' => 'required',
                ]
            );

            (new PetOwner)->modify(
                [
                    'id'         => $id,
                    'name'       => $request->name,
                    'last_name'  => $request->last_name,
                    'birth_date' => $request->birth_date,
                ]
            );

            $responseArray = [
                'status'  => 'success',
                'message' => 'pet_owner_modified',
            ];
        } catch (\Exception $e) {
            $statusCode = 400;

            $responseArray = [
                'status'  => 'error',
                'message' => 'pet_owner_modify_failed',
                'data'    => [
                    'error' => $e->getMessage(),
                ],
            ];
        }

        return response()->json($responseArray, $statusCode);
    }
}
