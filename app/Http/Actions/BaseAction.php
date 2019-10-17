<?php

namespace App\Http\Actions;

use Laravel\Lumen\Routing\Controller;

abstract class BaseAction extends Controller
{
    public const HTTP_OK = 200;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    /** @var array */
    private $responseData = [];


}
