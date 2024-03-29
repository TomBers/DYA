<?php

include("../topBar.php");

?>

<style>


a{
	color: #333;
	text-decoration: none;
}
.cntner{
	margin-top:75px;
	width: 100%;
	height: 100%;
	position: relative;
}
.clr{
	clear: both;
}
.cntner > hdr{
	padding: 20px 30px 20px 30px;
	margin: 0px 20px 10px 20px;
	position: relative;
	display: block;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
    text-align: center;
}
.cntner > hdr h1{
	position: relative;
	color: #498ea5;
	font-weight: 700;
	font-style: normal;
	font-size: 30px;
	padding: 0px 0px 5px 0px;
	text-shadow: 0px 1px 1px rgba(255,255,255,0.8);
}
.cntner > hdr h1 span{
	font-family: 'Alegreya SC', Georgia, serif;
	font-size: 20px;
	line-height: 20px;
	display: block;
	font-weight: 400;
	font-style: italic;
	color: #719dab;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.cntner > hdr h2{
	font-size: 16px;
	font-style: italic;
	color: #2d6277;
	text-shadow: 0px 1px 1px rgba(255,255,255,0.8);
}
/* Header Style */
.freshdesignweb-top{
	line-height: 24px;
	font-size: 11px;
	background: rgba(0, 0, 0, 0.05);
	text-transform: uppercase;
	z-index: 9999;
	position: relative;
	box-shadow: 1px 0px 2px rgba(0,0,0,0.2);
}
.freshdesignweb-top a{
	padding: 0px 10px;
	letter-spacing: 1px;
	color: #333;
	text-shadow: 0px 1px 1px #fff;
	display: block;
	float: left;
}
.freshdesignweb-top a:hover{
	background: #fff;
}
.freshdesignweb-top span.right{
	float: right;
}
.freshdesignweb-top span.right a{
	float: left;
	display: block;
}
.freshdesignweb-demos{
    text-align:center;
	display: block;
	line-height: 30px;
	padding: 20px 0px;
}
.freshdesignweb-demos a{
    display: inline-block;
	margin: 0px 4px;
	padding: 0px 4px;
	color: #fff;
	line-height: 20px;	
	font-style: italic;
	font-size: 13px;
	border-radius: 3px;
	background: rgba(41,77,95,0.1);
	-webkit-transition: all 0.2s linear;
	-moz-transition: all 0.2s linear;
	-o-transition: all 0.2s linear;
	-ms-transition: all 0.2s linear;
	transition: all 0.2s linear;
}
.freshdesignweb-demos a:hover{
	background: rgba(41,77,95,0.3);
}
.freshdesignweb-demos a.current,
.freshdesignweb-demos a.current:hover{
	background: rgba(41,77,95,0.3);
}

/* Slider
http://www.freshdesignweb.com/free-beautiful-css3-table-style.html
*/
#fdw-pricing-table {
		margin:0 auto;
		text-align: center;
		width: 928px; /* total computed width */
		zoom: 1;
	}

	#fdw-pricing-table:before, #fdw-pricing-table:after {
	  content: "";
	  display: table
	}

	#fdw-pricing-table:after {
	  clear: both
	}

	/* --------------- */	

	#fdw-pricing-table .plan {
		font: 13px 'Lucida Sans', 'trebuchet MS', Arial, Helvetica;     
		background: #fff;      
		border: 1px solid #ddd;
		color: #333;
		padding: 20px;
		width: 220px;
		float: left;
		_display: inline; /* IE6 double margin fix */
		position: relative;
		margin: 0 5px;
		-moz-box-shadow: 0 2px 2px -1px rgba(0,0,0,.3);
		-webkit-box-shadow: 0 2px 2px -1px rgba(0,0,0,.3);
		box-shadow: 0 2px 2px -1px rgba(0,0,0,.3);		
	}

	#fdw-pricing-table .plan:after {
	  z-index: -1; 
	  position: absolute; 
	  content: "";
	  bottom: 10px;
	  right: 4px;
	  width: 80%; 
	  top: 80%; 
	  -webkit-box-shadow: 0 12px 5px rgba(0, 0, 0, .3);   
	  -moz-box-shadow: 0 12px 5px rgba(0, 0, 0, .3);
	  box-shadow: 0 12px 5px rgba(0, 0, 0, .3);
	  -webkit-transform: rotate(3deg);    
	  -moz-transform: rotate(3deg);   
	  -o-transform: rotate(3deg);
	  -ms-transform: rotate(3deg);
	  transform: rotate(3deg);	
	}	
	
	#fdw-pricing-table .popular-plan {
		top: -20px;
		padding: 40px 20px;   
	}
	
	/* --------------- */	

	#fdw-pricing-table .hdr {
		position: relative;
		font-size: 20px;
		font-weight: normal;
		text-transform: uppercase;
		padding: 40px;
		margin: -20px -20px 20px -20px;
		border-bottom: 8px solid;
		background-color: #eee;
		background-image: -moz-linear-gradient(#fff,#eee);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));    
		background-image: -webkit-linear-gradient(#fff, #eee);
		background-image: -o-linear-gradient(#fff, #eee);
		background-image: -ms-linear-gradient(#fff, #eee);
		background-image: linear-gradient(#fff, #eee);
	}

	#fdw-pricing-table .hdr:after {
		position: absolute;
		bottom: -8px; left: 0;
		height: 3px; width: 100%;
		content: '';
		background-image: url(images/bar.png);
	}
	
	#fdw-pricing-table .popular-plan .hdr {
		margin-top: -40px;
		padding-top: 60px;		
	}

	#fdw-pricing-table .plan1 .hdr{
		border-bottom-color: #B3E03F;
	}

	#fdw-pricing-table .plan2 .hdr{
		border-bottom-color: #3AD5A0;
	}

	#fdw-pricing-table .plan3 .hdr{
		
		border-bottom-color: #7BD553;
	}

	#fdw-pricing-table .plan4 .hdr{
		border-bottom-color: #45D0DA;
	}			
	
	/* --------------- */

	#fdw-pricing-table .price{
		font-size: 45px;
	}

	#fdw-pricing-table .monthly{
		font-size: 13px;
		margin-bottom: 20px;
		text-transform: uppercase;
		color: #999;
	}

	/* --------------- */

	#fdw-pricing-table ul {
		margin: 20px 0;
		padding: 0;
		list-style: none;
	}

	#fdw-pricing-table li {
		padding: 10px 0;
	}
	
	/* --------------- */
		
	#fdw-pricing-table .signup {
		position: relative;
		padding: 10px 20px;
		color: #fff;
		font: bold 14px Arial, Helvetica;
		text-transform: uppercase;
		text-decoration: none;
		display: inline-block;       
		background-color: #72ce3f;
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;     
		text-shadow: 0 -1px 0 rgba(0,0,0,.15);
		opacity: .9;       
	}

	#fdw-pricing-table .signup:hover {
		opacity: 1;       
	}

	#fdw-pricing-table .signup:active {
		-moz-box-shadow: 0 2px 2px rgba(0,0,0,.3) inset;
		-webkit-box-shadow: 0 2px 2px rgba(0,0,0,.3) inset;
		box-shadow: 0 2px 2px rgba(0,0,0,.3) inset;       
	}			

	#fdw-pricing-table .plan1 .signup{
		background: #B3E03F;
	}

	#fdw-pricing-table .plan2 .signup{
		background: #7BD553;
	}

	#fdw-pricing-table .plan3 .signup{
		background: #3AD5A0;
	}

	#fdw-pricing-table .plan4 .signup{
		background: #45D0DA;
	}	
	
	/* end --------------- */
</style>
<body>
<div class="cntner">
     
     <!-- start hdr here-->
	<hdr>
<div id="fdw-pricing-table">
    <div class="plan plan1">
        <div class="hdr">Personal</div>
        <div class="price">£0</div>  
        <div class="monthly">forever</div>      
        <ul>
            <li><b>Unlimited</b> Questions</li>
            <li><b>Brand</b> all questions</li>
            <li><b>Analyse</b> results</li>
			<li><b>Download</b> your data</li>			
        </ul>
        <a class="signup" href="http://www.doyouagree.co.uk/login.php">Sign up</a>         
    </div>
 <div class="plan plan3">
        <div class="hdr">Event</div>
        <div class="price">£49</div>
        <div class="monthly">per event</div>
        <ul>
            <li><b>Custom</b> URL's</li>
            <li><b>Combine</b> quizzes/feedback</li>
            <li><b>Live</b> analytics dashboard</li>
			<li>E-mail<b> support</b> </li>			
        </ul>
        <a class="signup" href="http://www.doyouagree.co.uk/login.php">Sign up</a>        
    </div>
    <div class="plan plan2 popular-plan">
        <div class="hdr">Campaign</div>
        <div class="price">£150</div>
        <div class="monthly">per month</div>  
        <ul>
            <li><b>Fully</b> Branded</li>
            <li><b>Multiple</b> Polls</li>
            <li><b>Personal</b> Support</li>
			<li><b>Embed </b> in your site</li>			
        </ul>
        <a class="signup" href="mailto:tom@doyouagree.co.uk">Contact</a>            
    </div>
   
    <div class="plan plan4">
        <div class="hdr">Partnership</div>
        <div class="price">POR</div>
        <div class="monthly"></div>
        <ul>
            <li><b>Unlimited</b> questions and quizzes </li>
            <li><b>Connect</b> to all responders</li>
            <li><b>Detailed </b> analytics</li>
			<li><b>Full consultation</b> </li>			
        </ul>
        <a class="signup" href="mailto:tom@doyouagree.co.uk">Contact</a>        
    </div> 	
</div>
	</hdr><!-- end hdr -->
    
</div>
</body>

