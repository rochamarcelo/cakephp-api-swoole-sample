<?php

namespace App\Service;

use Cake\Routing\RouteBuilder;
use CakeDC\Api\Service\Action\CrudIndexAction;
use CakeDC\Api\Service\FallbackService;
use CakeDC\Api\Service\Service;

class AppFallbackService extends FallbackService
{
    public function routerDefaultOptions(): array
    {
        $options = parent::routerDefaultOptions();
        $options['id'] = '[a-zA-Z]{2}';

        return $options;
    }

}
