<?php

return [
    'regex' => 'Format penulisan :Attribute tidak valid.',
    'digits' => ':attribute harus terdiri dari :digits digit.',
    'required' => ':Attribute harus diisi.',
    'email' => ':Attribute harus berupa alamat email yang valid.',
    'max' => [
        'numeric' => ':Attribute tidak boleh lebih dari :max.',
        'file'    => 'Ukuran file :Attribute terlalu besar. Silakan perkecil ukuran file terlebih dahulu.',
        'string'  => ':Attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':Attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'min' => [
        'numeric' => ':Attribute harus minimal :min.',
        'file'    => ':Attribute harus minimal :min kilobytes.',
        'string'  => ':Attribute harus minimal :min karakter.',
        'array'   => ':Attribute harus memiliki minimal :min item.',
    ],
    'confirmed' => 'Konfirmasi :Attribute tidak cocok.',
    'unique' => ':Attribute sudah digunakan.',
    'digits_between' => ':Attribute harus terdiri dari :min sampai :max digit.',
    'string' => ':Attribute harus berupa teks.',
    'boolean' => ':Attribute harus bernilai true atau false.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'date_format' => ':Attribute harus sesuai dengan format :format.',
    'numeric' => ':Attribute harus berupa angka.',
    'image' => ':Attribute harus berupa gambar (jpeg, png, atau jpg).',
    'file' => ':Attribute harus berupa file.',
    'mimes' => ':Attribute harus berupa file bertipe: :values.',
    'size' => [
        'string' => ':Attribute harus memiliki panjang :size karakter.',
    ],
    'in' => ':Attribute harus salah satu dari: :values.',
    'not_in' => ':Attribute yang dipilih tidak valid.',

    'custom' => [
        'nik' => [
            'different' => 'NIK anak tidak boleh sama dengan NIK orang tua.',
        ],
        'ttl' => [
            'different' => 'Tempat, tanggal lahir anak tidak boleh sama dengan orang tua.',
        ],
    ],

    'attributes' => [
        'nik' => 'NIK',
        'nik_ortu' => 'NIK orang tua',
        'ttl' => 'tempat, tanggal lahir',
        'ttl_ortu' => 'tempat, tanggal lahir orang tua',
    ],

    'between' => [
        'numeric' => ':Attribute harus antara :min dan :max.',
        'file'    => ':Attribute harus antara :min dan :max .',
        'string'  => ':Attribute harus antara :min dan :max karakter.',
        'array'   => ':Attribute harus memiliki antara :min dan :max item.',
    ],

];
