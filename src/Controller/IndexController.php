<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlayerRepository;

final class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(PlayerRepository $playerRepository): Response
    {

        $players = $playerRepository->findAll() ?: []; 

        return $this->render('home/index.html.twig', [
            'controller_name' => 'IndexController',
            'players' => $players,
        ]);
    }
}
