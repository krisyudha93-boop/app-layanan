<?php

namespace App\Livewire;

use App\Models\Faq;
use App\Models\InformationPage;
use App\Models\ServiceType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar')]
class Home extends Component
{
    public string $ticketNumber = '';

    public function trackTicket()
    {
        $this->validate([
            'ticketNumber' => 'required|min:4',
        ], [
            'ticketNumber.required' => 'Masukkan nomor tiket atau kode pengajuan.',
            'ticketNumber.min' => 'Nomor tiket minimal 4 karakter.',
        ]);

        return redirect()->route('lacak', ['tiket' => trim($this->ticketNumber)]);
    }

    public function render()
    {
        $serviceTypes = ServiceType::where('is_active', true)->get();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $infoPages = InformationPage::published()->take(3)->get();

        return view('livewire.home', [
            'serviceTypes' => $serviceTypes,
            'faqs' => $faqs,
            'infoPages' => $infoPages,
        ]);
    }
}
