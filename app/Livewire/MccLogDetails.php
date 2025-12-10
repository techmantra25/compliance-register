<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mcc;
use App\Models\ChangeLog;

class MccLogDetails extends Component
{
    public $mcc;
    public $timeline = [];

    public function mount($id)
    {
        $this->mcc = Mcc::findOrFail($id);

        $logs = ChangeLog::where('module_name', 'mcc')
            ->where('module_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        $this->timeline = $logs->map(function ($log) {

            $log->old_data = is_string($log->old_data) ? json_decode($log->old_data, true) : ($log->old_data ?? []);
            $log->new_data = is_string($log->new_data) ? json_decode($log->new_data, true) : ($log->new_data ?? []);

            return [
                'title'        => ucfirst($log->action),
                'details'      => $this->formatDetails($log),
                'date'         => $log->created_at->format('d M Y'),
                'time'         => $log->created_at->format('h:i A'),
                'changed_by'   => $log->user ? $log->user->name : null,
                'badge_color'  => $this->getBadgeColor($log->action),
                'icon'         => 'bi-pencil-square',
            ];
        })->toArray();
    }


    private function formatDetails($log)
    {
        $action = strtolower($log->action);

        if (in_array($action, ['insert', 'update'])) {
            return "<p>{$log->description}</p>";
        }

        if ($action === 'status change' || $action === 'action taken') {
            $old = is_array($log->old_data) ? $log->old_data : ($log->old_data ? json_decode($log->old_data, true) : []);
            $new = is_array($log->new_data) ? $log->new_data : ($log->new_data ? json_decode($log->new_data, true) : []);

            $html = "";

            foreach ($new as $key => $value) {
                $oldValue = $old[$key] ?? '-';
                if ($oldValue == $value) continue;

                $html .= "
                    <div class='mb-1'>
                        <strong>".ucwords(str_replace('_',' ', $key))."</strong>:
                        <span class='text-danger'>{$oldValue}</span>
                        <i class='bi bi-arrow-right mx-1'></i>
                        <span class='text-success'>{$value}</span>
                    </div>
                ";
            }

            return $html ?: "<p>{$log->description}</p>";
        }

        return "<p>{$log->description}</p>";
    }

    private function getBadgeColor($action)
    {
        return match($action) {
            'Insert' => 'bg-success',
            'Update' => 'bg-primary',
            'Status Change' => 'bg-warning',
            default => 'bg-secondary'
        };
    }

    public function render()
    {
        return view('livewire.mcc-log-details')->layout('layouts.admin');
    }
}
