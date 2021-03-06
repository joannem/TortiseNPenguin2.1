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
function addstuff(stuff) {
  var add = "stuff added: "
  add += stuff;
  return add;
}

function processSelectAJAX(option) {
  if (option != "All") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        var php_arr = xmlhttp.responseText;
        php_arr = $.parseJSON(php_arr);
        for(i=0; i<5; i++) {
          php_arr[0][i][1] = parseFloat(php_arr[0][i][1]);
        }
        drawChart2(php_arr);
        //document.getElementById("txtHint").innerHTML=php_arr;
        console.log(php_arr);
     }
   }
   xmlhttp.open("GET","categories.php?from="+option,true);
   xmlhttp.send();

  } else {
    document.getElementById("txtHint").innerHTML="";
  }
}

function drawChart() {
 var slice_1 = ['Apples', 150];
 var slice_2 = ['Bananas', 50];
 var series = [slice_1, slice_2];
 var data = [series];
 
 var options = {
  title: 'Sales by Region-Chart1',
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

$.jqplot('chartDivId', data, options);
}

function drawChart2(data) {

  var options = {
    title: 'Sales by Region-Chart2',
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
   
  $.jqplot('chartDivId', data, options);
}

$(document).ready(function(){
  var goog = [["6/22/2009 16:00:00",425.32],
  ["6/8/2009 16:00:00",424.84],
  ["5/26/2009 16:00:00",417.23],
  ["5/11/2009 16:00:00",390],
  ["4/27/2009 16:00:00",393.69],
  ["4/13/2009 16:00:00",392.24],
  ["3/30/2009 16:00:00",369.78],
  ["3/16/2009 16:00:00",330.16],
  ["3/2/2009 16:00:00",308.57],
  ["2/17/2009 16:00:00",346.45],
  ["2/2/2009 16:00:00",371.28],
  ["1/20/2009 16:00:00",324.7],
  ["1/5/2009 16:00:00",315.07],
  ["12/22/2008 16:00:00",300.36],
  ["12/8/2008 16:00:00",315.76],
  ["11/24/2008 16:00:00",292.96],
  ["11/10/2008 16:00:00",310.02],
  ["10/27/2008 16:00:00",359.36],
  ["10/13/2008 16:00:00",372.54],
  ["9/29/2008 16:00:00",386.91],
  ["9/15/2008 16:00:00",449.15],
  ["9/2/2008 16:00:00",444.25],
  ["8/25/2008 16:00:00",463.29],
  ["8/11/2008 16:00:00",510.15],
  ["7/28/2008 16:00:00",467.86],
  ["7/14/2008 16:00:00",481.32],
  ["6/30/2008 16:00:00",537],
  ["6/16/2008 16:00:00",546.43],
  ["6/2/2008 16:00:00",567],
  ["5/19/2008 16:00:00",544.62],
  ["5/5/2008 16:00:00",573.2],
  ["4/21/2008 16:00:00",544.06],
  ["4/7/2008 16:00:00",457.45],
  ["3/24/2008 16:00:00",438.08],
  ["3/10/2008 16:00:00",437.92],
  ["2/25/2008 16:00:00",471.18],
  ["2/11/2008 16:00:00",529.64],
  ["1/28/2008 16:00:00",515.9],
  ["1/14/2008 16:00:00",600.25],
  ["12/31/2007 16:00:00",657],
  ["12/17/2007 16:00:00",696.69],
  ["12/3/2007 16:00:00",714.87],
  ["11/19/2007 16:00:00",676.7],
  ["11/5/2007 16:00:00",663.97],
  ["10/22/2007 16:00:00",674.6],
  ["10/8/2007 16:00:00",637.39],
  ["9/24/2007 16:00:00",567.27],
  ["9/10/2007 16:00:00",528.75],
  ["8/27/2007 16:00:00",515.25]];
  var plot1 = $.jqplot('chart1', [goog], { 
    title: 'Google, Inc.', 
    series: [{ 
      label: 'Google, Inc.', 
      neighborThreshold: -1 
    }], 
    axes: { 
      xaxis: { 
        renderer: $.jqplot.DateAxisRenderer,
        min:'August 1, 2007 16:00:00', 
        tickInterval: '4 months', 
        tickOptions:{formatString:'%Y/%#m/%#d'} 
      }, 
      yaxis: { 
        tickOptions:{formatString:'$%.2f'} 
      } 
    }, 
    cursor:{ 
      show: true,
      zoom:true, 
      showTooltip:false
    } 
  });

  $('.button-reset').click(function() { plot1.resetZoom() });
});