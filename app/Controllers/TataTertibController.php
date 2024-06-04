<?php

namespace App\Controllers;

use App\Models\TataTertibModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Ramsey\Uuid\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class TataTertibController extends BaseController
{
    protected $tataTertibModel;


    public function __construct()
    {
        $this->tataTertibModel = new TataTertibModel;
    }

    public function index(): string
    {
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $tata_tertib = $this->tataTertibModel->search($keyword);
        } else {
            $tata_tertib = $this->tataTertibModel;
        }

        $data = [
            'title' => 'Tata Tertib Siswa',
            'tata_tertib' => $tata_tertib->paginate(10, 'tata_tertib'),
            'pager' => $tata_tertib->pager
        ];

        return view('pages/settings/tata_tertib', $data);
    }

    public function delete($id)
    {
        try {
            $this->tataTertibModel->delete($id);
            return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            if ($e->getCode() == 1451) {
                // Jika terjadi kesalahan karena kunci asing
                return redirect()->to('/settings/tata-tertib')->with('error', 'Tidak dapat menghapus data. data tersebut sudah digunakan di tempat lain.');
            } else {
                // Jika terjadi kesalahan lain
                return redirect()->to('/settings/tata-tertib')->with('error', 'Gagal menghapus data.');
            }
        }
    }

    public function insert()
    {
        // Validasi Data Yang Masuk
        $validationRules = [
            'kategori' => 'required',
            'keterangan' => 'required',
            'type' => 'required',
            'poin' => 'required|numeric'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // Tetapkan ID secara otomatis menggunakan uuid ci4
        $uuid = Uuid::uuid4()->toString();

        // Ambil data dari request
        $kategori = $this->request->getPost('kategori');
        $keterangan = $this->request->getPost('keterangan');
        $type = $this->request->getPost('type');
        $poin = $this->request->getPost('poin');

        // Insert data kedalam database
        $data = [
            'id' => $uuid,
            'kategori' => $kategori,
            'keterangan' => $keterangan,
            'type' => $type,
            'poin' => $poin,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ];

        try {
            $this->tataTertibModel->insert($data);
            return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil ditambahkan.');
        } catch (DatabaseException $e) {
            $error_message = "Tidak dapat menambahkan data";
            return redirect()->to('/settings/tata-tertib')->with('error', $error_message);
        }
    }

    public function update(string $id)
    {
        try {
            // Validasi input dari form
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'kategori' => 'required',
                'keterangan' => 'required',
                'type' => 'required',
                'poin' => 'required|numeric'
            ]);

            // Jalankan validasi
            if (!$validation->withRequest($this->request)->run()) {
                // Jika validasi gagal, kirimkan pesan kesalahan
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Ambil data dari form
            $data = [
                'kategori' => $this->request->getPost('kategori'),
                'keterangan' => $this->request->getPost('keterangan'),
                'type' => $this->request->getPost('type'),
                'poin' => $this->request->getPost('poin'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            // Lakukan pembaruan data di sini
            $this->tataTertibModel->update($id, $data);

            return redirect()->to('/settings/tata-tertib')->with('success', 'Data berhasil diperbarui.');
        } catch (DatabaseException $e) {
            // Tangani kesalahan saat memperbarui data
            if ($e->getCode() == 1451) {
                // Jika terjadi kesalahan karena kunci asing
                return redirect()->to('/settings/tata-tertib')->with('error', 'Gagal memperbarui data. Kategori tersebut sudah digunakan di tempat lain.');
            } else {
                // Jika terjadi kesalahan lain
                return redirect()->to('/settings/tata-tertib')->with('error', 'Gagal memperbarui data.');
            }
        }
    }

    public function export()
    {
        $tataTertib = $this->tataTertibModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['ID', 'Keterangan', 'Kategori', 'Poin', 'Type'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Styling header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFE599');
        $sheet->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Data
        $row = 2;
        foreach ($tataTertib as $tt) {
            $sheet->setCellValue('A' . $row, $tt['id']);
            $sheet->setCellValue('B' . $row, $tt['keterangan']);
            $sheet->setCellValue('C' . $row, $tt['kategori']);
            $sheet->setCellValue('D' . $row, $tt['poin']);
            $sheet->setCellValue('E' . $row, $tt['type']);

            // Styling data rows
            $sheet->getStyle('A' . $row . ':E' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $row++;
        }

        // Set column widths
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_tata_tertib.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
