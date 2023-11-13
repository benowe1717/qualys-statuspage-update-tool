<!DOCTYPE html>
<html data-bs-theme="light" lang="en" style="--bs-body-color: #1D2737;--bs-body-bg: #F7FAFC;--bs-primary: #2E8BE0;--bs-primary-rgb: 46,139,224;--bs-danger: #ED2E26;--bs-danger-rgb: 237,46,38;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Status Page Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css">
    <link rel="stylesheet" href="/assets/css/montserrat-font.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    <script src="/assets/js/reset_form.js"></script>
    <!-- <script src="/assets/js/form_data.js"></script> -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/incident_title.js"></script>
    <script src="/assets/js/clipboard.js"></script>
</head>

<body style="font-family: 'Montserrat';">
    <nav class="navbar navbar-expand-md py-3" style="--bs-body-bg: #f4f6f8;--bs-body-color: #262626;background-color: var(--bs-body-bg);color: #262626;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <span class="bs-icon-sm d-flex justify-content-center align-items-center me-2 bs-icon">
                    <img class="img-fluid" src="/assets/img/Shield-Medium.png">
                </span>
                <span>Support Tools</span>
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
    <div class="container m-3">
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
                            <label class="form-label" for="incident-platform">Platform</label>
                            <select class="form-select" required="" id="incident-platform" name="incident-platform">
                                <option value="" selected="">Select...</option>
                                <?php
                                    require __DIR__ . "/scripts/platforms.php";
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="incident-title">Title</label>
                            <input class="form-control" type="text" required="" minlength="3" id="incident-title" name="incident-title" placeholder="QualysGuard UI is not accessible (IM-11285)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="incident-message">Message</label>
                            <textarea class="form-control" required="" id="incident-message" name="incident-message" placeholder="Users are unable to access QualysGuard for KSA Platform 1. Cloud Platform Operations team is actively investigating and further updates will be shared as they are received."></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control visually-hidden" readonly id="incident-copy"></textarea>
                        </div>
                        <div class="btn-group border rounded-pill" role="group">
                            <button class="btn border-light" type="button" id="incident-title-button">Generate Title</button>
                            <button class="btn border-light" type="button" onclick='get_incident_message();'>Generate Message</button>
                            <button class="btn btn-reset border-light" type="button" onclick='reset_form("#incident");'>Reset Form</button>
                        </div>
                    </form>
                    <div class="row m-3">
                        <div class="col-12">
                            <div class="alert" role="alert" id="incident-alert">
                                <span id="incident-alert-text"></span>
                            </div>
                            <button class="btn visually-hidden" type="button" data-clipboard-target="#incident-copy" data-clipboard-action="copy" id="incident-copy-button">Copy to Clipboard</button>
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
                            <input class="form-control" type="text" required="" minlength="3" id="maintenance-title" placeholder="File Integrity Monitoring (FIM) 3.8.0.0 Release Notification (CMB-215218)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ticket Number</label>
                            <input class="form-control" type="text" required="" minlength="3" pattern="^[A-Z]{3}-[0-9]+$" id="maintenance-ticket" placeholder="CMB-215218">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" required="" id="maintenance-message" placeholder="A new release of File Integrity Monitoring 3.8.0.0 (FIM) is going to be released into production. The deployment is completely transparent to users, and no impact is expected."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reference Link</label>
                            <input class="form-control" type="text" required="" inputmode="url" pattern="^(http|https):.{3,}" id="maintenance-ref-link" placeholder="https://www.qualys.com/docs/release-notes/qualys-file-integrity-monitoring-3.8-release-notes.pdf">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control visually-hidden" readonly id="maintenance-copy"></textarea>
                        </div>
                        <div class="btn-group border rounded-pill" role="group">
                            <button class="btn border-light" type="button" onclick='get_maintenance_title();'>Generate Title</button>
                            <button class="btn border-light" type="button" onclick='get_maintenance_details();'>Generate Message</button>
                            <button class="btn btn-reset border-light" type="button" onclick='reset_form("#maintenance");'>Reset Form</button>
                        </div>
                    </form>
                    <div class="row m-3">
                        <div class="col-12">
                            <div class="alert" role="alert" id="maintenance-alert">
                                <span id="maintenance-alert-text"></span>
                            </div>
                            <button class="btn visually-hidden" type="button" data-clipboard-target="#maintenance-copy" data-clipboard-action="copy" id="maintenance-copy-button">Copy to Clipboard</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>