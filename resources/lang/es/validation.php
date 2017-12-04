<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL válida.',
    'after'                => ':attribute debe ser una fecha posterior a :date.',
    'alpha'                => ':attribute solo debe contener letras.',
    'alpha_dash'           => ':attribute solo debe contener letras, números y guiones.',
    'alpha_num'            => ':attribute solo debe contener letras y números.',
    'array'                => ':attribute debe ser un conjunto.',
    'before'               => ':attribute debe ser una fecha anterior a :date.',
    'between'              => [
        'numeric' => ':attribute tiene que estar entre :min - :max.',
        'file'    => ':attribute debe pesar entre :min - :max kilobytes.',
        'string'  => ':attribute tiene que tener entre :min - :max caracteres.',
        'array'   => ':attribute tiene que tener entre :min - :max ítems.',
    ],
    'boolean'              => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed'            => 'La confirmación de :attribute no coincide.',
    'date'                 => ':attribute no es una fecha válida.',
    'date_format'          => ':attribute no corresponde al formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => ':attribute debe tener :digits dígitos.',
    'digits_between'       => ':attribute debe tener entre :min y :max dígitos.',
    'email'                => ':attribute no es un correo válido',
    'filled'               => 'El campo :attribute es obligatorio.',
    'exists'               => ':attribute es inválido.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => ':attribute es inválido.',
    'integer'              => ':attribute debe ser un número entero.',
    'ip'                   => ':attribute debe ser una dirección IP válida.',
    'max'                  => [
        'numeric' => ':attribute no debe ser mayor a :max.',
        'file'    => ':attribute no debe ser mayor que :max kilobytes.',
        'string'  => ':attribute no debe ser mayor que :max caracteres.',
        'array'   => ':attribute no debe tener más de :max elementos.',
    ],
    'mimes'                => ':attribute debe ser un archivo con formato: :values.',
    'min'                  => [
        'numeric' => 'El tamaño de :attribute debe ser de al menos :min.',
        'file'    => 'El tamaño de :attribute debe ser de al menos :min kilobytes.',
        'string'  => ':attribute debe contener al menos :min caracteres.',
        'array'   => ':attribute debe tener al menos :min elementos.',
    ],
    'not_in'               => ':attribute es inválido.',
    'numeric'              => ':attribute debe ser numérico.',
    'regex'                => 'El formato de :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values estén presentes.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El tamaño de :attribute debe ser :size.',
        'file'    => 'El tamaño de :attribute debe ser :size kilobytes.',
        'string'  => ':attribute debe contener :size caracteres.',
        'array'   => ':attribute debe contener :size elementos.',
    ],
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => ':attribute ya ha sido registrado.',
    'url'                  => 'El formato :attribute es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'email' => [
            'email' => 'Please enter a valid email address.',
            'required' => 'Please enter your e-mail address',
            'unique'      => 'E-Mail has already been taken.',
        ],
        'password' => [
            'between' => 'Password must contain characters :min - :max.',
        ],
        'password_confirm' => [
            'required' => 'Password confirm is required.',
            'same'      => 'Password and Confirm must be the same.',
        ],
        'sifre' => [
            'required' => 'Please enter your password.',
        ],
        'yeni_sifre' => [
            'required' => 'Please enter a new password.',
        ],
        'yeni_sifre_tekrar' => [
            'required' => 'Please enter new password again.',
            'same'      => 'Password and Confirm must be the same.',
        ],
        'first_name' => [
            'required' => 'Please enter name.',
            'min'      => 'Name must be at least :min character.',
        ],
        'last_name' => [
            'required' => 'Please enter surname.',
            'min'      => 'Surname must be at least :min character.',
        ],
        'comment' => [
            'required' => 'Please enter your comment.',
            'min'      => 'Comment must be at least :min character.',
        ],
        'rating' => [
            'required' => 'Please rate to product of 1-5.',
            'between'  => 'Please rate between :min - :max.',
        ],
        'alici_adi' => [
            'required' => 'Please enter the Recipient Name.',
        ],
        'country' => [
            'required' => 'Please select country.',
        ],
        'city' => [
            'required' => 'Please select city.',
        ],
        'state' => [
            'required' => 'Please select town.',
        ],
        'address' => [
            'required' => 'Please enter address.',
        ],
        'tel' => [
            'required' => 'Please enter telephone.',
        ],
        'fisim' => [
            'required' => 'Please enter Billing Name.',
        ],
        'fcountry' => [
            'required' => 'Please enter billing country.',
        ],
        'fcity' => [
            'required' => 'Please enter billing city',
        ],
        'fstate' => [
            'required' => 'Please enter billing town.',
        ],
        'faddress' => [
            'required' => 'Please enter billing address.',
        ],
        'ftel' => [
            'required' => 'Please enter billing telephone.',
        ],
        'pos_id' => [
            'required' => 'Please select credit card.',
        ],
        'ccname' => [
            'required' => 'Please enter name on card.',
        ],
        'ccno' => [
            'required' => 'Please enter your card number.',
        ],
        'cvc2' => [
            'required' => 'Please enter security code on card.',
        ],
        'hesapId' => [
            'required' => 'Please select a bank account.',
        ],
        'odemeTuruOnay' => [
            'required' => 'Please confirm that you accept the payment type.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
