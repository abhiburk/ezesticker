<?php

namespace App\Http\Livewire\Utils;

use Livewire\Component;

class StarRating extends Component
{
    public $rating = 0;
    protected $listeners = [
        'refreshRating' => 'resetRating'
    ];

    public function render()
    {
        return view('livewire.utils.star-rating');
    }

    public function rating($rating)
    {
        
        $this->rating = $rating;
        $this->emit('selectedRating', $this->rating);

    }

    public function resetRating(){
        $this->rating = 0;
    }
}
