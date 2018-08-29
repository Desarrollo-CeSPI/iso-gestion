<?php

namespace Cespi\Bundle\IsoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cespi\Bundle\IsoBundle\Entity\Alcances;
use Cespi\Bundle\IsoBundle\Form\AlcancesType;

/**
 * Alcances controller.
 *
 */
class AlcancesController extends Controller
{

    /**
     * Lists all Alcances entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CespiIsoBundle:Alcances')->findAll();

        return $this->render('CespiIsoBundle:Alcances:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Alcances entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Alcances();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alcances_show', array('id' => $entity->getId())));
        }

        return $this->render('CespiIsoBundle:Alcances:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Alcances entity.
     *
     * @param Alcances $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Alcances $entity)
    {
        $form = $this->createForm(new AlcancesType(), $entity, array(
            'action' => $this->generateUrl('alcances_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear','attr' => array('class' => 'marg btn btn-primary btn-sm')));

        return $form;
    }

    /**
     * Displays a form to create a new Alcances entity.
     *
     */
    public function newAction()
    {
        $entity = new Alcances();
        $form   = $this->createCreateForm($entity);

        return $this->render('CespiIsoBundle:Alcances:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Alcances entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Alcances')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alcances entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Alcances:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Alcances entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Alcances')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alcances entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CespiIsoBundle:Alcances:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Alcances entity.
    *
    * @param Alcances $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Alcances $entity)
    {
        $form = $this->createForm(new AlcancesType(), $entity, array(
            'action' => $this->generateUrl('alcances_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'marg btn btn-primary btn-sm')));
        

        return $form;
    }
    /**
     * Edits an existing Alcances entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CespiIsoBundle:Alcances')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alcances entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('alcances_edit', array('id' => $id)));
        }

        return $this->render('CespiIsoBundle:Alcances:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Alcances entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CespiIsoBundle:Alcances')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Alcances entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('alcances'));
    }

    /**
     * Creates a form to delete a Alcances entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alcances_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar','attr' => array('class' => 'btn btn-danger btn-sm')))
            ->getForm()
        ;
    }
}
