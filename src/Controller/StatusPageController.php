<?php

namespace App\Controller;

use Exception;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatusPageController extends AbstractController
{
    private $redis;
    private $title = 'Status Page Update Tool';

    public function __construct(ClientInterface $client)
    {
        $this->redis = $client;
    }

    private function getPlatforms(): array|false
    {
        try {
            $key = 'platforms';
            $platforms = $this->redis->get($key);
            if (empty($platforms)) {
                return false;
            }
            return unserialize($platforms);
        } catch (Exception $e) {
            return false;
        }
    }

    #[Route('/status_page', name: 'app_status_page', methods:['GET', 'HEAD'])]
    public function index(): Response
    {
        $platforms = $this->getPlatforms();
        if (!$platforms) {
            $platforms[] = 'No platforms available';
        }

        return $this->render(
            'status_page/index.html.twig',
            ['title' => $this->title, 'platforms' => $platforms]
        );
    }
}
