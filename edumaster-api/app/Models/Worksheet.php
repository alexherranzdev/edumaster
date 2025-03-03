<?php

namespace App\Models;

use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    use HasFactory;

    protected $fillable = ['worksheet_id', 'teacher_id', 'title', 'description', 'words', 'correct_word'];

    protected $casts = [
        'words' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->worksheet_id) {
                $model->worksheet_id = (new WorksheetId())->value();
            }
        });
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'user_id');
    }
}
