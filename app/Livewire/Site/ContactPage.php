<?php

namespace App\Livewire;

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
        $this->openFaqs = array_fill(0, count($this->faqs), false);
    }

    public function getFaqsProperty()
    {
        return [
            [
                'question' => 'How quickly do you respond to inquiries?',
                'answer' => 'We typically respond to all inquiries within 24 hours during business days. For urgent matters, please call our support line.'
            ],
            [
                'question' => 'What information should I include in my message?',
                'answer' => 'Please include your name, contact information, and a detailed description of your inquiry. The more information you provide, the better we can assist you.'
            ],
            [
                'question' => 'Do you provide phone support?',
                'answer' => 'Yes, we provide phone support during business hours (9AM - 6PM, Monday to Friday). You can reach us at +91 98765 43210.'
            ],
            [
                'question' => 'Can I schedule a meeting?',
                'answer' => 'Absolutely! Please mention your preferred date and time in your message, and we\'ll get back to you to confirm the appointment.'
            ],
            [
                'question' => 'Is there a cost for consultation?',
                'answer' => 'Initial consultations are free. We\'ll discuss your needs and provide information about our services without any obligation.'
            ],
        ];
    }

    public function toggleFaq($index)
    {
        $this->openFaqs[$index] = !$this->openFaqs[$index];
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
        return view('livewire.contact-page');
    }
}