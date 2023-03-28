<?php

namespace App\Controller\Front;

use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/guide', name: 'guide_')]
class GuideController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('guide/index.html.twig', [
            'controller_name' => 'GuideController',
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(ContentRepository $contentRepository): Response
    {
        $query = $contentRepository->createQueryBuilder('c')
            ->leftJoin('c.tags', 't')
            ->leftJoin('t.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $this->getUser()->getId())
            ->getQuery();

        $contents = $query->getResult();

        return $this->render('guide/list.html.twig', [
            'controller_name' => 'GuideController',
            'contents' => $contents,
        ]);
    }
}
