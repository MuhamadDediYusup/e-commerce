<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ e(session('success')) }}', // Pastikan isi session aman
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ e(session('error')) }}', // Pastikan isi session aman
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    });
</script>
@endif