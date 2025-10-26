<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'job_category_id',
        'job_role_id',
        'job_experience_id',
        'education_id',
        'job_type_id',
        'salary_type_id',
        'title',
        'slug',
        'vacancies',
        'min_salary',
        'max_salary',
        'custom_salary',
        'deadline',
        'description',
        'status',
        'apply_on',
        'apply_email',
        'apply_url',
        'featured',
        'highlight',
        'featured_until',
        'highlight_until',
        'total_views',
        'city_id',
        'state_id',
        'country_id',
        'address',
        'salary_mode',
        'company_name'
    ];

    // Quan hệ
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    public function role()
    {
        return $this->belongsTo(JobRole::class, 'job_role_id');
    }
    public function experience()
    {
        return $this->belongsTo(JobExperience::class, 'job_experience_id');
    }
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }
    public function salaryType()
    {
        return $this->belongsTo(SalaryType::class, 'salary_type_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    // Boot: tự tạo slug
    public static function boot()
    {
        parent::boot();
        static::creating(function ($job) {
            $job->slug = \Str::slug($job->title);
        });
        static::updating(function ($job) {
            $job->slug = \Str::slug($job->title);
        });
    }
}
