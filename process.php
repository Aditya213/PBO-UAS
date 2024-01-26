<?php
class Kambing
{
    public $nama;
    public $berat;
    public $tinggi;
    public $panjang;
    public $perkembanganList = [];

    public function __construct($nama, $berat_awal, $tinggi_awal, $panjang_awal)
    {
        $this->nama = $nama;
        $this->berat = $berat_awal;
        $this->tinggi = $tinggi_awal;
        $this->panjang = $panjang_awal;
    }

    public function tambahPerkembangan($perkembangan, $jumlah_bulan)
    {
        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $this->berat += $perkembangan;
            $this->tinggi += $perkembangan;
            $this->panjang += $perkembangan;

            $bulan = date('F', strtotime("+$i months"));

            $this->perkembanganList[$bulan] = [
                'berat' => $this->berat,
                'tinggi' => $this->tinggi,
                'panjang' => $this->panjang
            ];
        }
    }
}

class Peternakan
{
    public $namaPeternak;
    public $kambingList = [];

    public function __construct($namaPeternak)
    {
        $this->namaPeternak = $namaPeternak;
    }

    public function tambahKambing(Kambing $kambing)
    {
        $this->kambingList[] = $kambing;
    }

    public function tampilkanInfoPeternak()
    {
        $response_array['result_nama_peternak'] = $this->namaPeternak;
        $response_array['result_kambing_list'] = [];

        foreach ($this->kambingList as $kambing) {
            $response_per_kambing = [
                'result_nama_kambing' => $kambing->nama,
                'perkembangan_list' => $kambing->perkembanganList
            ];

            $response_array['result_kambing_list'][] = $response_per_kambing;
        }

        return $response_array;
    }
}

if (
    isset($_POST['nama_kambing'], $_POST['berat_awal'], $_POST['tinggi_awal'], $_POST['panjang_awal'], $_POST['perkembangan_bulanan']) &&
    is_numeric($_POST['berat_awal']) &&
    is_numeric($_POST['tinggi_awal']) &&
    is_numeric($_POST['panjang_awal']) &&
    is_numeric($_POST['perkembangan_bulanan'])
) {
    $nama_kambing           = $_POST['nama_kambing'];
    $berat_awal             = $_POST['berat_awal'];
    $tinggi_awal            = $_POST['tinggi_awal'];
    $panjang_awal           = $_POST['panjang_awal'];
    $perkembangan_bulanan   = $_POST['perkembangan_bulanan'];
} else {
    echo json_encode(['error' => 'Invalid input.']);
    exit; // Hentikan eksekusi jika input tidak valid
}

$kambing1 = new Kambing($nama_kambing, $berat_awal, $tinggi_awal, $panjang_awal);
$kambing1->tambahPerkembangan($perkembangan_bulanan, 5); // Tambah perkembangan selama 5 bulan

$peternakan_pak_slamet = new Peternakan("Pak Haji Slamet");
$peternakan_pak_slamet->tambahKambing($kambing1);
$result = $peternakan_pak_slamet->tampilkanInfoPeternak();

header('Content-Type: application/json');
echo json_encode($result);
