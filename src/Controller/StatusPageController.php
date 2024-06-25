<?php

namespace App\Controller;

use App\Entity\IncidentUpdate;
use App\Entity\MaintenanceUpdate;
use App\Form\MaintenanceUpdateFormType;
use Exception;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\IncidentUpdateFormType;

class StatusPageController extends AbstractController
{
    private $redis;
    private $title = 'Status Page Update Tool';
    private array $platforms;

    public function __construct(ClientInterface $client)
    {
        $this->redis = $client;
    }

    /**
     * Connect to Redis and retrieve the configured Platforms
     * Data stored in Redis is in a serialized string and will be
     * unserialized into an Array on return
     *
     * @return bool
     **/
    private function getPlatforms(): bool
    {
        try {
            $key = 'platforms';
            $platforms = $this->redis->get($key);
            if (empty($platforms)) {
                return false;
            }
            $this->platforms = unserialize($platforms);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Take the submitted platform id by the user
     * and return the corresponding platform name
     *
     * @param int $platform The platform's id
     *
     * @return string|false
     **/
    private function isValidPlatform(int $platform): string|false
    {
        if ($platform <= 0) {
            return false;
        }

        if ($platform > count($this->platforms)) {
            return false;
        }

        return $this->platforms[$platform];
    }

    /**
     * Take the submitted title from the user and valid the input
     *
     * @param string $title The title submitted by the user
     *
     * @return bool
     **/
    private function isValidTitle(string $title): bool
    {
        if ($title === 'asdf') {
            return false;
        }
        return true;
    }

    #[Route('/status_page', name: 'app_status_page', methods:['GET', 'HEAD', 'POST'])]
    public function index(Request $request): Response
    {
        $errors = 0;
        $submitted = 0;
        $active_tab = 'incident';
        $incident_title = '';
        $incident_message = '';
        $maintenance_title = '';
        $maintenance_message = '';
        $maintenance_ticket_number = '';
        $maintenance_reference_link = '';

        $incident = new IncidentUpdate();
        $incidentform = $this->createForm(IncidentUpdateFormType::class, $incident);
        $incidentform->handleRequest($request);

        if ($incidentform->isSubmitted() && $incidentform->isValid()) {
            $data = $incidentform->getData();
            if (!$this->isValidTitle($data->getTitle())) {
                $incidentform->get('title')
                    ->addError(new FormError('Please fill in a valid title!'));
                $errors++;
            }

            if (!$this->isValidTitle($data->getMessage())) {
                $incidentform->get('message')
                    ->addError(new FormError('Please fill in a valid message!'));
                $errors++;
            }

            $this->getPlatforms();
            $platform = $data->getPlatform();
            $platform_name = $this->isValidPlatform($platform);
            if (!$platform_name) {
                $incidentform->get('platform')
                    ->addError(new FormError('Please select a valid platform!'));
                $errors++;
            } else {
                $data->setPlatform($platform_name);
            }

            if ($errors === 0) {
                $incident_title = $data->getFormattedTitle();
                $incident_message = $data->getMessage();
                $submitted = 1;
            }
        }

        $maintenance = new MaintenanceUpdate();
        $maintform = $this->createForm(
            MaintenanceUpdateFormType::class,
            $maintenance
        );
        $maintform->handleRequest($request);

        if ($maintform->isSubmitted() && $maintform->isValid()) {
            $active_tab = 'maintenance';
            $data = $maintform->getData();
            if (!$this->isValidTitle($data->getTitle())) {
                $maintform->get('title')
                    ->addError(new FormError('Please fill in a valid title!'));
                $errors++;
            }

            if (!$this->isValidTitle($data->getMessage())) {
                $maintform->get('message')
                    ->addError(new FormError('Please fill in a valid message!'));
                $errors++;
            }

            if (empty($data->getTicketNumber())) {
                $maintform->get('ticket_number')
                    ->addError(
                        new FormError('Please fill in a valid Ticket Number!')
                    );
                $errors++;
            }

            if (empty($data->getReferenceLink())) {
                $maintform->get('reference_link')
                    ->addError(
                        new FormError('Please fill in a valid Reference Link!')
                    );
                $errors++;
            }

            $this->getPlatforms();
            $platform = $data->getPlatform();
            $platform_name = $this->isValidPlatform($platform);
            if (!$platform_name) {
                $maintform->get('platform')
                    ->addError(new FormError('Please select a valid platform!'));
                $errors++;
            } else {
                $data->setPlatform($platform_name);
            }

            if ($errors === 0) {
                $maintenance_title = $data->getFormattedTitle();
                $maintenance_message = $data->getFormattedMessage();
                $submitted = 1;
            }
        }

        return $this->render(
            'status_page/index.html.twig',
            ['title' => $this->title,
                'active_tab' => $active_tab,
                'incidentform' => $incidentform,
                'incident_title' => $incident_title,
                'incident_message' => $incident_message,
                'maintform' => $maintform,
                'maintenance_title' => $maintenance_title,
                'maintenance_message' => $maintenance_message,
                'errors' => $errors, 'submitted' => $submitted
            ]
        );
    }
}
