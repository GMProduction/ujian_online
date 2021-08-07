<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends CustomController
{
    //

    public function register(Request $r)
    {

        if ($r->get('id')) {
            $username = User::where([['username', '=', $r->get('username')], ['id', '!=', $r->get('id')]])->first();
            if ($username) {
                return response()->json(
                    [
                        "msg" => "The username has already been taken.",
                    ],
                    '201'
                );
            }
            $field = $r->validate(
                [
                    'nama'     => 'required|string',
                    'password' => 'required|string|confirmed',
                ]
            );

            $user = User::find($r->get('id'));
            $user->update(
                [
                    'username' => $r->get('username'),
                ]
            );
            if (strpos($r->get('password'), '*') === false) {
                $user->update(
                    [
                        'password' => Hash::make($field['password']),
                    ]
                );
            }
        } else {
            $field = $r->validate(
                [
                    'nama'     => 'required|string',
                    'username' => 'required|string|unique:users,username',
                    'password' => 'required|string|confirmed',
                ]
            );

            $user = User::create(
                [
                    'username' => $field['username'],
                    'password' => Hash::make($field['password']),
                    'roles'    => $r->get('roles') == '' ? 'siswa' : $r->get('roles'),
                ]
            );
        }

        $response = [
            'user' => $user,
        ];

        $model = 'Admin';

        if ( ! $r->get('roles')) {
            $model    = 'Siswa';
            $token    = $user->createToken('appsiswa')->plainTextToken;
            $response = Arr::add($response, 'token', $token);
            $us       = User::find($user->id);
            $us->update(
                [
                    'token' => $token,
                ]
            );
        } elseif ($r->get('roles') === 'guru') {
            $model    = 'Guru';
            $token    = $user->createToken('appguru')->plainTextToken;
            $response = Arr::add($response, 'token', $token);
            $us       = User::find($user->id);
            $us->update(
                [
                    'token' => $token,
                ]
            );
        }

        $models = '\\App\\Models\\'.$model;
        if ($model == 'Siswa') {
            if ($r->get('id')) {
                $member = $models::where('id_user', '=', $user->id)->first();
                $member->update(
                    [
                        'nama'   => $r->get('nama'),
                        'alamat' => $r->get('alamat'),
                        'kelas'  => $r->get('kelas'),
                        'no_hp'  => $r->get('no_hp'),
                    ]
                );
            } else {
                $member = $models::create(
                    [
                        'id_user' => $user->id,
                        'nama'    => $r->get('nama'),
                        'alamat'  => $r->get('alamat'),
                        'kelas'   => $r->get('kelas'),
                        'no_hp'   => $r->get('no_hp'),
                    ]
                );
            }
        } else {
            if ($r->get('id')) {
                $member = $models::where('id_user', '=', $user->id)->first();
                $member->update(
                    [
                        'nama'   => $r->get('nama'),
                        'alamat' => $r->get('alamat'),
                        'no_hp'  => $r->get('no_hp'),
                    ]
                );
            } else {
                $member = $models::create(
                    [
                        'id_user' => $user->id,
                        'nama'    => $r->get('nama'),
                        'alamat'  => $r->get('alamat'),
                        'no_hp'   => $r->get('no_hp'),
                    ]
                );
            }
        }

        $response = Arr::add($response, 'member', $member);

//        array_push($response,$model);
        return $response;

    }

    public function login(Request $r)
    {

        if ($r->isMethod('POST')) {
            $field = $r->validate(
                [
                    'username' => 'required|string',
                    'password' => 'required|string',
                ]
            );

            $user = User::where('username', $field['username'])->first();
            $uri  = $_SERVER['REQUEST_URI'];
            if ( ! $user || ! Hash::check($field['password'], $user->password) || $user->roles == 'admin') {
//            throw ValidationException::withMessages([
//                'username' => ['The provided credentials are incorrect.'],
//            ]);
                if (strpos($uri, 'api')) {
                    return response()->json(
                        [
                            'msg' => 'Login gagal',
                        ],
                        401
                    );
                } else {
                    $data = [
                        'msg' => 'Login gagal',
                    ];

                    return Redirect::back()->withErrors($data);

                }
            }
            if (strpos($uri, 'api')) {

                $user->tokens()->delete();
                $token = $user->createToken('app'.$user->roles)->plainTextToken;
                $user->update(
                    [
                        'token' => $token,
                    ]
                );

//            return ;
                return response()->json(
                    [
                        'status' => 200,
                        'msg'    => $token,
                    ]
                );

            } else {
//                return view('admin.dashboard');
            }
        }

        return view('login');

    }

    /**
     * @param Request $r
     *
     * @return string[]
     */
    public function logout(Request $r)
    {
        $us = User::find(Auth::user()->id);
        $us->update(
            [
                'token' => null,
            ]
        );
        Auth::user()->tokens()->delete();

        return [
            'message' => 'loged out',
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginAdmin(Request $request)
    {
        if ($request->isMethod('POST')) {

            $credentials = [
                'username' => $request['username'],
                'password' => $request['password'],
            ];
            if ($this->isAuth($credentials)) {
                if (Auth::user()->roles == 'admin') {
                    $redirect = '/admin';
                }elseif (Auth::user()->roles == 'guru') {
                    $redirect = '/guru';
                }

                return redirect($redirect);
            }

            return redirect()->back()->withInput()->with('failed', 'Periksa Kembali Username dan Password Anda');
        }

        return view('login');

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logoutAdmin()
    {
        Auth::logout();

        return redirect('/');
    }
}
