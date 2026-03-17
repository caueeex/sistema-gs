<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ad extends Model
{
    use HasFactory;
    protected $table = 'ads';

    protected $fillable = [
        'titulo',
        'descricao',
        'preco_venda',
    ];

    protected function casts(): array
    {
        return [
            'preco_venda' => 'decimal:2',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ad_product')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
