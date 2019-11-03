<!DOCTYPE html>

<html lang="en" class="smart-style-0">
<head>
    <title>{# pageTitle #}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />

    {% if config.site.DEBUG %}
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/vendors.bundle.css">
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/app.bundle.css">
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/wizard.css">
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/forms.css">
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/daterangepicker.css">

        <link rel="stylesheet" href="/assets_dev/css/main.css">
    {% else %}
        <link rel="stylesheet" href="/assets/css/main.min.css">
    {% endif %}

    {% if config.site.DEBUG %}
        <script
                data-controller="{{ router.getControllerName() }}" data-action="{{ router.getActionName() }}"
                data-main="/assets_dev/js/main" src="/assets_dev/js/require.js"></script>
    {% else %}
        <script
                data-controller="{{ router.getControllerName() }}" data-action="{{ router.getActionName() }}"
                data-main="/assets/js/build" src="/assets/js/require.js"></script>
    {% endif %}

</head>
<body class="smart-style-0">

<div class="sa-wrapper">
    <div class="sa-page-body">
        <div class="sa-content-wrapper">
            {{ flash.output() }}

            {% block content %}{% endblock %}
        </div>
    </div>

</div>

</body>
</html>