
$(function() {



    // SPLASH PAGE
    TweenMax.to($('p.hover'), 9, {ease: Power4.easeIn, opacity:0.7});


    // SPLASH PAGE
    $('.sample_wrapper').on('mouseover', function() {
        $('p.hover').hide();
    });


    // SPLASH PAGE
    $('.sample_wrapper').hover(
        function() {
            $(this).find('.composite').addClass('active');
        }, function() {
            $(this).find('.composite').removeClass('active');
        }
    );


    // SPLASH PAGE
    $('form.splash_form button').on('click', function(event) {

        event.preventDefault();

        if ($('form.splash_form .sku').val()) {
            $('form.splash_form').submit();
        }
    });





    // WORK ZONE
    // create an array to hold unused/available 'layers'
    var avail_layers = ['layer_a', 'layer_b', 'layer_c'];
    // create an array to hold used 'layers'
    var used_layers = [];

    // WORK ZONE
    $('.slider').slick({
        arrows: true,
        infinite: false,
        slidesToShow: 7,
        slidesToScroll: 7,
        swipe: false
    });


    // WORK ZONE
    // set a listener on all slider images
    $(document).on('click', '.slider_wrapper .slick-slide img', function() {

        // check to see if there is an available 'layer'
        if (avail_layers.length) {

            // remove click listener from this particular image
            //$(this).off('click');

            // remove 'active' class from any/all images in the 'layers_tracker'
            $('.layers_tracker img').removeClass('active');

            // add 'used' class to the image that was clicked on
            $(this).addClass('used');

            // set all images in the 'work_canvas' to the lowest z-index
            $('.work_canvas img').css('z-index', 999);

            // pull first available layer out of, and into arrays
            var layer_name = avail_layers.shift();
            used_layers.push(layer_name);

            // add custom data attribute to the image that was clicked on

    // ??
    // $(this).attr('data-layer', layer_name);
    // ??

            // clone the clicked image and add/remove data from it, append it to the work_canvas
            $(this).clone().css('z-index', 1001).addClass(layer_name).removeClass('used').removeAttr('title').removeAttr('opacity').attr('data-rotate', 0).attr('data-scale', 0.474).appendTo('.work_canvas');

            // set the 'glass slide' to the middle z-index
            $('#glass_slide').css('z-index', 1000);

            // set the new image in the 'work_canvas' to draggable
            Draggable.create($('.' +layer_name), {
                minX: 100,
                edgeResistance:0.25
            });

            // scale image to fit the work_canvas
            TweenMax.set($('.' +layer_name), {scale:0.474, x:-265, y:-265});

            $(this).clone().addClass(layer_name).addClass('active').removeClass('used').removeAttr('title').removeAttr('opacity').attr('data-layer', layer_name).appendTo('.layers_tracker');

            $('.layers_tracker .' +layer_name).on('click', function() {
                focus_active($(this));
            })
        }

    });


    // WORK ZONE
    $('.image_tools img').on('click', function() {

        if ($('.layers_tracker img.active').length) {

            if ($(this).hasClass('anti')) {

                var target_layer_name = $('.layers_tracker img.active').attr('data-layer');

                var obj = $('.work_canvas .' + target_layer_name);

                if ($(this).hasClass('inset')) {
                    var current_value = parseFloat(obj.attr('data-rotate')) - 0.5;
                } else {
                    var current_value = parseFloat(obj.attr('data-rotate')) - 15;
                }

                TweenMax.to(obj, 0.5, {rotation: current_value});

                obj.attr('data-rotate', current_value);

            } else if ($(this).hasClass('clock')) {

                var target_layer_name = $('.layers_tracker img.active').attr('data-layer');

                var obj = $('.work_canvas .' + target_layer_name);

                if ($(this).hasClass('inset')) {
                    var current_value = parseFloat(obj.attr('data-rotate')) + 0.5;
                } else {
                    var current_value = parseFloat(obj.attr('data-rotate')) + 15;
                }

                TweenMax.to(obj, 0.5, {rotation: current_value});

                obj.attr('data-rotate', current_value);

            } else if ($(this).hasClass('larger')) {

                var target_layer_name = $('.layers_tracker img.active').attr('data-layer');

                var obj = $('.work_canvas .' + target_layer_name);

                if ($(this).hasClass('inset2')) {
                    var current_value = parseFloat(obj.attr('data-scale')) + 0.05;
                } else {
                    var current_value = parseFloat(obj.attr('data-scale')) + .2;
                }

                if (current_value > 1) {
                    current_value = 1;
                }

                TweenMax.to(obj, 0.5, {scale: current_value});

                obj.attr('data-scale', current_value);

            } else if ($(this).hasClass('smaller')) {

                var target_layer_name = $('.layers_tracker img.active').attr('data-layer');

                var obj = $('.work_canvas .' + target_layer_name);

                if ($(this).hasClass('inset2')) {
                    var current_value = parseFloat(obj.attr('data-scale')) - 0.05;
                } else {
                    var current_value = parseFloat(obj.attr('data-scale')) - .2;
                }

                if (current_value < 0.05) {
                    current_value = 0.05;
                }

                TweenMax.to(obj, 0.5, {scale: current_value});

                obj.attr('data-scale', current_value);

            }
        }

    });


    // WORK ZONE
    $('body').on('keydown', function(event) {

        if (!$('.description').is(":focus")) {

            if (event.which === 82) {

                // keypress 'R' key (for RE-CENTER active layer)
                if ($('.layers_tracker').children().length > 0) {
                    var target_layer_id = $('.layers_tracker img.active').attr('data-layer');
                    TweenMax.to($('.work_canvas img.' + target_layer_id), 0.5, {x: -265, y: -265})
                }

            } else if (event.which === 68) {

                // keypress 'D' key (for DELETE active layer)
                if ($('.layers_tracker').children().length > 0) {
                    var target_layer_id = $('.layers_tracker img.active').attr('data-layer');
                    var src = $('.layers_tracker img.' + target_layer_id).attr('src');
                    var clear = true;

                    // remove node work_canvas
                    $('.work_canvas img.' + target_layer_id).remove();

                    // remove node from layers_tracker
                    $('.layers_tracker img.' + target_layer_id).remove();
                    // set another image to active

                    //verify that the image is not used more than once
                    $('.layers_tracker img').each(function() {
                        if ($(this).attr('src') === src) {
                            clear = false;
                        }
                    });

                    if (clear) {
                        // remove used class from slider
                        $('.slider_wrapper img').each(function() {
                            if ($(this).attr('src') === src) {
                                $(this).removeClass('used');
                            }
                        })
                    }

                    // remove layer id from used_layers array
                    for (var i = 0; i < used_layers.length; i++) {
                        if (used_layers[i] === target_layer_id) {
                            used_layers.splice(i, 1);
                        }
                    }

                    // add layer id to avail_layers array
                    avail_layers.push(target_layer_id);

                }

            } else if (event.which === 77) {

                // keypress 'M' key (for toggle MASK dark/light)
                $('#glass_slide').hasClass('hide') ? $('#glass_slide').removeClass('hide') : $('#glass_slide').addClass('hide');

            }

        }
    });


    // WORK ZONE
    $('body').on('keyup', function(event) {

        if ($('.details .line1').is(":focus")) {

            $('.text_overlay_wrapper .overlay1').text($('.details .line1').val());
        }

        if ($('.details .line2').is(":focus")) {

            $('.text_overlay_wrapper .overlay2').text($('.details .line2').val());
        }
    });


    // WORK ZONE
    $('.toggle .switch').change(function() {

        if ($(this).hasClass('active')) {

            $('#glass_slide').show();
            $('.text_overlay_wrapper').hide();
            $('.details .description').attr('disabled', 'disabled');
            $('.blockers').hide();
            $(this).removeClass('active');

        } else {

            $('#glass_slide').hide();
            $('.overlay1').empty().text($('.details .line1').val());
            $('.overlay2').empty().text($('.details .line2').val());
            $('.text_overlay_wrapper').show();
            $('.details .description').removeAttr('disabled');
            $('.blockers').show();
            $(this).addClass('active');
        }

    });


    // WORK ZONE
    $('form.telemetry button').on('click', function(event) {

        event.preventDefault();

        if ($('.layers_tracker img').length) {
            process_form();
        }
    });


    // WORK ZONE - WHEN TELEMETRY EXISTS
    if ($('#telemetry').text().length) {

        // parse the JSON object
        var telemetry = JSON.parse($('#telemetry').text());

        // we are going to be referencing these, so let's mave them variable objects
        var lt = $('.layers_tracker');
        var wc = $('.work_canvas');
        var sw = $('.slider_wrapper');


        // process each image

        // pull first available layer out of, and into arrays
        var layer_name = avail_layers.shift();
        used_layers.push(layer_name);

        lt.append('<img class="' +layer_name+ ' active" src="' +telemetry['layer-a']['url']+ '" style="opacity: 1;" data-layer="' +layer_name+ '">');

        wc.append('<img class="' +layer_name+ '" src="' +telemetry['layer-a']['url']+ '" style="opacity: 1; z-index: 1001;" data-rotate="' +telemetry['layer-a']['rotation']+ '" data-scale="' +telemetry['layer-a']['scale']+ '">');

        TweenMax.to($('.work_canvas .' +layer_name), 0.25, {x:telemetry['layer-a']['x_offset_gsap'], y:telemetry['layer-a']['y_offset_gsap']});

        TweenMax.to($('.work_canvas .' +layer_name), 0.25, {scale:telemetry['layer-a']['scale']});

        TweenMax.to($('.work_canvas .' +layer_name), 0.25, {rotation:telemetry['layer-a']['rotation']});

        $('.slider_wrapper img').each(function() {
           if ($(this).attr('data-lazy') === telemetry['layer-a']['url']) {
               $(this).addClass('used');
           }
        });

        // set the new image in the 'work_canvas' to draggable
        Draggable.create($('.work_canvas .' +layer_name), {
            minX: 100,
            edgeResistance:0.25
        });


        // add image to layer_tracker, work_zone, hilight in slider
        // etc.

    }


});

function focus_active(target_element) {

    var cla= target_element.attr('class');

    $('.layers_tracker img').removeClass('active');
    target_element.addClass('active');

    $('.work_canvas img').css('z-index', 999);
    $('#glass_slide').css('z-index', 1000);
    $('.work_canvas .' +cla).css('z-index', 1001);
}






















function process_form() {

    var idx = 0;

    $('.line1_text').attr('value', $('.details .line1').val());
    $('.line2_text').attr('value', $('.details .line2').val());

    $('.work_canvas img').each(function() {

        if ($(this).attr('id') !== 'glass_slide') {
            $('.url_' +idx.toString()).val($(this).attr('src'));
            $('.rotation_' +idx.toString()).val($(this).attr('data-rotate'));
            $('.scale_' +idx.toString()).val($(this).attr('data-scale'));

            var position = $(this).position();

            $('.x_offset_js_' +idx.toString()).val(position.left);
            $('.y_offset_js_' +idx.toString()).val(position.top);

            TweenMax.set($(this), {rotation:0, scale:1, opacity: 0});

            position = $(this).position();

            $('.x_offset_gsap_' +idx.toString()).val(position.left);
            $('.y_offset_gsap_' +idx.toString()).val(position.top);

            idx++;
        }

    });

    $('form.telemetry').submit();
}
