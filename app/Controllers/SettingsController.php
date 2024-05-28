<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\TataTertibModel;

class SettingsController extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $tataTertibModel;


    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->tataTertibModel = new TataTertibModel;
        helper('date');
    }



    public function guru(): string
    {
        $guru = $this->guruModel->findAll();

        $data = [
            'title' => 'Settings Data Guru',
            'guru' => $guru
        ];


        return view('pages/settings/guru', $data);
    }
}
