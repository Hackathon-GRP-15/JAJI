<?php

namespace App\Controller\Front;

use App\Entity\Tag;
use App\Entity\Content;
use App\Form\FormGuide1Type;
use App\Form\FormGuide2Type;
use App\Form\FormGuide3Type;
use App\Form\FormGuide4Type;
use App\Form\FormGuide5Type;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/guide', name: 'guide_')]
class GuideController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('front/guide/index.html.twig', [
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

        return $this->render('front/guide/list.html.twig', [
            'controller_name' => 'GuideController',
            'contents' => $contents,
        ]);
    }

    #[Route('/form', name: 'form_step1')]
    public function form(Request $request, UserRepository $userRepository, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(FormGuide1Type::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('job')->getData();

            $existingTag = $tagRepository->findOneBy(['name' => $data]);

            if (!$existingTag) {
                $tag = (new Tag())->setName($data);
                $tagRepository->save($tag, true);
                $this->getUser()->addTag($tag);
            } else {
                $this->getUser()->addTag($existingTag);
            }

            $userRepository->save($this->getUser(), true);

            if ($request->request->has('next') && $request->request->get('next') === 'step2') {
                $form = $this->createForm(FormGuide2Type::class);
            }
        }

        $nextUrl = null;

        if ($form->getConfig()->getType()->getInnerType() instanceof FormGuide2Type) {
            return $this->redirectToRoute('front_guide_form_step2');
        }

        return $this->render('front/guide/form1.html.twig', [
            'form' => $form->createView(),
            'next_url' => $nextUrl,
        ]);
    }

    #[Route('/form2', name: 'form_step2')]
    public function form2(Request $request, UserRepository $userRepository, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(FormGuide2Type::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('screenTime')->getData();

            if ($data < 2) {
                $data = 'low screen time';
            } elseif ($data >= 2 && $data < 4) {
                $data = 'medium screen time';
            } else {
                $data = 'high screen time';
            }

            $existingTag = $tagRepository->findOneBy(['name' => $data]);

            if (!$existingTag) {
                $tag = (new Tag())->setName($data);
                $tagRepository->save($tag, true);
                $this->getUser()->addTag($tag);
            } else {
                $this->getUser()->addTag($existingTag);
            }

            $userRepository->save($this->getUser(), true);

            if ($request->request->has('next') && $request->request->get('next') === 'step3') {
                $form = $this->createForm(FormGuide3Type::class);
            }
        }

        $nextUrl = null;

        if ($form->getConfig()->getType()->getInnerType() instanceof FormGuide3Type) {
            return $this->redirectToRoute('front_guide_form_step3');
        }

        return $this->render('front/guide/form2.html.twig', [
            'form' => $form->createView(),
            'next_url' => $nextUrl,
        ]);
    }

    #[Route('/form3', name: 'form_step3')]
    public function form3(Request $request, UserRepository $userRepository, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(FormGuide3Type::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('sport')->getData();

            foreach ($data as $tag) {
                $existingTag = $tagRepository->findOneBy(['name' => $tag]);

                if (!$existingTag) {
                    $tag = (new Tag())->setName($tag);
                    $tagRepository->save($tag, true);
                    $this->getUser()->addTag($tag);
                } else {
                    $this->getUser()->addTag($existingTag);
                }
            }

            $userRepository->save($this->getUser(), true);

            if ($request->request->has('next') && $request->request->get('next') === 'step4') {
                $form = $this->createForm(FormGuide4Type::class);
            }
        }

        $nextUrl = null;

        if ($form->getConfig()->getType()->getInnerType() instanceof FormGuide4Type) {
            return $this->redirectToRoute('front_guide_form_step4');
        }

        return $this->render('front/guide/form3.html.twig', [
            'form' => $form->createView(),
            'next_url' => $nextUrl,
        ]);
    }

    #[Route('/form4', name: 'form_step4')]
    public function form4(Request $request, UserRepository $userRepository, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(FormGuide4Type::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('concentration')->getData();

            if ($data == 'yes') {
                $data = 'good concentration';
            } else {
                $data = 'bad concentration';
            }

            $existingTag = $tagRepository->findOneBy(['name' => $data]);

            if (!$existingTag) {
                $tag = (new Tag())->setName($data);
                $tagRepository->save($tag, true);
                $this->getUser()->addTag($tag);
            } else {
                $this->getUser()->addTag($existingTag);
            }

            $userRepository->save($this->getUser(), true);

            if ($request->request->has('next') && $request->request->get('next') === 'step5') {
                $form = $this->createForm(FormGuide5Type::class);
            }
        }

        $nextUrl = null;

        if ($form->getConfig()->getType()->getInnerType() instanceof FormGuide5Type) {
            return $this->redirectToRoute('front_guide_form_step5');
        }

        return $this->render('front/guide/form4.html.twig', [
            'form' => $form->createView(),
            'next_url' => $nextUrl,
        ]);
    }

    #[Route('/form5', name: 'form_step5')]
    public function form5(Request $request, UserRepository $userRepository, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(FormGuide5Type::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isDiet = $form->get('isDiet')->getData();
            $data = $form->get('diet')->getData();

            if ($isDiet == 'yes') {
                foreach ($data as $tag) {
                    $existingTag = $tagRepository->findOneBy(['name' => $tag]);
    
                    if (!$existingTag) {
                        $tag = (new Tag())->setName($tag);
                        $tagRepository->save($tag, true);
                        $this->getUser()->addTag($tag);
                    } else {
                        $this->getUser()->addTag($existingTag);
                    }
                }
                $existingTag = $tagRepository->findOneBy(['name' => 'diet']);

                if (!$existingTag) {
                    $tag = (new Tag())->setName('diet');
                    $tagRepository->save($tag, true);
                    $this->getUser()->addTag($tag);
                } else {
                    $this->getUser()->addTag($existingTag);
                }
            }

            $userRepository->save($this->getUser(), true);

            if ($request->request->has('next') && $request->request->get('next') === 'end') {
                return $this->redirectToRoute('front_guide_list');
            }
        }

        $nextUrl = null;

        return $this->render('front/guide/form5.html.twig', [
            'form' => $form->createView(),
            'next_url' => $nextUrl,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Content $content): Response
    {
        return $this->render('front/guide/show.html.twig', [
            'controller_name' => 'GuideController',
            'content' => $content,
        ]);
    }

}
