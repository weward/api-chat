<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Admin\RegisterRepository;


class RegisterController extends Controller
{
    protected $repo;

    public function __construct(RegisterRepository $repo)
    {
        $this->repo = $repo;
    }

    public function register(RegisterRequest $request)
    {
        if ($this->repo->register($request)) {
            return response()->json(
                'Successfully registered. Check your email for verification.', 
                200
            );
        }

        return response()->json(
            'Failed to register.',
            500
        );
    }

    /**
     * Verify User
     * 
     * @param  int $id
     * @param  string $hash
     * 
     * @return null
     */
    public function verify($id, $hash)
    {
        if (sha1($id) != $hash) {
            return redirect()->away(env('FRONTEND_APP_URL').'/404');
        }

        if ($this->repo->verify($id)) {
            return redirect()->away(env('FRONTEND_APP_URL').'/login');
        }

        return redirect()->away(env('FRONTEND_APP_URL').'/404');
    }
}
