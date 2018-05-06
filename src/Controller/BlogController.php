<?php

namespace App\Controller;

use App\Form\BlogType;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /** 
    * @Route("/", name="home")
    */

    public function home(){

        $post = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('blog/display.html.twig',[

            'post' => $post
        ]);

    }
    /**
     * @Route("/blog", name="blog")
     */
    public function post(Request $request)
    {

    	$blog = new Post();

    	$form = $this->createForm(BlogType::class, $blog);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){

    		$data = $form->getData();

    		$em = $this->getDoctrine()->getManager();
    		$em->persist($data);

    		$em->flush();

            return $this->redirectToRoute("home");

    	}

    	return $this->render('blog/index.html.twig',[

    			'form' => $form->createView()
    		]);
    }

    /**
    * @Route("/view/{id}")
    */
    public function view_post($id){

        $post = $this->getDoctrine()
                ->getRepository(Post::class)
                ->find($id);

        return $this->render('blog/view.html.twig',[

            'view' => $post
        ]);

    }

    /**
    * @Route("/update/{id}")
    */

    public function update_post($id, Request $request){


        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

        $form = $this->createForm(BlogType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('blog/update.html.twig',[

            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/delete/{id}")
    */

    public function delete_post($id){

        $post = $this->getDoctrine()
                ->getRepository(Post::class)
                ->find($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($post);

        $em->flush();

        return $this->redirectToRoute("home");        
    }
}
