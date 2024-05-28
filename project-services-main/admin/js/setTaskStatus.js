$('document').ready(function() {

    console.log('mohahaha')

    $('#taskFormUpdate').submit(function(event) {
        event.preventDefault();

        var newTaskStatus = $('#selectedStatus').val();
        var formData = new FormData(this);

        switch (newTaskStatus) {
            case '0':
                newTaskStatus = 'Pending';
                break;
            case '1':
                newTaskStatus = 'Preparing';
                break;
            case '2':
                newTaskStatus = 'On-Progress';
                break;
            case '3':
                newTaskStatus = 'Completed';
                break;
            case '4':
                newTaskStatus = 'Cancelled';
                break;
            default:
                newTaskStatus = 'Unknown Status';
                break;
        }
        
        
        $.ajax({
            type: 'POST',
            url: './php/task_status_set.php',
            data: formData,
            processData: false, 
            contentType: false,
            success: function(response) {
                console.log(response);
                if (response === '0') {
                    Swal.fire({
                        title: 'Task Status Updated',
                        text: 'Task Status is now ' + newTaskStatus,
                        icon: 'success',
                    }).then(function() {
                        location.reload();
                    })
                } else if (response === '1') {
                    Swal.fire({
                        title: 'Something Went Wrong',
                        text: 'we are unable to update this task status',
                        icon: 'error',
                    })
                } else {
                    console.log('Hello? Something Went Wrong on Submitting this data');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })
})