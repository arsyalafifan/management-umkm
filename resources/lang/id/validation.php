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

    'accepted' => 'Field :attribute harus disetujui.',
    'active_url' => 'Field :attribute bukan valid URL.',
    'after' => 'Field :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Field :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Field :attribute hanya boleh berupa huruf.',
    'alpha_dash' => 'Field :attribute hanya boleh berupa huruf, nomor, dan penghubung.',
    'alpha_num' => 'Field :attribute hanya boleh berupa huruf dan nomor.',
    'array' => 'Field :attribute harus berupa array.',
    'before' => 'Field :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Field :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Field :attribute harus diantara :min - :max.',
        'file' => 'Field :attribute harus diantara :min - :max KB.',
        'string' => 'Field :attribute harus diantara :min - :max karakter.',
        'array' => 'Field :attribute harus diantara :min and :max items.',
    ],
    'boolean' => 'Field :attribute harus berupa true atau false.',
    'confirmed' => 'Field :attribute konfirmasi tidak cocok.',
    'date' => 'Field :attribute bukan tanggal valid.',
    'date_equals' => 'Field :attribute harus berupda tanggal yang sama dengan :date.',
    'date_format' => 'Field :attribute tidak cocok dengan format :format.',
    'different' => 'Field :attribute and :other harus berbeda.',
    'digits' => 'Field :attribute harus :digits digit.',
    'digits_between' => 'Field :attribute harus diantara :min dan :max digit.',
    'dimensions' => 'Field :attribute memiliki dimensi image yang tidak valid.',
    'distinct' => 'Field :attribute memiliki nilai duplikat.',
    'email' => 'Field :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Field :attribute harus diakhiri dengan salah satu dari nilai berikut: :values.',
    'exists' => 'Field :attribute yang dipilih tidak valid.',
    'file' => 'Field :attribute harus berupa file.',
    'filled' => 'Field :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Field :attribute harus lebih besar dari :value.',
        'file' => 'Field :attribute harus lebih besar dari :value kilobytes.',
        'string' => 'Field :attribute harus lebih besar dari :value characters.',
        'array' => 'Field :attribute harus lebih besar dari :value items.',
    ],
    'gte' => [
        'numeric' => 'Field :attribute harus lebih besar dari atau sama dengan :value.',
        'file' => 'Field :attribute harus lebih besar dari atau sama dengan :value kilobytes.',
        'string' => 'Field :attribute harus lebih besar dari atau sama dengan :value characters.',
        'array' => 'Field :attribute must have :value items or more.',
    ],
    'image' => 'Field :attribute harus berupa image.',
    'in' => 'Field :attribute yang dipilih tidak valid.',
    'in_array' => 'Field :attribute tidak terdapat di dalam :other.',
    'integer' => 'Field :attribute harus berupa integer.',
    'ip' => 'Field :attribute harus berupa IP address yang valid.',
    'ipv4' => 'Field :attribute harus berupa IPv4 address yang valid.',
    'ipv6' => 'Field :attribute harus berupa IPv6 address yang valid.',
    'json' => 'Field :attribute harus berupa JSON string yang valid.',
    'lt' => [
        'numeric' => 'Field :attribute harus lebih kecil dari :value.',
        'file' => 'Field :attribute harus lebih kecil dari :value kilobyte.',
        'string' => 'Field :attribute harus lebih kecil dari :value karakter.',
        'array' => 'Field :attribute harus lebih kecil dari :value item.',
    ],
    'lte' => [
        'numeric' => 'Field :attribute harus lebih kecil dari atau sama dengan :value.',
        'file' => 'Field :attribute harus lebih kecil dari atau sama dengan :value kilobyte.',
        'string' => 'Field :attribute harus lebih kecil dari atau sama dengan :value karakter.',
        'array' => 'Field :attribute tidak boleh lebih besar dari :value item.',
    ],
    'max' => [
        'numeric' => 'Field :attribute tidak boleh lebih besar dari :max.',
        'file' => 'Field :attribute tidak boleh lebih besar dari :max kilobyte.',
        'string' => 'Field :attribute tidak boleh lebih besar dari :max karakter.',
        'array' => 'Field :attribute tidak boleh lebih besar dari :max item.',
    ],
    'mimes' => 'Field :attribute harus berupa sebuah file dengan tipe: :values.',
    'mimetypes' => 'Field :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => 'Field :attribute tidak boleh lebih kecil dari :min.',
        'file' => 'Field :attribute tidak boleh lebih kecil dari :min kilobytes.',
        'string' => 'Field :attribute tidak boleh lebih kecil dari :min characters.',
        'array' => 'Field :attribute tidak boleh lebih kecil dari :min items.',
    ],
    'multiple_of' => 'Field :attribute must be a multiple of :value.',
    'not_in' => 'File :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format field :attribute tidak valid.',
    'numeric' => 'Field :attribute harus berupa number.',
    'password' => 'password tidak valid.',
    'present' => 'Field :attribute must be present.',
    'regex' => 'Format field :attribute tidak valid.',
    'required' => 'Field :attribute harus diisi.',
    'required_if' => 'Field :attribute harus diisi jika :other bernilai :value.',
    'required_unless' => 'Field :attribute field is required unless :other is in :values.',
    'required_with' => 'Field :attribute field is required when :values is present.',
    'required_with_all' => 'Field :attribute field is required when :values are present.',
    'required_without' => 'Field :attribute field is required when :values is not present.',
    'required_without_all' => 'Field :attribute field is required when none of :values are present.',
    'same' => 'Field :attribute and :other must match.',
    'size' => [
        'numeric' => 'Field :attribute harus berukuran :size.',
        'file' => 'Field :attribute harus berukuran :size kilobyte.',
        'string' => 'Field :attribute harus memiliki :size karakter.',
        'array' => 'Field :attribute harus berisi :size item.',
    ],
    'starts_with' => 'Field :attribute harus dimulai dengan salah satu dari nilai berikut: :values.',
    'string' => 'Field :attribute harus berupa string.',
    'timezone' => 'Field :attribute harus berupa zone yang valid.',
    'unique' => 'Nilai field :attribute sudah digunakan.',
    'uploaded' => 'Field :attribute gagal diupload.',
    'url' => 'Format field :attribute tidak valid.',
    'uuid' => 'Field :attribute harus berupa UUID yang valid.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
