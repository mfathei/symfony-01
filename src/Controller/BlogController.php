<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/1/18
 * Time: 10:51 AM
 */

namespace App\Controller;


use App\Security\VeryBadDesign;
use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController
{
    private $greeting;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(Greeting $greeting, \Twig_Environment $twig)
    {
        $this->greeting = $greeting;
        $this->twig = $twig;
    }

    /**
     * @Route("/{name}", name="blog_index")
     */
    public function index($name)
    {
        $html = $this->twig->render('base.html.twig', [
            'message' => $this->greeting->greet($name)
        ]);

        return new Response($html);
    }
}