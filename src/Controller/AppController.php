<?php

namespace App\Controller;

use App\Repository\FanzineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app")
 */
class AppController extends AbstractController
{
    private $zineRepo;

    public function __construct(FanzineRepository $zineRepo)
    {
        $this->zineRepo = $zineRepo;
    }
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $fanzines = $this->getUser()->getFanzines();
        return $this->render('app/index.html.twig',[
            "fanzines" => $fanzines
        ]);
    }

    /**
     * @Route("/{id}", name="edit_zine")
     */
    public function edit($id): Response
    {
        $fanzines = $this->getUser()->getFanzines();
        $selectedZine = $this->zineRepo->find($id);
        $pages = $selectedZine->getPages();
        return $this->render('app/index.html.twig',[
            "fanzines" => $fanzines,
            "selectedZine" => $selectedZine,
            "pages" => $pages
        ]);
    }
}
