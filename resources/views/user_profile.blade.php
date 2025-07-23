@extends('layouts.main')

@section('title', 'User-Profile')

@section('content')
<style>
    .success-message, .error-message {
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        font-size: 16px;
        display: flex;
        align-items: center;
    }
    .success-message {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .success-message i, .error-message i {
        margin-right: 10px;
    }
</style>

<div class="sect_head">
    <!--<h3>Profile</h3>-->
</div>
<div class="profile_container">
    <div class="profile-header">
        <h1>User Profile</h1>
        <!--<button id="edit-profile-btn" class="btn">-->
        <!--    <i class="fa fa-edit"></i> Edit Profile-->
        <!--</button>-->
    </div>
    <div id="message-container" style="display: none;"></div>
       
           
    <div class="profile-section">
        <div class="profile-info">
            <img src="{{ $user->profile_image ? asset('public/storage/products/' . $user->profile_image) : asset('assets/images/profile.png') }}" 
                 alt="Profile Picture" class="profile-avatar" id="profile-avatar">
            <button id="upload-avatar-btn" class="btn">
                <i class="fa fa-camera"></i> Change Picture
            </button>
        </div>
        
            <div class="profile-form">
        <div class="form-group">
            <label for="username"><i class="fa fa-user"></i> Username</label>
            <input type="text" id="username" name="username" value="{{ $user->first_name }} {{ $user->last_name }}" disabled>
        </div>

        <div class="form-group">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" disabled>
        </div>

        <div style="width: 98%; " class="form-group">
            <label for="phone"><i class="fa fa-phone"></i> Phone</label>
            <input type="text" id="phone" name="phone" value="{{ $user->phone }}" disabled>
        </div>
            </div>
        
        
 <form style="width: 100%; border-top: 1px solid #a3a2a2;" id="profile-form">
      @csrf
            <!-- Image Upload Field -->
            <div class="form-group">
                <label for="image"><i class="fa fa-image"></i> Profile Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <div id="image-preview" style="margin-top: 10px; display: none;">
                    <img id="preview-image" src="" alt="Image Preview" style="max-width: 100px; max-height: 100px;">
                </div>
            </div>

            <!-- Other Fields -->
            <div class="form-group">
                <label for="dob"><i class="fa fa-calendar"></i> Date of Birth</label>
                <input type="date" id="dob" name="dob" value="{{ $user->dob }}">
            </div>

            <div class="form-group">
                <label for="gender"><i class="fa fa-venus-mars"></i> Gender</label>
                <select id="gender" name="gender">
                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="city"><i class="fa fa-building"></i> City</label>
                <input type="text" id="city" name="city" value="{{ $user->city }}">
            </div>

            <div class="form-group">
                <label for="postal_code"><i class="fa fa-location-arrow"></i> Postal Code</label>
                <input type="text" id="postal_code" name="postal_code" value="{{ $user->postal_code }}">
            </div>

            <div class="form-group">
                <label for="country"><i class="fa fa-globe"></i> Country</label>
                <select id="country" name="country">
                    <option value="India" {{ $user->country == 'India' ? 'selected' : '' }}>India</option>
                </select>
            </div>

            <div class="form-group">
                <label for="address"><i class="fa fa-map-marker"></i> Address</label>
                <textarea id="address" name="address">{{ $user->address }}</textarea>
            </div>

            <button type="submit" class="btn" id="save-changes-btn">
                <i class="fa fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#save-changes-btn').click(function (e) {
        e.preventDefault();

        let formData = new FormData($('#profile-form')[0]);

        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const messageContainer = $('#message-container');
                messageContainer.html(`
                    <div class="success-message">
                        <i class="fa fa-check-circle"></i> ${response.message}
                    </div>
                `);
                messageContainer.fadeIn().delay(3000).fadeOut();
            },
            error: function (xhr) {
                const messageContainer = $('#message-container');
                messageContainer.html(`
                    <div class="error-message">
                        <i class="fa fa-times-circle"></i> Error updating profile. Please try again.
                    </div>
                `);
                messageContainer.fadeIn().delay(3000).fadeOut();
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
@endsection






