(function() {

    $(document).ready(function() {


        $('.disabled_link').click(function(event) {
            event.preventDefault();
        });
    });

    document.loadScript = function(src) {

    };
})();

function loadCSS(e) {
    var f = document.createElement("link");
    f.setAttribute("rel", "stylesheet");
    f.setAttribute("type", "text/css");
    f.setAttribute("href", e);
    document.getElementsByTagName("head")[0].appendChild(f);
}
function loadScriptsSync(e) {
    var t = [];
    var n = 0;
    var r = function(e, t) {
        loadScript(e[n], t[n], function() {
            n++;
            if (n < e.length) {
                r(e, t)
            }
        })
    };
    r(e, t)
}
function loadScript(e, t, n) {
    t = document.createElement("script");
    t.onload = function() {
        n()
    };
    t.src = e;
    document.getElementsByTagName("head")[0].appendChild(t)
}