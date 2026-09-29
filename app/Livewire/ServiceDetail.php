<?php

namespace App\Livewire;

use App\Models\DownloadableForm;
use App\Models\Faq;
use App\Models\InformationPage;
use App\Models\ServiceType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Detail Layanan â€” SAPA SOSIAL Kab. Blitar')]
class ServiceDetail extends Component
{
    public string $slug = '';

    public function mount(string $slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        // Check for specific service cases or DB information page
        $isDtsen = ($this->slug === 'surat-keterangan-dtsen' || str_contains($this->slug, 'dtsen'));
        $isPbi = ($this->slug === 'reaktivasi-kis-pbi-jk' || str_contains($this->slug, 'pbi') || str_contains($this->slug, 'kis'));
        $isRehsos = ($this->slug === 'pelayanan-rehabilitasi-sosial' || str_contains($this->slug, 'rehabilitasi'));

        $infoPage = InformationPage::where('slug', $this->slug)->first();
        $serviceType = null;

        if ($isDtsen) {
            $serviceType = ServiceType::where('handler', 'dtsen')->first();
        } elseif ($isPbi) {
            $serviceType = ServiceType::where('handler', 'pbi')->first();
        } else {
            $serviceType = ServiceType::where('code', 'REHSOS')->first();
        }

        $forms = DownloadableForm::where('is_current', true)->take(3)->get();
        $faqs = Faq::where('is_active', true)->take(4)->get();

        return view('livewire.service-detail', [
            'isDtsen' => $isDtsen,
            'isPbi' => $isPbi,
            'isRehsos' => $isRehsos,
            'infoPage' => $infoPage,
            'serviceType' => $serviceType,
            'forms' => $forms,
            'faqs' => $faqs,
        ]);
    }
}

