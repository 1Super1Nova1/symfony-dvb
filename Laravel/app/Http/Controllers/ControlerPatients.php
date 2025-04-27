<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Repository\PatientsRepository;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ControlerPatients extends Controller
{

    /**
     * @var PatientsRepository
     */
    private PatientsRepository $patientsRepository;

    /**
     * @param PatientsRepository $patientsRepository
     */
    public function __construct(PatientsRepository $patientsRepository)
    {
        $this->patientsRepository = $patientsRepository;
    }

    /** 
     * @return mixed
     */
    public function getPatients(Request $request): mixed

    {
        $queryParams = $request->all();

        $itemsPerPage = $queryParams['itemsPerPage'] ?? 2;

        unset($queryParams['page']);
        unset($queryParams['itemsPerPage']);

        $patients = $this->patientsRepository->getPatients($queryParams, $itemsPerPage ?? 2);

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
