<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var table = $('#brandsTable').DataTable({
            dom: 'lBfrtip',
            pageLength: 10,
            lengthMenu: [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, "All"]
            ],
            buttons: [],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('qualitys.index') }}",
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
                { data: 'description', name: 'description' },
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
    });
        $(document).on('click', '.editQuality', function() {
            var id = $(this).data('id');
            $.get("{{ url('qualitys') }}/" + id + "/edit", function(data) {
                $('#editQualitysModal').modal('show');
                $('#editName').val(data.category.name);
                $('#editDescription').val(data.category.slug);
                $('#editQualityForm').attr('action', "{{ url('qualitys') }}/" + id);
            });
        });

        // Update Category
        $('#editQualityForm').submit(function(e) {
            e.preventDefault();
            var id = $(this).attr('action').split('/').pop();
            $.ajax({
                url: "{{ url('qualitys') }}/" + id,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editQualitysModal').modal('hide');
                    table.ajax.reload();
                    const successAlert = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        qualitys Update successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $('#alertsContainer').html(successAlert);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });
</script>
