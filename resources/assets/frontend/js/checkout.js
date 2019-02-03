$(function () {
    $('.edit1').on('click', function () {
        $('.edit1').hide();
        $('.edit2').hide();
        $('.edit3').hide();
        $('.shipDetail').show();
        $('.shipReview').hide();
        $('.orderReview').hide();
        $('.deliveryDetails').hide();
        $('.deliveryReview').hide();
        $('.paymentDetails').hide();
        $('.paymentReview').hide();
        $('.warning-div').hide();
    });

    $('.edit2').on('click', function () {
        $('.edit2').hide();
        $('.edit3').hide();
        $('.deliveryDetails').show();
        $('.deliveryReview').hide();
        $('.paymentDetails').hide();
        $('.paymentReview').hide();
        $('.orderReview').hide();
        $('.warning-div').hide();
    });

    $('.edit3').on('click', function () {
        $('.edit3').hide();
        $('.paymentDetails').show();
        $('.paymentReview').hide();
        $('.orderReview').hide();
        $('.warning-div').hide();
    });

    $('#con').on('click', function () {
        if ($('#form').valid()) {
            //alert('valid');
            $('.shipDetail').hide();
            $('#sName').text($('#firstName').val() + ' ' + $('#lastName').val());
            $('#sEmail').text($('#email').val());
            $('#sAddress').text($('#address').val() + ' ,' + $('#city').val() + ' ,' + $('#zip').val() + ' ,' + $('#country').val());
            $('#sPhone').text($('#phone').val());
            $('.shipReview').show();
            $('.deliveryDetails').show();
            $('.edit1').show();
        }
    });
    $('#con1').on('click', function () {
        $('.deliveryDetails').hide();
        $('.deliveryReview').show();
        $('.paymentDetails').show();
        $('.edit2').show();
        $('#cc-number').rules('add', {
            required: true
        });
        $('#cc-exp').rules('add', {
            required: true
        });
        $('#cc-cvc').rules('add', {
            required: true
        });

    });

    $('#check').on('change', function () {
        if ($('#check').is(":checked")) {
            $('#bfirstName').rules('remove');
            $('#blastName').rules('remove');
            $('#baddress').rules('remove');
            $('#bcity').rules('remove');
            $('#bcountry').rules('remove');
            $('#bphone').rules('remove');
            $('#bzip').rules('remove');
        } else {
            $('#bfirstName').rules('add', {
                required: true,
                minlength: 2
            });
            $('#blastName').rules('add', {
                required: true,
                minlength: 2
            });
            $('#baddress').rules('add', {
                required: true,
                minlength: 2
            });
            $('#bcity').rules('add', {
                required: true,
                minlength: 2
            });
            $('#bcountry').rules('add', {
                required: true,
                minlength: 2
            });
            $('#bphone').rules('add', {
                required: true,
                digits: true
            });
            $('#bzip').rules('add', {
                required: true
            });
        }
    });

    $('#paypal').on('change', function () {
        if ($('#paypal').is(":checked")) {
            $('.creditInfo').hide();
            $('.paypalInfo').show();
        }
    });
    $('#credit').on('change', function () {
        if ($('#credit').is(":checked")) {
            $('.paypalInfo').hide();
            $('.creditInfo').show();
        }
    });

    $('#check').change(function () {
        $('.billingAddress').toggle('show');
    });

    $('#con2').on('click', function () {
        if ($('#form').valid()) {
            if ($('#credit').is(":checked")) {
                // var cardType = $.payment.cardType($('.cc-number').val());
                // if (!$.payment.validateCardNumber($('.cc-number').val())) {
                //     $('.cc-number').parent().addClass('has-error');
                // }
                // if (!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal'))) {
                //     $('.cc-exp').parent().addClass('has-error');
                // }
                // if (!$.payment.validateCardCVC($('.cc-cvc').val(), cardType)) {
                //     $('.cc-cvc').parent().addClass('has-error');
                // }
                // if ($.payment.validateCardNumber($('.cc-number').val()) && $.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')) && $.payment.validateCardCVC($('.cc-cvc').val(), cardType)) {
                if ($('#check').is(":checked")) {
                    $('#pName').text($('#firstName').val() + ' ' + $('#lastName').val());
                    $('#pEmail').text($('#email').val());
                    $('#pAddress').text($('#address').val() + ' ,' + $('#city').val() + ' ,' + $('#zip').val() + ' ,' + $('#country').val());
                    $('#pPhone').text($('#phone').val());
                } else {
                    $('#pName').text($('#bfirstName').val() + ' ' + $('#blastName').val());
                    $('#pEmail').text($('#email').val());
                    $('#pAddress').text($('#baddress').val() + ' ,' + $('#bcity').val() + ' ,' + $('#bzip').val() + ' ,' + $('#bcountry').val());
                    $('#pPhone').text($('#bphone').val());
                }
                $('.paymentDetails').hide();
                $('.paymentReview').show();
                $('.orderReview').show();
                $('.edit3').show();
                // }
            } else {
                if ($('#check').is(":checked")) {
                    $('#pName').text($('#firstName').val() + ' ' + $('#lastName').val());
                    $('#pEmail').text($('#email').val());
                    $('#pAddress').text($('#address').val() + ' ,' + $('#city').val() + ' ,' + $('#zip').val() + ' ,' + $('#country').val());
                    $('#pPhone').text($('#phone').val());
                } else {
                    $('#pName').text($('#bfirstName').val() + ' ' + $('#blastName').val());
                    $('#pEmail').text($('#email').val());
                    $('#pAddress').text($('#baddress').val() + ' ,' + $('#bcity').val() + ' ,' + $('#bzip').val() + ' ,' + $('#bcountry').val());
                    $('#pPhone').text($('#bphone').val());
                }
                $('.paymentDetails').hide();
                $('.paymentReview').show();
                $('.orderReview').show();
                $('.edit3').show();
            }
        }
    });

    $('#con3').on('click', function () {
        if ($('#form').valid()) {
            $('#form').submit();
        } else {
            $('.warning-div').show();

        }
    });

    $('#close').on('click', function () {
        $('.warning-div').hide();
    });



    $('.cc-number').keyup(function () {
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-brand').text(cardType);
    });
    $('.cc-number').on('blur', function () {
        $('.cc-number').toggleInputError(!$.payment.validateCardNumber($('.cc-number').val()));
    });
    $('.cc-exp').on('blur', function () {
        $('.cc-exp').toggleInputError(!$.payment.validateCardExpiry($('.cc-exp').payment('cardExpiryVal')));
    });
    $('.cc-cvc').on('blur', function () {
        var cardType = $.payment.cardType($('.cc-number').val());
        $('.cc-cvc').toggleInputError(!$.payment.validateCardCVC($('.cc-cvc').val(), cardType));
    });


    jQuery(function ($) {
        $('[data-numeric]').payment('restrictNumeric');
        $('.cc-number').payment('formatCardNumber');
        $('.cc-exp').payment('formatCardExpiry');
        $('.cc-cvc').payment('formatCardCVC');

        $.fn.toggleInputError = function (erred) {
            this.parent('.form-group').toggleClass('has-error', erred);
            return this;
        };
    });
});