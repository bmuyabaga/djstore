/* This script and many more are available free online at
The JavaScript Source!! http://www.javascriptsource.com
Created by: Jim Stiles | www.jdstiles.com */
function startCalcate(){
  interval = setInterval("calcate()",1);
}
function calcate(){


  six = document.autoSumForm.totalOutstanding.value;
  seven = document.autoSumForm.amountPaid.value; 
  eight = (six * 1) - (seven * 1);
  document.autoSumForm.balance.value = eight.toFixed(2);

  
}
function stopCalcate(){
  clearInterval(interval);
}
function myFunctiongood(){
	six = document.autoSumForm.totalOutstanding.value;
	document.autoSumForm.balance.value = six;
}
