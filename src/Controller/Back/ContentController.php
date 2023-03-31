<?php

namespace App\Controller\Back;

use App\Entity\Content;
use App\Entity\ContentText;
use App\Entity\Media;
use App\Form\ContentFormType;
use App\Repository\ContentRepository;
use App\Repository\ContentTypeRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/content', name: 'content_')]
class ContentController extends AbstractController
{
    private EntityManagerInterface $em;
    private MediaRepository $mediaRepository;
    private ContentTypeRepository $contentTypeRepository;
    private ContentRepository $contentRepository;

    public function __construct(
        EntityManagerInterface $em,
        MediaRepository $mediaRepository,
        ContentTypeRepository $contentTypeRepository,
        ContentRepository $contentRepository
    )
    {
        $this->em = $em;
        $this->mediaRepository = $mediaRepository;
        $this->contentTypeRepository = $contentTypeRepository;
        $this->contentRepository = $contentRepository;
    }

    #[Route('/create', name: 'create')]
    public function createContent(Request $request): Response
    {
        $content = new Content();
        $form = $this->createForm(ContentFormType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $request->isMethod('post')){
            $file = $form->get('file_header')->getData();
            $filename =  '/uploads/media/' . substr(md5(uniqid()), 0, 8).'.'.$file->guessExtension();
            $file->move(
                'uploads/media/',
                $filename
            );

            $contentType =  $this->contentTypeRepository->find(1);
            $dscp = $content->getDescription();
            $content->setDescription(substr($dscp, 0, 50));
            $content->setContentType($contentType);
            $content->addTag($form->get('selectTag')->getData());
            $this->em->persist($content);
            $contentText = (new ContentText())
                ->setContent($content)
                ->setText($dscp);
            $this->em->persist($contentText);

            $media = (new Media())
                ->setContent($content)
                //->setSlug(strtolower(basename($file, $file->guessExtension())))
                ->setType('img')
                ->setFilename($filename);
            $this->em->persist($media);
            $this->em->flush();

            return $this->redirectToRoute("back_content_create");
        }
        return $this->render('back/default/create.html.twig', [
            'form' => $form->createView(),
            'formData' => $content
        ]);
    }

    #[Route('/list', name: 'list')]
    public function listContents(ContentRepository $contentRepository): Response
    {
        $contents = $contentRepository->findAll();

        return $this->render('back/default/list.html.twig', [
            'controller_name' => 'GuideController',
            'contents' => $contents,
        ]);
    }
    #[Route('/show/{slug}', name: 'show')]
    public function showContent(Content $content, Request $request): Response
    {
        //$content = $this->contentRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(ContentFormType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $request->isMethod('post')){
            $file = $form->get('file_header')->getData();
            $filename =  '/uploads/media/' . substr(md5(uniqid()), 0, 8).'.'.$file->guessExtension();
            $file->move(
                'uploads/media/',
                $filename
            );

            $contentType =  $this->contentTypeRepository->find(1);
            $dscp = $content->getDescription();
            $content->setDescription(substr($dscp, 0, 50));
            $content->setContentType($contentType);
            $content->addTag($form->get('selectTag')->getData());
            $this->em->persist($content);
            $contentText = (new ContentText())
                ->setContent($content)
                ->setText($dscp);
            $this->em->persist($contentText);

            $media = (new Media())
                ->setContent($content)
                //->setSlug(strtolower(basename($file, $file->guessExtension())))
                ->setType('img')
                ->setFilename($filename);
            $this->em->persist($media);
            $this->em->flush();

            return $this->redirectToRoute("back_default_show");
        }

        return $this->render('back/default/show.html.twig', [
            'controller_name' => 'GuideController',
            'content' => $content,
            'form' => $form->createView(),
            'formData' => $content,
        ]);
    }
}