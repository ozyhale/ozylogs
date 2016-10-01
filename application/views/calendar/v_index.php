<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-calendar/css/calendar.min.css'); ?>">
<script src="<?php echo base_url('assets/underscore/underscore-min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-calendar/js/calendar.js'); ?>"></script>

<div class="row">
    <div class="col-sm-12">
        <hr />
        <h3 id="title"></h3>
        <hr />
    </div>
</div>

<div class="row">
    <div class="col-sm-2">
        <select id="month_year_filter_selections" class="form-control">
            <?php foreach($month_year_filter_selections_w_date as $value2): ?>
            <option value="<?php echo $value2["date"]; ?>">
                <?php echo $value2["month_year"]; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-sm-10">
        
        <div class="btn-group">
            <button class="btn btn-primary" data-calendar-nav="prev">&lt;&lt; Prev</button>
            <button class="btn" data-calendar-nav="today">Today</button>
            <button class="btn btn-primary" data-calendar-nav="next">Next &gt;&gt;</button>
        </div>
        
        <div class="btn-group">
            <button class="btn btn-warning bc-view" data-calendar-view="year">Year</button>
            <button class="btn btn-warning bc-view" data-calendar-view="month">Month</button>
            <button class="btn btn-warning bc-view" data-calendar-view="week">Week</button>
            <button class="btn btn-warning bc-view" data-calendar-view="day">Day</button>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-sm-12">
        <div id="calendar"></div>
    </div>
</div>

<script type="text/javascript">
    
    var calendar;
    var tmpl_path = "<?php echo base_url('assets/bootstrap-calendar/tmpls'); ?>/";
    var events_source = "<?php echo site_url('calendar/ajaxfetchevents'); ?>";
    
    $(document).ready(function (){
        calendar = $("#calendar").calendar({
            tmpl_path: tmpl_path,
            events_source: events_source,
            day: $("#month_year_filter_selections").val(),
            format12: true
        });
        
        $("#title").text(calendar.getTitle());
    });
    
    $("#month_year_filter_selections").change(function (){
        calendar.setOptions({
            day: $(this).val()
        });

        calendar.view("month");

        $("#title").text(calendar.getTitle());
    });

    $('.btn-group button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
            $("#title").text(calendar.getTitle());
        });
    });

    $('.btn-group .bc-view[data-calendar-view]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.view($this.data('calendar-view'));
            $("#title").text(calendar.getTitle());
        });
    });
</script>