<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\ItemCategory;
use AppBundle\Entity\Vote;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function getMenuAction($route)
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
       return $this->render('menu.html.twig', ['posts' => $posts, 'route' => $route]);
    }

    /**
     * @Route("/{id}", name="homepage", defaults={"id"=-1}, requirements={"id"="\d*"})
     */
    public function indexAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();

      if ( $id != -1 ){
        $item = $em->getRepository('AppBundle:Item')->find($id);
        if($item){

          $vote = new Vote();

          $vote->setItem($item);
          if( $this->getUser()){
            $vote->setUser($this->getUser());
          }

              // récupération du manager entité
          $em = $this->getDoctrine()->getManager();

          //nécessaire qu'une valeur change pour déclencer preUpdate
          $item->setLastVote();
          $em->persist($vote);
          $em->persist($item);
          // sauvegarde
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', 'Vote pour "'.$item->getTitre().'" enregistré!');
        }
      }

      //les 10 derniers votes
      $votes = $em->getRepository('AppBundle:Vote')->findBy(
        array(),        //critère
        array('id' => 'desc'),        //tri
        10,             //limit
        0               //offset
      );

      $votesPerso=[];
      //les 5 derniers votes de l'utilisateur
      if( $this->getUser()){
        $votesPerso = $em->getRepository('AppBundle:Vote')->findBy(
          array('user' => $this->getUser()),  //critère
          array('id' => 'desc'),              //tri
          5,                                 //limit
          0                                   //offset
        );
      }

      $items = $em->getRepository('AppBundle:Item')->findAll();



      if(isset($items[1])){
        $item1 = $items[rand(0, count($items)-1)];
        $item2 = $items[rand(0, count($items)-1)];
        $insuffisant=0;
      }
      else{
        $item1 = null;
        $item2 = null;
        $insuffisant = 1;
      }

      return $this->render('default/index.html.twig', [
        'item1' => $item1,
        'item2' => $item2,
        'insuffisant' => $insuffisant,
        'votes' => $votes,
        'votesPerso' => $votesPerso,
        'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
      ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function presentationAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/presentation.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
      * @Route("/recherche", name="recherchehp", defaults={"word" = false})
      * @Route("/recherche/{word}", name="recherche")
     */
    public function rechercheAction(Request $request, $word)
    {
      $news = [];

      if($word){
          $news = $this->getDoctrine()->getRepository('AppBundle:Post')->search( $word );
      }
      else{
          $news = $this->getDoctrine()->getRepository('AppBundle:Post')->search( "" );
      }
      $searchForm = $this->createFormBuilder()
          ->add('word', TextType::class, ['label' => 'Recherche', 'required'=>false])
          ->add('submit', SubmitType::class, ['label' => 'Envoyer'])
      ->getForm();


      $searchForm->handleRequest($request);
      if($searchForm->isSubmitted() && $searchForm->isValid()){
          $data = $searchForm->getData();
          $news = $this->getDoctrine()->getRepository('AppBundle:Post')->search( $data['word'] );
      }

      // replace this example code with whatever you need
      return $this->render('default/search.html.twig', [
          'news' => $news,
          'form' => $searchForm->createView(),
          'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
      ]);

    }

    /**
     * @Route("/news", name="news")
     */
    public function newsAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      //les 10 derniers articles
      $posts = $em->getRepository('AppBundle:Post')->findBy(
        array(),        //critère
        array('id' => 'desc'),        //tri
        5,             //limit
        0               //offset
      );
      // replace this example code with whatever you need
      return $this->render('default/news.html.twig', [
        'posts' => $posts,
        'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
      ]);
    }

    /**
     * @Route("/news/{slug}", name="news_show")
     */
    public function newsShowAction(Request $request, $slug)
    {
      $em = $this->getDoctrine()->getManager();

      //les 10 derniers articles
      $post = $em->getRepository('AppBundle:Post')->findOneBy(['slug' => $slug]);

      if ($post){
        // replace this example code with whatever you need
        return $this->render('default/news.show.html.twig', [
          'post' => $post,
          'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
      }

    }

    /**
     * @Route("/tops", name="tops")
     */
    public function topsAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();
      $categories = $em->getRepository('AppBundle:ItemCategory')->itemCategoriesPlusItemAll();
      // $categories = $em->getRepository('AppBundle:Category')->findBy(
      //   array(),        //critère
      //   array('titre' => 'desc'),        //tri
      //   10,             //limit
      //   0               //offset
      // );

      // replace this example code with whatever you need
      return $this->render('default/tops.html.twig', [
          'itemCategories' => $categories,
          'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
      ]);
    }

    /**
     * @Route("/categorie/{slug}/{id}", name="categorie", defaults={"id"=-1}, requirements={"id"="\d*"})
     */
    public function categorieAction(Request $request, $slug, $id)
    {

      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository('AppBundle:ItemCategory')->itemCategoriesPlusItem($slug);

      if ( $id != -1 ){
        $item = $em->getRepository('AppBundle:Item')->find($id);
        if($item){

          $vote = new Vote();

          $vote->setItem($item);
          if( $this->getUser()){
            $vote->setUser($this->getUser());
          }

              // récupération du manager entité
          $em = $this->getDoctrine()->getManager();

          //nécessaire qu'une valeur change pour déclencer preUpdate
          $item->setLastVote();
          $em->persist($vote);
          $em->persist($item);
          // sauvegarde
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', 'Vote pour "'.$item->getTitre().'" enregistré!');
        }
      }

      $items = $em->getRepository('AppBundle:Item')->persoFindByItemCategory($slug);

      if(isset($items[1])){
        $item1 = $items[rand(0, count($items)-1)];
        $item2 = $items[rand(0, count($items)-1)];
        $insuffisant=0;
      }
      else{
        $item1 = null;
        $item2 = null;
        $insuffisant = 1;
      }

      return $this->render('default/categorie.html.twig', [
          'itemCategory' => $category,
          'item1' => $item1,
          'item2' => $item2,
          'insuffisant' => $insuffisant,
          'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
      ]);
    }
}
