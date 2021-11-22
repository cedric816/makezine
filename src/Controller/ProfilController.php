<?php

namespace App\Controller;

use App\Form\EditPasswordType;
use App\Form\PasswordType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="profil_index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Vos informations de profil ont bien été modifiés');
            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/password", name="profil_password")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(EditPasswordType::class)->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $user = $this->getUser();
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get("plainPassword")->getData()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Votre mot de passe a été modifié avec succès.");
        }

        return $this->render('profil/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
