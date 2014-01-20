<?php
$active = '';
if ($site->published) {
    $from = strtotime(date('Y-m-d', $site->published));
} else {
    $from = strtotime('-7 days');
    $active = 'last-week';
}
$this->widget('Filter', array(
    'from' => $from,
    'to' => strtotime('today'),
    'active' => $active,
));
?>
<div class="row">
    <div class="span12">

        <?php if ($site->getTitle() != $site->url) { ?>
            <h1>
                <a target="_blank" href="<?php echo $site->getUrl(); ?>"><?php echo $site->getTitle(); ?></a>
            </h1>
            <h5>
                <a target="_blank" href="<?php echo $site->getUrl(); ?>"><?php echo $site->url; ?></a>
            </h5>
        <?php } else { ?>
            <h3>
                <a target="_blank" href="<?php echo $site->getUrl(); ?>"><?php echo $site->getTitle(); ?></a>
            </h3>
        <?php } ?>
        <?php if ($site->published) { ?>
            <h5>
                <?php echo Yii::t('app', 'Published'); ?> <?php echo Timeago::timeagoOrUnknown($site->published); ?>
            </h5>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="span3" data-toggle="tooltip" title="<?php echo Yii::t('app', 'Facebook shares, LinkedIn shares and tweets'); ?>">
        <div class="metric-label"><i class="icon-large icon-share-alt"></i><?php echo Yii::t('app', 'Total Shares'); ?></div>
        <div id="current-shares-total" class="metric"></div>
        <div class="small-chart" id="shares-total"></div>
    </div>
    <div class="span3">
        <div class="metric-label"><i class="icon-large icon-linkedin"></i><?php echo Yii::t('app', 'LinkedIn Shares'); ?></div>
        <div id="current-linkedin-shares" class="metric"></div>
        <div class="small-chart" id="linkedin-shares"></div>
    </div>
    <div class="span3">
        <div class="metric-label"><a target="_blank" href="https://twitter.com/search?q=<?php echo urlencode($site->url); ?>&f=realtime"><i class="icon-large icon-twitter"></i><?php echo Yii::t('app', 'Tweets'); ?></a></div>
        <div id="current-twitter-tweets" class="metric"></div>
        <div class="small-chart" id="twitter-tweets"></div>
    </div>
    <div class="span3" data-toggle="tooltip" title="<?php echo Yii::t('app', 'The number of Facebook shares, LinkedIn shares and tweets in an hour.'); ?>">
        <div class="metric-label"><i class="icon-large icon-time"></i><?php echo Yii::t('app', 'Shares Total'); ?></div>
        <div id="current-shares-per-hour" class="metric"></div>
        <div class="small-chart" id="shares-per-hour"></div>
    </div>

    <div class="span3" data-toggle="tooltip" title="<?php echo Yii::t('app', 'The total of Facebook shares, comments and likes'); ?>">
        <div class="metric-label"><i class="icon-large icon-facebook"></i><?php echo Yii::t('app', 'Facebook Total'); ?></div>
        <div id="current-facebook-total" class="metric"></div>
        <div class="small-chart" id="facebook-total"></div>
    </div>
    <div class="span3" data-toggle="tooltip" title="<?php echo Yii::t('app', 'This metric does not match with the numbers of like button. Like button includes comments and likes.'); ?>">
        <div class="metric-label"><i class="icon-large icon-share"></i><?php echo Yii::t('app', 'Facebook Shares'); ?></div>
        <div id="current-facebook-shares" class="metric"></div>
        <div class="small-chart" id="facebook-shares"></div>
    </div>
    <div class="span3" data-toggle="tooltip" title="<?php echo Yii::t('app', 'The number of Facebook comments given on the shares and likes linking to this page.'); ?>">
        <div class="metric-label"><i class="icon-large icon-comment"></i><?php echo Yii::t('app', 'Facebook Comments'); ?></div>
        <div id="current-facebook-comments" class="metric"></div>
        <div class="small-chart" id="facebook-comments"></div>
    </div>
    <div class="span3" data-toggle="tooltip" title="<?php echo Yii::t('app', 'The number of Facebook likes given on the shares linking to this page.'); ?>">
        <div class="metric-label"><i class="icon-large icon-thumbs-up"></i><?php echo Yii::t('app', 'Facebook Likes'); ?></div>
        <div id="current-facebook-likes" class="metric"></div>
        <div class="small-chart" id="facebook-likes"></div>
    </div>



</div>
<?php if (strpos($site->url, 'yle.fi') !== false) { ?>
    <div class="row">
        <div class="span6" id="page-views">
            <div class="metric-label"><i class="icon-large icon-refresh"></i><?php echo Yii::t('app', 'Page Views'); ?></div>
            <div class="metric">&nbsp;</div>
            <div class="big-chart">
            </div>
        </div>
        <div class="span6" id="entry-type">
            <div class="metric-label"><i class="icon-large icon-road"></i><?php echo Yii::t('app', 'Traffic Sources'); ?></div>
            <div class="inline-metric">
                <div class="metric" data-toggle="tooltip" title="<?php echo Yii::t('app', 'Internal Link'); ?>" id="total-entry-direct-entry">&nbsp;</div>
                <div class="metric" data-toggle="tooltip" title="<?php echo Yii::t('app', 'External Link'); ?>" id="total-entry-external-referrer" >&nbsp;</div>
                <div class="metric" data-toggle="tooltip" title="<?php echo Yii::t('app', 'Search Engine'); ?>" id="total-entry-search-engine" >&nbsp;</div>
            </div>
            <div class="big-chart" >         
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span6" id="referrers"  data-toggle="tooltip" title="<?php echo Yii::t('app', 'Websites that link directly to the page.'); ?>">
            <div class="metric-label"><i class="icon-large icon-share"></i>Linkittävät sivustot</div>
            <div class="big-chart">
            </div>
        </div>
        <div class="span6" id="search-terms" data-toggle="tooltip" title="<?php echo Yii::t('app', 'Search terms used to find this page from search engines.'); ?>">
            <div class="metric-label"><i class="icon-large icon-search"></i>Hakulauseet</div>
            <div class="big-chart" >         
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    var responses = 0;
    var totalTraffic = null;
    var searchTraffic = null;
    var referralTraffic = null;

    Highcharts.setOptions({
        global: {
            useUTC: false
        },
        lang: {
            calendar: ['<?php echo Yii::t('calendar', 'January'); ?>' ,'<?php echo Yii::t('calendar', 'February'); ?>', '<?php echo Yii::t('calendar', 'March'); ?>', '<?php echo Yii::t('calendar', 'April'); ?>', '<?php echo Yii::t('calendar', 'May'); ?>', '<?php echo Yii::t('calendar', 'June'); ?>', '<?php echo Yii::t('calendar', 'July'); ?>', '<?php echo Yii::t('calendar', 'August'); ?>', '<?php echo Yii::t('calendar', 'September'); ?>', '<?php echo Yii::t('calendar', 'October'); ?>', '<?php echo Yii::t('calendar', 'November'); ?>', '<?php echo Yii::t('calendar', 'December'); ?>'],
            weekdays: ['<?php echo Yii::t('calendar', 'Sunday'); ?>', '<?php echo Yii::t('calendar', 'Monday'); ?>', '<?php echo Yii::t('calendar', 'Tuesday'); ?>', '<?php echo Yii::t('calendar', 'Wednesday'); ?>', '<?php echo Yii::t('calendar', 'Thursday'); ?>', '<?php echo Yii::t('calendar', 'Friday'); ?>', '<?php echo Yii::t('calendar', 'Saturday'); ?>'],
            shortMonths: ['<?php echo Yii::t('calendar', 'Jan'); ?>', '<?php echo Yii::t('calendar', 'Feb'); ?>', '<?php echo Yii::t('calendar', 'Mar'); ?>', '<?php echo Yii::t('calendar', 'Apr'); ?>', '<?php echo Yii::t('calendar', 'May'); ?>', '<?php echo Yii::t('calendar', 'Jun'); ?>', '<?php echo Yii::t('calendar', 'Jul'); ?>', '<?php echo Yii::t('calendar', 'Aug'); ?>', '<?php echo Yii::t('calendar', 'Sep'); ?>', '<?php echo Yii::t('calendar', 'Oct'); ?>', '<?php echo Yii::t('calendar', 'Nov'); ?>', '<?php echo Yii::t('calendar', 'Dec'); ?>'],
            thousandsSep: " ",
            decimalPoint: ','
        }
    });

    $(function() {
        loadData();
    });

    var loadData = function loadData() {
        $('.big-chart').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
        $('.small-chart').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
        $('.metric').html('');
        loadSocial();
<?php if (strpos($site->url, 'yle.fi') !== false) { ?>
            loadPageViews();
            loadReferrers();
            loadSearchTerms();
            loadEntryType();
<?php } ?>
    }

    setInterval(loadData, 1000 * 60 * 5);

    function loadSocial() {
        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('api/social') ?>',
            data: {
                url: '<?php echo $site->getUrl(); ?>',
                from: $('#from').val(),
                to: $('#to').val()
            },
            success: function(data) {
                loadLine($('#facebook-comments'), socialDataToSeries(data.facebook.comments.series, '<?php echo Yii::t('app', 'Facebook Comments'); ?>'));
                $('#current-facebook-comments').html(formatNumber(data.facebook.comments.current));
                loadLine($('#facebook-likes'), socialDataToSeries(data.facebook.likes.series, '<?php echo Yii::t('app', 'Facebook Likes'); ?>'));
                $('#current-facebook-likes').html(formatNumber(data.facebook.likes.current));
                loadLine($('#facebook-shares'), socialDataToSeries(data.facebook.shares.series, '<?php echo Yii::t('app', 'Facebook Shares'); ?>'));
                $('#current-facebook-shares').html(formatNumber(data.facebook.shares.current));
                loadLine($('#linkedin-shares'), socialDataToSeries(data.linkedin.shares.series, '<?php echo Yii::t('app', 'LinkedIn Shares'); ?>'));
                $('#current-linkedin-shares').html(formatNumber(data.linkedin.shares.current));
                loadLine($('#twitter-tweets'), socialDataToSeries(data.twitter.tweets.series, '<?php echo Yii::t('app', 'Tweets'); ?>'));
                $('#current-twitter-tweets').html(formatNumber(data.twitter.tweets.current));
                loadLine($('#shares-per-hour'), socialDataToSeries(data.shares_per_hour.series, '<?php echo Yii::t('app', 'Shares Per Hour'); ?>'));
                $('#current-shares-per-hour').html(formatNumber(data.shares_per_hour.current));
                loadLine($('#shares-total'), socialDataToSeries(data.shares_total.series, '<?php echo Yii::t('app', 'Shares Total'); ?>'));
                $('#current-shares-total').html(formatNumber(data.shares_total.current));
                loadLine($('#facebook-total'), socialDataToSeries(data.facebook.total.series, '<?php echo Yii::t('app', 'Facebook Total'); ?>'));
                $('#current-facebook-total').html(formatNumber(data.facebook.total.current));
            }
        });
    }

    function socialDataToSeries(data, title) {
        var series = new Array();
        var serie = {name: title, data: new Array()};
        $(data).each(function(index, element) {
            serie.data.push(new Array(element.timestamp * 1000, element.value));
        });
        series.push(serie);
        return series;
    }

    function loadPageViews() {
        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('api/digitalanalytix') ?>',
            data: {
                reportId: 11678,
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                'parameters[ns_jspageurl]': '<?php echo $site->getUrl(); ?>',
            },
            success: function(response) {
                totalTraffic = response;
                responses++;
                drawEntryTypes();

                if (typeof(response.reportitems) === 'undefined') {
                    $('#page-views').hide();
                } else {
                    var serieNames = new Array('<?php echo Yii::t('app', 'Page Views'); ?>');
                    loadLine($('#page-views .big-chart'), digitalAnalytixDataToTimeSeries(response, 'Page views', null, serieNames));
                    $('#page-views .metric').html(formatNumber(response.reportitems.reportitem[0].statistics.total.c[2]));
                }
            }
        });
    }


    function loadEntryType() {
        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('api/digitalanalytix') ?>',
            data: {
                reportId: 11692,
                eventFilterId: 864,
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                'parameters[ns_jspageurl]': '<?php echo $site->getUrl(); ?>',
            },
            success: function(response) {
                searchTraffic = response;
                responses++;
                drawEntryTypes();
            }
        });

        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('api/digitalanalytix') ?>',
            data: {
                reportId: 11692,
                eventFilterId: 866,
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                'parameters[ns_jspageurl]': '<?php echo $site->getUrl(); ?>',
            },
            success: function(response) {
                referralTraffic = response;
                responses++;
                drawEntryTypes();
            }
        });
    }

    function drawEntryTypes() {
        if (responses == 3) {
            var internalTrafficTotal = totalTraffic.reportitems.reportitem[0].statistics.total.c[2];
            if (typeof(totalTraffic) === 'undefined') {
                $('#entry-type').hide();
            } else {
                var serieNames = new Array('<?php echo Yii::t('app', 'Internal Link'); ?>');
                series = digitalAnalytixDataToTimeSeries(totalTraffic, 'Page views', null, serieNames);
                if (typeof(searchTraffic.reportitems) !== 'undefined') {
                    var serieNames = new Array('Hakukone');
                    searchSeries = digitalAnalytixDataToTimeSeries(searchTraffic, 'Page views', 'Entry type', serieNames);
                    series[2] = searchSeries[0];
                    $('#total-entry-search-engine').html(formatNumber(searchTraffic.reportitems.reportitem[0].statistics.total.c[3]));
                    $(series[0].data).each(function(totalIndex, totalElement) {
                        $(series[2].data).each(function(subIndex, subElement) {
                            if (subElement[0] == totalElement[0]) {
                                series[0].data[totalIndex][1] -= subElement[1];
                                internalTrafficTotal -= subElement[1];
                            }
                        });
                    });
                }
                if (typeof(referralTraffic.reportitems) !== 'undefined') {
                    var serieNames = new Array('<?php echo Yii::t('app', 'External Link'); ?>', '<?php echo Yii::t('app', 'Search Engine'); ?>');
                    referralSeries = digitalAnalytixDataToTimeSeries(referralTraffic, 'Page views', 'Entry type', serieNames);
                    series[1] = referralSeries[0];
                    $('#total-entry-external-referrer').html(formatNumber(referralTraffic.reportitems.reportitem[0].statistics.total.c[3]));
                    $(series[0].data).each(function(totalIndex, totalElement) {
                        $(series[1].data).each(function(subIndex, subElement) {
                            if (subElement[0] == totalElement[0]) {
                                series[0].data[totalIndex][1] -= subElement[1];
                                internalTrafficTotal -= subElement[1];
                            }
                        });
                    });
                }
                $('#total-entry-direct-entry').html(formatNumber(internalTrafficTotal));
                loadLine($('#entry-type .big-chart'), series);
            }
            responses = 0;
        }
    }

    function loadReferrers() {
        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('api/digitalanalytix') ?>',
            data: {
                reportId: 11682,
                visitFilterId: 865,
                eventFilterId: 866,
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                'parameters[ns_jspageurl]': '<?php echo $site->getUrl(); ?>',
            },
            success: function(data) {
                if (typeof(data.reportitems) === 'undefined') {
                    $('#referrers').hide();
                } else {
                    var data = digitalAnalytixDataToSeries(data.reportitems.reportitem[0].rows.r, '<?php echo Yii::t('app', 'Page Views'); ?>');
                    loadBar($('#referrers .big-chart'), data.series, data.categories);
                }
            }
        });
    }

    function loadSearchTerms() {
        $.ajax({
            dataType: "json",
            url: '<?php echo $this->createUrl('api/digitalanalytix') ?>',
            data: {
                reportId: 11683,
                    eventFilterId: 864,
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                'parameters[ns_jspageurl]': '<?php echo $site->getUrl(); ?>',
            },
            success: function(data) {
                if (typeof(data.reportitems) === 'undefined') {
                    $('#search-terms').hide();
                } else {
                    var data = digitalAnalytixDataToSeries(data.reportitems.reportitem[0].rows.r, '<?php echo Yii::t('app', 'Page Views'); ?>');
                    loadBar($('#search-terms .big-chart'), data.series, data.categories);
                }
            }
        });
    }

    function Comparator(a, b) {
        if (a[0] < b[0])
            return -1;
        if (a[0] > b[0])
            return 1;
        return 0;
    }

    function digitalAnalytixDataToTimeSeries(response, dataColumnName, seriesColumnName, serieNames) {
        var columns = response.reportitems.reportitem[0].columns.column;
        var rows = response.reportitems.reportitem[0].rows.r;
        var seriesColumnIndex = null;
        var dataColumnIndex = null;

        $(columns).each(function(index, element) {
            if (element.ctitle === seriesColumnName) {
                seriesColumnIndex = index;
            }
            if (element.ctitle === dataColumnName) {
                dataColumnIndex = index;
            }
        });
        var series = new Array();
        var serieIndices = new Array();
        var serieIndex = null;
        var sIndex = 0;
        $(rows).each(function(index, element) {
            if (element.c[seriesColumnIndex] != 'Total') {
                if (typeof(serieIndices[element.c[seriesColumnIndex]]) == 'undefined') {
                    serieIndices[element.c[seriesColumnIndex]] = sIndex;
                    serie = series[sIndex] = {name: serieNames[index], data: new Array()};
                    sIndex++;
                }
                else {
                    var serieIndex = serieIndices[element.c[seriesColumnIndex]];
                    serie = series[serieIndex];
                }
                if (element.c[1] != 'Total') {
                    var date = element.c[0].split("-");
                    date = date[1] + "/" + date[0] + "/" + date[2] + ' ' + element.c[1] + ':00';
                    serie.data.push(new Array(new Date(date).getTime(), element.c[dataColumnIndex]));
                }
            }
        });
        for (var i = 0; i < series.length; i++) {
            series[i].data = series[i].data.sort(Comparator);
        }
        return series;
    }

    function digitalAnalytixDataToSeries(data, title, limit) {
        if (typeof(limit) === 'undefined')
            limit = 20;
        var series = {name: title, data: new Array()};
        var categories = new Array();
        $(data).each(function(index, element) {
            if (element.c[0] != 'Total') {
                series.data.push(element.c[1]);
                categories.push(element.c[0]);
            }
        });
        series.data = series.data.slice(0, limit);
        categories = categories.slice(0, limit);
        return {'series': new Array(series), 'categories': categories};
    }

    function loadLine(element, series) {

        // Create the chart
        element.highcharts({
            chart: {
                type: 'area',
                backgroundColor: 'rgba(255, 255, 255, 0)'
            },
            'title': {
                text: false
            },
            xAxis: {
                type: 'datetime'
            },
            credits: {
                enabled: false
            },
            yAxis: {
                min: 0,
                title: ''
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    marker: {
                        enabled: false
                    },
                    fillOpacity: 0.1
                }
            },
            'series': series
        });
    }

    function loadBar(element, series, categories) {
        // Create the chart
        element.highcharts({
            chart: {
                type: 'bar',
                backgroundColor: 'rgba(255, 255, 255, 0)'
            },
            'title': {
                text: false
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: categories,
                tickmarkPlacement: 'on',
                lineWidth: 0,
                labels: {
                    formatter: function() {
                        return truncate(this.value, 21);
                    }
                }
            },
            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 0,
                title: ''
            },
            legend: {
                enabled: false
            },
            plotOptions: {
            },
            'series': series
        });
    }

</script>
