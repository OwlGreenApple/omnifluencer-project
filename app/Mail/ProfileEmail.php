<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Account;
use PDF,Excel,Auth;

class ProfileEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $emaildata;
    protected $type;
    protected $id;

    public function __construct($emaildata,$type,$id)
    {
        $this->emaildata = $emaildata;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $account = Account::find($this->id);

      if($this->type=='pdf'){
        $data = array(
          'account' => $account,   
        );

        $pdf = PDF::loadView('user.pdf-profile', $data)
                ->setPaper('a4')
                ->setOption('margin-bottom', '0mm')
                ->setOption('margin-top', '0mm')
                ->setOption('margin-right', '0mm')
                ->setOption('margin-left', '0mm');

        $filename = "profile ".$account->username.".pdf";

        return $this->from('no-reply@omnifluencer.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attachData($pdf->output(),$filename)
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      } else {
        $store = '/storage/app/'.Auth::user()->email.'/profile.xlsx';

        $Excel_file = Excel::create('profile', function($excel) use ($account) {
          $excel->sheet('list', function($sheet) use ($account) {
            $username = '@'.$account->username;
            $sheet->cell('C2', $username); 
            $sheet->cell('C3', $account->fullname); 

            $sheet->cell('B4', 'Engagement Rate'); 
            $sheet->cell('C4', $account->eng_rate*100); 

            $influence = round($account->total_influenced);

            $sheet->cell('B5', 'Total Influenced'); 
            $sheet->cell('C5', $influence);

            $sheet->cell('B6', 'Post'); 
            $sheet->cell('C6', $account->jml_post);

            $sheet->cell('B7', 'Followers'); 
            $sheet->cell('C7', $account->jml_followers);

            $sheet->cell('B8', 'Following'); 
            $sheet->cell('C8', $account->jml_following);
            
            $sheet->cell('B9', 'Last Post'); 
            $sheet->cell('C9', date("M d Y", strtotime($account->lastpost)));

            $sheet->cell('B10', 'Avg Like Per Post');
            $sheet->cell('C10', $account->jml_likes);

            $sheet->cell('B11', 'Avg Comment Per Post'); 
            $sheet->cell('C11', $account->jml_comments);
            //$sheet->fromArray($data);
          });
        })->store('xlsx',storage_path('app/'.Auth::user()->email));

        return $this->from('no-reply@omnifluencer.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attach(asset($store))
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      }
      
    }
}
