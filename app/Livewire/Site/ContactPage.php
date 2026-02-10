<?php

namespace App\Livewire\Site;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactPage extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';
    public $openFaqs = [];

    protected $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'required|email',
        'subject' => 'required|min:5|max:200',
        'message' => 'required|min:10|max:2000',
        'phone' => 'nullable|regex:/^[0-9+\-\s]+$/',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'subject.required' => 'Please enter a subject.',
        'message.required' => 'Please enter your message.',
        'phone.regex' => 'Please enter a valid phone number.',
    ];

    public function mount()
    {
        // Initialize all FAQs as closed
    }

   
   

    public function submitForm()
    {
        // Validate form data
        $validatedData = $this->validate();

        try {
            // Send email (configure your mail settings first)
            // Mail::to('admin@yourdomain.com')->send(new ContactFormMail($validatedData));
            
            // Here you can also save to database if needed
            // ContactMessage::create($validatedData);

            // Clear form
            $this->reset(['name', 'email', 'phone', 'subject', 'message']);

            // Show success message
            session()->flash('success', 'Thank you! Your message has been sent successfully. We\'ll get back to you soon.');

        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.site.contact-page');
    }
}