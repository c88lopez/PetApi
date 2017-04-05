<?php

namespace App\Http\Controllers;

use App\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function list_all()
    {
        return response()->json(
            [
                'status'  => 'success',
                'message' => 'pet_list',
                'data'    => Pet::all(),
            ]
        );
    }

    public function create(Request $request)
    {
        try {
            $statusCode = 200;

            $this->validate(
                $request
                , [
                    'pet_type_id'  => 'required',
                    'pet_owner_id' => 'required',
                    'name'         => 'required',
                    'gender'       => 'required',
                    'birth_date'   => 'required',
                ]
            );

            $responseArray = [
                'status'  => 'success',
                'message' => 'pet_created',
                'data'    => [
                    'id' => (new Pet)->create(
                        [
                            'pet_type_id'  => (int)$request->pet_type_id,
                            'pet_owner_id' => (int)$request->pet_owner_id,
                            'name'         => $request->name,
                            'gender'       => $request->gender,
                            'birth_date'   => $request->birth_date,
                        ]
                    ),
                ],
            ];
        } catch (\Exception $e) {
            $statusCode = 400;

            $responseArray = [
                'status'  => 'error',
                'message' => 'pet_create_failed',
                'data'    => [
                    'error' => $e->getMessage(),
                ],
            ];
        }

        return response()->json($responseArray, $statusCode);
    }

    public function delete(Request $request)
    {
        try {
            $pet = Pet::find((int)$request->id);
            if (!empty($pet)) {
                $pet->delete();
            } else {
                throw new \Exception('invalid_pet');
            }

            $statusCode    = 200;
            $responseArray = [
                'status'  => 'success',
                'message' => 'pet_deleted',
            ];
        } catch (\Exception $e) {
            $statusCode = 400;

            $responseArray = [
                'status'  => 'error',
                'message' => 'pet_delete_failed',
                'data'    => [
                    'error' => $e->getMessage(),
                ],
            ];
        }

        return response()->json($responseArray, $statusCode);
    }
}
