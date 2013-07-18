function convertData(data) {
  console.log(data);
  for (var i = 0; i < data.length; i++) {
   // console.log(data[i][1]);
    if (data[i][1] == null) {
      //console.log("null found");
      data[i][1] = 0.0; 
    } 
    else {
      //console.log("data found");
      data[i][1] = parseFloat(data[i][1]);
    }
  }
}

function processCheckC() {

  //console.log(categoriesData);
  //console.log(categories);
  var selectedData = new Array();
  var selectedDataLabels = new Array();

  for (var i=0; i<categories.length; i++) {
    if(document.getElementById(categories[i]).checked) {
      selectedData.push(categoriesData[i]);
      selectedDataLabels.push(categories[i]);
     // console.log(categories[i] + " added!");
    }
  }
  //console.log("end of addition: ");
  console.log(selectedData);

  drawCLine(selectedData, selectedDataLabels)
}

function processCheckO() {
  var selectedData = new Array();
  var selectedDataLabels = new Array();

  if(document.getElementById("check_Ex").checked) {
    selectedData.push(expendituresO);
    selectedDataLabels.push("Expenditures");
  }
  if(document.getElementById("check_In").checked) {
    selectedData.push(incomesO);
    selectedDataLabels.push("Incomes");
  }
  if(document.getElementById("check_Sav").checked) {
    selectedData.push(savingsO);
    selectedDataLabels.push("Savings");
  }
  //console.log(selectedData);
  //console.log(selectedDataLabels);
  drawOLine(selectedData, selectedDataLabels);
}

function drawCLine(data, labels){

  if(data == '') {
    document.getElementById("CatLineGraph").innerHTML="No data selected!";
  }

  else {
    $('#CatLineGraph').empty();
    var plot2 = $.jqplot('CatLineGraph', data, { 
      title:'Categories Over Time', 
      seriesDefaults: {
        showMarker:false
      }, 

      cursor: {
        show: true,
        tooltipLocation:'sw', 
        zoom:true
      }, 
      axesDefaults:{useSeriesColor: true}, 
      axes:{
        xaxis:{
          renderer: $.jqplot.DateAxisRenderer,
          min:'January 1, 2013 00:00:00', 
          tickInterval: '1 month', 
          tickOptions:{formatString:'%Y/%#m/%#d'}
        }, 
        yaxis:{}, 
      }, 
      legend: {
        show: true,
        labels: labels
      }
    });
  }
}

function drawOLine(data, labels){
  if(data == '') {
    document.getElementById("OvLineGraph").innerHTML="No data selected!";
  }
  else {
  $('#OvLineGraph').empty();
  var plot2 = $.jqplot('OvLineGraph', data, { 
    title:'Overview Over Time', 
    seriesDefaults: {
      showMarker:false
    }, 
    cursor: {
      show: true,
      tooltipLocation:'sw', 
      zoom:true
    }, 
    axesDefaults:{useSeriesColor: true}, 
    axes:{
      xaxis:{
        renderer: $.jqplot.DateAxisRenderer,
        min:'January 1, 2013 00:00:00', 
        tickInterval: '1 month', 
        tickOptions:{formatString:'%Y/%#m/%#d'}
      }, 
      yaxis:{},  
    }, 
    legend: {
          show: true,
          labels: labels
    }
  });
}
}