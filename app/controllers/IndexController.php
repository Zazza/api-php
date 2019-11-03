<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 26.06.18
 * Time: 8:14
 */
namespace Controllers;

use Library\User\User;
use Phalcon\Mvc\Url;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        if (!$this->User) {
            $this->response->redirect('/session/login');
        } else {
            $Url = new Url();

            if ($this->User->getRvUsersAdmin()) {
                $redirectURL = $Url->get('/admin/logs');

                return $this->response->redirect($redirectURL);
            }

            if (!$this->User->getRvUsersLastAction()) {
                $redirectURL = $Url->get('/campaign');

                return $this->response->redirect($redirectURL);
            }

            switch ($this->User->getRvUsersLastAction()->action) {
                case User::ACTION_ADVERTISER:
                    $redirectURL = $Url->get('/campaign');
                    break;
                case User::ACTION_WEBMASTER:
                    $redirectURL = $Url->get('/website');
                    break;
                default:
                    $redirectURL = $Url->get('/campaign');
            }

            return $this->response->redirect($redirectURL);
        }
    }

    public function notfoundAction()
    {
        return $this->view->pick('template/404');
    }
}

