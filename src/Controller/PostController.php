<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function home()
    {
        // return new  Response('Hello tech yogi friends');
        return $this->render('posts/home.html.twig');
    }

    // @Route("/blog/how-to-carry-your-sup-with-style-in-ibiza-waters") --- No va
    
    /**
     * @Route("/blog/{postName}", name="post_show")
     */
    // public function showPost($post)

    // AHora hacemos uso de las Entidades creadas
    public function showPost($postName, EntityManagerInterface $em)
    {
        // return new Response('future page to show a post content');
        // return new Response(sprintf('future page to show: "%s"', $post));
        $repository = $em->getRepository(Post::class);

        // Nuestro objeto repository sabe todo de como consultar en nuestra base de datos y/o tabla

        /** @var Post $post */
        $post = $repository->findOneBy(['post_name' => $postName]);

        // Si no existe el post hacemos una excepcion
        if(!$post){
            throw $this->createNotFoundException(sprintf('No post for the name given "%s"', $postName));
        }

        // En esta url http://127.0.0.1:8000/blog/something-new-sup-yoga-with-kids
        // var_dump($post);
        // die;

        // return $this->render('posts/post.html.twig', [
        //     'title' => ucwords(str_replace('-',' ', $post))
        // ]);

        
        // Ahora pasamos todo el objeto post
        return $this->render('posts/post.html.twig', [
            'post' => $post
        ]);

    }
}