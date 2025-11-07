<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TuteursList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['subject', 'city', 'learning_preference'];

    public $subject = '';
    public $city = '';
    public $learning_preference = '';

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['subject', 'city', 'learning_preference']);
        $this->resetPage();
    }

    private function formatSubjects($subjects)
    {
        if (is_string($subjects)) {
            $decoded = json_decode($subjects, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_slice($decoded, 0, 5); // Limiter à 5 matières max
            }

            if (str_contains($subjects, ',')) {
                return array_slice(array_map('trim', explode(',', $subjects)), 0, 5);
            }

            if (str_contains($subjects, ';')) {
                return array_slice(array_map('trim', explode(';', $subjects)), 0, 5);
            }

            return [$subjects];
        }

        if (is_array($subjects)) {
            return array_slice($subjects, 0, 5);
        }

        return ['Matière non spécifiée'];
    }

    public function render()
    {
        $query = User::query()
               ->where([
                ['role_id', 3],
                ['is_active', true]])

        ;

        if ($this->subject) {
            $query->where(function($q) {
                $q->whereJsonContains('subjects', $this->subject)
                    ->orWhere('subjects', 'like', '%' . $this->subject . '%');
            });
        }

        if ($this->city) {
            $query->where('city', 'like', '%' . $this->city . '%');
        }

        if ($this->learning_preference) {
            $query->where('learning_preference', $this->learning_preference);
        }

        $tuteurs = $query->orderBy('firstname')->paginate(2);

        // Formater les matières
        $tuteurs->getCollection()->transform(function ($tuteur) {
            $tuteur->formatted_subjects = $this->formatSubjects($tuteur->subjects);
            return $tuteur;
        });

        return view('livewire.tuteurs-list', compact('tuteurs'));
    }
}
