function initUpload(id)
{
    var form_id = 'upload-form-' + id;
    var area_id = 'upload-' + id;

    var route = $('#upload-' + id).attr('data-route');
    var callback = $('#upload-' + id).attr('data-callback');

    var form = $('<form id="' + form_id + '" method="post" action="' + route + '" enctype="multipart/form-data"><input type="file" name="UploadForm[file]" multiple /></form>');

    form.appendTo($('#upload-forms'));

    var ul = $('#' + area_id + ' ul');

    $('#' + area_id + ' .drop a').click(function ()
    {
        // Simulate a click on the file input button
        // to show the file browser dialog
        $('#' + form_id + ' input').click();
    });

    var csrf_param = $('meta[name=csrf-param]').attr('content');
    var csrf_token = $('meta[name=csrf-token]').attr('content');

    var options = {
        form_id: id,
        object_id: $('#upload-' + id).attr('data-object-id'),
        field_id: $('#upload-' + id).attr('data-field-id')
    };

    options[csrf_param] = csrf_token;

    // Initialize the jQuery File Upload plugin
    $('#' + form_id).fileupload({
        // This element will accept file drag/drop uploading
        dropZone: $('#' + area_id + ' .drop'),

        formData: options,
        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data)
        {
            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"' +
                '  data-readOnly="1" /><p></p><span class="actions"></span><div class="clearfix"></div></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                .append('<span class="size">' + formatFileSize(data.files[0].size) + '</span>')
                .append('<span class="errors error"></span>')
                .append('<span class="success" style="color:#090"></span>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob({
                'format': function (value)
                {
                    return value + '%';
                }
            });

            // Listen for clicks on the cancel icon
            tpl.find('.actions').click(function ()
            {
                if (tpl.hasClass('working'))
                {
                    jqXHR.abort();
                }

                tpl.fadeOut(function ()
                {
                    tpl.remove();
                });
            });

            var jqXHR = data.submit().success(function (response)
            {
                console.log(response);

                if (response.errors)
                {
                    jErrors = response.errors;
                    data.context.find('.errors').html(jErrors.join('<br/>'));
                }
                else if (response)
                {
                    /*data.context.fadeOut(function ()
                    {
                        data.context.remove();
                    });*/

                    if (response.success)
                    {
                        data.context.find('.success').html('success');
                        $('#uploadform-src').val(response.src);
                        $('#upload-img').attr('src','/uploads/s/' + response.src);
                    }

                    if (callback && typeof window[callback] == 'function')
                    {
                        window[callback](response);
                    }
                    else
                    {
                        uploadCallback(response, id);
                    }
                }
            });
        },
        progress: function (e, data)
        {
            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();
        },
        fail: function (e, data)
        {
            console.log(data.jqXHR);

            $('#debug').html('<pre>' + data.jqXHR.responseText);

            // Something has gone wrong!
            data.context.addClass('error');

            data.context.find('.errors').html('Неизвестная ошибка закачки файла.');
        }
    });

    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e)
    {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes)
    {
        if (typeof bytes !== 'number')
        {
            return '';
        }

        if (bytes >= 1000000000)
        {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000)
        {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

}

function initUploadForms()
{
    if ($('#upload-forms').length == 0)
    {
        $('body').prepend('<div id="upload-forms"></div>');
    }

    $('.upload').each(
        function ()
        {
            var id = $(this).attr('id').match((/(.+)[-](.+)/));
            var object_id = $(this).attr('data-object-id');

            if (object_id != '')
            {
                initUpload(id[2]);
            }
        }
    );
}

function uploadCallback(response, field)
{
    if (response.data)
    {
        $('#files-' + field).html(response.data);
    }

    if (response.update_time)
    {
        $('#object-form input[name=update_time]').val(response.update_time);
    }
}

function deleteFile(id)
{
    if (confirm('Вы действительно хотите удалить данный файл?'))
    {
        var field = $('#upload-file-'+id).parent().parent().attr('id').match((/(.+)[-](.+)/))[2];

        var route = $('#upload-' + field).attr('data-route');

        ajax(route + 'delete-file/' + id + '/', {'field': field}, deleteFileCallback);
    }
}

function deleteFileCallback(response, data)
{
    if (response.errors)
    {
        alert(join(response.errors, '\n'))
    }
    else if (response.data)
    {
        $('#files-' + data.field).html(response.data);
    }

    if (response.update_time)
    {
        $('.smart-form input[name=update_time]').val(response.update_time);
    }
}

initUploadForms();