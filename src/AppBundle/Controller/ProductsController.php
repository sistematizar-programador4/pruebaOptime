<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Products;

class ProductsController extends Controller {
    /**
    * @Route("/create-products")
    */
    public function createAction(Request $request) {

        $products = new Products();
        $form = $this->createFormBuilder($products)
        ->add('code', TextType::class)
        ->add('name', TextType::class)
        ->add('description', TextareaType::class)
        ->add('mark', TextType::class)
        ->add('price', MoneyType::class)
        ->add('category', ChoiceType::class)
        ->add('save', SubmitType::class, array('label' => 'New products'))
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {

            $products = $form->getData();
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($products);
            $em->flush();
        
            return $this->redirect('/show-products/');
    
        }
    
        return $this->render(
        'products/new.html.twig',
        array('form' => $form->createView())
        );
    
    }
    /**
    * @Route("/show-products")
    */  
    public function showAction() {

        $products = $this->getDoctrine()
        ->getRepository('AppBundle:Products')
        ->findAll();
  
        return $this->render(
            'products/list.html.twig',
            array('products' => $products)
        );
    }

}
