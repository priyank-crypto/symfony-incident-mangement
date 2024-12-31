<?php

namespace App\Form;

use App\Entity\Incident;
use App\Enum\IncidentStatus;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entityType', ChoiceType::class, [
                'label' => 'Entity Type : ',
                'choices' => [
                    'Enterprise' => 'enterprise',
                    'Government' => 'government',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please select the entity type.']),
                ],
            ])
            ->add('incidentDetails', TextareaType::class, [
                'label' => 'Incident Details',
                'required' => false,
            ])
            ->add('reportedDate', DateTimeType::class, [
                'label' => 'Reported Date',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('priority', ChoiceType::class, [
                'label' => 'Priority',
                'choices' => [
                    'Low' => 'low',
                    'Medium' => 'medium',
                    'High' => 'high',
                ],
                'placeholder' => 'Select a priority',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Open' => IncidentStatus::OPEN,
                    'In Progress' => IncidentStatus::IN_PROGRESS,
                    'Closed' => IncidentStatus::CLOSED,

                ],
            ])
            ->add('reporter', null, [
                'attr' => ['class' => 'form-control', 'readonly' => true],
                'label' => 'Reporter',
                'disabled' => true,
                'choice_label' => 'first_name', // Assuming User has an email property
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
