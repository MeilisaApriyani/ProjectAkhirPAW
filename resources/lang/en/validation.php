<?php

return [
    'custom' => [
        'email' => [
            'required' => 'Alamat email wajib diisi.',
            'email' => 'Alamat email harus berupa alamat email yang valid.',
            'unique' => 'Alamat email ini sudah digunakan.',
        ],
        'password' => [
            'required' => 'Kata sandi wajib diisi.',
            'min' => 'Kata sandi harus memiliki setidaknya :min karakter.',
            'confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ],
    ],

    // Penamaan atribut dalam bahasa Indonesia
    'attributes' => [
        'email' => 'alamat email',
        'password' => 'kata sandi',
       
    ],
];
