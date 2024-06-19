<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatusPageController extends AbstractController
{
    private $title = 'Status Page Update Tool';

    #[Route('/status_page', name: 'app_status_page', methods:['GET', 'HEAD'])]
    public function index(): Response
    {
        return $this->render(
            'status_page/index.html.twig',
            ['title' => $this->title]
        );
    }
}
