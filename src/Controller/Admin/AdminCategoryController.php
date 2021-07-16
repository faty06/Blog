<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/categ/insert", name="adminCategoryInsert")
     */
    public function insertCategory(Request $request, EntityManagerInterface $entityManager)
    {
        //L'entity Article permet de creer un new article en bdd comme si je faisais un inser into en sql
        $category = new Category();

        //je genere le formaire grace au gabarit puis j'intancie l'entity Article
        $categoryForm = $this->createForm(CategoryType::class, $category);

        //j'associe le formulaire
        $categoryForm->handleRequest($request);

        //isValid permet
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $this->addFlash('success', 'Votre article '.$category->getTitle().'a bien été créé !');
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('adminCategoryList');
        }

        return $this->render('Admin/List/adminCategoryInsert.html.twig', [
            'categoryForm' => $categoryForm->createView()

        ]);
    }

    /**
     * @Route("/admin/categ/update/{id}", name="adminCategoryUpdate")
     */
    public function updateCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $category = $categoryRepository->find($id);
        //j'effectue une modification (update) sur le titre
        $category->setTitle("Bladade en dromadaire");

        $categoryForm = $this->createForm(CategoryType::class, $category);

        //j'associe le formulaire
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $this->addFlash('success', 'Votre article '.$category->getTitle().'a bien été modifiée !');
            //La methode "persist" permet d'effectuer un pré-sauvegarde
            $entityManager->persist($category);
            //ici j'insere dns la bdd grace la methode "flush"
            $entityManager->flush();

            //prendre la route
            return $this->redirectToRoute('adminCategoryList');

        }
        return $this->render('Admin/List/adminCategoryUpdate.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }

    /**
     * @Route("admin/categ", name="adminCategoryList")
     */
    public function categoryList(CategoryRepository $categoryRepository) //l'autowire
    {
        $category = $categoryRepository->findAll();
        return $this->render('Admin/List/adminCategoryList.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("admin/categ/{id}", name="adminCategoryShow")//utilisation de la wildcard
     */
    public function categoryShow($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        //Si le Base n'existe pas => renvoie automatiq une error exception en affichant erreur 404
        if (is_null($category)) {
            throw new NotFoundHttpException();
        };

        return $this->render('Admin/Show/adminCategoryShow.html.twig', [
            'category' => $category
        ]);
    }
}

