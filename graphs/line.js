function convertData(data) {
 // console.log(data.length);
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

function printData(categoriesData, emptyArr) {
  console.log(categoriesData);
}

function processCheckC(categoriesData, categories, emptyArr) {
 // console.log("empty array: ");
  console.log(emptyArr);
  console.log(categoriesData);
  console.log(categories);
  for (var i=0; i<categories.length; i++) {
    if(!document.getElementById(categories[i]).checked)
      console.log(categories[i] + " is not checked");
      categoriesData[i] = emptyArr;
  }
  console.log("end of convertion: ");
  console.log(categoriesData);
}

function processCheck(expenditures, incomes, savings, emptyArr) {
  if(!document.getElementById("check_Ex").checked)
    expenditures = emptyArr;
  if(!document.getElementById("check_In").checked)
    incomes = emptyArr;
  if(!document.getElementById("check_Sav").checked)
    savings = emptyArr;

  drawOLine(expenditures, incomes, savings);
}

function drawCLine(categoriesData, categories){

  NoOfCategories = categories.length;
  for(i=0; i<NoOfCategories; i++) {
    for(j=0; j<categories[i].length; j++) {
      if (categories[i][j][1] == null) {
        categories[i][j][1] = 0.0; 
      } 
      else {
        categories[i][j][1] = parseFloat(categories[i][j][1]);
      }
    }
  }
  //console.log(categories);
  $('#OvLineGraph').empty();
  var plot2 = $.jqplot('OvLineGraph', [categories, incomes, savings], { 
    title:'Test', 
    seriesDefaults: {
      showMarker:false
    }, 
    series:[
    {
      label: 'Expenditures'
    },
    {
      yaxis:'y2axis',
      label: 'Incomes'
    }, 
    {
      yaxis:'y3axis',
      label: 'Savings'
    }
    ], 
    cursor: {
      show: true,
      tooltipLocation:'sw', 
      zoom:true
    }, 
    axesDefaults:{useSeriesColor: true}, 
    axes:{
      xaxis:{
        renderer: $.jqplot.DateAxisRenderer,
        min:'March 1, 2013 00:00:00', 
        tickInterval: '1 month', 
        tickOptions:{formatString:'%Y/%#m/%#d'}
      }, 
      yaxis:{},  
      y2axis:{
        numberTicks:9, 
        tickOptions:{showGridline:false}
      }, 
      y3axis:{}
    }, 
    legend: {
          show: true
    }
  });
}

function drawOLine(expenditures, incomes, savings){

  length = expenditures.length;
  for(i=0; i<length; i++) {
    if (expenditures[i][1] == null) {
      expenditures[i][1] = 0.0; 
    } 
    else {
      expenditures[i][1] = parseFloat(expenditures[i][1]);
    }
    if (incomes[i][1] == null) {
      incomes[i][1] = 0.0; 
    }
    else {
      incomes[i][1] = parseFloat(incomes[i][1]);
    }
    if (savings[i][1] == null) {
      savings[i][1] = 0.0; 
    } 
    else {
      savings[i][1] = parseFloat(savings[i][1]);
    }
  }
  //console.log(expenditures);
  $('#OvLineGraph').empty();
  var plot2 = $.jqplot('OvLineGraph', [expenditures, incomes, savings], { 
    title:'Test', 
    seriesDefaults: {
      showMarker:false
    }, 
    series:[
    {
      label: 'Expenditures'
    },
    {
      yaxis:'y2axis',
      label: 'Incomes'
    }, 
    {
      yaxis:'y3axis',
      label: 'Savings'
    }
    ], 
    cursor: {
      show: true,
      tooltipLocation:'sw', 
      zoom:true
    }, 
    axesDefaults:{useSeriesColor: true}, 
    axes:{
      xaxis:{
        renderer: $.jqplot.DateAxisRenderer,
        min:'March 1, 2013 00:00:00', 
        tickInterval: '1 month', 
        tickOptions:{formatString:'%Y/%#m/%#d'}
      }, 
      yaxis:{},  
      y2axis:{
        numberTicks:9, 
        tickOptions:{showGridline:false}
      }, 
      y3axis:{}
    }, 
    legend: {
          show: true
    }
  });
}