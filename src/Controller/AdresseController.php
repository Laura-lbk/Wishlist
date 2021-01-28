<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adresse")
 */
class AdresseController extends AbstractController
{
    /**
     * @Route("/", name="adresse_index", methods={"GET"})
     */
    public function index(AdresseRepository $adresseRepository): Response
    {
        return $this->render('adresse/index.html.twig', [
            'adresses' => $adresseRepository->findAll(),
            'citys' => $adresseRepository->findAllCity()
        ]);
    }

    /**
     * @Route("/new", name="adresse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adresse);
            $entityManager->flush();

            return $this->redirectToRoute('adresse_index');
        }

        return $this->render('adresse/new.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adresse_show", methods={"GET"})
     */
    public function show(Adresse $adresse): Response
    {
        return $this->render('adresse/show.html.twig', [
            'adresse' => $adresse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adresse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Adresse $adresse): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adresse_index');
        }

        return $this->render('adresse/edit.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adresse_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Adresse $adresse): Response
    {

        if(!$adresse->personne->isEmpty()){
            throw new Exception('Vous n\'avez pas le droit de faire ceci ! (Suppression non autorisé car adresse habité)');
        }


        if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adresse);
            $entityManager->flush();
            
        }

        return $this->redirectToRoute('adresse_index');
    }

     /**
     * @Route("/{city}/city", name="adresse_city", methods={"GET"})
     */
    public function city(AdresseRepository $adresseRepository, String $city): Response
    {
        return $this->render('adresse/index.html.twig', [
            'adresses' => $adresseRepository->findByCity($city),
            'citys' => $adresseRepository->findAllCity(),
        ]);
    }

}