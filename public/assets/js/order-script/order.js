$('.create-filter').on('click', function () {
    $('#filter_id').val('');
    $('#name').val('');
    $('#id').val('');
    $('#order_number').val('');
    $('#select_store').val('').trigger('change');
    // $('#brand').val();
    // $('#tracking_id').val('');
    // $('#min_amount').val('');
    // $('#max_amount').val('');
    // $('#product_id').val('all');

});
$('.filter-e').on('click', function () {
    var filterdata = $(this).data('filter');
    // alert(filterdata);
    $('#name').val(filterdata.name);
    $('#filter_id').val(filterdata.id);
    var value = JSON.parse(filterdata.value);
    // $('#id').val(value.id);
    $('#date_range').val(value.date_range);
    // $('#order_number').val(value.order_number);
    // var store_ids = value.store_ids.split(", ");
    const values = value.store_ids.split(",");
    console.log(values);
    $('#select_store').val(values).trigger('change');
    // $('#brand').val(value.brand);
    // $('#tracking_id').val(value.tracking_id);
    // $('#min_amount').val(value.min_amount);
    // $('#max_amount').val(value.max_amount);
    $('#product_id').val(value.product_id);
    $('#fullfillment').val(value.fullfillment);
    // console.log(filterdata.id);

});
$('.filter-delete').on('click', function () {
    var filterdata = $(this).data('filter');
    const url = "{{ route('filters.destroy', ['filter' => ':filter']) }}";
    $('#delete-form').attr('action', url.replace(':filter', filterdata));
});
var box = document.getElementById('OrderFilter');
function showOrderFilter() {
    if (box.style.display == "block") {
        box.style.display = "none";
    } else {
        box.style.display = "block";
    }
}

// selected Order Ids1
var selectedOrderIds1 = [];
$('.select-checkbox').on('click', function () {
    $('#box-floating').show();
    var checkbox = $(this);
    var orderId = checkbox.data('order-id');

    if (checkbox.prop('checked')) {
        selectedOrderIds1.push(orderId);
        console.log(selectedOrderIds1);
    } else {
        var index = selectedOrderIds1.indexOf(orderId);
        if (index !== -1) {
            selectedOrderIds1.splice(index, 1);
        }
        if (selectedOrderIds1.length === 0) {
            document.getElementById('select-all-checkbox').checked = false;
            $('#box-floating').hide();

        }
    }

    $('#selectedOrderIds').val(selectedOrderIds1.join(','));
    $('#captureIds').val(selectedOrderIds1);
    $('#bookIds').val(selectedOrderIds1);
    $('.orderids').val(selectedOrderIds1);

});
document.getElementById('select-all-checkbox').addEventListener('change', function () {
    $('#box-floating').show();

    const isChecked = this.checked;
    selectedOrderIds1 = [];

    document.querySelectorAll('.select-checkbox').forEach(checkbox => {
        checkbox.checked = isChecked;
        if (isChecked) {
            var orderId = parseInt(checkbox.getAttribute('data-order-id'));
            selectedOrderIds1.push(orderId);
        }
    });
    $('#captureIds').val(selectedOrderIds1);
    $('#bookIds').val(selectedOrderIds1);
    $('.orderids').val(selectedOrderIds1);

    // Check if the array is not empty when checkboxes are checked
    if (isChecked && selectedOrderIds1.length === 0) {
        // Handle the case where no checkboxes are selected after checking all
        alert('Please select at least one checkbox.');
        // Optionally, you may want to uncheck the "select-all-checkbox" here
        this.checked = false;
        $('#box-floating').hide();

    }

    console.log(selectedOrderIds1);
});


$('.cancel-order').on('click', function () {
    $('#changeRequestType').val('cancel_order');
});
$('.cancel-void').on('click', function () {
    $('#changeRequestType').val('void_order');
});