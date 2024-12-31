<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Entity\States;
use App\Entity\User;
use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        // Create the form and handle the request
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password and set it on the user entity
            $password = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($password);

            // Save the user to the database

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Registration successful! You can now log in.');

            // Redirect to the login page after successful registration
            return $this->redirectToRoute('app_register');
        }

        // Render the registration form
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // #[Route('/get-states/{countryId}', name: 'get_states', methods: ['GET'])]
    // public function getStates(int $countryId): JsonResponse
    // {
    //     $states = $this->entityManager
    //         ->getRepository(States::class)
    //         ->findBy(['country' => $countryId]);

    //     $stateList = [];
    //     foreach ($states as $state) {
    //         $stateList[] = ['id' => $state->getId(), 'name' => $state->getName()];
    //     }

    //     return new JsonResponse($stateList);
    // }

    // #[Route('/get-cities/{stateId}', name: 'get_cities', methods: ['GET'])]
    // public function getCities(int $stateId): JsonResponse
    // {
    //     $cities = $this->entityManager
    //         ->getRepository(Cities::class)
    //         ->findBy(['state' => $stateId]);

    //     $cityList = [];
    //     foreach ($cities as $city) {
    //         $cityList[] = ['id' => $city->getId(), 'name' => $city->getName()];
    //     }

    //     return new JsonResponse($cityList);
    // }

    #[Route('/api/get-location', name: 'api_get_location', methods: ['GET'])]
    public function getLocation(Request $request): JsonResponse
    {
        $pincode = $request->query->get('pincode');

        if (!$pincode) {
            return new JsonResponse(['error' => 'Pincode is required'], Response::HTTP_BAD_REQUEST);
        }

        // Call to external API
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET', "https://api.zippopotam.us/IN/$pincode");
            $data = json_decode($response->getBody(), true);

            if (!empty($data['places'])) {
                $city = $data['places'][0]['place name'] ?? null;
                $state = $data['places'][0]['state'] ?? ($data['places'][0]['state name'] ?? null);
                $country = $data['country'] ?? null;

                return new JsonResponse([
                    'city' => $city,
                    'state' => $state,
                    'country' => $country
                ]);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Could not fetch location data'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['error' => 'Invalid Pincode'], Response::HTTP_BAD_REQUEST);
    }
}
