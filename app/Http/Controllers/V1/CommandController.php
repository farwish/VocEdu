<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    public function packageListOnCheck()
    {
        $exitCode = Artisan::call('voc-package:list-on-check');

        return ($exitCode == 0) ? $this->success() : $this->failure();
    }

    public function packageListOffCheck()
    {
        $exitCode = Artisan::call('voc-package:list-off-check');

        return ($exitCode == 0) ? $this->success() : $this->failure();
    }
}
