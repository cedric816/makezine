<?php

namespace App\Controller;

use App\Entity\Fanzine;
use App\Entity\Page;
use App\Form\FanzineType;
use App\Repository\FanzineRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/view/{id}", name="show_zine")
     */
    public function show($id): Response
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

    /**
     * @Route("/new", name="create_zine")
     */
    public function create(Request $request): Response
    {
        $fanzines = $this->getUser()->getFanzines();
        
        $fanzine = new Fanzine();
        $form = $this->createForm(FanzineType::class, $fanzine);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $fanzine = $form->getData();
            $fanzine->setCreatedAt(new DateTimeImmutable());
            $fanzine->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fanzine);

            for ($p=1; $p<=8; $p++){
                $page = new Page();
                $page->setFanzine($fanzine);
                $page->setPosition($p);
                $entityManager->persist($page);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('app/index.html.twig',[
            "formCreateZine" => $form->createView(),
            "fanzines" => $fanzines
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_zine")
     */
    public function delete($id, FanzineRepository $zineRepo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $fanzine = $zineRepo->find($id);
        $entityManager->remove($fanzine);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_index');
    }
}
