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

class VocableController extends AbstractController
{
    #[Route('/my/vocable/add', name: 'add_vocable')]
    public function addWord(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
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