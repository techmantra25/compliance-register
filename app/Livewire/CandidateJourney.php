<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\ChangeLog;
use Illuminate\Http\Request;
use Carbon\Carbon; // Use Carbon for date formatting

class CandidateJourney extends Component
{
    public $change_logs,$candidate;
    public $timeline = [];
    public function mount($id)
    {
        
        $this->candidate = Candidate::find($id);
        if (!$this->candidate) {
            abort(404, 'Candidate not found.');
        }
        
        $this->change_logs = ChangeLog::with('user')->where('module_id', $id)
            ->orderBy('created_at', 'ASC')
            ->get();

    }

    private function processTimeline()
    {
        $timeline = [];
        foreach ($this->change_logs as $log) {
            $title = $this->getLogTitle($log);
            $details = $this->getLogDetails($log);
            $badgeColor = $this->getBadgeColor($log);

            $timeline[] = [
                'time' => Carbon::parse($log->created_at)->format('H:i A'),
                'date' => Carbon::parse($log->created_at)->format('M d, Y'),
                'title' => $title,
                'details' => $details,
                'action' => $log->action,
                'module' => $log->module_name,
                'badge_color' => $badgeColor,
                'changed_by' => $log->user ? $log->user->name : null, 
            ];
        }
        $this->timeline = $timeline;
    }

    // Helper to determine the timeline entry title
    private function getLogTitle(ChangeLog $log): string
    {
        if ($log->module_name === 'Document') {
            return $log->document_name . ' - ' . $log->action;
        }
        return $log->module_name . ' ' . $log->action;
    }

    // Helper to determine the timeline entry details
    private function getLogDetails(ChangeLog $log): string
    {
        if ($log->action === 'Verification Update') {
            // Extract the status from the description if possible
            preg_match('/status updated to (\w+)/', $log->description, $matches);
            $status = $matches[1] ?? 'Updated';
            $vettedBy = json_decode($log->new_data, true)['vetted_by'] ?? 'N/A';
            return "Status changed to **{$status}** by **{$vettedBy}**.";
        } elseif ($log->action === 'Update' && $log->old_data === $log->new_data) {
            // Logs 9 and 28 show no data change, so use the generic description
            return $log->description . ' (No effective data change detected in log data)';
        } elseif ($log->module_name === 'Document' && in_array($log->action, ['Uploaded', 'Re-Uploaded'])) {
            $linkText = $log->link ? ' [View Document]' : '';
            return "New file uploaded. {$log->description}{$linkText}";
        }
        return $log->description;
    }

    // Helper to determine the Bootstrap color class
    private function getBadgeColor(ChangeLog $log): string
    {
        switch ($log->action) {
            case 'Insert':
                return 'bg-success';
            case 'Update':
                return 'bg-warning';
            case 'Uploaded':
            case 'Re-Uploaded':
                return 'bg-primary';
            case 'Verification Update':
                if (str_contains($log->description, 'Approved')) return 'bg-success';
                if (str_contains($log->description, 'Rejected')) return 'bg-danger';
                return 'bg-info';
            default:
                return 'bg-secondary';
        }
    }
    
    public function render()
    {
        $this->processTimeline();
        return view('livewire.candidate-journey')->layout('layouts.admin');
    }
}
