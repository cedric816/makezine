<?php

namespace App\Controller;

use App\Repository\FanzineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FanzineRepository $zineRepo): Response
    {
        $lastZines = $zineRepo->findLastFour();
        return $this->render('home/index.html.twig', [
            'lastZines' => $lastZines
        ]);
    }

    /**
     * @Route("/zine/{id}", name="home_read")
     */
    public function read($id, FanzineRepository $zineRepo): Response
    {
        $zine = $zineRepo->find($id);
        return $this->render('home/read.html.twig', [
            'zine' => $zine
        ]);
    }

     /**
     * @Route("/zine/print/{id}", name="home_print")
     */
    public function print($id, FanzineRepository $zineRepo): Response
    {
        $zine = $zineRepo->find($id);
        return $this->render('home/print.html.twig', [
            'fanzine' => $zine
        ]);
    }
}
