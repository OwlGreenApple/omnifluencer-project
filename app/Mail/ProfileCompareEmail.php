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
        })->store('xlsx',storage_path('app/'.Auth::user()->email));

        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attach(asset($store))
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      }
    }
}
