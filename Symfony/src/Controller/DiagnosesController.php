<?php

namespace App\Controller;

use App\Entity\Patients;
use App\Entity\Doctors;
use App\Entity\Diagnoses;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/v1')]
final class DiagnosesController extends AbstractController
{

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/diagnoses', name: 'get_diagnoses', methods: [Request::METHOD_GET])]
    public function getDiagnoses(Request $request): Response
    {
        $queryParams = $request->query->all();

        $page = $queryParams['page'] ?? 1;
        $itemsPerPage = $queryParams['itemsPerPage'] ?? 1;

        unset($queryParams['page']);
        unset($queryParams['itemsPerPage']);

        $diagnoses = $this->entityManager->getRepository(Diagnoses::class)->getDiagnoses($queryParams, $page, $itemsPerPage);

        // dump(['data' => $diagnoses]);
        // exit;

        // return $this->render(
        //     'diagnoses_controller/index.html.twig',
        //     ['diagnoses_controller' => $diagnoses]
        // );

        return new JsonResponse(['data' => $diagnoses], Response::HTTP_OK);
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/diagnoses/{id}', name: 'get_diagnoses_item', methods: [Request::METHOD_GET])]
    public function getDiagnosesItem(string $id): JsonResponse
    {
        $diagnoses = $this->entityManager->getRepository(Diagnoses::class)->find($id);

        if (!$diagnoses) {
            return new JsonResponse(['data' => ['error' => 'Not found diagnoses by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $diagnoses], Response::HTTP_OK);
    }


    #[Route('/diagnoses', name: 'post_diagnoses', methods: [Request::METHOD_POST])]
    public function createDiagnoses(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $doctors = $this->entityManager->getRepository(Doctors::class)->find($requestData['diagnosisMade']);

        if (!$doctors) {
            return new JsonResponse(['data' => ['error' => 'Not found doctors by id ' . $requestData['diagnosisMade']]], Response::HTTP_NOT_FOUND);
        }

        $patients = $this->entityManager->getRepository(Patients::class)->find($requestData['diagnosisHave']);

        if (!$patients) {
            return new JsonResponse(['data' => ['error' => 'Not found patients by id ' . $requestData['diagnosisHave']]], Response::HTTP_NOT_FOUND);
        }

        $diagnoses = new Diagnoses();

        $diagnoses->setDiagnosesName($requestData['diagnosesName'])
            ->setDiagnosisHave($patients)
            ->setDiagnosisMade($doctors);

        $this->entityManager->persist($diagnoses);
        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $diagnoses
        ], Response::HTTP_CREATED);
    }


    #[Route('/diagnoses/{id}', name: 'patch_diagnoses', methods: [Request::METHOD_PATCH])]
    public function updateDiagnoses(string $id, Request $request): JsonResponse
    {
        $diagnoses = $this->entityManager->getRepository(Diagnoses::class)->find($id);

        if (!$diagnoses) {
            return new JsonResponse(['data' => ['error' => 'Not found diagnoses by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $diagnoses->setDiagnosesName($requestData['diagnosesName']);

        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $diagnoses
        ], Response::HTTP_OK);
    }


    #[Route('/diagnoses/{id}', name: 'delete_diagnoses', methods: [Request::METHOD_DELETE])]
    public function deleteDiagnoses(string $id): JsonResponse
    {
        $diagnoses = $this->entityManager->getRepository(Diagnoses::class)->find($id);

        if (!$diagnoses) {
            return new JsonResponse(['data' => ['error' => 'Not found diagnoses by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($diagnoses);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
