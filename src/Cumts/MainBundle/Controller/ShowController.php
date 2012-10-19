<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Show;
use Cumts\MainBundle\Form\ShowType;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CumtsMainBundle:Show')->findAll();

        return $this->render('CumtsMainBundle:Show:index.html.twig', array(
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

        return $this->render('CumtsMainBundle:Show:show.html.twig', array(
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

        return $this->render('CumtsMainBundle:Show:new.html.twig', array(
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

            return $this->redirect($this->generateUrl('shows_show', array('id' => $entity->getId())));
        }

        return $this->render('CumtsMainBundle:Show:new.html.twig', array(
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

        return $this->render('CumtsMainBundle:Show:edit.html.twig', array(
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

            return $this->redirect($this->generateUrl('shows_edit', array('id' => $id)));
        }

        return $this->render('CumtsMainBundle:Show:edit.html.twig', array(
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
}
