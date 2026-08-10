<?php

namespace App\Http\Livewire\Utils;

use App\Helpers\Helper;
use App\Models\CustomerFeedback;
use Exception;
use Livewire\Component;

class CustomerFeedbackForm extends Component
{
    public $feedback;
    public $success = false;

    protected $listeners = [
        'selectedRating' // listen from StarRating
    ];

    protected $rules = [
        'feedback.rating' => 'required',
        'feedback.comment' => 'nullable',
        'feedback.source' => 'nullable'
    ];

    protected $messages = [
        'feedback.rating.required' => 'Please select ratings',
    ];
    
    public function render()
    {
        $data['last'] = CustomerFeedback::latest()->first();
        return view('livewire.utils.customer-feedback-form', $data);
    }

    public function mount($source)
    {
        $this->feedback['source'] = $source;
    }

    public function store()
    {
        
        $input = $this->validate();
        $input = $input['feedback'];
        try {
            
            $input['user_id'] = auth()->check() ? auth()->id() : null;
            CustomerFeedback::create($input);
            $this->success = true;

        } catch (Exception $th) {
            Helper::throwExeception($th);
        }
    }

    public function selectedRating($rating){
        $this->feedback['rating'] = $rating;
    }
}
