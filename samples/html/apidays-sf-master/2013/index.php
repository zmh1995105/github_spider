<!doctype html>
<!--[if IE 6]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if (gt IE 6)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title>APIdays San Francisco, 21-22 June 2013</title>
	<meta name="description" content="Apidays">
	<meta name="author" content="">
	<meta name="viewport" content="user-scalable=yes, width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="keywords" content="" />

	<meta property="og:title" content="APIdays San Francisco, 21-22 June 2013" />
	<meta property="og:image" content="http://sf.apidays.io/images/logo_apiday.png"/>

	<meta name="copyright" content="Apidays" />
	<meta name="robots" content = "all" />
	<meta name="robots" content = "index, follow" />
	<meta name="revisit-after" content="30 days" />
	<meta name="audience" content="all" />
	<!-- favicon 16x16 -->
	<link rel="shortcut icon" href="apidays_fav.ico">
	<!-- apple touch icon 57x57 -->
	<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700,300,200' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/styles.css?v=1.0">
	<link href="css/fonz.css" type="text/css" rel="stylesheet"></style>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://api.webshell.io/sdk/js?key=6f625a03162816120b70a4a63585c871"></script>
	<script type="text/javascript">
	$('document').ready(function() {
		wsh.exec({
			code: function() {
				var m = apis.google.maps();
				m.center('PARISOMA, 169 11th Street, San Francisco, CA');
				m.zoom(15);
				m.addMarker({address: 'PARISOMA, 169 11th Street, San Francisco, CA', icon: '', title: 'PARISOMA'});
			},
			process: function(data,meta) {
				$('#gmaps').html(meta.view);
			}
		})
	})
	</script>
	<!-- Remove the script reference below if you're using Modernizr -->
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


</head>

<body>

	<canvas id="draw" width="100%" height="100%" resize="true"></canvas>
	<div id="wrapper">

		<header>
			<div class="inside">
				<nav class="navigation">
					<ul class="nav_p" id="nav">
						<li data-color="#e6e6e6" class="current"><a href="#home">home</a></li>
						<li data-color="#e6e6e6"><a href="#speakers">SPEAKERS</a></li>
						<li data-color="#e6e6e6"><a href="#program">PROGRAM</a></li>
						<li data-color="#fff"><a href="#partners">SPONSORS &amp; MEDIA</a></li>
						<li data-color="#fff"><a href="#organizers">ORGANIZERS</a></li>
						<li data-color="#fff"><a href="#pratical">PRACTICAL DETAILS</a></li>
					</ul>
					<div class="clear"></div>
				</nav>
			</div><!-- fin inside -->
		</header>


		<div class="main_container">

			<section class="section home" id="home">
				<div class="inside fil">

					<div class="sleft">
						<img src="images/logo_apiday.png" alt="Api Day" class="logo" />

						<div class="socials">
							<br/>
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://sf.apidays.io" data-via="apidays2013" data-related="apidays2013">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
							<script type="IN/Share" data-url="http://sf.apidays.io" data-counter="right"></script>
							<br/><br/>
							<div class="fb-like" data-send="false" data-href="http://sf.apidays.io" data-layout="button_count" data-width="450" data-show-faces="false"></div>

						</div><!-- fin socials -->
						
						<div class="sponsors-logo">
							<span class="powered" style="margin-bottom:5px">Powered by</span>
							<img src="images/sponsors/layer7.png" alt="layer 7" title="layer 7" />
							<img src="images/dot.png" class="dot" alt="dot" />
							<img src="images/sponsors/intel.png" alt="intel" title="intel" />
							<img src="images/dot.png" class="dot" alt="dot" />
							<img src="images/sponsors/3scale.png" alt="3scale" title="3scale" />
							<img src="images/dot.png" class="dot" alt="dot" />														
							<img src="images/sponsors/SOA.png" alt="SOA Software" title="SOA Software" />
							<img src="images/dot.png" class="dot" alt="dot" />														
							<img src="images/sponsors/apiphany.png" alt="Apiphany" title="Apiphany" />
							<img src="images/dot.png" class="dot" alt="dot" />														
							<img src="images/sponsors/MuleSoft.png" alt="MuleSoft" title="MuleSoft" />
							<img src="images/dot.png" class="dot" alt="dot" />
							<img src="images/sponsors/APISpark.png" alt="APISpark" title="APISpark" />
						</div>

					</div><!-- fin sleft -->

					<div class="main">
						<div class="pad">
							<h1>
								<span class="be">API economy</span>
								<span class="te">The Giant has awakened.</span></h1>
							</div><!-- fin content -->

							<div class="hr"></div>

							<div class="pad">
								<h2>JUNE 21<span style="text-transform:none;display: inline;
								font-weight: inherit;
								color: inherit;">st</span>, 2013 > JUNE 22<span style="text-transform:none;display:inline;font-weight: inherit;color: inherit;">nd</span>, 2013  - Conference, <a href="http://www.parisoma.com" target="_blank">Parisoma</a><br>
									JUNE 23<span style="text-transform:none;display:inline;font-weight: inherit;								color: inherit;">rd</span> - API HackDay, <a href="http://www.parisoma.com" target="_blank">Parisoma</a>
								</div><!-- fin pad -->

								<div class="hr"></div>


								<div class="pad">
									
									<p style="font-size: 21px;line-height:25px">
									Thank you so much to everyone who helped make APIdays SF such a huge success. We had an amazing time, learned so much and had some awesome street food. Hope to see you next year, or perhaps in <a href="http://signup.apidays.io/" alt="APIDAYS Paris" target="_blank">Paris</a>!	
									</p>

									<div style="width:450px;margin:0 auto">

									<iframe src="http://player.vimeo.com/video/69561628" width="450" height="285" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>	
									<p style="margin-bottom:10px"><a href="http://www.youtube.com/user/apidays" alt="APIdays videos" target="_blank">See videos</a></p>
									
									<!-- <p><a href="" alt="APIdays videos">See more videos</a></p> -->

									</div>
									<br>

									<div style="width:450px;margin:0 auto">
										<a href="https://www.facebook.com/media/set/?set=a.10151437669287382.1073741827.274633977381&type=1&l=5430f83402" alt="APIdays photos"><img src="images/apidays_sf_group.jpg" alt="APIdays group" width="450"/></a>
										<p><a href="https://www.facebook.com/media/set/?set=a.10151437669287382.1073741827.274633977381&type=1&l=5430f83402" alt="APIdays photos" target="_blank">See more photos</a></p>
									
									
									</div>
									<div class="hr" style="margin-bottom:15px"></div>
									
									
									<p>With every year that passes more APIs are being published and integrated into the apps, websites, and online services we use every day. The promise of the programmable web is coming true.</p>

									<p>Just in the last few months, the API landscape has seen numerous <a href="http://techcrunch.com/2013/04/28/facebook-and-the-sudden-wake-up-about-the-api-economy/" take="_blank">acquistions</a> and investments, proving that the API ecosystem is as relevant and <a href="http://www.forbes.com/sites/reuvencohen/2013/04/29/with-recent-intel-and-ca-acquisitions-the-cloud-api-market-is-on-fire/" take="_blank">exciting as ever.</a></p>

									<p>APIdays San Francisco will gather thought and business leaders from the API community for a dialogue on the future of the programmable web, with the goal of understanding why APIs are growing from a multi-million to a multi-billion dollar market opportunity, and how we can take advantage of this movement.</p>

									<p>The main discussions will be around : <br>- How to scale API management, promotion and integration in an exponential growing market?<br>
										- How to make interfaces and design patterns that scale for global integration and automation?</p>

									<p>The APIdays conference will take place June 21-22 at PARISOMA in San Francisco. The conference will be followed by APIhackday on the 23rd.</p>

									<p class="p2">"Never in the face of digital revolution has so much been owed by so many to so few"</p>


								</div><!-- fin pad -->


							</div><!-- fin main -->
							<div class="clear"></div>
						</div><!-- fin inside -->
					</section><!-- fin section -->

<?php if (1) {?>
	<section class="section speakers" id="speakers">
		<div class="inside fil">
			<div class="pleft">
				<img src="images/ico_section_speakers.png" alt="Speakers"  class="ico"/>
			</div><!-- fin pleft -->
			<div class="main">
				<h2 class="rub ico_proud">APIdays is proud and thankful to welcome a huge panel of international<br />experts of the API world </h2>

			</div><!-- fin main -->
			<div class="clear"></div>

			<div class="list_speaker">

				<ul>
					<li><img src="images/speakers/speaker_KinLane.jpeg" alt="Kin Lane" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/kinlane'><span class="colr">Kin Lane</span></a></h4>
							<span class="job">API evangelist</span>
							<span class="society">API evangelist</span>
						</div>
					</li>
					<li><img src="images/speakers/John_Sheehan.jpg" alt="John Sheehan" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/johnsheehan'><span class="colr">John Sheehan</span></a></h4>
							<span class="job">CEO</span>
							<span class="society">Runscope</span>
						</div>
					</li>
					<li><img src="images/speakers/Adam_Duvander.jpg" alt="Adam Duvander" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='https://twitter.com/adamd'><span class="colr">Adam Duvander</span></a></h4>
									<span class="job">Developer Communications Dir.</span>
									<span class="society">SendGrid</span>
								</div>
					</li>
					<li><img src="images/speakers/speaker_mike_layer7.jpeg" alt="Mike Amundsen" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/mamund'><span class="colr">Mike Amundsen</span></a></h4>
							<span class="job">Principal API Architect</span>
							<span class="society">Layer 7</span>
						</div>
					</li>
					<li><img src="images/speakers/Daniel_Jacobson.jpg" alt="Daniel Jacobson" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/daniel_jacobson'><span class="colr">Daniel Jacobson</span></a></h4>
							<span class="job">Director of Engineering</span>
							<span class="society">Netflix</span>
						</div>
					</li>
					<li><img src="images/speakers/Alex_Williams.jpg" alt="Alex Williams" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='https://twitter.com/alexwilliams'><span class="colr">Alex Williams</span></a></h4>
									<span class="job">Enterprise Writer</span>
									<span class="society">TechCrunch</span>
								</div>
					</li>
					<li><img src="images/speakers/Blake_Dournaee.jpg" alt="Blake Dournaee" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/dournaee'><span class="colr">Blake Dournaee</span></a></h4>
							<span class="job">Sr Product Manager</span>
							<span class="society">INTEL</span>
						</div>
					</li>
					<li><img src="images/speakers/Ed_Anuff.jpg" alt="Ed Anuff" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='https://twitter.com/edanuff'><span class="colr">Ed Anuff</span></a></h4>
							<span class="job">VP, Mobile & Dev. Technologies</span>
							<span class="society">apigee</span>
						</div>
					</li>	
					<li><img src="images/speakers/Solomon_Hykes.jpg" alt="Solomon Hykes" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/solomonstre'><span class="colr">Solomon Hykes</span></a></h4>
							<span class="job">CEO</span>
							<span class="society">DotCloud</span>
						</div>
					</li>
					<li><img src="images/speakers/Amber_Feng.jpg" alt="Amber Feng" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/amfeng'><span class="colr">Amber Feng</span></a></h4>
							<span class="job">Software Engineer</span>
							<span class="society">Stripe</span>
						</div>
					</li>
								
					<li><img src="images/speakers/Chris_Ismael.jpg" alt="Chris Ismael" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/craftshape'><span class="colr">Chris Ismael</span></a></h4>
							<span class="job">Developer Evangelist</span>
							<span class="society">Mashape</span>
						</div>
					</li>
					<li><img src="images/speakers/Neil_Mansilla.jpg" alt="Neil Mansilla" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/mansillaDEV'><span class="colr">Neil Mansilla</span></a></h4>
							<span class="job">Director of Developer Products</span>
							<span class="society">Mashery</span>
						</div>
					</li>
					<li><img src="images/speakers/Steve_Wilmott.jpg" alt="Steven Wilmott" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/njyx'><span class="colr">Steven Wilmott</span></a></h4>
							<span class="job">CEO</span>
							<span class="society">3Scale</span>
						</div>
					</li>
					<li><img src="images/speakers/Bryan_Helmig.jpg" alt="Bryan Helmig" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/bryanhelmig'><span class="colr">Bryan Helmig</span></a></h4>
							<span class="job">Co-Founder</span>
							<span class="society">Zapier</span>
						</div>
					</li>
					<li><img src="images/speakers/Jerome_Louvel.jpg" alt="Jerome Louvel" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/jlouvel'><span class="colr">Jerome Louvel</span></a></h4>
							<span class="job">Creator</span>
							<span class="society">APISpark</span>
						</div>
					</li>
					<li><img src="images/speakers/Simon_Murtha-Smith.jpg" alt="Simon Murtha-Smith" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/smurthas'><span class="colr">Simon Murtha-Smith</span></a></h4>
							<span class="job">Co-founder</span>
							<span class="society">Singly</span>
						</div>
					</li>
					<li><img src="images/speakers/speaker_SWIFT.jpg" alt="Swift" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/SwiftAlphaOne'><span class="colr">Swift</span></a></h4>
							<span class="job">Developer Evangelist</span>
							<span class="society">SendGrid</span>
						</div>
					</li>
					<li><img src="images/speakers/Robert_Duffner.jpg" alt="Robert Duffner" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/rduffner'><span class="colr">Robert Duffner</span></a></h4>
							<span class="job">Dir. of Platform Go-to-Market</span>
							<span class="society">SalesForce / APIeconomist</span>
						</div>
					</li>
					<li><img src="images/speakers/Sachin_Agarwal.jpg" alt="Sachin Agarwal" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://twitter.com/SOASoftwareInc'><span class="colr">Sachin Agarwal</span></a></h4>
							<span class="job">VP Product Management</span>
							<span class="society">SOA Software</span>
						</div>
					</li>
					<li><img src="images/speakers/speaker_jakub-nesetril_Apiary.jpeg" alt="Jakub Nesetril" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='http://www.linkedin.com/profile/view?id=4492193'><span class="colr">Jakub Nesetril</span></a></h4>
									<span class="job">Founder</span>
									<span class="society">apiary.io</span>
								</div>
					</li>
					<li><img src="images/speakers/Adam_Daugelli.jpg" alt="Adam D’Augelli" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='https://twitter.com/adaugelli'><span class="colr">Adam D’Augelli</span></a></h4>
									<span class="job">VC</span>
									<span class="society">True Ventures</span>
								</div>
					</li>	
					<li><img src="images/speakers/Ethan_Kurzweil.jpg" alt="Ethan Kurzweil" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='https://twitter.com/ethankurz'><span class="colr">Ethan Kurzweil</span></a></h4>
									<span class="job">VC</span>
									<span class="society">Bessemer Venture Partners </span>
								</div>
					</li>
					<li><img src="images/speakers/Jeremiah_Lee.jpg" alt="Jeremiah Lee" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://jeremiahlee.com/'><span class="colr">Jeremiah Lee</span></a></h4>
							<span class="job">API Engineer</span>
							<span class="society">Fitbit</span>
						</div>
					</li>	
					<li><img src="images/speakers/Thomas_Grassl.jpg" alt="Thomas Grassl" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='https://twitter.com/grassl'><span class="colr">Thomas Grassl</span></a></h4>
							<span class="job">Developer relations</span>
							<span class="society">SAP</span>
						</div>
					</li>
					<li><img src="images/speakers/Sumit_Sharma.jpg" alt="Sumit Sharma" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://www.linkedin.com/in/sumitcan'><span class="colr">Sumit Sharma</span></a></h4>
							<span class="job">Director, API Solutions</span>
							<span class="society">MuleSoft</span>
						</div>
					</li>		
					<li><img src="images/speakers/Mike_Maney.jpg" alt="Mike Maney" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='https://twitter.com/the_spinmd'><span class="colr">Mike Maney</span></a></h4>
							<span class="job">Founder</span>
							<span class="society">maney:digital</span>
						</div>
					</li>	
					<li><img src="images/speakers/Evgeny_Popov.jpg" alt="Evgeny Popov" />
						<div class="desc">
							<h4 class="name"><a target='_blank' href='http://www.linkedin.com/pub/evgeny-popov/b/496/a28'><span class="colr">Evgeny Popov</span></a></h4>
							<span class="job">CEO</span>
							<span class="society">APIphany</span>
						</div>
					</li>					
					<li><img src="images/speakers/speaker_mehdi_medjaoui.jpeg" alt="Mehdi Medjaoui" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='http://twitter.com/Webshell_'><span class="colr">Mehdi Medjaoui</span></a></h4>
									<span class="job">CEO</span>
									<span class="society">WEBSHELL</span>
								</div>
					</li>	
					<li><img src="images/speakers/Guillaume_CB.jpg" alt="Guillaume CHARNY-BRUNET" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='http://www.linkedin.com/in/guillaumecb'><span class="colr" style="font-size:19px">Guillaume CHARNY-BRUNET</span></a></h4>
									<span class="job">VP Innovation Services</span>
									<span class="society">faberNovel</span>
								</div>
					</li>		
					<li><img src="images/speakers/Tony_Tam.jpg" alt="Tony Tam" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='https://twitter.com/fehguy'><span class="colr">Tony Tam</span></a></h4>
									<span class="job">CEO</span>
									<span class="society">Reverb</span>
								</div>
					</li>
					<li><img src="images/speakers/Greg_Gopman.jpg" alt="Gregory Gopman" />
								<div class="desc">
									<h4 class="name"><a target='_blank' href='https://twitter.com/GGopman'><span class="colr">Gregory Gopman</span></a></h4>
									<span class="job">Founder</span>
									<span class="society">AngelHack</span>
								</div>
					</li>																													
<!-- 					<div id="more">
						<span class="colr">More to come</span>
					</div> -->
</ul>

<div class="clear"></div>
</div><!-- fin speaker -->
<div class="clear"></div>


</div><!-- fin inside -->


</section><!-- fin section -->
<?php } ?>


					<?php if (1) {
						?>

						<section class="section program" id="program">
							<div class="inside fil">
								<div class="pleft">
									<img src="images/ico_section_program.png" alt=""  class="ico"/>
								</div><!-- fin pleft -->
								<div class="main">
<div id="day1">

									<h2 class="rub ico_program" style="font-variant:small-caps">FRIDAY EVENING: UNLEASH THE KRAKEN</h2>

									<div class="pad">
										<ul>
											<li>
												<span class="date">6PM</span>
												Doors open
											</li>
											<li>
												<span class="date">6.30PM: </span>
												Introduction and Welcome. <span class="colr">Guillaume Charny-Brunet</span> / faberNovel and <span class="colr">Mehdi Medjaoui</span> / Webshell
											</li>
											<li>
												<span class="date">7PM: </span>
												How Open is Your API Future? <span class="colr">Adam Duvander</span> / SendGrid
											</li>
											<li>
												<span class="date">7.25PM: </span>
												Modern Tools for Modern Applications. <span class="colr">John Sheehan</span> / Runscope
											</li>
											<li>
												<span class="date">7.50PM: </span>
												Scaling the API Economy with Scale-Free Networks. <span class="colr">Mike Amundsen</span> / Layer 7
											</li>
											<li>
												<span class="date">8.20PM: </span>
												Panel: The API Economy<br>
											<span style="line-height: 25px;display: block;">
												<span class="colr">Mike Maney</span> / Mike Maney Digital (Moderator) <br>
												<span class="colr">Adam d'Augelli</span> / True Ventures<br>
												<span class="colr">Ethan Kurzweil</span> / Bessemer Ventures  <br>
												<span class="colr">Alex Williams</span> / TechCrunch <br>
												<span class="colr">Adam Duvander</span> / SendGrid
											</span>
											</li>
											<li>
												<span class="date">9PM</span>
												Cocktails, Mixing & Mingling
											</li>
										</ul>
</div>										
									</div><!-- fin pad -->
<div id="day2">
									<h2 class="rub ico_program">SATURDAY: THE API JOURNEY</h2>

									<div class="pad">
										<ul style="margin-bottom:0">
											<li>
													<span class="date">8AM</span>
													Doors open and breakfast
												</li>
												
 											<li>
												<span class="date">8.30AM: </span>
												6 Reasons Why APIs are Reshaping your Business. <span class="colr">Guillaume Charny-Brunet</span> / faberNovel
											</li>
 											<li>
												<span class="date">9AM: </span>
												Scaling API Re-Use, Security & Integration Across the Multi-Property Consortia. <span class="colr">Blake Dournaee</span> / Intel
											</li>
											<li>
												<span class="date">9.25AM: </span>
												API Frenzy: The Implications and Planning for a Successful API Strategy. <span class="colr">Sachin Agarwal</span> / SOA Software
											</li>
											<li>
												<span class="date">9.50AM: </span>
												Techniques for Scaling the Netflix API. <span class="colr">Daniel Jacobson</span> / Netflix
											</li>
											<li>
												<span class="date">10.30AM: </span>
												API Economy and Crucial APIs to Know About. <span class="colr">Evgeny Popov</span> / Apiphany
											</li>
											<li>
												<span class="date">10.55PM: </span>
												APIs for Mobile Strategies. <span class="colr">Ed Anuff</span> / Apigee
											</li>
											
											<li>
												<span class="date">11.20PM: </span>
												As Software Eats the World, APIs Eat Software. <span class="colr">Steven Willmott</span> / 3scale
											</li>
											<li>
												<span class="date">11.45AM: </span>
												Panel: Big Companies' Challenges with APIs<br>
											<span style="line-height: 25px;display: block;">
<!-- 												<span class="colr">Scott Monson</span> / AT&T (Moderator) <br>
 -->											<span class="colr">Thomas Graasl</span> / SAP <br>
												<span class="colr">Sumit Sharma</span> / Mulesoft<br>
												<span class="colr">Robert Duffner</span> / Salesforce
											</span>
											</li> 
											<li>
												<span class="date">12.30PM: </span>
												<span class="colr">Lunch </span> at <a href="http://twitter.com/SoMaStrEatFood" target="_blank">SoMa StrEat Food Park</a>
											</li>
											<li>
												<span class="date">2PM: </span>
												API Design: The Good, The Bad and the Ugly. <span class="colr">Neil Mansilla</span> / Mashery
											</li>
											<li>
												<span class="date">2.25PM: </span>
												One Million APIs: Looking at the Future of App Data. <span class="colr">Simon Murtha-Smith</span> / Singly
											</li>
											<li>
												<span class="date">2.50PM: </span>
												Panel: API Design<br>
											<span style="line-height: 25px;display: block;">
												<span class="colr">Jeremiah Lee</span> / Fitbit (Moderator) <br>
												<span class="colr">Jakub Nesetril</span> / apiary.io<br>
												<span class="colr">Kevin Nelson</span> / Rdio <br>
												<span class="colr">Tony Tam</span> / Reverb
											</span>
											</li>
											<li>
												<span class="date">3.35PM: </span>
												Machine Learning APIs. <span class="colr">Chris Ismael</span> / Mashape
											</li>
											<li>
												<span class="date">4PM: </span>
												Shipping Code in a Service-Oriented World. <span class="colr">Solomon Hykes</span> / dotCloud
											</li>
											<li>
												<span class="date">4.25PM: </span>
												From Web APIs to Cross-Device Web Sites. <span class="colr">Jerome Louvel</span> / APISpark
											</li>
											<li>
												<span class="date">5.05PM: </span>
												Your API Consumers Aren't Who You Think They Are. <span class="colr">Bryan Helmig</span> / Zapier
											</li>
											<li>
												<span class="date">5.30PM: </span>
												Building APIs for Developers. <span class="colr">Amber Feng</span> / Stripe
											</li>
											<li>
												<span class="date">5.50PM: </span>
												Panel: Developer/API Evangelism<br>
											<span style="line-height: 25px;display: block;">
												<span class="colr">Mehdi Medjaoui</span> / Webshell (Moderator) <br>
												<span class="colr">Mike Swift</span> / SendGrid <br>
												<span class="colr">Gregory Gopman</span> / AngelHack <br>
												<span class="colr">Kin Lane</span> / APIevangelist<br>
											</span>
											</li>
											
										


										
										<!-- </ul>		
										<br>							
										<div id="arrow">
											<p>API Planning, Design, <br>and Management</p>
										</div>
										<div id="arrow">
											<p>API Strategy  and  Promotion</p>
										</div>
										<div id="arrow">
											<p>API Integration & distribution</p>
										</div>
										<div class="clear"></div>
										
										<div style="display:block">
										<p class="timing" style="margin-left:30px">
										9AM-12.30PM
										</p>
										<p class="timing" style="margin-left:140px">
										2-4PM
										</p>
										<p class="timing" style="margin-left:175px">
										4.15-6.15PM
										</p>
										</div>
										<div class="clear"></div>
										

										<ul class="theme" style="margin-left:-30px">
											<li>API Security and Scalability</li>
											<li>API Design and Patterns</li>
											<li>API Management</li>
											
										</ul>

										<ul class="theme">
											
											<li>API Strategy and Policy</li>
											<li>API as a Product</li>
											<li>API Promotion</li>
											
										</ul>

										<ul class="theme" style="margin-right:0">
											<li>Platforms and API distribution</li>
											<li>API Automation</li>
											<li>Future of interfaces</li>
											
										</ul>										
										<div class="clear"></div>
										
										<ul> -->
												<li style="margin-bottom:15px">
													<span class="date">6.30PM</span>
													Cocktails, Mixing & Mingling
												</li>
										</ul>
<a target='_blank' href="http://sf-apidays-program.eventbrite.com" class="register button btn btn-large btn-info" style="margin-left:100px">REGISTER FOR CONFERENCE</a>

</div>
</div><!-- fin pad -->

<div id="day3">
									<h2 class="rub ico_program">SUNDAY: THE API HACKDAY</h2>

									<div class="pad" style="margin-bottom:20px">
										<ul>
												<li>
													<span class="date">8.30AM</span>
													Opening doors
												</li>					
												<li>
													<span class="date">9.30-11AM</span>
													API pitches
												</li>
												<li>
													<span class="date">11AM-6PM</span>
													Hacking (with food)
												</li>
												<li>
													<span class="date">6PM-8PM</span>
													Presentations, Judging & Awards
												</li>
										</ul>
										
<a target='_blank' href="http://apihackdaysf2013-program.eventbrite.com/" class="register button btn btn-large btn-info" style="margin-left:100px">REGISTER FOR HACKDAY</a>
</div>
</div><!-- fin pad -->




</div><!-- fin main -->

<div class="clear"></div>
</div><!-- fin inside -->
</section><!-- fin section -->
<?php } ?>



<section class="section partners" id="partners">
	<div class="inside fil">
		<div class="pleft">
			<img src="images/ico_section_partners.png" alt="Partners"  class="ico"/>
		</div><!-- fin pleft -->
		<div class="main">

			<div class="clear"></div>
			<h2 class="rub ico_business_partners">BUSINESS SPONSORS</h2>


			<div class="logo"><a target='_blank' href="http://www.layer7tech.com/" title="Layer 7"><img src="images/sponsors/logo_layer7.png" alt="Layer 7" /></a></div>
			<div class="int">
				<h5>Layer 7 Technologies </h5>
				<p>Layer 7 Technologies helps enterprises and services providers manage APIs in the cloud; across the Internet; and out to mobile devices. The Layer 7 API Management suite provides the ability to address API security, version management, SLA enforcement, visibility and developer on-boarding requirements, in a fully-integrated suite. Enterprises and service providers can expose APIs externally or internally in a secure, reliable and manageable way, turning the enterprise into and extensible platform.  Deliverable on-premise or from the Cloud, the Layer 7 API Management suite is certified to support the most rigorous security needs including PCI, FIPS, STIG and OAuth.
					<br>To learn more visit <a target='_blank' href="http://www.layer7tech.com/">http://www.layer7tech.com/</a>.
				</div>
				<div class="clear"></div>

					<br/><br/>

					<div class="logo"><a target='_blank' href="http://www.3scale.net/" title="3Scale"><img src="images/sponsors/logo_3scale.png" alt="3Scale" /></a></div>
					<div class="int">
						<h5>3scale</h5>
						<p>
							Founded in 2007, 3scale provides a Plug & Play SaaS API Management solution enabling enabling Tech Startups, SMBs, and Fortune500 to securely distribute, operate, manage and monetize their APIs to 3rd parties (e.g. Internal or external developers, business partners, etc).<br>
							API providers benefit with 3scale of a unique suite of services available out-of-the-box that gives them unprecedented control, and visibility on the packaging, distribution and use of their API.<br>
							3scale currently powers 200 APIs and has over 85,000 developers writing applications using these APIs.<br>

							For more information visit <a href="http://www.3scale.net" target="_blank">www.3scale.net</a>.
							</p>
						</div>
						<div class="clear"></div>
						<br/><br/>	
						<div class="logo"><a target='_blank' href="http://cloudsecurity.intel.com/api-management" title="Intel"><img src="images/sponsors/logo_Intel.png" alt="Intel" /></a></div>
						<div class="int">
							<h5>Intel</h5>
							<p>
								Intel & McAfee deliver a portfolio of enterprise-class data center software products designed to help Enterprise and Service Providers seamlessly expose apps and data across on-prem, cloud, and mobile environments. At each layer of the data center software stack Intel has leveraged platform optimizations such as hardware assisted security, big data analytics, and an open infrastructure APIs  to transform how services & sensitive data are exposed as APIs to dev communities, mobile, & cloud. Expressway offers McAfee aligned security, patented Informatica powered integration, API Management powered by Mashery, and the only no app impact data tokenization solution for PCI & PII scope reduction.<br>
								To learn more visit <a href="http://cloudsecurity.intel.com/api-management" target="_blank">API Management</a> Solutions at Intel’s <a href="http://cloudsecurity.intel.com/" target="_blank">cloud security</a> web sites.</p>
							</div>
							<div class="clear"></div>
							<br><br>						

						<div class="logo"><a target='_blank' href="http://www.soa.com/" title="SOA"><img src="images/sponsors/logo_SOA.png" alt="SOA" /></a></div>
							<div class="int">
								<h5>SOA software </h5>
								 <!-- <p>SOA Software is a leading provider of API Management that help businesses plan, build, secure, monitor and share APIs, both within and outside the enterprise. The world’s largest companies including Bank of America, Pfizer, Michelin, BMW, Credit Suisse and Verizon use SOA Software products to harness the power of their technology and transform their businesses. Our products are available in the cloud or on-premise. To learn more, please visit our web site and follow us on social networks: <a target='_blank' href="http://www.soa.com" title="SOA"><span class="colr">http://www.soa.com</span></p> -->
								 <p>SOA Software's powers the API Economy with products that enable our customers to plan, build, run and share APIs through comprehensive cloud and on-premise solutions for API lifecycle, security, management and developer engagement.  SOA Software API Management and Security solutions includes:<br>
Community Manager™ - a sophisticated developer community product to help enterprises attract, manage, and support the developers that build Apps using their APIs<br> 
API Gateway™ - a high-performance API proxy server providing security, monitoring, mediation and other runtime capabilities<br>
Lifecycle Manager™ - provides API and App lifecycle management capabilities to help customers build APIs that meet current and future business requirements<br>
To learn more, come visit us at <a target='_blank' href="http://www.soa.com" title="SOA"><span class="colr">http://www.soa.com</span></a>.</p>
							</div>
							
						<div class="clear"></div>
				<br><br>
				<div class="logo"><a target='_blank' href="http://www.mulesoft.com/" title="MuleSoft"><img src="images/sponsors/logo_MuleSoft.png" alt="MuleSoft" /></a></div>
							<div class="int">
								<h5>MuleSoft</h5>
								 <p>MuleSoft, founded in 2006, provides the leading integration platform for connecting SaaS and enterprise applications in the cloud and on-premise. Believing that connecting applications shouldn’t be hard, MuleSoft lets organizations harness the power of their applications through integration. MuleSoft’s Anypoint™ technology eliminates costly, time-intensive point-to-point integration, enabling business agility. Delivered as a packaged integration experience, CloudHub™ and Mule ESB™ are built on open source technology for the most reliable integration without vendor lock-in. Most recently MuleSoft launched APIhub, the world's leading API publishing platform, and now also operates Programmable Web.</p>
							</div>
							
						<div class="clear"></div>
				<br><br>
					<div class="logo"><a target='_blank' href="http://apispark.com/" title="APISpark"><img src="images/sponsors/logo_APISpark.png" alt="APISpark" /></a></div>
						<div class="int">
							<h5>APISpark</h5>
							<p>
								APISpark is the first all-in-one web API platform, taking care of the creation, hosting and management of web APIs from a simple web browser. It comes with a built-in data store and can connect to external ones.<br>
								For more information, visit <a href="http://apispark.com/" target="_blank">APISpark.com</a>.</p>
							</div>
							<div class="clear"></div>
							<br><br>
				<div class="logo"><a target='_blank' href="http://apiphany.com/" title="Apiphany"><img src="images/sponsors/logo_apiphany.png" alt="Apiphany" /></a></div>
						<div class="int">
							<h5>Apiphany</h5>
							<p>
								Apiphany is one of the leading providers of API management and delivery solutions enabling organizations to successfully leverage the roaring mobile, social and app economy. With its flexible cloud-based architecture, Apiphany empowers companies to securely develop new revenue channels, gain insight in their business, and spur innovation at a fast pace while keeping cost and usage under control.<br>
								For more information, visit <a href="http://apiphany.com/" target="_blank">Apiphany.com</a>.</p>
							</div>
							<div class="clear"></div>
							<br><br>
				



						<!--<li><a href="http://www.salesforces.com/" title="salesForces" target="_blank"><img src="images/sponsors/logo_salesForces.png" alt="salesForces" /></a></li>-->


						<?php if (1) {?>
							<h2 class="rub ico_media">MEDIA PARTNERS</h2>

							<ul>								
								<li><a href="http://www.programmableweb.com" title="ProgrammableWeb" target="_blank"><img src="images/sponsors/logo_programmableWeb.png" alt="ProgrammableWeb" /></a></li>
								<li><a href="http://apievangelist.com/" title="API evangelist" target="_blank"><img src="images/sponsors/logo_APIEevangelist.png" alt="APIEvangelist" /></a></li>	
								<li><a href="http://api500.com/" title="API500" target="_blank"><img src="images/api500.png" alt="API500" /></a></li>
								<li><a href="http://apieconomist.com/" title="The API Economist" target="_blank"><img src="images/apieconomist.png" alt="The API Economist" /></a></li>
							</ul>

							</ul>
							<?php } ?>
							<div class="clear"></div>

						</div><!-- fin main -->
						<div class="clear"></div>
					</div><!-- fin inside -->
				</section><!-- fin partenrs -->


				<section class="section organizers" id="organizers">
					<div class="inside fil">
						<div class="pleft">
							<img src="images/ico_section_organizers.png" alt="Organizers"  class="ico"/>
						</div><!-- fin pleft -->
						<div class="main">
							<ul>
								<li>
									<div class="logo_organizers"><img src="images/logo_fabernovel.png" alt="faberNovel" /></div>
									<h3><a target='_blank' href="http://fabernovel.com/en/"><span class="colr">faberNovel</span></a> helps large organizations think and act like startups.</h3>
									<p>faberNovel helps organizations think and act like startups.  <br>
									Based in Paris, San Francisco, Moscow and New York City, faberNovel works with clients and partners all over the world helping them to discover new business models, learn a startup approach to growth, prototype new ideas, and connect with the startup ecosystem for success.  For more information visit <a target='_blank' href="http://www.fabernovel.com/en/"><span class="colr">fabernovel.com</span></a></p>
								</li>
								<li class="last">
									<div class="logo_organizers"><img src="images/logo_webshell.png" alt="Webshell" /></div>
									<h3>Webshell.io is an API of APIs, via a platform enabling developers to discover, integrate, combine, maintain and share APIs easily. </h3>
									<p>
									Webshell is an API of APIs. The <a target='_blank' href="http://webshell.io"><span class="colr">Webshell</span></a> platform enables developers to easily authenticate, integrate, script and maintain 3rd party web APIs into their web or mobile applications, via a consistent interface to more than 50 providers. Webshell is also highly involved in the API community with the <a target='_blank' href="http://apijoy.tumblr.com/"><span class="colr">{"apis":"the joy"} Tumblr</span></a>, <a target='_blank' href="http://api500.com/"><span class="colr">The API rating agency blog</span></a> and <a target='_blank' href="http://apidays.io/"><span class="colr">apidays.io</span></a> conferences.</p>
								</li>
								<li style="margin-top: 40px">
									<div class="logo_organizers"><img src="images/logo_parisoma.jpg" alt="PARISOMA" /></div>
									<h3><a target='_blank' href="http://www.parisoma.com/"><span class="colr">PARISOMA</span></a> is an open incubator.</h3>
									<p>PARISOMA is located in the heart of San Francisco’s SOMA neighborhood. We open source entrepreneurship through mentorship, education and events. Over the past 3 years we’ve helped over 250 startups to move from concept to launch. For more information visit <a target='_blank' href="http://www.parisoma.com/"><span class="colr">parisoma.com</span></a></p>
								</li>
							</ul>

							<div class="clear"></div>
														<p style="margin-left:-4px;margin-top: 30px"><span class="colr">APIdays San Francisco</span> is one of 3 world-wide conferences. See the other two: <a href="http://mediterranea.apidays.io" target="_blank">Mediterranea</a> and <a href="http://apidays.io" target="_blank">Paris</a>.</p>


														<div style="float:left;margin-right:25px;margin-top:25px;width:375px;margin-left:-4px;">
															<p style="margin-bottom:5px">Check out this short video of the Dec. 2012 Paris edition of the APIdays Conference:</p>
															<iframe width="341" height="291" src="http://www.youtube.com/embed/nf7-pFyKhiw" frameborder="0" allowfullscreen></iframe>
														</div>

														<div style="float:left;margin-top:25px;width:375px">
															<p style="margin-bottom:5px">And here's a study we published on "6 Reasons Why APIs are Reshaping Your Business"</p>
															<iframe src="http://www.slideshare.net/slideshow/embed_code/15453043?rel=0" width="342" height="291" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC;border-width:1px 1px 0;margin-bottom:5px" allowfullscreen webkitallowfullscreen mozallowfullscreen> </iframe>
														</div>
						</div><!-- fin main -->
						<div class="clear"></div>
					</div><!-- fin inside -->
				</section>


				<section class="section pratical" id="pratical">
					<div class="inside fil">
						<div class="pleft">
							<img src="images/ico_section_pratical.png" alt="Pratical"  class="ico"/>
						</div><!-- fin pleft -->
						<div class="main">
							<h2 class="rub ico_when">when and where ?</h2>

							<div class="address">
								<h5>June 21, 22 & 23 2013<br />-<br />
									PARISOMA <br>169 11th Street <br>San Francisco, CA 94103</h5>
									<p></p>
								</div><!-- fin adress -->
								<div class="anyQ">
									<h5>Any questions?</h5>
									<p>Please feel free to contact us</p>
									<a href="mailto:sf@apidays.io" title="sf@apidays.io" target="_blank"><span>sf@apidays.io</span></a>
								</div><!-- fin anyQ -->

								<div class="clear"></div>
							</div><!-- fin main -->
							<div class="clear"></div>

							<div id="gmaps">
							</div>

							<?php if (0): ?>
								<div class="main">
									<h2 class="rub ico_howto">How to get there?</h2>

									<ul>
										<li>
											<span class="type">Metro</span>
											<span class="ligne">Line 7 : Porte d'Italie</span>
										</li>
										<li>
											<span class="type">Bus</span>
											<span class="ligne">Lines 47, 125, 131, 185 : Roger Salengro<br />
												Line 186 : Pierre Brossolette</span>
											</li>
											<li>
												<span class="type">Tram</span>
												<span class="ligne">Line 3 : Porte d’Italie</span>
											</li>
											<li>
												<span class="type">Car</span>
												<span class="ligne">Beltway : Exit Porte d'Italie</span>
											</li>
											<li>
												<span class="type">Orly airport</span>
												<span class="ligne">Direct bus connexion to Porte de Choisy, bus 183</span>
											</li>
										</ul>

										<div class="clear"></div>
									</div><!-- fin main -->
								<?php endif; ?>

								<div class="clear"></div>
							</div><!-- fin inside -->

						</section><!-- fin section -->

					</div><!-- fin main_container-->


					<footer class="footer">
						<div class="footerT">
							<div class="inside">

								<a target='_blank' href="http://sf-apidays-details.eventbrite.com" alt="Register" class="button register"><span>Register</span></a>



								<div class="clear"></div>
							</div><!-- fin inside -->
						</div><!-- fin footerT -->

						<div id="fonz">
							<p>
								<img id="fonz-01-img" src="images/fonz/fonz_01.png">
								<img id="fonz-02-img" src="images/fonz/fonz_02.png">
								<img id="fonz-03-img" src="images/fonz/fonz_03.png">
								<img id="fonz-04-img" src="images/fonz/fonz_04.png">
							</p>
						</div>

						<div class="mentions">WE ARE LOOKING FORWARD TO MEETING YOU ! &nbsp;&nbsp;&nbsp;<span>APIdays is an event brought to you by fabernovel &amp; webshell</span></div>
					</footer><!-- fin footer -->

				</div><!-- fin wrapper -->

				<div class="iconMove">
					<img src="images/AD_icon0.png" alt="icon" id="icon0" /> 
					<img src="images/AD_icon1.png" alt="icon" id="icon1" /> 
					<img src="images/AD_icon2.png" alt="icon" id="icon2" /> 
					<img src="images/AD_icon3.png" alt="icon" id="icon3" /> 
					<img src="images/AD_icon4.png" alt="icon" id="icon4" /> 
					<img src="images/AD_icon5.png" alt="icon" id="icon5" /> 
					<img src="images/AD_icon6.png" alt="icon" id="icon6" /> 
					<img src="images/AD_icon7.png" alt="icon" id="icon7" /> 

					<img src="images/AD_icon0.png" alt="icon" id="icon8" /> 
					<img src="images/AD_icon1.png" alt="icon" id="icon9" /> 
					<img src="images/AD_icon2.png" alt="icon" id="icon10" /> 
					<img src="images/AD_icon3.png" alt="icon" id="icon11" /> 
					<img src="images/AD_icon4.png" alt="icon" id="icon12" /> 
					<img src="images/AD_icon5.png" alt="icon" id="icon13" /> 
					<img src="images/AD_icon6.png" alt="icon" id="icon14" /> 
					<img src="images/AD_icon7.png" alt="icon" id="icon15" />
				</div><!-- fin inconMove -->


				<script src="js/jquery.js"></script>
				<script src="js/jquery/jquery.animate-colors-min.js"></script>

				<script src="js/jquery/jquery.scrollTo.js"></script>
				<script src="js/jquery/jquery.nav.js"></script>
				<!-- BG JS -->
				<script src="js/lib/paper.min.js" type="text/javascript" id="paperJs"></script>
				<script src="js/lib/bg.min.js" type="text/paperscript" canvas="draw" id="bgJs"></script>
				<script src="js/app.js"></script>
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=223599037652849";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
					</script>

					<script>
					  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

					  ga('create', 'UA-35699861-2', 'apidays.io');
					  ga('send', 'pageview');

					</script>
					</body>
					</html>
