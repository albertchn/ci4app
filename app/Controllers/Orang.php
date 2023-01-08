<?php

namespace App\Controllers;

use App\Models\OrangModel;

class Orang extends BaseController
{
    protected $orangModel;
    public function __construct()
    {
        $this->orangModel = new OrangModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;

        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $orang = $this->orangModel->search($keyword);
        } else {
            $orang = $this->orangModel;
        }

        $batalData = 10;
        $data = [
            'title' => 'Daftar Orang',
            // 'orang' => $this->orangModel->findAll()
            'orang' => $orang->paginate($batalData, 'orang'),
            'pager' => $this->orangModel->pager,
            'currentPage' => $currentPage,
            'batasData' => $batalData
        ];

        return view('/orang/index', $data);
    }

    public function export()
    {
        $data = [
            'title' => 'Export Data',
            'orang' => $this->orangModel->findAll()
        ];

        $mpdf = new \Mpdf\Mpdf();

        // $html = view('/orang/export', $data);
        $i = 1;
        $html = '
            <html lang="en">
            
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>' . $data['title'] . '</title>
            </head>
            <body>
                <div class="container">
                    <div class="row my-2">
                            <div class="col">
                                <h1 style="text-align:center;">Daftar Orang</h1>
                                <table border="1" cellpadding="10" cellspacing="0" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;" scope="col">No.</th>
                                            <th style="width: 300px;" scope="col">Nama</th>
                                            <th style="width: 300px;" scope="col">Alamat</th>
                                        </tr>
                                    </thead>';
        foreach ($data['orang'] as $o) {
            $html .= '
                <tr>
                    <th style="vertical-align: center;" scope="row">' . $i++ . '</th>
                    <td style="vertical-align: center;">' . $o['nama'] . '</td>
                    <td style="vertical-align: center;">' . $o['alamat'] . '</td>
                </tr>
            ';
        }
        $html .= '</table>
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ';
        $mpdf->WriteHTML($html);
        $mpdf->Output('Data_Orang_' . date('d-M-Y') . '.pdf', 'D');
    }
}
