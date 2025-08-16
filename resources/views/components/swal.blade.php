@if(session('swal'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] }}',
            timer: {{ session('swal')['timer'] ?? 'null' }},
            showConfirmButton: {{ session('swal')['showConfirmButton'] ?? 'true' }},
            timerProgressBar: true,
            toast: {{ session('swal')['toast'] ?? 'false' }},
            position: '{{ session('swal')['position'] ?? 'center' }}'
        });
    });
</script>
@endif