<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Repository\ScheduleRepository;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ControlerSchedule extends Controller
{

    /**
     * @var ScheduleRepository
     */
    private ScheduleRepository $ScheduleRepository;

    /**
     * @param ScheduleRepository $ScheduleRepository
     */
    public function __construct(ScheduleRepository $ScheduleRepository)
    {
        $this->ScheduleRepository = $ScheduleRepository;
    }

    /** 
     * @return mixed
     */
    public function getSchedule(Request $request): mixed
    {
        $queryParams = $request->all();

        $itemsPerPage = $queryParams['itemsPerPage'] ?? 2;

        unset($queryParams['page']);
        unset($queryParams['itemsPerPage']);

        $Schedule = $this->ScheduleRepository->getSchedule($queryParams, $itemsPerPage ?? 2);

        return response()->json($Schedule, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getScheduleItem(string $id): mixed
    {
        $Schedule = Schedule::find($id);

        if (!$Schedule) {
            return response()->json(['data' => ['error' => 'Not found Schedule by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $Schedule], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function createSchedule(Request $request): mixed
    {
        $requestData = json_decode($request->getContent(), true);

        $Schedule = new Schedule();

        $Schedule->insertGetId([
            'name' => $requestData['name'],
            'doctor_be_tuday_id' => $requestData['doctorsid_id']
        ]);

        $Schedule = Schedule::all();

        return response()->json([
            'data' => $Schedule
        ], Response::HTTP_CREATED);
    }


    /**
     * @param string $id
     * @return mixed
     */
    public function deletSchedule(string $id): mixed
    {
        $Schedule = Schedule::find($id);

        if (!$Schedule) {
            return response()->json(['data' => ['error' => 'Not found Schedule by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $Schedule->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }


    public function updateSchedule(string $id, Request $request): mixed
    {
        $Schedule = Schedule::find($id);

        if (!$Schedule) {
            return response()->json(['data' => ['error' => 'Not found Schedule by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);
        
        

        $Schedule->update([
            'name' => $requestData['name']
        ]);

        return response()->json([
            'data' => $Schedule
        ], Response::HTTP_CREATED);
    }

}
