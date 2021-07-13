<?php


namespace App\Controller\Front;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categ", name="frontCategoryList")
     */
    public function categoryList(CategoryRepository $categoryRepository) //l'autowire
    {
        $category = $categoryRepository->findAll();
        return $this->render('Front/List/frontCategoryList.html.twig', [
            'category' => $category
        ]);

    }

    /**
     * @Route("/categ/{id}", name="frontCategoryShow")//utilisation de la wildcard
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        //Si le Base n'existe pas => renvoie automatiq une error exception en affichant erreur 404
        if (is_null($category)) {
            throw new NotFoundHttpException();
        };

        return $this->render('Front/Show/frontCategoryShow.html.twig', [
            'category' => $category
        ]);

    }
}

