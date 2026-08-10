<?php

namespace App\Http\Livewire\Comment;

use App\Models\Product;
use Livewire\Component;

class CommentForm extends Component
{
    public $product = null;
    public $comment = null;
    public $rating = null;
    protected $listeners = [
        'selectedRating' => 'setRating'
    ];

    public function render()
    {
        return view('livewire.comment.comment-form');
    }

    public function mount($product)
    {
        $this->product = $product;
    }

    function rules(){
        return [
            'comment' => 'required',
            'rating' => 'nullable'
        ];
    }

    public function store()
    {
        $this->validate();

        $product = Product::find($this->product->id);
        $product->comments()->create([
            'user_id' => auth()->user()->id,
            'rating' => $this->rating,
            'body' => $this->comment
        ]);

        $this->emit('refreshComments');
        $this->emit('refreshRating');
        $this->emit('alert', 'success', 'Your review is successfully submitted.');
        $this->rating = null;
        $this->comment = null;
    }

    public function setRating($rating){
        $this->rating = $rating;
    }
}
