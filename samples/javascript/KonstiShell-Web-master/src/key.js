curserPos = 1;
function keyHandler(e) {
  //console.log(e.keyCode);
  if (e.ctrlKey && e.keyCode == 83 /*S*/ || e.ctrlKey && e.keyCode == 85 /*U*/ || e.ctrlKey && e.keyCode == 73 /*I*/ || e.keyCode == 123 /*F12*/) {
    e.preventDefault();
  } else if (e.ctrlKey && e.keyCode == 68 /*D*/) {
    e.preventDefault();
    $$id('prompt-in-val').value = "logout"; cli.input.collect(e)
  } else if (e.keyCode == 38 /*Up*/) {
    e.preventDefault();
    if (curserPos > 0 && curserPos < command_history.length+1) {
      curserPos -= 1;
      $$id('prompt-in-val').value =command_history[curserPos];
    }
  } else if (e.keyCode == 40 /*Down*/) {
    e.preventDefault();
    if (curserPos < command_history.length-1) {
      curserPos += 1;
      $$id('prompt-in-val').value =command_history[curserPos];
    }
  }
}

document.addEventListener('keydown', keyHandler, false);
document.addEventListener('contextmenu', event => event.preventDefault());
