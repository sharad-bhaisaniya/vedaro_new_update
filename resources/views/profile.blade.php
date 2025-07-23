@extends('layouts.main')

@section('content')

<style>
    .sidebar-button {
        background-color: #fff;
        border: none;
        text-align: left;
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .sidebar-button:hover,
    .sidebar-button.active {
        background-color: #f0fdf4;
        color: #16a34a;
        font-weight: bold;
    }

    .profile-picture {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #22c55e;
    }

    .profile-form input,
    .profile-form select {
        border-radius: 8px;
        padding: 10px;
    }
</style>



<div class="container py-5" style="margin-top:110px;">
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h2 class="mb-4 text-center">My Account</h2>

    <div class="row mb-5">
        <!-- Sidebar -->
        <div class="col-md-3 bg-white shadow-sm rounded py-3">
            <div class="text-center mb-4">
             
                <img src="{{ asset('storage/app/private/public/profile_images/' . $user->profile_image) }}" alt="Profile" class="profile-picture">
            


                <h6 class="mt-2">{{ $user->first_name .' '.$user->last_name ?? 'User' }}</h6>
            </div>

            <button class="sidebar-button active" onclick="showSection('profile', this)">Personal Information</button>
            <button class="sidebar-button bg-light"> <a  href="/fetch-shiprocket-orders" class="text-dark text-decoration-none">My Order's</a></botton>
            <button class="sidebar-button bg-light" onclick="showSection('address', this)">Manage Address</button>
            <button class="sidebar-button bg-light">Payment Method</button>
            <!--<button class="sidebar-button bg-light" onclick="showSection('address', this)">Address Management</button>-->
            <button class="sidebar-button bg-light" onclick="showSection('password', this)">Password Manager</button>
            <button class="sidebar-button bg-light"> <a  href="{{route('logout')}}" class=" text-danger text-decoration-none">Logout</a></botton>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="bg-white p-4 py-5 rounded shadow-sm profile-form">
                <h4 class="mb-4">👤 My Profile</h4>

                {{-- Profile Info --}}
       <div id="profileSection">
        <div class="card mb-4 position-relative">
            <!-- Edit & Cancel Buttons -->
            <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
            <button type="button" id="editBtn" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button type="button" id="cancelBtn" class="btn btn-outline-danger btn-sm d-none">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>

        <div class="card-header">Profile Info</div>

        <div class="card-body w-100">
          <form id="profileForm" action="{{ route('user.updateProfile') }}" method="POST"enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" 
                               value="{{ $user->first_name ?? '' }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" 
                               value="{{ $user->last_name ?? '' }}" disabled>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="{{ $user->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" 
                           value="{{ $user->phone }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-select" disabled>
                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                     <div class="mb-3">
        <label>Profile Image</label><br>
        @if ($user->profile_image)
            <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" width="100" class="mb-2 rounded-circle" />
        @endif
        <input type="file" name="profile_image" class="form-control" accept="image/*" {{ $disabled ?? 'disabled' }}>
    </div>
                <button type="submit" id="updateBtn" class="btn btn-primary d-none">Update Profile</button>
            </form>
        </div>
    </div>
</div>
        
        <script>
            const editBtn = document.getElementById('editBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const updateBtn = document.getElementById('updateBtn');
            const form = document.getElementById('profileForm');
        
            const originalValues = {};
        
            // Store original values on page load
            document.querySelectorAll('#profileForm input, #profileForm select').forEach(field => {
                originalValues[field.name] = field.value;
            });
        
            editBtn.addEventListener('click', function () {
                form.querySelectorAll('input, select').forEach(field => field.removeAttribute('disabled'));
                updateBtn.classList.remove('d-none');
                cancelBtn.classList.remove('d-none');
                editBtn.classList.add('d-none');
            });
        
            cancelBtn.addEventListener('click', function () {
                // Reset values to original
                form.querySelectorAll('input, select').forEach(field => {
                    field.value = originalValues[field.name];
                    field.setAttribute('disabled', 'disabled');
                });
        
                updateBtn.classList.add('d-none');
                cancelBtn.classList.add('d-none');
                editBtn.classList.remove('d-none');
            });
        </script>
        



              {{-- Password Section --}}
                <div id="passwordSection" style="display:none;">
                    <div class="card mb-4 position-relative">
                        <!-- Edit Icon -->
                        <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
                    <button type="button" id="editPasswordBtn" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="button" id="cancelPasswordBtn" class="btn btn-outline-danger btn-sm d-none">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            
                    <div class="card-header">Change Password</div>
                    <div class="card-body w-100">
                       <form id="passwordForm" action="{{ route('user.updatePassword') }}" method="POST">
            
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label>Current Password</label>
                                <input type="password" name="current_password" class="form-control" disabled>
                            </div>
                            <div class="mb-3">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" disabled>
                            </div>
                            <div class="mb-3">
                                <label>Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" disabled>
                            </div>
                            <button type="submit" id="updatePasswordBtn" class="btn btn-warning d-none">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
                
                        
        <!--     {{-- Address Section --}}-->
        <!--    <div id="addressSection" style="display:none;">-->
        <!--        <div class="card mb-4 position-relative">-->
                    <!-- Edit Icon -->
        <!--            <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">-->
        <!--                    <button type="button" id="editAddressBtn" class="btn btn-outline-secondary btn-sm">-->
        <!--                        <i class="fas fa-edit"></i> Edit-->
        <!--                    </button>-->
        <!--                    <button type="button" id="cancelAddressBtn" class="btn btn-outline-danger btn-sm d-none">-->
        <!--                        <i class="fas fa-times"></i> Cancel-->
        <!--                    </button>-->
        <!--                </div>-->
        
        <!--        <div class="card-header">Address Details</div>-->
        <!--        <div class="card-body w-100">-->
        <!--            <form id="addressForm" action="{{ route('user.updateAddress') }}" method="POST">-->
        
        <!--                @csrf-->
        <!--                @method('PUT')-->
        <!--                <div class="mb-3">-->
        <!--                    <label>Address Line</label>-->
        <!--                    <input type="text" name="address" class="form-control" value="{{ $user->address }}" disabled>-->
        <!--                </div>-->
        <!--                <div class="row">-->
        <!--                    <div class="col-md-6 mb-3">-->
        <!--                        <label>City</label>-->
        <!--                        <input type="text" name="city" class="form-control" value="{{ $user->city }}" disabled>-->
        <!--                    </div>-->
        <!--                    <div class="col-md-6 mb-3">-->
        <!--                        <label>State</label>-->
        <!--                        <input type="text" name="state" class="form-control" value="{{ $user->state }}" disabled>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="row">-->
        <!--                    <div class="col-md-6 mb-3">-->
        <!--                        <label>Pincode</label>-->
        <!--                        <input type="text" name="pincode" class="form-control" value="{{ $user->pincode }}" disabled>-->
        <!--                    </div>-->
        <!--                    <div class="col-md-6 mb-3">-->
        <!--                        <label>Country</label>-->
        <!--                        <input type="text" name="country" class="form-control" value="{{ $user->country ?? 'India' }}" disabled>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <button type="submit" id="updateAddressBtn" class="btn btn-info d-none">Update Address</button>-->
        <!--            </form>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        {{-- Address Section --}}
<!--<div id="addressSection" style="display:none;">-->
<!--    <div class="card mb-4 position-relative">-->
        <!-- Edit Icon -->
<!--        <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">-->
<!--            <button type="button" id="editAddressBtn" class="btn btn-outline-secondary btn-sm">-->
<!--                <i class="fas fa-edit"></i> Edit-->
<!--            </button>-->
<!--            <button type="button" id="cancelAddressBtn" class="btn btn-outline-danger btn-sm d-none">-->
<!--                <i class="fas fa-times"></i> Cancel-->
<!--            </button>-->
<!--        </div>-->

<!--        <div class="card-header">Address Details</div>-->
<!--        <div class="card-body w-100">-->
<!--            <form id="addressForm" action="{{ route('address.store') }}" method="POST">-->
<!--                @csrf-->

<!--                <div class="mb-3">-->
<!--                    <label>Address Line</label>-->
<!--                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" disabled>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6 mb-3">-->
<!--                        <label>City</label>-->
<!--                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" disabled>-->
<!--                    </div>-->
<!--                    <div class="col-md-6 mb-3">-->
<!--                        <label>State</label>-->
<!--                        <input type="text" name="state" class="form-control" value="{{ old('state') }}" disabled>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6 mb-3">-->
<!--                        <label>Pincode</label>-->
<!--                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" disabled>-->
<!--                    </div>-->
<!--                    <div class="col-md-6 mb-3">-->
<!--                        <label>Country</label>-->
<!--                        <input type="text" name="country" class="form-control" value="{{ old('country', 'India') }}" disabled>-->
<!--                    </div>-->
<!--                </div>-->
<!--                        @if(isset($addresses) && $addresses->count())-->
<!--            <div class="mb-3">-->
<!--                <label>Select Saved Address</label>-->
<!--                <select class="form-control">-->
<!--                    @foreach($addresses as $address)-->
<!--                        <option value="{{ $address->id }}">-->
<!--                            {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}, {{ $address->country }}-->
<!--                        </option>-->
<!--                    @endforeach-->
<!--                </select>-->
<!--    </div>-->
<!--@endif-->


<!--                <button type="submit" id="updateAddressBtn" class="btn btn-info d-none">Save Address</button>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
{{-- Address Section --}}
@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Address;

    $addresses = \App\Models\Address::where('user_id', Auth::id())->get();
@endphp

<!-- Address Section -->
<div id="addressSection" style="display:none" class="card mb-4">
    <div class="card-header">
        <label for="savedAddressSelect" class="form-label">Your Saved Addresses</label>
    </div>

    <div class="card-body">
        {{-- Address Selection --}}
        <select id="savedAddressSelect" class="form-control mb-3" onchange="showUpdateForm(this)">
            <option value="">-- Select Saved Address --</option>
            @foreach($addresses as $address)
                <option value="{{ htmlspecialchars(json_encode($address), ENT_QUOTES, 'UTF-8') }}">
                    {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->pincode }}
                </option>
            @endforeach
        </select>

        {{-- Edit Button (Only appears when address is selected) --}}
        <button id="editAddressBtn" type="button" class="btn btn-warning mb-3" style="display: none;" onclick="editSelectedAddress()">Edit Selected Address</button>

        {{-- Update Address Form --}}
        <form id="updateAddressForm" method="POST" action="{{ route('user.address.update') }}" style="display: none;">
           

            @csrf
            <input type="hidden" name="id" id="updateAddressId">

            <div class="mb-3">
                <label>Address Line</label>
                <input type="text" name="address" class="form-control" id="updateAddress" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" id="updateCity" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" id="updateState" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" id="updatePincode" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" id="updateCountry" value="India" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update Address</button>
        </form>

        {{-- Add New Address Toggle --}}
        <button type="button" class="btn btn-primary mt-4" onclick="toggleNewAddressForm()">+ Add New Address</button>

        {{-- Add New Address Form --}}
        <form id="newAddressForm" action="{{ route('user.address.store') }}" method="POST" class="mt-3" style="display: none;">
            @csrf

            <div class="mb-3">
                <label>Address Line</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Pincode</label>
                    <input type="text" name="pincode" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="India" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save New Address</button>
        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
    let selectedAddressData = null;

    function showUpdateForm(select) {
        const value = select.value;
        if (value) {
            try {
                selectedAddressData = JSON.parse(value.replace(/&quot;/g, '"'));
                document.getElementById('editAddressBtn').style.display = 'inline-block';
            } catch (error) {
                console.error('Invalid JSON:', error);
                document.getElementById('editAddressBtn').style.display = 'none';
            }
        } else {
            document.getElementById('editAddressBtn').style.display = 'none';
            document.getElementById('updateAddressForm').style.display = 'none';
        }
    }

    function editSelectedAddress() {
        if (!selectedAddressData) return;

        // Show and fill update form
        document.getElementById('updateAddressForm').style.display = 'block';
        document.getElementById('updateAddressId').value = selectedAddressData.id || '';
        document.getElementById('updateAddress').value = selectedAddressData.address || '';
        document.getElementById('updateCity').value = selectedAddressData.city || '';
        document.getElementById('updateState').value = selectedAddressData.state || '';
        document.getElementById('updatePincode').value = selectedAddressData.pincode || '';
        document.getElementById('updateCountry').value = selectedAddressData.country || 'India';
    }

    function toggleNewAddressForm() {
        const form = document.getElementById('newAddressForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>







{{--<script>
    function toggleAddressForm() {
        const form = document.getElementById('addressForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function fillAddressFields(select) {
        const data = select.value;
        if (!data) return;

        const address = JSON.parse(data);
        document.querySelector('[name="address"]').value = address.address || '';
        document.querySelector('[name="city"]').value = address.city || '';
        document.querySelector('[name="state"]').value = address.state || '';
        document.querySelector('[name="pincode"]').value = address.pincode || '';
        document.querySelector('[name="country"]').value = address.country || 'India';
        
        // Show form if hidden
        document.getElementById('addressForm').style.display = 'block';
    }
</script>--}}




            </div>
        </div>
    </div>
</div>


<style>
    .newsletter {
        background: #fff;
        padding: 40px 20px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .newsletter h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .newsletter p {
        color: #6b7280;
        font-size: 14px;
    }

    .newsletter input {
        border-radius: 8px;
        padding: 10px;
        width: 250px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    .newsletter button {
        background-color: #facc15;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        color: #000;
    }

    .newsletter-icons {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 25px;
    }

    .newsletter-icons div {
        text-align: center;
        max-width: 150px;
    }

    .newsletter-icons img {
        width: 30px;
        height: 30px;
        margin-bottom: 8px;
    }

    .newsletter-icons h6 {
        font-size: 14px;
        font-weight: 600;
    }

    .newsletter-icons p {
        font-size: 12px;
        color: #6b7280;
    }
</style>


{{--<div class="newsletter mt-1">
    <div class="newsletter-icons mb-4">
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/123/123392.png" alt="Free Shipping">
            <h6>Free Shipping</h6>
            <p>Orders above $50</p>
        </div>
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/2894/2894573.png" alt="Flexible Payment">
            <h6>Flexible Payment</h6>
            <p>Secure options</p>
        </div>
        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828817.png" alt="Support">
            <h6>24x7 Support</h6>
            <p>We’re always here</p>
        </div>
    </div>

    <h5>Subscribe to Our Newsletter to Get <span class="text-success">Updates on Our Latest Offers</span></h5>
    <p>Get 25% off on your first order by subscribing</p>

    <form class="d-flex justify-content-center flex-wrap mt-3">
        <input type="email" placeholder="Enter Email Address" required>
        <button type="submit">Subscribe</button>
    </form>
</div>--}}

<!-- JS to toggle between sections -->
<script>
    function showSection(sectionId, btn) {
        // Hide all sections
        document.getElementById('profileSection').style.display = 'none';
        document.getElementById('passwordSection').style.display = 'none';
        document.getElementById('addressSection').style.display = 'none';

        // Show the selected section
        document.getElementById(sectionId + 'Section').style.display = 'block';

        // Remove "active" class from all buttons
        document.querySelectorAll('.sidebar-button').forEach(button => button.classList.remove('active'));

        // Add "active" class to clicked button
        btn.classList.add('active');
    }

    function fillAddressFields(select) {
        const value = select.value;

        if (!value) return;

        try {
            const address = JSON.parse(value);

            document.querySelector('input[name="address"]').value = address.address || '';
            document.querySelector('input[name="city"]').value = address.city || '';
            document.querySelector('input[name="state"]').value = address.state || '';
            document.querySelector('input[name="pincode"]').value = address.pincode || '';
            document.querySelector('input[name="country"]').value = address.country || 'India';
        } catch (e) {
            console.error('Invalid address JSON', e);
        }
    }
</script>


<script>
    function enableFormFields(formId, updateBtnId, editBtnId, cancelBtnId) {
        const form = document.getElementById(formId);
        const updateBtn = document.getElementById(updateBtnId);
        const editBtn = document.getElementById(editBtnId);
        const cancelBtn = document.getElementById(cancelBtnId);

        if (form && updateBtn && editBtn && cancelBtn) {
            // Enable all form fields
            form.querySelectorAll('input, select, textarea').forEach(field => field.removeAttribute('disabled'));

            updateBtn.classList.remove('d-none');
            cancelBtn.classList.remove('d-none');
            editBtn.classList.add('d-none');
        }
    }

    function cancelEdit(formId, updateBtnId, editBtnId, cancelBtnId, originalValues) {
        const form = document.getElementById(formId);
        const updateBtn = document.getElementById(updateBtnId);
        const editBtn = document.getElementById(editBtnId);
        const cancelBtn = document.getElementById(cancelBtnId);

        if (form && updateBtn && editBtn && cancelBtn) {
            form.querySelectorAll('input, select, textarea').forEach(field => {
                if (originalValues[field.name] !== undefined) {
                    field.value = originalValues[field.name];
                }
                field.setAttribute('disabled', 'disabled');
            });

            updateBtn.classList.add('d-none');
            cancelBtn.classList.add('d-none');
            editBtn.classList.remove('d-none');
        }
    }

    // Store initial values for Address
    const addressOriginalValues = {};
    document.querySelectorAll('#addressForm input').forEach(field => {
        addressOriginalValues[field.name] = field.value;
    });

    // Store blank values for Password (since it's always empty on load)
    const passwordOriginalValues = {
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
    };

    // Address Section Events
    document.getElementById('editAddressBtn')?.addEventListener('click', function () {
        enableFormFields('addressForm', 'updateAddressBtn', 'editAddressBtn', 'cancelAddressBtn');
    });

    document.getElementById('cancelAddressBtn')?.addEventListener('click', function () {
        cancelEdit('addressForm', 'updateAddressBtn', 'editAddressBtn', 'cancelAddressBtn', addressOriginalValues);
    });

    // Password Section Events
    document.getElementById('editPasswordBtn')?.addEventListener('click', function () {
        enableFormFields('passwordForm', 'updatePasswordBtn', 'editPasswordBtn', 'cancelPasswordBtn');
    });

    document.getElementById('cancelPasswordBtn')?.addEventListener('click', function () {
        cancelEdit('passwordForm', 'updatePasswordBtn', 'editPasswordBtn', 'cancelPasswordBtn', passwordOriginalValues);
    });
</script>



@endsection
