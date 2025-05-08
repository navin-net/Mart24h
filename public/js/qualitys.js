$(document).ready(function () {
    // Initialize DataTables
    $('#qualitysTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/qualitys',
        columns: [
            { data: 'id', name: 'id', render: function (data) {
                return `<input type="checkbox" class="qualitysCheckbox" value="${data}">`;
            }},
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

    // Select all checkboxes
    $('#selectAll').on('click', function () {
        $('.qualitysCheckbox').prop('checked', this.checked);
    });

    // Handle create form submission
    $('#createQualitysForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/qualitys',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('#createQualitysModal').modal('hide');
                $('#qualitysTable').DataTable().ajax.reload();
                alert(response.success);
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            },
        });
    });

    // Handle edit button click
    $(document).on('click', '.editQuality', function () {
        let id = $(this).data('id');
        $.ajax({
            url: `/qualitys/${id}/edit`,
            method: 'GET',
            success: function (response) {
                $('#editQualitysModal').modal('show');
                $('#editQualitysForm [name="name"]').val(response.qualitys.name);
                $('#editQualitysForm [name="description"]').val(response.qualitys.description);
                $('#editQualitysForm').attr('action', `/qualitys/${id}`);
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.error);
            },
        });
    });

    // Handle edit form submission
    $('#editQualitysForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('#editQualitysModal').modal('hide');
                $('#qualitysTable').DataTable().ajax.reload();
                alert(response.success);
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseJSON.error);
            },
        });
    });

    // Handle delete button click
    $(document).on('click', '.deleteQuality', function () {
        if (confirm('Are you sure you want to delete this qualitys?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `/qualitys/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#qualitysTable').DataTable().ajax.reload();
                    alert(response.success);
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                },
            });
        }
    });

    // Handle bulk delete
    $('#bulkDeleteButton').on('click', function () {
        let selectedIds = [];
        $('.qualitysCheckbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('Please select at least one qualitys to delete.');
            return;
        }

        if (confirm('Are you sure you want to delete the selected qualitys?')) {
            $.ajax({
                url: '/qualitys/bulk-delete',
                method: 'DELETE',
                data: { ids: selectedIds },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    $('#qualitysTable').DataTable().ajax.reload();
                    alert(response.success);
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseJSON.error);
                },
            });
        }
    });
});
