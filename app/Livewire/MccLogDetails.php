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
        $old = $log->old_data ?? [];
        $new = $log->new_data ?? [];

        $html = "";

        foreach ($new as $key => $value) {
            $oldValue = $old[$key] ?? '-';

            $html .= "
                <div>
                    <strong>" . ucwords(str_replace('_', ' ', $key)) . "</strong>:
                    <span class='text-danger'>{$oldValue}</span>
                    <i class='bi bi-arrow-right'></i>
                    <span class='text-success'>{$value}</span>
                </div>
            ";
        }

        return $html;
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
