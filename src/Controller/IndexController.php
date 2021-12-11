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
            return $this->forward('App\\Controller\\IndexController::dashboard');
        }
        return $this->render('index/index.html.twig');
    }

    #[Route('/my/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('index/dashboard.html.twig');
    }
}
