	SearchDate.style.display="none";
	SearchStudent.style.display="none";
	Add.style.display="none";
	Remove.style.display="none";

	//////////////// BUTTON 1 \\\\\\\\\\\\\\\\\\\\\\\\\\
	var submitButton = document.getElementById("button1");
	button1.addEventListener("click",display1);
	var count1 = 0;
	function display1(){//the user can click to display and click again to not to display 
		button1.className = "active1";//keep the same color as when it wasnt hovered to give a sense that it hasn't been clicked 
		button2.className = "NoneActive2";//keep the same color as when it hovered to give a sense that it has been clicked 
		button3.className = "NoneActive3";
		button4.className = "NoneActive4";

		SearchDate.style.display="none";// hides all of the other functionality 
		SearchStudent.style.display="none";
		Add.style.display="block";//this is only going to show the user only thr functionality that they clicked on
		Remove.style.display="none";
	}

	//////////////// BUTTON 2 \\\\\\\\\\\\\\\\\\\\\\\\\\
	var submitButton = document.getElementById("button2");
	button2.addEventListener("click",display2);
	var count1 = 0;
	function display2(){//the user can click to display and click again to not to display 
		button1.className = "NoneActive1";//keep the same color as when it wasnt hovered to give a sense that it hasn't been clicked 
		button2.className = "active2";//keep the same color as when it hovered to give a sense that it has been clicked 
		button3.className = "NoneActive3";
		button4.className = "NoneActive4"; 

		SearchDate.style.display="none";// hides all of the other functionality 
		SearchStudent.style.display="none";
		Add.style.display="none";
		Remove.style.display="block";//this is only going to show the user only thr functionality that they clicked on

	}

	//////////////// BUTTON 3 \\\\\\\\\\\\\\\\\\\\\\\\\\
	var submitButton = document.getElementById("button3");
	button3.addEventListener("click",display3);
	var count1 = 0;
	function display3(){//the user can click to display and click again to not to display 
		button1.className = "NoneActive1";//keep the same color as when it wasnt hovered to give a sense that it hasn't been clicked 
		button2.className = "NoneActive2";
		button3.className = "active3";//keep the same color as when it hovered to give a sense that it has been clicked 
		button4.className = "NoneActive4";

		SearchDate.style.display="none";// hides all of the other functionality 
		SearchStudent.style.display="block";//this is only going to show the user only thr functionality that they clicked on
		Add.style.display="none";
		Remove.style.display="none";
	}

	//////////////// BUTTON 4 \\\\\\\\\\\\\\\\\\\\\\\\\\
	var submitButton = document.getElementById("button4");
	button4.addEventListener("click",display4);
	var count1 = 0;
	function display4(){//the user can click to display and click again to not to display 
		button1.className = "NoneActive1";//keep the same color as when it wasnt hovered to give a sense that it hasn't been clicked 
		button2.className = "NoneActive2";
		button3.className = "NoneActive3";
		button4.className = "active4"; //keep the same color as when it hovered to give a sense that it has been clicked 

		SearchDate.style.display="block"; //this is only going to show the user only thr functionality that they clicked on
		SearchStudent.style.display="none"; // hides all of the other functionality 
		Add.style.display="none";
		Remove.style.display="none";
	}

	//////////////////////// POP UP FOR MECHANISM THE GRAPH \\\\\\\\\\\\\\\\\\\\\\\\

	function toggle_visibility(id) {
			       var e = document.getElementById(id);
			       if(e.style.display == 'block')
			          e.style.display = 'none';
			       else
			          e.style.display = 'block';
	}	

/* this finction is taken from an online source, written by ashrash290, 
		website wer this piec of code has been taken: 
		https://github.com/ashrash290/mart/blob/master/index2.html */

