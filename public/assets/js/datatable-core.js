/**
 * DataTable Core Helper
 * Centralized configuration and utilities for DataTables
 */

class DataTableCore {
    constructor() {
        this.defaultConfig = {
            dom: 'lBfrtip',
            pageLength: 10,
            lengthMenu: [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, "All"]
            ],
            responsive: true,
            processing: true,
            serverSide: true,
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
        };
    }

    /**
     * Initialize a standard CRUD DataTable
     * @param {string} tableId - The table element ID
     * @param {string} ajaxUrl - The URL for AJAX data loading
     * @param {Array} columns - Column definitions
     * @param {Object} options - Additional options to override defaults
     * @returns {Object} DataTable instance
     */
    initCrudTable(tableId, ajaxUrl, columns, options = {}) {
        const config = {
            ...this.defaultConfig,
            ajax: ajaxUrl,
            columns: this.addCheckboxColumn(columns),
            ...options
        };

        return $(tableId).DataTable(config);
    }

    /**
     * Add checkbox column for bulk operations
     * @param {Array} columns - Existing columns
     * @returns {Array} Columns with checkbox column prepended
     */
    addCheckboxColumn(columns) {
        const checkboxColumn = {
            data: 'id',
            name: 'id',
            render: function(data) {
                return `<input type="checkbox" class="row-checkbox" value="${data}">`;
            },
            orderable: false,
            searchable: false
        };

        return [checkboxColumn, ...columns];
    }

    /**
     * Initialize bulk operations for a table
     * @param {string} tableId - The table element ID
     * @param {Object} table - DataTable instance
     * @param {Object} bulkConfig - Bulk operation configuration
     */
    initBulkOperations(tableId, table, bulkConfig = {}) {
        const {
            selectAllId = '#selectAll',
            bulkDeleteBtnId = '#bulkDeleteBtn',
            bulkDeleteUrl = '',
            confirmModalId = '#confirmModal',
            confirmBtnId = '#confirmDeleteBtn',
            alertContainerId = '#alertsContainer'
        } = bulkConfig;

        // Select All functionality
        $(selectAllId).on('click', function() {
            const isChecked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', isChecked);
            $(bulkDeleteBtnId).prop('disabled', !$('.row-checkbox:checked').length);
        });

        // Update bulk button state
        $(document).on('change', '.row-checkbox', function() {
            $(bulkDeleteBtnId).prop('disabled', !$('.row-checkbox:checked').length);
        });

        // Bulk delete
        $(bulkDeleteBtnId).on('click', function() {
            const selectedIds = [];
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length > 0) {
                const confirmModal = new bootstrap.Modal(document.getElementById(confirmModalId.replace('#', '')));
                confirmModal.show();

                $(confirmBtnId).off('click').on('click', function() {
                    $.ajax({
                        url: bulkDeleteUrl,
                        method: 'DELETE',
                        data: { ids: selectedIds },
                        success: function(response) {
                            table.ajax.reload();
                            DataTableCore.showAlert(alertContainerId, 'Items deleted successfully!', 'success');
                            confirmModal.hide();
                        },
                        error: function(response) {
                            DataTableCore.showAlert(alertContainerId, 'Error: ' + response.responseJSON.message, 'danger');
                        }
                    });
                });
            } else {
                alert('Please select at least one item.');
            }
        });
    }

    /**
     * Initialize CRUD modals
     * @param {Object} table - DataTable instance
     * @param {Object} crudConfig - CRUD configuration
     */
    initCrudModals(table, crudConfig = {}) {
        const {
            addBtnId = '#addBtn',
            addModalId = '#addModal',
            addFormId = '#addForm',
            editModalId = '#editModal',
            editFormId = '#editForm',
            deleteModalId = '#deleteModal',
            deleteFormId = '#deleteForm',
            storeUrl = '',
            updateUrl = '',
            editUrl = '',
            deleteUrl = '',
            alertContainerId = '#alertsContainer'
        } = crudConfig;

        // Show add modal
        $(addBtnId).click(function() {
            $(addModalId).modal('show');
        });

        // Create record
        $(addFormId).submit(function(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = $(form).find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            // Disable button and show loading
            submitBtn.prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: storeUrl,
                method: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    $(addModalId).modal('hide');
                    table.ajax.reload();
                    DataTableCore.showAlert(alertContainerId, 'Record added successfully!', 'success');
                    form.reset();
                },
                error: function(response) {
                    const message = response.responseJSON?.message || 'An error occurred';
                    DataTableCore.showAlert(alertContainerId, 'Error: ' + message, 'danger');
                },
                complete: function() {
                    // Re-enable button
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Edit record
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const editBtn = $(this);
            const originalHtml = editBtn.html();
            
            // Show loading state
            editBtn.html('<i class="bi bi-hourglass-split"></i>').prop('disabled', true);
            
            $.get(editUrl.replace(':id', id))
                .done(function(data) {
                    $(editModalId).modal('show');
                    
                    // Handle nested data structure (e.g., data.quality or direct data)
                    const record = data.quality || data;
                    
                    // Populate form fields
                    Object.keys(record).forEach(key => {
                        const fieldId = `#edit${key.charAt(0).toUpperCase() + key.slice(1)}`;
                        $(fieldId).val(record[key]);
                    });
                    
                    $(editFormId).attr('data-id', id);
                })
                .fail(function(response) {
                    const message = response.responseJSON?.message || 'Failed to load record';
                    DataTableCore.showAlert(alertContainerId, 'Error: ' + message, 'danger');
                })
                .always(function() {
                    // Restore button state
                    editBtn.html(originalHtml).prop('disabled', false);
                });
        });

        // Update record
        $(editFormId).submit(function(e) {
            e.preventDefault();
            const form = this;
            const id = $(form).attr('data-id');
            const submitBtn = $(form).find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            // Disable button and show loading
            submitBtn.prop('disabled', true).text('Updating...');
            
            $.ajax({
                url: updateUrl.replace(':id', id),
                method: 'PUT',
                data: $(form).serialize(),
                success: function(response) {
                    $(editModalId).modal('hide');
                    table.ajax.reload();
                    DataTableCore.showAlert(alertContainerId, 'Record updated successfully!', 'success');
                },
                error: function(response) {
                    const message = response.responseJSON?.message || 'An error occurred';
                    DataTableCore.showAlert(alertContainerId, 'Error: ' + message, 'danger');
                },
                complete: function() {
                    // Re-enable button
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        // Delete record
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            $(deleteFormId).attr('data-id', id);
            $(deleteModalId).modal('show');
        });

        $(deleteFormId).submit(function(e) {
            e.preventDefault();
            const form = this;
            const id = $(form).attr('data-id');
            const submitBtn = $(form).find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            // Disable button and show loading
            submitBtn.prop('disabled', true).text('Deleting...');
            
            $.ajax({
                url: deleteUrl.replace(':id', id),
                method: 'DELETE',
                success: function(response) {
                    $(deleteModalId).modal('hide');
                    table.ajax.reload();
                    DataTableCore.showAlert(alertContainerId, 'Record deleted successfully!', 'success');
                },
                error: function(response) {
                    const message = response.responseJSON?.message || 'An error occurred';
                    DataTableCore.showAlert(alertContainerId, 'Error: ' + message, 'danger');
                },
                complete: function() {
                    // Re-enable button
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    }

    /**
     * Show alert message
     * @param {string} containerId - Alert container ID
     * @param {string} message - Alert message
     * @param {string} type - Alert type (success, danger, warning, info)
     */
    static showAlert(containerId, message, type = 'success') {
        const alert = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $(containerId).html(alert);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            $(containerId).find('.alert').fadeOut();
        }, 5000);
    }

    /**
     * Get standard action buttons HTML
     * @param {number} id - Record ID
     * @param {Object} options - Button options
     * @returns {string} HTML for action buttons
     */
    static getActionButtons(id, options = {}) {
        const {
            showEdit = true,
            showDelete = true,
            showView = false,
            customButtons = []
        } = options;

        let buttons = '';
        
        if (showView) {
            buttons += `<button class="btn btn-info btn-sm view-btn me-1" data-id="${id}">
                <i class="bi bi-eye"></i>
            </button>`;
        }
        
        if (showEdit) {
            buttons += `<button class="btn btn-warning btn-sm edit-btn me-1" data-id="${id}">
                <i class="bi bi-pencil"></i>
            </button>`;
        }
        
        if (showDelete) {
            buttons += `<button class="btn btn-danger btn-sm delete-btn" data-id="${id}">
                <i class="bi bi-trash"></i>
            </button>`;
        }

        // Add custom buttons
        customButtons.forEach(button => {
            buttons += `<button class="btn btn-${button.class} btn-sm ${button.action}-btn me-1" data-id="${id}">
                <i class="bi bi-${button.icon}"></i>
            </button>`;
        });

        return buttons;
    }

    /**
     * Initialize complete CRUD table with all features
     * @param {Object} config - Complete configuration object
     */
    initCompleteCrud(config) {
        const {
            tableId,
            ajaxUrl,
            columns,
            bulkConfig = {},
            crudConfig = {},
            tableOptions = {}
        } = config;

        // Initialize table
        const table = this.initCrudTable(tableId, ajaxUrl, columns, tableOptions);

        // Initialize bulk operations
        this.initBulkOperations(tableId, table, bulkConfig);

        // Initialize CRUD modals
        this.initCrudModals(table, crudConfig);

        return table;
    }
}

// Initialize CSRF token for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Export for use
window.DataTableCore = DataTableCore;