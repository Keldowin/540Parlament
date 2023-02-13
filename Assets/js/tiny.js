tinymce.init({
    selector: 'textarea',
    height: 300,
    menubar: false,
    automatic_uploads: false,
    plugins: [
        'image code advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    menubar: 'file edit view insert format tools table tc help',
    toolbar: 'image code fullscreen | undo redo | formatselect | ' +
        'bold italic forecolor backcolor link| alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent table | ' +
        'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    convert_urls: true,
    relative_urls: true,
    document_base_url: docBaseUrl,
    automatic_uploads: false,
    paste_data_images: true,
    image_uploadtab: true,
    //remove_script_host : true,
    images_upload_handler: function(blobInfo, success, failure) {},

});