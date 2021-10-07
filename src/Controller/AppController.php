<?php

namespace App\Controller;

use App\Entity\Fanzine;
use App\Entity\Module;
use App\Entity\Page;
use App\Form\FanzineType;
use App\Form\ModuleType;
use App\Repository\FanzineRepository;
use App\Repository\ModuleRepository;
use App\Repository\PageRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
        return $this->render('app/index.html.twig', [
            "fanzines" => $fanzines
        ]);
    }

    /**
     * @Route("/view/{id}", name="show_zine")
     */
    public function show($id): Response
    {
        $selectedZine = $this->zineRepo->find($id);
        $pages = $selectedZine->getPages();
        return $this->render('app/edit.html.twig', [
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

            for ($p = 1; $p <= 8; $p++) {
                $page = new Page();
                $page->setFanzine($fanzine);
                $page->setPosition($p);
                $entityManager->persist($page);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('app/index.html.twig', [
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

    /**
     * @Route("/update/{id}", name="update_zine")
     */
    public function update($id, FanzineRepository $zineRepo, Request $request): Response
    {
        $selectedZine = $this->zineRepo->find($id);
        $pages = $selectedZine->getPages();
        $fanzine = $zineRepo->find($id);
        $form = $this->createForm(FanzineType::class, $fanzine);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fanzine = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('show_zine', ["id" => $id]);
        }

        return $this->render('app/edit.html.twig', [
            "formUpdateZine" => $form->createView(),
            "selectedZine" => $selectedZine,
            "pages" => $pages
        ]);
    }

    /**
     * @Route("/page/{id}", name="page_view")
     */
    public function pageView($id, PageRepository $pageRepo): Response
    {

        $selectedPage = $pageRepo->find($id);
        $modules = $selectedPage->getModules();
        $selectedZine = $selectedPage->getFanzine();
        $pages = $selectedZine->getPages();

        return $this->render('app/edit-page.html.twig', [
            "selectedPage" => $selectedPage,
            "selectedZine" => $selectedZine,
            "pages" => $pages,
            "modules" => $modules
        ]);
    }

    /**
     * @Route("/module/edit/{id}", name="edit_module")
     */
    public function editModule($id, ModuleRepository $moduleRepo, Request $request, PageRepository $pageRepo): Response
    {
        $module = $moduleRepo->find($id);
        $formModule = $this->createForm(ModuleType::class, $module);
        $formModule->handleRequest($request);

        $idPage = $module->getPage()->getId();

        if ($formModule->isSubmitted() && $formModule->isValid()) {

            $file = $formModule->get('url')->getData();
            if ($file) {
                //unique image name
                $timestamp = time();
                $userId = $this->getUser()->getId();
                $imageName = $timestamp . $userId . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $imageName
                    );
                } catch (FileException $e) {
                    dd($e->getMessage());
                }
                $module->setUrl($imageName);
            }

            $module = $formModule->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('page_view', ["id" => $idPage]);
        }

        $selectedPage = $pageRepo->find($idPage);
        $modules = $selectedPage->getModules();
        $selectedZine = $selectedPage->getFanzine();

        return $this->render('app/edit-page.html.twig', [
            "selectedPage" => $selectedPage,
            "selectedZine" => $selectedZine,
            "modules" => $modules,
            "formModule" => $formModule->createView()
        ]);
    }

    /**
     * @Route("/module/create/{idPage}", name="create_module")
     */
    public function createModule($idPage, PageRepository $pageRepo, Request $request): Response
    {
        $module = new Module();
        $formModuleCreate = $this->createForm(ModuleType::class, $module);
        $formModuleCreate->handleRequest($request);

        $selectedPage = $pageRepo->find($idPage);
        $modules = $selectedPage->getModules();
        $selectedZine = $selectedPage->getFanzine();

        if ($formModuleCreate->isSubmitted() && $formModuleCreate->isValid()) {

            $file = $formModuleCreate->get('url')->getData();
            if ($file) {
                //unique image name
                $timestamp = time();
                $userId = $this->getUser()->getId();
                $imageName = $timestamp . $userId . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $imageName
                    );
                } catch (FileException $e) {
                    dd($e->getMessage());
                }
                $module->setUrl($imageName);
            }

            $module = $formModuleCreate->getData();
            $module->setPage($selectedPage);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();
            return $this->redirectToRoute('page_view', ["id" => $idPage]);
        }

        return $this->render('app/edit-page.html.twig', [
            "selectedPage" => $selectedPage,
            "selectedZine" => $selectedZine,
            "modules" => $modules,
            "formModuleCreate" => $formModuleCreate->createView()
        ]);
    }

    /**
     * @Route("/module/delete/{id}", name="delete_module")
     */
    public function deleteModule($id, ModuleRepository $moduleRepo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $module = $moduleRepo->find($id);
        $selectedPage = $module->getPage();
        $selectedZine = $selectedPage->getFanzine();
        $pages = $selectedZine->getPages();
        $modules = $selectedPage->getModules();
        $entityManager->remove($module);
        $entityManager->flush();

        return $this->render('app/edit-page.html.twig', [
            "selectedPage" => $selectedPage,
            "selectedZine" => $selectedZine,
            "pages" => $pages,
            "modules" => $modules
        ]);
    }

    /**
     * @Route("/print/{id}", name="print_zine")
     */
    public function editPdf($id, FanzineRepository $zineRepo)
    {
        $fanzine = $zineRepo->find($id);
        
        return $this->render("app/print-zine.html.twig", [
            "fanzine" => $fanzine
        ]);
    }
}
