$(document).ready(function() {
    $('#photo-input').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-preview').attr('src', e.target.result);
                $('#upload-button').prop('disabled', false);
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    $('#upload-button').click(function() {
        var formData = new FormData($('#profile-form')[0]);
        var url = $('#profile-form').attr('action'); // Get the URL from the form's action attribute
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Profile photo updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                  })

            // Disable the button after successful upload
            $('#upload-button').prop('disabled', true);
            },

            
            
            error: function(xhr, status, error) {
                // Handle error response, if needed
                console.error(error);
            }
        });
    });
});