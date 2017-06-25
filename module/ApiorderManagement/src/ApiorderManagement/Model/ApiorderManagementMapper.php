<?php

/**
 * ApiorderManagementMapper file for Order Management Module.
 *
 * This file is a Class file and holds the Business Logic for 
 * orders.This file contains a Class 
 * which has all necessary methods to process Orders.
 *
 * PHP Version 5.5 (php version)
 *
 * LICENSE: This source file is subject to version 1.0 
 * of the OrderManagement license that is available on perpetual or 
 * services(SAAS) based http://www.github.in/licence. 
 * The SalesCON License will not be available free.
 * For futher details kindly contact issaqsyed918@gmail.com
 * 
 * @version   1.0
 * @author    smishaq <smishaq@stc.in>
 * @copyright 2016 STC
 * @license   Api Ordermanagement Version 2.0 {@link http://www.github.in/licence}
 
 */

namespace ApiorderManagement\Model;

use Doctrine\ORM\EntityManager;

use Application\Entity\Orderitems;

class ApiorderManagementMapper
{
    
    /**
     * $entityManager property
     *
     * This property holds Doctrine Connection Object
     *
     * @author Sm Ishaq <smishaq@stc.in>
     * @since 1.0 Added the $entityManager property
     * @var object
     * @access private
     */

	protected $entityManager;
	
	
	/**
     * Constructor 
     * 
     * This method is used to set $entityManager property with Doctrine 
     * Connection Object sent from Controller.
     * 
     * @author Sm Ishaq <smishaq@stc.in>
     * 
     * @since 1.0 Added the __construct() method
     * @since 1.0 Added the $entityManager argument
     * 
     * @param  object  $entityManager Will receive Doctrine Object    
     * 
     * @return null 
     * @throws Does not throws any exception
     * @access public
     */

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager=$entityManager;
	}
    
    /**
     * Get All  Orders / Return single Order
     * 
     * This method is used to fetch All  Order in 
     * Orders Table
     * 
     * This method is also used to fetch Particular  Order in 
     * Orders Table by passing searchbyUserId and bool arguments
     * 
     * This method is also used to fetch Today All Order in 
     * Orders Table by passing SearchbyToday and bool arguments

     * @author SM Ishaq <smishaq@stc.in/issaqsyed918@gmail.com>
     * 
     * @since 1.0 Added the getOrders() method   
     * 
     * @return object|exception Could be any
     * @throws Exception Could not connect or find table etc
     * @access public
     */

    public function getOrders( $id = null , $bool = null , $search = null){
        try{
            $queryBuildr = $this->entityManager->createQueryBuilder();
            $queryBuildr
            ->SELECT('oi,o')
            ->FROM('Application\Entity\Orderitems', 'oi')
            ->INNERJOIN('oi.orderid' , 'o');
            if( $bool ){
                if( $search == 'searchbyToday' ){
                    $queryBuildr->WHERE('o.createdat >=?1')->ANDWHERE('o.createdat <=?2')->SETPARAMETERS( [ 1 => $id." "."00:00:00", 2 => $id." "."23:59:59" ] ); 
                }else if( $search == 'searchbyId' ){
                    $queryBuildr->WHERE('o.userid =?1' )->SETPARAMETER( 1 ,$id );   
                }else if( $search == 'SearchbyOrderid' ){
                    $queryBuildr->WHERE('o.orderid =?1' )->SETPARAMETER( 1 , $id );
                }
            }
           $result = $queryBuildr->getQuery()->getArrayResult();
        }catch (Exception $exe) {
            $result =  $exe->getMessage();
        }
        return $result;
    }
    
    /**
     * Get Order Details
     * 
     * This method is used to  Order Details from  Orders 
     * 
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com >
     * 
     * @since 1.0 Added the getOrderEntity() method
     * @since 1.0 Added the $Orderid argument
     * 
     * @param  integer $Orderid Will receive  Order Id    
     * 
     * @return array|exception Could be any
     * @throws Exception Could not connect or find table etc
     * @access public
     */
    public function getOrderEntity($id){
        try{
            $queryBuildr = $this->entityManager->createQueryBuilder();
            $queryBuildr
            ->SELECT('o')
            ->FROM('Application\Entity\Orders', 'o')
            ->WHERE('o.orderid =?1' )->SETPARAMETER( 1 , $id );
           $result = $queryBuildr->getQuery()->getResult();
        }catch (\Exception $exe) {
            $result =  $exe->getMessage();
        }
        return $result;
    }

    /**
     * Save Sales Order 
     * 
     * This method is used to insert data in  Orders Table,
     * Order Items Product Orderitems Table
     * @author Syed Mohmad Ishaq <smishaq@stc.in>
     * @since 1.0 Added the saveOrder() method
     * @since 1.0 Added the $OrderEntity argument
     * @since 1.0 Added the $data argument
     * @param object $OrderEntity Will receive Order Entity
     * @param array $data Will receive Sales Order Data
     * @param object $hydrator Will receive Hydrator
     * @return boolean|exception Could be any
     * @throws Exception Could not insert
     * @access public
     */

    public function saveOrder( $hydrator , $data ){
         try{
            $this->entityManager->beginTransaction();
            $this->entityManager->persist( $hydrator->getEntity() );
            $this->entityManager->flush( $hydrator->getEntity() );
            $orderId = $hydrator->getEntity()->getOrderid();
            foreach($data['nameArr'] as $key=> $value){
                $hydrator( [ 
                    'orderid' =>  $orderId ,
                    'name' => $value , 
                    'price' => $data['priceArr'][$key] , 
                    'quantity' => $data['qtyArr'][$key] ,
                ]  , new Orderitems );

                $this->entityManager->persist( $hydrator->getEntity() );
                $this->entityManager->flush( $hydrator->getEntity() );
            }
            $result = $orderId;
            $this->entityManager->commit();
        }catch( Exception $exc){
            $this->entityManager->rollback();
            $result = $exc->getMessage();
        } 
        return $result;
       
    }
    
    /**
     * Update Sales Order 
     * 
     * This method is used to update data in  Orders Table,
     * Order Items Product Orderitems Table
     * @author Syed Mohmad Ishaq <smishaq@stc.in>
     * @since 1.0 Added the saveOrder() method
     * @since 1.0 Added the $OrderEntity argument
     * @since 1.0 Added the $data argument
     * @param object $OrderEntity Will receive Order Entity
     * @param array $data Will receive Sales Order Data
     * @param object $hydrator Will receive Hydrator
     * @return boolean|exception Could be any
     * @throws Exception Could not update
     * @access public
     */

    public function updateOrder( $hydrator , $data , $id ){
       try{
        $this->entityManager->beginTransaction();
        $this->entityManager->persist( $hydrator->getEntity() );
        $this->entityManager->flush( $hydrator->getEntity() );
        
        $query = $em->createQuery('SELECT  oi.id as id FROM Application\Entity\Orderitems oi where  oi.orderid=?1');
        $query->setParameter(1,$id);
        $result = $query->getArrayResult();
        foreach( $result as $key=>$value ){
            $Orders = $em->find('Application\Entity\Orderitems', $value);
            $em->remove($Orders);
            $em->flush();
        }
       
       foreach($data['nameArr'] as $key=> $value){
            $hydrator( [
                'orderid' =>  $id ,
                'name' => $value , 
                'price' => $data['priceArr'][$key] , 
                'quantity' => $data['qtyArr'][$key] ,
            ]  , new Orderitems );
            
            $this->entityManager->persist( $hydrator->getEntity() );
            $this->entityManager->flush( $hydrator->getEntity() );
        }
        $result = $id;
        $this->entityManager->commit();
        }catch( Exception $exc){
            $this->entityManager->rollback();
            $result = $exc->getMessage();
        } 
        return $result;

    }
}
        
	
