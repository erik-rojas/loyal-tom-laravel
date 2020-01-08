<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Excel;
use App\Click;
use App\Client;
use App\ClientAdvisor;
use App\Feedback;
use App\Occasion;
use App\Tag;
use App\Idea;
use App\Reminder;



class AnalyticsController extends Controller
{
    /**
     * Analytics Controller
     * @return view with all Analytics:
     *  withOccasions($occasions)
     *  withWeek_reminders($week_reminders)
     *  withOccasion_types($occasion_types)
     *  withEngagements($engagements)
     *  withClient_advisors($client_advisors)
     *  withClients_count($clients_count)
     *  withClient_ages($client_ages)
     *  withClient_genders($client_genders)
     *  withClient_tags($client_tags)
     *  withClient_locations($client_locations)
     *  withMonth_ideas($month_ideas)
     *  withCount_feedbacks($count_feedbacks)
     *  withIdeas_no_feedback($ideas_no_feedback);
     */
    public function index()
    {
        $occasions = Occasion::all();

        // Chart 1: REMINDERS BY WEEK.
        // Count Number of reminders to send, Number of reminders sent, Number of extra reminders sent for last 12 weeks
        for ($i = 11; $i >= 0; $i--) {

            $week_reminders[Carbon::now()->subWeek($i)->weekOfYear]['number_of_reminders_to_send'] = Occasion::
            whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();

            $week_reminders[Carbon::now()->subWeek($i)->weekOfYear]['number_of_reminders_sent'] = Occasion::has('reminders')
                ->whereHas('reminders', function($query){
                    $query->where('email_sent', true);
                })
                ->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();

            $week_reminders[Carbon::now()->subWeek($i)->weekOfYear]['number_of_extra_reminders'] = Reminder::whereHas('occasion', function($query) use ($i){
                $query->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()]);
            })
                ->where('email_sent', true)
                ->count() - $week_reminders[Carbon::now()->subWeek($i)->weekOfYear]['number_of_reminders_sent'];
        }

        // Chart 2: COUNTS BASED ON OCCASION TYPE.
        // Count Number of each occasion type
        $occasion_types = Occasion::select('type', DB::raw('count(type) as total'))->groupBy('type')->get();

        // Chart 3: Client Advisors engagement view
        // Count Number of Reminder Emails sent, Extra Reminder Emails sent, Emails opened and clicked
        for ($i = 11; $i >= 0; $i--) {
            $engagements[Carbon::now()->subWeek($i)->weekOfYear]['reminders_sent'] = Occasion::has('reminders')
                ->whereHas('reminders', function($query){
                    $query->where('email_sent', true);
                })
                ->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();

            $engagements[Carbon::now()->subWeek($i)->weekOfYear]['extra_reminders_sent'] = Reminder::whereHas('occasion', function($query) use ($i){
                $query->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()]);
            })
                ->where('email_sent', true)
                ->count() - $engagements[Carbon::now()->subWeek($i)->weekOfYear]['reminders_sent'];

            $engagements[Carbon::now()->subWeek($i)->weekOfYear]['pages_opened'] = Reminder::whereHas('occasion', function ($query) use ($i) {
                $query->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()]);
            })->where('seen', true)
                ->count();

            $engagements[Carbon::now()->subWeek($i)->weekOfYear]['clicks'] = Click::whereBetween('created_at', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();
        }

        //Chart 4: Client Advisors
        $client_advisors = ClientAdvisor::all();

        //Chart 5: Number of clients in DB
        $clients_count = Client::count();

        //Chart 6.1: Age
        $client_ages = Client::select('age', DB::raw('count(age) as total'))->groupBy('age')->get();

        //Chart 6.2: Gender
        $client_genders = Client::select('gender', DB::raw('count(gender) as total'))->groupBy('gender')->get();

        //Chart 6.3: Tags
        $tags = Tag::where('category', 'character')->get();
        foreach ($tags as $tag) {
            $client_tags[$tag->name] = Client::where('like', 'like', '%' . $tag->name . '%')->count();
        }

        //Chart 6.4: Location
        $client_locations = Client::select('country', DB::raw('count(country) as total'))->groupBy('country')->get();

        //Chart 7: Ideas
        for ($i = 5; $i >= 0; $i--) {
            //For each month
            //$month_ideas[Carbon::now()->subMonth($i)->month]['total'] = Idea::whereBetween('created_at', [Carbon::now()->subMonth($i)->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth($i)->endOfMonth()->toDateTimeString()])->count();
            //From start to current month
            $month_ideas[Carbon::now()->subMonth($i)->month]['total'] = Idea::whereDate('created_at', '<', Carbon::now()->subMonth($i)->endOfMonth()->toDateTimeString())->count();
        }

        //Chart 8: Feedback
        $count_feedbacks = Feedback::select('status', DB::raw('count(status) as total'))->groupBy('status')->get();
        $ideas_no_feedback = Idea::doesntHave('feedbacks')->count();


        return view('admin.analytics.index')
            ->withOccasions($occasions)
            ->withWeek_reminders($week_reminders)
            ->withOccasion_types($occasion_types)
            ->withEngagements($engagements)
            ->withClient_advisors($client_advisors)
            ->withClients_count($clients_count)
            ->withClient_ages($client_ages)
            ->withClient_genders($client_genders)
            ->withClient_tags($client_tags)
            ->withClient_locations($client_locations)
            ->withMonth_ideas($month_ideas)
            ->withCount_feedbacks($count_feedbacks)
            ->withIdeas_no_feedback($ideas_no_feedback);
    }

    /**
     * Number of occasions recorded
     * @return CSV
     */
    public function exportChart1()
    {
        $first_occasion = Occasion::first();
        $diffInDays = Carbon::now()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $first_occasion->created_at));
        $previous_day = 0;
        $progress_total = 0;
        for($i = $diffInDays; $i >= 0; $i--){
            $occasions[$i]['Day Index'] = Carbon::now()->subDays($i)->toDateString();
            $occasions[$i]['Occasions'] = Occasion::whereDate('created_at', '<', Carbon::now()->subDays($i)->toDateTimeString())->count();
            if($previous_day){
                $occasions[$i]['Progress'] = round((($occasions[$i]['Occasions']-$previous_day)/$previous_day)*100).'%';
                $progress_total += (($occasions[$i]['Occasions']-$previous_day)/$previous_day)*100;
            }
            else{
                $occasions[$i]['Progress'] = 'null';
            }
            $previous_day = $occasions[$i]['Occasions'];
        }
        $occasions[$diffInDays+1]['Day Index'] = 'TOTAL:';
        $occasions[$diffInDays+1]['Occasions'] = Occasion::count();
        $occasions[$diffInDays+1]['Progress'] = $progress_total/($diffInDays-1).'%';

        return Excel::create('occasions-recorded-report-'.Carbon::now()->toDateString(), function($excel) use ($occasions) {
            $excel->sheet('mySheet', function($sheet) use ($occasions)
            {
                $sheet->fromArray($occasions);
            });
        })->download('csv');


    }

    /**
     * Reminders
     * @return CSV
     */
    public function exportChart2()
    {
        $first_reminder = Reminder::orderBy('created_at', 'ask')->first();
        $diffInWeeks = Carbon::now()->diffInWeeks(Carbon::createFromFormat('Y-m-d H:i:s', $first_reminder->created_at));
        $remindersToSend = 0;
        $remindersSend = 0;
        $extraReminders = 0;
        for ($i = $diffInWeeks; $i >= 0; $i--){
            $reminders[$i]['Week index'] = Carbon::now()->subWeek($i)->startOfWeek()->format('d').'-'.Carbon::now()->subWeek($i)->endOfWeek()->format('d.m.Y');
            $reminders[$i]['Reminders to send'] = Occasion::whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])->count();
            $remindersToSend += $reminders[$i]['Reminders to send'];

            $reminders[$i]['Reminders sent'] = Occasion::has('reminders')
                ->whereHas('reminders', function($query){
                    $query->where('email_sent', true);
                })
                ->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();
            $remindersSend += $reminders[$i]['Reminders sent'];

            $reminders[$i]['Extra reminders'] = Reminder::whereHas('occasion', function($query) use ($i){
                    $query->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()]);
                })
                    ->where('email_sent', true)
                    ->count() - $reminders[$i]['Reminders sent'];
            $extraReminders += $reminders[$i]['Extra reminders'];

        }
        $reminders[$diffInWeeks+1]['Week index'] = 'TOTAL:';
        $reminders[$diffInWeeks+1]['Reminders to send'] = $remindersToSend;
        $reminders[$diffInWeeks+1]['Reminders sent'] = $remindersSend;
        $reminders[$diffInWeeks+1]['Extra reminders'] = $extraReminders;

        return Excel::create('reminders-'.Carbon::now()->toDateString(), function($excel) use ($reminders) {
            $excel->sheet('mySheet', function($sheet) use ($reminders)
            {
                $sheet->fromArray($reminders);
            });
        })->download('csv');
    }

    /**
     * COUNTS BASED ON OCCASION TYPE
     * @return CSV
     */
    public function exportChart3()
    {
        $occasion_types = Occasion::select('type as Type', DB::raw('count(type) as Total'))->groupBy('type')->get()->toArray();
        $occasion_total = Occasion::count();
        foreach($occasion_types as $key=>$occasion_type){
            $occasion_types[$key]['% from total'] = round(($occasion_types[$key]['Total']*100)/$occasion_total);
        }

        $occasion_types[] = ['Type' => 'TOTAL:', 'Total' => $occasion_total];

        return Excel::create('occasions-types-'.Carbon::now()->toDateString(), function($excel) use ($occasion_types) {
            $excel->sheet('mySheet', function($sheet) use ($occasion_types)
            {
                $sheet->fromArray($occasion_types);
            });
        })->download('csv');
    }

    /**
     * CA engagement
     * @return CSV
     */
    public function exportChart4()
    {
        $first_reminder = Reminder::orderBy('created_at', 'ask')->first();

        $reminders_previous_week = 0;
        $extra_reminders_previous_week = 0;
        $reminder_Emails_sent_total = 0;
        $extra_reminder_Emails_sent_total = 0;
        $reminder_pages_opened_total = 0;
        $open_rate_total = 0;
        $buy_buttons_clicked_total = 0;
        $click_through_rate_total = 0;

        $diffInWeeks = Carbon::now()->diffInWeeks(Carbon::createFromFormat('Y-m-d H:i:s', $first_reminder->created_at));
        for ($i = $diffInWeeks; $i >= 0; $i--){
            $engagement[$i]['Week index'] = Carbon::now()->subWeek($i)->startOfWeek()->format('d').'-'.Carbon::now()->subWeek($i)->endOfWeek()->format('d.m.Y');

            //Reminders
            $engagement[$i]['Reminder Emails sent'] = Occasion::has('reminders')
                ->whereHas('reminders', function($query){
                    $query->where('email_sent', true);
                })
                ->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();
            if($reminders_previous_week){
                $engagement[$i]['Change vs last week %'] = round((($engagement[$i]['Reminder Emails sent'] - $reminders_previous_week)*100)/$reminders_previous_week).'%';
            }else{
                $engagement[$i]['Change vs last week %'] = 'null';
            }
            $reminders_previous_week = $engagement[$i]['Reminder Emails sent'];
            $reminder_Emails_sent_total += $engagement[$i]['Reminder Emails sent'];

            //Extra Reminders
            $engagement[$i]['Extra reminder Emails sent'] = Reminder::whereHas('occasion', function($query) use ($i){
                    $query->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()]);
                })
                    ->where('email_sent', true)
                    ->count() - $engagement[$i]['Reminder Emails sent'];
            if($extra_reminders_previous_week){
                $engagement[$i]['Change vs last week [abs]'] = $extra_reminders_previous_week - $engagement[$i]['Extra reminder Emails sent'];
            }else{
                $engagement[$i]['Change vs last week [abs]'] = 'null';
            }
            $extra_reminders_previous_week = $engagement[$i]['Extra reminder Emails sent'];
            $extra_reminder_Emails_sent_total += $engagement[$i]['Extra reminder Emails sent'];

            //Reminder pages opened
            $engagement[$i]['Reminder pages opened'] = Reminder::whereHas('occasion', function ($query) use ($i) {
                $query->whereBetween('due_date', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()]);
            })->where('seen', true)
                ->count();
            $reminder_pages_opened_total += $engagement[$i]['Reminder pages opened'];

            if(($engagement[$i]['Reminder Emails sent']+$engagement[$i]['Extra reminder Emails sent']) == 0){
                $engagement[$i]['Open rate'] = '0';
            }else{
                $engagement[$i]['Open rate'] = round(($engagement[$i]['Reminder pages opened']*100)/($engagement[$i]['Reminder Emails sent']+$engagement[$i]['Extra reminder Emails sent'])).'%';
                $open_rate_total += $engagement[$i]['Open rate'];
            }

            $engagement[$i]['Buy buttons clicked'] = Click::whereBetween('created_at', [Carbon::now()->subWeek($i)->startOfWeek()->toDateString(), Carbon::now()->subWeek($i)->endOfWeek()->toDateString()])
                ->count();
            $buy_buttons_clicked_total += $engagement[$i]['Buy buttons clicked'];

            if($engagement[$i]['Reminder pages opened'] == 0){
                $engagement[$i]['Click Through rate'] = '0';
            }else{
                $engagement[$i]['Click Through rate'] = ($engagement[$i]['Buy buttons clicked']*100)/$engagement[$i]['Reminder pages opened'].'%';
                $click_through_rate_total += $engagement[$i]['Click Through rate'];
            }
            
        }

        if(!$diffInWeeks){
            $diffInWeeks = 1;
        }
        $engagement[] = [
            'Week index' => 'TOTAL:',
            'Reminder Emails sent' => $reminder_Emails_sent_total,
            'Change vs last week %' => ' ',
            'Extra reminder Emails sent' => $extra_reminder_Emails_sent_total,
            'Change vs last week [abs]' => ' ',
            'Reminder pages opened' => $reminder_pages_opened_total,
            'Open rate' => ($open_rate_total)/$diffInWeeks.'%',
            'Buy buttons clicked' => $buy_buttons_clicked_total,
            'Click Through rate' => $click_through_rate_total/$diffInWeeks.'%',
        ];

        return Excel::create('CA-engagement-'.Carbon::now()->toDateString(), function($excel) use ($engagement) {
            $excel->sheet('mySheet', function($sheet) use ($engagement)
            {
                $sheet->fromArray($engagement);
            });
        })->download('csv');
    }

    /**
     * Client Advisors Leaderboard
     * @return CSV
     */
    public function exportChart5()
    {
        $client_advisors = ClientAdvisor::all();

        $i = 1;
        foreach ($client_advisors as $client_advisor){

            $occasions_total = 0;
            foreach($client_advisor->clients as $client){
                $occasions_total += $client->occasions->count();
            }

            $reminders_total = 0;
            foreach($client_advisor->clients as $client){
                foreach($client->occasions as $occasion){
                    $reminders_total += $occasion->receivedReminders->count();
                }
            }

            $reminders_seen_total = 0;
            foreach($client_advisor->clients as $client){
                foreach($client->occasions as $occasion){
                    $reminders_seen_total += $occasion->seenReminders->count();
                }
            }

            $reminders_clicked_total = 0;
            foreach($client_advisor->clients as $client){
                foreach($client->occasions as $occasion){
                    foreach($occasion->reminders as $one_reminder){
                        $reminders_clicked_total += $one_reminder->clicks->count();
                    }
                }
            }

            $client_advisors_array[] = [
                '#' => $i++,
                'CA name' => $client_advisor->name,
                'CA surname' => $client_advisor->surname,
                'Clients recorded' => $client_advisor->clients->count(),
                'Occasions recorded' => $occasions_total,
                'Emails received' => $reminders_total,
                'Reminder pages opened' => $reminders_seen_total,
                'Buy buttons clicked' => $reminders_clicked_total,

            ];
        }

        return Excel::create('Client-Advisors-Leaderboard-'.Carbon::now()->toDateString(), function($excel) use ($client_advisors_array) {
            $excel->sheet('mySheet', function($sheet) use ($client_advisors_array)
            {
                $sheet->fromArray($client_advisors_array);
            });
        })->download('csv');
    }

    /**
     * Number of clients recorded
     * @return CSV
     */
    public function exportChart6()
    {
        $first_client = Client::first();
        $diffInDays = Carbon::now()->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', $first_client->created_at));
        $previous_day = 0;

        for($i = $diffInDays; $i >= 0; $i--){
            $clients[$i]['Day Index'] = Carbon::now()->subDays($i)->toDateString();
            $clients[$i]['Clients'] = Client::whereDate('created_at', '<', Carbon::now()->subDays($i)->toDateTimeString())->count();

            if($previous_day){
                $clients[$i]['Progress'] = round((($clients[$i]['Clients']-$previous_day)/$previous_day)*100).'%';
            }
            else{
                $clients[$i]['Progress'] = 'null';
            }
            $previous_day = $clients[$i]['Clients'];
        }

        return Excel::create('Number-of-clients-recorded-'.Carbon::now()->toDateString(), function($excel) use ($clients) {
            $excel->sheet('mySheet', function($sheet) use ($clients)
            {
                $sheet->fromArray($clients);
            });
        })->download('csv');

    }

    /**
     * COUNTS BASED ON CLIENTS AGE
     * @return CSV
     */
    public function exportChart7()
    {
        $clients_ages = Client::select('age as Client Age', DB::raw('count(age) as Total'))->groupBy('age')->get()->toArray();
        $clients_total = Client::count();

        foreach($clients_ages as $key=>$clients_age){
            $clients_ages[$key]['% from total'] = round(($clients_ages[$key]['Total']*100)/$clients_total).'%';
        }

        $clients_ages[] = ['Type' => 'TOTAL:', 'Total' => $clients_total];

        return Excel::create('Clients-Age-'.Carbon::now()->toDateString(), function($excel) use ($clients_ages) {
            $excel->sheet('mySheet', function($sheet) use ($clients_ages)
            {
                $sheet->fromArray($clients_ages);
            });
        })->download('csv');
    }

    /**
     * COUNTS BASED ON CLIENTS GENDER
     * @return CSV
     */
    public function exportChart8()
    {
        $clients_genders = Client::select('gender as Client gender', DB::raw('count(gender) as Total'))->groupBy('gender')->get()->toArray();
        $clients_total = Client::count();

        foreach($clients_genders as $key=>$clients_gender){
            $clients_genders[$key]['% from total'] = round(($clients_genders[$key]['Total']*100)/$clients_total).'%';
        }

        $clients_genders[] = ['Type' => 'TOTAL:', 'Total' => $clients_total];

        return Excel::create('Clients-Gender-'.Carbon::now()->toDateString(), function($excel) use ($clients_genders) {
            $excel->sheet('mySheet', function($sheet) use ($clients_genders)
            {
                $sheet->fromArray($clients_genders);
            });
        })->download('csv');
    }

    /**
     * COUNTS BASED ON CLIENTS TAGS
     * @return CSV
     */
    public function exportChart9()
    {
        $tags = Tag::where('category', 'character')->get();
        $tags_total = Tag::count();
        foreach ($tags as $key=>$tag) {
            $client_tags[$key]['Name'] = $tag->name;
            $client_tags[$key]['Total'] = Client::where('like', 'like', '%' . $tag->name . '%')->count();
            $client_tags[$key]['% from total'] = round(($client_tags[$key]['Total']*100)/$tags_total, 2).'%';
            $client_tags[$key]['Doesnt enjoy Total'] = Client::where('dislike', 'like', '%' . $tag->name . '%')->count();
            $client_tags[$key]['% from total dislike'] = round(($client_tags[$key]['Doesnt enjoy Total']*100)/$tags_total, 2).'%';
        }


        $client_tags[] = ['Name' => 'TOTAL:', 'Total' => $tags_total];

        return Excel::create('Clients-tags-'.Carbon::now()->toDateString(), function($excel) use ($client_tags) {
            $excel->sheet('mySheet', function($sheet) use ($client_tags)
            {
                $sheet->fromArray($client_tags);
            });
        })->download('csv');
    }

    /**
     * COUNTS BASED ON CLIENTS LOCATION
     * @return CSV
     */
    public function exportChart10()
    {
        $clients_countries = Client::select('country as Client country', DB::raw('count(country) as Total'))->groupBy('country')->get()->toArray();
        $clients_total = Client::count();

        foreach($clients_countries as $key=>$clients_country){
            $clients_countries[$key]['% from total'] = round(($clients_countries[$key]['Total']*100)/$clients_total).'%';
        }

        $clients_countries[] = ['Type' => 'TOTAL:', 'Total' => $clients_total];

        return Excel::create('Clients-Location-'.Carbon::now()->toDateString(), function($excel) use ($clients_countries) {
            $excel->sheet('mySheet', function($sheet) use ($clients_countries)
            {
                $sheet->fromArray($clients_countries);
            });
        })->download('csv');
    }

    /**
     * Ideas in database
     * @return CSV
     */
    public function exportChart11()
    {
        $first_idea = Idea::first();
        $ideas_total = Idea::count();
        $difInMonth = Carbon::now()->diffInMonths(Carbon::createFromFormat('Y-m-d H:i:s', $first_idea->created_at));
        $previous_month = 0;


        for ($i = $difInMonth; $i >= 0; $i--) {
            $month_ideas[$i]['Month index'] = Carbon::now()->subMonth($i)->format('F Y');
            $month_ideas[$i]['Ideas Count'] = Idea::whereDate('created_at', '<', Carbon::now()->subMonth($i)->endOfMonth()->toDateTimeString())->count();
            if($previous_month){
                $month_ideas[$i]['Progress'] = round((($month_ideas[$i]['Ideas Count'] - $previous_month)*100)/$previous_month, 2).'%';
            }else{
                $month_ideas[$i]['Progress'] = 'null';
            }
            $previous_month = $month_ideas[$i]['Ideas Count'];

        }

        $month_ideas[] = ['Month index'=>'Total:', 'Ideas Count'=>$ideas_total];

        return Excel::create('Ideas-in-database-'.Carbon::now()->toDateString(), function($excel) use ($month_ideas) {
            $excel->sheet('mySheet', function($sheet) use ($month_ideas)
            {
                $sheet->fromArray($month_ideas);
            });
        })->download('csv');
    }

    /**
     * Ideas feedback
     * @return csv
     */
    public function exportChart12()
    {
        $feedbacks = Feedback::select('status as Status', DB::raw('count(status) as Total'))->groupBy('status')->get()->toArray();
        $ideas_no_feedback = Idea::doesntHave('feedbacks')->count();
        $feedbacks_total = Feedback::count() + $ideas_no_feedback ;

        foreach($feedbacks as $key=>$feedback){
            $feedbacks[$key]['% from total'] = round(($feedbacks[$key]['Total']*100)/$feedbacks_total, 2).'%';
        }

        $feedbacks[] = [
            'Status' => 'Ideas without feedback',
            'Total' => $ideas_no_feedback,
            '% from total' => round(($ideas_no_feedback*100)/$feedbacks_total , 2).'%',
        ];
        $feedbacks[] = ['Status' => 'TOTAL:', 'Total' => $feedbacks_total - $ideas_no_feedback];

        return Excel::create('Clients-feedbacks-'.Carbon::now()->toDateString(), function($excel) use ($feedbacks) {
            $excel->sheet('mySheet', function($sheet) use ($feedbacks)
            {
                $sheet->fromArray($feedbacks);
            });
        })->download('csv');
    }
}
