//this code will enable the correct elements in your nav based on their ids, which you defined within the nav-config;
// you can use that as your base and swap out classes or even the entire thing.

let currentPath = window.location.pathname;

var pathParts = currentPath.split('/');

$('.sidebar').find('a').removeClass("active");
$('.sidebar').find('a').parent().removeClass("menu-open");
let buildPath = "";
pathParts.forEach(function (tilePath, index) {
    if (tilePath != "") {
        buildPath += ("_" + tilePath);
        $('#' + buildPath + "_").addClass('active');
        $('#' + buildPath + "_").parent().addClass("menu-open");
    }
});

buildPath += "_";

console.log( buildPath);

$('#' + buildPath).addClass('active');
$('#' + buildPath).parent().addClass("menu-open");