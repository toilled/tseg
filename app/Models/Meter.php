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
    private ?int $eac;

    protected $fillable = ['mpxn', 'installation', 'fuel', 'eac'];

    public function getLastReading()
    {
        return $this->readings()
            ->where('estimated', '=', 0)
            ->orderBy('date', 'desc')
            ->first();
    }

    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    public function validEAC(): bool
    {
        if ($this->getAttribute('eac') > 8000 || $this->getAttribute('eac') < 2000) {
            return false;
        }
        return true;
    }
}
