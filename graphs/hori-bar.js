function drawBar(budgetAmt, amtSpent, amtLeft, div_id){
 // console.log(div_id + " " + amtLeft);
  if(amtLeft < 0) {
    //console.log(amtLeft);
    var s1 = [amtLeft*-1]; //negative amount left
    var s2 = [budgetAmt];
    var maxVal = amtSpent;
    var color = ["#ccc", "#4bb2c5"];
    var stringFormat = '$%#.2f';
  } else {
    var s1 = [amtSpent];
    var s2 = [amtLeft]; //positive amount left
    var maxVal = budgetAmt;
    var color = ["#EAA228","#eee"];
    var stringFormat = '$%#.2f';
  }

  $('#budBars').empty();
  budBars = $.jqplot(div_id, [s1, s2], {
    // Tell the plot to stack the bars.
    stackSeries: true,
    captureRightClick: true,
    seriesDefaults:{
      renderer:$.jqplot.BarRenderer,
      pointLabels: { 
        show: true, 
        location: 'e', 
        edgeTolerance: -15
      },
      // Rotate the bar shadow as if bar is lit from top right.
      shadowAngle: 135,
      // Here's where we tell the chart it is oriented horizontally.
      rendererOptions: {
        barDirection: 'horizontal',
        barMargin: 0,
        barWidth: 25
      }
    },
    axes: {
      xaxis: {
          showTicks: false,
          tickOptions:{
            showGridline: false,
            formatString: stringFormat
          },
          max: maxVal
      },
      yaxis: {
        showTicks: false,
        tickOptions:{
          showGridline: false
       }

      }
    },
    grid: {
      shadow:false,
      drawBorder:false,
    },
    seriesColors: color
  });

}