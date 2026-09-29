<?php

namespace App\Livewire;

use App\Models\ClientCategory;
use App\Models\ReferralInstitution;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Pelayanan Rehabilitasi Sosial â€” SAPA SOSIAL Kab. Blitar')]
class SocialRehabilitation extends Component
{
    public function render()
    {
        $categories = ClientCategory::all();
        $institutions = ReferralInstitution::where('is_active', true)->get();

        return view('livewire.social-rehabilitation', [
            'categories' => $categories,
            'institutions' => $institutions,
        ]);
    }
}

