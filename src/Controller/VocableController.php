<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vocable;
use App\Form\VocableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class VocableController extends AbstractController
{
    #[Route('/my/vocable/add', name: 'add_vocable')]
    public function addWord(#[CurrentUser]User $user, Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $vocable = new Vocable();
        $vocableForm = $this->createForm(VocableType::class, $vocable);
        $vocableForm->handleRequest($request);
        if ($vocableForm->isSubmitted() && $vocableForm->isValid()) {
            $vocable->setUser($user);
			$vocable->setSession($user->getLearningLanguages()->first());
            $entityManager->persist($vocable);
            $entityManager->flush();
        }

        return $this->render('index/vocable.html.twig', ['form' => $vocableForm->createView()]);
    }
}
