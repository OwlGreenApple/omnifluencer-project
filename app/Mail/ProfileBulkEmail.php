<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Account;
use PDF,Excel,Auth; 

class ProfileBulkEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $emaildata;
    protected $type;
    protected $bulkid;

    public function __construct($emaildata,$type,$bulkid)
    {
        $this->emaildata = $emaildata;
        $this->type = $type;
        $this->bulkid = $bulkid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       if($this->type=='pdf'){
        $account = [];
        foreach ($this->bulkid as $id) {
          $account[] = Account::find($id); 
        }

        $data = array(
          'account' => $account,   
        );

        $pdf = PDF::loadView('user.pdf-profile', $data)
                ->setPaper('a4')
                ->setOption('margin-bottom', '0mm')
                ->setOption('margin-top', '0mm')
                ->setOption('margin-right', '0mm')
                ->setOption('margin-left', '0mm');

        $filename = "profile bulk - ".count($data['account'])." accounts - ".date('d-m-Y').".pdf";

        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attachData($pdf->output(), $filename)
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      } else {
        $store = '/storage/app/'.Auth::user()->email.'/profilebulk.xlsx';

        $bulkid = $this->bulkid;

        $Excel_file = Excel::create('profilebulk', function($excel) use ($bulkid) {
          $i = 1;
          foreach ($bulkid as $id) {
            $sheetname = 'Sheet'.$i;

            $excel->sheet($sheetname, function($sheet) use ($id) {

                $account = Account::find($id); 

                $username = '@'.$account->username;
                $sheet->cell('C2', $username); 

                $sheet->cell('B3', 'Engagement Rate'); 
                $sheet->cell('C3', $account->eng_rate*100); 

                $influence = round($account->total_influenced);

                $sheet->cell('B4', 'Total Influenced'); 
                $sheet->cell('C4', $influence);

                $sheet->cell('B5', 'Post'); 
                $sheet->cell('C5', $account->jml_post);

                $sheet->cell('B6', 'Followers'); 
                $sheet->cell('C6', $account->jml_followers);

                $sheet->cell('B7', 'Following'); 
                $sheet->cell('C7', $account->jml_following);
                
                $sheet->cell('B8', 'Last Post'); 
                $sheet->cell('C8', date("M d Y", strtotime($account->lastpost)));

                $sheet->cell('B9', 'Avg Like Per Post'); 
                $sheet->cell('C9', $account->jml_likes);

                $sheet->cell('B10', 'Avg Comment Per Post'); 
                $sheet->cell('C10', $account->jml_comments);
            });
            $i++;
          }
        })->store('xlsx',storage_path('app/'.Auth::user()->email));

        return $this->from('omnifluencer@gmail.com', 'Omnifluencer')
                    ->subject('[Omnifluencer] Profile Document')
                    ->attach(asset($store))
                    ->view('emails.profile-docs')
                    ->with($this->emaildata);
      }
    }
}
