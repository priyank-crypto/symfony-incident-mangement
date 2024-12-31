<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentSearchType;
use App\Form\IncidentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/incident')]
class IncidentController extends AbstractController
{
    /**
     * List of incident
     * */
    #[Route('/', name: 'incident_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(IncidentSearchType::class);
        $form->handleRequest($request);
        $incidentId = $form->get('incidentId')->getData();
        $incidentRepository = $em->getRepository(Incident::class);
        if ($incidentId) {
            // If a search term is provided, search incidents by incidentId
            $incidents = $incidentRepository->findBy(['incidentId' => $incidentId]);
        } else {
            // If no search term, fetch all incidents
            $incidents = $incidentRepository->findAll();
        }
        return $this->render('incident/index.html.twig', [
            'form' => $form->createView(),
            'incidents' => $incidents,
        ]);
    }

    /**
     * Create new Incident
     * */
    #[Route('/new', name: 'incident_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $incident = new Incident();

        $user = $this->getUser();
        $incident->setReporter($user);

        $incidentId = $incident->generateIncidentId($entityManager);
        $incident->setIncidentId($incidentId);

        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($incident);
            $entityManager->flush();

            $this->addFlash('success', 'Incident created successfully with ID: ' . $incidentId);
            return $this->redirectToRoute('incident_index');
        }

        return $this->render('incident/new.html.twig', [
            'incident' => $incident,
            'form' => $form->createView(),
        ]);
    }

    /**
     * View incident details
     * */
    #[Route('/{id}', name: 'incident_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Incident $incident): Response
    {
        if ($incident->getReporter() !== $this->getUser()) {
            $this->addFlash('error', 'You do not have permission to view this incident.');
            return $this->redirectToRoute('incident_index');
        }

        $status = $incident->getStatus()->value;

        return $this->render('incident/show.html.twig', [
            'incident' => $incident,
            'status' => $status, // Pass the status as a string
        ]);
    }

    /**
     * Update Incident
     */
    #[Route('/{id}/edit', name: 'incident_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Incident $incident, EntityManagerInterface $entityManager): Response
    {
        if ($incident->getReporter() !== $this->getUser()) {
            $this->addFlash('error', 'You do not have permission to perform update.');
            return $this->redirectToRoute('incident_index');
        }
        $form = $this->createForm(IncidentType::class, $incident);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Incident updated successfully.');

            return $this->redirectToRoute('incident_index');
        }

        return $this->render('incident/new.html.twig', [
            'incident' => $incident,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delelte an Incident
     */
    #[Route('/{id}', name: 'incident_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Incident $incident, EntityManagerInterface $entityManager): Response
    {
        // Check if the current user is the reporter of the incident
        if ($incident->getReporter() !== $this->getUser()) {
            $this->addFlash('error', 'You do not have permission to perform delete action.');
            return $this->redirectToRoute('incident_index');
        }

        if ($this->isCsrfTokenValid('delete' . $incident->getId(), $request->request->get('_token'))) {
            $entityManager->remove($incident);
            $entityManager->flush();
            $this->addFlash('success', 'Incident deleted successfully.');
        }

        return $this->redirectToRoute('incident_index');
    }
}
