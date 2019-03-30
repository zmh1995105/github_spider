<!DOCTYPE html>
<html>
	<title>Pwned by Monkey B Luffy</title>
<META NAME="description" CONTENT="Pwned by Monkey B Luffy"> 
<META NAME="keywords" CONTENT="Monkey B Luffy"> 
<META NAME="robot" CONTENT="index,follow"> 
<META NAME="copyright" CONTENT="Copyright. All Rights Reserved."> 
<META NAME="author" CONTENT="Pwned by Monkey B Luffy"> 
<META NAME="language" CONTENT="English"> 
<META NAME="revisit-after" CONTENT="1">
<link href="http://cdn.wallpapersafari.com/31/90/JO6HyU.png" rel="SHORTCUT ICON"/>
<head>
<style type="text/css" media="all">
@import 'https://fonts.googleapis.com/css?family=Orbitron';
html {
	text-align: center;
	font-size: 15px;
	background: black;
	width: 100%;
	height: 100%;
	display: block;
	color: lime;

}

h1 {
	font-size: 50px;
}
.shine
{
    background: #222 -webkit-gradient(linear, left top, right top, from(#222), to(#222), color-stop(0.5, #fff)) 0 0 no-repeat;
    -webkit-background-size: 100px;
    
    color: rgba(255, 255, 255, 0.1);
    -webkit-background-clip: text;
    
    -webkit-animation-name: shine;
    -webkit-animation-duration: 3s;
    -webkit-animation-iteration-count: infinite;
}

@-webkit-keyframes shine
{
    50% { background-position: top left; }
    50% { background-position: top right; }
}
p.kaki {
	font-size: 15px;
	color: lime;
}	

@mixin textGlitch($name, $intensity, $textColor, $background, $highlightColor1, $highlightColor2, $width, $height) {
  
  color: $textColor;
  position: relative;
  $steps: $intensity;
  
  // Ensure the @keyframes are generated at the root level
  @at-root {
    // We need two different ones
    @for $i from 1 through 2 {
      @keyframes #{$name}-anim-#{$i} {
        @for $i from 0 through $steps {
          #{percentage($i*(1/$steps))} {
            clip: rect(
              random($height)+px,
              $width+px,
              random($height)+px,
              0
            );
          }
        }
      }
    }
  }
  &:before,
  &:after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    background: $background;
    clip: rect(0, 0, 0, 0); 
  }
  &:after {
    left: 2px;
    text-shadow: -1px 0 $highlightColor1;
    animation: #{$name}-anim-1 2s infinite linear alternate-reverse;
  }
  &:before {
    left: -2px;
    text-shadow: 2px 0 $highlightColor2; 
    animation: #{$name}-anim-2 3s infinite linear alternate-reverse;
  }
  
}
.content {
	color: #62C85B;
	font-family: 'Orbitron', sans-serif;
	font-size: 30px;
	font-weight: bold;
  @include textGlitch("glitch", 17, #61F5A1, black, red, blue, 1084, 115);
}
</style>

<h1 class="shine">Got Pwned....???</h1>
<img src="https://lh3.googleusercontent.com/proxy/0Lkkur7ke6KpwsoT2Y93hwqQQf4FEedpcqbxBk6rMAq7VQ-TBZxmL3DICdrsG9swhzDGvX9huMSOXoUWeiUQgaMw=w530-h297-p"><br>
<br><div class="content" data-text="A Digital Frontier">Monkey B Luffy - BerdendangC0de</div>
<br>WE ARE : <marquee width="500">Ccocot - ./Mr.greetz69 - Kazuya404 - ACE666X - Jilan404 - Effect - B0c4H_Id30t - Ashura - Fuss - Sector.V2 - Badc0de</marquee>
</head>
</html>
