<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use App\Repository\DoctorRepository;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ControlerDoctors extends Controller
{

    /**
     * @var DoctorRepository
     */
    private DoctorRepository $doctorRepository;

    /**
     * @param DoctorRepository $doctorRepository
     */
    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    /** 
     * @return mixed
     */
    public function getDoctors(Request $request): mixed
    {
        $queryParams = $request->all();

        $itemsPerPage = $queryParams['itemsPerPage'] ?? 2;

        unset($queryParams['page']);
        unset($queryParams['itemsPerPage']);

        $Doctors = $this->doctorRepository->getDoctors($queryParams, $itemsPerPage ?? 2);

        return response()->json($Doctors, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getDoctorsItem(string $id): mixed
    {
        $Doctors = Doctors::find($id);

        if (!$Doctors) {
            return response()->json(['data' => ['error' => 'Not found Doctors by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $Doctors], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function createDoctors(Request $request): mixed
    {
        $requestData = json_decode($request->getContent(), true);

        $Doctors = new Doctors();

        $Doctors->create([
            'firstName' => $requestData['firstName'],
            'lastName' => $requestData['lastName']
        ]);

        $Doctors = Doctors::all();

        return response()->json([
            'data' => $Doctors
        ], Response::HTTP_CREATED);
    }


    /**
     * @param string $id
     * @return mixed
     */
    public function deletDoctors(string $id): mixed
    {
        $Doctors = Doctors::find($id);

        if (!$Doctors) {
            return response()->json(['data' => ['error' => 'Not found Doctors by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $Doctors->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }


    public function updateDoctors(string $id, Request $request): mixed
    {
        $Doctors = Doctors::find($id);

        if (!$Doctors) {
            return response()->json(['data' => ['error' => 'Not found Doctors by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $Doctors->update([
            'firstName' => $requestData['firstName'],
            'lastName' => $requestData['lastName']
        ]);

        return response()->json([
            'data' => $Doctors
        ], Response::HTTP_CREATED);
    }

}
