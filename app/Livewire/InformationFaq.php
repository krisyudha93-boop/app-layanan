<?php

namespace App\Livewire;

use App\Models\DownloadableForm;
use App\Models\Faq;
use App\Models\InformationPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Informasi, FAQ & Unduh Formulir â€” SAPA SOSIAL')]
class InformationFaq extends Component
{
    #[Url]
    public string $search = '';

    #[Url]
    public string $tab = 'semua';

    public function setTab(string $selectedTab)
    {
        $this->tab = $selectedTab;
    }

    public function render()
    {
        // 1. FAQs Query
        $faqQuery = Faq::where('is_active', true)->orderBy('sort_order');
        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $faqQuery->where(function ($q) use ($term) {
                $q->where('question', 'ilike', $term)
                  ->orWhere('answer', 'ilike', $term);
            });
        }
        $faqs = $faqQuery->get();

        // 2. Downloadable Forms Query
        $formQuery = DownloadableForm::where('is_current', true);
        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $formQuery->where('name', 'ilike', $term);
        }
        $forms = $formQuery->get();

        // 3. Information Pages Query
        $pageQuery = InformationPage::published();
        if ($this->tab !== 'semua') {
            $pageQuery->where('category', 'ilike', '%' . $this->tab . '%');
        }
        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $pageQuery->where(function ($q) use ($term) {
                $q->where('title', 'ilike', $term)
                  ->orWhere('description', 'ilike', $term);
            });
        }
        $infoPages = $pageQuery->get();

        return view('livewire.information-faq', [
            'faqs' => $faqs,
            'forms' => $forms,
            'infoPages' => $infoPages,
        ]);
    }
}

