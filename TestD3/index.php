<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>D3 Test</title>
        <script type="text/javascript" src="d3.v3/d3.v3.js"></script>
        <style>
        div.bar {
            display: inline-block;
            width: 20px;
            height: 75px;   /* We'll override this later */
            margin-right: 2px;
            background-color: teal;
        }
        </style>
    </head>
    <body>
        <script type="text/javascript">
        d3.select("body").append("p").text("New Paragraph!");

        var dataset = [ 5, 10, 15, 20, 25 ];

        d3.select("body").selectAll("div")
        .data(dataset)
        .enter()
        .append("div")
        .attr("class", "bar")
        .style("height", function(d) {
            var barHeight = d * 5;
            return barHeight + "px";
        });
        
        </script>
        <div style="display: inline-block;
            width: 20px;
            height: 75px;
            background-color: teal;"></div>

        <div class="bar"></div>


    </body>
</html>