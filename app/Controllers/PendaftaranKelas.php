<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\KonfirmasiModel;
use App\Models\PendaftaranKelasModel;
use App\Models\UserModel;

class PendaftaranKelas extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
        $this->pendaftaranKelasModel = new PendaftaranKelasModel();
        $this->konfirmasiModel = new KonfirmasiModel();
    }
    public function index($idKelas = null)
    {
        $dataCourse = $this->kelasModel->findAll();

        $data = array(
            'title'             => 'Pendaftaran Kelas',
            'dataCourses'       => $dataCourse,
            'selectedCourses'   => $idKelas,
        );
        return view('pendaftaran_kelas', $data);
    }

    public function daftar()
    {
        $kodePendaftaran = $this->pendaftaranKelasModel->getKodePendaftaran();
        $dataPendaftaran = [
            'id_pendaftaran'        => $kodePendaftaran,
            'id_kelas'              => $this->request->getVar('kelas'),
            'tanggal_pendaftaran'   => date('Y-m-d H:i:s'),
        ];

        $kodeKonfirmasi = $this->konfirmasiModel->getKodeKonfirmasi();
        $dataKonfirmasi = [
            'id_konfirmasi' => $kodeKonfirmasi,
            'id_pendaftaran' => $kodePendaftaran
        ];

        $this->pendaftaranKelasModel->insert($dataPendaftaran);
        $this->konfirmasiModel->insert($dataKonfirmasi);

        $dataUser = [
            'id_pendaftaran'    => $kodePendaftaran,
        ];
        $this->userModel->update($this->userModel->find(session()->get('id_user')), $dataUser);
        return redirect()->to(base_url('invoice/' . $kodeKonfirmasi));
    }
}
