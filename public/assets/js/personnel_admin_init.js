$(function () {
    // Initialize DataTable
    const table = $('#personnelTable').DataTable({
        ajax: {
            type: 'GET',
            url: baseURL + '/admin/personnel',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function (response) {
                console.log(response);

                // Extract all unique board types from the response for the filter
                const boards = [];
                const boardMap = {};

                response.forEach(function (item) {
                    if (item.board && item.board.id && !boardMap[item.board.id]) {
                        boardMap[item.board.id] = true;
                        boards.push(item.board);
                    }
                });

                // Add the filter after DataTable is fully initialized
                setTimeout(function () {
                    if ($('#boardFilter').length === 0) {
                        // Create filter HTML
                        let filterHtml = '<div class="d-inline-block me-3">' +
                            '<label for="boardFilter" class="me-2">' + lang.filter_by_board + '</label>' +
                            '<select class="form-select form-select-sm d-inline-block w-auto" id="boardFilter">' +
                            '<option value="">' + lang.all_boards + '</option>';

                        // Add options for each board
                        boards.forEach(function (board) {
                            filterHtml += '<option value="' + board.id + '">' + board.board_name_th + '</option>';
                        });

                        filterHtml += '</select></div>';

                        // Find the DataTables filter section
                        const filterSection = $('#personnelTable_filter');
                        // Insert the board filter before the search box
                        filterSection.prepend(filterHtml);

                        // Add event listener for the filter
                        $('#boardFilter').on('change', function () {
                            const boardId = $(this).val();

                            // Use custom filtering function instead of basic search
                            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex, rowData) {
                                // If no filter is selected, show all rows
                                if (!boardId) {
                                    return true;
                                }

                                // Return true if the board ID matches the selected filter
                                return rowData.board && rowData.board.id == boardId;
                            });

                            // Redraw the table to apply the filter
                            table.draw();

                            // Remove the filter function after drawing
                            $.fn.dataTable.ext.search.pop();
                        });
                    }
                }, 100); // Small delay to ensure DataTable is fully initialized

                return response;
            }
        },
        columns: [{
                data: 'image',
                render: function (data) {
                    if (data) {
                        return `<img src="${baseURL}/storage/${data}" alt="Personnel Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">`;
                    } else {
                        return `<div style="width: 50px; height: 50px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                  <i class="ti ti-user text-muted"></i>
                                </div>`;
                    }
                }
            },
            {
                data: null,
                render: function (data) {
                    return data.firstname_th + ' ' + data.lastname_th;
                }
            },
            {
                data: 'position_th'
            },
            {
                data: 'board.board_name_th'
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
                    return `<a href="${baseURL}/admin/personnel/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4">
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
    $('#personnelTable').on('click', '.delete-btn', function () {
        const row = $(this).closest('tr');
        const data = $('#personnelTable').DataTable().row(row).data();

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
                    url: baseURL + '/admin/personnel/destroy/' + data.id,
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
                            $('#personnelTable').DataTable().ajax.reload();
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
                        console.error('Error deleting personnel:', error);
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