<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HistoryCompare;
use App\User;
use App\Account;

use App\Mail\ProfileCompareEmail;

use Auth,PDF,Excel,Validator,Mail;

class CompareController extends Controller
{
  protected function validator(array $data){
    $rules = [
      'email' => 'required|string|email|max:255',
    ];

    return Validator::make($data, $rules);
  }

  public function index(Request $request){
    return view('user.compare.index')
            ->with('id1',$request->id1)
            ->with('id2',$request->id2)
            ->with('id3',$request->id3)
            ->with('id4',$request->id4);
  }

  public function load_compare(Request $request){
    $acc1 = Account::find($request->id1);
    $acc2 = Account::find($request->id2);
    $acc3 = Account::find($request->id3);
    $acc4 = Account::find($request->id4);

    $accounts = array($acc1,$acc2,$acc3,$acc4);

    $arr['view'] = (string) view('user.compare.index')
                      ->with('accounts',$accounts);

    return $arr;
  }

    public function index_history(){
      return view('user.compare-history.index');
    }

    public function load_history_compare(){
      $compares = HistoryCompare::where('user_id',Auth::user()->id)
                  ->orderBy('created_at','desc')
                  ->paginate(15);

      $arr['view'] = (string) view('user.compare-history.content')
                        ->with('compares',$compares);
      $arr['pager'] = (string) view('user.compare-history.pagination')
                        ->with('compares',$compares);
      return $arr;
    }

  public function print_pdf($id){
    $user = User::find(Auth::user()->id);
    $user->count_pdf = $user->count_pdf + 1;
    $user->save();

    $compare = HistoryCompare::find($id);

    $account1 = Account::find($compare->account_id_1);
    $account2 = Account::find($compare->account_id_2);
    $account3 = Account::find($compare->account_id_3);
    $account4 = Account::find($compare->account_id_4);

    $data = array(
      'data' => array($account1,$account2,$account3,$account4
            )
    );

    $pdf = PDF::loadView('user.pdf-compare',$data)
                ->setOrientation('landscape');

    return $pdf->download('omnifluencer.pdf');
  }

  public function print_csv($id){
    $user = User::find(Auth::user()->id);
    $user->count_csv = $user->count_csv + 1;
    $user->save();

    $filename = 'omnifluencer';

    $compare = HistoryCompare::find($id);

    $account1 = Account::find($compare->account_id_1);
    $account2 = Account::find($compare->account_id_2);
    $account3 = Account::find($compare->account_id_3);
    $account4 = Account::find($compare->account_id_4);

    $data = array($account1,$account2,$account3,$account4
    );

    $Excel_file = Excel::create($filename, function($excel) use ($data) {
        $excel->sheet('list', function($sheet) use ($data) {
          /*$objDrawing = new PHPExcel_Worksheet_Drawing;
          $objDrawing->setPath(public_path('img/headerKop.png')); //your image path
          $objDrawing->setCoordinates('A2');
          $objDrawing->setWorksheet($sheet);*/
          
          $cell1 = 'B';
          $cell2 = 'C';

          foreach ($data as $account) {
            if(is_null($account)){
              continue;
            }

            $username = '@'.$account->username;
            $sheet->cell($cell1.'2', $username); 
            $sheet->cell($cell1.'3', $account->eng_rate); 
            $sheet->cell($cell1.'4', $account->jml_post);
            $sheet->cell($cell1.'5', function($cell) {
              $cell->setValue('Post');   
            });
            $sheet->cell($cell1.'6', $account->jml_followers); 
            $sheet->cell($cell1.'7', function($cell) {
              $cell->setValue('Followers');   
            });
            $sheet->cell($cell1.'8', $account->jml_following); 
            $sheet->cell($cell1.'9', function($cell) {
              $cell->setValue('Following');   
            });
            
            $sheet->cell($cell2.'4', date("M d Y", strtotime($account->lastpost))); 
            $sheet->cell($cell2.'5', function($cell) {
              $cell->setValue('Last Post');   
            });
            $sheet->cell($cell2.'6', $account->jml_likes); 
            $sheet->cell($cell2.'7', function($cell) {
              $cell->setValue('Avg Like Per Post');   
            });
            $sheet->cell($cell2.'8', $account->jml_comments); 
            $sheet->cell($cell2.'9', function($cell) {
              $cell->setValue('Avg Comment Per Post');   
            });   

            $cell1++; $cell1++; 
            $cell2++; $cell2++; 
          }
          
          //$sheet->fromArray($data);
        });
      })->download('xlsx');
  }

  public function send_email(Request $request){
    $validator = $this->validator($request->all());

    if(!$validator->fails()){
      $compare = HistoryCompare::find($request->id);

      $account1 = Account::find($compare->account_id_1);
      $account2 = Account::find($compare->account_id_2);
      $account3 = Account::find($compare->account_id_3);
      $account4 = Account::find($compare->account_id_4);

      if($request->type=='pdf'){
        $data = array(
          'data' => array($account1,$account2,$account3,$account4),   
        );
      } else {
        $data = array($account1,$account2,$account3,$account4);
      }
      

      Mail::to($request->email)->queue(new ProfileCompareEmail($request->email,$request->type,$data));

      $arr['status'] = 'success';
      $arr['message'] = 'Email berhasil terkirim';
    } else {
      $arr['status'] = 'error';
      $arr['message'] = $validator->errors()->first();
    }

    return $arr;
  }

  public function delete_compare(Request $request){
    $compare = HistoryCompare::find($request->id)
                ->delete();

    $arr['status'] = 'success';
    $arr['message'] = 'Delete berhasil';

    return $arr;
  }

  public function delete_compare_bulk(Request $request){

    foreach ($request->compareid as $id) {
      $compare = HistoryCompare::find($id)
                ->delete(); 
    }

    $arr['status'] = 'success';
    $arr['message'] = 'Delete berhasil';

    return $arr;
  }
}
