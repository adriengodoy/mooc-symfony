<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        // on ne sait pas combien de pages il y a
        // mais on sait qu'une page doit être supérieure ou égale à 1
        if ($page < 1) {
            // on déclenche une exception NotFoundHttpException, 
            // cela va afficher une page d'erreur 404 (qu'on pourra personnaliser plus tard)
            throw new NotFoundException('Page "'.$page.'" inexistante. :(');
        }
        
        // ici on récupérera la liste des annonces, puis on la passera au template
        
        // Notre liste d'annonce en dur
        $listAdverts = array(
          array(
            'title'   => 'Recherche développpeur Symfony',
            'id'      => 1,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()),
          array(
            'title'   => 'Mission de webmaster',
            'id'      => 2,
            'author'  => 'Hugo',
            'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
            'date'    => new \Datetime()),
          array(
            'title'   => 'Offre de stage webdesigner',
            'id'      => 3,
            'author'  => 'Mathieu',
            'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
            'date'    => new \Datetime())
        );
        
        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }
    
    // manip de la session
    public function viewAction($id)
    {
        // ici, on va récupérer l'annonce correspondant à l'id $id
        
        // mais en attendant, on va mettre des trucs en dur
        $advert = array(
          'title'   => 'Recherche développpeur Symfony',
          'id'      => $id,
          'author'  => 'Alexandre',
          'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
          'date'    => new \Datetime()
        );
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert
        ));
       /*return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
           'id' => $id
       ));*/
    }
    
    public function viewSlugAction($slug, $year, $format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au slug '".$slug."', créée en ".$year." et au format ".$format."."
        );
    }
    
    public function addAction(Request $request)
    {
        // la gestion d'un formulaire est particulière, mais l'idée est la suivante :
        
        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST')) {
            // ici, on s'occupera de la création et de la gestion du formulaire
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            
            // puis on redirige vers la page de visualisation de cette annonce
            return $this->redirectToRoute('oc_platform_view', array('id' => 5));
        }
        
        // s ion est pas en POST, alors on affiche le formulaire
        return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }
    
    public function editAction($id, Request $request)
    {
        // ici, on récupérera l'annonce correspondant à $id
        
        // même mécanisme que pour l'ajout
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            
            return $this->redirectToRoute('oc_platform_view', array('id' => 5));
        }
        
        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }
    
    public function deleteAction($id)
    {
        // ici, on récupérera l'annonce correspondant à l'$id
        
        // ici, on générera la suppression de l'annonce en question
        
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }
    
    public function menuAction($limit)
    {
        // on fixe en dur une liste, mais par la suite, elle sera récupérée depuis la BDD
        $listAdverts = array(
            array('id' => 2, 'title' => 'recherche développeur Symfony'),
            array('id' => 5, 'title' => 'mission de webmaster'),
            array('id' => 9, 'title' => 'offre de stage webdesigner')
        );
        
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            // tout l'intérêt est ici : le controller passe
            // les variables nécessaires au template !!!
            'listAdverts' => $listAdverts
        ));
    }
}