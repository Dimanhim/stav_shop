$(document).ready(function() {

    /**
     * сортирует изображения
     * */
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
// ---------- BEGIN slug
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

    if (!$('#product-alias').val()) {
        $("#product-name").keyup(function() {
            $('#product-alias').val(slugify($(this).val()));
        });
    }

    if (!$('#catalogue-alias').val()) {
        $("#catalogue-name").keyup(function() {
            $('#catalogue-alias').val(slugify($(this).val()));
        });
    }
// ---------- END slug



    /**
     * сворачивает/разворачивает карточку
     * */
    $('body').on('click', '.card-header-o', function(e) {
        e.preventDefault();
        let parent = $(this).closest('.card-img-o');
        let body = parent.find('.card-body-o');
        let icon = $(this).find('.bi')
        if(body.is(':visible')) {
            body.slideUp();
            icon.removeClass('bi-chevron-up').addClass('bi-chevron-down')
        }
        else {
            body.slideDown();
            icon.removeClass('bi-chevron-down').addClass('bi-chevron-up')
        }
    });

    /**
     * в форме товара показывает форму атрибутов по их типу
     * */
    $('body').on('click', '.show-attributes-for-type-o', function(e) {
        e.preventDefault();
        let self = $(this);
        console.log('id', self.attr('data-type-id'))
    });

    /**
     * сохраняет выбранные типы атрибутов
     * */
    $('body').on('change', '.checkbox-select-type-o', function(e) {
        e.preventDefault();
        let self = $(this);
        let checked = self.is(':checked') ? 1 : 0;
        let product_id = self.attr('data-product-id');
        let attribute_type_id = self.val();
        $.ajax({
            url: '/admin/product/select-product-type',
            type: 'POST',
            data: {product_id: product_id, attribute_type_id: attribute_type_id, checked: checked},
            success: function (res) {
                if(res.result) {
                    $('.attribute-type-list-o').replaceWith(res.html);
                    displaySuccessMessage(res.message);
                }
            },
            error: function () {
                alert('Error!');
            }
        });
    });



// не нужен
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

    initPlugins()
})
