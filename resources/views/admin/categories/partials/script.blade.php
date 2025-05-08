<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var table = $('#categoriesTable').DataTable({
    dom: 'lBfrtip', // Ensure 'l' is included for the length menu
    pageLength: 10, // Default rows per page
    lengthMenu: [
        [10, 20, 30, 50, -1],
        [10, 20, 30, 50, "All"]
    ], // Custom options including "All"
    buttons: [],
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: "{{ route('categories.index') }}",
    columns: [
        {
            data: 'id',
            name: 'id',
            render: function(data) {
                return `<input type="checkbox" class="brandCheckbox" value="${data}">`;
            },
            orderable: false,
            searchable: false
        },
        { data: 'name', name: 'name' },
        { data: 'slug', name: 'slug' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    language: {
        paginate: {
            previous: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>',
            next: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>'
        },
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        lengthMenu: 'Show _MENU_ entries',
        search: 'Search:',
        emptyTable: 'No data available in table'
    }
});

        // Show Add Category Modal
        $('#addCategoryBtn').click(function() {
            $('#addCategoryModal').modal('show');
        });

        // Create Category
        $('#createCategoryForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('categories.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addCategoryModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Category add successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        // Edit Category
        $(document).on('click', '.editCategory', function() {
            var id = $(this).data('id');
            $.get("{{ url('categories') }}/" + id + "/edit", function(data) {
                $('#editCategoryModal').modal('show');
                $('#editName').val(data.category.name);
                $('#editSlug').val(data.category.slug);
                $('#editCategoryForm').attr('action', "{{ url('categories') }}/" + id);
            });
        });

        // Update Category
        $('#editCategoryForm').submit(function(e) {
            e.preventDefault();
            var id = $(this).attr('action').split('/').pop();
            $.ajax({
                url: "{{ url('categories') }}/" + id,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editCategoryModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Category Update successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        // Delete Category
        $(document).on('click', '.deleteCategory', function() {
            var id = $(this).data('id');
            $('#deleteCategoryForm').attr('action', "{{ url('categories') }}/" + id);
            $('#deleteCategoryModal').modal('show');
        });

        $('#deleteCategoryForm').submit(function(e) {
            e.preventDefault();
            var id = $(this).attr('action').split('/').pop();
            $.ajax({
                url: "{{ url('categories') }}/" + id,
                method: 'DELETE',
                success: function(response) {
                    $('#deleteCategoryModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Category Delete successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });


        $('#selectAll').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.brandCheckbox').prop('checked', isChecked);
        });

        $('#bulkDeleteBtn').on('click', function () {
        var selectedIds = [];
        $('.brandCheckbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length > 0) {
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();

        $('#confirmDeleteBtn').off('click').on('click', function () {
            $.ajax({
                url: "{{ route('categories.bulkDelete') }}",
                method: 'POST',
                data: { ids: selectedIds },
                success: function (response) {
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Category Delete successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function (response) {
                    showToast('error', 'Error: ' + response.responseJSON.message);
                }
            });
            confirmModal.hide();
        });
    } else {
        showToast('warning', 'Please select at least one category.');
    }
});


    });
</script>
