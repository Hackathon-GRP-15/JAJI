<?php

namespace App\Controller\Back;

use App\Repository\TagRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tag', name: 'tag_')]
class TagController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/render', name: 'render', options: ['expose' => true])]
    public function getAllTags(Request $request, TagRepository $tagRepository) :JsonResponse
    {
        $tags = $tagRepository->findAll();
        foreach ($tags as $tag){
            $json['tagId'] = $tag->getId();
            $json['tagName'] = $tag->getName();
        }
        return new JsonResponse($json);
    }

}