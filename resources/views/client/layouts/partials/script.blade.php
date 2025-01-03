<!-- Thêm jQuery vào trang (Phải được tải trước Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Các tệp JS của bên thứ ba (nếu có) -->
<script src="{{ asset('assets/client/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/client/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/client/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/client/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Main JS File -->
<script src="{{ asset('assets/client/assets/js/main.js') }}"></script>

<!-- Bootstrap JS (chỉ cần tải bootstrap.bundle.min.js là đủ) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@stack('script')
