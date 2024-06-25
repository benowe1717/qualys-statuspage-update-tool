<?php

namespace App\Form;

use App\Entity\IncidentUpdate;
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

class IncidentUpdateFormType extends AbstractType
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
        $title_placeholder = 'QualysGuard UI is not accessible (IM-11285)';
        $message_placeholder = 'Users are unable to access QualysGuard for KSA ';
        $message_placeholder .= 'Platform 1. Cloud Platform Operations team is ';
        $message_placeholder .= 'actively investigating and further updates will ';
        $message_placeholder .= 'be shared as they are received.';

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
                'attr' => array('placeholder' => $title_placeholder))
            )
            ->add(
                'message',
                TextareaType::class,
                array(
                'attr' => array('placeholder' => $message_placeholder))
            )
            ->add('generate_post', SubmitType::class)
            ->add('reset_form', ButtonType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            // Configure your form options here
                'data_class' => IncidentUpdate::class,
            ]
        );
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('message', new NotBlank());
    }
}
