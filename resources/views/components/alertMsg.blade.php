@if (session($msg))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: 'true',
                position: 'top-end',
                icon: 'success',
                title: "{{ session($msg) }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }, false);
    </script>
@endif
