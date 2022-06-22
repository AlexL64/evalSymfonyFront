<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClubsController extends AbstractController
{

    public function clubs(CallApiService $callApiService): Response
        {
        return $this->render('clubs/clubs.html.twig', [
            'clubs' => $callApiService->getClubs()
        ]);
    }

    public function clubsById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/clubsById'])
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->render('clubs/clubsById.html.twig', [
                'clubs' => $callApiService->getClubsId($form['id']->getData())
            ]);
        }

        return $this->render('clubs/clubsForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function postClub(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/postClub'])
            ->add('nom', TextType::class)
            ->add('email', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $callApiService->postClub($form->getData());
            return $this->redirectToRoute('home');

        }

        return $this->render('clubs/clubsForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function delClubById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/delClubById'])
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $callApiService->delClub($form['id']->getData());
            return $this->redirectToRoute('home');

        }

        return $this->render('clubs/clubsForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function patchClubById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/patchClubById'])
            ->add('nom', TextType::class)
            ->add('email', TextType::class)
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
           

            $callApiService->patchClub($data, $data['id']);
            return $this->redirectToRoute('home');

        }

        return $this->render('clubs/clubsForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
