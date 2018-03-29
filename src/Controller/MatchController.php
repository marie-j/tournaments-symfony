<?php
/**
 * Created by PhpStorm.
 * User: Marie
 * Date: 3/25/18
 * Time: 7:21 PM
 */

namespace App\Controller;

use App\Entity\Match;
use App\Entity\Tournament;
use App\Form\MatchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/tournament/{id}")
 */
class MatchController extends AbstractController
{

    public function getForm(Match $match, string $label, Request $request)
    {
        $form = $this->createForm(MatchType::class, $match);
        $form->add(
            $label, SubmitType::class, array(
            'label' => $label,
            'attr' => array('class' => 'btn btn-primary')
        ));

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @Route("/match", name="match_create")
     */
    public function createMatch(Request $request, int $id)
    {
        $tournament = $this->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->find($id);

        $match = new Match();
        $match->tournament = $tournament;
        $form = $this->getForm($match, 'Create', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($match);
            $entityManager->flush();

            return $this->redirectToRoute('tournament_detail', array('id' => $id));
        }

        return $this->render('match/create.html.twig',
            [
                'form' => $form->createView(),
                'tournament' => $tournament
            ]);
    }

    /**
     * @Route("/match/{match_id}/update", name="match_update")
     */
    public function updateMatch(Request $request, int $id, int $match_id)
    {
        $match = $this->getDoctrine()
            ->getManager()
            ->getRepository(Match::class)
            ->find($match_id);
        $form = $this->getForm($match, 'Update', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($match);
            $entityManager->flush();

            return $this->redirectToRoute('tournament_detail', array('id' => $id));
        }

        return $this->render('match/update.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/match/{match_id}/delete", name="match_delete")
     */
    public function deleteMatch(Request $request, int $id, int $match_id)
    {
        $em = $this->getDoctrine()->getManager();
        $match = $em->getRepository(Match::class)->find($match_id);
        $em->remove($match);
        $em->flush();

        return $this->redirectToRoute('tournament_detail', array('id' => $id));
    }
}