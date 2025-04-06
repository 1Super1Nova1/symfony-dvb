<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ControlerTreatment extends Controller
{

    /** 
     * @return mixed
     */
    public function getTreatment(): mixed
    {
        $Treatment = Treatment::all();

        return response()->json($Treatment, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getTreatmentItem(string $id): mixed
    {
        $Treatment = Treatment::find($id);

        if (!$Treatment) {
            return response()->json(['data' => ['error' => 'Not found Treatment by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $Treatment], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function createTreatment(Request $request): mixed
    {
        $requestData = json_decode($request->getContent(), true);

        $Treatment = new Treatment();

        is_null($requestData);

        $Treatment->insertGetId([
            'name' => $requestData['name'],
            'patient_id' => $requestData['patient_id']
        ]);

        $Treatment = Treatment::all();

        return response()->json([
            'data' => $Treatment
        ], Response::HTTP_CREATED);
    }


    /**
     * @param string $id
     * @return mixed
     */
    public function deletTreatment(string $id): mixed
    {
        $Treatment = Treatment::find($id);

        if (!$Treatment) {
            return response()->json(['data' => ['error' => 'Not found Treatment by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $Treatment->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }


    public function updateTreatment(string $id, Request $request): mixed
    {
        $Treatment = Treatment::find($id);

        if (!$Treatment) {
            return response()->json(['data' => ['error' => 'Not found Treatment by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $Treatment->update([
            'name' => $requestData['name']
        ]);

        return response()->json([
            'data' => $Treatment
        ], Response::HTTP_CREATED);
    }

}
