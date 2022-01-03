// hero
if ( $("#js-hero-canvas").length ) {
  let granimInstance = new Granim({
    element: '#js-hero-canvas',
    direction: 'left-right',
    isPausedWhenNotInView: true,
    states : {
      "default-state": {
        gradients: [
          ['#19ce0e', '#9be15d'],
          ['#92fe9d', '#00c9ff'],
        ]
      }
    }
  });
}

// アレルギーチェックのslideDown
$("input[name='allergy_check']").change(function(){
  if ( $("#js-allergy-check").prop('checked') ) {
    $("#js-allergy-list").slideDown(200);
  } else {
    $("#js-allergy-list").slideUp(200);
    $("input[type='checkbox']").prop('checked', false);
  }
})

// URLコピー
function copyUrl() {
  const element = document.createElement('input');
  element.value = location.href;
  document.body.appendChild(element);
  element.select();
  document.execCommand('copy');
  document.body.removeChild(element);
  alert("URLをコピーしました!")
}
