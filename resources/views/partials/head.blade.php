<!-- Meta Tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') | SmartHR - Advanced Bootstrap 5 Multipurpose Admin Dashboard Template for HRM, Payroll & CRM</title>

<meta name="description" content="SmartHR - An advanced Bootstrap 5 admin dashboard template for HRM and CRM. Ideal for managing employee records, payroll, attendance, recruitment, and team performance with an intuitive and responsive design. Perfect for HR teams and business managers looking to streamline workforce management.">
<meta name="keywords" content="HR dashboard template, HRM admin template, Bootstrap 5 HR dashboard, workforce management dashboard, employee management system, payroll dashboard, HR analytics, admin dashboard, CRM admin template, human resources management, HR admin template, team management dashboard, recruitment dashboard, employee attendance system, performance management, HR CRM, HR dashboard HTML, Bootstrap HR template, employee engagement, HR software, project management dashboard">
<meta name="author" content="Dreams Technologies">
<meta name="robots" content="index, follow">

<!-- Apple Touch Icon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">

<!-- Favicon -->
<link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

<!-- Theme Script js -->
<script src="{{ asset('assets/js/theme-script.js') }}"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

<!-- Feather CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/icons/feather/feather.css') }}">

<!-- Tabler Icon CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

<!-- Fontawesome CSS - Using CDN for webfonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

<!-- Bootstrap Tagsinput CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

<!-- Summernote CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-lite.min.css') }}">

<!-- Daterangepikcer CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

<!-- Datatable CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<!-- Color Picker Css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">

<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

@stack('styles')
