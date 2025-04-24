const imageUploaderElements = {
    uploadImage: document.querySelector('.app-post-type-image-uploader__button--choose'),
    imageInput: document.querySelector('.app-post-type-image-uploader__input'),
    removeImage: document.querySelector('.app-post-type-image-uploader__button--remove'),
    imagePreview: document.querySelector('.app-post-type-image-uploader__preview')
};

const isHiddenSelector = 'hide-app-post-type-image-uploader';

/**
 * Handle the image uploader
 */
document.addEventListener('DOMContentLoaded', () => {
    /**
     * Check if elements exist on the page (in other words, if the page has the image uploader)
     */
    const elementsExist = Object.values(imageUploaderElements).every(
        (element) => element !== null
    );

    if (!elementsExist) {
        return;
    }

    /**
     * Handle Select Image
     */
    imageUploaderElements.uploadImage.addEventListener('click', (e) => {
        handleSelectImage(e);
    });

    /**
     * Handle Remove Image
     */
    imageUploaderElements.removeImage.addEventListener('click', (e) => {
        handleRemoveImage(e);
    });
});

/**
 * Handle select image
 * @param {MouseEvent} e Current click event
 * @return {void}
 */
function handleSelectImage(e) {
    e.preventDefault();
    try {
        let frame;

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media({
            title: __('Select or Upload Media', 'heikkivihersalo-custom-post-types'),
            button: {
                text: __('Use this media', 'heikkivihersalo-custom-post-types'),
            },
            multiple: false,
        });

        frame.on('select', () => {
            const attachment = frame.state().get('selection').first();

            /* Place ID to the input field */
            imageUploaderElements.imageInput.value = attachment.id;

            /* Show image preview */
            imageUploaderElements.imagePreview.setAttribute(
                'src',
                attachment.attributes.url
            );
            imageUploaderElements.imagePreview.classList.remove(
                isHiddenSelector
            );

            /* Show "Remove" button */
            imageUploaderElements.removeImage.classList.remove(
                isHiddenSelector
            );

            /* Hide "Choose" button */
            imageUploaderElements.uploadImage.classList.add(isHiddenSelector);
        });

        frame.open();
    } catch (error) {
        console.error(error);
    }
}

/**
 * Handle remove image
 * @param {MouseEvent} e Current click event
 * @return {void}
 */
function handleRemoveImage(e) {
    e.preventDefault();

    /* Remove ID from the input field */
    imageUploaderElements.imageInput.value = '';

    /* Hide the preview image */
    imageUploaderElements.imagePreview.setAttribute('src', '');
    imageUploaderElements.imagePreview.classList.add(isHiddenSelector);

    /* Show "Choose" button */
    imageUploaderElements.uploadImage.classList.remove(isHiddenSelector);

    /* Hide "Remove" button */
    imageUploaderElements.removeImage.classList.add(isHiddenSelector);
}