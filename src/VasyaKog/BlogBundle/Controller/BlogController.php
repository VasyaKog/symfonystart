<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24.10.2017
 * Time: 0:06
 */

namespace VasyaKog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('VasyaKogBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $this->render('VasyaKogBlogBundle:Blog:show.html.twig', array(
            'blog' => $blog,
        ));
    }
}