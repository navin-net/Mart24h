<div class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">Design and Developed by
        <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">Alvin</a>
        {{-- Distributed by <a href="https://themewagon.com">ThemeWagon</a> --}}
    </p>
  </div>
<script>
    document.querySelectorAll('.sidebar-link.has-arrow').forEach(link => {
  link.addEventListener('click', function () {
    const submenu = this.nextElementSibling;
    if (submenu) {
      submenu.classList.toggle('show');
    }
  });
});

</script>
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
