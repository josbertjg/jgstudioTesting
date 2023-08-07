async function addMenuStyles(img){
    $("nav").addClass("menuStyled");
    $(`nav .navbar-brand img`).attr("src",img);
}
async function removeMenuStyles(img){
    $("nav").removeClass("menuStyled");
    $("nav .navbar-brand img").attr("src",img);
}