<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class ActivityLogsTable extends Component
{
    use WithPagination;

    public $perPage = 15; // Pagination per page
    public $search = '';  // Optional search by action text

    protected $paginationTheme = 'tailwind';
    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset to first page when search changes
    }

    public function render()
    {
        $logs = ActivityLogs::where('user_id', Auth::id())
            ->when($this->search, fn($query) => $query->where('action', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.activity-logs-table', compact('logs'));
    }
}
