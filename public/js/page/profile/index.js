/**
 * Created by Vu Hai on 1/15/2017.
 */
$(document).ready(function () {
    $('#editUser').on('hidden.bs.modal', function () {
        //clear form
        $('#editUserError').empty('');
    });

    //update user
    $('.updateUser').on('click', function () {

        //prepare data
        var formData = new FormData();
        formData.append('email', $('#editUser').find('[name="email"]').val());
        formData.append('password', $('#editUser').find('[name="password"]').val());
        formData.append('full_name', $('#editUser').find('[name="full_name"]').val());
        formData.append('phone', $('#editUser').find('[name="phone"]').val());
        formData.append('address', $('#editUser').find('[name="address"]').val());
        formData.append('memo', $('#editUser').find('[name="memo"]').val());
        formData.append('avatar', $("#update_avatar")[0].files[0]);
        formData.append('id', $('#editUser').find('[name="id"]').val());

        updateUserProfile(formData)


    });
});
function updateUserProfile(data) {
    $.ajax({
        url: SITE_ROOT + '/profile/update',
        data: data,
        method: 'POST',
        processData: false,
        contentType: false,

        success: function (response) {
            //hidden modal
            $("#editUserError").html(
                '<div class="alert alert-success">' +
                '<button class="close" data-close="alert"></button>' +
                'Update profile Successfully' + '<br>'
                + '</div>'
            )
        },
        error: function (response) {
            jQuery.each(response.responseJSON, function (i, error) {
                $("#editUserError").html(
                    '<div class="alert alert-danger">' +
                    '<button class="close" data-close="alert"></button>' +
                    error[0] + '<br>'
                    + '</div>'
                )
            });
        }
    });
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_avatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
