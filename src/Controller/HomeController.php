<?php

namespace App\Controller;

use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BannerRepository $bannerRepository): Response
    {
        return $this->render('home/list.html.twig', [
            'banners' => $bannerRepository->getPublished()
        ]);
    }
}
