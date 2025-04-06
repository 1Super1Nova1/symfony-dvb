<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ControlerPatients extends Controller
{

    /** 
     * @return mixed
     */
    public function getPatients(): mixed
    {
        $patients = Patients::all();

        return response()->json($patients, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getPatientsItem(string $id): mixed
    {
        $patients = Patients::find($id);

        if (!$patients) {
            return response()->json(['data' => ['error' => 'Not found patients by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $patients], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function createPatients(Request $request): mixed
    {
        $requestData = json_decode($request->getContent(), true);

        $patients = new Patients();

        $patients->create([
            'firstName' => $requestData['firstName'],
            'lastName' => $requestData['lastName']
        ]);

        $patients = Patients::all();

        return response()->json([
            'data' => $patients
        ], Response::HTTP_CREATED);
    }


    /**
     * @param string $id
     * @return mixed
     */
    public function deletPatients(string $id): mixed
    {
        $patients = Patients::find($id);

        if (!$patients) {
            return response()->json(['data' => ['error' => 'Not found patients by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $patients->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }


    public function updatePatients(string $id, Request $request): mixed
    {
        $patients = Patients::find($id);

        if (!$patients) {
            return response()->json(['data' => ['error' => 'Not found patients by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $patients->update([
            'firstName' => $requestData['firstName'],
            'lastName' => $requestData['lastName']
        ]);

        return response()->json([
            'data' => $patients
        ], Response::HTTP_CREATED);
    }

}
