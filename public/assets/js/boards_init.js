$(function () {
    // Initialize DataTable first
    const table = $('#boardTable').DataTable({
        ajax: {
            type: 'GET',
            url: '/admin/boards',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function (response) {
                console.log(response);
                return response;
            }
        },
        rowId: 'id', // Use the id field as the row identifier
        order: [[2, 'asc']], // Order by display_order column (index 2)
        columns: [{
                data: 'board_name_th'
            },
            {
                data: 'board_name_en',
                render: function (data) {
                    return data || '-';
                }
            },
            {
                data: 'display_order',
                visible: false // Hide the display_order column
            },
            {
                data: 'is_active',
                render: function (data) {
                    if (data) {
                        return `<span class="badge bg-success">${lang.active}</span>`;
                    } else {
                        return `<span class="badge bg-danger">${lang.inactive}</span>`;
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<div class="action-buttons">
                                <a href="/admin/boards/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4 me-1">
                                    <i class="ti ti-edit text-primary"></i>
                                </a>
                                <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>`;
                }
            }
        ],
        rowReorder: false, // We'll use our custom Sortable.js implementation
        createdRow: function(row, data, index) {
            // Add data attributes to each row for sorting
            $(row).attr('data-id', data.id);
            $(row).attr('data-order', data.display_order);
        }
    });

    // Initialize Sortable.js for table body after DataTable is fully rendered
    table.on('draw', function() {
        const tbody = document.querySelector('#boardTable tbody');
        if (tbody && !tbody._sortable) {
            tbody._sortable = new Sortable(tbody, {
                animation: 150,
                // Remove the handle to make the entire row draggable
                ghostClass: 'bg-light-primary',
                // Add a cursor style to indicate the row is draggable
                draggable: 'tr',
                onEnd: function(evt) {
                    updateDisplayOrder();
                }
            });
        }
    });

    // Function to update display order after dragging
    function updateDisplayOrder() {
        const rows = $('#boardTable tbody tr');
        const orderData = [];

        // Collect data for all visible rows
        rows.each(function(index) {
            const id = $(this).attr('data-id');
            orderData.push({
                id: id,
                display_order: index + 1
            });
        });

        // Send the updated order to the server
        if (orderData.length > 0) {
            $.ajax({
                type: 'POST',
                url: '/admin/boards/update-order',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    orders: orderData
                },
                success: function(response) {
                    if (response.status) {
                        // Show success notification
                        Swal.fire({
                            icon: 'success',
                            title: lang.success || 'Success',
                            text: lang.order_updated || 'Display order updated successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Refresh the table to show updated order
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: lang.error || 'Error',
                            text: response.message || lang.update_error || 'Failed to update display order'
                        });
                    }
                },
                error: function(error) {
                    console.error('Error updating display order:', error);
                    Swal.fire({
                        icon: 'error',
                        title: lang.error || 'Error',
                        text: lang.update_error || 'Failed to update display order'
                    });
                }
            });
        }
    }

    // Add event handler for delete button
    $('#boardTable').on('click', '.delete-btn', function () {
        const row = $(this).closest('tr');
        const data = $('#boardTable').DataTable().row(row).data();

        Swal.fire({
            title: lang.confirm,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang.yes_delete,
            cancelButtonText: lang.cancel
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/boards/destroy/' + data.id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status) {
                            // Show success alert
                            Swal.fire(
                                lang.deleted,
                                lang.delete_success,
                                'success'
                            );

                            // Reload the table to reflect changes
                            table.ajax.reload();
                        } else {
                            // Show error alert
                            Swal.fire(
                                lang.error,
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function (error) {
                        console.error('Error deleting board:', error);
                        Swal.fire(
                            lang.error,
                            lang.delete_error,
                            'error'
                        );
                    }
                });
            }
        });
    });
});