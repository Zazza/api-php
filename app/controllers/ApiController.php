<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 04.11.19
 * Time: 10:52
 */
namespace Controllers;

use Phalcon\Mvc\Controller;

class ApiController extends Controller
{
    public function getDocumentAction($id)
    {
        echo '!' . $id;
    }

    public function getListAction()
    {
        echo $this->request->getQuery('page') . ' ' . $this->request->getQuery('perPage');
    }

    public function addAction()
    {

    }

    public function editAction($id)
    {
        echo '!' . $id;
    }

    public function publishAction($id)
    {
        echo '!' . $id;
    }
}
