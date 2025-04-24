$(function () {

    // Add moment.js sorting plugin for DataTables
    $.fn.dataTable.moment = function (format, locale) {
        var types = $.fn.dataTable.ext.type;

        // Add type detection
        types.detect.unshift(function (d) {
            return moment(d, format, locale, true).isValid() ?
                'moment-' + format :
                null;
        });

        // Add sorting methods
        types.order['moment-' + format + '-pre'] = function (d) {
            return moment(d, format, locale, true).unix();
        };
    };

    $.fn.dataTable.moment('DD/MM/yyyy');

    // Initialize DataTable first
    const table = $('#example').DataTable({
        ajax: {
            type: 'GET',
            url: baseUrl + '/admin/fitmnews',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function (response) {
                console.log(response);

                return response;
            }
        },
        columns: [{
                data: 'issue_name'
            },
            {
                data: 'title_th'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return moment(data.published_date).format('DD/MM/yyyy');
                }
            },
            {
                data: 'description_th',
                render: function(data) {
                    // Truncate description if too long
                    return data != null ? data.length > 50 ? data.substring(0, 50) + '...' : data : '';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<a href="${baseUrl}/admin/fitmnews/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4">
                                <i class="ti ti-edit text-primary"></i>
                            </a>
                            <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                <i class="ti ti-trash"></i>
                            </button>`;
                }
            }
        ],
        order: [
            [2, 'desc']
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
                    url: baseUrl + '/admin/fitmnews/delete/' + data.id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
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
                        console.error('Error deleting news:', error);
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
