$(function() {
    $('#example').DataTable({
        ajax: {
            type: 'GET',
            url: '/news',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataSrc: function dataSrc(response) {
                return response;
            },
        },
        columns: [
            { data: 'new_id' },
            { data: 'title' },
            { data: 'created_at' }
        ],
    });
});
