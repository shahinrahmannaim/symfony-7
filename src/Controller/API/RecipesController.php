<?php 
namespace App\Controller\API;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;


class RecipesController extends AbstractController{

    


    #[Route('/api/recette',methods:['GET'])]
    public function index(Request $request, RecipeRepository $repository): JsonResponse
    {
        $recipes = $repository->findAll();
        $data = [];

        foreach ($recipes as $recipe) {
            $data[] = [
                'id' => $recipe->getId(),
                'thumbnailFile' => $recipe->getThumbnail() ? '/uploads/recipes/' . $recipe->getThumbnail() : null,
                'title' => $recipe->getTitle(),
                'category'=>$recipe->getCategory()? $recipe->getCategory()->getId() : null,
                'createdAt' => $recipe->getCreatedAt(),
                'updatedAt' => $recipe->getUpdatedAt(),
                'duration' => $recipe->getDuration(),
                'content' => $recipe->getContent()
            ];
        }
        
        
       
        
        return $this->json($data);
        
        
    }

    
    
    #[Route('/api/recette/create', methods:['POST'])]

    public function create(Request $request, EntityManagerInterface  $em  ):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
            $recipe = new Recipe();
            
            if ($request->request->has('title')) {
                $recipe->setTitle($request->request->get('title'));
            }
            if ($request->files->has('thumbnailFile')) {
                /** @var UploadedFile $file */
                $file = $request->files->get('thumbnailFile');
                $recipe->setThumbnailFile($file);
            }
            if ($request->request->has('duration')) {
                $recipe->setDuration($request->request->get('duration'));
            }
            if ($request->request->has('content')) {
                $recipe->setContent($request->request->get('content'));
            }
            if ($request->request->has('category')) {
                $category = $em->getRepository(Category::class)->find($request->request->get('category'));
                $recipe->setCategory($category);
            }
        
          
            
              $em->persist($recipe);
              $em->flush();
              
            
            return new JsonResponse("success");
    }

    #[Route('/api/recette/edit/{id}', methods: ['PUT', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Find the existing recipe by its ID
        $recipe = $em->getRepository(Recipe::class)->find($id);
        // $category = $em->getRepository(Category::class)->find($id);

        if (!$recipe) {
            return new JsonResponse(['error' => 'Recipe not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Update title if provided
        if ($request->request->has('title')) {
            $recipe->setTitle($request->request->get('title'));
        }

       
        if ($request->files->has('thumbnailFile')) {
            /** @var UploadedFile $file */
            $file = $request->files->get('thumbnailFile');
            $recipe->setThumbnailFile($file);
        }

        // Update duration if provided
        if ($request->request->has('duration')) {
            $recipe->setDuration($request->request->get('duration'));
        }

        // Update content if provided
        if ($request->request->has('content')) {
            $recipe->setContent($request->request->get('content'));
        }

       
        if ($request->request->has('category')) {
            $category = $em->getRepository(Category::class)->find($request->request->get('category'));
            if ($category) {
                $recipe->setCategory($category);
            } else {
                return new JsonResponse(['error' => 'Category not found'], JsonResponse::HTTP_NOT_FOUND);
            }
        }

        try {
            $em->persist($recipe);
            $em->flush();  // Save the changes to the database
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Failed to update recipe: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['status' => 'Recipe updated successfully!'], JsonResponse::HTTP_OK);
    }

        
    
#[Route('/api/recette/delete/{id}', methods:['DELETE'],requirements:['id'=>Requirement::DIGITS])]
    public function delete(Request $request , Recipe $recipe,RecipeRepository $repository , EntityManagerInterface $em, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        
        $recipe = $repository->find($id);
        $em->remove($recipe);
        $em->flush();
    
        
        return new JsonResponse("Deleted Success!!");
    }




}