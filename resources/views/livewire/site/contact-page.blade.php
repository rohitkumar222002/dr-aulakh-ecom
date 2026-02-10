<div>
   
<div class="contact-page">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Contact Us</h1>
                <p class="hero-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>
        </div>
    </div>

    <!-- Main Contact Section -->
    <div class="contact-main">
        <div class="container">
            <div class="contact-wrapper">
                <!-- Contact Form -->
                <div class="contact-form-section">
                    <div class="form-header">
                        <h2>Send us a Message</h2>
                        <p>Fill out the form below and our team will get back to you within 24 hours.</p>
                    </div>

                    <form wire:submit.prevent="submitForm" class="contact-form">
                        <!-- Success Message -->
                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <div class="input-group">
                                <i class="fas fa-user"></i>
                                <input 
                                    type="text" 
                                    id="name"
                                    wire:model="name"
                                    placeholder="Enter your full name"
                                    class="@error('name') error @enderror">
                            </div>
                            @error('name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <div class="input-group">
                                <i class="fas fa-envelope"></i>
                                <input 
                                    type="email" 
                                    id="email"
                                    wire:model="email"
                                    placeholder="Enter your email address"
                                    class="@error('email') error @enderror">
                            </div>
                            @error('email')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-group">
                                <i class="fas fa-phone"></i>
                                <input 
                                    type="tel" 
                                    id="phone"
                                    wire:model="phone"
                                    placeholder="Enter your phone number">
                            </div>
                        </div>

                        <!-- Subject Field -->
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <div class="input-group">
                                <i class="fas fa-tag"></i>
                                <input 
                                    type="text" 
                                    id="subject"
                                    wire:model="subject"
                                    placeholder="What is this regarding?"
                                    class="@error('subject') error @enderror">
                            </div>
                            @error('subject')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <div class="input-group">
                                <i class="fas fa-comment"></i>
                                <textarea 
                                    id="message"
                                    wire:model="message"
                                    rows="6"
                                    placeholder="Tell us how we can help you..."
                                    class="@error('message') error @enderror"></textarea>
                            </div>
                            @error('message')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="submit-btn" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitForm">
                                Send Message
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span wire:loading wire:target="submitForm">
                                <i class="fas fa-spinner fa-spin"></i>
                                Sending...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info-section">
                    <!-- Contact Details -->
                    <div class="info-card">
                        <h3>Get in Touch</h3>
                        <p>Have questions? We're here to help. Reach out to us through any of the channels below.</p>
                        
                        <div class="contact-details">
                            <!-- Phone -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="detail-content">
                                    <h4>Phone</h4>
                                    <a href="tel:{{get_setting('company_phone') }}">{{ get_setting('company_phone') }}</a>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="detail-content">
                                    <h4>Email</h4>
                                    <a href="mailto:{{ get_setting('company_email') }}">{{ get_setting('company_email') }}</a>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="detail-content">
                                    <h4>Address</h4>
                                    <p>{{ get_setting('company_address') }}</p>
                                </div>
                            </div>

                            <!-- Hours -->
                          
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="map-card">
                        <h3>Our Location</h3>
                        <div class="map-placeholder">
                            <i class="fas fa-map"></i>
                            <p>Interactive Map Here</p>
                        </div>
                        <a href="#" class="directions-btn">
                            <i class="fas fa-directions"></i>
                            Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

    <style>
    

    .contact-page {
        min-height: 100vh;
        background: var(--bg-light);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Hero Section */
    .contact-hero {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue));
        color: white;
        padding: 25px;
        text-align: center;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Main Contact Section */
    .contact-main {
        padding: 4rem 0;
    }

    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 3rem;
        align-items: start;
    }

    /* Form Section */
    .contact-form-section {
        background: var(--bg-white);
        padding: 2.5rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
    }

    .form-header {
        margin-bottom: 2rem;
    }

    .form-header h2 {
        font-size: 2rem;
        color: var(--text-primary-blue);
        margin-bottom: 0.5rem;
    }

    .form-header p {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    /* Form Styles */
    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary-blue);
    }

    .form-group .input-group {
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 1rem;
        top: 1rem;
        color: var(--text-light);
        z-index: 1;
    }

    .input-group input,
    .input-group textarea {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-size: 1rem;
        transition: all 0.2s;
        background: var(--bg-white);
    }

    .input-group textarea {
        resize: vertical;
        min-height: 150px;
    }

    .input-group input:focus,
    .input-group textarea:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .input-group input.error,
    .input-group textarea.error {
        border-color: var(--danger);
    }

    .error-message {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
    }

    /* Alert */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: var(--radius-sm);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    /* Submit Button */
    .submit-btn {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue));
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--radius-sm);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s;
        margin-top: 1rem;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Contact Info Section */
    .contact-info-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-card,
    .map-card {
        background: var(--bg-white);
        padding: 2rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
    }

    .info-card h3,
    .map-card h3 {
        font-size: 1.5rem;
        color: var(--text-primary-blue);
        margin-bottom: 1rem;
    }

    .info-card > p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    /* Contact Details */
    .contact-details {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .detail-icon {
        width: 3rem;
        height: 3rem;
        background: var(--bg-light);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .detail-content h4 {
        font-size: 0.875rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .detail-content a,
    .detail-content p {
        color: var(--text-primary-blue);
        text-decoration: none;
        font-weight: 500;
        line-height: 1.5;
    }

    .detail-content a:hover {
        color: var(--primary-blue);
    }

    /* Map Card */
    .map-placeholder {
        height: 200px;
        background: linear-gradient(135deg, var(--bg-light), #e5e7eb);
        border-radius: var(--radius-md);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        margin: 1rem 0;
    }

    .map-placeholder i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--text-light);
    }

    .directions-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--bg-light);
        color: var(--text-primary-blue);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        width: 100%;
        justify-content: center;
    }

    .directions-btn:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-1px);
    }

    /* FAQ Section */
    .faq-section {
        padding: 4rem 0;
        background: var(--bg-white);
        border-top: 1px solid var(--border-color);
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2.5rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .section-header p {
        color: var(--text-secondary);
        font-size: 1.125rem;
    }

    .faq-grid {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .faq-item {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: all 0.3s;
    }

    .faq-question {
        width: 100%;
        padding: 1.5rem;
        background: var(--bg-white);
        border: none;
        text-align: left;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.2s;
    }

    .faq-question:hover {
        background: var(--bg-light);
    }

    .faq-answer {
        padding: 0 1.5rem 1.5rem;
        color: var(--text-secondary);
        line-height: 1.6;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .contact-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .contact-info-section {
            order: -1;
        }
        
        .hero-title {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        .contact-hero {
            padding: 4rem 0 3rem;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
        
        .contact-form-section,
        .info-card,
        .map-card {
            padding: 2rem;
        }
        
        .section-header h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 640px) {
        .container {
            padding: 0 1rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1.125rem;
        }
        
        .contact-form-section,
        .info-card,
        .map-card {
            padding: 1.5rem;
        }
        
        .detail-item {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    </style>
</div>

</div>
