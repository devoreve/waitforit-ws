$(function(){
    Vue.config.delimiters = ['${', '}'];

    new Vue({
        el: "#app",
        data: {
            url: $('form').data('url'),
            isSuccess: false,
            errors: {},
            tokenError: false,
            message: null
        },
        methods: {
            submit: function(event){
                event.preventDefault();
                $.ajax(this.url, {
                    data: $('form').serialize(),
                    dataType: 'json',
                    method: 'post',
                    success: this.success,
                    error: this.error
                });
            },
            success: function(data){
                this.isSuccess = data.success;
                this.tokenError = !this.isSuccess;
                this.errors = {};
                this.message = data.response;
            },
            error: function(error){
                this.errors = error.responseJSON;
                this.isSuccess = false;
            }
        }
    });
});