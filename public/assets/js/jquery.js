function updateTransactionStatus(transaction_id, status, row) {

    if (
        confirm(
            `Are you sure you want to ${status.toLowerCase()} this Transaction?`
        )
    ) {
        $.ajax({
            url: `/admin/transactions/update/${transaction_id}/${status}`,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "PATCH",
            },
            success: function (response) {
                // Remove the row from the table
                $(row).remove();
                console.log(response.message);
            },
            error: function (xhr, status, error) {
                console.error(error);
                console.error(status);
                console.error(xhr);
            },
        });
    }
}

function updatePhoneStatus(phoneId, status, row) {
    if (
        confirm(`Are you sure you want to ${status.toLowerCase()} this phone?`)
    ) {
        $.ajax({
            url: `/admin/phones/update/${phoneId}/${status}`,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "PATCH",
            },
            success: function (response) {
                // Remove the row from the table
                $(row).remove();
                console.log(response.message);
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    }
}
