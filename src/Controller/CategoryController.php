<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $category = [
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

    public function CategoriesBlog()
    {
        //return new Response('categories'); die;
        return $this->render('blog.html.twig', [
            'category' => $this->category
        ]);

    }

    /**
     * @Route ("/category/{id}", name="category")
     */


    public function Categoryid($id)
    {
        //return new Response('blog'); die;
        return $this->render('blogid.html.twig', [
            'category' => $this->category[$id]

        ]);

    }
}

