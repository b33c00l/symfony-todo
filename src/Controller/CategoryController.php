<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Task;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\CategoryType;


class CategoryController extends Controller
{
    private $entityManager;
    private $categoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    )

    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("category/{id}", name="category.show")
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);
        foreach ($category->getTasks() as $task){
            dump($task->getTitle());
        }
        exit;
    }

    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/create", name="category.create")
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $data = $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirect('/category');
        }

        return $this->render('category/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("category/{id}/edit", name="category.edit")
     */

    public function edit(Request $request, $id)
    {
        $category = $this->categoryRepository->find($id);

        if ($category == null)
        {
            throw $this->createNotFoundException("Category # $id does not exist");
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $data = $form->getData();

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirect('/category');
        }
        return $this->render('category/create.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/category/{id}/delete", name="category.delete")
     */
    public function delete($id)
    {
        $category = $this->categoryRepository->find($id);
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->redirect('/category');
    }


}
