<!DOCTYPE html>
<html data-bs-theme="dark" lang="en" data-bss-forced-theme="dark">

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
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Status Page Update Tool</h2>
                <h3 class="text-center">Patch Notes</h3>
            </div>
        </div>
    </div>
    <div class="container m-3">
        <div class="row">
            <div class="col-md-6">
                <h4>Current Version: <?php require_once __DIR__ . "/scripts/get_current_version.php"; ?></h4>
                <ul class="list-group">
                    <li class="list-group-item">Added an Incident Update feature</li>
                    <li class="list-group-item">Added a Scheduled Maintenance feature</li>
                    <li class="list-group-item">Added a "Copy to Clipboard!" button</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h4>Known Issues: </h4>
                <ul class="list-group"></ul>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>