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
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $greeting;
    private $badDesign;

    public function __construct(Greeting $greeting, VeryBadDesign $badDesign)
    {
        $this->greeting = $greeting;
        $this->badDesign = $badDesign;
    }

    /**
     * @Route("/", name="blog_index")
     */
    public function index(Request $request)
    {
        return $this->render('base.html.twig', [
            'message' => $this->greeting->greet($request->get('name'))
        ]);
    }
}