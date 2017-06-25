<?php
namespace Apiordermanagement\Exceptions;


class Exceptions{
    
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

    
}