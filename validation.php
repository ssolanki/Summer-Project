<!DOCTYPE html>
<html>
<head>
    <title>BootstrapValidator demo</title>

    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/bootstrapValidator.css"/>

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <!-- form: -->
            <section>
              
                <div class="col-lg-8 col-lg-offset-2">
                    <form id="defaultForm" method="post" action="target.php" class="form-horizontal">
                        <fieldset>
                            <legend>Not Empty validator</legend>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Username</label>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="username" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Country</label>
                                <div class="col-lg-5">
                                    <select class="form-control" name="country">
                                        <option value="">-- Select a country --</option>
                                        <option value="fr">France</option>
                                        <option value="de">Germany</option>
                                        <option value="it">Italy</option>
                                        <option value="jp">Japan</option>
                                        <option value="ru">Russia</option>
                                        <option value="gb">United Kingdom</option>
                                        <option value="us">United State</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-5 col-lg-offset-3">
                                    <div class="checkbox">
                                        <input type="checkbox" name="acceptTerms" /> Accept the terms and policies
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- :form -->
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function() {
    $('#defaultForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            country: {
                validators: {
                    notEmpty: {
                        message: 'The country is required and can\'t be empty'
                    }
                }
            },
            acceptTerms: {
                validators: {
                    notEmpty: {
                        message: 'You have to accept the terms and policies'
                    }
                }
            }
        }
    });
});
</script>
</body>
</html>