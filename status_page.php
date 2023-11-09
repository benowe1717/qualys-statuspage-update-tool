<!DOCTYPE html>
<html data-bs-theme="dark" lang="en" data-bss-forced-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Status Page Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    <script src="/assets/js/reset_form.js"></script>
    <script src="/assets/js/form_data.js"></script>
    <script src="/assets/js/clipboard.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-md bg-body py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg>
                </span>
                <span>Qualys</span>
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="/mer_templates.php">MER Templates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/status_page.php">Status Page</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" role="tab" data-bs-toggle="tab" href="#tab-1">Incident Update</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" role="tab" data-bs-toggle="tab" href="#tab-2">Scheduled Maintenance Update</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <form id="incident" action="">
                        <div class="mb-3">
                            <label class="form-label">Platform</label>
                            <select class="form-select" required="" id="incident-platform">
                                <option value="" selected="">Select...</option>
                                <?php
                                    require __DIR__ . "/scripts/platforms.php";
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input class="form-control" type="text" required="" minlength="3" id="incident-title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" required="" id="incident-message"></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control visually-hidden" readonly id="incident-copy"></textarea>
                        </div>
                        <div class="btn-group border rounded-pill" role="group">
                            <button class="btn btn-primary border-light" type="button" onclick='get_incident_title();'>Generate Title</button>
                            <button class="btn btn-primary border-light" type="button" onclick='get_incident_message();'>Generate Message</button>
                            <button class="btn btn-primary border-light" type="button" onclick='reset_form("#incident");'>Reset Form</button>
                        </div>
                    </form>
                    <div class="row m-3">
                        <div class="col-12">
                            <div class="alert" role="alert" id="incident-alert">
                                <span id="incident-alert-text"></span>
                            </div>
                            <button class="btn btn-primary visually-hidden" type="button" data-clipboard-target="#incident-copy" data-clipboard-action="copy" id="incident-copy-button">Copy to Clipboard</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <form id="maintenance">
                        <div class="mb-3">
                            <label class="form-label">Platform</label>
                            <select class="form-select" required="" id="maintenance-platform">
                                <option value="" selected="">Select...</option>
                                <?php
                                    require __DIR__ . "/scripts/platforms.php";
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input class="form-control" type="text" required="" minlength="3" id="maintenance-title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ticket Number</label>
                            <input class="form-control" type="text" required="" minlength="3" pattern="^[A-Z]{3}-[0-9]+$" id="maintenance-ticket">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" required="" id="maintenance-message"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reference Link</label>
                            <input class="form-control" type="text" required="" inputmode="url" pattern="^(http|https):.{3,}" id="maintenance-ref-link">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control visually-hidden" readonly id="maintenance-copy"></textarea>
                        </div>
                        <div class="btn-group border rounded-pill" role="group">
                            <button class="btn btn-primary border-light" type="button" onclick='get_maintenance_title();'>Generate Title</button>
                            <button class="btn btn-primary border-light" type="button" onclick='get_maintenance_details();'>Generate Message</button>
                            <button class="btn btn-primary border-light" type="button" onclick='reset_form("#maintenance");'>Reset Form</button>
                        </div>
                    </form>
                    <div class="row m-3">
                        <div class="col-12">
                            <div class="alert" role="alert" id="maintenance-alert">
                                <span id="maintenance-alert-text"></span>
                            </div>
                            <button class="btn btn-primary visually-hidden" type="button" data-clipboard-target="#maintenance-copy" data-clipboard-action="copy" id="maintenance-copy-button">Copy to Clipboard</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>