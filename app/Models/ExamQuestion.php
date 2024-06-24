<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExamQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'exam_questions';
    protected $tkey = 'id';

}
