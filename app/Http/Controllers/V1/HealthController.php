<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

class HealthController extends Controller
{
    // /api/v1/health/status
    public function status()
    {
        return 200;
    }
}
