<?php

namespace App\Controller;

use App\Entity\Vocable;
use App\Form\VocableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Security $security): Response
    {
        if ($security->getUser()) {
            return $this->forward('App\\Controller\\IndexController::loggedIndex');
        }
        return $this->render('index/index.html.twig');
    }

    #[Route('/i', name: 'lindex')]
    public function loggedIndex(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $vocable = new Vocable();
        $vocableForm = $this->createForm(VocableType::class, $vocable);
        $vocableForm->handleRequest($request);
        if ($vocableForm->isSubmitted() && $vocableForm->isValid()) {
            $vocable->setUser($security->getUser());
            $entityManager->persist($vocable);
            $entityManager->flush();
        }

        return $this->render('index/vocable.html.twig', ['form' => $vocableForm->createView()]);
    }
}
