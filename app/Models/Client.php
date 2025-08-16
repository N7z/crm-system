<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpf',
        'state',
        'city',
        'address',
    ];

    public function cpf(): Attribute {
        return new Attribute(
            get: fn($value) => $this->formatCpf($value),
            set: fn($value) => preg_replace('/\D/', '', $value)
        );
    }

    public function phone(): Attribute {
        return new Attribute(
            get: fn($value) => $this->formatPhone($value),
            set: fn($value) => preg_replace('/\D/', '', $value)
        );
    }

    protected function formatCpf($value) {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value);
    }

    protected function formatPhone($value) {
        $digits = preg_replace('/\D/', '', $value);
        if (strlen($digits) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $digits);
        } elseif (strlen($digits) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits);
        }
        return $value;
    }
}
