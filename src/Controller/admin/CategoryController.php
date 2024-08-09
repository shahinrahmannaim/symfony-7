<?php 
namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/category', name:'admin.category.')]
#[IsGranted('ROLE_ADMIN')]
class CategoryController extends AbstractController {

    #[Route(name:'index')]
    public function index(CategoryRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        // dd($categories);
        return $this->render('admin/category/index.html.twig',[
        'categories' => $repository->findAll()
       
        ]);
       
    }
    
    #[Route('/create', name:'create')]
    public function create(Request $request , EntityManagerInterface $em):Response
    {
        $category = new Category();
        $form= $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'la category a bien ete cree');
            return $this->redirectToRoute('admin.category.index');
        }
        return $this->render('admin/category/create.html.twig',[
            'form' => $form
        ]);

    }
    #[Route('/{id}', name:'edit', requirements:['id'=>Requirement::DIGITS],methods:['GET','POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em):Response
    {

        
        $form = $this->createForm(CategoryType::class,$category );
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->flush();
            $this->addFlash('success','la category a bien ete modifie');
            return $this->redirectToRoute('admin.category.index');
            
        }
        
        return $this->render('admin/category/edit.html.twig',[
            'category'=>$category,
            'form'=>$form
            
        ]);
        

    }
    #[Route('/{id}', name:'delete',   methods:['DELETE'],requirements:['id'=>Requirement::DIGITS])]
    public function remove(Category $category, EntityManagerInterface $em,int $id): Response
    {
   
        $category = $em->getRepository(Category::class)->find($id);

        if (!$category) {
            $this->addFlash('error', 'Category not found.');
            return $this->redirectToRoute('category_list'); // Adjust this route as needed
        }

        
            $em->remove($category);
            
            $em->flush();
            $this->addFlash('Success','category a été bien supprimeé');
             return $this->redirectToRoute('admin.category.index');
             

    }


}
