<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private $title = 'Home';
    private $version = '1.2.0';

    #[Route('/', name: 'app_home', methods:['GET', 'HEAD'])]
    public function index(): Response
    {
        $patch_notes = ['Reworked app to Symfony Framework'];
        $known_issues = ['No known issues! :)'];
        return $this->render(
            'index.html.twig',
            [
                'title' => $this->title,
                'version' => $this->version,
                'patch_notes' => $patch_notes,
                'known_issues' => $known_issues
            ]
        );
    }
}
