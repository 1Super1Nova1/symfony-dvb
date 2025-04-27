<?php

namespace App\Http\Controllers;

use App\Models\Diagnoses;
use App\Repository\DiagnosesRepository;
use App\Models\Doctors;
use App\Models\Patients;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ControlerDiagnoses extends Controller
{

    /**
     * @var DiagnosesRepository
     */
    private DiagnosesRepository $DiagnosesRepository;

    /**
     * @param DiagnosesRepository $DiagnosesRepository
     */
    public function __construct(DiagnosesRepository $DiagnosesRepository)
    {
        $this->DiagnosesRepository = $DiagnosesRepository;
    }

    /** 
     * @return mixed
     */
    public function getDiagnoses(Request $request): mixed
    {
        $queryParams = $request->all();

        $itemsPerPage = $queryParams['itemsPerPage'] ?? 2;

        unset($queryParams['page']);
        unset($queryParams['itemsPerPage']);

        $Diagnoses = $this->DiagnosesRepository->getDiagnoses($queryParams, $itemsPerPage ?? 2);

        return response()->json($Diagnoses, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getDiagnosesItem(string $id): mixed
    {
        $Diagnoses = Diagnoses::find($id);

        if (!$Diagnoses) {
            return response()->json(['data' => ['error' => 'Not found Diagnoses by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $Diagnoses], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function creatDiagnoses(Request $request): mixed
    {
        $requestData = json_decode($request->getContent(), true);

        $Diagnoses = new Diagnoses();

        $Diagnoses->insertGetId([
            'diagnosesName' => $requestData['diagnosesName'],
            'doctorsid_id' => $requestData['doctorsid_id'],
            'patient_id' => $requestData['patient_id']
        ]);

        $Diagnoses = Diagnoses::all();
        
        return response()->json([
            'data' => $Diagnoses
        ], Response::HTTP_CREATED);
    }


    /**
     * @param string $id
     * @return mixed
     */
    public function deletDiagnoses(string $id): mixed
    {
        $Diagnoses = Diagnoses::find($id);

        if (!$Diagnoses) {
            return response()->json(['data' => ['error' => 'Not found Diagnoses by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $Diagnoses->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }


    public function updateDiagnoses(string $id, Request $request): mixed
    {
        $Diagnoses = Diagnoses::find($id);

        if (!$Diagnoses) {
            return response()->json(['data' => ['error' => 'Not found Diagnoses by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $Diagnoses->update([
            'diagnosesName' => $requestData['diagnosesName']
        ]);

        return response()->json([
            'data' => $Diagnoses
        ], Response::HTTP_CREATED);
    }

}
