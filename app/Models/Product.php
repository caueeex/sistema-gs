<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'cep',
        'bairro',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
        ];
    }

    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class, 'ad_product')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
