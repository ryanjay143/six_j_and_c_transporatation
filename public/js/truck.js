    const truckPhotoInput = document.getElementById('truck_photo_input');
    const truckPhotoPreview = document.getElementById('truck_photo_preview');
    const truckPhotoPreviewContainer = document.getElementById('truck_photo_preview_container');

    // Add event listener to the file input to handle image preview
    truckPhotoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                truckPhotoPreview.setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
            truckPhotoPreviewContainer.style.display = 'block';
        } else {
            truckPhotoPreviewContainer.style.display = 'none';
        }
    });



   // Add event listener to handle image preview for all file inputs
   document.addEventListener('change', function (event) {
    if (event.target.classList.contains('truck-photo-input')) {
        const fileInput = event.target;
        const truckId = fileInput.dataset.truckId;
        const truckPhotoPreview = document.getElementById('truck_photo_view_' + truckId);

        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                truckPhotoPreview.setAttribute('src', e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            // If no new photo is selected, show the current photo
            truckPhotoPreview.setAttribute('src', "{{ asset($t->truck_image) }}");
        }
    }
});