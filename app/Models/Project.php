<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    use HasFactory;
    protected $fillable = ['title', 'description', 'featured'];

    public function projectTypes() {
        return $this->belongsToMany(ProjectType::class);
    }

    public function cities() {
        return $this->belongsToMany(City::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
