 <script src="/js/holder.js"></script>

<style>
.marketing .col-lg-4 {
margin-bottom: 20px;
text-align: center;
}
#industries{
	text-align:center;
	margin-bottom:20px;
	margin-top:20px; 
}
#industries a{
	margin-left:10px;
}

</style>

<body>
			<?php 
			include("../topBar.php"); 
			?>
		  <div class="container">
		    <h1>Feedback best practice</h1>
			<div id="industries">
				<a href="#retail">Retail</a>
				<a href="#events">Events</a>
				<a href="#performances">Performances</a>
				</div>
				
			 <div class="container marketing">
				
				<hr class="featurette-divider">
				<h1 id="retail">Retail</h1>
				<div class="row">
		        <div class="col-lg-4">
		          <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
		          <h2>Staff feedback</h2>
		          <p>Staff were : Very unhelpful, Somewhat Unhelpful, Neutral, Helpful, Very Helpful</p>
		          <p><a class="btn btn-default" href="http://www.doyouagree.co.uk/questionMaker/?qnType=singlechoice&qn=Staff were&opt1=Very unhelpful&opt2=Somewhat Unhelpful&opt3=Neutral&opt4=Helpful&opt5=Very Helpful" role="button" target="_blank">Use this</a></p>
		        </div><!-- /.col-lg-4 -->
		        <div class="col-lg-4">
		          <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
		          <h2>Facility rating</h2>
		          <p>Which of these did you use? Wifi, Coffee Bar, Sleep Pods, Charging points</p>
		          <p><a class="btn btn-default" href="http://www.doyouagree.co.uk/questionMaker/?qnType=multiplechoice&qn=Which of these did you use?&opt1=Wifi&opt2=Coffee Bar&opt3=Sleep Pods&opt4=Charging points" role="button" target="_blank">Use this</a></p>
		        </div><!-- /.col-lg-4 -->
		       
		</div><!-- /.row -->
		
		<hr class="featurette-divider">
		<h1 id="events">Events</h1>
		<div class="row">
			 <div class="col-lg-4">
		          <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
		          <h2>General Rating</h2>
		          <p>I enjoyed the event?</p>
		          <p><a class="btn btn-default" href="http://www.doyouagree.co.uk/questionMaker/?qnType=slider&qn=I enjoyed this event?" role="button" target="_blank">Use this</a></p>
		        </div><!-- /.col-lg-4 -->
				<div class="col-lg-4">
		          <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
		          <h2>Comments</h2>
		          <p>What did you think to the event?</p>
		          <p><a class="btn btn-default" href="http://www.doyouagree.co.uk/questionMaker/?qnType=comments&qn=What did you think to the event?" role="button" target="_blank">Use this</a></p>
		        </div><!-- /.col-lg-4 -->
		
		    </div><!-- /.row -->
				<hr class="featurette-divider">
				<h1 id="performances">Performance</h1>
				<div class="row">

						<div class="col-lg-4">
				          <img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
				          <h2>Comments</h2>
				          <p>What did you think of the Performance?</p>
				          <p><a class="btn btn-default" href="http://www.doyouagree.co.uk/questionMaker/?qnType=comments&qn=What did you think of the performance?" role="button" target="_blank">Use this</a></p>
				        </div><!-- /.col-lg-4 -->

				    </div><!-- /.row -->
		    </div>
		</div>

</body>
