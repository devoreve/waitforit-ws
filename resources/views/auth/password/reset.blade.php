<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <style>
        [v-cloak] {
            display:none;
        }
    </style>
</head>
<body>

<div class="container" id="app">

    <h1 class="text-center">Reset password</h1>

    <form class="form-horizontal" data-url="{{route('password.reset')}}">

        <input type="hidden" name="token" value="{{$token}}">

        <div class="form-group" v-bind:class="{ 'has-error': errors.email }">
            <label class="col-md-4 control-label" for="email">Email</label>
            <div class="col-md-4">
                <input id="email" name="email" class="form-control input-md" required="" type="email" value="{{$email}}">
                <span v-show="errors.password" class="help-block" v-cloak>${errors.email[0]}</span>
            </div>
        </div>

        <div class="form-group" v-bind:class="{ 'has-error': errors.password }">
            <label class="col-md-4 control-label" for="password">Password</label>
            <div class="col-md-4">
                <input id="password" name="password" class="form-control input-md" type="password" required="">
                <span v-show="errors.password" class="help-block" v-cloak>${errors.password[0]}</span>
            </div>
        </div>

        <div class="form-group" v-bind:class="{ 'has-error': errors.password }">
            <label class="col-md-4 control-label" for="password_confirmation">Password confirmation</label>
            <div class="col-md-4">
                <input id="password_confirmation" name="password_confirmation" class="form-control input-md" type="password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button class="btn btn-primary btn-block" v-on:click="submit">Submit</button>
            </div>
        </div>
    </form>

    <div class="col-md-4 col-md-offset-4 text-center">
        <div class="alert alert-success alert-dismissible fade in" role="alert" v-show="isSuccess" v-cloak>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>${message}</p>
        </div>
        <div class="alert alert-danger alert-dismissible fade in" role="alert" v-show="tokenError" v-cloak>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p>${message}</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>
