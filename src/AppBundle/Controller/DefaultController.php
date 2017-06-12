<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/author/create")
     */
    public function createAuthorAction()
    {
        $author = new Author();
        $author->setFirstName('first name')
            ->setLastName('Last name')
            ->setUsername('username'.rand(0, 999));

        $doctrine = $this->getDoctrine();
        $doctrine->getManager()->persist($author);
        $doctrine->getManager()->flush();
        die('ok');
    }

    /**
     * @Route("/author/{id}")
     * @ParamConverter("author", class="AppBundle:Author")
     */
    public function showAuthorAction($author)
    {
        return $this->render('@App/author.html.twig', ['author' => $author]);
    }
}
