document.addEventListener('DOMContentLoaded', () => {
    const tables = document.querySelectorAll('.datatable');

    if (tables.length > 0) {
        tables.forEach((table) => {
            const ajaxUrl = table.dataset.ajaxUrl;
            const columns = table.dataset.columns ? JSON.parse(table.dataset.columns) : [];

            $(table).DataTable({
                processing: true,
                serverSide: true,
                ajax: ajaxUrl,
                columns: columns,
                language: {
                    loadingRecords: "Loading...",
                    zeroRecords: "No matching records found.",
                },
            });
        });

        console.log('DataTables initialized.');
    }
});
