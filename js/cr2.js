$(function(){
//Change of styles
$("h2").css("color", "#314593");
$(".btn-primary, .badge-success, .btn-success").css({"color": "cyan", "background-color": "#314593"});
$(".badge").css("line-height","2");
$("img:not(.imgs)").animate({"width" : "-=30"}, "slow");


init(); //Functions at init
});

function init() {
submf ();
framh (); 
imgh (); 
}

    //Forms
function submf () {
//Submits the form inmediately after change
$('.csubm').change(function(){
            $('#forms').submit();
            });
        }    

function framh() {
//Changes framed-box when hover
$(".framed-box").hover(
    function () {
    //$(this).animate ({ "font-size" : "110%" }, "fast" ); 
        $(this).css ("font-size",  "110%"); }, 
    function () {
       $(this).css ("font-size",  "105%"); } ); 
}

function imgh() {
    $("img:not(.imgs)").hover(
    function () { //Increases image size when hover
       $(this).css ("width",  "+=30"); }, 
    function () {
       $(this).css ("width",  "-=30"); } );
    }