<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CallApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DettesController extends AbstractController
{

    public function dettes(CallApiService $callApiService): Response
        {
        return $this->render('dettes/dettes.html.twig', [
            'dettes' => $callApiService->getDettes()
        ]);
    }

    public function dettesById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/dettesById'])
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->render('dettes/dettesById.html.twig', [
                'dettes' => $callApiService->getDettesId($form['id']->getData())
            ]);
        }

        return $this->render('dettes/dettesForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function postDettes(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/postDettes'])
            ->add('montant', IntegerType::class)
            ->add('gensId', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $callApiService->postDette($form->getData());
            return $this->redirectToRoute('home');

        }

        return $this->render('dettes/dettesForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function delDettesById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/delDettesById'])
            ->add('id', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $callApiService->delDette($form['id']->getData());
            return $this->redirectToRoute('home');

        }

        return $this->render('dettes/dettesForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function patchDettesById(Request $request,CallApiService $callApiService)
    {

        $form = $this->createFormBuilder(null, ['action' => '/patchDettesById'])
            ->add('montant', IntegerType::class)
            ->add('id', TextType::class)
            ->add('gensId', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $callApiService->patchDette($data, $data['id']);
            return $this->redirectToRoute('home');

        }

        return $this->render('dettes/dettesForm.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
