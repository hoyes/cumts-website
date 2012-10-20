<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Show;
use Cumts\AdminBundle\Form\Type\ShowType;

/**
 * Show controller.
 *
 */
class ShowController extends Controller
{
    /**
     * Lists all Show entities.
     *
     */
    public function indexAction($page = 1, $limit = 25)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('CumtsMainBundle:Show')->findBy(array(), array('start_at' => 'desc'));
        $entities = $paginator->paginate($query, $page, $limit);

        return $this->render('CumtsAdminBundle:Show:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Show entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CumtsMainBundle:Show')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Show entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsAdminBundle:Show:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Show entity.
     *
     */
    public function newAction()
    {
        $entity = new Show();
        $form   = $this->createForm(new ShowType(), $entity);

        return $this->render('CumtsAdminBundle:Show:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Show entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Show();
        $form = $this->createForm(new ShowType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('camdram')->updateShow($entity);

            return $this->redirect($this->generateUrl('admin_shows_show', array('id' => $entity->getId())));
        }

        return $this->render('CumtsAdminBundle:Show:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Show entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CumtsMainBundle:Show')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Show entity.');
        }

        $editForm = $this->createForm(new ShowType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsAdminBundle:Show:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Show entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CumtsMainBundle:Show')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Show entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ShowType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('camdram')->updateShow($entity);

            return $this->redirect($this->generateUrl('admin_shows_edit', array('id' => $id)));
        }

        return $this->render('CumtsAdminBundle:Show:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Show entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CumtsMainBundle:Show')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Show entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('shows'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    public function camdramAction($id)
    {
        $data = $this->get('camdram')->getShowData($id);
        if ($data) {
            $em = $this->getDoctrine()->getEntityManager();
            $m = $em->getRepository('CumtsMainBundle:Show')->findOneBy(array('camdram_id' => $id));
            $data->exists = !is_null($m);
        }

        return new Response(json_encode($data),200,array('Content-Type'=>'application/json'));
    }
}
