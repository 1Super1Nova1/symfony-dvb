<?php

namespace App\Controller;

use App\Entity\Doctors;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/v1')]
final class ScheduleControler extends AbstractController
{

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return JsonResponse
     */
    #[Route('/schedule', name: 'get_schedule', methods: [Request::METHOD_GET])]
    public function getSchedule(): JsonResponse
    {
        $schedule = $this->entityManager->getRepository(Schedule::class)->findAll();

        return new JsonResponse(['data' => $schedule], Response::HTTP_OK);
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/schedule/{id}', name: 'get_schedule_item', methods: [Request::METHOD_GET])]
    public function getScheduleItem(string $id): JsonResponse
    {
        $schedule = $this->entityManager->getRepository(Schedule::class)->find($id);

        if (!$schedule) {
            return new JsonResponse(['data' => ['error' => 'Not found schedule by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $schedule], Response::HTTP_OK);
    }


    #[Route('/schedule', name: 'post_schedule', methods: [Request::METHOD_POST])]
    public function createSchedule(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $doctors = $this->entityManager->getRepository(Doctors::class)->find($requestData['doctor_be_tuday_id']);

        if (!$doctors) {
            return new JsonResponse(['data' => ['error' => 'Not found doctors by id ' . $requestData['doctor_be_tuday_id']]], Response::HTTP_NOT_FOUND);
        }

        $schedule = new schedule();

        $schedule->setName($requestData['name'])
            ->setDoctorBeTuday($doctors);

        $this->entityManager->persist($schedule);
        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $schedule
        ], Response::HTTP_CREATED);
    }


    #[Route('/schedule/{id}', name: 'patch_schedule', methods: [Request::METHOD_PATCH])]
    public function updateSchedule(string $id, Request $request): JsonResponse
    {
        $schedule = $this->entityManager->getRepository(Schedule::class)->find($id);

        if (!$schedule) {
            return new JsonResponse(['data' => ['error' => 'Not found schedule by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $schedule->setName($requestData['name']);

        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $schedule
        ], Response::HTTP_OK);
    }


    #[Route('/schedule/{id}', name: 'delete_schedule', methods: [Request::METHOD_DELETE])]
    public function deleteSchedule(string $id): JsonResponse
    {
        $schedule = $this->entityManager->getRepository(Schedule::class)->find($id);

        if (!$schedule) {
            return new JsonResponse(['data' => ['error' => 'Not found schedule by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($schedule);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
