<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Country;
use App\Entity\States;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationType extends AbstractType
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userType', ChoiceType::class, [
                'label' => 'User Type',
                'choices' => [
                    'Individual' => 'individual',
                    'Employee' => 'employee',
                    'Government' => 'government',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Please select a user type.']),
                ],
            ])
            ->add('firstName', null, [
                'label' => 'First Name',
                'constraints' => [
                    new NotBlank(['message' => 'First name is required.']),
                ]
            ])
            ->add('lastName', null, [
                'label' => 'Last Name'
            ])
            ->add('email', null, [
                'label' => 'Email Address',
                'constraints' => [
                    new NotBlank(['message' => 'Email is required.']),
                ]
            ])
            ->add('address', null, [
                'label' => 'Address',
                'constraints' => [
                    new NotBlank(['message' => 'Address is required.']),
                ]
            ])
            ->add('pincode', null, [
                'label' => 'Pincode',
                'constraints' => [
                    new NotBlank(['message' => 'Pincode is required.']),
                ]
            ])
            ->add('country', null, [
                'label' => 'Country',
                'attr' => ['placeholder' => 'Enter country name', 'readonly' => true],
                'constraints' => [
                    new NotBlank(['message' => 'Country is required.']),
                ],
            ])
            ->add('state', null, [
                'label' => 'State',
                'attr' => ['placeholder' => 'Enter state name', 'readonly' => true],
                'constraints' => [
                    new NotBlank(['message' => 'State is required.']),
                ],
            ])
            ->add('city', null, [
                'label' => 'City',
                'attr' => ['placeholder' => 'Enter city name', 'readonly' => true],
                'constraints' => [
                    new NotBlank(['message' => 'City is required.']),
                ],
            ])

            ->add('mobile', null, [
                'label' => 'Mobile Number',
                'constraints' => [
                    new NotBlank(['message' => 'Mobile number is required.']),
                ]
            ])
            ->add('fax', null, [
                'label' => 'Fax Number',
                'required' => false, // Optional field
            ])
            ->add('phone', null, [
                'label' => 'Phone Number',
                'required' => false, // Optional field
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'constraints' => [
                    new NotBlank(['message' => 'Password is required.']),
                    new Length(['min' => 8, 'minMessage' => 'Password should be at least 8 characters.']),
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirm Password',
                'constraints' => [
                    new NotBlank(['message' => 'Please confirm your password.']),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    // fetch countries
    // private function getCountries(): array
    // {
    //     $countries = $this->entityManager->getRepository(Country::class)->findAll();
    //     $choices = [];
    //     foreach ($countries as $country) {
    //         $choices[$country->getName()] = $country->getId(); // Display name => ID
    //     }
    //     return $choices;
    // }

    // private function getStates(): array
    // {
    //     // You might filter by country in real scenarios
    //     $states = $this->entityManager->getRepository(States::class)->findAll();
    //     $choices = [];
    //     foreach ($states as $state) {
    //         $choices[$state->getName()] = $state->getId(); // Display name => ID
    //     }
    //     return $choices;
    // }

    // private function getCities(): array
    // {
    //     $cities = $this->entityManager->getRepository(Cities::class)->findAll();
    //     $choices = [];
    //     foreach ($cities as $city) {
    //         $choices[$city->getName()] = $city->getId(); // Display name => ID
    //     }
    //     return $choices;
    // }
}
