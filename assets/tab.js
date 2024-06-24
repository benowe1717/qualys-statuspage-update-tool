if (window.location.hash == '#incident-tab') {
    var id = document.querySelector('#incident-tab');
    var tab = new bootstrap.Tab(id);
    tab.show();
} else if (window.location.hash == '#maintenance-tab') {
    var id = document.querySelector('#maintenance-tab');
    var tab = new bootstrap.Tab(id);
    tab.show();
}
