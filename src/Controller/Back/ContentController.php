<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/content', name: 'content_')]
class ContentController extends AbstractController
{

    #[Route('/create', name: 'create')]
    public function createContent(): Response
    {
        dd('OK');
    }
}