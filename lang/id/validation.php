<?php

/*
 | Terjemahan validasi yang umum dipakai. Kunci yang tidak ada di sini
 | otomatis memakai bahasa cadangan (lang/en/validation.php).
 */
return [
    'accepted'         => ':attribute harus diterima.',
    'array'            => ':attribute harus berupa array.',
    'between'          => [
        'numeric' => ':attribute harus di antara :min dan :max.',
        'file'    => 'Ukuran :attribute harus di antara :min dan :max kilobita.',
        'string'  => ':attribute harus di antara :min dan :max karakter.',
    ],
    'boolean'          => ':attribute harus bernilai benar atau salah.',
    'confirmed'        => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Kata sandi saat ini salah.',
    'date'             => ':attribute bukan tanggal yang valid.',
    'email'            => ':attribute harus berupa alamat email yang valid.',
    'exists'           => ':attribute yang dipilih tidak valid.',
    'file'             => ':attribute harus berupa berkas.',
    'gt'               => [
        'numeric' => ':attribute harus lebih besar dari :value.',
    ],
    'gte'              => [
        'numeric' => ':attribute harus lebih besar atau sama dengan :value.',
    ],
    'image'            => ':attribute harus berupa gambar.',
    'in'               => ':attribute yang dipilih tidak valid.',
    'integer'          => ':attribute harus berupa bilangan bulat.',
    'max'              => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => 'Ukuran :attribute tidak boleh lebih dari :max kilobita.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes'            => ':attribute harus berupa berkas bertipe: :values.',
    'min'              => [
        'numeric' => ':attribute minimal :min.',
        'file'    => 'Ukuran :attribute minimal :min kilobita.',
        'string'  => ':attribute minimal :min karakter.',
        'array'   => ':attribute minimal memiliki :min item.',
    ],
    'numeric'          => ':attribute harus berupa angka.',
    'password'         => [
        'letters'       => ':attribute harus mengandung minimal satu huruf.',
        'mixed'         => ':attribute harus mengandung huruf besar dan huruf kecil.',
        'numbers'       => ':attribute harus mengandung minimal satu angka.',
        'symbols'       => ':attribute harus mengandung minimal satu simbol.',
        'uncompromised' => ':attribute pernah muncul dalam kebocoran data. Gunakan :attribute lain.',
    ],
    'regex'            => 'Format :attribute tidak valid.',
    'required'         => ':attribute wajib diisi.',
    'same'             => ':attribute dan :other harus sama.',
    'string'           => ':attribute harus berupa teks.',
    'unique'           => ':attribute sudah terdaftar.',
    'uploaded'         => ':attribute gagal diunggah.',

    'custom' => [],

    'attributes' => [
        'name'                  => 'Nama',
        'email'                 => 'Email',
        'password'              => 'Kata sandi',
        'password_confirmation' => 'Konfirmasi kata sandi',
        'current_password'      => 'Kata sandi saat ini',
        'phone'                 => 'Nomor telepon',
        'address'               => 'Alamat',
        'budget'                => 'Anggaran',
        'area'                  => 'Luas bangunan',
        'proof'                 => 'Bukti pembayaran',
        'image'                 => 'Gambar',
    ],
];
