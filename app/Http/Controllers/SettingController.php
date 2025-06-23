<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Pengaturan';
        return view('settings.index', $data);
    }
    
    public function sensor()
    {
        $data['page_title'] = 'Pengaturan Sensor';
        return view('settings.index', $data);
    }
    
    public function alarm()
    {
        $data['page_title'] = 'Pengaturan Alarm';
        return view('settings.index', $data);
    }

}
