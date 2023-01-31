$(document).ready(function() {

    $('.image-preview-container-o').sortable({
        stop(ev, ui) {
            let sort = [];
            $('.image-preview-container-o .image-preview-o').each(function(index, element){
                sort.push($(element).attr('data-id'));
            });
            $.ajax({
                url: '/admin/images/save-sort',
                method: 'post',
                data: {ids: JSON.stringify(sort)},
                success(response) {
                    if(response.result) {
                        displaySuccessMessage(response.message)
                    }
                },
                error(e) {
                    console.log('error', e)
                }
            });
        }
    });

    if (!$('#page-alias').val()) {
        $(".page-name").keyup(function() {
            $('#page-alias').val(slugify($(this).val()));
        });
    }

    if (!$('#page-h1').val()) {
        $(".page-name").keyup(function() {
            $('#page-h1').val($(this).val());
            $('#page-title').val($(this).val());
            $('#page-name').val($(this).val());
        });
    }

    $('.default-form').on('beforeSubmit', function (e) {
        console.log('beforeSubmit')
        let form = $(this);
        var data = form.serialize();
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: data,
            success: function(res) {
                console.log('response', res);
                form[0].reset();
            },
            error: function(e) {
                console.log('error', e)
            }
        })
        return false;
    });

    function displaySuccessMessage(message) {
        $('.info-message').text(message);
        setTimeout(function() {
            $('.info-message').text('');
        }, 3000)
    }
    function displayErrorMessage(message) {
        $('.info-message').addClass('error').text(message);
        setTimeout(function() {
            $('.info-message').text('');
        }, 3000)
    }

    function initPlugins() {
        $('.chosen').chosen()
        $(".select-time").inputmask({"mask": "99:99"});
        $(".phone-mask").inputmask({"mask": "+7 (999) 999-99-99"});
    }
    initPlugins()
})
