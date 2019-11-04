<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 26.06.18
 * Time: 8:14
 */
namespace Controllers;

use MongoDB\Driver\Manager;
use Phalcon\Db\Adapter\MongoDB\Database;
use Phalcon\Mvc\Controller;

/**
 * Class IndexController
 * @package Controllers
 *
 * POST /api/v1/document/ - credting draft of the document
 * GET /api/v1/document/{id} - getting document by id
 * PATCH /api/v1/document/{id} - edit document
 * POST /api/v1/document/{id}/publish - publish document
 * GET /api/v1/document/?page=1&perPage=20 - get last document with pagination, sorting (new added are on the top)
 * If document is not found, 404 NOT Found must be returned
 * If document is already published, and user tries to update it, return 400.
 * Try to publish arelady published document should return 200
 * PATCH is sending in the body of JSON document, all fields except payload are ignored. If payload is not sent/defined, then return 400.
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        $Api = new \Models\Api();
        $Api->setPayload(['content' => 'data']);
        if (!$Api->save()) {
            print_r($Api->getMessages());
        }

        $ApiList = \Models\Api::find();
        /** @var \Models\Api $Api */
        foreach ($ApiList as $Api) {
            print_r($Api->toArray()); echo "<br>";
        }
    }
}
