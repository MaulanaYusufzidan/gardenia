<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** Simpan tujuan setelah login/daftar bila ?next= berupa URL internal yang aman. */
    protected function rememberIntended(\Illuminate\Http\Request $request): void
    {
        $next = (string) $request->query('next', '');
        if ($next === '') {
            return;
        }
        $internalPath = str_starts_with($next, '/') && ! str_starts_with($next, '//');
        $sameHost     = parse_url($next, PHP_URL_HOST) === $request->getHost();
        if ($internalPath || $sameHost) {
            session()->put('url.intended', $next);
        }
    }
}
