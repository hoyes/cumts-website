<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Event;
use Cumts\MainBundle\Entity\Workshop;
use Cumts\MainBundle\Entity\Visit;
use Cumts\MainBundle\Entity\BarNight;
use Cumts\AdminBundle\Form\Type\EventType;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all Event entities.
     *
     */
    public function indexAction($page = 1, $limit = 25)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('CumtsMainBundle:Event')->findAllNonShows($page, $limit);
        $entities = $paginator->paginate($query, $page, $limit);

        return $this->render('CumtsAdminBundle:Event:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsAdminBundle:Event:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Event entity.
     *
     */
    public function newAction($type)
    {
        $entity  = $this->createEvent($type);
        $form   = $this->createForm(new EventType(), $entity);

        return $this->render('CumtsAdminBundle:Event:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Event entity.
     *
     */
    public function createAction($type)
    {
        $entity  = $this->createEvent($type);
        $form    = $this->createForm(new EventType(), $entity);
        $form->bind($this->getRequest());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_events_show', array('id' => $entity->getId())));
            
        }

        return $this->render('CumtsAdminBundle:Event:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createForm(new EventType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsAdminBundle:Event:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Event entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm   = $this->createForm(new EventType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_events_edit', array('id' => $id)));
        }

        return $this->render('CumtsAdminBundle:Event:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Event entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CumtsMainBundle:Event')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_events'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    private function createEvent($type)
    {
        switch ($type) {
            case 'bar_night':
                return new BarNight();
            case 'workshop':
                return new Workshop();
            case 'visit':
                return new Visit();
            default:
                return new Event();
        }
    }
}
