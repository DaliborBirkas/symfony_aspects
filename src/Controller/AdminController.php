<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin', methods: [Request::METHOD_GET])]
    public function admin(): Response
    {
        $this->isGranted("ROLE_AA");
        //$this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render('pages/admin/admin.html.twig', [
        ]);
    }


}