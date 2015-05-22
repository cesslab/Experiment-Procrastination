<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\View\Forms\ThreeTaskPenaltyTreatmentForm;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use \Slim\Slim;

class SessionController
{
    /**
     * Get request handler.
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(SessionMap::toTemplate(),$app->flashData());
    }

    /**
     * Post request handler.
     */
    public function post()
    {
        $app = Slim::getInstance();

        $sessionForm = new ThreeTaskPenaltyTreatmentForm($app->request->post());
        if ($sessionForm->validate()) {
            $sessionForm->storeSession();
            $responseUri = DashboardMap::toUri();
        }
        else {
            $app->flash('flash', $sessionForm->getEntriesWithErrors());
            $responseUri = SessionMap::toUri();
        }

        $app->redirect($responseUri);
    }
}