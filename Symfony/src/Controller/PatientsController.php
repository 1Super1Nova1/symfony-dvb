<?php

namespace App\Controller;

use App\Entity\Patients;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/v1')]
final class PatientsController extends AbstractController
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
    #[Route('/patients', name: 'get_patients', methods: [Request::METHOD_GET])]
    public function getpatients(): JsonResponse
    {
        $patients = $this->entityManager->getRepository(Patients::class)->findAll();

        return new JsonResponse(['data' => $patients], Response::HTTP_OK);
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/patients/{id}', name: 'get_patients_item', methods: [Request::METHOD_GET])]
    public function getpatientsItem(string $id): JsonResponse
    {
        $patients = $this->entityManager->getRepository(Patients::class)->find($id);

        if (!$patients) {
            return new JsonResponse(['data' => ['error' => 'Not found patients by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $patients], Response::HTTP_OK);
    }


    #[Route('/patients', name: 'post_patients', methods: [Request::METHOD_POST])]
    public function createpatients(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true); 

        $patients = new patients();

        $patients->setFirstName($requestData['firstName'])
            ->setLastName($requestData['lastName']);

        $this->entityManager->persist($patients);
        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $patients
        ], Response::HTTP_CREATED);
    }


    #[Route('/patients/{id}', name: 'patch_patients', methods: [Request::METHOD_PATCH])]
    public function updatepatients(string $id, Request $request): JsonResponse
    {
        $patients = $this->entityManager->getRepository(Patients::class)->find($id);

        if (!$patients) {
            return new JsonResponse(['data' => ['error' => 'Not found patients by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $patients->setLastName($requestData['lastName']);
        $patients->setFirstName($requestData['firstName']);

        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $patients
        ], Response::HTTP_OK);
    }


    #[Route('/patients/{id}', name: 'delete_patients', methods: [Request::METHOD_DELETE])]
    public function deletepatients(string $id): JsonResponse
    {
        $patients = $this->entityManager->getRepository(Patients::class)->find($id);

        if (!$patients) {
            return new JsonResponse(['data' => ['error' => 'Not found patients by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($patients);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
