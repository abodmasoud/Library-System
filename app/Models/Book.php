<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Stmt\Catch_;

class Book extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function borrowers()
    {
        return $this->belongsToMany(Borrower::class);
    }
}