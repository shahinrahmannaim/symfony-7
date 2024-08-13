<?php

namespace App\Controller\Admin;


use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints\Json;


#[Route('/admin/recettes', name:'admin.recipe.')]
#[IsGranted('ROLE_ADMIN')]

class RecipeController extends AbstractController
{
   
    #[Route('/', name: 'index')]
    public function index(Request $request, RecipeRepository $repository, CategoryRepository $categoryRepository ): Response
    {
      $page = $request->query->getInt( 'page', 1);
      
      $recipes = $repository->paginateRecipes($page);
  
      return
      $this->render ('admin/recipe/index.html.twig', [
      'recipes' => $recipes
      ]);
        
    }
    #[Route('/create', name:'create')]
    public function create( Request $request, EntityManagerInterface $em){
      $recipe = new Recipe();
      $form = $this->createForm(RecipeType::class,$recipe);
      $form->handleRequest($request);  
      
      if($form->isSubmitted() && $form->isValid()){
        // $recipe->setCreatedAt(new \DateTimeImmutable());
        // $recipe->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($recipe);
        $em->flush();
        $this->addFlash('success','La recette a bien été crée');
        return $this->redirectToRoute('admin.recipe.index'); 
      }
      
      return $this->render('admin/recipe/create.html.twig',[
        
        'form'=>$form
      ]);
    }
   
    
    #[Route('/{id}', name:'edit', methods:['GET','POST'],requirements:['id'=>Requirement::DIGITS])]
    
    public function edit(Recipe $recipe , Request $request, EntityManagerInterface $em){
      // $thumbnailFile = $recipe->getThumbnail();
      $form = $this->createForm(RecipeType::class,$recipe);
      $form->handleRequest($request);  
      
      if($form->isSubmitted() && $form->isValid()) {
        // $recipe->setCreatedAt(new \DateTimeImmutable());
        // $recipe->setUpdatedAt(new \DateTimeImmutable());
          $em->flush();
        $this->addFlash('success','La recette a bien ete modifie');
          return $this->redirectToRoute('admin.recipe.index');
    }      
      return $this->render('admin/recipe/edit.html.twig',[
        'recipe'=>$recipe,
        // 'thumbnailFile' => $thumbnailFile,
        'form'=>$form
      ]);
    }
   

    #[Route('/{id}', name:'delete', methods:['DELETE'],requirements:['id'=>Requirement::DIGITS])]

    public function delete(Recipe $recipe, EntityManagerInterface $em){
      
      $em->remove($recipe);
      $em->flush();

      $this->addFlash('success','the recipe has been deleted !!!');
 
      return $this->redirectToRoute('admin.recipe.index');

      
    
      
    }

    
}
