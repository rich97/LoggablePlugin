<div style="width: 100%; margin: 5px;">
<ul style="width: 100%">
<li style="display: inline; width: 50%; float: left;"><?php echo $results['views']; ?> Page Views</li>
<li style="display: inline; width: 50%; float: left;"><?php echo $results['visits']; ?> Visits</li>
<?php if ($results['visits'] !== 0) { ?><li style="display: inline; width: 50%; float: left;"><?php echo number_format((float)$results['views']/(float)$results['visits'], 2); ?> Pages per visit</li>
<li style="display: inline; width: 50%; float: left;"><?php echo number_format(100 * (float)$results['bounces']/(float)$results['visits'], 2); ?> % Bounce Rate</li><?php } ?>
<li style="display: inline; width: 50%; float: left"><?php echo $results['unique']; ?> Unique Visitors</li>
<li style="display: inline; width: 50%; float: left"><?php echo $results['new']; ?> New Visitors</li>
</ul>
</div>
<div style="clear: both;"></div>
<div class="noshow">
<table id="main-results">
<tbody>
<?php
foreach($mainresults as $result) {
?>
<tr>
    <td><?php echo $result['pages']; ?></td>
    <td><?php echo $result['visits']; ?></td>
    <td><?php echo $result['returns']; ?></td>
    <td><?php echo ($result['visits'] - $result['returns']); ?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
<div id="main-graph" style="width: 100%; margin: 5px;">
</div>
<?php
echo $javascript->codeBlock("var chart1 = new Highcharts.Chart({
    chart: {
        renderTo: 'main-graph',
        defaultSeriesType: 'area',
        margin: [50, 50, 85, 50]
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Page Views and Visitors',
        style: {
            color: '#008fb1'
        }
    },
    xAxis: {
        categories: ['" . implode("', '", array_keys($mainresults)) . "'],
        labels: {
            rotation: -45,
            align: 'right'
        }
    },
    yAxis: {
        title: {
            style: {
                color: '#008fb1',
            },
            text: 'Number'
        }
    },
    tooltip: {
        formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
                this.y +' '+ this.x.toLowerCase();
        }
    },
    plotOptions: {
        area: {
            data: 'main-results',
            dataParser: function(data) {
                var table = document.getElementById(data),
                rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'),
                result = [], 
                column = { 'Page Loads': 0, 'Total Visits': 1, 'Returning Visits': 2, 'New Visits': 3 }[this.options.name];
                for (var i = 0; i < rows.length; i++) {                  
                    result.push(
                        parseInt(
                            rows[i].getElementsByTagName('td')[column].innerHTML
                        )
                    );
                }
                return result;
            }
        }
    },
   legend: {
      layout: 'horizontal',
      style: {
         left: '0px',
         bottom: '0px',
      }
   },
    series: [{
        name: 'Page Loads'
    }, {
        name: 'Total Visits'
    }, {
        name: 'Returning Visits'
    }, {
        name: 'New Visits'
    }]
});");
?>
<div id="browser-graph-wrap" style="width: 50%; float: left;">
    <div id="browser-graph" style="margin-left: 5px">
    </div>
</div>
<?php
$data = array();
foreach($browserresults as $result) {
    $data[] = "['" . $result[0]['browser'] . "', " . $result[0]['count'] . "]";
}
$data = implode(',', $data);
echo $javascript->codeBlock("var chart2 = new Highcharts.Chart({
    chart: {
        renderTo: 'browser-graph',
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Browser share',
        style: {
            color: '#008fb1'
        }
    },
    plotArea: {
        shadow: null,
        borderWidth: null,
        backgroundColor: null
    },
    tooltip: {
        formatter: function() {
            return '<b>'+ this.point.name +'</b>: '+ this.y;
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: false,
            }
        }
    },
    legend: {
        layout: 'horizontal',
        style: {
            left: '0px',
            bottom: '0px',
            right: '25px',
            top: '250px'
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [" . $data . "]
    }]
});");
?>
<div id="os-graph-wrap" style="width: 50%; float: left;">
    <div id="os-graph" style="margin-right: 5px">
    </div>
</div>
<?php
$data = array();
foreach($osresults as $result) {
    $data[] = "['" . $result[0]['system'] . "', " . $result[0]['count'] . "]";
}
$data = implode(',', $data);
echo $javascript->codeBlock("var chart3 = new Highcharts.Chart({
    chart: {
        renderTo: 'os-graph',
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Operating System share',
        style: {
            color: '#008fb1'
        }
    },
    plotArea: {
        shadow: null,
        borderWidth: null,
        backgroundColor: null
    },
    tooltip: {
        formatter: function() {
            return '<b>'+ this.point.name +'</b>: '+ this.y;
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: false,
            }
        }
    },
    legend: {
        layout: 'horizontal',
        style: {
            left: '25px',
            bottom: '0px',
            right: '0px',
            top: '250px'
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [" . $data . "]
    }]
});");
?>
<div style="clear: both;"></div>
<div style="width: 50%; float: left;">
<table>
<thead>
<tr>
<th>Referring URL</th>
<th>Count</th>
</tr>
</thead>
<tbody>
<?php foreach ($referrerresults as $result) { ?>
<tr>
<td><?php
if (substr($result['Referrer']['referrer'], 0, 7) === 'http://') {
    echo $html->link($result['Referrer']['referrer']);
} else {
    echo $result['Referrer']['referrer'];
}
?></td>
<td><?php echo $result[0]['count']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<div style="width: 50%; float: left;">
<table>
<thead>
<tr>
<th>Visited URL</th>
<th>Count</th>
</tr>
</thead>
<tbody>
<?php foreach ($urlresults as $result) { ?>
<tr>
<td><?php echo $html->link('http://' . $result[0]['url']); ?></td>
<td><?php echo $result[0]['count']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<div style="clear: both;"></div>
