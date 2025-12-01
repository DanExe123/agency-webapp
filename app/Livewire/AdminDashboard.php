<?php // app/Livewire/AdminDashboard.php - ✅ FIXED FOR post_responses
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Post;
use App\Models\PostResponse;

class AdminDashboard extends Component
{
    public function render()
    {
        // Existing counts
        $totalUsers = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'Admin');
        })->where('account_status', 'verified')->count();

        $pendingVerification = User::where('account_status', 'pending')->count();
        $verifiedAgencies = User::role('Agency')->where('account_status', 'verified')->count();
        $verifiedCompanies = User::role('Company')->where('account_status', 'verified')->count();

        // ✅ FIXED: Count completed_negotiating PostResponses
        $completedNegotiatingCount = PostResponse::where('status', 'completed_negotiating')->count();

        // ✅ TOP 5 AGENCIES by completed_negotiating PostResponses
        $topAgencies = User::role('Agency') // ✅ Capital 'A' matches your role
            ->withCount([
                'postResponses AS completed_negotiating_count' => function($query) {
                    $query->where('status', 'completed_negotiating');
                }
            ])
            ->with('profile')
            ->orderBy('completed_negotiating_count', 'desc')
            ->take(5)
            ->get();

        return view('livewire.admin-dashboard', compact(
            'totalUsers', 'pendingVerification', 'verifiedAgencies', 'verifiedCompanies',
            'completedNegotiatingCount', 'topAgencies'
        ));
    }
}
