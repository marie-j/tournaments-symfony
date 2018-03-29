<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(Request $request)
    {

        $tournaments = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->findAll();

        return $this->render('homepage.html.twig',
            [
                'tournaments' => $tournaments,
                'message' => $request->query->get('message', 'Pas de message')
            ]);
    }

    /**
     * @Route("/tournament", name="tournament")
     */
    public function createTournament(Request $request)
    {
        $tournament = new Tournament();
        $form = $this->getForm($tournament, 'Create', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tournament);
            $entityManager->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render('tournament/create.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    public function getForm(Tournament $tournament, string $label, Request $request)
    {
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->add(
            $label, SubmitType::class, array(
                'label' => $label,
                'attr' => array('class' => 'btn btn-primary')
                ));

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @Route("/tournament/{id}", name="tournament_detail")
     */
    public function showTournament(Request $request, int $id)
    {
        $tournament = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->find($id);

        return $this->render('tournament/tournament.html.twig',
            [
                'tournament' => $tournament
            ]);
    }

    /**
     * @Route("/tournament/{id}/update", name="tournament_update")
     */
    public function updateTournament(Request $request, int $id)
    {
        $tournament = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->find($id);
        $form = $this->getForm($tournament, 'Update', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tournament);
            $entityManager->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render('tournament/update.html.twig',
            [
                'form' => $form->createView(),
                'tournament' => $tournament
            ]);
    }

    /**
     * @Route("/tournament/{id}/delete", name="tournament_delete")
     */
    public function deleteTournament(Request $request, int $id)
    {
        $tournament = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->find($id);

        $entityManager = $this->getDoctrine()
            ->getManager();
        $entityManager->remove($tournament);
        $entityManager->flush();

        return $this->redirectToRoute('home_page');
    }
}
