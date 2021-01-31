<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Cadeau;
use App\Form\PersonneType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\PersonneRepository;
use App\Repository\AdresseRepository;
use App\Repository\CadeauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne_index", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository, AdresseRepository $adresseRepository): Response
    {
        return $this->render('personne/index.html.twig', [
            'personnes' => $personneRepository->findAll(),
            'rues'=>$adresseRepository->findAllRue(),
        ]);
    }

    /**
     * @Route("/new", name="personne_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('personne_index');
        }

        return $this->render('personne/new.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personne_show", methods={"GET"})
     */
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personne $personne): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->add('nom', null, array('disabled' => true));
        $form->add('prenom', null, array('disabled' => true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personne_index');
        }

        return $this->render('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personne_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Personne $personne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personne_index');
    }

    /**
     * @Route("/{rue}/rue", name="personne_rue", methods={"GET"})
     */
    public function rue(PersonneRepository $personneRepository, AdresseRepository $adresseRepository, String $rue): Response
    {
        return $this->render('personne/index.html.twig', [
            'personnes' => $personneRepository->findByRue($rue),
            'rues'=>$adresseRepository->findAllRue(),
        ]);
    }

    /**
     * @Route("/list/{id}", name="personne_list", methods={"GET","POST"})
     */
    public function listeCadeau(Request $request, Personne $personne, CadeauRepository $cadeauRepository): Response
    {
        $listcadeau= $personne->getCadeaux();

        $form = $this->createFormBuilder($personne)
                ->add('cadeaux',  EntityType::class, [
                    // looks for choices from this entity
                    'class' => Cadeau::class,
                
                    // uses the User.username property as the visible option string
                    'choice_label' => 'nom',
                    'choices' => $cadeauRepository->findFreeCadeaux($personne->getId()),
                
                    // used to render a select box, check boxes or radios
                    'multiple' => true,
                    'expanded' => true,
                ])
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($personne->getCadeaux() as $cadeau )
            {
                $personne->addCadeaux($cadeau);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute('personne_index');
        }
        

        return $this->render('personne/list.html.twig', [
            'personne' => $personne,
            'listcadeau' => $listcadeau,
            'form' => $form->createView(),
        ]);
    }
}
