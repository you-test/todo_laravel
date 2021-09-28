<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
        // 引数の省略無し：$this->hasMany('App\Task', 'folder_id', 'id');
    }
}
