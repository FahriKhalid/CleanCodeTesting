<?php

namespace Tests\Unit;

use App\Domain\Shared\Helpers\Terbilang;
use Tests\TestCase;

class TerbilangTest extends TestCase
{
    public function testOne()
    {
        $terbilang = new Terbilang(1);
        $this->assertEquals('satu', $terbilang->toString());
    }

    public function testTen()
    {
        $terbilang = new Terbilang(10);
        $this->assertEquals('sepuluh', $terbilang->toString());
    }

    public function testEleven()
    {
        $terbilang = new Terbilang(11);
        $this->assertEquals('sebelas', $terbilang->toString());
    }

    public function testTwelve()
    {
        $terbilang = new Terbilang(12);
        $this->assertEquals('dua belas', $terbilang->toString());
    }

    public function testTwenty()
    {
        $terbilang = new Terbilang(20);
        $this->assertEquals('dua puluh', $terbilang->toString());
    }

    public function testTwentyOne()
    {
        $terbilang = new Terbilang(21);
        $this->assertEquals('dua puluh satu', $terbilang->toString());
    }

    public function testHundred()
    {
        $terbilang = new Terbilang(100);
        $this->assertEquals('seratus', $terbilang->toString());
    }

    public function testHundredAndOne()
    {
        $terbilang = new Terbilang(101);
        $this->assertEquals('seratus satu', $terbilang->toString());
    }

    public function testThousand()
    {
        $terbilang = new Terbilang(1000);
        $this->assertEquals('seribu', $terbilang->toString());
    }

    public function testThousandAndOne()
    {
        $terbilang = new Terbilang(1001);
        $this->assertEquals('seribu satu', $terbilang->toString());
    }

    public function testMillion()
    {
        $terbilang = new Terbilang(1000000);
        $this->assertEquals('satu juta', $terbilang->toString());
    }

    public function testBillion()
    {
        $terbilang = new Terbilang(1000000000);
        $this->assertEquals('satu milyar', $terbilang->toString());
    }

    public function testTrillion()
    {
        $terbilang = new Terbilang(1000000000000);
        $this->assertEquals('satu trilyun', $terbilang->toString());
    }

    public function testNegativeNumber()
    {
        $terbilang = new Terbilang(-500);
        $this->assertEquals('minus lima ratus', $terbilang->toString());
    }

    public function testLargeNumber()
    {
        $terbilang = new Terbilang(1234567890123);
        $this->assertEquals('satu trilyun dua ratus tiga puluh empat milyar lima ratus enam puluh tujuh juta delapan ratus sembilan puluh ribu seratus dua puluh tiga', $terbilang->toString());
    }

    public function testZero()
    {
        $terbilang = new Terbilang(0);
        $this->assertEquals('nol', $terbilang->toString());
    }

    // Test for negative numbers
    public function testMinus()
    {
        // Test negative numbers
        $terbilang = new Terbilang(-1000);
        $this->assertEquals('minus seribu', $terbilang->toString());
    }
}
