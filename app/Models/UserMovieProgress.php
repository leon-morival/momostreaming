<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMovieProgress extends Model
{
    use HasFactory;
    public function movieProgress()
{
    return $this->hasMany(UserMovieProgress::class);
}

}
