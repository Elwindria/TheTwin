<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TwinController extends AbstractController
{
    #[Route('/twin', name: 'app_twin')]
    public function index(): Response
    {
        return $this->render('twin/index.html.twig', [
            'controller_name' => 'TwinController',
        ]);
    }
}
