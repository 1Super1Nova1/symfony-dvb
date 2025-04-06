<?php

namespace App\Controller;

use App\Entity\Patients;
use App\Entity\Treatment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/v1')]
final class TreatmentControler extends AbstractController
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
    #[Route('/treatment', name: 'get_treatment', methods: [Request::METHOD_GET])]
    public function getTreatment(): JsonResponse
    {
        $treatment = $this->entityManager->getRepository(Treatment::class)->findAll();

        return new JsonResponse(['data' => $treatment], Response::HTTP_OK);
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/treatment/{id}', name: 'get_treatment_item', methods: [Request::METHOD_GET])]
    public function getTreatmentItem(string $id): JsonResponse
    {
        $treatment = $this->entityManager->getRepository(Treatment::class)->find($id);

        if (!$treatment) {
            return new JsonResponse(['data' => ['error' => 'Not found treatment by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $treatment], Response::HTTP_OK);
    }


    #[Route('/treatment', name: 'post_treatment', methods: [Request::METHOD_POST])]
    public function createTreatment(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $patients = $this->entityManager->getRepository(Patients::class)->find($requestData['patient_id']);

        if (!$patients) {
            return new JsonResponse(['data' => ['error' => 'Not found patients by id ' . $requestData['patient_id']]], Response::HTTP_NOT_FOUND);
        }

        $treatment = new treatment();

        $treatment->setName($requestData['name'])
            ->setPatient($patients);

        $this->entityManager->persist($treatment);
        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $treatment
        ], Response::HTTP_CREATED);
    }


    #[Route('/treatment/{id}', name: 'patch_treatment', methods: [Request::METHOD_PATCH])]
    public function updatetreatment(string $id, Request $request): JsonResponse
    {
        $treatment = $this->entityManager->getRepository(Treatment::class)->find($id);

        if (!$treatment) {
            return new JsonResponse(['data' => ['error' => 'Not found treatment by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $treatment->setName($requestData['name']);

        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $treatment
        ], Response::HTTP_OK);
    }


    #[Route('/treatment/{id}', name: 'delete_treatment', methods: [Request::METHOD_DELETE])]
    public function deletTreatment(string $id): JsonResponse
    {
        $treatment = $this->entityManager->getRepository(Treatment::class)->find($id);

        if (!$treatment) {
            return new JsonResponse(['data' => ['error' => 'Not found treatment by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($treatment);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
