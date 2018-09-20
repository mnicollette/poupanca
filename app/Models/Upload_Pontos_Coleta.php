<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload_Pontos_Coleta extends Model
{
    use SoftDeletes;
    
    protected $table = 'upload_pontos_coletas';
    
    protected $hidden = [
        
    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
