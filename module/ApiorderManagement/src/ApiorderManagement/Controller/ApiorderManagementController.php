<?php
namespace ApiorderManagement\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use ApiorderManagement\Model\ApiorderManagementMapper;
use Zend\View\Model\JsonModel;
use Application\Entity\Orders;
use ApiorderManagement\Factories\HydratorFactory;

class ApiorderManagementController extends AbstractRestfulController{
    
    /**
     * Handler 404
     *
     * This method is used to handle 404.
     *
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     *
     * @since -- Added the handler404() method
     *
     * @return 404 Page Not Found
     * @throws Does not throw any exception
     * @access public
     */
    public function handler404()
    {
        $this->getResponse()->setStatusCode(404);
        return;
    }
    
    /**
     * Doctrine Object Manager
     *
     * This method is used to get Doctrine connection object.
     *
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     *
     * @since -- Added the getConnection() method
     *
     * @return object $entityManager Doctrine Object Manager
     * @throws Does not throw any exception
     * @access public
     */

    public function getConnection()
    {
        $eManager = $this->getServiceLocator();
        $entityManager = $eManager->get('doctObjMngr');
        return $entityManager;
    }
    
    /**
     * Entity Hydrator
     *
     * This method is used to set data in entity.
     *
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     *
     * @since  -- Added the entityHydrator() method
     * @since -- Added the $dataArr argument
     * @since -- Added the $entity argument
     *
     * @param  array $dataArr Will receive data values
     * @param  object $entity Will receive an entity
     *
     * @return object $hydrator
     * @throws Does not throw any exception
     * @access public
     */

    public function entityHydrator( $dataArr, $entity )
    {
        $hydrator = $this->getServiceLocator()->get('hydrateEntity');
        $hydrator( $dataArr , $entity );
        return $hydrator;
    }
    
    /**
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     * Return list of resources
     *
     * @return mixed
    */
    
	public function getList(){
        $ApiorderManagementMapper = new ApiorderManagementMapper( $this->getConnection() );
        $results = $ApiorderManagementMapper->getOrders();
        return new JsonModel(array(
			'data' => $results,
		));
	}
    
    /**
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     * Return single resource
     *
     * @param  mixed $id
     * @return mixed
     */

    public function get($id){
        $ApiorderManagementMapper = new ApiorderManagementMapper( $this->getConnection() );
        $results = $ApiorderManagementMapper->getOrders( $id , true , 'SearchbyOrderid');
        return new JsonModel(array(
            'data' => $results ,
        ));
    }
    
    /**
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */

    public function create($data)
    {   
        if( isset($data['today'] )){
            $ApiorderManagementMapper = new ApiorderManagementMapper( $this->getConnection() );
            $results = $ApiorderManagementMapper->getOrders( Date('Y-m-d') , true , 'searchbyToday' );
            return new JsonModel(array(
                'data' => $results ,
            ));
        }else if( isset( $data['search'] ) ){
            $ApiorderManagementMapper = new ApiorderManagementMapper( $this->getConnection() );
            $results = $ApiorderManagementMapper->getOrders( $data['id'] , true , 'searchbyId' );
            return new JsonModel(array(
                'data' => $results ,
            ));
        }else{
            $hydrator = $this->entityHydrator( $data[0] , new Orders );
            $hydrator( $data[0]  , new Orders   );
            $ApiorderManagementMapper = new ApiorderManagementMapper( $this->getConnection() );
            $results = $ApiorderManagementMapper->saveOrder( $hydrator , $data );
            if ( !is_a($results, 'Exception') ) {
                $res = 'Order Successfully Added';
            }else if (ENV) {
                    $this->flashMessenger()->addErrorMessage($resultLedgerFor->getMessage());
                    $res = 'Exc: '. $resultLedgerFor->getMessage();
            }else if (!ENV)  {
                    $res = 'Exc: Something Went Wrong';
            }else{
                $res = $this->handler404();
            }
            return new JsonModel(array(
                'data' => $res,
            ));
        }
    }

    /**
     * Respond to the PATCH method
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     * @param  $id
     * @param  $data
     * @return array
     */
    public function patch($id, $data)
    {   
        $ApiorderManagementMapper = new ApiorderManagementMapper( $this->getConnection() );
        $OrderEntity =  $ApiorderManagementMapper->getOrderEntity($id);
        $hydrator = $this->entityHydrator( $data[0] , $OrderEntity  );
        $results = $ApiorderManagementMapper->updateOrder( $hydrator , $data ,$id);
        if (!is_a($results, 'Exception')) {
            $res = 'Order Successfully Updated';
        }else if (ENV) {
                $this->flashMessenger()->addErrorMessage($resultLedgerFor->getMessage());
                $res = 'Exc: '. $resultLedgerFor->getMessage();
        } else if(!ENV) {
                $res = 'Exc: Something Went Wrong';
        }else{
            $res = $this->handler404();
        }
        return new JsonModel(array(
            'data' => $res,
        ));
    }
    
    /**
     * @author Syed Ishaq <smishaq@stc.in .... syedissaq918@gmail.com>
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */

    public function delete($id)
    {  
        $eManager = $this->getServiceLocator();
        $em = $eManager->get('doctObjMngr');
        $query = $em->createQuery('SELECT  oi.id as id FROM Application\Entity\Orderitems oi where  oi.orderid=?1');
        $query->setParameter(1,$id);
        $result = $query->getArrayResult();
        foreach( $result as $key=>$value ){
            $Orders = $em->find('Application\Entity\Orderitems', $value);
            $em->remove($Orders);
            $em->flush();
        }
        $Orders = $em->find('Application\Entity\Orders', $id);
        $em->remove($Orders);
        $em->flush();
        return new JsonModel([
            'data' => 'deleted'
        ]);
    } 
}