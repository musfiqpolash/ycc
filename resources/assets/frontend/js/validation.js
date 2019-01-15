$(function(){

    $('#form').validate({
        rules:{
            email:{
                required     : true,
                email        : true
            },
            phone:{
                required     : true,
                digits       : true
            },
            firstName:{
                required : true,
                minlength:2
            },
            lastName:{
                required : true,
                minlength:2
            },
            address:{
                required : true,
                minlength:2
            },
            city:{
                required : true,
                minlength:2
            },
            country:{
                required : true,
                minlength:2
            },
            zip:{
                required : true,
                minlength:2
            }

        },

        highlight: function (element) {
            $(element).parent().addClass('has-error')
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('has-error')
        }
    });
});
