<?php

namespace App\Form;

use App\Entity\MaintenanceUpdate;
use Exception;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class MaintenanceUpdateFormType extends AbstractType
{
    private $redis;
    private array $platforms;

    public function __construct(ClientInterface $client)
    {
        $this->redis = $client;
    }

    private function getPlatforms(): bool
    {
        try {
            $serialized_platforms = $this->redis->get('platforms');
            $this->platforms = unserialize($serialized_platforms);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function isPlatform(int $platform): bool
    {
        if ($platform === 0 || $platform < 0) {
            return false;
        }
        return true;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $title_placeholder = 'File Integrity Monitoring (FIM) 3.8.0.0 ';
        $title_placeholder .= 'Release Notification (CMB-215218)';
        $message_placeholder = 'A new release of File Integrity Monitoring ';
        $message_placeholder .= '3.8.0.0 (FIM) is going to be released into ';
        $message_placeholder .= 'production. The deployment is completely ';
        $message_placeholder .= 'transparent to users, and no impact is expected.';
        $ticket_number_placeholder = 'CMB-215218';
        $ref_link_placeholder = 'https://www.qualys.com/docs/release-notes';
        $ref_link_placeholder .= '/qualys-file-integrity-monitoring-3.8-';
        $ref_link_placeholder .= 'release-notes.pdf';

        $choices = array();

        $result = $this->getPlatforms();
        if (!$result) {
            $choices['No platforms available'] = null;
        } else {
            foreach ($this->platforms as $key => $value) {
                $choices[$value] = $key;
            }
        }
        $builder
            ->add(
                'platform',
                ChoiceType::class,
                ['choices' => $choices, 'placeholder' => 'Select...']
            )
            ->add(
                'title',
                TextType::class,
                array(
                    'attr' => array('placeholder' => $title_placeholder)
                )
            )
            ->add(
                'ticket_number',
                TextType::class,
                array(
                    'attr' => array('placeholder' => $ticket_number_placeholder)
                )
            )
            ->add(
                'message',
                TextareaType::class,
                array(
                    'attr' => array('placeholder' => $message_placeholder)
                )
            )
            ->add(
                'reference_link',
                TextType::class,
                array(
                    'attr' => array('placeholder' => $ref_link_placeholder)
                )
            )
            ->add('generate_post', SubmitType::class)
            ->add('reset_form', ButtonType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            // Configure your form options here
                'data_class' => MaintenanceUpdate::class
            ]
        );
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('message', new NotBlank());
        $metadata->addPropertyConstraint('ticket_number', new NotBlank());
        $metadata->addPropertyConstraint('reference_link', new NotBlank());
    }
}
