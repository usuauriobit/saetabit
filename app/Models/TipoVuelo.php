<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TipoVuelo extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_vuelo_id',
        'descripcion',
        'supports_massive_assign',
        'max_peso_bulto',
    ];

    public function getDescCategoriaAttribute(){
        if($this->is_desc_same_as_category)
            return $this->descripcion;
        return "{$this->categoria_vuelo->descripcion} - {$this->descripcion}";
    }
    public function getIsCharterAttribute(){
        return optional($this->categoria_vuelo)->descripcion === 'Chárter';
    }
    public function getIsEmergenciaMedicaAttribute(){
        return $this->descripcion === 'Emergencia médica';
    }
    public function getIsNoRegularAttribute(){
        return $this->descripcion === 'No regular';
    }
    public function getIsComercialAttribute(){
        return $this->descripcion === 'Comercial';
    }
    public function getIsCompaniaAttribute(){
        return $this->descripcion === 'Compañía';
    }
    public function getIsSubvencionadoAttribute(){
        return $this->descripcion === 'Subvencionado';
    }
    public function getIsDescSameAsCategoryAttribute(){
        return !strpos($this->descripcion, $this->categoria_vuelo->descripcion);
    }

    public function categoria_vuelo(): BelongsTo { return $this->belongsTo(CategoriaVuelo::class); }

    public function scopeWhereIsCharter($q){
        return $q->whereHas('categoria_vuelo', function($q){
            return $q->whereDescripcion('Chárter');
        });
    }
    public function scopeWhereIsNotCharter($q){
        return $q->whereHas('categoria_vuelo', function($q){
            return $q->where('descripcion', '!=', 'Chárter');
        });
    }
    public function scopeWhereIsNotRegular($q){
        return $q->where('descripcion', 'No regular');
    }
    public function scopeWhereIsComercial($q){
        return $q->whereHas('categoria_vuelo', function($q){
            return $q->where('descripcion', '!=', 'Chárter');
        })
        ->whereDescripcion('Comercial');
    }
    public function scopeWhereIsSubvencionado($q){
        return $q
        ->whereDescripcion('Subvencionado');
    }
    public function scopeWhereSupportsMassiveAssign($q){
        return $q->where('supports_massive_assign', true);
    }
    public function scopeWhereNotSupportsMassiveAssign($q){
        return $q->where('supports_massive_assign', false);
    }

}
