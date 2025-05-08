<script>
    // Function to format the details row content
function formatDetailsRow(data) {
    return `
        <div class="details-content">
            <p><strong>{{ __('messages.image') }}:</strong> <img src="${data.image}" alt="Brand Image" class="brand-image-thumbnail"></p>
            <p><strong>{{ __('messages.slug') }}:</strong> ${data.slug}</p>
        </div>
    `;
}
    $(document).ready(function() {
        var table =
            $('#brandsTable').DataTable({

                dom: 'lBfrtip', // Ensure 'l' is included for the length menu
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 30, 50, -1],
                    [10, 20, 30, 50, "All"]
                ],
                buttons: [ 'pdf', 'print'],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('brands.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `<input type="checkbox" class="brandCheckbox" value="${data}">`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data) {
    if (data) {
        return `
            <a href="#" class="image-popup" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="/upload/image/${data}">
                <img src="/upload/image/${data}" width="50" class="img-thumbnail">
            </a>`;
    }
    return `
        <a href="#" class="image-popup" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="/upload/image/noimage.png">
            <img src="/upload/image/noimage.png" width="50" class="img-thumbnail">
        </a>`;
}

                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    // {
                    //     data: 'description',
                    //     name: 'description'
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
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
                },
                pageLength: 10, // Default rows per page
                lengthMenu: [
                    [10, 20, 30, 50, -1],
                    [10, 20, 30, 50, "All"]
                ] // Add custom options including "All"
            });


        $('#addBrandBtn').on('click', function() {
            $('#brandForm').trigger('reset'); // Clear form
            $('#brandId').val(''); // Empty ID for creation
            $('#brandModal').modal('show'); // Show modal
        });

        // Form submission handles both create and update:

        $(document).on('click', '.editBrandBtn', function() {
            var id = $(this).data('id'); // Get the ID of the brand

            // Fetch brand details via AJAX
            $.get(`/brands/${id}/edit`, function(data) {
                // Populate modal fields
                $('#brandId').val(data.id); // Fill hidden ID field
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#slug').val(data.slug);
                $('#description').val(data.description);

                if (data.image) {
                    $('#currentImage').attr('src', `/upload/image/${data.image}`)
                        .show(); // Show current image

                } else {
                    $('#currentImage').hide();
                }

                // Show the modal
                $('#brandModal').modal('show');
            });
        });

        // Handle form submission (Add or Update)
// Handle form submission (Add or Update)
$('#brandForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    // Determine action (Create or Update)
    var isUpdate = $('#brandId').val() ? true : false;
    var url = isUpdate ? `/brands/${$('#brandId').val()}` : "{{ route('brands.store') }}";
    var method = 'POST';
    formData.append('_method', isUpdate ? 'PUT' : 'POST');

    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#brandModal').modal('hide'); // Hide modal
            $('#brandsTable').DataTable().ajax.reload(); // Reload the DataTable

            // Create different success messages
            const successAlert = `
<div class="alert alert-success alert-dismissible fade show" role="alert">
    ${isUpdate ? 'Brand updated successfully!' : 'Brand added successfully!'}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

            $('#alertsContainer').html(successAlert);
        },
        error: function(xhr) {
            alert('An error occurred. Please try again.');
        }
    });
});


        $(document).on('click', '.deleteBrandBtn', function() {
            const brandId = $(this).data('id'); // Get brand ID from button data
            const deleteUrl = `/brands/${brandId}`; // Construct delete URL

            // Set the action attribute of the delete form dynamically
            $('#deleteForm').attr('action', deleteUrl);
        });



        $('#deleteForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            const form = $(this);
            const action = form.attr('action'); // Get the form's action URL

            $.ajax({
                url: action,
                type: 'DELETE', // Send DELETE request
                data: form.serialize(),
                success: function(response) {
                    // Close the modal
                    $('#deleteModal').modal('hide');

                    // Reload the DataTable
                    $('#brandsTable').DataTable().ajax.reload();

                    // Show the success alert
                    const successAlert = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Brand deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                    $('#alertsContainer').html(
                        successAlert); // Assuming you have a container for alerts
                },
                error: function(xhr) {
                    alert('Failed to delete the brand. Please try again.');
                }
            });
        });





        // Select/Deselect All Checkboxes
        $('#selectAll').on('click', function() {
            $('.brandCheckbox').prop('checked', $(this).prop('checked'));
            toggleBulkDeleteButton();
        });

        // Check individual checkboxes
        $(document).on('change', '.brandCheckbox', function() {
            toggleBulkDeleteButton();
        });

        // Enable/Disable Bulk Delete Button
        function toggleBulkDeleteButton() {
            const anyChecked = $('.brandCheckbox:checked').length > 0;
            $('#bulkDeleteBtn').prop('disabled', !anyChecked);
        }

        // Handle Bulk Delete
        $('#bulkDeleteBtn').on('click', function() {
            const selectedIds = $('.brandCheckbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                alert('No brands selected for deletion.');
                return;
            }

            // Open the Bulk Delete Confirmation Modal
            $('#bulkDeleteModal').modal('show');

            // Attach delete event only once to avoid duplicate bindings
            $('#confirmBulkDelete').off('click').on('click', function() {
                // Make AJAX call to perform bulk delete
                $.ajax({
                    url: "{{ route('brands.bulkDestroy') }}", // Route for bulk delete
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: selectedIds
                    },
                    success: function(response) {
                        // Hide the modal after successful deletion
                        $('#bulkDeleteModal').modal('hide');

                        // Reload the DataTable
                        $('#brandsTable').DataTable().ajax.reload();

                        // Reset checkboxes and bulk delete button
                        $('#selectAll').prop('checked', false);
                        $('#bulkDeleteBtn').prop('disabled', true);

                        // Display success alert
                        const successAlert = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ __('messages.selected_brands_deleted_successfully!') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                        $('#alertsContainer').html(successAlert);
                    },
                    error: function(xhr) {
                        // Display error alert
                        const errorAlert = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Failed to delete selected brands. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                        $('#alertsContainer').html(errorAlert);
                    }
                });
            });
        });

    });
    $(document).on('click', '.image-popup', function(e) {
        e.preventDefault();
        const imageUrl = $(this).data('image');
        $('#modalImage').attr('src', imageUrl);
    });
    $('#exportBrands').on('click', function() {
        var selectedIds = $('.brandCheckbox:checked').map(function() {
            return $(this).val();
        }).get();

        var url = "{{ route('brands.export') }}";

        if (selectedIds.length === 0) {
            alert('No brands selected for export.');
            return;
        }
        window.location.href = url + '?ids=' + selectedIds.join(',');
    });
</script>

