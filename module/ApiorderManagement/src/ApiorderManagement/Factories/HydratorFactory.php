<?php

/**
 * General Hydrating file for All Modules.
 *
 * This file is a Hydrator file and holds the Logic for Hydrating Doctrine Entities
 * This file contains all necessary Methods to set Entites.
 *
 * PHP Version 5.5 (php version)
 *
 * LICENSE: This source file is subject to version 1.0 
 * of the medicscon license that is available on perpetual or 
 * services(SAAS) based http://www.medicscon.in/licence. 
 * The medicscon License will not be available free.
 * For futher details kindly contact stc@info.in
 * 
 * @version   1.0
 * @author    Syed Ishaq <smishaq@stc.in>
 * @copyright 2016 STC
 * @license   medicscon Version 1.0 {@link http://www.medicscon.in/licence}
 * @link      http://www.stc.in
 */

namespace Apiordermanagement\Factories;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Hydrator Class
 *
 * This is a Hydrator Class and holds the Logic for Hydrating Doctrine Entities
 * This contains all necessary Methods to set Entites.
 *
 * @package   Apiordermanagement\Controller
 * @version   1.0
 * @since     1.0 Added the class
 * @author    Syed Ishaq <smishaq@stc.in>
 */
class HydratorFactory extends AbstractActionController
{

    /**
     * $entity property
     *
     * this property holds Entity Object
     *
     * @author Syed Ishaq <smishaq@stc.in>
     * @since 1.0 Added the $entity property
     * @var object
     * @access protected
     */
    protected $entity;

    /**
     * $data property
     *
     * This property holds data array
     *
     * @author Syed Ishaq <smishaq@stc.in>
     * @since 1.0 Added the $data property
     * @var array
     * @access protected
     */
    protected $data;

    /**
     * Set Data
     * 
     * This method sets data to $data property.
     * 
     * @author Syed Ishaq <smishaq@stc.in>
     * 
     * @since 1.0 Added the setData() method
     * @since 1.0 Added the $data argument
     * 
     * @param  array $data Will receive data values
     * 
     * @return null
     * @throws Does not throws any exception
     * @access public
     */
    public function setData($data)
    {
        $this->data = (array) $data;
    }

    /**
     * Set Entity
     * 
     * This method sets entity object to $entity property.
     * 
     * @author Syed Ishaq <smishaq@stc.in>
     * 
     * @since 1.0 Added the setEntity() method
     * @since 1.0 Added the $entity argument
     * 
     * @param  object $entity Will receive an entity
     * 
     * @return null
     * @throws Does not throws any exception
     * @access public
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function getEntity(){
        return $this->entity;
    }

    /**
     * Get Hydrator
     * 
     * This method gets hydrator to be used.
     * 
     * @author Syed Ishaq <smishaq@stc.in>
     * 
     * @since 1.0 Added the getHydrator() method
     * 	
     * @return $hydrator object
     * @throws Does not throws any exception
     * @access public
     */
    public function getHydrator()
    {
        $doctrineObject = $this->getServiceLocator()->get('doctObjMngr');
        $hydrator = new DoctrineObject($doctrineObject);
        return $hydrator;
    }

    /**
     * Hydrate Entity
     * 
     * This method fills entity with data.
     * 
     * @author Syed Ishaq <smishaq@stc.in>
     * 
     * @since 1.0 Added the hydrateEntity() method
     * 	
     * @return null
     * @throws Does not throws any exception
     * @access public
     */
    public function hydrateEntity()
    {

        $hydrator = $this->getHydrator();
        $hydrator->hydrate($this->data, $this->entity);
    }

    /**
     * Invokable Base Method
     * 
     * This method routes data and entity to respective methods.
     * 
     * @author Syed Ishaq <smishaq@stc.in>
     * 
     * @since 1.0 Added the __invoke() method
     * @since 1.0 Added the $dataArr argument
     * @since 1.0 Added the $entity argument
     * 
     * @param  array $dataArr will receive data values	
     * @param  object $entity will receive an entity
     * 
     * @return null
     * @throws Does not throws any exception
     * @access public
     */
    public function __invoke($dataArr = null, $entity = null)
    {
        if ($dataArr != null && $entity != null) {
            $this->setData($dataArr);
            $this->setEntity($entity);

            $this->hydrateEntity();
        }
    }

}
