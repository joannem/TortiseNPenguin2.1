function processSelect(option) {

  if(option == 1) {
    drawChart2(data);
  }
  else if(option == 2)
    drawChart2(data2);
  else if(option == 3)
    drawChart2(data3);
  else
    drawChart2(data4);
}


function processSelectAJAX(from, to) {
//console.log(from);
//console.log(to);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        var php_data = xmlhttp.responseText;
        //console.log(php_data);
        var js_data = $.parseJSON(php_data);
        //console.log(js_data);
        drawChart(js_data);
       //document.getElementById("txtHint").innerHTML=js_data;
     }
   }
   xmlhttp.open("GET","graphs/categories.php?from="+from+"&to="+to,true);
 //  console.log("just sent request!");
   xmlhttp.send();
}

function drawChart_O(data) {
  if(data == "") {
    console.log("no data!");
    //data.push((("No Data Found", 100)));
    var data = [[["No Data Found", 100]]]
  }

  for(i=0; i<data[0].length; i++) {
   data[0][i][1] = parseFloat(data[0][i][1]);
  }

  var options = {
    title: 'Overall Expenditures - By Category',
    seriesDefaults: {
      renderer: jQuery.jqplot.PieRenderer,
      rendererOptions : {
        showDataLabels: true,
        dataLabels: 'percent',
        sliceMargin: 5
      }
    },
    legend: { show:true, location: 'e' }
  };
   
  $.jqplot('OvPieChartDivId', data, options);
}
function drawChart(data) {
  if(data == "") {
    console.log("no data!");
    //data.push((("No Data Found", 100)));
    var data = [[["No Data Found", 100]]]
  }
//console.log("in drawChart()");
  for(i=0; i<data[0].length; i++) {
   data[0][i][1] = parseFloat(data[0][i][1]);
  }

  var options = {
    title: 'Expenditures - By Category',
    seriesDefaults: {
      renderer: jQuery.jqplot.PieRenderer,
      rendererOptions : {
        showDataLabels: true,
        dataLabels: 'percent',
        sliceMargin: 5
      }
    },
    legend: { show:true, location: 'e' }
  };
  $('#PieChartDivId').empty();
  $.jqplot('PieChartDivId', data, options);
}

