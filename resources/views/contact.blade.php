

@extends('layouts.main')

@section('title', 'Contact Us')

@section('content')
<!--<div class="sect_head">-->
<!--        <h3>Contact</h3>-->
<!--    </div>-->
<div class="contact_section"style=" margin-top: 100px;">
    <div  class="center_wr">
  <div class="nature_sect_head">
    <h5>Keep Connected</h5>
    <h2>Get in Touch <i class="bi bi-chat-dots-fill"></i></h2>
</div>
        <div class="contact_banner">
            <div class="contact-form-container">
            <h2 style="font-weight: 100;margin-bottom:10px;">Write to us</h2>
            <form action="{{route('contact.store')}}" method="POST" class="contact-form">
                @csrf
                <div class="form-group">
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <input type="text" id="phone" name="phone" placeholder="Enter Your phone" required>
                </div>
                <div class="form-group">
                    <input type="text" id="subject" name="subject" placeholder="Enter the subject" required>
                </div>
                <div class="form-group">
                    <textarea id="message" name="message" rows="5" placeholder="Write your message" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>
        <div class="contact_info">
            <div class="contact_info_border" style="text-align:justify">
                <h2 style="margin-bottom: 50px;"><i class="bi bi-person-lines-fill "></i>  Contact Info</h2>
                    <p style="margin-bottom: 50px;">We’re always excited to hear from our customers, collaborators, and anyone who shares a passion for creativity. <br><br>Whether you have a question, suggestion, or inquiry, we’re here to help.</p>
                    <div class="contact-info">
                        <p>
                            <i class="fas fa-map-marker-alt"></i> 
                            Behind Panchayat Samiti , Near Bhardwaj hospital, <br>Jhujhunu, Rajasthan, India, 333026
                        </p>
                        <a href="tel:+84112345678">
                            <i class="fas fa-phone"></i>+91-9079673886
                        </a>
                        <a href="mailto:info@dtiva.com">
                            <i class="fas fa-envelope"></i> support@mahakaaal.com
                        </a>
                    </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
