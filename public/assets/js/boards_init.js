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
                data: 'display_order'
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
                    return `<a href="/admin/boards/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4">
                                <i class="ti ti-edit text-primary"></i>
                            </a>
                            <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                <i class="ti ti-trash"></i>
                            </button>`;
                }
            }
        ]
    });

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
                            $('#boardTable').DataTable().ajax.reload();
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
