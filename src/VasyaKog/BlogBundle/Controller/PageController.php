<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23.10.2017
 * Time: 21:10
 */

//src/VasyaKog/BlogBundle/Controller/PageController.php

namespace VasyaKog\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VasyaKog\BlogBundle\Entity\Enquiry;
use VasyaKog\BlogBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('VasyaKogBlogBundle:Page:index.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('VasyaKogBlogBundle:Page:about.html.twig');
    }

    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('VasyaKogBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));


                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('vasya_kog_blog_contact'));

            }

        }

        return $this->render('VasyaKogBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

}