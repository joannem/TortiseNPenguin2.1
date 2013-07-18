function drawBar(data1, data2, div_id){
  var s1 = [data1];
  var s2 = [data2];
 /* console.log(s1);
  console.log(s2);
  console.log(div_id);*/
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
            showGridline: false
          }
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
    }
  });

}