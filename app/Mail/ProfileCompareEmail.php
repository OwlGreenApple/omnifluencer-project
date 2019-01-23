<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use PDF,Excel,Auth;

class ProfileCompareEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $emaildata;
    protected $type;
    protected $data;

    public function __construct($emaildata,$type,$data)
    {
        $this->emaildata = $emaildata;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      if($this->type=='pdf'){
        $pdf = PDF::loadView('user.pdf-compare', $this->data)->setOrientation('landscape');

        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attachData($pdf->output(), "profile.pdf")
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      } else {
        $store = '/storage/app/'.Auth::user()->email.'/profile-compare.xlsx';
        $data = $this->data;

        $Excel_file = Excel::create('profile-compare', function($excel) use ($data) {
          $excel->sheet('list', function($sheet) use ($data) {

            $sheet->cell('B3', 'Engagement Rate'); 
            $sheet->cell('B4', 'Total Influenced'); 
            $sheet->cell('B5', 'Post'); 
            $sheet->cell('B6', 'Followers'); 
            $sheet->cell('B7', 'Following'); 
            $sheet->cell('B8', 'Last Post'); 
            $sheet->cell('B9', 'Avg Like Per Post'); 
            $sheet->cell('B10', 'Avg Comment Per Post'); 

            $cell = 'C';

            foreach ($data as $account) {
              if(is_null($account)){
                continue;
              }

              $username = '@'.$account->username;
              $sheet->cell($cell.'2', $username); 
              $sheet->cell($cell.'3', $account->eng_rate*100); 

              $influence = round($account->total_influenced);
              $sheet->cell($cell.'4', $influence); 

              $sheet->cell($cell.'5', $account->jml_post);
              $sheet->cell($cell.'6', $account->jml_followers); 
              $sheet->cell($cell.'7', $account->jml_following); 
              
              $sheet->cell($cell.'8', date("M d Y", strtotime($account->lastpost))); 
              $sheet->cell($cell.'9', $account->jml_likes);
              $sheet->cell($cell.'10', $account->jml_comments); 

              $cell++;
            }
            //$sheet->fromArray($data);
          });
        })->store('xlsx',storage_path('app/'.Auth::user()->email));

        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attach(asset($store))
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      }
    }
}