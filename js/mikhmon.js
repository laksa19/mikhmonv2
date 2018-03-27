//enable disable input on change
function RequiredV(){
    var exp = document.getElementById('expmode').value;
    var val = document.getElementById('validity').style;
    var grp = document.getElementById('graceperiod').style;
    var vali = document.getElementById('validi');
    var grpi = document.getElementById('gracepi');
    if (exp === 'rem' || exp === 'remc') {
      val.display= 'table-row';
      vali.type = 'text';
      if (vali.value === "") {
        vali.value = "";
      }
      $("#validi").focus();
      grp.display = 'table-row';
      grpi.type = 'text';
      if (grpi.value === "") {
        grpi.value = "5m";
      }
    } else if (exp === 'ntf' || exp === 'ntfc') {
      val.display = 'table-row';
      vali.type = 'text';
      if (vali.value === "") {
        vali.value = "";
      }
      $("#validi").focus();
      grp.display = 'none';
      grpi.type = 'hidden';
    } else {
      val.display = 'none';
      grp.display = 'none';
      vali.type = 'hidden';
      grpi.type = 'hidden';
    }
}

//enable disable input on ready
$(document).ready(function(){
    var exp = document.getElementById('expmode').value;
    var val = document.getElementById('validity').style;
    var grp = document.getElementById('graceperiod').style;
    var vali = document.getElementById('validi');
    var grpi = document.getElementById('gracepi');
    if (exp === 'rem' || exp === 'remc') {
      val.display= 'table-row';
      vali.type = 'text';
      $("#validi").focus();
      grp.display = 'table-row';
      grpi.type = 'text';
    } else if (exp === 'ntf' || exp === 'ntfc') {
      val.display = 'table-row';
      vali.type = 'text';
      $("#validi").focus();
      grp.display = 'none';
      grpi.type = 'hidden';
    } else {
      val.display = 'none';
      grp.display = 'none';
      vali.type = 'hidden';
      grpi.type = 'hidden';
    }
});

// default user length
function defUserl(){
   var usr = document.getElementById('user').value;
  if(usr === 'up'){
     $('select[name=userl] option:first').html('4');
  }else if(usr === 'vc'){
    $('select[name=userl] option:first').html('8');
}}

// get valid $ price
function GetVP(){
  var prof = document.getElementById('uprof').value;
  var url = "./process/getvalidprice.php?name=";
  var getvalidprice = url+prof
  $("#GetValidPrice").load(getvalidprice);
}
  

//table filter
function fTable() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("filterTable");
  filter = input.value.toUpperCase();
  table = document.getElementById("tFilter");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function fTable1() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("filterTable1");
  filter = input.value.toUpperCase();
  table = document.getElementById("tFilter");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function fTable2() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("filterTable2");
  filter = input.value.toUpperCase();
  table = document.getElementById("tFilter");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[5];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

