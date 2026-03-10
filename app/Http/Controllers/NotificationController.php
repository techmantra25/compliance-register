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
        /*
        |--------------------------------------------------------------------------
        | Log Full Webhook Payload
        |--------------------------------------------------------------------------
        */

        Log::info('WhatsApp Webhook Payload', [
            'payload' => $request->all()
        ]);

        /*
        |--------------------------------------------------------------------------
        | Extract WhatsApp Data
        |--------------------------------------------------------------------------
        */

        $entry = $request->input('entry.0.changes.0.value');

        if (!$entry) {
            Log::warning('Invalid WhatsApp webhook structure');

            return response()->json([
                'status' => false,
                'message' => 'Invalid webhook payload'
            ]);
        }

        $contact = $entry['contacts'][0] ?? null;
        $messageObj = $entry['messages'][0] ?? null;

        if (!$messageObj) {

            Log::warning('No message object found in webhook');

            return response()->json([
                'status' => false,
                'message' => 'No message received'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sender Details
        |--------------------------------------------------------------------------
        */

        $incidentFromName = $contact['profile']['name'] ?? null;
        $incidentFromNumber = $messageObj['from'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Message Body
        |--------------------------------------------------------------------------
        */

        $message = $messageObj['text']['body'] ?? null;

        if (!$message) {

            Log::warning('Message body missing');

            return response()->json([
                'status' => false,
                'message' => 'Empty message body'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Parse Message Fields
        |--------------------------------------------------------------------------
        */

        $lines = explode("\n", $message);

        $data = [];

        foreach ($lines as $line) {

            $line = trim($line);

            // AC -> Assembly
            if (str_contains($line, 'AC:')) {
                $data['assembly'] = trim(str_replace('AC:', '', $line));
            }

            // Block/Town
            if (str_contains($line, 'Block/Town:')) {
                $data['block_town'] = trim(str_replace('Block/Town:', '', $line));
            }

            // GP/Ward
            if (str_contains($line, 'GP/Ward:')) {
                $data['gp_word'] = trim(str_replace('GP/Ward:', '', $line));
            }

            // Booth No
            if (str_contains($line, 'Booth No:')) {
                $data['booth_area'] = trim(str_replace('Booth No:', '', $line));
            }

            // Complainant Name
            if (str_contains($line, 'Name of complainant:')) {
                $data['reported_by'] = trim(str_replace('Name of complainant:', '', $line));
            }

            // Phone
            if (str_contains($line, 'Complainant phone no:')) {
                $data['contact_number'] = trim(str_replace('Complainant phone no:', '', $line));
            }

            // Complaint Details
            if (str_contains($line, 'Complaint details:')) {
                $data['incident_description'] = trim(str_replace('Complaint details:', '', $line));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Assembly Match
        |--------------------------------------------------------------------------
        */
        
        Log::info('Parsed WhatsApp Message', [
            'from_name' => $incidentFromName,
            'from_number' => $incidentFromNumber,
            'message' => $message,
            'data' => $data
        ]);
        
        $assembly = null;

        if (!empty($data['assembly'])) {

            $assemblyValue = trim($data['assembly']);

            $assembly = Assembly::where('assembly_code', $assemblyValue)
                ->orWhere('assembly_number', $assemblyValue)
                ->orWhere('assembly_name_en', 'LIKE', "%{$assemblyValue}%")
                ->orWhere('assembly_name_bn', 'LIKE', "%{$assemblyValue}%")
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Generate War Code
        |--------------------------------------------------------------------------
        */

        $warCode = $this->generateWarCode($assembly ? $assembly->id : null);

        /*
        |--------------------------------------------------------------------------
        | Save Incident
        |--------------------------------------------------------------------------
        */

        $incident = WarRoom::create([

            'war_code' => $warCode,

            'incident_from_name' => $incidentFromName,
            'incident_from_number' => $incidentFromNumber,

            'assembly_id' => $assembly->id ?? null,
            'district_id' => $assembly->district_id ?? null,

            'block_town' => $data['block_town'] ?? null,
            'gp_word' => $data['gp_word'] ?? null,
            'booth_area' => $data['booth_area'] ?? null,

            'incident_description' => $data['incident_description'] ?? null,

            'reported_by' => $data['reported_by'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,

            'status' => 'pending'
        ]);

        Log::info('Incident Stored', [
            'war_code' => $warCode,
            'incident_id' => $incident->id
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        $assemblyName = $assembly->assembly_name_en ?? 'Unknown Assembly';

        Notification::create([
            'title' => 'New Election Incident from ' . $assemblyName,
            'url' => route('admin.war_room'),
            'is_read' => 0
        ]);

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => true,
            'message' => 'Incident captured successfully'
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
