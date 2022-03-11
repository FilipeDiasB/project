<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use HasFactory;

    protected $fillable = [
        'user',
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

    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = $this->clearField($value);
    }

    private function clearField(?string $param)
    {
        if (empty($param)){
            return '';
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }

}
