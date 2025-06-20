<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            'auth' => [
                'user' => function() {
                    if (Auth::check()) {
                        $user = Auth::user();
                        $userArray = $user->toArray();  //(array)$user;
                        $userArray['role'] = $user->role->name;
                        $userArray['permissions'] = $user->role->permissions->pluck('name');

                        return $userArray;
                    }
                }
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'color' => fn () => $request->session()->get('color'),
            ]
        ];
    }
}
