<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = $this->clearField($value);
    }

    public function getDocumentCompanyAttribute($value)
    {
        return substr($value, '0', '2') . '.' . substr($value, '2', '3') . '.' . substr($value, '3', '3') . '/' . substr($value, '3', '4') . '-' . substr($value, '4', '2');
    }

    private function clearField(?string $param)
    {
        if (empty($param)) {
            return '';
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

}
