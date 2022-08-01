<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    use HasFactory;

    protected $fillable = [
        'roll_id',
        'roll_time',
        'color',
        'number',
        'seed',
        'roll_id',
        'time_add',
        'duplicated_seed'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'datetime'
    ];

    public function signs()
    {
        return Sign::where('base_color_id', $this->id)->get();
    }

    public function getMinuteRoll()
    {

        $minuteRoll = $this
            ->whereBetween('roll_time',[Carbon::parse($this->roll_time)->format('Y-m-d H:i:00'), Carbon::parse($this->roll_time)->format('Y-m-d H:i:59')])
            ->where('id', '<>', $this->id);

        return $minuteRoll;

    }

    public function getMinuteRolls()
    {

        $minuteRolls = $this
            ->where('roll_time', '<' ,Carbon::parse($this->roll_time)->addMinute()->format('Y-m-d H:i:59'))
            ->where('roll_time', '>', Carbon::parse($this->roll_time)->subMinute()->format('Y-m-d H:i:00'));

        return $minuteRolls;

    }

    public function getDuplicatedRolls()
    {

        $duplicatedRoll = $this
            ->whereBetween('roll_time',[Carbon::parse($this->roll_time)->format('Y-m-d H:i:00'), Carbon::parse($this->roll_time)->format('Y-m-d H:i:59')])
            ->where('id', '<>', $this->id)->first();


        if(($duplicatedRoll) && $duplicatedRoll->number == $this->number){

            return $duplicatedRoll;

        } else {

            return false;

        }

    }
}
