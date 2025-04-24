$(function () {
    // Language variables from Laravel localization
    // Initialize DataTable first
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

    const table = $('#example').DataTable({
        ajax: {
            type: 'GET',
            url: baseURL + '/admin/news',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function (response) {
                console.log(response);

                // Extract all unique new types from the response for the filter
                const newTypes = [];
                const typeMap = {};

                response.forEach(function (item) {
                    if (item.new_type && item.new_type.new_type_name && !typeMap[item.new_type.new_type_name]) {
                        typeMap[item.new_type.new_type_name] = true;
                        newTypes.push(item.new_type);
                    }
                });

                // Instead of adding the filter before the table, we'll wait until DataTables has initialized
                // and then move it next to the search box
                setTimeout(function () {
                    if ($('#typeFilter').length === 0) {
                        // Create filter HTML
                        let filterHtml = '<div class="d-inline-block me-3">' +
                            '<label for="typeFilter" class="me-2">' + lang.filter_by_type + '</label>' +
                            '<select class="form-select form-select-sm d-inline-block w-auto" id="typeFilter">' +
                            '<option value="">' + lang.all_types + '</option>';

                        // Add options for each new type
                        newTypes.forEach(function (type) {
                            filterHtml += '<option value="' + type.new_type_name + '">' + type.new_type_name + '</option>';
                        });

                        filterHtml += '</select></div>';

                        // Find the DataTables filter section
                        const filterSection = $('#example_filter');
                        // Insert the type filter before the search box
                        filterSection.prepend(filterHtml);

                        // Add event listener for the filter
                        $('#typeFilter').on('change', function () {
                            let filterValue = $(this).val();
                            table.column(3).search(filterValue).draw();
                        });
                    }
                }, 100); // Small delay to ensure DataTable is fully initialized

                return response;
            }
        },
        columns: [{
                data: 'title_th'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return moment(data.effective_date).format('DD/MM/yyyy');
                }
            },
            {
                data: 'display_type',
                render: function (data) {
                    return `${lang.style} ${data}`;
                }
            },
            {
                data: 'new_type.new_type_name'
            },
            {
                data: 'is_important',
                render: function (data) {
                    if (data == 1) {
                        return '<span class="badge bg-success"><i class="fas fa-star"></i></span>';
                    } else {
                        return '';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<a href="${baseURL}/admin/new/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4">
                                <i class="ti ti-edit text-primary"></i>
                            </a>
                            <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                <i class="ti ti-trash"></i>
                            </button>`;
                }
            }
        ],
        order: [
            [1, 'desc']
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
                    url: baseURL + '/admin/new/delete/' + data.id,
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
