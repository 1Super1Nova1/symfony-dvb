<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestControlerController extends AbstractController
{
    #[Route('/test/controler', name: 'app_test_controler')]
    public function index(): Response
    {
        return $this->render('test_controler/index.html.twig', [
            'controller_name' => 'TestControlerController',
        ]);
    }
}