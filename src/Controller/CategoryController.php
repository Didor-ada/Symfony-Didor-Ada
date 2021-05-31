<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        {
            $categories = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findAll();

            return $this->render(
                'category/index.html.twig',
                ['categories' => $categories]
            );
        }
    }

    /**
     * @Route("/{categoryName}", name="show")
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        if (!$categoryName) {
            return $this->render('./erreur.html.twig', [
                'categoryName' => $categoryName]);
        }

        $programByCategory = $category->getPrograms();

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programByCategory
        ]);
    }
}