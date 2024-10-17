<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AdController extends AbstractController
{
    #[Route('/ad/{id}/edit', name: 'ad_edit', methods: ['GET', 'POST'])]
    public function editAd(Ad $ad, #[CurrentUser] User $user): Response
    {
        if ($user !== $ad->getOwner())
        {
            throw $this->createAccessDeniedException('Vi niste vlasnik oglasa');
        }

        return $this->render('ad/edit.html.twig', [
            'ad' => $ad,
        ]);
    }
}