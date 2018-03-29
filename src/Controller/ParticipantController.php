<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/participants")
 */
class ParticipantController extends AbstractController
{

    /**
     * @Route("/", name="participants")
     */
    public function index(Request $request)
    {
        $participants = $this->getDoctrine()
            ->getManager()
            ->getRepository(Participant::class)
            ->findAll();

        return $this->render('participant/home.html.twig',
            [
                'participants' => $participants
            ]);
    }

    public function getForm($player, $label, $request)
    {
        $form = $this->createForm(ParticipantType::class, $player);
        $form->add(
            $label, SubmitType::class, array(
            'label' => $label,
            'attr' => array('class' => 'btn btn-primary')
        ));

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @Route("/create", name="participants_create")
     */
    public function createPlayer(Request $request)
    {
        $participant = new Participant();
        $form = $this->getForm($participant, 'Create', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('participants');
        }

        return $this->render('participant/create.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
}