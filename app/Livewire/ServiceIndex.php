<?php

namespace App\Livewire;

use App\Models\InformationPage;
use App\Models\ServiceType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Direktori Layanan Sosial â€” SAPA SOSIAL Kab. Blitar')]
class ServiceIndex extends Component
{
    #[Url]
    public string $search = '';

    #[Url]
    public string $kategori = 'semua';

    public function setCategory(string $cat)
    {
        $this->kategori = $cat;
    }

    public function render()
    {
        $query = ServiceType::where('is_active', true);

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'ilike', $term)
                  ->orWhere('description', 'ilike', $term)
                  ->orWhere('category', 'ilike', $term);
            });
        }

        if ($this->kategori !== 'semua') {
            $query->where('category', 'ilike', '%' . $this->kategori . '%');
        }

        $serviceTypes = $query->get();

        // Also fetch published information pages for more comprehensive knowledge
        $infoQuery = InformationPage::published();
        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $infoQuery->where(function ($q) use ($term) {
                $q->where('title', 'ilike', $term)
                  ->orWhere('description', 'ilike', $term);
            });
        }
        $infoPages = $infoQuery->get();

        return view('livewire.service-index', [
            'serviceTypes' => $serviceTypes,
            'infoPages' => $infoPages,
        ]);
    }
}

