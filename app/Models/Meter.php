<?php

namespace App\Models;

use App\Enums\Fuel;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meter extends Model
{
    use HasFactory;

    protected $table = 'meters';
    protected $primaryKey = 'mpxn';
    public $incrementing = false;
    protected $keyType = 'string';

    private string $mpxn;
    private DateTime $installation;
    private Fuel $fuel;

    protected $fillable = ['mpxn', 'installation', 'fuel'];

    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }
}
