<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class CredentialIndex extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Step 1
    public $logo, $certificate, $valid_id, $about_us;

    // Step 2
    public $organization_type, $industry_type, $team_size, $year_established, $website, $vision;

    // Step 3
    public $address, $phone, $email;

    public function mount()
    {
        $this->loadStepData();
    }

    private function loadStepData()
    {
        $profile = UserProfile::where('user_id', Auth::id())->first();

        if ($profile) {
            $this->about_us = $profile->about_us;
            $this->organization_type = $profile->organization_type;
            $this->industry_type = $profile->industry_type;
            $this->team_size = $profile->team_size;
            $this->year_established = $profile->year_established;
            $this->website = $profile->website;
            $this->vision = $profile->vision;
            $this->address = $profile->address;
            $this->phone = $profile->phone;
            $this->email = $profile->email;

            // keep existing file paths (so previews can work if you want)
            $this->logo = $profile->logo_path;
            $this->certificate = $profile->certificate_path;
            $this->valid_id = $profile->valid_id_path;
        }
    }

    private function saveStep()
    {
        $data = [];

        if ($this->step === 1) {
    $this->validate([
        'logo' => 'required',
        'certificate' => 'required',
        'valid_id' => 'required',
        'about_us' => 'required|string|min:10',
    ]);

    // Logo
    if ($this->logo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $logoPath = $this->logo->store('uploads/logos', 'public');
        $logoOriginal = $this->logo->getClientOriginalName();
    } else {
        $logoPath = $this->logo;
        $logoOriginal = UserProfile::where('user_id', Auth::id())->value('logo_original_name'); // keep old
    }

    // Certificate
    if ($this->certificate instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $certificatePath = $this->certificate->store('uploads/certificates', 'public');
        $certificateOriginal = $this->certificate->getClientOriginalName();
    } else {
        $certificatePath = $this->certificate;
        $certificateOriginal = UserProfile::where('user_id', Auth::id())->value('certificate_original_name');
    }

    // Valid ID
    if ($this->valid_id instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
        $validIdPath = $this->valid_id->store('uploads/valid_ids', 'public');
        $validIdOriginal = $this->valid_id->getClientOriginalName();
    } else {
        $validIdPath = $this->valid_id;
        $validIdOriginal = UserProfile::where('user_id', Auth::id())->value('valid_id_original_name');
    }

    $data = [
        'about_us'                  => $this->about_us,
        'logo_path'                 => $logoPath,
        'logo_original_name'        => $logoOriginal,
        'certificate_path'          => $certificatePath,
        'certificate_original_name' => $certificateOriginal,
        'valid_id_path'             => $validIdPath,
        'valid_id_original_name'    => $validIdOriginal,
    ];
}

        if ($this->step === 2) {
            $this->validate([
                'organization_type' => 'required',
                'industry_type' => 'required',
                'team_size' => 'required',
                'year_established' => 'required|date',
                'vision' => 'required|string|min:10',
            ]);

            $data = [
                'organization_type' => $this->organization_type,
                'industry_type' => $this->industry_type,
                'team_size' => $this->team_size,
                'year_established' => $this->year_established,
                'website' => $this->website,
                'vision' => $this->vision,
            ];
        }

        if ($this->step === 3) {
            $this->validate([
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
            ]);

            $data = [
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
            ];
        }

        if (!empty($data)) {
            UserProfile::updateOrCreate(
                ['user_id' => Auth::id()],
                array_merge($data, ['is_verified' => false])
            );
        }
    }

    public function nextStep()
    {
        $this->saveStep();
        $this->step++;
        $this->dispatch('step-changed', step: $this->step);
    }

    public function prevStep()
    {
        $this->step--;
        $this->loadStepData();
        $this->dispatch('step-changed', step: $this->step);
    }

    public function save()
    {
        $this->saveStep(); // last step save
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $profile = UserProfile::where('user_id', Auth::id())->first();

        return view('livewire.credential-index', [
            'profile' => $profile
        ]);
    }
}
