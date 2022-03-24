<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale',
        'rent',
        'owner_id',
        'owner_spouse',
        'owner_company_id',
        'acquirer_id',
        'acquirer_spouse',
        'acquirer_company_id',
        'property_id',
        'sale_price',
        'rent_price',
        'price',
        'tribute',
        'condominium',
        'due_date',
        'deadline',
        'start_at',
        'status'
    ];

    public function ownerIdObject()
    {
        return $this->hasOne(User::class);
    }

    public function ownerCompanyIdObject()
    {
        return $this->hasOne(Company::class);
    }

    public function propertyIdObject()
    {
        return $this->hasOne(Property::class);
    }

    public function acquirerIdObject()
    {
        return $this->hasOne(User::class);
    }

    public function acquirerCompanyIdObject()
    {
        return $this->hasOne(Company::class);
    }

    public function scopePendent($query)
    {
        return $query->where('status', 'pendent');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    public function setOwnerSpouseAttribute($value)
    {
        $this->attributes['owner_spouse'] = ($value === '1' ? 1 : 0);
    }

    public function setOwnerCompanyIdAttribute($value)
    {
        if ($value == '0') {
            $this->attributes['owner_company_id'] = null;
        } else {
            $this->attributes['owner_company_id'] = $value;
        }
    }

    public function setAcquirerSpouseAttribute($value)
    {
        $this->attributes['acquirer_spouse'] = ($value === '1' ? 1 : 0);
    }

    public function setAcquirerCompanyIdAttribute($value)
    {
        if ($value == '0') {
            $this->attributes['acquirer_company_id'] = null;
        } else {
            $this->attributes['acquirer_company_id'] = $value;
        }
    }

    public function setSaleAttribute($value)
    {
        if ($value === true || $value === 'on') {
            $this->attributes['sale'] = 1;
            $this->attributes['rent'] = 0;
        }
    }

    public function setRentAttribute($value)
    {
        if ($value === true || $value === 'on') {
            $this->attributes['sale'] = 1;
            $this->attributes['rent'] = 0;
        }
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function setSalePriceAttribute($value)
    {
        $this->attributes['price'] = floatval($this->convertStringToDouble($value));

    }

    public function setRentPriceAttribute($value)
    {
        $this->attributes['price'] = floatval($this->convertStringToDouble($value));

    }

    public function setTributeAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['tribute'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function setCondominiumAttribute($value)
    {
        $this->attributes['condominium'] = floatval($this->convertStringToDouble($value));
    }

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = date('Y-m-d', strtotime($value));
    }

    public function getStartAtAttribute($value)
    {
        $this->attributes['start_at'] = date('d/m/Y', strtotime($value));
    }

    private function convertStringToDouble(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }

    public function terms()
    {
        // Finalidade [Venda/Locação]
        if ($this->sale == true) {
            $parameters = [
                'purpouse' => 'VENDA',
                'part' => 'VENDEDOR',
                'part_opposite' => 'COMPRADOR',
            ];
        }

        if ($this->rent == true) {
            $parameters = [
                'purpouse' => 'LOCAÇÃO',
                'part' => 'LOCADOR',
                'part_opposite' => 'LOCATÁRIO',
            ];
        }

        $terms[] = "<p style='text-align: center;'>{$this->id} - CONTRATO DE {$parameters['purpouse']} DE IMÓVEL</p>";

        // OWNER
        if (!empty($this->owner_company_id)) { // Se tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyIdObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->ownerCompanyIdObject->document_company} e I. E. nº {$this->ownerCompanyIdObject->document_company_secondary} exercendo suas atividades no endereço {$this->ownerCompanyIdObject->street}, nº {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyIdObject->neighborhood}, {$this->ownerCompanyIdObject->city}/{$this->ownerCompanyIdObject->state}, CEP {$this->ownerCompanyIdObject->zipcode} tendo como responsável legal {$this->ownerIdObject->name}, natural de {$this->ownerIdObject->place_of_birth}, {$this->ownerIdObject->civil_status}, {$this->ownerIdObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerIdObject->document_secondary} {$this->ownerIdObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerIdObject->document}, e cônjuge {$this->ownerIdObject->spouse_name}, natural de {$this->ownerIdObject->spouse_place_of_birth}, {$this->ownerIdObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->ownerIdObject->spouse_document_secondary} {$this->ownerIdObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerIdObject->spouse_document}, residentes e domiciliados à {$this->ownerIdObject->street}, nº {$this->ownerIdObject->number}, {$this->ownerIdObject->complement}, {$this->ownerIdObject->neighborhood}, {$this->ownerIdObject->city}/{$this->ownerIdObject->state}, CEP {$this->ownerIdObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyIdObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->ownerCompanyIdObject->document_company} e I. E. nº {$this->ownerCompanyIdObject->document_company_secondary} exercendo suas atividades no endereço {$this->ownerCompanyIdObject->street}, nº {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyIdObject->neighborhood}, {$this->ownerCompanyIdObject->city}/{$this->ownerCompanyIdObject->state}, CEP {$this->ownerCompanyIdObject->zipcode} tendo como responsável legal {$this->ownerIdObject->name}, natural de {$this->ownerIdObject->place_of_birth}, {$this->ownerIdObject->civil_status}, {$this->ownerIdObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerIdObject->document_secondary} {$this->ownerIdObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerIdObject->document}, residente e domiciliado à {$this->ownerIdObject->street}, nº {$this->ownerIdObject->number}, {$this->ownerIdObject->complement}, {$this->ownerIdObject->neighborhood}, {$this->ownerIdObject->city}/{$this->ownerIdObject->state}, CEP {$this->ownerIdObject->zipcode}.</p>";
            }
        } else { // Se não tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerIdObject->name}</b>, natural de {$this->ownerIdObject->place_of_birth}, {$this->ownerIdObject->civil_status}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerIdObject->document}, e cônjuge {$this->ownerIdObject->spouse_name}, natural de {$this->ownerIdObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->ownerIdObject->spouse_document_secondary} {$this->ownerIdObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerIdObject->spouse_document}, residentes e domiciliados à {$this->ownerIdObject->street}, nº {$this->ownerObject->number}, {$this->ownerIdObject->complement}, {$this->ownerIdObject->neighborhood}, {$this->ownerIdObject->city}/{$this->ownerIdObject->state}, CEP {$this->ownerIdObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerIdObject->name}</b>, natural de {$this->ownerIdObject->place_of_birth}, {$this->ownerIdObject->civil_status}, {$this->ownerObject->occupation}, portador da cédula de identidade R. G. nº {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->ownerIdObject->document}, residente e domiciliado à {$this->ownerIdObject->street}, nº {$this->ownerIdObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerIdObject->state}, CEP {$this->ownerIdObject->zipcode}.</p>";
            }
        }

        // ACQUIRER
        // Se tem empresa
        if (!empty($this->acquirer_company_id)) { // Se tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyIdObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->acquirerCompanyIdObject->document_company} e I. E. nº {$this->acquirerCompanyIdObject->document_company_secondary} exercendo suas atividades no endereço {$this->acquirerCompanyIdObject->street}, nº {$this->acquirerCompanyIdObject->number}, {$this->acquirerCompanyIdObject->complement}, {$this->acquirerCompanyIdObject->neighborhood}, {$this->acquirerCompanyIdObject->city}/{$this->acquirerCompanyIdObject->state}, CEP {$this->acquirerCompanyIdObject->zipcode} tendo como responsável legal {$this->acquirerIdObject->name}, natural de {$this->acquirerIdObject->place_of_birth}, {$this->acquirerIdObject->civil_status}, {$this->acquirerIdObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerIdObject->document_secondary} {$this->acquirerIdObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerIdObject->document}, e cônjuge {$this->acquirerIdObject->spouse_name}, natural de {$this->acquirerIdObject->spouse_place_of_birth}, {$this->acquirerIdObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->acquirerIdObject->spouse_document_secondary} {$this->acquirerIdObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerIdObject->spouse_document}, residentes e domiciliados à {$this->acquirerIdObject->street}, nº {$this->acquirerIdObject->number}, {$this->acquirerIdObject->complement}, {$this->acquirerIdObject->neighborhood}, {$this->acquirerIdObject->city}/{$this->acquirerIdObject->state}, CEP {$this->acquirerIdObject->zipcode}.</p>";
            } else { // E não tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyIdObject->social_name}</b>, inscrito sob C. N. P. J. nº {$this->acquirerCompanyIdObject->document_company} e I. E. nº {$this->acquirerCompanyIdObject->document_company_secondary} exercendo suas atividades no endereço {$this->acquirerCompanyIdObject->street}, nº {$this->acquirerCompanyIdObject->number}, {$this->acquirerCompanyIdObject->complement}, {$this->acquirerCompanyIdObject->neighborhood}, {$this->acquirerCompanyIdObject->city}/{$this->acquirerCompanyIdObject->state}, CEP {$this->acquirerCompanyIdObject->zipcode} tendo como responsável legal {$this->acquirerIdObject->name}, natural de {$this->acquirerIdObject->place_of_birth}, {$this->acquirerIdObject->civil_status}, {$this->acquirerIdObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerIdObject->document_secondary} {$this->acquirerIdObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerIdObject->document}, residente e domiciliado à {$this->acquirerIdObject->street}, nº {$this->acquirerIdObject->number}, {$this->acquirerIdObject->complement}, {$this->acquirerIdObject->neighborhood}, {$this->acquirerIdObject->city}/{$this->acquirerIdObject->state}, CEP {$this->acquirerIdObject->zipcode}.</p>";
            }
        } else { // Se não tem empre

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerIdObject->name}</b>, natural de {$this->acquirerIdObject->place_of_birth}, {$this->acquirerIdObject->civil_status}, {$this->acquirerIdObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerIdObject->document_secondary} {$this->acquirerIdObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerIdObject->document}, e cônjuge {$this->acquirerIdObject->spouse_name}, natural de {$this->acquirerIdObject->spouse_place_of_birth}, {$this->acquirerIdObject->spouse_occupation}, portador da cédula de identidade R. G. nº {$this->acquirerIdObject->spouse_document_secondary} {$this->acquirerIdObject->spouse_document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerIdObject->spouse_document}, residentes e domiciliados à {$this->acquirerIdObject->street}, nº {$this->acquirerIdObject->number}, {$this->acquirerIdObject->complement}, {$this->acquirerIdObject->neighborhood}, {$this->acquirerIdObject->city}/{$this->acquirerIdObject->state}, CEP {$this->acquirerIdObject->zipcode}.</p>";
            } else { // E não tem conjugeId
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerIdObject->name}</b>, natural de {$this->acquirerIdObject->place_of_birth}, {$this->acquirerIdObject->civil_status}, {$this->acquirerIdObject->occupation}, portador da cédula de identidade R. G. nº {$this->acquirerIdObject->document_secondary} {$this->acquirerIdObject->document_secondary_complement}, e inscrição no C. P. F. nº {$this->acquirerIdObject->document}, residente e domiciliado à {$this->acquirerIdObject->street}, nº {$this->acquirerIdObject->number}, {$this->acquirerIdObject->complement}, {$this->acquirerIdObject->neighborhood}, {$this->acquirerIdObject->city}/{$this->acquirerIdObject->state}, CEP {$this->acquirerIdObject->zipcode}.</p>";
            }
        }

        $terms[] = "<p style='font-style: italic; font-size: 0.875em;'>A falsidade dessa declaração configura crime previsto no Código Penal Brasileiro, e passível de apuração na forma da Lei.</p>";

        $terms[] = "<p><b>5. IMÓVEL:</b> {$this->propertyIdObject->category}, {$this->propertyIdObject->type}, localizada no endereço {$this->propertyIdIdObject->street}, nº {$this->propertyObject->number}, {$this->propertyIdObject->complement}, {$this->propertyIdObject->neighborhood}, {$this->propertyIdObject->city}/{$this->propertyIdObject->state}, CEP {$this->propertyIdObject->zipcode}</p>";

        $terms[] = "<p><b>6. PERÍODO:</b> {$this->deadline} meses</p>";

        $terms[] = "<p><b>7. VIGÊNCIA:</b> O presente contrato tem como data de início {$this->start_at} e o término exatamente após a quantidade de meses descrito no item 6 deste.</p>";

        $terms[] = "<p><b>8. VENCIMENTO:</b> Fica estipulado o vencimento no dia {$this->due_date} do mês posterior ao do início de vigência do presente contrato.</p>";

        $terms[] = "<p>Florianópolis, " . date('d/m/Y') . ".</p>";

        $terms[] = "<table width='100%' style='margin-top: 50px;'>
                           <tr>
                                <td>_________________________</td>
                                " . ($this->owner_spouse ? "<td>_________________________</td>" : "") . "
                           </tr>
                           <tr>
                                <td>{$parameters['part']}: {$this->ownerObject->name}</td>
                                " . ($this->owner_spouse ? "<td>Conjuge: {$this->ownerIdObject->spouse_name}</td>" : "") . "
                           </tr>
                           <tr>
                                <td>Documento: {$this->ownerObject->document}</td>
                                " . ($this->owner_spouse ? "<td>Documento: {$this->ownerIdObject->spouse_document}</td>" : "") . "
                           </tr>

                    </table>";


        $terms[] = "<table width='100%' style='margin-top: 50px;'>
                           <tr>
                                <td>_________________________</td>
                                " . ($this->acquirer_spouse_id ? "<td>_________________________</td>" : "") . "
                           </tr>
                           <tr>
                                <td>{$parameters['part_opposite']}: {$this->acquirerIdObject->name}</td>
                                " . ($this->acquirer_spouse_id ? "<td>Conjuge: {$this->acquirerIdObject->spouse_name}</td>" : "") . "
                           </tr>
                           <tr>
                                <td>Documento: {$this->acquirerIdObject->document}</td>
                                " . ($this->acquirer_spouse_id ? "<td>Documento: {$this->acquirerIdObject->spouse_document}</td>" : "") . "
                           </tr>

                    </table>";

        $terms[] = "<table width='100%' style='margin-top: 50px;'>
                           <tr>
                                <td>_________________________</td>
                                <td>_________________________</td>
                           </tr>
                           <tr>
                                <td>1ª Testemunha: </td>
                                <td>2ª Testemunha: </td>
                           </tr>
                           <tr>
                                <td>Documento: </td>
                                <td>Documento: </td>
                           </tr>

                    </table>";

        return implode('', $terms);
    }
}
