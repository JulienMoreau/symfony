<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/author/{id}", requirements={"id": "\d+"})
     * @ParamConverter("author", class="AppBundle:Author")
     */
    public function showAuthorAction($author, Request $request)
    {

        $form = $this->createFormBuilder($author)
            ->add('firstName')
            ->add('lastName')
            ->add('username')
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $doctrine = $this->getDoctrine();
            $doctrine->getManager()->flush();
        }

        return $this->render('@App/author.html.twig', ['author' => $author, 'form' => $form->createView()]);
    }


    /**
     * @Route("/author/form", name="incription")
     */
    public function formAuthorAction(Request $request)
    {
        $author = new Author();
        $form = $this->createFormBuilder($author)
            ->add('firstName')
            ->add('lastName')
            ->add('username')
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $doctrine = $this->getDoctrine();
            $doctrine->getManager()->remove($author);
            $doctrine->getManager()->flush();
        }

        return $this->render(
            '@App/form.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/author/delete/{id}", requirements={"id": "\d+"}, name="delete_author")
     * @ParamConverter("author", class="AppBundle:Author")
     */
    public function deleteAuthorAction(Author $author)
    {
        $this->getDoctrine()->getManager()->remove($author);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('incription');
    }
}
