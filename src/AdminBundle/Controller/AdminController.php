<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

//entity
use SiteBundle\Entity\Article;
use SiteBundle\Entity\Sales;
//types
use SiteBundle\Form\ArticleType;
use SiteBundle\Form\ArticleDelType;
use SiteBundle\Form\SalesType;
use SiteBundle\Form\SalesDelType;

class AdminController extends Controller
{
    
    public function indexAction()
    {

        return $this->render('AdminBundle::index.html.twig');
    }
    
    public function subscribersAction()
    {
        $listSub = $this->getDoctrine()->getRepository('SiteBundle:Subscriber')->findAll(array(), array('date'=>'desc'));
        return $this->render('AdminBundle:Subscribers:subscribers.html.twig',array(
            'listSub' => $listSub,
        ));
    }

    public function articlesAction()
    {
        $listArticles = $this->getDoctrine()->getRepository('SiteBundle:Article')->findAll();
        return $this->render('AdminBundle:Articles:articles.html.twig',array(
            'listArticles' => $listArticles,
        ));
    }
   
    public function addArticlesAction(request $request)
    {
        $article = new article();
        $artcile->setDate(new \Datetime());
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Your new article has been added');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('AdminBundle:Articles:add.html.twig',array(
        'form' => $form->createView(),
        ));
    }
    
    public function modArticlesAction(request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository('SiteBundle:Article')->find($id);
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Your article has been modified.');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('AdminBundle:Articles:mod.html.twig',array(
        'form' => $form->createView(),
        ));
    }
    
    public function delArticlesAction(request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository('SiteBundle:Article')->find($id);
        $form = $this->createForm(ArticleDelType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Your article has been deleted.');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('AdminBundle:Articles:del.html.twig',array(
        'form' => $form->createView(),
        ));

    }
    
    public function salesAction()
    {
        $listSales = $this->getDoctrine()->getRepository('SiteBundle:Sales')->findAll();
        return $this->render('AdminBundle:Sales:sales.html.twig',array(
            'listSales' => $listSales,
        ));
    }
    
    public function addSalesAction(request $request)
    {
        $sale = new Sales();
        $form = $this->createForm(SalesType::class, $sale);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sale);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Your new sale point has been added');
            return $this->redirectToRoute('admin_sales');
        }

        return $this->render('AdminBundle:Sales:add.html.twig',array(
        'form' => $form->createView(),
        ));
    }
    
    public function modSalesAction(request $request, $id)
    {
        $sale = $this->getDoctrine()->getRepository('SiteBundle:Sales')->find($id);
        $form = $this->createForm(SalesType::class, $sale);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sale);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Your new sale point has been modified');
            return $this->redirectToRoute('admin_sales');
        }

        return $this->render('AdminBundle:Sales:add.html.twig',array(
        'form' => $form->createView(),
        ));
    }
    
    public function delSalesAction(request $request, $id)
    {
        $sale = $this->getDoctrine()->getRepository('SiteBundle:Sales')->find($id);
        $form = $this->createForm(SalesDelType::class, $sale);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sale);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Your new sale point has been deleted');
            return $this->redirectToRoute('admin_sales');
        }

        return $this->render('AdminBundle:Sales:del.html.twig',array(
        'form' => $form->createView(),
        'sale' => $sale,
        ));
    }   
}
