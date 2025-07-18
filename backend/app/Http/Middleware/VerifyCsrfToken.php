<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**   
     *
     * @var array<int,string>
     */
    protected $except = [
        'api/*',  
    ];
}
