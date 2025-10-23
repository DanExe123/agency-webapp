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
    public $logo, $bpl, $dti, $about_us;

    // Step 2
    public $organization_type, $industry_type, $team_size, $year_established, $website, $vision;

    // Step 3
    public $address, $phone ;

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
            $this->bpl = $profile->bpl_path;
            $this->dti = $profile->dti_path;
        }
    }

    private function saveStep()
    {
        $data = [];

        if ($this->step === 1) {
            $this->validate([
                'logo' => 'required|mimes:pdf,png,jpg,jpeg,doc,docx|max:2048',
                'bpl'  => 'required|mimes:pdf,png,jpg,jpeg,doc,docx|max:2048',
                'dti'  => 'required|mimes:pdf,png,jpg,jpeg,doc,docx|max:2048',
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

            // bpl
            if ($this->bpl instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $bplPath = $this->bpl->store('uploads/bpls', 'public');
                $bplOriginal = $this->bpl->getClientOriginalName();
            } else {
                $bplPath = $this->bpl;
                $bplOriginal = UserProfile::where('user_id', Auth::id())->value('bpl_original_name');
            }

            // Valid ID
            if ($this->dti instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $validIdPath = $this->dti->store('uploads/dtis', 'public');
                $validIdOriginal = $this->dti->getClientOriginalName();
            } else {
                $validIdPath = $this->dti;
                $validIdOriginal = UserProfile::where('user_id', Auth::id())->value('dti_original_name');
            }

            $data = [
                'about_us'                  => $this->about_us,
                'logo_path'                 => $logoPath,
                'logo_original_name'        => $logoOriginal,
                'bpl_path'                  => $bplPath,
                'bpl_original_name'         => $bplOriginal,
                'dti_path'                  => $validIdPath,
                'dti_original_name'         => $validIdOriginal,
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
                'phone' => [
                    'required',
                    'digits:11',
                    'unique:user_profiles,phone'
                ],
            ]);

            $data = [
                'address' => $this->address,
                'phone' => $this->phone,
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
