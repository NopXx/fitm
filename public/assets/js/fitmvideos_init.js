$(function () {
    // Initialize DataTable first
    const table = $('#example').DataTable({
        ajax: {
            type: 'GET',
            url: baseUrl + '/admin/fitmvideos',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function (response) {
                console.log(response);
                return response;
            }
        },
        columns: [{
                data: 'name'
            },
            {
                data: 'url'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return data.is_important ? lang.yes : lang.no;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<a href="${baseUrl}/admin/fitmvideos/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4">
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
    $('#example').on('click', '.delete-btn', function () {
        const row = $(this).closest('tr');
        const data = $('#example').DataTable().row(row).data();

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
                    url: baseUrl + '/admin/fitmvideos/destroy/' + data.id,
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
                            $('#example').DataTable().ajax.reload();
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
                        console.error('Error deleting video:', error);
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
