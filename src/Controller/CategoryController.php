<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categ", name="categoryList")
     */
    public function categoryList(CategoryRepository $categoryRepository) //l'autowire
    {
        $category = $categoryRepository->findAll();
        return $this->render('categoryList.html.twig', [
            'category' => $category
        ]);

    }

    /**
     * @Route("/categ/{id}", name="categoryShow")//utilisation de la wildcard
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        //Si le tag n'existe pas => renvoie automatiq une error exception en affichant erreur 404
        if (is_null($category)) {
            throw new NotFoundHttpException();
        };

        return $this->render('categoryShow.html.twig', [
            'category' => $category
        ]);

    }
}

