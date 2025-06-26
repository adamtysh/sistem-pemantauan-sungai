<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the settings menu page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Data yang akan dikirim ke view
        $data['page_title'] = 'Pengaturan Sistem';

        // Mengarahkan ke file view 'settings.menu'
        return view('settings.menu', $data);
    }
}
