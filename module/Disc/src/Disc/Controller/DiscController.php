<?php

namespace Disc\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel, 
    Disc\Form\DiscForm,
    Doctrine\ORM\EntityManager,
    Disc\Entity\Disc;

class DiscController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    public function indexAction()
    {
        return new ViewModel(array(
            'discs' => $this->getEntityManager()->getRepository('Disc\Entity\Disc')->findAll() 
        ));
    }

    public function addAction()
    {
        $form = new DiscForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $disc = new Disc();
            
            $form->setInputFilter($disc->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $disc->populate($form->getData()); 
                $this->getEntityManager()->persist($disc);
                $this->getEntityManager()->flush();

                // Redirect to list of discs
                return $this->redirect()->toRoute('disc'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('disc', array('action'=>'add'));
        } 
        $disc = $this->getEntityManager()->find('Disc\Entity\Disc', $id);

        $form = new DiscForm();
        $form->setBindOnValidate(false);
        $form->bind($disc);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of discs
                return $this->redirect()->toRoute('disc');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('disc');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $disc = $this->getEntityManager()->find('Disc\Entity\Disc', $id);
                if ($disc) {
                    $this->getEntityManager()->remove($disc);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of discs
            return $this->redirect()->toRoute('disc', array(
                'controller' => 'disc',
                'action'     => 'index',
            ));
        }

        return array(
            'id' => $id,
            'disc' => $this->getEntityManager()->find('Disc\Entity\Disc', $id)
		//->getArrayCopy() // blad
        );
    }
}
