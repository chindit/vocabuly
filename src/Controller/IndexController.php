<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\VocableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Security $security): Response
    {
        if ($security->getUser()) {
            return $this->forward('App\\Controller\\IndexController::dashboard');
        }

        return $this->render('index/index.html.twig');
    }

    #[Route('/my/dashboard', name: 'dashboard')]
    public function dashboard(#[CurrentUser] User $user, VocableRepository $vocableRepository): Response
    {
        if ($user->getLearningLanguages()->isEmpty()) {
            return $this->forward('App\\Controller\\LearningController::createLearning');
        }

        return $this->render('index/dashboard.html.twig', [
            'sessions' => $user->getLearningLanguages(),
            'stats' => $vocableRepository->getStatistics($user, $user->getLearningLanguages()->first()),
        ]);
    }
}
