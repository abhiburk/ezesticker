<?php

namespace App\Http\Livewire\Comment;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class CommentList extends Component
{
    use WithPagination;
    
    public $product = null; 
    protected $listeners = [
        'refreshComments' => '$refresh'
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $product = Product::find($this->product->id);
        $data['comments'] = $product->comments()->simplePaginate(10);
        return view('livewire.comment.comment-list', $data);
    }
}
