<?php

namespace App\Controller;

use App\Entity\Usercateg;
use App\Form\UsercategType;
use App\Repository\UsercategRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usercateg")
 */
class UsercategController extends AbstractController
{
    /**
     * @Route("/", name="usercateg_index", methods={"GET"})
     */
    public function index(UsercategRepository $usercategRepository): Response
    {
        return $this->render('usercateg/index.html.twig', [
            'usercategs' => $usercategRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="usercateg_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usercateg = new Usercateg();
        $form = $this->createForm(UsercategType::class, $usercateg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($usercateg);
            $entityManager->flush();

            return $this->redirectToRoute('usercateg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usercateg/new.html.twig', [
            'usercateg' => $usercateg,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="usercateg_show", methods={"GET"})
     */
    public function show(Usercateg $usercateg): Response
    {
        return $this->render('usercateg/show.html.twig', [
            'usercateg' => $usercateg,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usercateg_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Usercateg $usercateg, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsercategType::class, $usercateg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('usercateg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usercateg/edit.html.twig', [
            'usercateg' => $usercateg,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="usercateg_delete", methods={"POST"})
     */
    public function delete(Request $request, Usercateg $usercateg, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usercateg->getId(), $request->request->get('_token'))) {
            $entityManager->remove($usercateg);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usercateg_index', [], Response::HTTP_SEE_OTHER);
    }
}
