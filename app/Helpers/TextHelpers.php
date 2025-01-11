<?php

namespace App\Helpers;

class TextHelpers {
    public static function splitText($text, $maxLength = 40) {
        $words = explode(' ', $text);
        $result = '';
        $line = '';

        foreach ($words as $word) {
            // Cek apakah menambahkan kata berikutnya melebihi panjang maksimum
            if (strlen($line . ' ' . $word) > $maxLength) {
                $result .= trim($line) . "<br/>"; // Tambahkan garis baru
                $line = $word; // Mulai baris baru dengan kata ini
            } else {
                $line .= ' ' . $word; // Tambahkan kata ke baris saat ini
            }
        }

        // Tambahkan baris terakhir jika ada
        if ($line) {
            $result .= trim($line);
        }

        return $result;
    }

    // Fungsi untuk menghasilkan warna berdasarkan nama
    public static function getColorFromName($name) {
        // Menghasilkan nilai hash dari nama
        $hash = crc32($name);
        // Menghasilkan hue dari 0-360
        $hue = $hash % 360; // Menggunakan modulus untuk mendapatkan hue

        // Menggunakan HSL untuk menghasilkan warna
        return "hsl($hue, 70%, 50%)"; // Saturation 70%, Lightness 50%
    }
}
