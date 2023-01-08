<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        // $komik = $this->komikModel->findAll();
        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];

        // cara manual query db
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // // dd($komik);
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }

        // $komikModel = new \App\Models\KomikModel(); // lengkapnya tanpa use
        // $komikModel = new KomikModel();
        // $komik = $this->komikModel->findAll();
        // dd($komik);

        return view('/komik/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // jika komik tidak titemukan
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan!');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        // session(); // sudah autostart karena ditaro di basecontroller
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.'
                ]
            ],
            'sampul' => [
                // 'rules' => 'uploaded[sampul]|max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar sampul terlebih dahulu.',
                    'max_size' => 'Ukuran gambar terlalu beesar.',
                    'is_image' => 'Yang anda pilih bukan gambar.',
                    'mime_in' => 'Yang anda pilih bukan gambar.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // dd($validation);
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // dd($fileSampul);

        // cek apakah tidak ada gambar
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'naruto.jpg';
        } else {
            // ambil nama file
            // $namaSampul = $fileSampul->getName();
            // generate nama random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan file (function move langsung mengarah ke folder public)
            $fileSampul->move('img', $namaSampul);
            // $fileSampul->move('img');
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // ambil nama sampul
        $komik = $this->komikModel->find($id);

        // cek apakah menggunakan gambar default
        if ($komik['sampul'] != 'naruto.jpg') {
            // hapus gambar di local storage
            unlink('img/' . $komik['sampul']);
        }


        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        // dd($this->request->getVar());
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            // dd($validation);
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        $fileSampul = $this->request->getFile('sampul');

        //cek gambar apakah berubah
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate random nama sampul
            $namaSampul = $fileSampul->getRandomName();

            // pindah file sampul
            $fileSampul->move('img', $namaSampul);

            // hapus file lama
            // cek apakah sampulnya default atau engga
            if ($this->request->getVar('sampul') != 'naruto.jpg') {
                if (!empty($this->request->getVar('sampulLama'))) {
                    unlink('img/' . $this->request->getVar('sampulLama'));
                }
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/komik');
    }
}
