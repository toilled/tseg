<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $table = 'readings';

    private Meter $meter_mpxn;
    private float $value;
    private DateTime $date;
    private bool $estimated;

    protected $attributes = ['estimated' => false];
    protected $fillable = ['meter_mpxn', 'value', 'date', 'estimated'];
}
