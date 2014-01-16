<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Cumts\MainBundle\Entity\Member;
use Cumts\AdminBundle\Form\Type\MemberType;

/**
 * Member controller.
 *
 */
class MemberController extends Controller
{
    /**
     * Lists all Member entities.
     *
     */
    public function indexAction($page, $limit, $filter)
    {
    
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('CumtsMainBundle:Member')->findAllQuery($filter);
        $entities = $paginator->paginate($query, $page, $limit);

        return $this->render('CumtsAdminBundle:Member:index.html.twig', array(
            'entities' => $entities, 'filter' => $filter
        ));
    }
    
    public function printAction($filter)
    {
    
        $em = $this->getDoctrine()->getEntityManager();
        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('CumtsMainBundle:Member')->findAllQuery($filter);
	$entities = $paginator->paginate($query, 1, 99999);

        return $this->render('CumtsAdminBundle:Member:print.html.twig', array(
            'entities' => $entities, 'filter' => $filter
        ));
    }

    /*
     * Finds and displays a Member entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:Member')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Member entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsAdminBundle:Member:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Member entity.
     *
     */
    public function newAction()
    {
        $entity = new Member();
        $form   = $this->createForm(new MemberType(), $entity);

        return $this->render('CumtsAdminBundle:Member:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Member entity.
     *
     */
    public function createAction()
    {
        $entity  = new Member();
        $entity->setPaid(true);
        $request = $this->getRequest();
        $form    = $this->createForm(new MemberType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_members_show', array('id' => $entity->getId())));
            
        }

        return $this->render('CumtsAdminBundle:Member:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Member entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:Member')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Member entity.');
        }
        $editForm = $this->createForm(new MemberType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsAdminBundle:Member:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Member entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:Member')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Member entity.');
        }

        $editForm   = $this->createForm(new MemberType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_members_edit', array('id' => $id)));
        }

        return $this->render('CumtsAdminBundle:Member:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Member entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CumtsMainBundle:Member')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Member entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_members'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function ldapAction($crsid)
    {
        $data = $this->get('cambridge_ldap')->lookup($crsid);
        if ($data) {
            $em = $this->getDoctrine()->getEntityManager();
            $m = $em->getRepository('CumtsMainBundle:Member')->findOneBy(array('auth_id' => $crsid));
            $data['exists'] = !is_null($m);
        }
        
        return new Response(json_encode($data),200,array('Content-Type'=>'application/json'));
    }
    
        
    public function checkAction()
    {
        if ($this->get('request')->getMethod() == 'POST') {
            $data = $this->get('request')->get('crsids');
            $lines = explode("\n",$data);
            $crsids = array();
                        
            $repo = $this->getDoctrine()->getEntityManager()->getRepository('CumtsMainBundle:Member');
            $ldap = $this->get('cambridge_ldap');
            $members = array();
            $not_members = array();
            $not_elligible = array();
            $not_found = array();
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (preg_match("/([a-z]{2,6}[0-9]{1,})(?:@cam\.ac\.uk)?/i", $line, $matches)) {
                        $crsids[] = $matches[1];
                }
                else if ($line) $not_found[] = $line;
            }
            
            foreach ($crsids as $crsid) {
                $m = $repo->findOneBy(array('auth_id' => $crsid, 'paid' => true));
                if ($m) $members[] = $m;
                else {
                    $m = $ldap->lookup($crsid);
                    if ($m) {
                        if ($m['is_student']) $not_members[] = $m;
                        else $not_elligible[] = $m;
                    }
                    else $not_found[] = $crsid;
                }
            }
            return $this->render('CumtsAdminBundle:Member:check.html.twig', array(
                'data' => $data,
                'members' => $members,
                'not_members' => $not_members,
                'not_elligible' => $not_elligible,
                'not_found' => $not_found
            ));

        }
        return $this->render('CumtsAdminBundle:Member:check.html.twig', array(
            'data' => ''
        ));
    }

}
