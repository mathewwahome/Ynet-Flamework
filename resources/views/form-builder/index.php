<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Drag & Drop Bootstrap Form Builder</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/tether.min.css" />
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/form_builder.css" />
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light  bg-faded fixed-top">
            <div class="clearfix">
                <div class="container">
                    <button style="cursor: pointer;display: none" class="btn btn-info export_html mt-2 pull-right">Export HTML</button>
                    <h3 class="mr-auto">Drag & Drop Bootstrap Form Builder</h3>
                </div>
            </div>
        </nav>
        <br />
        <div class="clearfix"></div>
        <div class="form_builder" style="margin-top: 25px">
            <div class="row">
                <div class="col-sm-2">
                    <nav class="nav-sidebar">
                        <ul class="nav">
                            <li class="form_bal_textfield">
                                <a href="javascript:;">Text Field <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_textarea">
                                <a href="javascript:;">Text Area <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_select">
                                <a href="javascript:;">Select <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_radio">
                                <a href="javascript:;">Radio Button <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_checkbox">
                                <a href="javascript:;">Checkbox <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_email">
                                <a href="javascript:;">Email <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_number">
                                <a href="javascript:;">Number <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_password">
                                <a href="javascript:;">Password <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_date">
                                <a href="javascript:;">Date <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                            <li class="form_bal_button">
                                <a href="javascript:;">Button <i class="fa fa-plus-circle pull-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-5 bal_builder">
                    <div class="form_builder_area"></div>
                </div>
                <div class="col-md-5">
                    <div class="col-md-12">
                        <form class="form-horizontal">
                            <div class="preview"></div>
                            <div style="display: none" class="form-group plain_html"><textarea rows="50" class="form-control"></textarea></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function saveForm() {
    const formData = {
        name: document.getElementById('formName')?.value || 'Untitled Form',
        tableName: document.getElementById('tableName')?.value || 'custom_table',
        fields: []
    };

    document.querySelectorAll('.form_builder_area .form-group').forEach(component => {
        const input = component.querySelector('input, textarea, select');
        if (input) {
            formData.fields.push({
                type: input.type || 'text',
                name: input.name || input.id || `field_${formData.fields.length + 1}`,
                label: component.querySelector('label')?.textContent.trim() || 'Untitled Field',
                required: input.hasAttribute('required')
            });
        }
    });

    fetch('/form-builder/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Form saved successfully!');
        } else {
            alert('Error: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Error saving form: ' + error.message);
    });
}

    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/form_builder.js"></script>
</body>

</html>