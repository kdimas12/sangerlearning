<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use Irsyadulibad\DataTables\DataTables;

class AdminKelas extends BaseController
{
    public function __construct()
    {
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        return view('dashboard/kelas');
    }

    public function tambah()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama_kelas' => 'required'
        ]);

        $isDataValid = $validation->withRequest($this->request)->run();
        // jika data vlid, maka simpan ke database
        if ($isDataValid) {
            $dataKelas = [
                'id_kelas' => $this->request->getVar('id_kelas'),
                'nama_kelas' => $this->request->getVar('nama_kelas'),
                'id_jenis' => $this->request->getVar('id_jenis'),
                'ket_kelas' => $this->request->getVar('ket_kelas'),
                'harga' => $this->request->getVar('harga'),
            ];
            $this->kelasModel->insert($dataKelas);
            return redirect()->to(base_url('dashboard/kelas'));
        }
        echo view('dashboard/kelas_tambah');
    }

    public function edit($id)
    {
        $data['kelas'] = $this->kelasModel->where('id_kelas', $id)->first();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'nama_kelas' => 'required'
        ]);

        $isDataValid = $validation->withRequest($this->request)->run();
        // jika data vlid, maka simpan ke database
        if ($isDataValid) {
            $dataKelas = [
                'id_kelas' => $this->request->getVar('id_kelas'),
                'nama_kelas' => $this->request->getVar('nama_kelas'),
                'id_jenis' => $this->request->getVar('id_jenis'),
                'ket_kelas' => $this->request->getVar('ket_kelas'),
                'harga' => $this->request->getVar('harga'),
            ];
            $this->coursesModel->update($id, $dataKelas);
            return redirect()->to(base_url('dashboard/kelas'));
        }

        echo view('dashboard/kelas_edit', $data);
    }

    public function hapus($id)
    {
        $this->coursesModel->delete($id);
        return redirect('dashboard/kelas');
    }

    public function json()
    {
        return DataTables::use('tbl_kelas')->join('tbl_jenis_kelas', 'tbl_kelas.id_jenis = tbl_jenis_kelas.id_jenis', 'inner')->addColumn('action', function ($data) {
            $uriEdit = base_url() . '/dashboard/kelas/' . $data->id_kelas . '/edit';
            $uriHapus = base_url() . '/dashboard/kelas/' . $data->id_kelas . '/hapus';

            return '<a href="' . $uriEdit . '" class="btn btn-primary btn-sm">Edit</a> <a href="' . $uriHapus . '" class="btn btn-danger btn-sm">Hapus</a>';
        })->rawColumns(['action'])->make();
    }
}
