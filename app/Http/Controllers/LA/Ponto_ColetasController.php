<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Ponto_Coleta;
use App\Models\Categoria_Empresa;
use App\Models\Material;

class Ponto_ColetasController extends Controller
{
    public $show_action = true;
    public $view_col = 'endereco';
    public $listing_cols = ['id', 'empresa', 'responsavel', 'telefone', 'status'];

    public function __construct()
    {
        // Field Access of Listing Columns
        if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
            $this->middleware(function ($request, $next) {
                $this->listing_cols = ModuleFields::listingColumnAccessScan('Ponto_Coletas', $this->listing_cols);
                return $next($request);
            });
        } else {
            $this->listing_cols = ModuleFields::listingColumnAccessScan('Ponto_Coletas', $this->listing_cols);
        }
    }

    /**
     * Display a listing of the Ponto_Coletas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module = Module::get('Ponto_Coletas');
        $categorias = Categoria_Empresa::get();
        $materiais = Material::get();

        if (Module::hasAccess($module->id)) {
            return View('la.ponto_coletas.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => $this->listing_cols,
                'module' => $module,
                'categorias' => $categorias,
                'materiais' => $materiais
            ]);
        } else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }

    /**
     * Show the form for creating a new ponto_coleta.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created ponto_coleta in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Module::hasAccess("Ponto_Coletas", "create")) {
            $rules = Module::validateRules("Ponto_Coletas", $request);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert("Ponto_Coletas", $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.ponto_coletas.index');
        } else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }

    /**
     * Display the specified ponto_coleta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Module::hasAccess("Ponto_Coletas", "view")) {
            $ponto_coleta = Ponto_Coleta::find($id);
            if (isset($ponto_coleta->id)) {
                $module = Module::get('Ponto_Coletas');
                $module->row = $ponto_coleta;

                $categorias = Categoria_Empresa::get();
                $materiais = Material::get();

                return view('la.ponto_coletas.show', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding",
                    'categorias' => $categorias,
                    'materiais' => $materiais
                ])->with('ponto_coleta', $ponto_coleta);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("ponto_coleta"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }

    /**
     * Show the form for editing the specified ponto_coleta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Module::hasAccess("Ponto_Coletas", "edit")) {
            $ponto_coleta = Ponto_Coleta::find($id);
            if (isset($ponto_coleta->id)) {
                $module = Module::get('Ponto_Coletas');

                $module->row = $ponto_coleta;

                $categorias = Categoria_Empresa::get();
                $materiais = Material::get();

                return view('la.ponto_coletas.edit', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                    'categorias' => $categorias,
                    'materiais' => $materiais
                ])->with('ponto_coleta', $ponto_coleta);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("ponto_coleta"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }

    /**
     * Update the specified ponto_coleta in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Module::hasAccess("Ponto_Coletas", "edit")) {
            $rules = Module::validateRules("Ponto_Coletas", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
                ;
            }

            $insert_id = Module::updateRow("Ponto_Coletas", $request, $id);

            return redirect()->route(config('laraadmin.adminRoute') . '.ponto_coletas.index');
        } else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }

    /**
     * Remove the specified ponto_coleta from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Module::hasAccess("Ponto_Coletas", "delete")) {
            Ponto_Coleta::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.ponto_coletas.index');
        } else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
    }

    /**
     * Datatable Ajax fetch
     *
     * @return
     */
    public function dtajax()
    {
        $values = DB::table('ponto_coletas')->select($this->listing_cols)->whereNull('deleted_at');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Ponto_Coletas');

        for ($i=0; $i < count($data->data); $i++) {
            for ($j=0; $j < count($this->listing_cols); $j++) {
                $col = $this->listing_cols[$j];
                if ($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if ($col == $this->view_col) {
                    $data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/ponto_coletas/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if ($this->show_action) {
                $output = '';
                if (Module::hasAccess("Ponto_Coletas", "edit")) {
                    $output .= '<a href="'.url(config('laraadmin.adminRoute') . '/ponto_coletas/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if (Module::hasAccess("Ponto_Coletas", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.ponto_coletas.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }
}
