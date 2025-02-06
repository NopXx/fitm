$(function () {
    $('#example').DataTable({
        ajax: {
            type: 'GET',
            url: '/admin/news',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function dataSrc(response) {
                return response;
            },
        },
        columns: [
            {
                data: 'title'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return moment(data.effective_date).format('DD/MM/yyyy HH:mm:ss');
                }
            },
            {
                data: 'detail'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<a href="/admin/new/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4">
                                <i class="ti ti-edit text-primary"></i>
                            </a>
                            <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                <i class="ti ti-trash"></i>
                            </button>`;
                }
            }
        ],
    });
});
