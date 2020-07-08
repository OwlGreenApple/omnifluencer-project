<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserLog;
use App\PointLog;
use App\Referral;

use App\Http\Controllers\OrderController;

use Excel, Carbon, Auth, File, Hash, Mail;

class UserController extends Controller
{
    public function super_admin()
    {
      $user = User::all();
      return view('admin.admin',['data'=>$user]);
    }
    
    public function index(){
      return view('admin.list-user.index');
    }

    public function load_user(Request $request){
      $users = User::where('is_admin',0)->get();

      $arr['view'] = (string) view('admin.list-user.content')->with('users',$users);

      return $arr;
    }

    public function point_log(Request $request){
      $logs = PointLog::where('user_id',$request->id)
              ->get();

      $arr['view'] = (string) view('admin.list-user.content-poin')->with('points',$logs);

      return $arr;
    }

    public function referral_log(Request $request){
      $logs = Referral::join('users','referrals.user_id_taker','users.id')
              ->select('referrals.*','users.name','users.email')
              ->where('user_id_giver',$request->id)
              ->get();

      $arr['view'] = (string) view('admin.list-user.content-referral')->with('referrals',$logs);

      return $arr;
    }

    public function view_log(Request $request){
      $logs = UserLog::where('user_id',$request->id)
              ->get();

      $arr['view'] = (string) view('admin.list-user.content-log')->with('logs',$logs);

      return $arr;
    }

    public function import_excel_user(Request $request)
    {
      $admin = Auth::user();
      $arr = [
        "status" => "success",
        "message" => "User berhasil di add",
      ];

      if ($admin->is_admin == 1) {

          $active_d = strtotime(''.$request->time_d.' day 0 second', 0);
        // $data = Excel::load(Input::file('import_file'), function($reader) {
        $data = Excel::load($request->import_file, function($reader) {

        })->get();

        if(!empty($data) && $data->count()){
          foreach ($data as $key) {
            foreach ($key as $value) {
              //echo $value->email;
              if (!filter_var($value->email, FILTER_VALIDATE_EMAIL) === false) {
                $password = "";
                //cek new user or update
                $user = User::where("email",$value->email)->first();
                
                if ( is_null($user) ) {
                    //klo new user
                    $pas = $value->username.$value->name;
                    $gh = substr($pas, 0,6);
                    $chrnd =substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,5);
                    $password = str_replace(' ','', $gh.$chrnd) ;
                  
                    $user = User::create([
                              'name' => $value->name,
                              'email' => $value->email,
                              'gender'=> 0,
                              'password' => Hash::make($password),
                              'username' => $value->email,
                            ]);
                    $user->referral_link = uniqid().md5($user->id);
                    $user->point = 10;
                }
                else {
                  //klo update user
                }
                $ordercont = new OrderController;
                $valid = $ordercont->add_time($user,"+".$request->time_d." days");
                $user->valid_until = $valid;
                $user->membership = 'premium';
                $user->save();
          
                $pointlog = new PointLog;
                $pointlog->user_id = $user->id;
                $pointlog->jml_point = 10;
                $pointlog->poin_before = 0;
                $pointlog->poin_after = 10;
                $pointlog->keterangan = 'You get an extra point from Register';
                $pointlog->save();
      
                $userlog = new UserLog;
                $userlog->user_id = $user->id;
                $userlog->type = 'membership';
                $userlog->value = 'premium';
                $userlog->keterangan = "Add Bonus user from admin";
                $userlog->save();
          
                //email data ke user
                $dt = Carbon::now();
                $dt->setDateFrom($valid);
                $dataEmail = [
                  "email" => $value->email,
                  "password" => $password,
                  "valid_until" => $dt->toDateTimeString(),
                ];
                Mail::send('emails.welcome', $dataEmail, function ($message) use ($dataEmail) {
                  $message->from('no-reply@omnifluencer.com', 'Omnifluencer');
                  $message->to($dataEmail['email']);
                  $message->subject('[Omnifluencer] Bonus Berlangganan Omnifluencer');
                });
                if(env('MAIL_HOST')=='smtp.mailtrap.io'){
                  sleep(1);
                }
                
              }
            }
          }
        }
      }else{
        $arr = [
          "status" => "error",
          "message" => "Not Authorize",
        ];
      }
      return $arr;
    }


}
