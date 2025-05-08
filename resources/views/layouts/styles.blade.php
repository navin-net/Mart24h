
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="{{ asset('assets1/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

   <!-- DataTables Bootstrap 5 CSS -->
   <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
   <!-- DataTables Buttons CSS -->
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css">
   <!-- Custom CSS -->

<style>
         .dt-buttons .btn {
            margin-right: 5px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.25rem;
        }
        .brand-image-thumbnail {
            max-height: 50px;
            cursor: pointer;
        }
        /* Fix for processing overlay (DataTables bug with Bootstrap) */
        div.dataTables_wrapper div.dataTables_processing {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }
    /* General Table Styling */
.table {
    border-collapse: collapse !important;
    margin: 20px 0 !important;
    font-size: 14px !important;
    min-width: 100% !important;
    background-color: #fff !important;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1) !important;
}

.table thead th {
    background-color: #007bff !important;
    color: #fff !important;
    text-align: center !important;
    padding: 10px !important;
    border: 1px solid #ddd !important;
}

.table tbody td {
    text-align: center !important;
    padding: 10px !important;
    border: 1px solid #ddd !important;
    vertical-align: middle !important;
}

/* Checkbox Styling */
input[type="checkbox"] {
    cursor: pointer !important;
    width: 16px !important;
    height: 16px !important;
}

/* Search Box Styling */
.dataTables_filter {
    margin-bottom: 15px !important;
}

.dataTables_filter label {
    font-weight: bold !important;
    /* color: #333 !important; */
}

.dataTables_filter input {
    width: 300px !important;
    padding: 8px !important;
    border: 1px solid #ddd !important;
    border-radius: 5px !important;
}

/* Pagination Styling */
.dataTables_paginate {
    margin-top: 15px !important;
    text-align: center !important;
}

.dataTables_paginate .paginate_button {
    padding: 5px 8px !important;
    margin: 0 5px !important;
    border-radius: 3px !important;
    background-color: #f8f9fa !important;
    border: 1px solid #ddd !important;
    color: #007bff !important;
    cursor: pointer !important;
}

.dataTables_paginate .paginate_button:hover {
    /* background-color: #007bff !important; */
    /* color: #fff !important; */
}

.dataTables_paginate .paginate_button.current {
    /* background-color: #007bff !important; */
    color: #fff !important;
    border-color: #007bff !important;
}

/* Disable Pagination Buttons */
.dataTables_paginate .paginate_button.disabled {
    background-color: #e9ecef !important;
    /* color: #6c757d !important; */
    cursor: not-allowed !important;
}
.dataTables_info {
    display: block; /* Ensure it's visible */
}

/* Info & Length Dropdown */
.dataTables_info {
    margin-top: 15px !important;
    color: #333 !important;
}

.dataTables_length select {
    width: 75px !important;
    padding: 5px !important;
    border: 1px solid #ddd !important;
    border-radius: 5px !important;
}

/* Responsive Design */
.table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
}



</style>
