<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria_Empresa extends Model
{
    use SoftDeletes;
    
    protected $table = 'categoria_empresas';
    
    protected $hidden = [
        
    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
