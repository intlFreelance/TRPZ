function showSidebar(){
  $("#sideNavigation").css('width','280px');
  $("#full-page").css('margin-left','280px');
  $("#full-page-cover").css('display','block');
  $("#full-page-cover").animate({
    left: "280",
    opacity:1,
  }, 0,function(){
  });
}
function hideSide(){
  $("#full-page-cover").css('display','none');
}
function hideSidebar(){
  $("#sideNavigation").css('width','0px');
  $("#full-page").css('margin-left','0px');
  $("#full-page-cover").animate({
    left: "0",
    opacity:0,
  }, 0,function(){
    setTimeout(hideSide,500);
  });
}
function round(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}