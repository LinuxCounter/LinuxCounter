

$(document).ready(function() {

    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });

    //numbering for pre>code blocks
    $(function(){
        $('pre code').each(function(){
            var lines = $(this).text().split('\n').length - 1;
            var $numbering = $('<ul/>').addClass('pre-numbering');
            $(this)
                .addClass('has-numbering')
                .parent()
                .append($numbering);
            for(i=1;i<=lines;i++){
                $numbering.append($('<li/>').text(i));
            }
        });
    });

    if ($('#myCarousel').length >= 1) {
        $('.carousel').carousel({
            interval: 1000 * 10
        });

        $("#myCarousel").swiperight(function () {
            $("#myCarousel").carousel('prev');
        });
        $("#myCarousel").swipeleft(function () {
            $("#myCarousel").carousel('next');
        });
    }

    $( "#question1" ).click(function() {
        $( "#answer1" ).slideToggle( "slow" );
    });
    $( "#question2" ).click(function() {
        $( "#answer2" ).slideToggle( "slow" );
    });
    $( "#question3" ).click(function() {
        $( "#answer3" ).slideToggle( "slow" );
    });
    $( "#question4" ).click(function() {
        $( "#answer4" ).slideToggle( "slow" );
    });
    $( "#question5" ).click(function() {
        $( "#answer5" ).slideToggle( "slow" );
    });
    $( "#question6" ).click(function() {
        $( "#answer6" ).slideToggle( "slow" );
    });

    $( "#apidoc1" ).click(function() {
        $( "#apidoc_desc1" ).slideToggle( "slow" );
    });
    $( "#apidoc2" ).click(function() {
        $( "#apidoc_desc2" ).slideToggle( "slow" );
    });
    $( "#apidoc3" ).click(function() {
        $( "#apidoc_desc3" ).slideToggle( "slow" );
    });
    $( "#apidoc4" ).click(function() {
        $( "#apidoc_desc4" ).slideToggle( "slow" );
    });
    $( "#apidoc5" ).click(function() {
        $( "#apidoc_desc5" ).slideToggle( "slow" );
    });
    $( "#apidoc6" ).click(function() {
        $( "#apidoc_desc6" ).slideToggle( "slow" );
    });
    $( "#apidoc7" ).click(function() {
        $( "#apidoc_desc7" ).slideToggle( "slow" );
    });
    $( "#apidoc8" ).click(function() {
        $( "#apidoc_desc8" ).slideToggle( "slow" );
    });
    $( "#apidoc9" ).click(function() {
        $( "#apidoc_desc9" ).slideToggle( "slow" );
    });
    $( "#apidoc10" ).click(function() {
        $( "#apidoc_desc10" ).slideToggle( "slow" );
    });
    $( "#apidoc11" ).click(function() {
        $( "#apidoc_desc11" ).slideToggle( "slow" );
    });

    $(":checkbox").bootstrapSwitch();

    $("#add_city_button").click(function(){
        $("#myModal").modal('show');
    });

    $("#translate_page_button").click(function(){
        $("#transModal").modal('show');
    });

    $("#arrt").on("click", "#addcity_save", function(e){
        /* e.preventDefault(); */
        /* $("#myModal").modal('hide'); */
    });

    $(".githubissues").click(function(){
        window.location.href = "https://github.com/christinloehner/linuxcounter.new/issues";
    });

    $(".github").click(function(){
        window.location.href = "https://github.com/christinloehner/linuxcounter.new";
    });

    $(".travis").click(function(){
        window.location.href = "https://travis-ci.org/alexloehner/linuxcounter.new";
    });

    $(".versioneye").click(function(){
        window.location.href = "https://www.versioneye.com/user/projects/5509756b4996ebef3300004f";
    });

    $(".coveralls").click(function(){
        window.location.href = "https://coveralls.io/r/alexloehner/linuxcounter.new";
    });

    $(".scrutinzer").click(function(){
        window.location.href = "https://scrutinizer-ci.com/g/alexloehner/linuxcounter.new/?branch=master";
    });

    $(".codeclimate").click(function(){
        window.location.href = "https://codeclimate.com/github/alexloehner/linuxcounter.new";
    });

    $(".license").click(function(){
        window.location.href = "https://github.com/christinloehner/linuxcounter.new/blob/master/LICENSE";
    });

    $(".facebook").click(function(){
        window.location.href = "https://www.facebook.com/linuxcounter";
    });

    $(".twitter").click(function(){
        window.location.href = "https://twitter.com/NewLinuxCounter";
    });

    $(".googleplus").click(function(){
        window.location.href = "https://plus.google.com/u/0/b/110560922503990043085/110560922503990043085/posts";
    });

});

(function() {
    var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
    s.type = 'text/javascript';
    s.async = true;
    s.src = 'https://api.flattr.com/js/0.6/load.js?mode=auto';
    t.parentNode.insertBefore(s, t);
})();
var _qevents = _qevents || [];
(function() {
    var elem = document.createElement('script');
    elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
    elem.async = true;
    elem.type = "text/javascript";
    var scpt = document.getElementsByTagName('script')[0];
    scpt.parentNode.insertBefore(elem, scpt);
})();
_qevents.push({
    qacct:"p-gahRPaNY4dyfq"
});

<!-- Piwik -->
var _paq = _paq || [];
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(function() {
    var u="//piwik.linuxcounter.net/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
})();
<!-- End Piwik Code -->

