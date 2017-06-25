<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/ for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ordermanagement\Controller;


use Application\Entity\Orders;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Response;

class OrdermanagementController extends AbstractActionController
{

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
     * indexAction
     * This method calls API and get all Orders from order-rest API
     * This method is used getting All Orders
     *
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com>
     *
     * @since 1.0 Added indexAction() method
     *
     *
     * @param  will not receive any argument
     *
     * @return will return a connection
     * @throws Does not throws any exception
     * @access public
     */

    public function indexAction()
    {   

        $viewobjmodel = new ViewModel();
        $client = new Client();
        $ServerPort ="";
        if($_SERVER['SERVER_PORT']){
            $ServerPort = ':'.$_SERVER['SERVER_PORT'];
        }
        $client->setUri('http://'.$_SERVER['SERVER_NAME'].$ServerPort.'/order-rest');
        $client->setOptions(array(
            'maxredirects' => 0,
            'timeout'      => 30
        ));
        $response = $client->send();
        
        if ($response->isSuccess()) {
            $result = json_decode( $response->getContent() , true);
            
        }
        if(count($result)){
            $viewobjmodel->setVariable('result', $result);
        }
        return $viewobjmodel;
    }
    
    /**
     * getordersAction
     * This method calls API and get Particular Orders based on Orderid that we sent to api from order-rest API
     * This method is used getting Single Orders
     *
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com>
     *
     * @since 1.0 Added getordersAction() method
     *
     *
     * @param  will not receive any argument
     *
     * @return will return a connection
     * @throws Does not throws any exception
     * @access public
     */

     public function getordersAction()
    {   
        $id = 9;
        $viewobjmodel = new ViewModel();
        $client = new Client();

        $ServerPort ="";
        if($_SERVER['SERVER_PORT']){
            $ServerPort = ':'.$_SERVER['SERVER_PORT'];
        }
        $client->setUri('http://'.$_SERVER['SERVER_NAME'].$ServerPort.'/order-rest/'.$id);

        // $client->setUri('http://localhost:9015/order-rest/'.$id);
        $client->setOptions(array(
            'maxredirects' => 0,
            'timeout'      => 30
        ));
        $response = $client->send();
        
        if ($response->isSuccess()) {
            $result = json_decode( $response->getContent() , true);
        }
        if(count($result)){
            $viewobjmodel->setVariable('result', $result);
        }
        return $this->redirect()->toRoute('ordermanagement', array('action' => 'index')  );
    }
    
    /**
     * createAction
     * // This method calls API and send POST Data and Save order Details in orderstable and orderitems table
     * This method is used getting Single Orders
     *
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com>
     *
     * @since 1.0 Added createAction() method
     *
     *
     * @param  will not receive any argument
     *
     * @return will return a connection
     * @throws throws  exception
     * @access public
     */
    
    public function createAction(){
        $nameArr= [1,2];
        $priceArr=[10,12];
        $qtyArr=[2,1];
        $data = [ [
            'emailid' => 'issaqsyed918@gmail.com',
            'status'     => 'created'
            ] , 'nameArr' =>  $nameArr , 'priceArr' => $priceArr   ,'qtyArr' => $qtyArr  ];
        $client = new Client();

        $ServerPort ="";
        if($_SERVER['SERVER_PORT']){
            $ServerPort = ':'.$_SERVER['SERVER_PORT'];
        }
        $client->setUri('http://'.$_SERVER['SERVER_NAME'].$ServerPort.'/order-rest');

        // $client->setUri('http://localhost:9015/order-rest');
        $client->setOptions(array(
            'maxredirects' => 5,
            'timeout'      => 30
        ));
        $client->setParameterPost(
             $data
        );
        $client->setMethod( Request::METHOD_POST );
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = json_decode( $response->getContent() , true);
        }
        return $this->redirect()->toRoute('ordermanagement', array('action' => 'index')  );
    }
    
    /**
     * deleteAction
     *  This method is used to delete single order by passing orderid and using delete method
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com>
     *
     * @since 1.0 Added deleteAction() method
     *
     *
     * @param  will not receive any argument
     *
     * @return will return a connection
     * @throws Does not throws any exception
     * @access public
     */

    public function deleteAction(){
        $id = $this->params('id');
        $client = new Client();
        $ServerPort ="";
        if($_SERVER['SERVER_PORT']){
            $ServerPort = ':'.$_SERVER['SERVER_PORT'];
        }
        $client->setUri('http://'.$_SERVER['SERVER_NAME'].$ServerPort.'/order-rest/'.$id);
        $client->setOptions(array(
            'maxredirects' => 5,
            'timeout'      => 30
        ));
        $client->setMethod( Request::METHOD_DELETE );
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = json_decode( $response->getContent() , true);
        }
        return $this->redirect()->toRoute('ordermanagement', array('action' => 'index')  );
    }
    
    /**
     * todayAction
     *  This method fetches all today orders using API and POST Data today 
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com>
     *
     * @since 1.0 Added todayAction() method
     *
     *
     * @param  will not receive any argument
     *
     * @return will return a connection
     * @throws Does not throws any exception
     * @access public
     */

    
    public function todayAction(){

        $data = [ 'today' => 'today' ];
        $client = new Client();
        $ServerPort ="";
        if($_SERVER['SERVER_PORT']){
            $ServerPort = ':'.$_SERVER['SERVER_PORT'];
        }
        $client->setUri('http://'.$_SERVER['SERVER_NAME'].$ServerPort.'/order-rest');
        $client->setOptions(array(
            'maxredirects' => 5,
            'timeout'      => 30
        ));
        $client->setParameterPost(
             $data
        );
        $client->setMethod( Request::METHOD_POST );
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = json_decode( $response->getContent() , true);
        }
        return $this->redirect()->toRoute('ordermanagement', array('action' => 'index')  );
    }
    
    /**
     * searchuserAction
     *  This method fetches order by users id using API and POST Data search and id of user 
     * @author SM Ishaq <smishaq@stc.in / issaqsyed918@gmail.com>
     *
     * @since 1.0 Added searchuserAction() method
     *
     *
     * @param  will not receive any argument
     *
     * @return will return a connection
     * @throws Does not throws any exception
     * @access public
     */

    
    public function searchuserAction(){

        $data = [ 'search' => 'search' , 'id' => 1 ];
        $client = new Client();
        $ServerPort ="";
        if($_SERVER['SERVER_PORT']){
            $ServerPort = ':'.$_SERVER['SERVER_PORT'];
        }
        $client->setUri('http://'.$_SERVER['SERVER_NAME'].$ServerPort.'/order-rest');
        $client->setOptions(array(
            'maxredirects' => 5,
            'timeout'      => 30
        ));
        $client->setParameterPost(
             $data
        );
        $client->setMethod( Request::METHOD_POST );
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = json_decode( $response->getContent() , true);
        }
        return $this->redirect()->toRoute('ordermanagement', array('action' => 'index')  );
    }
}
