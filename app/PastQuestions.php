<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PastQuestions extends Model
{
	protected $table = 'past_questions';

    protected $fillable = [
        'department', 'course_code', 'course_title', 'level', 'year', 'semester', 'uploaded_by', 'created_at', 'updated_at', 'path',
    ];

    protected $primaryKey = 'id';
}
