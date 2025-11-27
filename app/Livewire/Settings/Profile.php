<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';

    // ALL PROFILE FIELDS
    public $about_us = '';
    public $organization_type = '';
    public $industry_type = '';
    public $team_size = '';
    public $year_established = '';

    public $website = '';
    public $vision = '';
    public $address = '';
    public $phone = '';

    // FILE FIELDS
    public $logo_path = '';
    public $bpl_path = '';
    public $dti_path = '';
    public $logo_original_name = '';
    public $bpl_original_name = '';
    public $dti_original_name = '';
     // file upload temporary variables
    public $logoFile;
    public $bplFile;
    public $dtiFile;


    public bool $isEditing = false;

    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->profile;

        $this->name = $user->name;
        $this->email = $user->email;

        if ($profile) {
            $this->about_us = $profile->about_us;
            $this->organization_type = $profile->organization_type;
            $this->industry_type = $profile->industry_type;
            $this->team_size = $profile->team_size;

            $this->year_established = $profile->year_established
                ? $profile->year_established->format('Y-m-d')
                : '';

            $this->website = $profile->website;
            $this->vision = $profile->vision;
            $this->address = $profile->address;
            $this->phone = $profile->phone;

            // FILE FIELDS
            $this->logo_path = $profile->logo_path;
            $this->bpl_path = $profile->bpl_path;
            $this->dti_path = $profile->dti_path;
            $this->logo_original_name = $profile->logo_original_name;
            $this->bpl_original_name = $profile->bpl_original_name;
            $this->dti_original_name = $profile->dti_original_name;
        }
    }

    public function edit()
    {
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->mount();
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validatedUser = $this->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255', Rule::unique(User::class)->ignore($user->id)],
            // optional: validate files
            'logoFile' => 'nullable|image|max:1024', // 1MB
            'bplFile'  => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'dtiFile'  => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $user->fill($validatedUser);
        if ($user->isDirty('email')) $user->email_verified_at = null;
        $user->save();

        $profile = $user->profile;

        if ($profile) {
            // Handle uploads
            if ($this->logoFile) {
                $logoName = $this->logoFile->getClientOriginalName();
                $profile->logo_path = $this->logoFile->store('profiles', 'public');
                $profile->logo_original_name = $logoName;
            }

            if ($this->bplFile) {
                $bplName = $this->bplFile->getClientOriginalName();
                $profile->bpl_path = $this->bplFile->store('profiles', 'public');
                $profile->bpl_original_name = $bplName;
            }

            if ($this->dtiFile) {
                $dtiName = $this->dtiFile->getClientOriginalName();
                $profile->dti_path = $this->dtiFile->store('profiles', 'public');
                $profile->dti_original_name = $dtiName;
            }

            $profile->update([
                'about_us' => $this->about_us,
                'organization_type' => $this->organization_type,
                'industry_type' => $this->industry_type,
                'team_size' => $this->team_size,
                'year_established' => $this->year_established ?: null,
                'website' => $this->website,
                'vision' => $this->vision,
                'address' => $this->address,
                'phone' => $this->phone,
            ]);
        }

        $this->isEditing = false;
        $this->dispatch('profile-updated', name: $user->name);
    }

    



    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
