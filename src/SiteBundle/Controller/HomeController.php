<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class HomeController extends Controller
{
    public function indexAction()
    {
    	//get the last 5 articles.
        $listArticles = $this->getDoctrine()->getRepository('SiteBundle:Article')->home();
        
        return $this->render('SiteBundle:Home:index.html.twig',array(
        'listArticles' => $listArticles,
        ));
    }
    public function aboutAction()
    {
        return $this->render('SiteBundle:Home:about.html.twig');
    }
    public function oldDuikerAction()
    {
        return $this->render('SiteBundle:Beer:ouweduiker.html.twig');
    }
    public function stoutAction()
    {
        return $this->render('SiteBundle:Beer:stout.html.twig');
    }
    public function newsAction()
    {
        $listArticles = $this->getDoctrine()->getRepository('SiteBundle:Article')->findBy(array(),array('date' => 'DESC'));

        $numberarticles = count($listArticles);

        $leftArticles = array();
        $rightArticles = array();

        //making 2 lists, one for right and one for left.
        for($i=0;$i < $numberarticles; $i++){
            if($i % 2 == 0 ){
                //the number is odd
                array_push($leftArticles, $listArticles[$i]);
            }
            else{
                array_push($rightArticles, $listArticles[$i]);
            }
        }

        return $this->render('SiteBundle:Home:news.html.twig',array(
            'leftArticles' => $leftArticles,
            'rightArticles' => $rightArticles,
        ));
    }
    public function salesAction()
    {
        

        //making a list for every state.
        $west = $this->getDoctrine()->getRepository('SiteBundle:Sales')->west();
        $oost = $this->getDoctrine()->getRepository('SiteBundle:Sales')->oost();
        $antwerpen = $this->getDoctrine()->getRepository('SiteBundle:Sales') ->antwerpen();
        $limburg = $this->getDoctrine()->getRepository('SiteBundle:Sales') ->limburg();
        $vlaams = $this->getDoctrine()->getRepository('SiteBundle:Sales') ->vlaams();
        $buitenland = $this->getDoctrine()->getRepository('SiteBundle:Sales') ->buitenland();

        $listSales = array('west'=> $west, 'oost' => $oost, 'antwerpen' => $antwerpen, 'limburg' => $limburg, 'vlaams' => $vlaams, 'buitenland' => $buitenland);


        return $this->render('SiteBundle:Home:sales.html.twig',array(
            'listSales' => $listSales,
        ));
    }
    public function contactAction(request $request)
    {
            //the code for the proposition
        $data = array();
            $form = $this->createFormBuilder($data)
                    ->add('name', TextType::class)
                    ->add('email', EmailType::class)
                    ->add('message', TextareaType::class)

                    ->add('copy', CheckboxType::class,
                            array(
                                'label'    => 'Get a copy of the mail.',
                                'label_attr' => array(
                                   'class' => 'checkbox-inline'
                               ),
                                'required' => false,
                            )
                        )
                    ->getForm();
            $form->handleRequest($request);
        if ($form->isValid()) {
            // $data is a simply array with your form fields
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
                    ->setSubject('A new challenge proposition')
                    ->setFrom('noreply@hedonisambachtsbier.be')
                    ->setTo('contact@hedonisambachtsbier.be')
                    ->setBody(
                        $this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                            'Emails/contact.html.twig',
                            array('text' => $data['message'], 'name' => $data['name'], 'email' => $data['email'])
                        ),
                        'text/html'
                    )
            ;
            $this->get('mailer')->send($message);
            if($data['copy'] === true){
                //send the message to the user.
                $secondmessage = \Swift_Message::newInstance()
                    ->setSubject('Copy of your message to Hedonis Ambachtsbier')
                    ->setFrom('noreply@hedonisambachtsbier.be')
                    ->setTo($data['email'])
                    ->setBody(
                        $this->renderView(
                            // app/Resources/views/Emails/registration.html.twig
                            'Emails/contactcopy.html.twig',
                            array('text' => $data['message'], 'name' => $data['name'], 'email' => $data['email'])
                        ),
                        'text/html'
                    )
            ;
            $this->get('mailer')->send($secondmessage);
            }

            $this->addFlash('success', 'Your message has been send. Thank you.');
            return $this->redirect($this->generateUrl('site_index'));
        }
        return $this->render('SiteBundle:Home:contact.html.twig', array(
              'form' => $form->createView(),
            ));
    }


}
