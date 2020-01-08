<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reminder;
use Carbon\Carbon;

class smsClientAdvisor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:ClientAdvisor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Sms To ClientAdvisors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $reminders = Reminder::whereHas('occasion', function($query){
            $query->where('sms_date', Carbon::now()->toDateString());
        })->where('status', 'Scheduled')->where('sms_sent', false)->get();

        foreach ($reminders as $reminder) {
            $phones = $reminder->occasion->client->clientAdvisor->mobile_phone;
            $message = 'Hi '.$reminder->occasion->client->clientAdvisor->name.'! '.$reminder->occasion->client->name.'%27s '.$reminder->occasion->type.' is coming up in a week starting '.Carbon::createFromFormat('Y-m-d',$reminder->occasion->due_date)->addWeeks(2)->format('d.m.Y').'. Here are our surprise suggestions: '.route('ca.reminders.show', $reminder->id).' If you have any questions, feel free to email us at welcome@loyaltom.com. Yours, LoyalTom';

//            $myCurl = curl_init();
//            curl_setopt_array($myCurl, array(
//                CURLOPT_URL => 'https://rest.textmagic.com/api/v2/messages',
//                CURLOPT_POST => true,
//                CURLOPT_POSTFIELDS => http_build_query(array("phones" => $phones, "text" => $message))
//            ));
//            curl_setopt($myCurl, CURLOPT_HTTPHEADER, array(
//                'X-TM-Username: surpriseclub',
//                'X-TM-Key: yGZLSLT7eyYvOZCMsUCU52fFb3v7sS'
//            ));
//            $response = curl_exec($myCurl);
//            curl_close($myCurl);

            //SENDING SMS USING eCALL
            $url = "http://www1.ecall.ch/ecallurl/ECALLURL.ASP?WCI=Interface&Function=SendPage&Address=".$phones."&Message=".$message."&AccountName=gian@floriddia.com&AccountPassword=com.floriddia@gian";
            $url = str_replace(' ', '%20', $url);
            $url = str_replace("'", '%27', $url);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_ENCODING,'gzip,deflate');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $data = curl_exec($ch);
            curl_close($ch);


            $reminder->sms_sent = true;
            $reminder->save();
        }

    }
}
