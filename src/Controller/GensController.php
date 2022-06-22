<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GensController extends AbstractController
{

    public function gens(CallApiService $callApiService): Response
        {
        return $this->render('gens/gens.html.twig', [
            'gens' => $callApiService->getGens()
        ]);
    }

    public function gensById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/gensById'])
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->render('gens/gensById.html.twig', [
                'gens' => $callApiService->getGensId($form['id']->getData())
            ]);
        }

        return $this->render('gens/gensForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function postGens(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/postGens'])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('clubId', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /*$data = $form->getData();
            $data['clubId'] = "/api/v1/clubs/".$data['clubId'];*/

            $callApiService->postGens($form->getData());
            return $this->redirectToRoute('home');

        }

        return $this->render('gens/gensForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function delGensById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/delGensById'])
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $callApiService->delGens($form['id']->getData());
            return $this->redirectToRoute('home');

        }

        return $this->render('gens/gensForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function patchGensById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/patchGensById'])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('id', TextType::class)
            ->add('clubId', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $callApiService->patchGens($data, $data['id']);
            return $this->redirectToRoute('home');

        }

        return $this->render('gens/gensForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
