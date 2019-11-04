<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 04.11.19
 * Time: 10:52
 */
namespace Controllers;

use Phalcon\Mvc\Controller;
use Library\Api\Document as DocumentApi;
use Library\Exception\DocumentCreateException;
use Library\Exception\DocumentStatusException;
use Library\Exception\DocumentUpdateException;

class ApiController extends Controller
{
    const LIMIT = 20;

    public function getDocumentAction($id)
    {
        $DocumentApi = new DocumentApi($id);

        return json_encode($DocumentApi->getRecord());
    }

    public function getListAction()
    {
        $page = $this->request->getQuery('page', 'int', 1);
        $perPage = $this->request->getQuery('perPage', 'int', self::LIMIT);

        return json_encode(DocumentApi::getRecordsList($page, $perPage));
    }

    public function addAction()
    {
        $content = $this->request->getRawBody();

        try {
            $DocumentApi = DocumentApi::addRecord(json_decode($content, true));
        } catch (DocumentCreateException $e) {
            return json_encode(['result' => false, 'comment' => $e->getMessage()]);
        }

        return json_encode($DocumentApi->getRecord());
    }

    public function editAction($id)
    {
        $content = $this->request->getRawBody();

        $DocumentApi = new DocumentApi($id);
        try {
            $DocumentApi->update(json_decode($content, true));
        } catch (DocumentUpdateException $e) {
            return json_encode(['result' => false, 'comment' => $e->getMessage()]);
        }

        return json_encode($DocumentApi->getRecord());
    }

    public function publishAction($id)
    {
        $DocumentApi = new DocumentApi($id);
        try {
            $DocumentApi->publish();
        } catch (DocumentStatusException $e) {
            return json_encode(['result' => false, 'comment' => $e->getMessage()]);
        }

        return json_encode($DocumentApi->getRecord());
    }
}
