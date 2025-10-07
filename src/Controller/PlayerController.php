<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use App\Controller\IsGranted;

#[Route('/player')]
final class PlayerController extends AbstractController
{
    #[Route(name: 'app_player_index', methods: ['GET'])]
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', [
            'players' => $playerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_player_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('player/new.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    //#[Route('/{id}', name: 'app_player_show', methods: ['GET'])]
    // public function show(Player $player): Response
    // {
    //     return $this->render('player/show.html.twig', [
    //         'player' => $player,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_player_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('player/edit.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_player_delete', methods: ['POST'])]
    public function delete(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($player);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/{id}', name: 'app_player_show', methods: ['GET', 'POST'])]
public function show(Player $player,Request $request,EntityManagerInterface $em,ReviewRepository $reviewRepository): Response {
    
    $reviews = $player->getReviews();

    // Calcul de la note moyenne
    $notes = array_map(fn($r) => $r->getNote(), $reviews->toArray());
    $average = count($notes) ? round(array_sum($notes) / count($notes), 2) : 0;

    $reviewForm = null;
    if ($this->getUser()) {

        $existingReview = $reviewRepository->findOneBy([
            'Joueur' => $player,
            'Utilisateur' => $this->getUser(),
        ]);

        if ($existingReview) {
            $this->addFlash('warning', 'Vous avez déjà posté un avis pour ce joueur.');
            return $this->redirectToRoute('app_player_show', ['id' => $player->getId()]);
        }

       
        $review = new Review();
        $review->setJoueur($player);
        $review->setUtilisateur($this->getUser());
        //$review->setCreatedAt(new \DateTimeImmutable());

        $reviewForm = $this->createForm(ReviewType::class, $review);
        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            $em->persist($review);
            $em->flush();
            $this->addFlash('success', 'Votre avis a été ajouté.');
            
            return $this->redirectToRoute('app_player_show', ['id' => $player->getId(),]);
            
        }
    }

    return $this->render('player/show.html.twig', [
        'player' => $player,
        'reviews' => $reviews,
        'average' => $average,
        'reviewForm' => $reviewForm?->createView(),
    ]);
}

}
