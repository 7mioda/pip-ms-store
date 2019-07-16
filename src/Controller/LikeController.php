<?php

namespace App\Controller;

use App\Entity\Like;
use App\Form\LikeType;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/like")
 */
class LikeController extends AbstractController
{
    /**
     * @Route("/", name="like_index", methods={"GET"})
     */
    public function index(LikeRepository $likeRepository): Response
    {
        return $this->render('like/index.html.twig', [
            'likes' => $likeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="like_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $like = new Like();
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($like);
            $entityManager->flush();

            return $this->redirectToRoute('like_index');
        }

        return $this->render('like/new.html.twig', [
            'like' => $like,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="like_show", methods={"GET"})
     */
    public function show(Like $like): Response
    {
        return $this->render('like/show.html.twig', [
            'like' => $like,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="like_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Like $like): Response
    {
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('like_index', [
                'id' => $like->getId(),
            ]);
        }

        return $this->render('like/edit.html.twig', [
            'like' => $like,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="like_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Like $like): Response
    {
        if ($this->isCsrfTokenValid('delete'.$like->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($like);
            $entityManager->flush();
        }

        return $this->redirectToRoute('like_index');
    }
}
