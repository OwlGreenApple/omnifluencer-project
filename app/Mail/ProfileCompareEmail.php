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
        $pdf = PDF::loadView('user.pdf-compare', $this->data)->setPaper('a4')
              ->setOrientation('landscape')
              ->setOption('margin-bottom', '0mm')
              ->setOption('margin-top', '0mm')
              ->setOption('margin-right', '0mm')
              ->setOption('margin-left', '0mm');

        $filename = "profile compare - ".count(array_filter($this->data['data']))." accounts - ".date('d-m-Y').".pdf";

        return $this->from('info@omnifluencer.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attachData($pdf->output(), $filename)
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      } else {
        $store = '/storage/app/'.Auth::user()->email.'/profile-compare.xlsx';
        $data = $this->data;

        $Excel_file = Excel::create('profile-compare', function($excel) use ($data) {
          $excel->sheet('list', function($sheet) use ($data) {

            $sheet->cell('B4', 'Engagement Rate'); 
            $sheet->cell('B5', 'Total Influenced'); 
            $sheet->cell('B6', 'Post'); 
            $sheet->cell('B7', 'Followers'); 
            $sheet->cell('B8', 'Following'); 
            $sheet->cell('B9', 'Last Post'); 
            $sheet->cell('B10', 'Avg Like Per Post');
            $sheet->cell('B11', 'Avg Comment Per Post'); 

            $cell = 'C';

            foreach ($data as $account) {
              if(is_null($account)){
                continue;
              }

              $username = '@'.$account->username;
              $sheet->cell($cell.'2', $username); 
              $sheet->cell($cell.'3', $account->fullname); 

              $sheet->cell($cell.'4', $account->eng_rate*100); 

              $influence = round($account->total_influenced);
              $sheet->cell($cell.'5', $influence); 

              $sheet->cell($cell.'6', $account->jml_post);
              $sheet->cell($cell.'7', $account->jml_followers); 
              $sheet->cell($cell.'8', $account->jml_following); 
              
              $sheet->cell($cell.'9', date("M d Y", strtotime($account->lastpost))); 
              $sheet->cell($cell.'10', $account->jml_likes);
              $sheet->cell($cell.'11', $account->jml_comments); 

              $cell++;
            }
            //$sheet->fromArray($data);
          });
        })->store('xlsx',storage_path('app/'.Auth::user()->email));

        return $this->from('info@omnifluencer.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attach(asset($store))
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      }
    }
}
