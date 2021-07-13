<?php


namespace App\Controller\Admin;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("admin/categ", name="categoryList")
     */
    public function categoryList(CategoryRepository $categoryRepository) //l'autowire
    {
        $category = $categoryRepository->findAll();
        return $this->render('admin/adminCategoryList.html.twig', [
            'category' => $category
        ]);

    }

    /**
     * @Route("admin/categ/{id}", name="categoryShow")//utilisation de la wildcard
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        //Si le Base n'existe pas => renvoie automatiq une error exception en affichant erreur 404
        if (is_null($category)) {
            throw new NotFoundHttpException();
        };

        return $this->render('admin/adminCategoryShow.html.twig', [
            'category' => $category
        ]);

    }
}

