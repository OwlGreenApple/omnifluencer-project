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

        $pdf = PDF::loadView('user.pdf-profile', $data);

        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attachData($pdf->output(), "profile.pdf")
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      } else {
        $store = '/storage/app/'.Auth::user()->email.'/profile.xlsx';

        $Excel_file = Excel::create('profile', function($excel) use ($account) {
          $excel->sheet('list', function($sheet) use ($account) {
            $username = '@'.$account->username;
            $sheet->cell('B2', $username); 
            $sheet->cell('B3', $account->eng_rate); 

            $sheet->cell('B4', $account->jml_post); 
            $sheet->cell('B5', function($cell) {
              $cell->setValue('Post');   
            });
            $sheet->cell('B6', $account->jml_followers); 
            $sheet->cell('B7', function($cell) {
              $cell->setValue('Followers');   
            });
            $sheet->cell('B8', $account->jml_following); 
            $sheet->cell('B9', function($cell) {
              $cell->setValue('Following');   
            });
            
            $sheet->cell('C4', date("M d Y", strtotime($account->lastpost))); 
            $sheet->cell('C5', function($cell) {
              $cell->setValue('Last Post');   
            });
            $sheet->cell('C6', $account->jml_likes); 
            $sheet->cell('C7', function($cell) {
              $cell->setValue('Avg Like Per Post');   
            });
            $sheet->cell('C8', $account->jml_comments); 
            $sheet->cell('C9', function($cell) {
              $cell->setValue('Avg Comment Per Post');   
            });
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
