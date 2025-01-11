<?php

return [
    'required' => ':Attribute harus diisi.',
    'email' => ':Attribute harus berupa alamat email yang valid.',
    'max' => [
        'string' => ':Attribute tidak boleh lebih dari :max karakter.',
    ],
    'min' => [
        'string' => ':Attribute harus memiliki minimal :min karakter.',
    ],
    'confirmed' => 'Konfirmasi :Attribute tidak cocok.',
    'unique' => ':Attribute sudah digunakan.',
    'string' => ':Attribute harus berupa teks.',
    'boolean' => ':Attribute harus bernilai true atau false.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'date_format' => ':Attribute harus sesuai dengan format :format.',
    'numeric' => ':Attribute harus berupa angka.',
    'image' => ':Attribute harus berupa gambar (jpeg, png, bmp, gif, atau svg).',
    'file' => ':Attribute harus berupa file.',
    'mimes' => ':Attribute harus berupa file bertipe: :values.',
    'size' => [
        'string' => ':Attribute harus memiliki panjang :size karakter.',
    ],
    'in' => ':Attribute harus salah satu dari: :values.',
    'not_in' => ':Attribute yang dipilih tidak valid.',
];
