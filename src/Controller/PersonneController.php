<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Form\ChampSearchType;
use App\Entity\PersonSearch;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne_index", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = new PersonSearch();
        $pers = $personneRepository->findAll();
        $form = $this->createForm(ChampSearchType::class,$search); 
        $form->handleRequest($request);
         $paginates = $paginator->paginate(
            $pers, // Requête contenant les données à paginer (ici nos personnes)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
       
                if ($form->isSubmitted() && $form->isValid()) {
                   
                    foreach($pers as $value)
                     {
                        $pers2 = $personneRepository->findBy([
                            'nom'=> $value->getNom(),
                            'prenom'=> $value->getPrenom()]);
                        $paginates2 = $paginator->paginate(
                            $pers2, // Requête contenant les données à paginer (ici nos personnes)
                            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                            6 // Nombre de résultats par page
                        );
                         //dump($value->getPrenom());die();
                        if ($search->getNom() == $value->getNom() && $search->getPrenom() == $value->getPrenom()) {
                            return $this->render('personne/index.html.twig', [
                            'personnes' => $paginates2,
                            'form' => $form->createView()
                            ]);

                     }    
                 }if ($search->getNom() != $value->getNom() && $search->getPrenom() != $value->getPrenom()) {
                     return new response('Erreur !!!');
                 }
                 
                           
        } 
       
        return $this->render('personne/index.html.twig', 
        [ 
            'personnes' => $paginates,
            'form' => $form->createView(),
            'paginate'=>$paginates
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
    
}
