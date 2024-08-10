//contact us form
$(".contact_btn").on('click', function () {
    $(".contact_btn i").removeClass('d-none');

    // Define required fields
    var requiredFields = ['userEmail']; // Adicione aqui os campos obrigatórios

    // Simple validation at client's end
    var post_data, output;
    var proceed = true;

    // Check required fields
    requiredFields.forEach(function(field) {
        var fieldValue = $('#contact-form-data input[name="' + field + '"]').val();
        if (!fieldValue) {
            proceed = false;
            return false; // Stop the loop
        }
    });

    if (proceed) {
        var pathArray = window.location.pathname.split('/');
        var secondLevelLocation = pathArray[3];

        var accessURL = secondLevelLocation ? "../vendor/contact-mailer.php" : "vendor/contact-mailer.php";

        var str = $('#contact-form-data').serializeArray();

        // Data to be sent to server
        $.ajax({
            type: 'POST',
            url: accessURL,
            data: str,
            dataType: 'json',
            success: function (response) {
                if (response.type == 'error') {
                    output = '<div class="alert-danger" style="padding:10px 15px; margin-bottom:30px;">' + response.text + '</div>';
                } else {
                    output = '<div class="alert-success" style="padding:10px 15px; margin-bottom:30px;">' + response.text + '</div>';
                    $('.contact-form input').val('');
                    $('.contact-form textarea').val('');
                }

                if ($("#result").length) {
                    $("#result").hide().html(output).slideDown();
                } else {
                    Swal.fire({
                        type: response.type,
                        icon: response.type,
                        title: response.type === 'error' ? 'Oops...' : 'Success!',
                        html: '<div class="text-' + response.type + '">' + response.text + '</div>',
                    });
                }
                $(".contact_btn i").addClass('d-none');
            },
            error: function () {
                alert("Failer");
            }
        });
    } else {
        if ($("#result").length) {
            output = '<div class="alert-danger" style="padding:10px 15px; margin-bottom:30px;">Please provide the missing fields.</div>';
            $("#result").hide().html(output).slideDown();
        } else {
            Swal.fire({
                icon: 'error',
                type: 'error',
                title: 'Oops...',
                html: '<div class="text-danger">Please provide the missing fields.</div>'
            });
        }
        $(".contact_btn i").addClass('d-none');
    }
});

// Modal window form
$(".modal_contact_btn").on('click', function () {
    $(".modal_contact_btn i").removeClass('d-none');

    // Define required fields
    var requiredFields = ['userEmail']; // Adicione aqui os campos obrigatórios

    // Simple validation at client's end
    var post_data, output;
    var proceed = true;

    // Check required fields
    requiredFields.forEach(function(field) {
        var fieldValue = $('#modal-contact-form-data input[name="' + field + '"]').val();
        if (!fieldValue) {
            proceed = false;
            return false; // Stop the loop
        }
    });

    if (proceed) {
        var pathArray = window.location.pathname.split('/');
        var secondLevelLocation = pathArray[3];

        var accessURL = secondLevelLocation ? "../vendor/contact-mailer.php" : "vendor/contact-mailer.php";

        var str = $('#modal-contact-form-data').serializeArray();

        // Data to be sent to server
        $.ajax({
            type: 'POST',
            url: accessURL,
            data: str,
            dataType: 'json',
            success: function(response) {
                if (response.type == 'error') {
                    output = '<div class="alert-danger" style="padding:10px 15px; margin-bottom:30px;">' + response.text + '</div>';
                } else {
                    output = '<div class="alert-success" style="padding:10px 15px; margin-bottom:30px;">' + response.text + '</div>';
                    $('.contact-form input').val('');
                    $('.contact-form textarea').val('');
                }

                if ($("#quote_result").length) {
                    $("#quote_result").hide().html(output).slideDown();
                } else {
                    Swal.fire({
                        type: response.type,
                        icon: response.type,
                        title: response.type === 'error' ? 'Oops...' : 'Success!',
                        html: '<div class="text-' + response.type + '">' + response.text + '</div>',
                    });
                }
                $(".modal_contact_btn i").addClass('d-none');
            },
            error: function () {
                alert("Failer");
            }
        });
    } else {
        if ($("#quote_result").length) {
            output = '<div class="alert-danger" style="padding:10px 15px; margin-bottom:30px;">Please provide the missing fields.</div>';
            $("#quote_result").hide().html(output).slideDown();
        } else {
            Swal.fire({
                icon: 'error',
                type: 'error',
                title: 'Oops...',
                html: '<div class="text-danger">Please provide the missing fields.</div>'
            });
        }
        $(".modal_contact_btn i").addClass('d-none');
    }
});
