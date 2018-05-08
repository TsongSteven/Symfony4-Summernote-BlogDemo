<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DisplayBlogController extends Controller
{
    /**
     * @Route("/display/blog", name="display_blog")
     */
    public function index()
    {
    	$post = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('display_blog/index.html.twig', [
            'post' => $post
        ]);
    }

    /** 
    * @Route("/viewpost/{id}")
    */

    public function viewpost($id){

    	$post = $this->getDoctrine()->getRepository(Post::class)->find($id);

    	return $this->render("display_blog/viewpost.html.twig",[

    		'post' => $post
    	]);
    }
}
