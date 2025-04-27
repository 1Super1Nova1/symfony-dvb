<?php

namespace App\Controller;

use App\Entity\Doctors;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/v1')]
final class DoctorsController extends AbstractController
{

    public const ITEMS_PER_PAGE = 2;

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
    #[Route('/doctors', name: 'get_doctors', methods: [Request::METHOD_GET])]
    public function getdoctors(Request $request): JsonResponse
    {
        $queryParams = $request->query->all();

        $page = $queryParams['page'] ?? 1;
        $itemsPerPage = $queryParams['itemsPerPage'] ?? self::ITEMS_PER_PAGE;

        unset($queryParams['page']);
        unset($queryParams['itemsPerPage']);

        $doctors = $this->entityManager->getRepository(Doctors::class)->getDoctors($queryParams, $page, $itemsPerPage);

        return new JsonResponse(['data' => $doctors], Response::HTTP_OK);
    }


    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/doctors/{id}', name: 'get_doctors_item', methods: [Request::METHOD_GET])]
    public function getdoctorsItem(string $id): JsonResponse
    {
        $doctors = $this->entityManager->getRepository(Doctors::class)->find($id);

        if (!$doctors) {
            return new JsonResponse(['data' => ['error' => 'Not found doctors by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $doctors], Response::HTTP_OK);
    }


    #[Route('/doctors', name: 'post_doctors', methods: [Request::METHOD_POST])]
    public function createdoctors(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $doctors = new doctors();

        $doctors->setFirstName($requestData['firstName'])
            ->setLastName($requestData['lastName']);

        $this->entityManager->persist($doctors);
        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $doctors
        ], Response::HTTP_CREATED);
    }


    #[Route('/doctors/{id}', name: 'patch_doctors', methods: [Request::METHOD_PATCH])]
    public function updatedoctors(string $id, Request $request): JsonResponse
    {
        $doctors = $this->entityManager->getRepository(Doctors::class)->find($id);

        if (!$doctors) {
            return new JsonResponse(['data' => ['error' => 'Not found doctors by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $doctors->setLastName($requestData['lastName']);
        $doctors->setFirstName($requestData['firstName']);

        $this->entityManager->flush();

        return new JsonResponse([
            'data' => $doctors
        ], Response::HTTP_OK);
    }


    #[Route('/doctors/{id}', name: 'delete_doctors', methods: [Request::METHOD_DELETE])]
    public function deletedoctors(string $id): JsonResponse
    {
        $doctors = $this->entityManager->getRepository(Doctors::class)->find($id);

        if (!$doctors) {
            return new JsonResponse(['data' => ['error' => 'Not found doctors by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($doctors);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
