<?php

namespace App\Domain\Shared\Helpers;

class Terbilang
{
    private $nilai;

    /**
     * @param $nilai
     */
    public function __construct($nilai)
    {
        $this->nilai = $nilai;
    }

    private function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf =
            ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        $temp = '';

        if ($nilai < 12) {
            $temp = ' ' . $huruf[$nilai];
        } elseif ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . ' belas';
        } elseif ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . ' puluh' . $this->penyebut($nilai % 10);
        } elseif ($nilai < 200) {
            $temp = ' seratus' . $this->penyebut($nilai - 100);
        } elseif ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . ' ratus' . $this->penyebut($nilai % 100);
        } elseif ($nilai < 2000) {
            $temp = ' seribu' . $this->penyebut($nilai - 1000);
        } elseif ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . ' ribu' . $this->penyebut($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . ' juta' . $this->penyebut($nilai % 1000000);
        } elseif ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . ' milyar' . $this->penyebut(fmod($nilai, 1000000000));
        } elseif ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . ' trilyun' . $this->penyebut(fmod($nilai, 1000000000000));
        }

        return $temp;
    }

    public function toString()
    {
        if ($this->nilai < 0) {
            return 'minus ' . trim($this->penyebut($this->nilai));
        }

        return trim($this->penyebut($this->nilai));
    }
}
