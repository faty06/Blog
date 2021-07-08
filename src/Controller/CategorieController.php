<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    private $category /*propet.*/ = [
        '1' => [
            "title" => "Politique",
            "content" => "Tous les articles liés à Jean Lassalle",
            "id" => 1,
            "published" => true,
        ],
        '2' => [
            "title" => "Economie",
            "content" => "Les meilleurs tuyaux pour avoir DU FRIC",
            "id" => 2,
            "published" => true
        ],
        '3' => [
            "title" => "Securité",
            "content" => "Attention les étrangers sont très méchants",
            "id" => 3,
            "published" => false
        ],
        '4' => [
            "title" => "Ecologie",
            "content" => "Hummer <3",
            "id" => 4,
            "published" => true
        ]
    ];

    /**
     * @Route ("/categories", name="categories")
     */
    public function CategoriesBlog(CategoryRepository $categoryRepository)
    {
        //return new Response('category'); die;
        //render permet de transform twig
        return $this->render('blog.html.twig', [
            'category' => $this->category
        ]);

    }

    /**
     * @Route ("/categories/{id}", name="category")
     */
    public function Categoryid($id)
    {
        //return new Response('blog'); die;
        return $this->render('blogid.html.twig', [
            'category' => $this->category[$id] // this = appel la mehode de la class ou propet (ici category).
        ]);
//instance de la class
    }
}

