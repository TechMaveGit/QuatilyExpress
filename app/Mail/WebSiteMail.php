<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;


class WebSiteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dynamicContent;
    public $type;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param $type file type
     * @param $subject mail subject
     * @param $dynamicContent
     */
    public function __construct($type,$subject,$dynamicContent)
    {
        $this->dynamicContent = $dynamicContent;
        $this->type = $type;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      try{
        $emailContent = DB::table('settings')->where('meta_key',$this->type)->first()->meta_value;
        if($this->dynamicContent){
            foreach($this->dynamicContent as $kk=>$dyn){
                if(str_contains($emailContent, $kk)){
                    $emailContent = Str::replace($kk, $dyn, $emailContent);
                }
            }
        }
        
        return $this->subject($this->subject)->html($emailContent);
      }catch (\Exception $e) {
                        
      }
    }
}
