<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
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
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/bootstrap-multiselect.css">
        <link rel="stylesheet" media="screen, print" href="/assets_dev/css/cropper.css">

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
    <div id="loading">
        <img id="loading-image" src="/img/loading.gif" alt="{{ t._('loading') }}..." />
    </div>

    {% if auth %}
        {% include 'layouts/header.volt' %}
    {% endif %}

    <div class="sa-page-body">
        {% block left %}{% endblock %}

        <div class="sa-content-wrapper">
            <div class="sa-content">
                {% include 'layouts/breadcrumbs.volt' %}

                {{ flash.output() }}

                {% block content %}{% endblock %}
            </div>
        </div>
    </div>

    {% include "template/window/alert.volt" %}
    {% include "template/window/confirm.volt" %}
    {% include "template/window/prompt.volt" %}
    {% include "template/notify.volt" %}
</body>
</html>
