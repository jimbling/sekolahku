<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Str;


class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('students')->delete();
        // Optional: kosongkan dulu tabelnya

        $students = [
            ['Afila Oktavia Dewi', 1378, 'P', 'Kulon Progo', '2013-10-20'],
            ['Alatif Pradana Wijaya', 1379, 'L', 'Kulon Progo', '2013-06-18'],
            ['Anis Zarifah Ramadhani', 1380, 'P', 'Kulon Progo', '2013-07-17'],
            ['Ardyka Nur Zanuariyanta', 1381, 'L', 'Kulon Progo', '2013-01-17'],
            ['Arkhreza Fa\'Iza Rifki', 1382, 'L', 'Kulon Progo', '2013-05-24'],
            ['Izzatin Nifsa', 1383, 'P', 'Kulon Progo', '2013-05-14'],
            ['Muhammad Afif Muhyi', 1384, 'L', 'Tangerang', '2013-05-05'],
            ['Rr. Rosyana Dewi Anggraeni', 1385, 'P', 'Kulon Progo', '2013-08-20'],
            ['Safana Dwita Putri', 1386, 'P', 'Jakarta', '2013-01-20'],
            ['Alvaro Prawira Putro Santoso', 1369, 'L', 'Kulon Progo', '2012-09-27'],
            ['Andhika Martino', 1370, 'L', 'Kulon Progo', '2012-03-30'],
            ['Fajar Nofriyanto', 1371, 'L', 'Kulon Progo', '2012-11-09'],
            ['Gilang Radinka Timur', 1372, 'L', 'Kulon Progo', '2013-04-27'],
            ['Naoval Ardhi Firmansyah', 1373, 'L', 'Kulon Progo', '2012-07-01'],
            ['Puji Rahayu', 1374, 'P', 'Kulon Progo', '2012-11-24'],
            ['Radhika Aditama Pranaja', 1375, 'L', 'Samarinda', '2012-05-29'],
            ['Rima Hayuk Lestari', 1376, 'P', 'Kulonprogo', '2012-09-20'],
            ['Yusuf Nur Muhammad', 1377, 'L', 'Kulon Progo', '2012-08-03'],
            ['Alfiano Chello Pranata', 1354, 'L', 'Kulon Progo', '2012-03-22'],
            ['Alfino Reifan Althafarsya', 1368, 'L', 'Banjarbaru', '2011-06-13'],
            ['Alif Fathurrahman', 1355, 'L', 'Kulon Progo', '2011-07-14'],
            ['Anas \'Aunur Rofiq', 1356, 'L', 'Kulon Progo', '2011-07-14'],
            ['Annisa Nur Fadilla', 1357, 'P', 'Jakarta', '2010-12-05'],
            ['Bagas Mahardika Latif', 1358, 'L', 'Kulon Progo', '2011-07-05'],
            ['Halimah Nur Aini', 1359, 'P', 'Kulon Progo', '2011-04-20'],
            ['Khalisa Rilis Zaneti', 1360, 'P', 'Kulon Progo', '2012-01-14'],
            ['Melysa Kurniawati', 1361, 'P', 'Kulon Progo', '2011-05-16'],
            ['Muhammad Dzaki Nurhafidh', 1362, 'L', 'Kulon Progo', '2011-05-13'],
            ['Novita Nur Azizah', 1363, 'P', 'Kulon Progo', '2011-11-29'],
            ['Rafka Julian Pratama', 1364, 'L', 'Kulon Progo', '2011-07-30'],
            ['Rahmat Irfan Assidiqi', 1365, 'L', 'Kulon Progo', '2011-04-20'],
            ['Selfiana Dyah Purwitasari', 1366, 'P', 'Kulon Progo', '2011-06-27'],
            ['Wahidun Nina Anisazahra', 1367, 'P', 'Kulon Progo', '2011-09-29'],
            ['Aprilana Azizah Indriyani', 1342, 'L', 'Kulon Progo', '2010-04-13'],
            ['Aruna Palupi', 1343, 'P', 'Kulon Progo', '2010-11-10'],
            ['Bagas Fajar Aprilian', 1345, 'L', 'Kulon Progo', '2010-04-17'],
            ['Bening Banyu Biru', 1344, 'L', 'Kulon Progo', '2010-09-19'],
            ['Elly Yully Ana', 1346, 'P', 'Kulon Progo', '2010-07-27'],
            ['Faisal Setiawan', 1347, 'L', 'Kulon Progo', '2010-11-05'],
            ['Isnaini Puji Astuti', 1348, 'P', 'Kulon Progo', '2010-01-01'],
            ['Maulinda Dwi Febriyanti', 1349, 'P', 'Kulon Progo', '2011-02-23'],
            ['Melan Nijananda Samson', 1350, 'P', 'Kulon Progo', '2010-08-14'],
            ['Octafiany Putri Lestari', 1351, 'P', 'Kulon Progo', '2010-10-16'],
            ['Vita Nur Anggraini', 1352, 'P', 'Kulon Progo', '2011-04-28'],
            ['Zya Nada Afifah', 1353, 'P', 'Kulon Progo', '2010-03-14'],
            ['Afwan Irsyad', 1328, 'L', 'Kulon Progo', '2009-11-23'],
            ['Ayu Endang Fatmawati', 1302, 'P', 'Kulon Progo', '2007-07-12'],
            ['Farhan Adi Setyawan', 1331, 'L', 'Kulon Progo', '2009-10-07'],
            ['Laras Dwi Suryani', 1332, 'P', 'Kulon Progo', '2010-07-09'],
            ['Nova Rista Dian Faizela', 1333, 'P', 'Kulon Progo', '2009-11-08'],
            ['Rasya Oney Ardiansyah', 1334, 'L', 'Kulon Progo', '2009-09-22'],
            ['Vita Dian Nur Akhsani', 1335, 'P', 'Kulon Progo', '2010-02-15'],
            ['Wardah Nur Hafidzah', 1336, 'P', 'Kulon Progo', '2009-09-12'],
            ['Annisa Miftahul Janah', 1315, 'P', 'Kulon Progo', '2007-08-07'],
            ['Ardyarti Latif Utami', 1300, 'P', 'Kulon Progo', '2007-03-01'],
            ['Ariel Faizal Akbar', 1309, 'L', 'Kulon Progo', '2008-02-19'],
            ['Deta Cahyani', 1316, 'P', 'Kulon Progo', '2008-04-23'],
            ['Fiqian Tri Mahesa', 1322, 'L', 'Kulon Progo', '2009-01-09'],
            ['Hanifah Nur Fitriani', 1321, 'P', 'Bandung', '2008-10-10'],
            ['Isnaini Nur Hudzaifah', 1317, 'P', 'Cimahi', '2008-06-02'],
            ['Kesya Revi Erfina', 1324, 'P', 'Kulon Progo', '2009-06-24'],
            ['Labita Selviona', 1323, 'P', 'Kulon Progo', '2009-01-24'],
            ['Mahmud Jabaludin', 1308, 'L', 'Kulon Progo', '2008-01-20'],
            ['Nahla Rasti Puspitasari', 1320, 'P', 'Kulon Progo', '2008-09-24'],
            ['Rido Ramadhani', 1319, 'L', 'Kulon Progo', '2008-09-12'],
            ['Rizka Sasha Aulia', 1318, 'P', 'Kulon Progo', '2008-07-20'],
            ['Sinta Oktafiani', 1338, 'P', 'Kulon Progo', '2008-10-28'],
        ];

        $data = collect($students)->map(function ($s) {
            return [
                'name' => $s[0],
                'nis' => $s[1],
                'gender' => $s[2],
                'birth_place' => $s[3],
                'birth_date' => $s[4],
                'email' => Str::slug($s[0], '.') . '@sdnkedungrejo.sch.id',
                'student_status_id' => 1,
                'end_date' => null,
                'reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        Student::insert($data->toArray());
    }
}
