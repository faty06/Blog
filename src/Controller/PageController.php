<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
//tjrs mettre extends AbstratController pour render
{
    /**
     * @Route ("/", name="home")
     */

    public function home()
    {
        return new Response('Home');
    }
}

