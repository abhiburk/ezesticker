<?php

namespace App\Http\Livewire\Utils;

use App\Helpers\Helper;
use App\Models\CustomerFeedback as ModelsCustomerFeedback;
use Exception;
use Livewire\Component;

class CustomerFeedback extends Component
{

    public ModelsCustomerFeedback $feedback;
    
    public function render()
    {
        return view('livewire.utils.customer-feedback');
    }

    public function rules(){
        return [
            'feedback.type' => 'required',
            'feedback.comment' => 'nullable'
        ];
    }

    public function store()
    {
        $input = $this->validate();

        try {
            
            $this->feedback->save();

        } catch (Exception $th) {
            Helper::throwExeception($th);
        }
    }
}
