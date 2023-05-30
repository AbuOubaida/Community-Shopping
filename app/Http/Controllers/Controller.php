<?php

namespace App\Http\Controllers;

use App\Rules\Html;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $html = null;
    public function htmlValidator()//Rule for check html spatial character
    {
        $this->html = new Html();
    }
    public function test()
    {
        return 'Test';
    }
}
