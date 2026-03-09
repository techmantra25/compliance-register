<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarRoom;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Assembly;

class NotificationController extends Controller
{
   public function latest()
    {
        $notifications = Notification::whereDate('created_at', Carbon::today())
            ->where('is_read', 0)
            ->latest()
            ->take(10)
            ->get();

        return response()->json($notifications);
    }
    public function markRead($id)
    {
        $notification = Notification::find($id);

        if($notification){
            $notification->is_read = 1;
            $notification->save();
        }

        return response()->json([
            'success' => true
        ]);
    }

   public function receiveIncident(Request $request)
    {
       // Log full request
        Log::info('WhatsApp Webhook Request', [
            'all_data' => $request->all(),
        ]);

        $message = $request->input('message');

        if (!$message) {
            Log::warning('No message received in webhook');

            return response()->json([
                'status' => false,
                'message' => 'No message received'
            ]);
        }

        $lines = explode("\n",$message);

        $data = [];

        foreach($lines as $line){

            if(str_contains($line,'Assembly:')){
                $data['assembly'] = trim(str_replace('Assembly:','',$line));
            }

            if(str_contains($line,'Booth / Area:')){
                $data['booth_area'] = trim(str_replace('Booth / Area:','',$line));
            }

            if(str_contains($line,'Incident Type:')){
                $data['incident_type'] = trim(str_replace('Incident Type:','',$line));
            }

            if(str_contains($line,'Severity:')){
                $data['severity'] = trim(str_replace('Severity:','',$line));
            }

            if(str_contains($line,'Incident Description:')){
                $data['incident_description'] = trim(str_replace('Incident Description:','',$line));
            }

            if(str_contains($line,'Reported By:')){
                $data['reported_by'] = trim(str_replace('Reported By:','',$line));
            }

            if(str_contains($line,'Contact Number:')){
                $data['contact_number'] = trim(str_replace('Contact Number:','',$line));
            }

            if(str_contains($line,'Incident Time:')){
                $data['incident_time'] = trim(str_replace('Incident Time:','',$line));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Assembly Match
        |--------------------------------------------------------------------------
        */

        $assembly = null;

        if(!empty($data['assembly'])){

            $assemblyValue = trim($data['assembly']);

            $assembly = Assembly::where('assembly_code',$assemblyValue)
                ->orWhere('assembly_number',$assemblyValue)
                ->orWhere('assembly_name_en','LIKE',"%{$assemblyValue}%")
                ->orWhere('assembly_name_bn','LIKE',"%{$assemblyValue}%")
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | War Code Generate
        |--------------------------------------------------------------------------
        */

        $warCode = $this->generateWarCode($assembly ? $assembly->id : null);

        /*
        |--------------------------------------------------------------------------
        | Insert Incident
        |--------------------------------------------------------------------------
        */

        $incident = WarRoom::create([
            'war_code' => $warCode,
            'assembly_id' => $assembly->id ?? null,
            'district_id' => $assembly->district_id ?? null,
            'booth_area' => $data['booth_area'] ?? null,
            'incident_type' => $data['incident_type'] ?? null,
            'severity' => $data['severity'] ?? null,
            'incident_description' => $data['incident_description'] ?? null,
            'reported_by' => $data['reported_by'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,
            'incident_time' => $data['incident_time'] ?? null,
            'status' => 'pending'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        $assemblyName = $assembly->assembly_name_en ?? 'Unknown Assembly';

        Notification::create([
            'title' => 'New Election Incident from '.$assemblyName,
            'url' => route('admin.war_room'),
            'is_read' => 0
        ]);

        return response()->json([
            'status'=>true,
            'message'=>'Incident captured successfully'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | War Code Generator
    |--------------------------------------------------------------------------
    */

    private function generateWarCode($assemblyId = null)
    {
        if($assemblyId){

            $assembly = Assembly::find($assemblyId);

            $assemblyNumber = $assembly->assembly_number;

            $max = WarRoom::where('assembly_id',$assemblyId)->max('war_code');

            $next = $max ? intval(substr($max,-4)) + 1 : 1;

            $sequence = str_pad($next,4,'0',STR_PAD_LEFT);

            return "WR".$assemblyNumber.$sequence;
        }

        // If assembly not found

        $max = WarRoom::whereNull('assembly_id')->max('war_code');

        $next = $max ? intval(substr($max,-4)) + 1 : 1;

        $sequence = str_pad($next,4,'0',STR_PAD_LEFT);

        return "WR0000".$sequence;
    }
}
