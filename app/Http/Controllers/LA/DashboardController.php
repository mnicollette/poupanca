<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

use Ixudra\Curl\Facades\Curl;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {

      $response = Curl::to('https://i2waste.azurewebsites.net/api/Users/Autenticate')
      ->withData( array( 'Email' => 'nicollette@mpiza.com.br', 'Password' => '87Z.yaRb' ) )
      ->asJson( true )
      ->post();
      $token = $response['authToken'];

      $current = Curl::to('https://i2waste.azurewebsites.net/api/Users/CurrentUser')
        ->withHeader('Authorization: Bearer '.$token)
        ->get();

      $bases = Curl::to('https://i2waste.azurewebsites.net/api/DumpBoxes/GetAll?pageIndex=0&pageSize=5')
        ->withHeader('Authorization: Bearer '.$token)
        ->asJson( true )
        ->get();
      $id_base = $bases['data'][2]['id'];
      //dd($id_base);
      $nivel_lixeiras = Curl::to('https://i2waste.azurewebsites.net/api/DumpHistory/GetWasteLevel/'.$id_base)
        ->withHeader('Authorization: Bearer '.$token)
        ->asJson( true )
        ->get();

        $total_lixeiras = Curl::to('https://i2waste.azurewebsites.net/api/Dumps/Count/'.$id_base)
          ->withHeader('Authorization: Bearer '.$token)
          ->asJson( true )
          ->get();


        return view('la.dashboard',['nivel_lixeiras'=>$nivel_lixeiras, 'total_lixeiras' => $total_lixeiras] );
    }


}
